<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersTeams extends Model
{
    protected $table = "users_teams";

    public function users()
    {
        return $this->belongsTo('App\Users', 'users_id');
    }
}
