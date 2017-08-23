<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recipies extends CI_Model {

	public function __construct() {

		$this->load->database();
		// disabled db debug
		$this->db->db_debug = FALSE;
	}

	public function getLatest() {
		$sql = "SELECT a.*, b.name AS category_name FROM recipies AS a LEFT JOIN categories AS b ";
		$sql .= "ON b.id = a.category_id ORDER BY date_added DESC LIMIT 3";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getRecipe($id) {
		$sql = "SELECT a.*, b.name AS category_name FROM recipies AS a LEFT JOIN categories AS b ";
		$sql .= "ON b.id = a.category_id where a.id = ".$id;
		return $this->db->query($sql)->row();
	}



	public function getRecipies($category_id = null) {

		$sql = "SELECT a.*, b.name AS category_name FROM recipies AS a LEFT JOIN categories AS b ";
		$sql .= "ON b.id = a.category_id";

		if($category_id){	
			$sql .= " where a.category_id = {$category_id} ORDER BY date_added DESC";
		}
		
		return $this->db->query($sql)->result();
	}

	public function save($data, $id = null) {
		if($id) {
			$this->db->where('id',$id);
			$this->db->update('recipies',$data);
		}else{
			$this->db->insert('recipies',$data);
		}
		// return $this->db->last_query();
		return $this->db->affected_rows();
	}

	public function delete($id) {
		if($id) {
			$this->db->delete('recipies', array('id' => $id));
		}
		return $this->db->affected_rows();
	}

	public function truncate() {
		return $this->db->truncate('recipies');
	}

	public function total_rows() {
		return $this->db->from('recipies')->count_all_results();
	}
	


}