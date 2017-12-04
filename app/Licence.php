<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Licence extends Model {

	protected $table = 'licences';
	protected $hidden = array('code', 'begin_date', 'end_date');

	public function getBeginDateAttribute($value)
	{
		$dt = Carbon::createFromFormat('Y-m-d', $value)->format('d.m.Y');
		return $dt;
	}

	public function getEndDateAttribute($value)
	{
		$dt = Carbon::createFromFormat('Y-m-d', $value)->format('d.m.Y');
		return $dt;
	}
}
