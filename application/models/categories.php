<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Model {

	public function __construct() {

		$this->load->database();
		// disabled db debug
		$this->db->db_debug = FALSE;
	}


	public function getCategories() {
		return $this->db->get('categories')->result();
	}
	


}