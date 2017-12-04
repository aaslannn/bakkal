<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class ProductProp extends Model
{
    public $timestamps = false;

    protected $table = 'products_props';
    protected $fillable = ['pr_id', 'title_tr', 'title_en', 'title_es'];

    public function product() {
        return $this->belongsTo('App\Product','pr_id');
    }
    public function options() {
        return $this->hasMany('App\ProductOption','prop_id');
    }

    /**
     * Find a corproation for users
     * @param int $id
     * @return self
     */
    public static function countPropbyPduductId($prId)
    {
        return self::where('pr_id', $prId)->count();
    }


}
