<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class UsersService
{
    static function avatar($user)
    {
        if ( ! empty($user->users_avatar))
        {
            if (Storage::exists($user->users_avatar))
            {
                $user->users_avatar = Storage::url($user->users_avatar);
            }
            else
            {
                $user->users_avatar = '';
            }
        }
        return $user;
    }
}
