<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
	protected $table = "customers";
    protected $primaryKey = 'customer_id';
    protected $guarded = [];

    public function teams()
    {
        return $this->belongsToMany('App\Customers', 'customers_teams', 'customer_id', 'teams_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\Users', 'customers_users', 'customer_id', 'users_id');
    }

    public function cards()
    {
        return $this->belongsToMany('App\Cards', 'cards_customers', 'customer_id', 'cards_id');
    }
}