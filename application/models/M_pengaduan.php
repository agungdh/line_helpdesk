<?php
class M_pengaduan extends CI_Model{	
	function __construct(){
		parent::__construct();		
	}

	function ubah_status($id_pengaduan, $status) {
		$sql = "UPDATE pengaduan
				SET status = ?
				WHERE id = ?";
		$this->db->query($sql, array($status, $id_pengaduan));
	}

	function ambil_pengaduan($id_pengaduan) {
		$sql = "SELECT *, date(waktu) tanggal
				FROM pengaduan
				WHERE id = ?";
		return $this->db->query($sql, array($id_pengaduan))->row();
	}

	function ambil_pengaduan_selesai() {
		$sql = "SELECT *, date(waktu) tanggal
				FROM pengaduan
				WHERE status = 2";
		return $this->db->query($sql, array())->result();
	}

	function ambil_pengaduan_belum() {
		$sql = "SELECT *, date(waktu) tanggal
				FROM pengaduan
				WHERE status != 2";
		return $this->db->query($sql, array())->result();
	}

	function chat_keluar($id_user, $id_pengaduan, $tipe, $isi, $waktu) {
		$sql = "INSERT INTO chat_keluar
				SET id_user = ?,
				id_pengaduan = ?,
				tipe = ?,
				isi = ?,
				waktu = ?";
		$this->db->query($sql, array($id_user, $id_pengaduan, $tipe, $isi, $waktu));	
	}
}
?>