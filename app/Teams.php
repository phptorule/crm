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

    public function customers()
    {
        return $this->belongsToMany('App\Customers', 'customers_teams', 'teams_id', 'customer_id');
    }

    public function finances()
    {
        return $this->belongsToMany('App\Finances', 'finances_teams', 'teams_id', 'finances_id');
    }

    public function financesRegistered()
    {
        return $this->belongsToMany('App\FinancesRegistered', 'finances_registered_teams', 'teams_id', 'registered_id');
    }

    public function descs()
    {
        return $this->hasMany('App\Descs', 'team_id');
    }

    public function labels()
    {
        return $this->hasMany('App\Labels', 'teams_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function($team) {
            $team->defaultLabels($team);
        });

        static::deleting(function($team) {
            //
        });
    }

    public function defaultLabels($team)
    {
        $labels = [
            [
                'label_color' => 'green'
            ], [
                'label_color' => 'yellow'
            ], [
                'label_color' => 'orange'
            ], [
                'label_color' => 'red'
            ], [
                'label_color' => 'blue'
            ]
        ];

        foreach ($labels as $label) {
           $team->labels()->create($label);
        }
    }
}
