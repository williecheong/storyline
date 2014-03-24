<?php

class ReadController extends BaseController {
	
	//THIS CONTROLLER SERVES STORY RELATED FUNCTIONS FOR GUESTS
	public function __construct(){
	}
	
	public function getIndex(){

		$stories = User::find(1)->directing->toArray();		
		return View::make('guest/story/main')
			->with(array(
				'stories' => $stories
			));
	}
	
	public function readSingle($sid){
		
		$user_id = 0;
		if( Auth::check() ) {
			$user_id = Auth::user()->user_id;
		} 
		
		$chapters = Story::find($sid)->chapters ; 
		
		//removes all chapters with nothing to display
		foreach ( $chapters as $ckey => $chapter ) {
			$chap_display = '';

			$paragraphs = Chapter::find($chapter['chap_id'])->paragraphs;
			$chapters[$ckey]['paragraphs'] = $paragraphs;
			
			//removes all paragraphs with nothing to display
			foreach ( $paragraphs as $pkey => $paragraph ) {
				$paragraphs[$pkey] = $paragraph;
				
				$para_display = EasyParagraph::htmlreadify( EasyParagraph::untrack($paragraph['content']) );
				if ( strlen($para_display) === 0 ) {
					unset( $paragraphs[$pkey] );
						
				} else {
					//fills up the chapter display for evaluation after this loop ends
					$chap_display = $chap_display . $para_display;
				}
			}
			if ( strlen($chap_display) === 0 ) {
				unset( $chapters[$ckey] );
			}
			
		}
		
		return View::make('guest/story/single')
			->with(array(
				'user_id' => $user_id,
				'chapters' => $chapters,
				'story' => Story::find($sid)->toArray()
			));
	}
	
	
}