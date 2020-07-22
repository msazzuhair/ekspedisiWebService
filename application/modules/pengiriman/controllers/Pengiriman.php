<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengiriman extends MX_Controller {
	
	public $data = [];

	public function __construct()
	{
		parent::__construct();

		// Set user data
		if ($this->ion_auth->logged_in())
		{
			$this->load->database();
			$this->load->model('pengiriman_model');

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
		// Get page parameter
		$page = (int) $this->input->get('page', true);

		// Get page and total page
		$this->data['page']  = $page;
		$this->data['pages'] = $this->pengiriman_model->getPages(9);

		// Show 404 if page exceeding number of max page
		if($page > $this->data['pages']) show_404();

		// Check if there is no page parameter defined
		if (empty($page) or $page < 1) $page = 1;

		// Get barang list from db by page number
		$this->data['items'] = $this->pengiriman_model->getBarang(9,$page);

		$this->load->view('tabel',$this->data);
	}

	public function kirim()
	{
		$id = (int) $this->input->get('id', true);

		if(!$data = $this->pengiriman_model->kirimBarang($id))
		{
			echo '<script>alert("Gagal mengirim barang")</script>';
			redirect(site_url(''));
		}
		else
		{
			redirect(site_url(''));
		}
	}

	public function terima()
	{
		$id = (int) $this->input->get('id', true);

		if(!$data = $this->pengiriman_model->terimaBarang($id))
		{
			echo '<script>alert("Gagal mengirim barang")</script>';
			redirect(site_url(''));
		}
		else
		{
			redirect(site_url(''));
		}
	}
}
