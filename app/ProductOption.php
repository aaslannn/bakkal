<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    public $timestamps = false;

    protected $table = 'products_options';
    protected $fillable = ['pr_id', 'prop_id', 'title_tr', 'title_en', 'stok'];

    public function product() {
        return $this->belongsTo('App\Product','pr_id');
    }


}
