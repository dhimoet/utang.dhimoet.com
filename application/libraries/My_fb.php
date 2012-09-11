<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_fb {

	public function __construct($config = array())
	{
		$this->facebook = facebookInit();
		$this->initialize($config);
	}
	
	public function initialize($config = array())
	{
		// Use the provided token if exists
		if(!empty($config)) {
			$this->facebook->setAccessToken($config['access_token']);
		}
		
		// Get User ID
		$this->user = $this->facebook->getUser();
		
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
			$params = array(
				'scope' => 'email,publish_actions,publish_stream'
			);
			$this->loginUrl = $this->facebook->getLoginUrl($params);
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
	
	public function get_access_token()
	{
		return $this->facebook->getAccessToken();
	}
	
	public function set_access_token($token)
	{
		return $this->facebook->setAccessToken($token);
	}
	
	public function set_extended_access_token()
	{
		$this->facebook->setExtendedAccessToken();
	}
	
	public function get_logout_url()
	{
		return $this->logoutUrl;
	}
	
	public function get_login_url()
	{
		return $this->loginUrl;
	}
	
	public function make_request($url, $params)
	{
		return $this->facebook->make_api_request($url, $params);
	}
}

/* End of file home.php */
/* Location: ./application/libraries/Facebook.php */
