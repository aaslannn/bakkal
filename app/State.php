<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';

    public function cities() {
        return $this->hasMany('App\City','state_id');
    }

    public function country() {
        return $this->belongsTo('App\Countrie');
    }
}
