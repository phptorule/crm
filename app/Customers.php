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
}