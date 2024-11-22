<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Message;

class BotTelegramController extends Controller
{
    public function setWebhook(): string
    {
        $response = Telegram::setWebhook(['url' => env('TELEGRAM_WEBHOOK_URL')]);

        if ($response) {
            return "Bot successfully activated with webhook";
        } else {
            return "Failed to activate the bot.";
        }
    }

    public function removeWebhook(): string
    {
        $response = Telegram::removeWebhook();

        if ($response) {
            return "Bot successfully activated with webhook";
        } else {
            return "Failed to activate the bot.";
        }
    }


    public function commandHandlerWebhook(): Message
    {
        $updates = Telegram::commandsHandler(true);

        $chatId = $updates->getChat()->getId();

        $firstName = $updates->getChat()->getFirstName();
        $lastName = $updates->getChat()->getLastName();
        $userName = $updates->getMessage()->from->username;
        $userId = $updates->getMessage()->from->id;

        $message = $updates->getMessage()->getText();

        error_log($message);

        if (strtolower($message) == 'halo') {
            return Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'Halo ' . $userName,
            ]);
        } else {
            // Convert updates object to pretty JSON
            $prettyResponse = json_encode( $updates, JSON_PRETTY_PRINT);

            return Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Berikut adalah data:\n\n" . "```json\n" . $prettyResponse . "\n```",
                'parse_mode' => 'Markdown'
            ]);
        }
    }
}
