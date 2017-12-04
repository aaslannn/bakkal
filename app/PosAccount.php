<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PosAccount extends Model
{
    protected $table = 'posaccounts';
    protected $fillable = ['bankname', 'bankhandle', 'cardname', 'taksitler', 'icon', 'status','mainpos','isyerino','terminalno','kullanici','sifre'];
    
    public function setbankhandleAttribute($url)
    {
        $url = Str::slug($url);      
        return $this->attributes['bankhandle'] = $url;
    }  
}
