<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Content extends Model
{
    protected $table = 'contents';
    protected $fillable = ['title_tr','title_en','content_tr','content_en', 'link', 'sefurl', 'parent_id', 'sequence', 'hidden', 'target', 'tags', 'image', 'type', 'status'];

    public function subcats() {
        return $this->hasMany('App\Content','parent_id');
    }

    public function parentCat() {
        return $this->belongsTo('App\Content');
    }

    public function setSefurlAttribute($sefurl)
    {
        $sefurl = Str::slug($sefurl);
        //check is url unique ?
        //$check = new static;
        //$url = ($check::whereSefurl($url)->count()) ? $url .'-'. str_random(3) : $url;

        return $this->attributes['sefurl'] = $sefurl;
    }
}
