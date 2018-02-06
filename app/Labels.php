<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Labels extends Model
{
    protected $table = "labels";
    protected $primaryKey = 'label_id';
    protected $fillable = ['label_color', 'label_description'];
    public $timestamps = false;

    public function teams()
    {
        return $this->hasMany('App\Labels', 'label_id');
    }

    public function cards() {
        return $this->belongsToMany('App\Cards', 'cards_labels', 'label_id', 'cards_id');
    }
}
