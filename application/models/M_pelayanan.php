<?php
class M_pelayanan extends CI_Model{	
	function __construct(){
		parent::__construct();		
	}

	function ubah_status($id_pelayanan, $status) {
		$sql = "UPDATE pelayanan
				SET status = ?
				WHERE id = ?";
		$this->db->query($sql, array($status, $id_pelayanan));
	}

	function ambil_pelayanan($id_pelayanan) {
		$sql = "SELECT *, date(waktu) tanggal
				FROM pelayanan
				WHERE id = ?";
		return $this->db->query($sql, array($id_pelayanan))->row();
	}

	function ambil_layanan($id_layanan) {
		$sql = "SELECT *
				FROM layanan
				WHERE id = ?";
		return $this->db->query($sql, array($id_layanan))->row();
	}

	function ambil_pelayanan_selesai($id) {
		$sql = "SELECT *, date(waktu) tanggal
				FROM pelayanan
				WHERE status = 2
				AND id_layanan = ?";
		return $this->db->query($sql, array($id))->result();
	}

	function ambil_pelayanan_belum($id) {
		$sql = "SELECT *, date(waktu) tanggal
				FROM pelayanan
				WHERE status != 2
				AND id_layanan = ?";
		return $this->db->query($sql, array($id))->result();
	}

	function chat_keluar($id_user, $id_pelayanan, $tipe, $isi, $waktu) {
		$sql = "INSERT INTO chat_keluar
				SET id_user = ?,
				id_pelayanan = ?,
				tipe = ?,
				isi = ?,
				waktu = ?";
		$this->db->query($sql, array($id_user, $id_pelayanan, $tipe, $isi, $waktu));	
	}
}
?>