<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class InterestModel extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'interests';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	public static function findByNameOrFail($interest, $columns = array('*'))
	{
        if ( ! is_null($interests = static::whereName($interest)->first($columns))) {
            return $interests;
        }

    }

    public function getName() {

    	return $this->name;
    }

    public function getPost() {

    	return $this->belongsToMany('PostModel');
    }

}