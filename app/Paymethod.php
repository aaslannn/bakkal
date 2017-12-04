<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Paymethod extends Model
{
    protected $table = 'paymethods';
    protected $fillable = ['title_tr', 'title_en', 'title_es', 'status', 'sequence','uniqueName'];
    
    
    public function setuniqueNameAttribute($url)
    {
        $url = Str::slug($url);      
        return $this->attributes['uniqueName'] = $url;
    }    
}
