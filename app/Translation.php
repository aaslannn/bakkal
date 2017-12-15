<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Translation extends Model
{
    public $timestamps = false;
    protected $table = 'translations';
    protected $fillable = ['slug', 'lang_tr', 'lang_en'];

    public function setSlugAttribute($slug)
    {
        $slug = Str::slug($slug);
        return $this->attributes['slug'] = $slug;
    }
}