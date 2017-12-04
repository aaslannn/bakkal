<?php namespace App;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;


class Customer extends Model {

	protected $table = 'customers';
	protected $hidden = array('password', 'remember_token','reset_password_code');
	protected $guarded = array('reset_password_code','activation_code','persist_code');
	protected $fillable = ['first_name', 'last_name', 'email', 'password', 'dob', 'bio', 'gender', 'country', 'state', 'city', 'town', 'address', 'activated', 'passnohash', 'social_login', 'social_provider', 'social_user_id', 'social_token', 'social_token_secret'];

	/*
	use SoftDeletes;
    protected $dates = ['deleted_at'];
	*/

	public function setPasswordAttribute($password)
	{
		return $this->attributes['password'] = Hash::make($password);
	}

	public function getDobAttribute($value)
	{
		if($value == '0000-00-00')
			return '';
		$dt = Carbon::createFromFormat('Y-m-d', $value)->format('d-m-Y');
		return $this->attributes['dob'] = $dt;
	}

	public function setDobAttribute($value)
	{
		if($value == '')
			return '0000-00-00';
		
		$dt = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
		return $this->attributes['dob'] = $dt;
	}

	public function getCreatedAtAttribute($value)
	{
		if($value == '')
			return '';

		$dt = Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d.m.Y H:i');
		return $dt;
	}

	public function isActivated()
	{
		return (bool) $this->activated;
	}

	public function scopeActivated($query) {
		return $query->where('activated', true);
	}

	public function countrie() {
		return $this->belongsTo('App\Countrie','country');
	}

	public function adresses() {
		return $this->hasMany('App\CustomerAddresse','customer_id');
	}

	public function favorites() {
		return $this->hasMany('App\Favorite','user_id');
	}

	public function orders() {
		return $this->hasMany('App\Order','uyeId');
	}

	public function recordLogin()
	{
		$this->last_login = $this->freshTimestamp();
		$this->save();
	}
}
