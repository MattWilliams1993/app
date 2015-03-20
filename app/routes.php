<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{	
	return View::make('hello');
});


// User api


Route::post('api/user/login', 'UserController@login');

Route::post('api/user/signup', 'UserController@signUpUser');

Route::post('api/user/logout', 'UserController@logout');

Route::post('api/users/step2Update', 'UserController@step2Update');

Route::get('api/user/getUserData', 'UserController@getUserData');

Route::post('api/user/photo', 'UserController@photoUpload');



// Post api

Route::post('api/post/create', 'PostController@createPost');

Route::get('api/post/getPosts', 'PostController@getPosts');

Route::post('api/post/addLike/', 'PostController@addLike');
Route::post('api/post/addDislike/', 'PostController@addDislike');




//Interest Search api

Route::get('api/search/getInterest', 'InterestController@getInterest');
Route::post('api/search/addtag', 'InterestController@addtag');



App::missing(function($exception)
{
    return View::make('hello');
});
