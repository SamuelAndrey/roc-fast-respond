<?php

namespace App\Services\Api;

use App\KeyPrompt;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Message;

class BotTelegramService
{
    public function commandHandler($updates): void
    {
        $chatId = $updates->getChat()->getId();
        $messageId = $updates->getMessage()->getMessageId();
        $message = $updates->getMessage()->getText();

        switch (true) {
            case str_starts_with($message, '/moban'):
                $this->handlePrompt($chatId, $messageId, $message);
                break;

            case str_starts_with($message, '/help'):
                $this->sendReply($chatId, $messageId, "Daftar command yang tersedia:\n/moban#close_inet - Tangani tiket penutupan.");
                break;

            default:
                $this->sendReply($chatId, $messageId, "Command tidak dikenali. Gunakan /help untuk melihat command yang tersedia.");
        }
    }

    private function handlePrompt($chatId, $messageId, $message): void
    {
        $lines = explode("\n", trim($message));
        if (!str_starts_with($lines[0], '/moban')) {
            return;
        }

        [$command, $action] = explode('#', $lines[0], 2);
        $action = rtrim($action, '#');

        if (!KeyPrompt::validate($action)['status']) {
            $this->sendReply($chatId, $messageId, "Mohon maaf, perintah anda tidak terdaftar sebagai unbind atau closing.");
            return;
        }

        [$data, $approvalData, $rawData] = $this->parseMessageLines($lines, $action);

        $this->processPromptData($chatId, $messageId, $command, $action, $data, $approvalData, $rawData);
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

    private function processPromptData($chatId, $messageId, $command, $action, $data, $approvalData, $rawData): void
    {
        $replyMessage = $this->generateReplyMessage($command, $action, $data, $approvalData, $rawData);
        $this->sendReply($chatId, $messageId, $replyMessage);
    }

    private function generateReplyMessage(string $command, string $action, array $data, array $approvalData, string $rawData): string
    {
        $requester = $this->generateIdentity([
            'Nama' => $data['nama'] ?? '(Kosong)',
            'NIK' => $data['nik'] ?? '(Kosong)',
            'Unit' => $data['unit'] ?? '(Kosong)'
        ]);

        $approval = $this->generateIdentity([
            'Nama Atasan' => $approvalData['nama_atasan'] ?? '(Kosong)',
            'NIK Atasan' => $approvalData['nik_atasan'] ?? '(Kosong)'
        ]);

        $ticket = $data['perihal'] ?? '(Kosong)';
        $reason = $data['alasan'] ?? '(Kosong)';

        return <<<REPLY
            Command: $command
            Action: $action

            Requester Identity:
            $requester

            Ticket: $ticket
            Reason: $reason

            Approval Identity:
            $approval

            Raw Data (antara tanda #):
            $rawData
            REPLY;
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
}
