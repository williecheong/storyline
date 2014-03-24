<?php
class ProSave {
	
	static function user ( $user = array() ) {
		//user_id, email, password, display
		if ( isset($user['user_id']) ) {
			$user_obj = User::find( $user['user_id'] );
		} else {
			$user_obj = new User;
		}
		
		if ( isset($user['email']) ) {
			$user_obj->email = $user['email'];
		}
		
		if ( isset($user['password']) ) {
			$user_obj->password = $user['password'];
		}
		
		if ( isset($user['display']) ) {
			$user_obj->display = $user['display'];
		}
		
		$user_obj->save();
		
		return $user_obj;
		
	}
	
	static function story ( $story = array() ) {
		//stor_id, title, synopsis
		if ( isset($story['stor_id']) ) {
			//we want to update a story with this stor_id
			$story_obj = Story::find( $story['stor_id'] );
		} else {
			//create a new story object.
			$story_obj = new Story;
		}
		
		if ( isset($story['title']) ) {
			$story_obj->title = $story['title'];
		}
		
		if ( isset($story['synopsis']) ) {
			$story_obj->synopsis = $story['synopsis'];
		}
		

		$validation_passes = false ;
		if ( isset( $story['stor_id'] ) ) {
			$validation_passes = $story_obj->save( Story::rules_update($story['stor_id']) );
		} else {
			$validation_passes = $story_obj->save( Story::rules_create() );
		}

		if ( $validation_passes ) {
			return array( 
				'success' => true,
				'story' => $story_obj->toArray()
				);
		} else {
			return array(
				'success' => false,
				'messages'=> $story_obj->errors()->all()
				);	
		}
			
	}
	
	static function chapter ( $chapter = array() ) {
		//chap_id, stor_id, ordering, title
		if ( isset($chapter['chap_id']) ) {
			//we want to update a chapter with this chap_id
			$chapter_obj = Chapter::find( $chapter['chap_id'] );
		} else {
			//create a new chapter object.
			$chapter_obj = new Chapter;
		}
		
		if ( isset($chapter['stor_id']) ) {
			$chapter_obj->stor_id = $chapter['stor_id'];
		}
		
		if ( isset($chapter['ordering']) ) {
			$chapter_obj->ordering = $chapter['ordering'];
		}
		
		if ( isset($chapter['title']) ) {
			$chapter_obj->title = $chapter['title'];
		}
		
		$chapter_obj->save();
		
		return $chapter_obj;
		
	}
	
	static function paragraph ( $paragraph = array() ) {
		//para_id, chap_id, ordering, content
		if ( isset($paragraph['para_id']) ) {
			$paragraph_obj = Paragraph::find( $paragraph['para_id'] );
		} else {
			$paragraph_obj = new Paragraph;
		}
		
		if ( isset($paragraph['chap_id']) ) {
			$paragraph_obj->chap_id = $paragraph['chap_id'];
		}
		
		if ( isset($paragraph['ordering']) ) {
			$paragraph_obj->ordering = $paragraph['ordering'];
		}
		
		if ( isset($paragraph['content']) ) {
			$paragraph_obj->content = $paragraph['content'];
		}
		
		$paragraph_obj->save();
		
		return $paragraph_obj;
		
	}
	
	static function contribution ( $contribution = array() ) {
		//cont_id, para_id, user_id, status, description
		if ( isset($contribution['cont_id']) ) {
			$contribution_obj = Contribution::find($contribution['cont_id']);
		} else {
			$contribution_obj = new Contribution;
		}
		
		if ( isset($contribution['para_id']) ) {
			$contribution_obj->para_id = $contribution['para_id'];
		}
		
		if ( isset($contribution['user_id']) ) {
			$contribution_obj->user_id = $contribution['user_id'];
		}
		
		if ( isset($contribution['contype']) ) {
			$contribution_obj->contype = $contribution['contype'];
		}
		
		if ( isset($contribution['status']) ) {
			$contribution_obj->status = $contribution['status'];
		}
		
		if ( isset($contribution['description']) ) {
			$contribution_obj->description = $contribution['description'];
		}
		
		if ( isset($contribution['snapshot']) ) {
			$contribution_obj->snapshot = $contribution['snapshot'];
		}
		
		$contribution_obj->save();
		
		return $contribution_obj;
	
	}
	
	static function contributionpart ( $part = array() ) {
		//part_id, cont_id, edited_by, insdel, content
		if ( isset($part['part_id']) ) {
			$part_obj = ContributionPart::find($part['part_id']);
		} else {
			$part_obj = new ContributionPart;
		}
		
		if ( isset($part['cont_id']) ) {
			$part_obj->cont_id = $part['cont_id'];
		}
		
		if ( isset($part['edited_by']) ) {
			$part_obj->edited_by = $part['edited_by'];
		}
		
		if ( isset($part['insdel']) ) {
			$part_obj->insdel = $part['insdel'];
		}
		
		if ( isset($part['content']) ) {
			$part_obj->content = $part['content'];
		}
		
		$part_obj->save();
		
		return $part_obj;
		
	}

	static function feedback ( $feedback = array() ) {
		//id, email, message, url, ip_address
		if ( isset($feedback['id']) ) {
			$feedback_obj = Feedback::find($feedback['id']);
		} else {
			$feedback_obj = new Feedback;
		}
		
		if ( isset($feedback['email']) ) {
			$feedback_obj->email = $feedback['email'];
		}
		
		if ( isset($feedback['message']) ) {
			$feedback_obj->message = $feedback['message'];
		}
		
		if ( isset($feedback['url']) ) {
			$feedback_obj->url = $feedback['url'];
		}
		
		if ( isset($feedback['ip_address']) ) {
			$feedback_obj->ip_address = $feedback['ip_address'];
		}

		$feedback_obj->save();
		
		return $feedback_obj;
		
	}

}