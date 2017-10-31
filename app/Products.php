<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = "products";
    protected $primaryKey = 'products_id';
    protected $guarded = [];

    public function finances()
    {
        return $this->belongsToMany('App\Finances', 'finances_products', 'products_id', 'finances_id');
    }
}