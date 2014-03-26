<?php   
    //makes an untracked paragraph easy to read in plain text
    function textreadify ( $paragraph ) {
    
        $paragraph = EasyText::singlelines( $paragraph );
        $paragraph = EasyText::singlespaces ( $paragraph );
        
        return trim($paragraph);
    }
    
    //makes an untracked paragraph easy to read on html
    function htmlreadify ( $paragraph ) {
        
        $paragraph = EasyText::singlelines( $paragraph );
        $paragraph = EasyText::singlespaces ( $paragraph );
        $paragraph = EasyText::htmlbreaks ( $paragraph );
        
        return trim($paragraph);
    }
    
    //use this for removing specific part trackers from a paragraph
    //good for using when rejecting a contribution.
    function removePart( $paragraph = '' , $part = array() ) {
        if ( $part['insdel'] === 1 ) { //part is specifying an insert
            $paragraph = preg_replace('/@'.$part['part_id'].'@/', '', $paragraph);
        } else { // part is specifying a delete
            $paragraph = preg_replace('/{'.$part['part_id'].'{/', '', $paragraph);
            $paragraph = preg_replace('/}'.$part['part_id'].'}/' , '', $paragraph);
        }
        return $paragraph;
    }

    //use this for appending changes into a paragraph.
    //tagged change to make CSS-ify paragraph.
    //tagged false to make change look as if it is for real
    function appendChange( $paragraph = '' , $part = array(), $tagged = true ) {
        
        if ($part['insdel'] === 1 ) { //this is an insert..
            if ( $tagged ) { //we want CSS
                $paragraph = preg_replace('/@'.$part['part_id'].'@/', '<ins>'.$part['content'].'</ins>', $paragraph);
            } else { //nope, no css
                $paragraph = preg_replace('/@'.$part['part_id'].'@/', $part['content'], $paragraph);                
            }
            
        } else { //this is a delete
            if ( $tagged ) { //we want CSS
                $paragraph = preg_replace('/{'.$part['part_id'].'{/', '<del>', $paragraph);
                $paragraph = preg_replace('/}'.$part['part_id'].'}/' , '</del>', $paragraph);
            } else { //nope, no css
                
                //first we get the deletion piece, inclusive of it's own tracker
                $wrapped = null;
                $returnValue1 = preg_match('/{'.$part['part_id'].'{'. '.+' .'}'.$part['part_id'].'}/', $paragraph, $wrapped);

                //then we dig out all the trackers inside and then remove the first and last tracker (self)
                $nestedTrackers = null;
                $returnValue2 = preg_match_all('/@[0-9]+@|{[0-9]+{|}[0-9]+}/', $wrapped[0], $nestedTrackers);

                $nestedTrackers = array_slice($nestedTrackers[0], 1, -1);

                //join the above trackers into a string seperated by space and use it to replace the deleted section.
                $paragraph = preg_replace('/{'.$part['part_id'].'{'. '.+' .'}'.$part['part_id'].'}/', ' '.implode(' ', $nestedTrackers).' ', $paragraph);           
            }
        }

        return $paragraph;
    }
    
    //use this for making a raw paragraph readable
    function untrack( $paragraph ) {
        //remove insertions
        $paragraph = preg_replace('/@[0-9]+@/', '', $paragraph);
        
        //remove deletions, head first then the tail.
        $paragraph = preg_replace('/{[0-9]+{/', '', $paragraph);
        $paragraph = preg_replace('/}[0-9]+}/', '', $paragraph);
        
        return $paragraph;
    }

    //use this for making a string of words nice to read.
    function htmlbreaks ( $input ){
        //turns nextlines into a html line breakers
        $input = preg_replace('/\n/', '<br>', $input);
        return $input;
    }
    
    function singlelines ( $input ) {
        //every time 3 or more line breaks are found, 
        //replace them with 2 line breaks
        $input = preg_replace('/(\r\n){3,}/', '\r\n\r\n', trim($input));
        return $input;
    }
    
    function nolines ( $input ) {
        //every time 3 or more line breaks are found, 
        //replace them with 2 line breaks
        $input = preg_replace('/\n/', ' ', trim($input));
        return $input;
    }

    function singlespaces ( $input ) {
        // Reduces all multiple spaces into single space
        // Then trim to take away any head/tail space.
        $input = preg_replace('/ +/', ' ', $input);
        $input = trim($input);
        return $input;
    }
    
    function makedate ( $sqlts ) {
        return date("j M'y", strtotime( $sqlts ) );

    }
    
    function esc_doublequote ( $input ) {
        //use this to escape double quotes into code
        //be sure to invoke this before inserting content into html attribute   
        return str_replace('"', '&#34;', $input);
    }