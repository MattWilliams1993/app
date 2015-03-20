<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class PostModel extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'posts';



	public function getAuthIdentifier()
	{
		return $this->getKey();
	}
 

	public static function findByUsernameOrFail($username, $columns = array('*'))
	{
        if ( ! is_null($user = static::whereUsername($username)->first($columns))) {
            return $user;
        }
        throw new ModelNotFoundException;
    }

    public function interests() {

    	return $this->belongsToMany("InterestModel", 'post_interest', 'post_id', 'interest_id');

    }

    public function user() {
    	return $this->belongsTo('UserModel');
    }
    
}
