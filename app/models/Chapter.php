<?php

class Chapter extends Eloquent {

	protected $table = 'line_chapter';
	protected $primaryKey = 'chap_id';	
	
	public function story(){
		return $this->belongsTo('Story', 'stor_id');
	}
	
	public function paragraphs(){
		return $this->hasMany('Paragraph', 'chap_id')->orderby('ordering', 'asc');
	}
	
}