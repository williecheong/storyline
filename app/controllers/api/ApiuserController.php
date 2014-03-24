<?php

class ApiuserController extends BaseController {
	public function __construct(){
		$this->beforeFilter(function(){
			if( Auth::guest() ){
				return Redirect::to('user');
			}
		});
	}

	public function putSettings(){

		$retrieve = Input::all();
		$return_object = array();

		$credentials = array(
			'password' => $retrieve['password'],
			'c_password' => $retrieve['c_password']
		);
		
		
		$validator = Validator::make( $credentials,
			array(	'password' => 'required',
					'c_password' => 'required|same:password'
				)
		);
		
		
		if ( $validator->fails() ){
			
			$messages = $validator->messages();
			
			$return_object['fail_1'] = $messages->first('password');
			$return_object['fail_2'] = $messages->first('c_password');

			
			return json_encode( $return_object );

		
		} 
		else {
			$user = ProSave::user( array('password' => Hash::make($retrieve['password']),
											'user_id' => Auth::user()->user_id));
		}
		
		$return_object['status'] = 'success';
		return json_encode( $return_object );
		

	}
	
}