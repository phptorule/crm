<?php

namespace App\Http\Controllers;

use App\Users;
use App\Teams;
use App\Services\UsersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function info()
    {
        $user = FALSE;
        if (Auth::check())
        {
            $user = Auth::user();
            $user = UsersService::avatar($user);
        }

        return $user;
    }

    public function check($post = [])
    {
    	$user = Users::where('users_email', $post['email'])->where('users_id', '<>', Auth::id())->first();
    	if (empty($user))
    	{
    		$user = [
    			'users_id' => time(),
    			'users_email' => $post['email'],
    			'new' => TRUE
    		];
    	}
        else
        {
            $user = UsersService::avatar($user);
        }

    	return $user;
    }

    public function profile($post = [])
    {
        $user = Auth::user();
        if (request()->hasFile('file') && request()->file->isValid())
        {
            if ( ! empty($user->users_avatar))
            {
                Storage::delete($user->users_avatar);
            }
            $user->users_avatar = request()->file->store('avatars');
        }
        $user->save();

        $this->message(__('All changes were saved'), 'success');
        return $this->info();
    }

    public function getTeams($post = []) {
        $teams = Auth::user();
        return $teams->teams;
    }

    public function getCurrentTeam() {
        $current_team = array();
        $current_team_id = session('current_team');
        $current_team = Teams::find(['teams_id' => $current_team_id]);
        return $current_team;
    }

    public function saveTeam($post = []) {
        session(['current_team' => $post['current_team']]);
    }

    public function getUser($post = []) {
        $user = Users::where('users_id', $post['users_id']);
        //dd($user->get());

        return $user->get();
    }
}
