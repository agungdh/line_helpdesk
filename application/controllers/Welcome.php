<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_welcome');		
	}

	public function index() {
		$data['isi'] = "template/halaman_utama";
		$data['data']['pengaduan_selesai'] = $this->m_welcome->ambil_jumlah_pengaduan_selesai();
		$data['data']['pengaduan_belum'] = $this->m_welcome->ambil_jumlah_pengaduan_belum();
		$data['data']['pengaduan_total'] = $this->m_welcome->ambil_jumlah_pengaduan();

		$this->session->login != true ? $this->load->view("template/halaman_login") : $this->load->view('template/template',$data);;
	}

}
