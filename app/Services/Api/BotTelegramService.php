<?php

namespace App\Services\Api;

use App\Helpers\KeyPrompt;
use App\Helpers\SupportCommand;
use App\Models\Closing;
use Exception;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotTelegramService
{

    /**
     * @throws Exception
     */
    public function commandHandler($updates): void
    {
        $chatId = $updates->getChat()->getId();
        $messageId = $updates->getMessage()->getMessageId();
        $message = $updates->getMessage()->getText();
        $chatTitle = $updates->getChat()->getTitle();

        error_log($chatId);
        error_log($messageId);

        switch (true) {
            case str_starts_with($message, '/moban'):
                $this->handlePrompt($chatId, $messageId, $message, $chatTitle);
                break;

            default:
                $this->handleCommand($chatId, $messageId, $message);
        }
    }


    /**
     * @throws Exception
     */
    private function handlePrompt($chatId, $messageId, $message, $chatTitle): void
    {
        $lines = explode("\n", trim($message));
        if (!str_starts_with($lines[0], '/moban')) {
            return;
        }

        [$command, $action] = explode('#', $lines[0], 2);
        $action = rtrim($action, '#');

        $actionCategory = KeyPrompt::validate($action);

        if (!$actionCategory['status']) {
            $this->sendReply($chatId, $messageId, "Mohon maaf, perintah anda tidak terdaftar sebagai unbind atau closing.");
            return;
        }

        [$data, $approvalData, $rawData] = $this->parseMessageLines($lines, $action);

        $processParams = [
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'action' => $action,
            'data' => $data,
            'approval_data' => $approvalData,
            'raw_data' => $rawData,
            'chat_title' => $chatTitle,
            'action_category' => $actionCategory['type']
        ];

        $this->processPromptData($processParams);
    }


    private function parseMessageLines(array $lines, string $action): array
    {
        $data = [];
        $approvalData = [];
        $rawData = '';
        $isCapturingRaw = false;
        $isApprovalSection = false;
        $currentKey = null;

        foreach ($lines as $line) {
            $line = trim($line);

            if (empty($line)) {
                $rawData .= $isCapturingRaw ? "\n" : '';
                continue;
            }

            if (!$isCapturingRaw && str_contains($line, $action . '#')) {
                $isCapturingRaw = true;
                continue;
            }

            if (str_contains($line, '#approval')) {
                $isCapturingRaw = false;
                $isApprovalSection = true;
                continue;
            }

            if ($isCapturingRaw) {
                $rawData .= $line . "\n";
            }

            $this->parseKeyValuePair($line, $data, $approvalData, $isApprovalSection, $currentKey);
        }

        return [$data, $approvalData, $rawData];
    }


    private function parseKeyValuePair(string $line, array &$data, array &$approvalData, bool $isApprovalSection, ?string &$currentKey): void
    {
        if (str_contains($line, '=')) {
            [$key, $value] = explode('=', $line, 2);
            $formattedKey = $this->formatKey($key);

            if ($isApprovalSection) {
                $approvalData[$formattedKey] = trim($value);
            } else {
                $data[$formattedKey] = trim($value);
                $currentKey = $formattedKey;
            }
        } elseif ($currentKey && !$isApprovalSection) {
            $data[$currentKey] .= "\n" . $line;
        }
    }


    /**
     * @throws Exception
     */
    private function processPromptData($params): void
    {
        $replyMessage = $this->processToDatabase($params);
        $this->sendReply($params['chat_id'], $params['message_id'], $replyMessage);
    }


    /**
     * @param $params
     * @return string
     * @throws Exception
     */
    private function processToDatabase($params): string
    {

        $data = $this->generateRequest($params);
        $actionCategory = $params['action_category'];

        try {
            $closing = Closing::query()->create($data);
            return <<<RESP
                    Permintaan closing berhasil di proses.

                    ~ Tercatat ~
                    Kategori $actionCategory
                    No.Tiket $closing->ticket_id

                    RESP;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function generateRequest($params): array
    {
        $requester = $this->generateIdentity([
            'Nama' => $params['data']['nama'] ?? '(Kosong)',
            'NIK' => $params['data']['nik'] ?? '(Kosong)',
            'Unit' => $params['data']['unit'] ?? '(Kosong)'
        ]);

        $approval = $this->generateIdentity([
            'Nama Atasan' => $params['approval_data']['nama_atasan'] ?? '(Kosong)',
            'NIK Atasan' => $params['approval_data']['nik_atasan'] ?? '(Kosong)'
        ]);

        $ticket = $params['data']['perihal'] ?? '(Kosong)';
        $reason = $params['data']['alasan'] ?? '(Kosong)';

        return [
            'chat_id' => $params['chat_id'],
            'message_id' => $params['message_id'],
            'requester_identity' => $requester,
            'approval_identity' => $approval,
            'ticket' => $ticket,
            'reason' => $reason,
            'witel' => $data['unit'] ?? '(Kosong)',
            'message' => $params['raw_data'],
            'category' => $params['action'],
            'group_name' => $params['chat_title'],
        ];
    }


    private function generateIdentity(array $fields): string
    {
        return implode("\n", array_map(fn($key, $value) => "$key: $value", array_keys($fields), $fields));
    }


    private function sendReply($chatId, $messageId, $text): void
    {
        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => $text,
            'reply_to_message_id' => $messageId,
            'parse_mode' => 'HTML',
        ]);
    }


    private function formatKey(string $key): string
    {
        return strtolower(preg_replace('/\s+/', '_', trim($key)));
    }


    private function handleCommand($chatId, $messageId, $message): void
    {
        $commands = SupportCommand::SUPPORT_MESSAGE;
        foreach ($commands as $command => $replyText) {
            if (str_starts_with($message, $command)) {
                $this->sendReply($chatId, $messageId, $replyText);
                return;
            }
        }

        $this->sendReply($chatId, $messageId, "Command tidak dikenali. Gunakan /help untuk melihat command yang tersedia.");
    }


//    private function generateReplyMessage(string $command, string $action, array $data, array $approvalData, string $rawData): string
//    {
//        $requester = $this->generateIdentity([
//            'Nama' => $data['nama'] ?? '(Kosong)',
//            'NIK' => $data['nik'] ?? '(Kosong)',
//            'Unit' => $data['unit'] ?? '(Kosong)'
//        ]);
//
//        $approval = $this->generateIdentity([
//            'Nama Atasan' => $approvalData['nama_atasan'] ?? '(Kosong)',
//            'NIK Atasan' => $approvalData['nik_atasan'] ?? '(Kosong)'
//        ]);
//
//        $ticket = $data['perihal'] ?? '(Kosong)';
//        $reason = $data['alasan'] ?? '(Kosong)';
//
//        return <<<REPLY
//            Command: $command
//            Action: $action
//
//            Requester Identity:
//            $requester
//
//            Ticket: $ticket
//            Reason: $reason
//
//            Approval Identity:
//            $approval
//
//            Raw Data (antara tanda #):
//            $rawData
//            REPLY;
//    }

}
