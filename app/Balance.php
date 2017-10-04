<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $table = "balance";
    protected $primaryKey = 'balance_id';
    protected $guarded = [];
}
