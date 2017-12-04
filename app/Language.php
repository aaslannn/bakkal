<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public $timestamps = false;
    protected $table = 'languages';
    protected $fillable = ['dil', 'kisaltma', 'durum','varsayilan','bayrak'];
}