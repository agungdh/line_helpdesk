<?php
class M_welcome extends CI_Model{	
	function __construct(){
		parent::__construct();		
	}

	function ambil_data_hutang_kasbon() {
		$sql = "select f_ambil_data_kasbon_hutang(?) total";
		$query = $this->db->query($sql, array($this->session->id));
		$row = $query->row();

		return $row->total;
	}

	function ambil_data_pembayaran() {
		$sql = "select f_ambil_data_pembayaran(?) total";
		$query = $this->db->query($sql, array($this->session->id));
		$row = $query->row();

		return $row->total;
	}

	function ambil_data_catatan() {
		$sql = "select f_ambil_data_catatan(?) total";
		$query = $this->db->query($sql, array($this->session->id));
		$row = $query->row();

		return $row->total;
	}

}
?>