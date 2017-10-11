<?php

namespace App\Http\Controllers;

use App\Plugins;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PluginsController extends Controller
{
    public function get($post = [])
    {
    	return Plugins::all();
    }

    public function forUser($post = [])
    {
    	$exist_ids = [];
    	$result = [];

        $current_team = session()->get('current_team');

        $teams = Auth::user()->teams()->wherePivot('teams_id', '=', $current_team, 'and', 'teams_approved', '=', true)->get();
        foreach ($teams as $team)
        {
            $plugins = $team->plugins()->get();
            foreach ($plugins as $plugin)
            {
                $config = json_decode($plugin->plugins_config, TRUE);
                if ( ! empty($config['only_leaders']) && ! empty($team->pivot->teams_leader) || empty($config['only_leaders']))
                {
                    if ( ! in_array($plugin->plugins_id, $exist_ids))
                    {
                        $exist_ids[] = $plugin->plugins_id;
                        $result[] = $plugin;
                    }
                }
            }
        }

    	return $result;
    }

    public function save($post = [])
    {
    	$plugin = Plugins::find($post['plugins_id']);
    	if (empty($post['plugins_active']))
    	{
    		$plugin->teams()->detach($post['teams_id']);
    	}
    	else
    	{
    		$plugin->teams()->syncWithoutDetaching($post['teams_id']);
    	}

        $this->message(__('Changes were successfully saved'), 'success');
        return TRUE;
    }
}
