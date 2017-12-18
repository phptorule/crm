<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardsUsers extends Model
{
    protected $table = "cards_users";
    public $timestamps = false;

    public function user() {
        return $this->belongsTo('App\Users', 'users_id');
    }
}
