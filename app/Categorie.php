<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Categorie extends Model
{
    protected $table = 'categories';
    protected $fillable = ['title_tr','title_en','title_es','content_tr','content_en', 'content_es', 'parent_id', 'sefurl', 'status', 'sequence', 'image'];

    protected $autoFilters = array('id', 'sequence', 'title');


    public function products() {
        return $this->hasMany('App\Product','cat_id');
    }

    public function subcats() {
        return $this->hasMany('App\Categorie','parent_id');
    }

    public function parentCat() {
        return $this->belongsTo('App\Categorie','parent_id');
    }

    public function brands() {
        return $this->hasManyThrough('App\Brand','App\Product','brand_id','pr_id');
    }

    public function setSefurlAttribute($url)
    {
        $url = Str::slug($url);
        //check is url unique ?
        //$check = new static;
        //$url = ($check::whereSefurl($url)->count()) ? $url .'-'. str_random(3) : $url;

        return $this->attributes['sefurl'] = $url;
    }
}
