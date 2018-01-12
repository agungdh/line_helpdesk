<?php
class M_welcome extends CI_Model{	
	function __construct(){
		parent::__construct();		
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
				WHERE id_line = ?";
		return $this->db->query($sql, array($id_line))->row()->total;
	}

	function ambil_pengaduan_terakhir($id_line) {
		$sql = "SELECT id
				FROM pengaduan
				WHERE id_line = ?
				ORDER BY id DESC
				LIMIT 1";
		return $this->db->query($sql, array($id_line))->row()->id;
	}

}
?>