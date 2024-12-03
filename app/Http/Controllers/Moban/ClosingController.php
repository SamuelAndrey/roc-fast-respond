<?php

namespace App\Http\Controllers\Moban;

use App\Http\Controllers\Controller;
use App\Services\Moban\ClosingService;
use Illuminate\Http\RedirectResponse;
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


    public function pickup(Request $request): RedirectResponse
    {
        try {
            $data = $request->validate([
                'closing_id' => 'required|int'
            ]);

            $this->closingService->pickup($data);

            return back()->with('success', 'Request pickup successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function close(Request $request): RedirectResponse
    {
        try {
            $data = $request->validate([
                'closing_id' => 'required|int',
                'action' => ''
            ]);

            $this->closingService->close($data);

            return back()->with('success', 'Request pickup successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
