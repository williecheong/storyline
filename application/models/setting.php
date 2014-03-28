<?php

class setting extends CI_Model{

    function retrieve_pairs( $data = array() ) {
        $temp_settings = $this->setting->retrieve($data);
        $settings = array();
        foreach( $temp_settings as $setting ){
            $settings[$setting->key] = $setting->value;
        }
        
        return $settings;
    }

    // BEGIN BASIC CRUD FUNCTIONALITY

    function create( $data = array() ){
        $this->db->insert('setting', $data);    
        return $this->db->insert_id();
    }

    function retrieve( $data = array() ){
        $this->db->where($data);
        $query = $this->db->get('setting');
        return $query->result();
    }
    
    function update( $criteria = array(), $new_data = array() ){
        $this->db->where($criteria);
        $this->db->update('setting', $new_data);
    }
    
    function delete( $data = array() ){
        $this->db->where($data);
        $this->db->delete('setting');
    }

}

?>