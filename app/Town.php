<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    protected $table = 'towns';

    public function city() {
        return $this->belongsTo('App\City');
    }
}
