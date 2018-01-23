<?php
class M_welcome extends CI_Model{	
	function __construct(){
		parent::__construct();		
	}

	function ambil_jumlah_pelayanan_selesai() {
		$sql = "SELECT count(*) total
				FROM pelayanan
				WHERE status = 2";
		return $this->db->query($sql, array())->row()->total;
	}

	function ambil_jumlah_pelayanan_belum() {
		$sql = "SELECT count(*) total
				FROM pelayanan
				WHERE status != 2";
		return $this->db->query($sql, array())->row()->total;
	}

	function ambil_jumlah_pelayanan() {
		$sql = "SELECT count(*) total
				FROM pelayanan";
		return $this->db->query($sql, array())->row()->total;
	}
}
?>