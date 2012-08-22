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
				'email' => $user_profile['email']
			);
			
			/*** create a new account if the user does not exist ***/
			if(!$this->facebook_model->is_registered_user($user)) {
				$this->facebook_model->create_user($user);
			}
			else {
				/*** update user's information if it has changed ***/
				if($this->facebook_model->user_updated($user)) {
					$this->facebook_model->update_user($user);
				}
			}

			/*** log in the user ***/
			$this->facebook_model->login($user);
		}
		else {
			/*** log in user to facebook ***/
			redirect($this->my_fb->get_login_url());
		}
	}
	
	public function logout()
	{
		// logout user
		if($this->my_fb->get_user()) {
			// clear cookies
			$this->my_fb->close();
			redirect($this->my_fb->get_logout_url());
		}
		else {
			redirect('auth/logout', 'refresh');
		}
	}
}

/* End of file home.php */
/* Location: ./application/controllers/fb.php */
