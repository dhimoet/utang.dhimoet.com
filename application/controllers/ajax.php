<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

	public function index() {
    
	}
	
	public function get_users() 
	{
		$key = $this->input->post('key');
		$users = $this->user_model->get_not_friends($key);
		
		echo json_encode($users);
		exit;
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
