<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Services\Auth\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{

    private ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function profilePage(): View
    {
        return view('pages.auth.profile');
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        try {
            $user = auth()->user();

            $request->validated();

            $this->profileService->updatePassword($request, $user);

            return back()->with('success', 'Profile updated successfully.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
