<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recipe extends CI_Controller {

		
	public function __construct() {
		parent::__construct();
		$this->_initHelpers();
		$this->_initData();
	}

	private function _initHelpers() {
		$this->load->helper(['url', 'form']);
		$this->load->library('form_validation');
		$this->load->model(['categories', 'recipies']);
	}

	private function _initData() {

		$this->data = new stdClass();
		$this->data->categories = $this->categories->getCategories();
		$this->data->menu_active = $this->uri->segment(2, "Home");
		$this->data->title = ucfirst(str_replace("_", " ", $this->data->menu_active));

		// Preparation time values
		$this->data->options[''] = 'Select preparation time';
		for($i = 0; $i < 1440; $i = $i + 10) {
			if($i > 0) {
				$mins = ($i%60) > 0 ? ' '. ($i%60) . ' mins' : '';		
				if($i < 60) {
					$this->data->options[$i . ' mins'] = $i . ' mins';
				}else if($i/60 < 2) {
					$hr = (int)($i/60) . ' hr' . $mins;
					$this->data->options[$hr] = $hr;

				}else if($i/60 >= 2) {
					$hrs = (int)($i/60) . ' hrs' . $mins;
					$this->data->options[$hrs] = $hrs;
				}
			}
		}

		foreach($this->data->categories as $key => $val) {
			$this->data->categories[$key]->url = strtolower(str_replace(" ","_", $val->name));
		}

	}



	public function index()
	{
		$this->_loadPage('home', $this->data);
	}

	public function appetizer() {
		$this->_loadPage(__FUNCTION__, $this->data);
	}

	public function soup() {
		$this->_loadPage(__FUNCTION__, $this->data);
	}

	public function main_dish() {
		$this->_loadPage(__FUNCTION__, $this->data);
	}

	public function dessert() {
		$this->_loadPage(__FUNCTION__, $this->data);
	}

	public function details($id) {
		$this->data->id = $id;
		$this->_loadPage(__FUNCTION__, $this->data, TRUE);
	}

	public function add($category = null) {
		// redirect to 404 poage if no parameter
		if(empty($category)){
			show_404();
		}

		// get category_id to be hidden on the form
		foreach($this->data->categories as $val) {
			if($val->url == $category) {
				$this->data->category_id = $val->id;
			}
		}
	
		$this->_loadPage(__FUNCTION__, $this->data, TRUE);
	}

	public function update($category = null, $id = null) {

		if(empty($category) || empty($id) || !is_numeric($id)) {
			show_404();
		}

		$recipe = $this->recipies->getRecipe($id);

		if(empty($recipe)) {
			show_404();
		}
		// get recipe data
		foreach($recipe as $k => $v) {
			$this->data->$k = $v;
		}

		$this->data->category = $category;
		$this->_loadPage(__FUNCTION__, $this->data, TRUE);
	}


	private function _loadPage($body, $data, $flag = FALSE) {
		$this->load->view('header', $data);
		$this->load->view('contents/'.$body, $data);
		if($flag == FALSE) {
			$this->load->view('feature', $data);
		}
		$this->load->view('footer', $data);

	}


	// this is my reference, nothing to do with the project
	public function my_count() {
		$path = dirname(dirname(__DIR__)) .'/assets/img/uploads';
		$main = scandir($path);
		unset($main[0]);
		unset($main[1]);
		$counter = 0;

		foreach($main as $k => $v) {
			$child = scandir($path ."/".$v);
			foreach($child as $val) {
				
				if($val != '.' && $val != '..' && $val != '.keep') {
					$counter++;
				}
			}
		}

		echo "total images : ". $counter;
		echo "<br>";
		echo "total table records : " . $this->recipies->total_rows();

	}

	// this is my reference, nothing to do with the project
	public function my_reset() {

		$path = dirname(dirname(__DIR__)) .'/assets/img/uploads';
		$main = scandir($path);
		unset($main[0]);
		unset($main[1]);
		$counter = 0;

		foreach($main as $k => $v) {
			$child = scandir($path ."/".$v);
			foreach($child as $val) {
				
				if($val != '.' && $val != '..' && $val != '.keep') {
					$counter++;
					unlink($path . "/{$v}/".$val);
				}
			}
		}

		echo "files deleted : " . $counter;
		echo "<br>";
		echo "Table recipies truncated : " . $this->recipies->truncate();

	}

	

	




}
