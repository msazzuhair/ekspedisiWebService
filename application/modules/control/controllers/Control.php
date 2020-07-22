<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control extends MX_Controller {
	
	public $data = [];

	public function __construct()
	{
		parent::__construct();

		// Set user data
		if ($this->ion_auth->logged_in())
		{
			$this->load->database();
			$this->load->model('api_model');
			
			$user = $this->ion_auth->user()->row();
			$this->data['username']		= htmlspecialchars($user->username,ENT_QUOTES,'UTF-8');
			$this->data['full_name']	= htmlspecialchars($user->first_name.(!empty($user->last_name) ? ' '.$user->last_name : ''),ENT_QUOTES,'UTF-8');
		}
		else
		{
			redirect('auth/login', 'refresh');
		}
	}
	
	public function index()
	{
		$this->data['apis'] = $this->api_model->getApis();
		$this->load->view('tabel', $this->data);
	}

	public function generate_api()
	{
		$config = array(
			array(
				'field' => 'identifier',
				'label' => 'identifier',
				'rules' => 'required|alpha_numeric'
			)
		);
		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('generate', $this->data);
		}
		else
		{
				$identifier = $_POST['identifier'];
				$api = $this->api_model->generateApi($identifier);
				redirect(site_url('control'));
		}
	}

	public function delete_api()
	{
		$id = (int) $this->input->get('id', true);

		if(!$data = $this->api_model->deleteApi($id))
		{
			echo '<script>alert("Gagal menghapus api")</script>';
			redirect(site_url('control'));
		}
		else
		{
			redirect(site_url('control'));
		}
	}
}
