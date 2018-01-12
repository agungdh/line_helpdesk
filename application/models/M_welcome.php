<?php
class M_welcome extends CI_Model{	
	function __construct(){
		parent::__construct();		
	}

	function ambil_pengaduan($id_line) {
		$sql = "SELECT *
				FROM pengaduan
				WHERE id_line = ?";
		return $this->db->query($sql, array($id_line))->result();
	}

	function ambil_chat_masuk($id_pengaduan) {
		$sql = "SELECT cm.id, cm.id_pengaduan, cm.chat, cm.waktu, p.id_line
				FROM chat_masuk cm, pengaduan p
				WHERE cm.id_pengaduan = p.id
				AND id_pengaduan = ?";
		return $this->db->query($sql, array($id_pengaduan))->result();
	}

	function ambil_chat_keluar($id_pengaduan) {
		$sql = "SELECT ck.id, ck.id_user, ck.id_pengaduan, ck.chat, ck.waktu, u.username, u.nama, u.level
				FROM chat_keluar ck, user u
				WHERE ck.id_user = u.id
				AND ck.id_pengaduan = ?";
		return $this->db->query($sql, array($id_pengaduan))->result();
	}

	function tambah_chat_masuk($id_pengaduan, $chat, $waktu) {
		$sql = "INSERT INTO chat_masuk
				SET id_pengaduan = ?,
				chat = ?,
				waktu = ?";
		$this->db->query($sql, array($id_pengaduan, $chat, $waktu));
	}

	function tambah_pengaduan($id_line, $pengaduan, $waktu) {
		$sql = "INSERT INTO pengaduan
				SET id_line = ?,
				pengaduan = ?,
				waktu = ?,
				status = 0";
		$this->db->query($sql, array($id_line, $pengaduan, $waktu));
		$insert_id = $this->db->insert_id();

		return $insert_id;
	}

	function cek_jumlah_pengaduan($id_line) {
		$sql = "SELECT count(*) total
				FROM pengaduan
				WHERE id_line = ?
				AND status != 2";
		return $this->db->query($sql, array($id_line))->row()->total;
	}

	function ambil_pengaduan_terakhir($id_line) {
		$sql = "SELECT id
				FROM pengaduan
				WHERE id_line = ?
				AND status != 2
				ORDER BY id DESC
				LIMIT 1";
		return $this->db->query($sql, array($id_line))->row()->id;
	}

}
?>