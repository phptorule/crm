<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Products;
use App\Finances;

class Finances_products extends Model
{
    protected $table = "finances_products";
    //protected $primaryKey = 'products_id';



    public function products()
    {
        return $this->hasMany('App\Products', 'products_id');
    }


    
}