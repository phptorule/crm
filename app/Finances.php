<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Finances extends Model
{
    protected $table = "finances";
    protected $primaryKey = 'finances_id';
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany('App\Products', 'finances_products', 'finances_id', 'products_id');
    }
}
