<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plugins extends Model
{
	protected $primaryKey = 'plugins_id';

    public function teams()
    {
    	return $this->belongsToMany('App\Teams', 'plugins_teams', 'plugins_id', 'teams_id');
    }
}
