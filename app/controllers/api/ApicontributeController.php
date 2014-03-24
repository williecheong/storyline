<?php

class ApicontributeController extends BaseController {
	public function __construct(){
		$this->beforeFilter(function(){
			if( Auth::guest() ){
				return json_encode( array( 'status' => 'noSession' ) );
			}
		});
	}
	
	public function postChapter(){
		$retrieve = Input::all();
		$return_object = array();
		
		$chapter = Chapter::where('stor_id', '=', $retrieve['stor_id'])
							->where('ordering', '=', $retrieve['chap_ordering'])
							->first();

		if ( empty($chapter->chap_id) ) {
			//no such chapter yet. Let's do an insert for this chapter.
			$chapter = ProSave::chapter( array(	'stor_id' => $retrieve['stor_id'],
												'ordering' => $retrieve['chap_ordering'] ));			
		} //now $chapter will contain the chapter we want
		
		
		//since this is a new chapter, the para_ordering will always be 1
		$paragraph = Paragraph::where('chap_id', '=', $chapter['chap_id'])
								->where('ordering', '=', 10000)
								->first();
		
		if ( empty($paragraph->para_id) ) {
			//no such paragraph exists 
			//Let's do an insert for this paragraph
			$paragraph = ProSave::paragraph( array(	'chap_id' => $chapter->chap_id,
													'ordering' => 10000	));			
		} //now $paragraph will contain the paragraph we want
		
		//let's save in this contribution now.
		$contribution = ProSave::contribution( array(	'para_id' => $paragraph->para_id,
														'user_id' => Auth::user()->user_id,
														'contype' => 'New Chapter',
														'status' => 1,
														'description' => $retrieve['cont_desc'] ));
								
		foreach( $retrieve['content'] as $change ) {
			if ( array_key_exists('added', $change) ) {
				//this is an addition.		
				$contribution_part = ProSave::contributionpart(array('cont_id' => $contribution->cont_id,
																	'edited_by' => 1,
																	'content' => EasyText::singlespaces( 
																			EasyText::nolines( $change['value'] ) ),
																	'insdel' => 1 ));
				//now to append the insert into the paragraph
				$paragraph = ProSave::paragraph( array(	'para_id' => $paragraph->para_id,
														'content' => $paragraph->content . '@' . $contribution_part->part_id . '@ ' ));
				$return_object['status'] = 'success';			
			
			} else if ( array_key_exists('removed', $change) ) {
				//for new chapters, deletions should never be called.
				$return_object['status'] = 'Making a new chapter. Why is there a deletion?';
			} else {
				//for new chapters, unchanged should never be called.
				$return_object['status'] = 'Making a new chapter. Why is there unchanged text?';
			}
		}
		
		return json_encode( $return_object );
	}
	
	public function postParagraph(){
		$retrieve = Input::all();
		$return_object = array();
		
		$paragraph = Paragraph::where('chap_id', '=', $retrieve['chap_id'])
								->where('ordering', '=', $retrieve['para_ordering'] ) 
								->first();
		
		if ( empty($paragraph->para_id) ) {
			//no such paragraph exists 
			//Let's do an insert for this paragraph
			$paragraph = ProSave::paragraph( array(	'chap_id' => $retrieve['chap_id'],
													'ordering' => $retrieve['para_ordering'] ));
		} //now $paragraph will contain the paragraph we want
		
		$contribution = ProSave::contribution( array('para_id' => $paragraph->para_id,
													'user_id' => Auth::user()->user_id,
													'contype' => 'New Paragraph',
													'status' => 1,
													'description' => $retrieve['cont_desc'] ));
		
		foreach( $retrieve['content'] as $change ) {
			if ( array_key_exists('added', $change) ) {
				//this is an addition.		
				$contribution_part = ProSave::contributionpart(array('cont_id' => $contribution->cont_id,
																	'edited_by' => 1,
																	'content' => EasyText::singlespaces( 
																			EasyText::nolines( $change['value'] ) ),
																	'insdel' => 1 ));
				//now to append the insert into the paragraph
				$paragraph = ProSave::paragraph( array(	'para_id' => $paragraph->para_id,
														'content' => $paragraph->content . '@' . $contribution_part->part_id . '@ ' ));
				$return_object['status'] = 'success';			
			
			} else if ( array_key_exists('removed', $change) ) {
				//for new paragraphs, deletions should never be called.
				$return_object['status'] = 'Making a new paragraph. Why is there a deletion?';
			} else {
				//for new paragraphs, unchanged should never be called.
				$return_object['status'] = 'Making a new paragraph. Why is there unchanged text?';		
			}
		}
		
		return json_encode( $return_object );
	}
	
