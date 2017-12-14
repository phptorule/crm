<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TasksLists extends Model
{
    protected $table = "tasks_lists";
    protected $fillable = ['name','user_id','created_at', 'updated_at'];

    public function users() {
        return $this->belongsToMany('App\Users', 'lists_users', 'lists_id', 'users_id');
    }

    public function cards()
    {
        return $this->hasMany('App\Cards', 'task_id', 'id');
    }

    public function desc() {
        return $this->belongsTo('App\Descs');
    }

}
