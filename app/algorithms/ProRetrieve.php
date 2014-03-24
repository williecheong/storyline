<?php
class ProRetrieve {
	
	//acceptable $id = any int corresponding to a stor_id
	//acceptable $order = 'desc' | 'asc'
	static function contributionsByStory ( $id = 0 , $order = 'desc' ) {
		$contributions = array();
		$contributions = DB::table('line_contribution')
							->join('line_paragraph', 'line_paragraph.para_id', '=', 'line_contribution.para_id')
							->join('line_chapter', 'line_chapter.chap_id', '=', 'line_paragraph.chap_id')
							->join('line_story', 'line_story.stor_id', '=', 'line_chapter.stor_id')
							->where('line_story.stor_id', '=', $id )
							->orderBy('line_contribution.updated_at', $order)
							->select('cont_id', 'line_contribution.para_id', 'user_id', 'contype', 'status', 'description', 
								'snapshot', 'line_contribution.created_at', 'line_contribution.updated_at')
							->get();
		return $contributions;
	}

	//retrieves an array containing the story 
	//that this contribution ID belongs to
	static function storyByContribution ( $id = 0 ) {
		$story = array();
		
		$paragraph = Contribution::find($id)->paragraph->toArray();
		$chapter = Paragraph::find( $paragraph['para_id'] )->chapter->toArray();
		$story = Chapter::find( $chapter['chap_id'] )->story->toArray();

		return $story;
	}

}