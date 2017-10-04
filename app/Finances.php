<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Finances extends Model
{
    protected $table = "finances";
    protected $primaryKey = 'finances_id';
    protected $guarded = [];
}
