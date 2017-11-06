<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinancesRegistered extends Model
{
    protected $table = "finances_registered";
    protected $primaryKey = 'registered_id';
    protected $guarded = [];
}