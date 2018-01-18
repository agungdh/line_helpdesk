<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaduan extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('m_pengaduan');
		$this->load->library('lapi');
		$this->load->library('pustaka');
	}

	function index() {
		$data['isi'] = "pengaduan/index";
		$data['data']['pengaduan_selesai'] = $this->m_pengaduan->ambil_pengaduan_selesai();
		$data['data']['pengaduan_belum'] = $this->m_pengaduan->ambil_pengaduan_belum();
		$this->load->view("template/template", $data);
	}

	function lihat($id){
		$data['isi'] = "pengaduan/lihat";
		$this->load->view("template/template", $data);	
	}

}
