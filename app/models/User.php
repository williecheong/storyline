<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'line_user';
	protected $primaryKey = 'user_id';
	
	public function directing(){
		return $this->belongsToMany('Story', 'rshp_director', 'user_id', 'stor_id');
	}
	
	public function contributions(){
		return $this->hasMany('Contribution', 'user_id')->orderby('updated_at', 'desc');
	}
	
	public function editedcontributionparts(){
		return $this->hasMany('ContributionPart', 'editedby');
	}
	
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

}