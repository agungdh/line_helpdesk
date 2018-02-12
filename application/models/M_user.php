<?php
class M_user extends CI_Model{	
	function __construct(){
		parent::__construct();		
	}

	function ambil_data_user_id($id) {
		$sql = "SELECT *
				FROM user
				WHERE id = ?";
		return $this->db->query($sql, array($id))->row();
	}

	function ambil_data_pelayan_id_user($id_user) {
		$sql = "SELECT *
				FROM pelayan
				WHERE id_user = ?";
		return $this->db->query($sql, array($id_user))->result();
	}

	function ambil_data_user() {
		$sql = "SELECT *
				FROM user";
		return $this->db->query($sql, array())->result();
	}

	function ambil_data_layanan() {
		$sql = "SELECT *
				FROM layanan";
		return $this->db->query($sql, array())->result();
	}

	function tambah_user($username, $nama, $password, $level) {
		$sql = "INSERT INTO user
				SET username = ?,
				nama = ?,
				password = ?,
				level = ?";
		$this->db->query($sql, array($username, $nama, $password, $level));
		return $this->db->insert_id();
	}

	function ubah_user($username, $nama, $level, $id) {
		$sql = "UPDATE user
				SET username = ?,
				nama = ?,
				level = ?
				WHERE id = ?";
		$this->db->query($sql, array($username, $nama, $level, $id));
	}

	function tambah_pelayan($id_user, $layanan) {
		$sql = "INSERT INTO pelayan
				SET id_user = ?,
				id_layanan = ?";
		$this->db->query($sql, array($id_user, $layanan));
	}

	function hapus_pelayan($id_user) {
		$sql = "DELETE FROM pelayan
				WHERE id_user = ?";
		$this->db->query($sql, array($id_user));	
	}

	function hapus_user($id_user) {
		$sql = "DELETE FROM user
				WHERE id = ?";
		$this->db->query($sql, array($id_user));	
	}
	function ubah_password($password, $id_user) {
		$sql = "UPDATE user
				SET password = ?
				WHERE id = ?";
		$this->db->query($sql, array($password, $id_user));	
	}
}
?>