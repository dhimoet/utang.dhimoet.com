<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_fb {

	public function __construct()
	{
		$this->facebook = facebookInit();
		
		// Get User ID
		$user = $this->facebook->getUser();
		$this->user = $user;
		if ($this->user) {
			try {
				// Proceed knowing you have a logged in user who's authenticated.
				$this->user_profile = $this->facebook->api('/me');
			} 
			catch (FacebookApiException $e) {
				error_log($e);
				$this->user = null;
			}
		}
		if ($this->user) {
			$this->logoutUrl = $this->facebook->getLogoutUrl();
		} 
		else {
			$this->loginUrl = $this->facebook->getLoginUrl();
		}
	}
	
	public function open()
	{
		return $this->facebook;
	}
	
	public function close()
	{
		$this->facebook->destroySession();
	}
	
	public function logged_in() 
	{
		return $this->user ? true : false;
	}
	
	public function get_user()
	{
		return $this->user;
	}
	
	public function get_user_profile()
	{
		if(isset($this->user_profile)) {
			return $this->user_profile;
		}
		else {
			return 0;
		}
	}
	
	public function get_logout_url()
	{
		return $this->logoutUrl;
	}
	
	public function get_login_url()
	{
		return $this->loginUrl;
	}
}

/* End of file home.php */
/* Location: ./application/libraries/Facebook.php */
