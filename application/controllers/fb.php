<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fb extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		/*** construct html page ***/
		$title = ucwords(str_replace('_', ' ',$this->router->fetch_method()));
		$this->head['title'] = $title;
	}
	
	public function index() 
	{
		$this->login();
	}
	
	public function login()
	{
		
		if($this->my_fb->get_user()) {
			/*** check database for the user ***/
			$user_profile = $this->my_fb->get_user_profile();
			$user = array(
				'user_id' => $user_profile['id'],
				'first_name' => $user_profile['first_name'],
				'last_name' => $user_profile['last_name'],
				'username' => $user_profile['username'],
			);
			
			/*** create a new account if the user does not exist ***/
			if(!$this->utang_model->is_registered_user($user)) {
				$this->utang_model->fb_create_user($user);
			}
			
			/*** log in the user ***/
			$this->utang_model->fb_login($user);
		}
		else {
			/*** log in user to facebook ***/
			redirect($this->my_fb->get_login_url());
		}
	}
	
	public function logout()
	{
		// clear cookies
		$this->my_fb->close();
		// logout user
		if($this->my_fb->get_user()) {
			redirect($this->my_fb->get_logout_url());
		}
		else {
			redirect('auth/login', 'refresh');
		}
	}
}

/* End of file home.php */
/* Location: ./application/controllers/fb.php */
