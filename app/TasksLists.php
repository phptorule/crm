<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\TaskList;

class TasksLists extends Model
{
    protected $table = "tasks_lists";

    protected $fillable = ['name','user_id','created_at', 'updated_at'];


    public function tasks() {
        return $this->hasMany('App\Cards');
    }

}
