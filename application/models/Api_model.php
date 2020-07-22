<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model  extends CI_Model {
    var $user_id;
    
    function __construct(){
        parent::__construct();
        $this->load->database();
        if ($this->ion_auth->logged_in()) $this->user_id = $this->ion_auth->user()->row()->id;
        else $this->user_id = 0;
    }
    
    /**
     * Get API Keys
     */
    function getApis()
    {
        $this->db->select('*');
        $this->db->from('api');
        $this->db->where('api.user_id', $this->user_id);
        $this->db->where('api.status', 1);
        $this->db->order_by('timestamp','desc');

        $query = $this->db->get()->result();
        return $query;
    }

    /**
     * Get Single API Key
     */
    function getApi($identifier,$key)
    {
        $this->db->select('*');
        $this->db->from('api');
        $this->db->where('api.identifier', $identifier);
        $this->db->where('api.key', $key);
        $this->db->where('api.status', 1);
        $this->db->order_by('timestamp','desc');

        $query = $this->db->get()->row();
        if (!empty($query)) return $query;
        else return false;
    }

    /**
     * Get Single API Key by ID
     */
    function getApiByID($id)
    {
        $this->db->select('*');
        $this->db->from('api');
        $this->db->where('api.user_id', $this->user_id);
        $this->db->where('api.id', $id);
        $this->db->where('api.status', 1);
        $this->db->order_by('timestamp','desc');

        $query = $this->db->get()->row();
        if (!empty($query)) return $query;
        else return false;
    }

    /**
     * Get API Keys
     */
    function deleteApi($id)
    {
        if(!$this->getApiByID($id))
        {
            return false;
        }
        else
        {
            $data = array(
                'status' => 0
            );
            $result = $this->db->update('api',$data,array('id' => $id));
            return $result;
        }
    }

    /**
     * Generate API Keys
     */
    function generateApi($identifier)
    {
        $data = array(
            'user_id'       => $this->user_id,
            'identifier'    => $identifier,
            'key'           => date('hmsYid').rand(100,999)
        );

        $result = $this->db->insert('api',$data);
        return $result;
    }
}