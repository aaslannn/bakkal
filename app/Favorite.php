<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favorites';
    protected $fillable = ['pr_id', 'user_id'];


    public function user() {
        return $this->belongsTo('App\Customer');
    }

    public function product() {
        return $this->belongsTo('App\Product','pr_id');
    }
    
    public function getTimeagoAttribute()
    {
        $date = Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans();
        return $date;
    }

    // this function takes in product ID, comment and the rating and attaches the favorite to the product by its ID, then the average rating for the product is recalculated
    public function storeFavoriteForProduct($sefurl, $comment, $rating,$uId)
    {
        $prd = Product::whereSefurl($sefurl)->firstOrFail();

        //$this->pr_id = $prd->id;
        $this->user_id = $uId;
        $this->comment = $comment;
        $this->rating = $rating;
        $prd->favorites()->save($this);

        // recalculate ratings for the specified product
        $prd->recalculateRating($rating);
    }

    public function delFavoriteForProduct($sefurl, $rId)
    {
        $prd = Product::whereSefurl($sefurl)->firstOrFail();
        $favorite = Favorite::whereId($rId)->firstOrFail();
        $rating = $favorite->rating;
        $favorite->delete();

        // recalculate ratings for the specified product
        $prd->recalculateRating($rating);
    }

}
