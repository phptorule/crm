<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{
    protected $table = "task_list";

    protected $fillable = ['name','user_id','task_id','created_at', 'updated_at'];


    public function task() {
        return $this->belongsTo('App\Task');
    }

}
