<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckboxesUsers extends Model
{
    protected $table = "checkboxes_users";
    public $timestamps = false;

    public function checkbox() {
        return $this->belongsTo('App\Users', 'users_id');
    }

}
