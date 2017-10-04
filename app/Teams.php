<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    protected $primaryKey = 'teams_id';
    protected $fillable = ['teams_name'];

    public function users()
    {
    	return $this->belongsToMany('App\Users', 'users_teams', 'teams_id', 'users_id')->withPivot(['teams_leader', 'teams_invite', 'teams_approved']);
    }

    public function plugins()
    {
    	return $this->belongsToMany('App\Plugins', 'plugins_teams', 'teams_id', 'plugins_id');
    }
}
