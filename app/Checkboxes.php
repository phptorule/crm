<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkboxes extends Model
{
    protected $table = "checkboxes";

    protected $primaryKey = 'id';


    public function checkboxesUsers() {
        return $this->hasMany('App\Users', 'checkboxes_users', 'id', 'users_id');
    }

}
