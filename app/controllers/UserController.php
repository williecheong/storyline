<?php

class UserController extends BaseController {
	//public $restful = true;

	public function getIndex(){
		return View::make('user/main');
	}
	
	public function postSignin(){
		$retrieve = Input::all();
		$credentials = array(
			'email' 	=> $retrieve['email'],
			'password' 	=> $retrieve['password']
		);
		
		$validator = Validator::make( $credentials,
			array(	'email' => 'required|email|exists:line_user,email',
					'password' => 'required')
		);
		
		if ( $validator->fails() ){
			return Redirect::to('user')->withErrors($validator);
		} else {
			if( Auth::attempt($credentials) ){
				if(Auth::check()){
					//success!
					return Redirect::to('/');
				} else {
					//session could not be created.
					$failmessage = 'System is down. Please contact cheongwillie@gmail.com';
				}
			} else {
				$failmessage = 'Login credentials are incorrect. Please try again.';
			} //endif auth attempt
			return View::make('user/main')->with('failmessage', $failmessage);
		} //endif validation
	}
	
	public function getSignup(){
		return View::make('user/signup');
	}

	public function postSignup(){
		$retrieve = Input::all();
		$credentials = array(
			'email' => $retrieve['email'],
			'c_email' => $retrieve['c_email'],
			'password' => $retrieve['password'],
			'c_password' => $retrieve['c_password'],
			'display_name' => $retrieve['display_name']
		);
		
		
		$validator = Validator::make( $credentials,
			array(	'email' => 'required|email|unique:line_user,email',
					'c_email' => 'required|email|same:email',
					'password' => 'required',
					'c_password' => 'required|same:password',
					'display_name' => 'required|unique:line_user,display'
				)
		);
		
		if ( $validator->fails() ){
			return Redirect::to('user/signup')->withErrors($validator);
		} else {
			$user = ProSave::user( array('email' => $retrieve['email'],
										'password' => Hash::make($retrieve['password']),
										'display' => $retrieve['display_name'] ));

			//account has been created. 
			//Let's log this guy in right away.
			$credentials = array(
				'email' => $retrieve['email'],
				'password' => $retrieve['password']
			);
			if( Auth::attempt($credentials) ){
				if(Auth::check()){
					//success!
					return Redirect::to('/');
				} else {
					//session could not be created.
					return Redirect::to('user');
				}
			} else {
				return Redirect::to('user');
			} //endif auth attempt
		}
	}	
	
	public function getSignout(){
		Auth::logout();
		return Redirect::to('/');
	}	
	
}