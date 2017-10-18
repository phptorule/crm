<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomersComments extends Model
{
	protected $table = "customers_comments";
    protected $primaryKey = 'comment_id';
    protected $guarded = [];
}