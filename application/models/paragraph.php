<?php

class paragraph extends CI_Model{

    // BEGIN BASIC CRUD FUNCTIONALITY

    function create( $data = array() ){
        $this->db->insert('paragraph', $data);    
        return $this->db->insert_id();
    }

    function retrieve( $data = array() ){
        $this->db->where($data);
        $this->db->order_by('ordering', 'asc');
        $query = $this->db->get('paragraph');
        return $query->result();
    }
    
    function update( $criteria = array(), $new_data = array() ){
        $this->db->where($criteria);
        $this->db->update('paragraph', $new_data);
    }
    
    function delete( $data = array() ){
        $this->db->where($data);
        $this->db->delete('paragraph');
    }

}

?>