<?php

class EasyText {
	
	//use this for making a string of words nice to read.
	static function htmlbreaks ( $input ){
		//turns nextlines into a html line breakers
		$input = preg_replace('/\n/', '<br>', $input);
		return $input;
	}
	
	static function singlelines ( $input ) {
		//every time 3 or more line breaks are found, 
		//replace them with 2 line breaks
		$input = preg_replace('/(\r\n){3,}/', '\r\n\r\n', trim($input));
		return $input;
	}
	
	static function nolines ( $input ) {
		//every time 3 or more line breaks are found, 
		//replace them with 2 line breaks
		$input = preg_replace('/\n/', ' ', trim($input));
		return $input;
	}

	static function singlespaces ( $input ) {
		// Reduces all multiple spaces into single space
		// Then trim to take away any head/tail space.
		$input = preg_replace('/ +/', ' ', $input);
		$input = trim($input);
		return $input;
	}
	
	static function makedate ( $sqlts ) {
		return date("j M'y", strtotime( $sqlts ) );

	}
	
	static function esc_doublequote ( $input ) {
		//use this to escape double quotes into code
		//be sure to invoke this before inserting content into html attribute	
		return str_replace('"', '&#34;', $input);
	}
	
}