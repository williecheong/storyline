<?php
class ProCheck {
	
	static function isDirector ($stor_id = 0) {
		$directors = Story::find($stor_id)->directors;
		$cur_user_id = Auth::user()->user_id;
		
		$authorized = false;
		foreach($directors as $director) {
			if ( $cur_user_id === $director->user_id ) {
				$authorized = true;
			}
		}
		
		return $authorized;
	}
	
	
	
}