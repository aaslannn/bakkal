<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $table = 'products_images';
    protected $fillable = ['pr_id', 'isim', 'baslik', 'varsayilan'];

    public function product() {
        return $this->belongsTo('App\Product','pr_id');
    }


}
