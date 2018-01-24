<?php
class M_api extends CI_Model{	
	function __construct(){
		parent::__construct();		
	}

	function ambil_data_layanan() {
		$sql = "SELECT *
				FROM layanan";
		return $this->db->query($sql, array())->result();
	}

	function tambah_chat_masuk($id_pelayanan, $tipe, $isi, $waktu) {
		$sql = "INSERT INTO chat_masuk
				SET id_pelayanan = ?,
				tipe = ?,
				isi = ?,
				waktu = ?";
		$this->db->query($sql, array($id_pelayanan, $tipe, $isi, $waktu));
	}

	function cek_jumlah_pelayanan_aktif($id_line) {
		$sql = "SELECT count(*) total
				FROM pelayanan
				WHERE id_line = ?
				AND status != 2";
		return $this->db->query($sql, array($id_line))->row()->total;
	}

	function cek_jumlah_pelayanan($id_line) {
		$sql = "SELECT count(*) total
				FROM pelayanan
				WHERE id_line = ?";
		return $this->db->query($sql, array($id_line))->row()->total;
	}

	function ambil_pelayanan_terakhir($id_line) {
		$sql = "SELECT id
				FROM pelayanan
				WHERE id_line = ?
				AND status != 2
				ORDER BY id DESC
				LIMIT 1";
		return $this->db->query($sql, array($id_line))->row()->id;
	}

	function tambah_pelayanan($id_line, $id_layanan, $pelayanan, $waktu) {
		$sql = "INSERT INTO pelayanan
				SET id_line = ?,
				id_layanan = ?,
				pelayanan = ?,
				waktu = ?,
				status = 0";
		$this->db->query($sql, array($id_line, $id_layanan, $pelayanan, $waktu));
		$insert_id = $this->db->insert_id();

		return $insert_id;
	}

	function ambil_pelayanan($id_line) {
		$sql = "SELECT *
				FROM pelayanan
				WHERE id_line = ?
				ORDER BY id DESC
				LIMIT 1";
		return $this->db->query($sql, array($id_line))->row();
	}

	function ambil_chat_masuk($id_pelayanan) {
		$sql = "SELECT cm.id, cm.id_pelayanan, cm.tipe, cm.isi, cm.waktu, p.id_line
				FROM chat_masuk cm, pelayanan p
				WHERE cm.id_pelayanan = p.id
				AND id_pelayanan = ?";
		return $this->db->query($sql, array($id_pelayanan))->result();
	}

	function ambil_chat_keluar($id_pelayanan) {
		$sql = "SELECT ck.id, ck.id_user, ck.id_pelayanan, ck.tipe, ck.isi, ck.waktu, u.username, u.nama, u.level
				FROM chat_keluar ck, user u
				WHERE ck.id_user = u.id
				AND ck.id_pelayanan = ?";
		return $this->db->query($sql, array($id_pelayanan))->result();
	}

}
?>