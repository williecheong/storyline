<?php

class ApimanageController extends BaseController {
	public function __construct(){
		$this->beforeFilter(function(){
			if( Auth::guest() ){
				return json_encode( array( 'status' => 'noSession' ) );
			}
		});
	}
	
	public function getIndex(){
		return Redirect::to('/');
	}
	
	public function postStory(){

		$retrieve = Input::all();
		
		//insert the new story that was posted.
		$results = ProSave::story( array('title' => EasyText::singlespaces( $retrieve['title'] ),
										'synopsis' => EasyText::singlespaces( $retrieve['synopsis'] )));
		
		if ( $results['success'] ) {
			$story = $results['story'];
			$id = $story['stor_id'];
			
			//link the story to the creator as director
			$user = User::find( Auth::user()->user_id );
			$user->directing()->attach($id);	
			
			$return_object = array( 
				'status' => 'success',
				'story'	 => Story::where( 'stor_id', '=', $id )->first()->toArray()
				);
		
			return json_encode( $return_object );
		
		} else {
			$return_object = array(
				'status' => 'fail',
				'messages' => $results['messages']
				);

			return json_encode ( $return_object );
		}
			
	}
	
	public function putStory(){
		$retrieve = Input::all();
		
		//insert the new story that was posted.
		$results = ProSave::story( array('stor_id' => $retrieve['id'],
										'title' => EasyText::singlespaces( $retrieve['title'] ),
										'synopsis' => EasyText::singlespaces( $retrieve['synopsis'] ) 
									));
		
		if ( $results['success'] ) {
			$return_object = array( 
				'status' => 'success',
				'story'	 => $results['story']
				);
			
			return json_encode( $return_object );
		
		} else {
			$return_object = array(
				'status' => 'fail',
				'messages' => $result['messages']
				);

			return json_encode ( $return_object );

		}			
	}

}