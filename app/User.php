<?php namespace App;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;

class User extends Model {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	/**
	* To allow soft deletes
	*/
	use SoftDeletes;

    protected $dates = ['deleted_at'];

}
