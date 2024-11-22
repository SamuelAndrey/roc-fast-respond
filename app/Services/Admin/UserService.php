<?php

namespace App\Services\Admin;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserService
{

    /**
     * @param $request
     * @return mixed
     * @throws Exception
     */
    public function store($request): mixed
    {
        $validateUserData = User::query()
            ->where('username', '=', $request->username)
            ->orWhere('email', '=', $request->email)
            ->first();

        if ($validateUserData) {
            throw new Exception("Username or email already exist", 404);
        }

        return User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'is_active' => boolval($request->is_active),
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);
    }

    public function update($userId, $request)
    {
        $user = User::find($userId);
        if (!$user) {
            throw new Exception("User not found", 404);
        }

        $requestData = [
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => boolval($request->is_active),
        ];

        if (!empty($request->password)) {
            $requestData['password'] = Hash::make($request->password);
        }

        $user->update($requestData);

        return $user;
    }

    /**
     * @param $userId
     * @return void
     * @throws Exception
     */
    public function destroy($userId): void
    {
        $user = User::find($userId);
        if (!$user) {
            throw new Exception("User not found", 404);
        }

        $user->delete();
    }
}
