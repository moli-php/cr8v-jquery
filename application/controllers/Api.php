<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	protected $data;
	protected $verb;

	public function __construct() {
		parent::__construct();
		$this->_init();

		// filter only ajax request is allowed
		if(!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
	}

	private function _init() {
		$this->load->model('recipies');
		$this->load->helper(['url']);
		parse_str(file_get_contents('php://input'), $this->data);
		$this->verb = $this->input->method(TRUE);
	}

	// home data
	public function latest() {
		if($this->verb == 'GET'){
			$data = $this->recipies->getLatest();
			echo json_encode($data);
		}
		
	}

	// data for appetizer, soup, dessert, main dish
	public function recipies($id) {
		if($this->verb == 'GET'){
			$data = $this->recipies->getRecipies($id);
			echo json_encode($data);
		}
	}

	// details data
	public function recipe($id) {
		if($this->verb == 'GET') {
			$data = $this->recipies->getRecipe($id);
			echo json_encode($data);
		}
	}

	// feature layout data
	public function feature() {
		if($this->verb == 'GET'){
			$data = $this->recipies->getRecipies();
			if(empty($data)) {
				echo 0;
				exit();
			}
			$index = rand(0,count($data) -1);
			echo json_encode($data[$index]);
		}
	}

	public function delete($id) {
		if($id && $this->verb == 'DELETE'){

			$this->load->helper("file");
			$recipe = $this->recipies->getRecipe($id);

			$path = FCPATH . "assets\\img\\uploads\\{$recipe->category_id}\\" . substr($recipe->image, strrpos($recipe->image, "/")+1);

			// delete file and delete database
			if(unlink($path)){
				 echo $this->recipies->delete($id);
			}
		}

	}



	public function save($id = null) {

		$data = $this->input->post();
	

		if($_FILES['image']['error'] != 4) {

			$result = $this->_uploadImage($data);

			if(isset($result['status'])) {
				if($result['status'] == 400) {
					echo json_encode($result);
					exit();
				}else if($result['status'] == 200) {
					$data['image'] = base_url() . 'assets/img/uploads/' . $data['category_id'] . 
									'/' . $result['orig_name'];
				}

				// if update delete old file
				if($id) {
					$recipe = $this->recipies->getRecipe($id);
					$path = FCPATH . "assets\\img\\uploads\\{$recipe->category_id}\\" . substr($recipe->image, strrpos($recipe->image, "/")+1);
					
					unlink($path);


				}
			}
		}

		// save or update database
		$res = ($id) ? $this->recipies->save($data, $id) : $this->recipies->save($data);


		if($res ==  1  || $res == 0) {
			$data['status'] = 200;
		}
		

		echo json_encode($data);
	
	}

	private function _randomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}



	private function _uploadImage($data) {


		$ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

		$config['upload_path']          = './assets/img/uploads/'.$data['category_id'];
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_size']             = 2048;
		$config['max_width']            = 1920;
		$config['max_height']           = 1920;
		// generate unique filename
		$config['file_name'] = $this->_randomString() . "." . $ext;


        $this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('image')) {
			return ['status' => 400, 'error' => 
					$this->upload->display_errors('<p class="text-danger">', '</p>')];
		} else {
			$fileUploadReturnData = $this->upload->data();
			$fileUploadReturnData['status'] = 200;
			return $fileUploadReturnData;
		}

	}







	
}
