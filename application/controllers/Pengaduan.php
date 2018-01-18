<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaduan extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('m_pengaduan');
		$this->load->model('m_api');
		$this->load->library('lapi');
		$this->load->library('pustaka');
	}

	function index() {
		$data['isi'] = "pengaduan/index";
		$data['data']['pengaduan_selesai'] = $this->m_pengaduan->ambil_pengaduan_selesai();
		$data['data']['pengaduan_belum'] = $this->m_pengaduan->ambil_pengaduan_belum();
		$this->load->view("template/template", $data);
	}

	function lihat($id_pengaduan){
		$data['isi'] = "pengaduan/lihat";
		$data['data']['id_pengaduan'] = $id_pengaduan;
		$data['data']['pengaduan'] = $this->m_pengaduan->ambil_pengaduan($id_pengaduan);
		$chat_masuk = $this->m_api->ambil_chat_masuk($id_pengaduan);
		$chat_keluar = $this->m_api->ambil_chat_keluar($id_pengaduan);
		$chat_sementara = $this->lapi->ambil_chat($chat_masuk, $chat_keluar);
		$chat = array();
		$i = 0;
		foreach ($chat_sementara['waktu'] as $item) {
			$chat[] = array($chat_sementara['waktu'][$i], $chat_sementara['nama'][$i], $chat_sementara['tipe'][$i], $chat_sementara['isi'][$i], $chat_sementara['id_user'][$i], $chat_sementara['tipe_user'][$i]);
			$i++;
		}
		$data['data']['chat'] = $chat;
		$this->load->view("template/template", $data);	
	}

}
