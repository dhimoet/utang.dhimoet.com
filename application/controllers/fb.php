<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fb extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->facebook = facebookInit();
		// Get User ID
		$this->user = $this->facebook->getUser();
		$user = $this->user;
		if ($user) {
			try {
				// Proceed knowing you have a logged in user who's authenticated.
				$this->user_profile = $this->facebook->api('/me');
			} 
			catch (FacebookApiException $e) {
				error_log($e);
				$user = null;
			}
		}
		if ($user) {
			$this->logoutUrl = $this->facebook->getLogoutUrl();
		} 
		else {
			$this->loginUrl = $this->facebook->getLoginUrl();
		}
		
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
		if($this->user) {
			/*** check database for the user ***/
			$user = array(
				'user_id' => $this->user_profile['id'],
				'first_name' => $this->user_profile['first_name'],
				'last_name' => $this->user_profile['last_name'],
				'username' => $this->user_profile['username'],
			);
			
			/*** create a new account if the user does not exist ***/
			if(!$this->utang_model->is_registered_user($user)) {
				$this->utang_model->fb_create_user($user);
			}
			
			/*** log in the user ***/
			$this->utang_model->fb_login($this->user);
			
			/*** redirect to homepage ***/
			redirect($this->config->item('base_url'), 'refresh');
		}
		else {
			/*** log in user to facebook ***/
			redirect($this->loginUrl);
		}
	}
	
	public function logout()
	{
		// clear cookies
		$this->facebook->destroySession();
		// logout user
		if($this->user) {
			redirect($this->logoutUrl);
		}
		else {
			redirect('auth/login', 'refresh');
		}
	}
}

/* End of file home.php */
/* Location: ./application/controllers/fb.php */
