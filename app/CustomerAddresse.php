<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class CustomerAddresse extends Model
{
    //public $timestamps = false;

    protected $table = 'customers_address';
    protected $fillable = ['customer_id', 'title', 'country_id', 'city_id', 'town', 'state', 'adres', 'tel', 'name', 'tckimlik', 'vergid','vergino','type'];

    public function user() {
        return $this->belongsTo('App\Customer','customer_id');
    }


}
