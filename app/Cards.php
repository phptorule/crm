<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cards extends Model
{
    protected $table = "cards";

    protected $fillable = ['name','user_id','task_id','created_at', 'updated_at'];


    public function task() {
        return $this->belongsTo('App\TasksLists');
    }

}
