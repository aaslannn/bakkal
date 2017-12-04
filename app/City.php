<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'iller';

    public function ilceler() {
        return $this->hasMany('App\Town','il_id');
    }

    public function ulke() {
        return $this->belongsTo('App\Countrie');
    }
}
