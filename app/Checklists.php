<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklists extends Model
{
    protected $table = "checklists";

    public function checkBoxes() {
        return $this->hasMany('App\Checkboxes', 'checklist_id');
    }

}
