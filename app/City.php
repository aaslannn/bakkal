<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    public function towns() {
        return $this->hasMany('App\Town','city_id');
    }

    public function state() {
        return $this->belongsTo('App\State');
    }

    public function country() {
        return $this->belongsTo('App\Countrie');
    }
}
