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

Route::get('/', function() {
	return View::make('main');
});

Route::get('read/{sid}','ReadController@readSingle')
	->where('sid', '[0-9]+');

Route::get('moderate/{sid}','MemberController@getModerate')
	->where('sid', '[0-9]+');

//Route::controller(Controller::detect());
Route::controller('user', 'UserController');
Route::controller('read', 'ReadController');
Route::controller('member', 'MemberController');
//Route::controller('api', 'ApiController');

/*//API Goodies!
Route::group(['prefix' => 'api'], function() {
	Route::controller('contribute', 'ApicontributeController');
	Route::controller('moderate', 'ApimoderateController');
	Route::controller('manage', 'ApimanageController');
	Route::controller('user', 'ApiuserController');

	//clean resource controllers
	Route::resource('feedback', 'ApifeedbackController');
});
*/

Route::controller('api/contribute', 'ApicontributeController');
Route::controller('api/moderate', 'ApimoderateController');
Route::controller('api/manage', 'ApimanageController');
Route::controller('api/user', 'ApiuserController');

//clean resource controllers
Route::resource('api/feedback', 'ApifeedbackController');

if( App::environment() !== 'development' ) {
	//unrecognized urls, must be placed at bottom
	App::missing(function(){
		return View::make('lost');
	});
	App::error(function(){
		return View::make('lost');
	});
}