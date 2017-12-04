<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // Validation rules for the ratings
    public function getCreateRules()
    {
        return array(
            'comment'=>'required|min:10',
            'rating'=>'required|integer|between:1,5',
            'user_id' => 'required|min:1'
        );
    }

    protected $table = 'reviews';
    protected $fillable = ['rating','comment'];

    public function user() {
        return $this->belongsTo('App\Customer');
    }

    public function product() {
        return $this->belongsTo('App\Product','pr_id');
    }

    public function scopeApproved($query) {
        return $query->where('approved', true);
    }

    public function scopeSpam($query) {
        return $query->where('spam', true);
    }

    public function scopeNotSpam($query) {
        return $query->where('spam', false);
    }

    // Attribute presenters
    public function getTimeagoAttribute()
    {
        $date = Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans();
        return $date;
    }

    public function getCreatedAtAttribute($value)
    {
        $dt = Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d.m.Y H:i');
        return $dt;
    }

    // this function takes in product ID, comment and the rating and attaches the review to the product by its ID, then the average rating for the product is recalculated
    public function storeReviewForProduct($sefurl, $comment, $rating,$uId)
    {
        $prd = Product::whereSefurl($sefurl)->firstOrFail();

        //$this->pr_id = $prd->id;
        $this->user_id = $uId;
        $this->comment = $comment;
        $this->rating = $rating;
        $prd->reviews()->save($this);

        // recalculate ratings for the specified product
        $prd->recalculateRating($rating);
    }

    public function delReviewForProduct($sefurl, $rId)
    {
        $prd = Product::whereSefurl($sefurl)->firstOrFail();
        $review = Review::whereId($rId)->firstOrFail();
        $rating = $review->rating;
        $review->delete();

        // recalculate ratings for the specified product
        $prd->recalculateRating($rating);
    }

}
