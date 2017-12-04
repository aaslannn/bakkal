<?php

namespace App;

use App\Library\Common;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $table = 'products';
    protected $guarded  = array('id');

    public function categorie() {
        return $this->belongsTo('App\Categorie','cat_id');
    }
    public function products_images() {
        return $this->hasMany('App\Picture','pr_id');
    }
    public function properties() {
        return $this->hasMany('App\ProductProp','pr_id');
    }
    public function products_options() {
        return $this->hasMany('App\ProductOption','pr_id');
    }
    public function product_brand() {
        return $this->belongsTo('App\Brand','brand_id');
    }

    public function reviews() {
        return $this->hasMany('App\Review','pr_id');
    }

    public function brands() {
        return $this->belongsToMany('App\Brand','brand_id');
    }

    public function setSefurlAttribute($url)
    {
        $url = Str::slug($url);
        //check is url unique ?
        //$check = new static;
        //$url = ($check::whereSefurl($url)->count()) ? $url .'-'. str_random(3) : $url;
        return $this->attributes['sefurl'] = $url;
    }

    public function setPriceAttribute($price)
    {
        $price = str_replace(',','.',$price);
        return $this->attributes['price'] = floatval($price);
    }
    public function setDiscountPriceAttribute($price)
    {
        $price = str_replace(',','.',$price);
        return $this->attributes['discount_price'] = floatval($price);
    }
    public function setRealPriceAttribute($price)
    {
        $price = str_replace(',','.',$price);
        return $this->attributes['real_price'] = floatval($price);
    }
    public function setKargoUcretAttribute($price)
    {
        $price = str_replace(',','.',$price);
        return $this->attributes['kargo_ucret'] = floatval($price);
    }


    /*
    public function setPriceAttribute($price)
    {
        $price = str_replace('.','',$price);
        $price = str_replace(',','.',$price);
        return $this->attributes['price'] = floatval($price);
    }
    public function setDiscountPriceAttribute($price)
    {
        $price = str_replace('.','',$price);
        $price = str_replace(',','.',$price);
        return $this->attributes['discount_price'] = floatval($price);
    }
    public function setRealPriceAttribute($price)
    {
        $price = str_replace('.','',$price);
        $price = str_replace(',','.',$price);
        return $this->attributes['real_price'] = floatval($price);
    }
    */

    // The way average rating is calculated (and stored) is by getting an average of all ratings,
    // storing the calculated value in the rating_cache column and incrementing the rating_count column by 1
    public function recalculateRating($rating)
    {
        $reviews = $this->reviews()->notSpam()->approved();
        $avgRating = $reviews->avg('rating');
        $this->rating_cache = round($avgRating,1);
        $this->rating_count = $reviews->count();
        $this->save();
    }


    /*
   public function setPriceAttribute($price)
   {
       $new_price = str_replace(',', '.', $price);
       return $this->attributes['price'] = $new_price;
   }

   public function setDiscount_priceAttribute($price)
   {
       $new_price = str_replace(',', '.', $price);
       return $this->attributes['discount_price'] = $new_price;
   }
   */

}
