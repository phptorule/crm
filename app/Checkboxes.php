<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkboxes extends Model
{
    protected $table = "checkboxes";

    public function users() {
        return $this->belongsToMany('App\Users', 'checkboxes_users', 'checkboxes_id', 'users_id');
    }

}
