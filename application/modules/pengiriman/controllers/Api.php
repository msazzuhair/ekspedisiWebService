<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Api extends RestController {

	function __construct()
    {
        // Construct the parent class
		parent::__construct();
        $this->load->database();
        $this->load->model('api_model');
        $this->load->model('pengiriman_model');
	}
	
	public function index_get()
	{
		$id = trim($this->get('resi'));
        if ($id == '') {
            $this->response(false, 404);
        } else {
            if ($result = $this->pengiriman_model->getRiwayatByResi($id))
                $this->response($result, 200);
            else $this->response(false, 500);
        }
        $this->response(false, 404);
	}

	public function send_post()
	{
        $identifier = $this->post('identifier');
        $key        = $this->post('key');
        if ($auth = $this->api_model->getApi($identifier,$key))
        {
            $data = (array) json_decode($this->post('data'));
            if (!empty($data) && $resi = $this->pengiriman_model->addBarang($data))
            {
                $this->response($resi, 200);
            }
            else $this->response(false,500);
        }
        else $this->response(false,404);
	}
}
