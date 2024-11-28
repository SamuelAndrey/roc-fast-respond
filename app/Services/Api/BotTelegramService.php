<?php

namespace App\Services\Api;

use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Message;

class BotTelegramService
{

    public function commandHandler($updates): void
    {
        $chatId = $updates->getChat()->getId();
        $firstName = $updates->getChat()->getFirstName();
        $lastName = $updates->getChat()->getLastName();
        $userName = $updates->getMessage()->from->username;
        $userId = $updates->getMessage()->from->id;
        $message = $updates->getMessage()->getText();
        $messageId = $updates->getMessage()->getMessageId();

        if (str_starts_with($message, '/moban')) {
            $this->promptHandler($chatId, $messageId, $message);
        } elseif (str_starts_with($message, '/help')) {
            $this->replyMessage($chatId, $messageId, "Daftar command yang tersedia:\n/moban#close_inet - Tangani tiket penutupan.");
        } else {
            $this->replyMessage($chatId, $messageId, "Command tidak dikenali. Gunakan /help untuk melihat command yang tersedia.");
        }

    }

    public function promptHandler($chatId, $messageId, $message): void
    {
        $lines = explode("\n", trim($message));

        if (!str_starts_with($lines[0], '/moban')) {
            return;
        }

        // Ambil command dan action, bersihkan simbol '#' berlebih
        [$command, $action] = explode('#', $lines[0], 2);
        $action = rtrim($action, '#'); // Hapus simbol '#' di akhir action

        $data = [];
        $approvalData = [];
        $rawData = '';
        $isCapturingRaw = false;
        $isApprovalSection = false;
        $currentKey = null;

        foreach ($lines as $line) {
            $line = trim($line);

            // Abaikan baris kosong
            if (empty($line)) {
                if ($isCapturingRaw) {
                    $rawData .= "\n"; // Tambahkan baris kosong ke raw data
                }
                continue;
            }

            // Mulai menangkap raw data setelah close_inet#
            if (!$isCapturingRaw && str_contains($line, 'close_inet#')) {
                $isCapturingRaw = true;
                continue; // Jangan proses baris ini
            }

            // Berhenti menangkap raw data setelah #approval
            if (str_contains($line, '#approval')) {
                $isCapturingRaw = false;
                $isApprovalSection = true; // Mulai bagian #approval
                continue;
            }

            // Tangkap raw data jika sedang dalam mode capturing
            if ($isCapturingRaw) {
                $rawData .= $line . "\n";
            }

            // Parsing data utama meskipun sedang menangkap raw data
            if (!$isApprovalSection && str_contains($line, '=')) {
                [$key, $value] = explode('=', $line, 2);
                $currentKey = trim(strtolower(str_replace(' ', '_', $key))); // Normalisasi key
                $data[$currentKey] = trim($value); // Simpan ke data utama
            } elseif (!$isApprovalSection && $currentKey) {
                // Jika tidak ada '=' dan ada key yang sedang diproses, tambahkan ke nilai key
                $data[$currentKey] .= "\n" . $line;
            }

            // Parsing data #approval
            if ($isApprovalSection && str_contains($line, '=')) {
                [$key, $value] = explode('=', $line, 2);
                $key = trim(strtolower(str_replace(' ', '_', $key))); // Normalisasi key
                $approvalData[$key] = trim($value);
            }
        }

        $this->processData($chatId, $messageId, $command, $action, $data, $approvalData, $rawData);
    }

    public function processData($chatId, $messageId, $command, $action, $data, $approvalData, $rawData): void
    {
        $requester_identity = [
            'nama' => $data['nama_'] ?? '(Kosong)',
            'nik' => $data['nik_'] ?? '(Kosong)',
            'unit' => $data['unit_'] ?? '(Kosong)',
        ];

        $ticket = $data['perihal_'] ?? '(Kosong)';
        $reason = $data['alasan_'] ?? '(Kosong)';

        $approval_identity = [
            'nama_atasan' => $approvalData['nama_atasan_'] ?? '(Kosong)',
            'nik_atasan' => $approvalData['nik_atasan_'] ?? '(Kosong)',
        ];

        // Debugging data hasil parsing
        error_log("Requester Identity: " . print_r($requester_identity, true));
        error_log("Ticket: " . $ticket);
        error_log("Reason: " . $reason);
        error_log("Approval Identity: " . print_r($approval_identity, true));

        // Susun pesan balasan
        $replyMessage = "Command: $command\n";
        $replyMessage .= "Action: $action\n";
        $replyMessage .= "Requester Identity:\n";
        foreach ($requester_identity as $key => $value) {
            $replyMessage .= ucfirst(str_replace('_', ' ', $key)) . ": " . $value . "\n";
        }

        $replyMessage .= "\nTicket: " . $ticket . "\n";
        $replyMessage .= "Reason: " . $reason . "\n";

        $replyMessage .= "\nApproval Identity:\n";
        foreach ($approval_identity as $key => $value) {
            $replyMessage .= ucfirst(str_replace('_', ' ', $key)) . ": " . $value . "\n";
        }

        $replyMessage .= "\nRaw Data (antara tanda #):\n" . $rawData;

        $this->replyMessage($chatId, $messageId, $replyMessage);
    }
    public function replyMessage($chatId, $messageId, $replyMessage)
    {
        try {
            return Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => $replyMessage,
                'reply_to_message_id' => $messageId,
                'parse_mode' => 'HTML',
            ]);
        } catch (\Exception $e) {
            error_log("Telegram API Error: " . $e->getMessage());
        }
    }

}

