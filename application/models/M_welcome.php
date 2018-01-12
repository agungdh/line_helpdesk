<?php
class M_welcome extends CI_Model{	
	function __construct(){
		parent::__construct();		
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

}
?>