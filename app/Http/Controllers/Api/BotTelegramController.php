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
        $chat_id = $updates->getChat()->getId();
        $username = $updates->getChat()->getFirstName();
        $message = $updates->getMessage()->getText();

        error_log($message);

        if (strtolower($message) == 'halo') {
            return Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Halo ' . $username,
            ]);
        } else {
            return Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => $message,
            ]);
        }
    }
}
