<?php

class Contribution extends Eloquent {

	protected $table = 'line_contribution';
	protected $primaryKey = 'cont_id';	

	public function author(){
		return $this->belongsTo('User', 'user_id');
	}
	
	public function paragraph(){
		return $this->belongsTo('Paragraph', 'para_id');
	}
	
	public function contributionparts(){
		//we always handle the deletes first then followed by the inserts.
		return $this->hasMany('ContributionPart', 'cont_id')->orderby('insdel', 'asc');
	}
	
}