	public function putParagraph(){
		$retrieve = Input::all();
		$return_object = array();
		
		$paragraph = Paragraph::where('para_id', '=', $retrieve['para_id']) 
								->first();
		
		// let's break down the paragraph into
		// an array of words that ignore tracktags
		// real words get int keys, tracktags get char keys
		$text_array = preg_replace('/\s+/', ' ', $paragraph->content);
		$text_array = trim( $text_array );
		$text_array = explode(' ', $text_array);
		$temp_array = array();
		
		$counter = 0;
		$pseudokey = 'a';
		foreach ($text_array as $key => $word) {
			if ( preg_match('/@[0-9]+/',$word) 
			|| preg_match('/{[0-9]+/',$word)
			|| preg_match('/[0-9]+}/',$word) ) {
				$temp_array[$pseudokey] = $word;
				$pseudokey++;
			} else {
				$temp_array[$counter] = $word;
				$counter++;
			}
		}
		$text_array = $temp_array;
		
		//now let's make a contribution for this insert
		$contribution = ProSave::contribution( array('para_id' => $retrieve['para_id'],
													'user_id' => Auth::user()->user_id,
													'contype' => 'Edit',
													'status' => 1,
													'description' => $retrieve['cont_desc'] ));		
		$wordcount = 0;
		foreach ( $retrieve['content'] as $change ) {
			//if this is an empty change, ignore it with continue.
				$value = trim(preg_replace('/\s+/', ' ', $change['value']) );
				if ( $value === '' ) continue;
			
			//else do all the following:
			$value_count = count(explode(' ', $value ) ); 
			
			if ( array_key_exists('added', $change) ) {
				//this is an addition.		
				$contribution_part = ProSave::contributionpart(array('cont_id' => $contribution->cont_id,
																	'edited_by' => 1,
																	'content' => $change['value'],
																	'insdel' => 1 ));
				if ( array_key_exists($wordcount, $text_array) ) {
					$text_array[$wordcount] = '@'.$contribution_part->part_id.'@ '.$text_array[$wordcount];
				} else {
					$text_array[$wordcount] = '@'.$contribution_part->part_id.'@ ';
				}
				
			} else if ( array_key_exists('removed', $change) ) {
				//this is a deletion.
				$contribution_part = ProSave::contributionpart(array('cont_id' => $contribution->cont_id,
																	'edited_by' => 1,
																	'content' => $change['value'],
																	'insdel' => 0 ));;
				$text_array[$wordcount] = '{'.$contribution_part->part_id.'{ '.$text_array[$wordcount];
				$wordcount = $wordcount + $value_count;
				if ( array_key_exists($wordcount, $text_array) ) {
					$text_array[$wordcount] = '}'.$contribution_part->part_id .'} '.$text_array[$wordcount]; 
				} else {
					$text_array[$wordcount] = '}'.$contribution_part->part_id .'} ';
				}
			} else {
				//this is just unchanged text
				$wordcount = $wordcount + $value_count;
			}
		}
		
		$newpara_content = implode(' ', $text_array);
		$paragraph = ProSave::paragraph( array(	'para_id' => $retrieve['para_id'],
												'content' => EasyText::singlespaces( 
														EasyText::nolines( $newpara_content ) ) ));

		$return_object['status'] = 'success';
		
		return json_encode( $return_object );
	}
}

