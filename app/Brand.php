<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public $timestamps = false;

    protected $table = 'brands';
    protected $fillable = ['name','sequence','status'];

    public function product() {
        return $this->hasMany('App\Product');
    }

    public function products() {
        return $this->hasMany('App\Product','brand_id');
    }
}
