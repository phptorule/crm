<?php

namespace App\Http\Controllers;

use App\Teams;
use App\Users;
use App\Services\UsersService;
use App\Notifications\TeamsInvite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use \Validator;

class TeamsController extends Controller
{
    public function getList()
    {
    	$teams = Auth::user()->teams()->with('users')->with('plugins')->get();
        foreach ($teams as $team)
        {
            foreach ($team['users'] as $user)
            {
                $user = UsersService::avatar($user);
            }
        }
        return $teams;
    }

    public function getTeam($post = [])
    {
        $team = Teams::where('teams_id', $post['teams_id'])->first();

        return $team;
    }

    public function getLeaderTeams($post = [])
    {
        return Auth::user()->teams()->wherePivot('teams_leader', TRUE)->get();
    }

    public function save($post = [])
    {
        $messages = [
            'unique' => 'The name "' . $post['team']['teams_name'] . '" has already been taken.'
        ];

        $validator = $this->validate(request(), [
            'team.teams_name' => 'unique:teams,teams_name,' . (empty($post['team']['teams_id']) ? 0 : $post['team']['teams_id']) . ',teams_id'
        ], $messages);

        if ($validator->fails())
        {
            return FALSE;
        }

    	$team = Teams::firstOrNew(['teams_id' => empty($post['team']['teams_id']) ? 0 : $post['team']['teams_id']]);
    	foreach ($post['team'] as $key => $value)
    	{
            if (empty($value))
            {
                $value = '';
            }

    		$team->$key = $value;
    	}

        $team->save();

        $exists = [];
        foreach ($team->users as $user)
        {
            $exists[] = $user->users_id;
        }


        if ( ! empty($post['members']))
        {
            $users_ids = [];
            $need_to_notify = [];
            foreach ($post['members'] as $member)
            {
                if ( ! empty($member['new']))
                {
                    if (empty($member['removed']))
                    {
                        $user = new Users;
                        $user->users_name = '';
                        $user->users_password = '';
                        $user->users_avatar = '';
                        $user->users_email = $member['users_email'];
                        $user->save();

                        $users_ids[$user->users_id] = [
                            'teams_leader' => ! empty($member['pivot']['teams_leader']),
                            'teams_invite' => 1,
                            'teams_approved' => ! empty($member['pivot']['teams_approved'])
                        ];

                        $need_to_notify[] = [
                            'users_id' => $user->users_id,
                            'type' => 'new'
                        ];
                    }
                }
                else
                {
                    if (empty($member['removed']))
                    {
                        $users_ids[$member['users_id']] = [
                            'teams_leader' => ! empty($member['pivot']['teams_leader']),
                            'teams_invite' => 1,
                            'teams_approved' => ! empty($member['pivot']['teams_approved'])
                        ];

                        if ( ! in_array($member['users_id'], $exists) && $member['users_id'] != Auth::id())
                        {
                            $need_to_notify[] = [
                                'users_id' => $member['users_id'],
                                'type' => 'exist'
                            ];
                        }
                    }
                }
            }
        }

        if ( ! empty($users_ids))
        {
            $team->users()->sync($users_ids);
        }

        if ( ! empty($need_to_notify))
        {
            foreach ($need_to_notify as $notify)
            {
                $user = Users::find($notify['users_id']);
                $user->type = $notify['type'];
                $user->teams_id = $team->teams_id;
                $user->notify(new TeamsInvite($user));
            }
        }

		$this->message(__('Team was successfully saved'), 'success');
        //return $this->get();
		return $team->teams_id;
    }

    public function remove($post = [])
    {
        $team = Teams::find($post['teams_id']);
        $team->users()->detach();
        $team->delete();

        $this->message(__('Team was successfully removed'), 'success');
        return $this->get();
    }

    public function leave($post = [])
    {
        $team = Teams::find($post['teams_id']);
        $team->users()->detach(Auth::id());

        $this->message(__('You successfully left the team'), 'success');
        return $this->get();
    }

    public function decline($post = [])
    {
        $team = Teams::find($post['teams_id']);
        $team->users()->detach(Auth::id());

        $this->message(__('You successfully decline the invitation'), 'success');
        return $this->get();
    }

    public function approve($post = [])
    {
        DB::table('users_teams')->where([['users_id', '=', Auth::id()], ['teams_id', '=', $post['teams_id']]])->update(['teams_approved' => TRUE]);

        $this->message(__('You just successfully confirmed your membership in a team'), 'success');
        return $this->get();
    }
}
