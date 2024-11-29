<?php

namespace App\Http\Controllers\Api;

use App\Helper\CUID;
use App\Http\Controllers\Controller;
use App\Services\Api\BotTelegramService;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Message;

class BotTelegramController extends Controller

{

    private BotTelegramService $botTelegramService;

    public function __construct(BotTelegramService $botTelegramService)
    {
        $this->botTelegramService = $botTelegramService;
    }

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
            return "Bot successfully deactivated with webhook";
        } else {
            return "Failed to deactivate the bot.";
        }
    }


    public function commandHandlerWebhook(): void
    {
        # $prettyResponse = json_encode($updates, JSON_PRETTY_PRINT);
        $updates = Telegram::commandsHandler(true);
        $this->botTelegramService->commandHandler($updates);
    }
}
