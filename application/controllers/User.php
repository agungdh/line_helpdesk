<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_user');		
	}

	public function index() {
		$data['isi'] = "user/index";
		$data['data']['user'] = $this->m_user->ambil_data_user();

		$this->load->view('template/template',$data);
	}

	public function tambah() {
		$data['isi'] = "user/tambah";
		$data['data']['layanan'] = $this->m_user->ambil_data_layanan();

		$this->load->view('template/template',$data);
	}

	public function aksi_tambah(){
		$this->m_user->tambah_user($this->input->post('username'),
									$this->input->post('nama'),
									hash('sha512', $this->input->post('password')),
									$this->input->post('radio')
								);

		foreach ($this->m_user->ambil_data_layanan() as $item) {
			if ($this->input->post($item->id) == 1) {
				
			} else {
				
			}
		}

		redirect(base_url('user'));
	}

}
