<?php

use LaravelBook\Ardent\Ardent;

class Story extends Ardent {

	protected $table = 'line_story';
	protected $primaryKey = 'stor_id';	
	
	public function directors(){
		return $this->belongsToMany('User', 'rshp_director', 'stor_id', 'user_id');
	}
	
	public function chapters(){
		return $this->hasMany('Chapter', 'stor_id')->orderby('ordering', 'asc');
	}
	
	public static function rules_create(){
		return array(
				'title' => 'required|min:1|max:100|unique:line_story,title',
				'synopsis' => 'required'
			);
	}

	public static function rules_update( $stor_id = 0 ){
		return array(
				'title' => 'min:1|max:100|unique:line_story,title,'.$stor_id.',stor_id',
				'synopsis' => ''
			);
	}
	
}