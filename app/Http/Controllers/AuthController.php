<?php

namespace App\Http\Controllers;

use App\Users;
use App\Teams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function signin($post = [])
    {
        $validator = $this->validate(request(), [
            'users_email' => 'required',
            'password' => 'required',
        ]);

        if ( ! $validator->fails())
        {
            $auth = ['users_email'=>$post['users_email'], 'password' => $post['password'] ];
            if (Auth::validate($auth))
            {
                $user = Users::where('users_email', $auth['users_email'])->first();
                if (!empty($user->users_active))
                {
                    Auth::attempt($auth);
                    return TRUE;
                }
                else
                {
                    $this->message(__('Your account isn\'t active'));
                    $response['resend_letters'] = TRUE;
                    return $response;
                }
            }
            else
            {
                $this->message(__('Incorect username or password'));
            }
        }
        return FALSE;

    }

    public function signup($post = [])
    {
        $users_email = $post['users_email'];
        $password = $post['password'];
        $current = Users::where('users_email', $users_email)->first();
        if (!empty($current))
        {
            $this->message(__('User with current email alredy registered.'));
            return false;
        }
        else
        {
            $user = new Users();
            $user->users_email = $users_email;
            $user->users_name = '';
            $user->users_password = bcrypt($password);
            if ($user->save() && $this->activate($user))
            {
                $this->message(__('To activate account chek you email'),'success');
                return true;
            }
        }
    }

    public function accept($post = [])
    {
        $users_name = $post['users_name'];
        $hash = $post['url'];
        $user = Users::whereRaw('MD5(users_id) = "'. $hash.'"')->where('users_active',0)->first();
        if ($user)
        {
            $user->users_name = $users_name;
            $user->users_active = 1;
            $user->save();
            $this->message(__('Account for email: '.$user->users_email.' activated'),'success');
            return TRUE;
        }
        else
        {
            $this->message('Bad url');
            return FALSE;
        }
    }

    public function signout()
    {
        Auth::logout();
        return TRUE;
    }

    public function recovery($post = [])
    {
        $users_email = $post['users_email'];
        $user = Users::whereRaw('LOWER(users_email) = "'.strtolower($users_email).'"')->first();
        if ($user)
        {
            $new_password = substr(md5(rand(100, 200)), 8, 6) ;
            $user->users_password = bcrypt($new_password);
            $user->save();
            $user->users_password = $new_password;
            Mail::to($user->users_email)->send(new \App\Mail\UsersRecoveryPassword($user));
            $this->message(__('Chek you email'),'success');
            return TRUE;
        }
        else
        {
            $this->message(__('User with this email not registered'));
            return FALSE;
        }
        return $post;
    }

    public function resend($post = [])
    {
        $email = strtolower($post['users_email']);
        $user = Users::whereRaw('LOWER(users_email) = "'.$email.'"')->first();
        if ($user && $this->activate($user))
        {
            $this->message(__('Activation email was successfully sent'), 'success');
            return TRUE;
        }
        else
        {
            $this->message(__('There is no a user with current email - ').$email);
            return FALSE;
        }
    }

    private function activate($user)
    {
        $user->activate_link = url('/auth/accept', [md5($user->users_id)]);
        try
        {
            Mail::to($user->users_email)->send(new \App\Mail\UsersNewRegister($user));
            return TRUE;
        }
        catch (Exception $ex)
        {
            return FALSE;
        }
    }

    public function invite($post = [])
    {
        $members = DB::table('users_teams')->where(DB::raw('MD5(CONCAT(users_id,teams_id))'), $post['hash'])->first();
        if ( ! empty($members->users_id) &&  ! empty($members->teams_id))
        {
            $user = Users::find($members->users_id);
            $user->team = Teams::find($members->teams_id);
            return $user;
        }

        return FALSE;
    }

    public function confirm($post = [])
    {
        $user = Users::find($post['users_id']);
        $user->users_name = $post['users_name'];
        $user->users_active = TRUE;
        if ( ! empty($post['password']))
        {
            $user->users_password = bcrypt($post['password']);
        }
        $user->save();

        DB::table('users_teams')->where([['users_id', '=', $post['users_id']], ['teams_id', '=', $post['teams_id']]])->update(['teams_approved' => TRUE]);
        Auth::loginUsingId($post['users_id']);

        $this->message(__('You just successfully confirmed your membership in a team'), 'success');
        return TRUE;
    }
}
