<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['uyeId', 'refNo', 'odemeTuru', 'hesapId', 'hediye', 'topTutar', 'kargoId', 'kargoTutar', 'kargoTakip', 'uyeIp', 'status', 'alici_adi', 'country_id', 'city_id', 'state', 'town', 'address', 'tel', 'tckimlik', 'faturaAyni', 'ftype', 'fisim', 'fcountry_id', 'fcity_id', 'fstate', 'ftown', 'faddress', 'ftel', 'ftckimlik', 'vergid','vergino','alici_email','ind_kod','ind_oran','kart_islemkod','paypal_txno'];


    public function customer() {
        return $this->belongsTo('App\Customer','uyeId');
    }

    public function product() {
        return $this->belongsTo('App\Product','pr_id');
    }

    public function orderstatus() {
        return $this->belongsTo('App\OrderStatu','status');
    }

    public function orderdetails() {
        return $this->hasMany('App\OrderDetails');
    }

    public function paymethod() {
        return $this->belongsTo('App\Paymethod','odemeTuru');
    }

    public function orderbank() {
        return $this->belongsTo('App\BankAccount','hesapId');
    }

    public function cargo() {
        return $this->belongsTo('App\Cargo','kargoId');
    }

    public function city() {
        return $this->belongsTo('App\City','city_id');
    }

    public function country() {
        return $this->belongsTo('App\Countrie','country_id');
    }

    public function fcity() {
        return $this->belongsTo('App\City','fcity_id');
    }

    public function fcountry() {
        return $this->belongsTo('App\Countrie','fcountry_id');
    }

    public function getCreatedAtAttribute($value)
    {
        $dt = Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d.m.Y H:i');
        return $dt;
    }

    public function setTopTutarAttribute($price)
    {
        $price = str_replace(',','',$price);
        //$price = str_replace('.',',',$price);
        return $this->attributes['topTutar'] = floatval($price);
    }
}
