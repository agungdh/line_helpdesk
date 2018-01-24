<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelayanan extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('m_pelayanan');
		$this->load->model('m_api');
		$this->load->library('lapi');
		$this->load->library('pustaka');
	}

	function index() {
		$data['isi'] = "pelayanan/index";
		$data['data']['pelayanan_selesai'] = $this->m_pelayanan->ambil_pelayanan_selesai();
		$data['data']['pelayanan_belum'] = $this->m_pelayanan->ambil_pelayanan_belum();
		$this->load->view("template/template", $data);
	}

	function lihat($id_pelayanan){
		$data['isi'] = "pelayanan/lihat";
		$data['data']['id_pelayanan'] = $id_pelayanan;
		$data['data']['pelayanan'] = $this->m_pelayanan->ambil_pelayanan($id_pelayanan);
		$chat_masuk = $this->m_api->ambil_chat_masuk($id_pelayanan);
		$chat_keluar = $this->m_api->ambil_chat_keluar($id_pelayanan);
		$chat_sementara = $this->lapi->ambil_chat($chat_masuk, $chat_keluar);
		$chat = array();
		$i = 0;
		foreach ($chat_sementara['waktu'] as $item) {
			$chat[] = array($chat_sementara['waktu'][$i], $chat_sementara['nama'][$i], $chat_sementara['tipe'][$i], $chat_sementara['isi'][$i], $chat_sementara['id_user'][$i], $chat_sementara['tipe_user'][$i], $chat_sementara['id_chat'][$i]);
			$i++;
		}
		$data['data']['chat'] = $chat;
		$this->load->view("template/template", $data);	
	}

	function chat() {
		$chat = $this->input->post('chat');
		$id_pelayanan = $this->input->post('id_pelayanan');
		$id_line = $this->input->post('id_line');
		$this->lapi->push($id_line, $chat);
		$this->m_pelayanan->chat_keluar($this->session->id, $id_pelayanan, "text", $chat, date('Y-m-d H:i:s'));
		redirect(base_url('pelayanan/lihat/'.$id_pelayanan));
	}

	function ubah_status($id_pelayanan, $status) {
		$this->m_pelayanan->ubah_status($id_pelayanan, $status);
		redirect(base_url('pelayanan/lihat/'.$id_pelayanan));
	}
}
