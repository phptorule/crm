<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'users_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['users_name', 'users_email', 'users_password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['users_password', 'remember_token'];

    public function username()
    {
        return 'users_email';
    }

    public function getAuthPassword()
    {
        return $this->users_password;
    }

    public function routeNotificationForMail()
    {
        return $this->users_email;
    }

    public function teams()
    {
        return $this->belongsToMany('App\Teams', 'users_teams', 'users_id', 'teams_id')->withPivot(['teams_leader', 'teams_invite', 'teams_approved']);
    }

    public function customers()
    {
        return $this->belongsToMany('App\Customers', 'customers_users', 'users_id', 'customer_id');
    }

    public function finances()
    {
        return $this->hasMany('App\Finances');
    }

    
    public function comments_card() {
        return $this->HasMany('App\CardsComments', 'users_id');
    }
    
    public function cards() {
        return $this->belongsToMany('App\Cards', 'cards_users', 'users_id', 'cards_id');
    }

    public function checkbox() {
        return $this->belongsTo('App\Checkboxes', 'checkboxes_users', 'users_id', 'checkboxes_id');
    }

    public function lists() {
        return $this->belongsToMany('App\TasksLists', 'lists_users', 'users_id', 'lists_id');
    }
}
