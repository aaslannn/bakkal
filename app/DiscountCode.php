<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    public $timestamps = false;

    protected $table = 'discount_codes';
    protected $fillable = ['code', 'desc', 'rate','start_date','end_date','used'];

    public function getStartDateAttribute($value)
    {
        $dt = Carbon::createFromFormat('Y-m-d', $value)->format('d.m.Y');
        return $this->attributes['start_date'] = $dt;
    }

    public function setStartDateAttribute($value)
    {
        $dt = Carbon::createFromFormat('d.m.Y', $value)->format('Y-m-d');
        return $this->attributes['start_date'] = $dt;
    }

    public function getEndDateAttribute($value)
    {
        $dt = Carbon::createFromFormat('Y-m-d', $value)->format('d.m.Y');
        return $this->attributes['end_date'] = $dt;
    }

    public function setEndDateAttribute($value)
    {
        $dt = Carbon::createFromFormat('d.m.Y', $value)->format('Y-m-d');
        return $this->attributes['end_date'] = $dt;
    }

    public function changeCodetoUsed($code)
    {
        $disCode = DiscountCode::whereCode($code)->firstOrFail();
        $disCode->used = 1;
        $disCode->save();
    }
}