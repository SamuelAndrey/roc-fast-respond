<?php

namespace App\Services\Moban;

use App\Http\Controllers\Moban\ClosingController;
use App\Models\Closing;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Telegram\Bot\Laravel\Facades\Telegram;

class ClosingService
{
    public function currentList(): LengthAwarePaginator
    {
        return Closing::query()
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    /**
     * @throws Exception
     */
    public function pickup($data): Model|Collection|Builder|array
    {
        $user = auth()->user();
        $closing = Closing::query()->find($data['closing_id']);

        if (!$closing) {
            throw new Exception("Request not found", 404);
        }

        if ($closing->solved_id || $closing->status != 0) {
            throw new Exception("Request already taken by other agent", 404);
        }

        $closing->solver_id = $user->id;
        $closing->solver = $user->name;
        $closing->status = 1;
        $closing->save();

        $message = <<<RESP
        ~ Permintaan Telah Diproses ~

        🔸 Agen: {$user->name}
        🔹 Status: Permintaan closing berhasil diambil alih.
        RESP;

        $this->sendReply($message, $closing);

        return $closing;
    }


    private function sendReply(string $text, $data): void
    {
        Telegram::sendMessage([
            'chat_id' => $data->chat_id,
            'text' => $text,
            'reply_to_message_id' => $data->message_id,
            'parse_mode' => 'HTML',
        ]);
    }
}
