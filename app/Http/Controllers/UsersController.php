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
        $user = Auth::user();
        return $user->teams;
    }

    public function getCurrentTeam() {

        if(isset($_COOKIE['current_team'])){
            session(['current_team' => $_COOKIE['current_team']]);
        }

        $current_team = array();
        $current_team = Teams::where(['teams_id' => session('current_team')])->first();
        return $current_team;
    }

    public function saveTeam($post = []) {
        
        setcookie("current_team", $post['current_team'], time()+86400);
        session(['current_team' => $post['current_team']]);
    }

    public function getUser($post = []) {
        $user = Users::where('users_id', $post['users_id']);
        return $user->get();
    }

    public function getTeamUsers($post = []) {

        if(isset($_COOKIE['current_team'])){
            session(['current_team' => $_COOKIE['current_team']]);
        }
        
        $team = Teams::find(session('current_team'));
        return $team->users()->get();
    }
}