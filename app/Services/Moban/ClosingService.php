<?php

namespace App\Services\Moban;

use App\Models\Closing;
use Illuminate\Database\Eloquent\Collection;

class ClosingService
{
    public function currentList(): Collection|array
    {
        return Closing::query()
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
