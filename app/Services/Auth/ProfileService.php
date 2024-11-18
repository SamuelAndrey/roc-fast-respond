<?php

namespace App\Services\Auth;

use Exception;
use Illuminate\Support\Facades\Hash;

class ProfileService
{

    /**
     * @param $request
     * @param $user
     * @return mixed
     * @throws Exception
     */
    public function updatePassword($request, $user): mixed
    {
        if (!Hash::check($request['current_password'], $user->password)) {
            throw new Exception('Current password is incorrect.');
        }

        if ($request['new_password'] != $request['renew_password']) {
            throw new Exception('New password is not match.');
        }

        $user->update([
            'password' => Hash::make($request['renew_password'])
        ]);

        return $user;
    }
}
