<?php

class Paragraph extends Eloquent {

	protected $table = 'line_paragraph';
	protected $primaryKey = 'para_id';	
	
	public function chapter(){
		return $this->belongsTo('Chapter', 'chap_id');
	}
	
	public function contributions(){
		return $this->hasMany('Contribution', 'para_id')->orderby('updated_at', 'desc');
	}
	
}