<?php

class ApimoderateController extends BaseController {
	public function __construct(){
		$this->beforeFilter(function(){
			if( Auth::guest() ){
				return json_encode( array( 'status' => 'noSession' ) );
			}
		});
	}	

	public function postMerge(){
		$retrieve = Input::all();
		$paragraph = Contribution::find($retrieve['cont_id'])->paragraph;
		//todo: validate user is allowed to perform merge. 
		
		$newtext = $paragraph['content'];
		$snapshot = $paragraph['content'];
		$cont_parts = Contribution::find($retrieve['cont_id'])->contributionparts;
		foreach ( $cont_parts as $part ) {
			$snapshot = EasyParagraph::appendChange($snapshot, $part, true);
			$newtext = EasyParagraph::appendChange($newtext, $part, false);
		}
		
		//update the paragraph with the newly appended texts
		$newpara = ProSave::paragraph( array('para_id' => $paragraph['para_id'],
											'content' => $newtext ));
		
		//update the status of the contribution to 2: Approved
		$newcont = ProSave::contribution( array('cont_id' => $retrieve['cont_id'],
												'status' => 2, 
												'snapshot' => EasyParagraph::htmlreadify( 
																EasyParagraph::untrack($snapshot) 
															)));
		
		$return_object['status'] = 'success';
		
		return json_encode( $return_object );
	}
	
	public function postRetire(){
		$retrieve = Input::all();
		$paragraph = Contribution::find($retrieve['cont_id'])->paragraph;
		//todo: validate user is allowed to perform merge. 
		
		$newtext = $paragraph['content'];
		$snapshot = $paragraph['content'];
		$cont_parts = Contribution::find($retrieve['cont_id'])->contributionparts;
		foreach ( $cont_parts as $part ) {
			$snapshot = EasyParagraph::appendChange($snapshot, $part, true);
			$newtext = EasyParagraph::removePart($newtext, $part, false);
		}
		
		//update the paragraph with the newly appended texts
		$newpara = ProSave::paragraph( array('para_id' => $paragraph['para_id'],
											'content' => $newtext ));
		
		//update the status of the contribution to 3: Rejected
		$newcont = ProSave::contribution( array('cont_id' => $retrieve['cont_id'],
												'status' => 3, 
												'snapshot' => EasyParagraph::htmlreadify( 
																EasyParagraph::untrack($snapshot) 
															)));
		
		$return_object['status'] = 'success';
		
		return json_encode( $return_object );
	}
}