<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatu extends Model
{
    public $timestamps = false;

    protected $table = 'orderstatus';
    protected $fillable = ['status'];

}
