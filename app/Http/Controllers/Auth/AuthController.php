<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{


    /**
     * Login page.
     *
     * @return View
     */
    public function loginPage(): View
    {
        return view('pages.auth.login');
    }


    /**
     * Authentication by form.
     *
     * @param AuthLoginRequest $request
     * @return RedirectResponse
     */
    public function authenticate(AuthLoginRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $remember = isset($validated['remember_me']);

        $user = User::where('email', '=', $validated['email_or_username'])
            ->orWhere('username',  '=', $validated['email_or_username'])
            ->first();

        if ($user && Hash::check($validated['password'], $user->password)) {

            if (!$user->is_active) {

                return back()->withErrors([
                    'error' => 'Account is deactivated.',
                ])->onlyInput('email_or_username');
            }

            Auth::login($user, $remember);

            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'error' => 'The provided credentials do not match our records.',
        ])->onlyInput('email_or_username');
    }


    public function redirectAuthGoogle()
    {

    }


    public function callbackAuthGoogle()
    {

    }


    /**
     * Logout statement.
     *
     * @param Request $request
     * @return Application|Redirector|RedirectResponse
     */
    public function logout(Request $request): Application | Redirector | RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('auth/login');
    }
}
