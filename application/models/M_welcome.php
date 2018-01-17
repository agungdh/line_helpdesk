<?php
class M_welcome extends CI_Model{	
	function __construct(){
		parent::__construct();		
	}

	function ambil_jumlah_pengaduan_selesai() {
		$sql = "SELECT count(*) total
				FROM pengaduan
				WHERE status = 2";
		return $this->db->query($sql, array())->row()->total;
	}

	function ambil_jumlah_pengaduan_belum() {
		$sql = "SELECT count(*) total
				FROM pengaduan
				WHERE status != 2";
		return $this->db->query($sql, array())->row()->total;
	}

	function ambil_jumlah_pengaduan() {
		$sql = "SELECT count(*) total
				FROM pengaduan";
		return $this->db->query($sql, array())->row()->total;
	}
}
?>