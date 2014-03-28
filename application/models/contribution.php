<?php

class contribution extends CI_Model{

    // BEGIN BASIC CRUD FUNCTIONALITY

    function create( $data = array() ){
        $this->db->insert('contribution', $data);    
        return $this->db->insert_id();
    }

    function retrieve( $data = array() ){
        $this->db->where($data);
        $query = $this->db->get('contribution');
        return $query->result();
    }
    
    function update( $criteria = array(), $new_data = array() ){
        $this->db->where($criteria);
        $this->db->update('contribution', $new_data);
    }
    
    function delete( $data = array() ){
        $this->db->where($data);
        $this->db->delete('contribution');
    }

}

?>