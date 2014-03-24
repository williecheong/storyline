<?php

class ContributionPart extends Eloquent {

	protected $table = 'line_contribution_part';
	protected $primaryKey = 'part_id';	

	public function editedby(){
		return $this->belongsTo('User', 'edited_by');
	}
	
	public function contribution(){
		return $this->belongsTo('Contribution', 'cont_id');
	}
	
}