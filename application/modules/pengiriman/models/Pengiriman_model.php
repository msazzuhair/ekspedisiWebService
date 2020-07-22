<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengiriman_model extends CI_Model {
    var $user_id;
    
    function __construct(){
        parent::__construct();
        $this->load->database();
        if ($this->ion_auth->logged_in()) $this->user_id = $this->ion_auth->user()->row()->id;
        else $this->user_id = 0;
    }
    
    /**
     * Mengambil data barang dari database, dengan limit dan page
     * @param int   $limit Limit number of data in a page
     * @param int   $limit Offset number of data in a page
     * @return array|bool Satu baris detail barang
     */
    function getBarang($limit, $page)
    {
        $offset = ($page - 1) * $limit;
        $this->db->select('*');
        $this->db->from('pengiriman');
        $this->db->order_by('timestamp','desc');
        $this->db->limit($limit, $offset);

        $query = $this->db->get()->result();
        
        foreach ($query as $k => $v)
        {
            $query[$k]->riwayat = $this->getRiwayat($v->id);
            $query[$k]->riwayat[] = (object) array(
                'status' => 'Diproses',
                'waktu' => $v->timestamp
            );
        }

        return $query;
    }

    /**
     * Mengambil detail info barang dari database
     * @param int   $id ID barang
     * @return array|bool Satu baris detail barang
     */
    function getBarangDetails($id)
    {
        $this->db->select('*');
        $this->db->from('pengiriman');
        $this->db->where('pengiriman.id', $id);
        $this->db->order_by('timestamp','desc');

        $query = $this->db->get()->row();
        if (!empty($query)) return $query;
        else return false;
    }

    /**
     * Mengambil detail info barang dari database
     * @param int   $id ID barang
     * @return array|bool Satu baris detail barang
     */
    function getBarangDetailsByResi($id)
    {
        $this->db->select('*');
        $this->db->from('pengiriman');
        $this->db->where('pengiriman.resi', $id);
        $this->db->order_by('timestamp','desc');

        $query = $this->db->get()->row();
        if (!empty($query)) return $query;
        else return false;
    }

    function getPages($limit)
    {
        $this->db->select('*');
        $this->db->from('pengiriman');

        $query = $this->db->get()->result();
        $maxPage = ceil((double) count($query) / $limit);
        return $maxPage;
    }

    function getRiwayat($id)
    {
        $this->db->select('status_pengiriman.description as status, pengiriman_status.timestamp as waktu');
        $this->db->from('pengiriman_status');
        $this->db->join('status_pengiriman', 'pengiriman_status.status_pengiriman_id = status_pengiriman.id');
        $this->db->where('pengiriman_status.pengiriman_id', $id);
        $this->db->order_by('timestamp','desc');

        $query = $this->db->get()->result();
        return $query;
    }

    function getRiwayatByResi($id)
    {
        $this->db->select('status_pengiriman.description as status, pengiriman_status.timestamp as waktu');
        $this->db->from('pengiriman');
        $this->db->join('pengiriman_status', 'pengiriman_status.pengiriman_id = pengiriman.id','left');
        $this->db->join('status_pengiriman', 'pengiriman_status.status_pengiriman_id = status_pengiriman.id','left');
        $this->db->where('pengiriman.resi', $id);
        $this->db->order_by('pengiriman_status.timestamp','desc');

        $query = $this->db->get()->result();
        
        if (!empty($query))
        {
            $query[] = (object) array(
                'status' => 'Diproses',
                'waktu' => $this->getBarangDetailsByResi($id)->timestamp
            );

            if ($query[0]->status == null)
            {
                unset($query[0]);
                $query = array_values($query);
            }
        } 

        if (!empty($query)) return $query;
        else return false;
    }

    function getRiwayatLast($id)
    {
        $this->db->select('status_pengiriman.description as status, pengiriman_status.timestamp as waktu');
        $this->db->from('pengiriman_status');
        $this->db->join('status_pengiriman', 'pengiriman_status.status_pengiriman_id = status_pengiriman.id');
        $this->db->where('pengiriman_status.pengiriman_id', $id);
        $this->db->order_by('timestamp','desc');

        $query = $this->db->get()->row();
        if (!empty($query)) return $query;
        else return false;
    }

    function addBarang($data)
    {
        $data['resi'] = date('siHYdm').rand(100,999);
        $result = $this->db->insert('pengiriman',$data);
        return $result ? $data['resi'] : false;
    }

    function kirimBarang($id)
    {
        if(!$this->getBarangDetails($id))
        {
            return false;
        }
        else
        {
            if (!$this->getRiwayatLast($id))
            {
                // Insert data
                $data = array(
                    'pengiriman_id' => $id,
                    'status_pengiriman_id'=> 1
                );
                $result = $this->db->insert('pengiriman_status',$data);
                
                return $result;
            }
            else return false;
        }
    }

    function terimaBarang($id)
    {
        if(!$this->getBarangDetails($id))
        {
            return false;
        }
        else
        {
            if ($this->getRiwayatLast($id) && $this->getRiwayatLast($id)->status == 'Dikirim')
            {
                // Insert data
                $data = array(
                    'pengiriman_id' => $id,
                    'status_pengiriman_id'=> 2
                );
                $result = $this->db->insert('pengiriman_status',$data);
                
                return $result;
            }
            else return false;
        }
    }
}