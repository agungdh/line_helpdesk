<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_welcome');		
	}

	public function index() {
		$hutang_kasbon = $this->m_welcome->ambil_data_hutang_kasbon();
		$pembayaran = $this->m_welcome->ambil_data_pembayaran();
		$catatan = $this->m_welcome->ambil_data_catatan();

		$this->session->login != true ? $this->load->view("template/halaman_login") : $this->load->view('template/template',array("isi" => "template/halaman_utama", "data" => array("hutang_kasbon" => $hutang_kasbon,"pembayaran" => $pembayaran,"catatan" => $catatan)));;
	}

}
