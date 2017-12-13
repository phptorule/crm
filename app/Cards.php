<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cards extends Model
{
    protected $table = "cards";
	protected $primaryKey = "cards_id";
    protected $fillable = ['name','user_id','task_id','created_at', 'updated_at'];


    public function task() {
        return $this->belongsTo('App\TasksLists');
    }

    public function users() {
        return $this->belongsToMany('App\Users', 'cards_users', 'cards_id', 'users_id');
    }

    public function comments() {
        return $this->belongsToMany('App\CardsComments', 'cards_users', 'cards_id', 'users_id');
    }

    public function checkLists() {
        return $this->hasMany('App\Checklists', 'cards_id');
    }

    public function cardComments() {
        return $this->hasMany('App\CardsComments', 'cards_id');
    }
}
