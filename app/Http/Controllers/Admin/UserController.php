<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserStoreRequest;
use App\Http\Requests\Admin\User\UserUpdateRequest;
use App\Models\User;
use App\Services\Admin\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use function Symfony\Component\String\u;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function listAgentPage(Request $request): View
    {
        $agents = User::query()
            ->where('role', '=', 'agent')
            ->get();

        return view('pages.admin.user.agent', ['agents' => $agents]);
    }

    public function listAdminPage(Request $request): View
    {
        $admins = User::query()
            ->where('role', '=', 'admin')
            ->get();

        return view('pages.admin.user.admin', ['admins' => $admins]);
    }

    public function store(UserStoreRequest $request): RedirectResponse
    {
        try {
            $request->validated();

            $this->userService->store($request);

            return back()->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update($userId, UserUpdateRequest $request): RedirectResponse
    {
        try {
            $request->validated();

            $this->userService->update($userId, $request);

            return back()->with('success', 'User updated successfully.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($userId): RedirectResponse
    {
        try {
            $this->userService->destroy($userId);

            return back()->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
