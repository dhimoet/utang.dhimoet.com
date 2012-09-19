<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Api extends REST_Controller {

	public function index_get()
	{	
		$this->load->view('templates/api_header');
		$this->load->view('api/index');
		$this->load->view('templates/base_footer');
	}
	
	public function user_get()
	{
		// get user's basic information
		$user = $this->user_model->get_user($this->get('id'));
		if(!empty($user)) {
			$this->response($user, 200);
		}
		else {
			$this->response(array('error' => "Couldn't find any user!"), 404);
		}
	}
	
	public function user_id_get()
	{
		// get user's basic information
		$user = $this->user_model->get_user_id($this->get('email'));
		if(!empty($user)) {
			$this->response($user, 200);
		}
		else {
			$this->response(array('error' => "Couldn't find any user!"), 404);
		}
	}
	
	public function users_get()
	{
		$identity = array(
			'id' 				=> $this->get('id'),
			'username' 			=> $this->get('username'),
			'email' 			=> $this->get('email'),
			'first_name' 		=> $this->get('first_name'),
			'last_name' 		=> $this->get('last_name'),
			'phone' 			=> $this->get('phone'),
			'facebook_user_id' 	=> $this->get('facebook_user_id'),
			'facebook_username' => $this->get('facebook_username'),
		);
		// get user's basic information
		$user = $this->user_model->get_users($identity);
		if(!empty($user)) {
			$this->response($user, 200);
		}
		else {
			$this->response(array('error' => "Couldn't find any user!"), 404);
		}
	}
	
	public function friends_get()
	{
		// get friends' basic information
		$friends = $this->user_model->get_friends($this->get('key'));
		
		if(!empty($friends)) {
			$this->response($friends, 200);
		}
		else {
			$this->response(array('error' => "Couldn't find any friends!"), 404);
		}
	}
}

/* End of file home.php */
/* Location: ./application/controllers/api.php */
