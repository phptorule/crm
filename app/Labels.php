<?php

namespace App;

use App\Cards;
use Illuminate\Database\Eloquent\Model;

class Labels extends Model
{
    protected $table = "labels";
	protected $primaryKey = "label_id";

}
