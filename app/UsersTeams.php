<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersTeams extends Model
{
    protected $table = "users_teams";

    public function users()
    {
    	return $this->hasMany('App\Users','users_id');
    }
}
