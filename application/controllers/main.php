<?php // if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

    function __construct() {
        parent::__construct();
        // Autoloaded Config, Helpers, Models 
    }
    
	public function index() {
        $data = array();
        $user_email = $this->session->userdata('email');
        
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
        
        // Send the resulting data array into the view
        $this->blade->render('main', 
            array(
                'user_email' => $user_email,
                'chapters' => $chapters,
                'story' => Story::find($sid)->toArray()
            )
        );
    }
}