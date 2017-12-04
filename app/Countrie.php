<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Countrie extends Model
{
    protected $table = 'countries';

    public function cities() {
        return $this->hasMany('App\City','ulke_id');
    }
}
