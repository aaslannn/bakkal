<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $table = 'slides';
    protected $fillable = ['title_tr', 'title_en', 'title_es', 'image', 'link','sequence','status'];
}