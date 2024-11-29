<?php

namespace App\Services\Api;

use App\Helpers\KeyPrompt;
use App\Helpers\SupportCommand;
use App\Models\Closing;
use Exception;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotTelegramService
{
    private int $chatId;
    private int $messageId;
    private string $message;
    private string $chatTitle;

    /**
     * @throws Exception
     */
    public function commandHandler($updates): void
    {
        $this->chatId = $updates->getChat()->getId();
        $this->messageId = $updates->getMessage()->getMessageId();
        $this->message = $updates->getMessage()->getText();
        $this->chatTitle = $updates->getChat()->getTitle();

        if (str_starts_with($this->message, '/moban')) {
            $this->handlePrompt();
        } else {
            $this->handleCommand();
        }
    }

    /**
     * @throws Exception
     */
    private function handlePrompt(): void
    {
        $lines = explode("\n", trim($this->message));
        if (!str_starts_with($lines[0], '/moban')) {
            return;
        }

        [$command, $action] = explode('#', $lines[0], 2);
        $action = rtrim($action, '#');

        $actionCategory = KeyPrompt::validate($action);

        if (!$actionCategory['status']) {
            $this->sendReply("Mohon maaf, perintah anda tidak terdaftar sebagai unbind atau closing.");
            return;
        }

        [$data, $approvalData, $rawData] = $this->parseMessageLines($lines, $action);

        $this->processPromptData([
            'action' => $action,
            'data' => $data,
            'approval_data' => $approvalData,
            'raw_data' => $rawData,
            'action_category' => $actionCategory['type']
        ]);
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

    private function processPromptData(array $params): void
    {
        try {
            $replyMessage = $this->processToDatabase($params);
            $this->sendReply($replyMessage);
        } catch (Exception $e) {
            $this->sendReply("Terjadi kesalahan: " . $e->getMessage());
        }
    }

    private function processToDatabase(array $params): string
    {
        $data = $this->generateRequest($params);
        $closing = Closing::query()->create($data);

        return <<<RESP
                Permintaan closing berhasil di proses.

                ~ Tercatat ~
                Kategori :  {$params['action_category']}
                No.Tiket :  $closing->ticket_id}
                RESP;
    }

    private function generateRequest(array $params): array
    {
        return [
            'chat_id' => $this->chatId,
            'message_id' => $this->messageId,
            'requester_identity' => $this->generateIdentity([
                'Nama' => $params['data']['nama'] ?? '(Kosong)',
                'NIK' => $params['data']['nik'] ?? '(Kosong)',
                'Unit' => $params['data']['unit'] ?? '(Kosong)'
            ]),
            'approval_identity' => $this->generateIdentity([
                'Nama Atasan' => $params['approval_data']['nama_atasan'] ?? '(Kosong)',
                'NIK Atasan' => $params['approval_data']['nik_atasan'] ?? '(Kosong)'
            ]),
            'ticket' => $params['data']['perihal'] ?? '(Kosong)',
            'reason' => $params['data']['alasan'] ?? '(Kosong)',
            'witel' => $params['data']['unit'] ?? '(Kosong)',
            'message' => $params['raw_data'],
            'category' => $params['action'],
            'group_name' => $this->chatTitle,
        ];
    }

    private function generateIdentity(array $fields): string
    {
        return implode("\n", array_map(fn($key, $value) => "$key: $value", array_keys($fields), $fields));
    }

    private function sendReply(string $text): void
    {
        Telegram::sendMessage([
            'chat_id' => $this->chatId,
            'text' => $text,
            'reply_to_message_id' => $this->messageId,
            'parse_mode' => 'HTML',
        ]);
    }

    private function formatKey(string $key): string
    {
        return strtolower(preg_replace('/\s+/', '_', trim($key)));
    }

    private function handleCommand(): void
    {
        $commands = SupportCommand::SUPPORT_MESSAGE;
        foreach ($commands as $command => $replyText) {
            if (str_starts_with($this->message, $command)) {
                $this->sendReply($replyText);
                return;
            }
        }

        $this->sendReply("Command tidak dikenali. Gunakan /help untuk melihat command yang tersedia.");
    }
}
