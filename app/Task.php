<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = "task";

    protected $fillable = ['name','user_id','created_at', 'updated_at'];

}
