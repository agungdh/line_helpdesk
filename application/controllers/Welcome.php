<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_welcome');		
	}

	public function index() {
		$data['isi'] = "template/halaman_utama";
		$data['data']['pelayanan_selesai'] = $this->m_welcome->ambil_jumlah_pelayanan_selesai();
		$data['data']['pelayanan_belum'] = $this->m_welcome->ambil_jumlah_pelayanan_belum();
		$data['data']['pelayanan_total'] = $this->m_welcome->ambil_jumlah_pelayanan();

		$this->session->login != true ? $this->load->view("template/halaman_login") : $this->load->view('template/template',$data);;
	}

}
