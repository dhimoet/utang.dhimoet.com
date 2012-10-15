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
		$cookie = $this->input->cookie('utangapp_login_cookie');
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
			/*** create cookie ***/
			$this->input->set_cookie(array(
				'name' => 'utangapp_login_cookie',
				'value' => $this->my_fb->get_user(),
				'expire' => '5184000'
			));
			/*** log in the user ***/
			$this->facebook_model->login($user);
		}
		elseif($cookie) {
			// get facebook user data
			$fu = $this->facebookuser_model->get($cookie);
			$this->my_fb->set_access_token($fu->token);
			redirect('/fb/login', 'refresh');
		}
		else {
			/*** log in user to facebook ***/
			redirect($this->my_fb->get_login_url());
		}
	}
	
	public function loginx()
	{
		// check if user logged into the website
		if($this->ion_auth->logged_in()) {
			// user is logged in
			// get user
			$user = $this->ion_auth->user()->row();
			// get user's facebook uid
			$uid = $this->user_model->get_facebook_uid($user->id);
			// get facebook user data
			$fb = $this->facebookuser_model->get($uid);
			// use access token
			$this->my_fb->set_access_token($fb['token']);
			// check if token is valid
			if($this->my_fb->logged_in()) {
				// token is valid
				// login the user
				$this->facebook_model->login($user);
			}
			else {
				// token is invalid
				redirect($this->my_fb->get_login_url());
			}
		}
		else {
			// user is not logged in
			
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
