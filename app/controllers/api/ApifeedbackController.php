<?php

class ApifeedbackController extends BaseController {

	//THIS RESOURCE CONTROLLER SERVES FUNCTIONS FOR FEEDBACK
	
	/*
	public function __construct(){
	}

	public function index() {

	}

	public function create() {

	}
	*/

	public function store() {
		$retrieve = Input::all();
		$retrieve['ip_address'] = $_SERVER['REMOTE_ADDR'];

		$feedback = ProSave::feedback( $retrieve );

		return json_encode( array('status' => 'success') );
	}

	/* Perhaps someday in the near future
	//when we decide we want to have an admin for managing feedbacks
	public function show( $id = 0 ) {

	}

	public function edit( $id = 0 ) {

	}

	public function update( $id = 0 ) {

	}

	public function destroy( $id = 0 ) {

	}
	*/
}