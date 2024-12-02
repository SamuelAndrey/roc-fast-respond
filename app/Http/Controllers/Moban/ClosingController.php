<?php

namespace App\Http\Controllers\Moban;

use App\Http\Controllers\Controller;
use App\Services\Moban\ClosingService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use function Symfony\Component\Translation\t;

class ClosingController extends Controller
{

    private ClosingService $closingService;

    public function __construct(ClosingService $closingService)
    {
        $this->closingService = $closingService;
    }


    public function index(): View
    {
        $closings = $this->closingService->currentList();
        return view('pages.moban.closing.index', ['closings' => $closings]);
    }
}
