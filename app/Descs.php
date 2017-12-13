<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Descs;

class Descs extends Model
{
    protected $table = "descs";

    protected $fillable = ['name','user_id','created_at', 'updated_at'];


    public function tasks() {
        return $this->hasMany('App\TasksLists', 'desc_id');
    }

}
