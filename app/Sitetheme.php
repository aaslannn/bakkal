<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sitetheme extends Model
{
    public $timestamps = false;

    protected $table = 'themes';
    protected $fillable = ['baslik', 'aciklama', 'durum', 'varsayilan'];

}
