<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $table = 'orders_details';
    protected $fillable = ['order_id','product_id','option_id','adet','birimFiyat','toplamFiyat','kargoTutar','kdvTutar','havale_ind_yuzde'];

    public function order() {
        return $this->belongsTo('App\Order','order_id');
    }

    public function product() {
        return $this->belongsTo('App\Product','product_id');
    }

    public function option() {
        return $this->belongsTo('App\ProductOption','option_id');
    }

}
