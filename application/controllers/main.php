<?php // if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

    function __construct() {
        parent::__construct();
        // Autoloaded Config, Helpers, Models 
    }
    
	public function index() {
        $data = array();
        $user_email = $this->session->userdata('email');
        
        $chapters = (array) $this->chapter->retrieve();
        $chapters = $chapters;
        //removes all chapters with nothing to display
        foreach ( $chapters as $chapter_key => $chapter ) {
            $chapter_display = '';

            $paragraphs = (array) $this->paragraph->retrieve( array('chapter_id'=>$chapter->id) );
            $chapters[$chapter_key]->paragraphs = $paragraphs;
            
            //removes all paragraphs with nothing to display
            foreach ( $paragraphs as $paragraph_key => $paragraph ) {
                $paragraphs[$paragraph_key] = $paragraph;
                
                $paragraph_display = htmlreadify( untrack($paragraph->content) );
                if ( strlen($paragraph_display) === 0 ) {
                    unset( $paragraphs[$paragraph_key] );
                        
                } else {
                    //fills up the chapter display for evaluation after this loop ends
                    $chapter_display = $chapter_display . $paragraph_display;
                }
            }
            if ( strlen($chapter_display) === 0 ) {
                unset( $chapters[$chapter_key] );
            }
            
        }
        
        // Send the resulting data array into the view
        $this->blade->render('main', 
            array(
                'user_email' => $user_email,
                'chapters'   => $chapters,
                'settings'   => $this->setting->retrieve_pairs()
            )
        );
    }
}