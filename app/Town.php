<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    protected $table = 'ilceler';

    public function il() {
        return $this->belongsTo('App\City');
    }
}
