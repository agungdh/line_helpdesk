<?php
class M_pengaduan extends CI_Model{	
	function __construct(){
		parent::__construct();		
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
}
?>