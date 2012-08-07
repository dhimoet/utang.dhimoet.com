<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fb extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		/*** facebook init ***/
		require 'facebook-php-sdk/src/facebook.php';
		$facebook = new Facebook(array(
			'appId'  => '128125447331739',
			'secret' => '2b9cd0e50286b80cd33d52a03a7ab8db',
		));
		// Get User ID
		$user = $facebook->getUser();
		$this->user = $user;
		echo $user;
		if ($user) {
			try {
				// Proceed knowing you have a logged in user who's authenticated.
				$user_profile = $facebook->api('/me');
			} 
			catch (FacebookApiException $e) {
				error_log($e);
				$user = null;
			}
		}
		if ($user) {
			$this->logoutUrl = $facebook->getLogoutUrl();
		} else {
			$this->loginUrl = $facebook->getLoginUrl();
		}
		
		/*** html page init ***/
		$title = ucwords(str_replace('_', ' ',$this->router->fetch_method()));
		$this->head['doctype'] = doctype('html5');
		$this->head['title'] = "UtangApp | " . $title;
		$this->head['css'] = array("/static/css/style.css",
								   "/static/css/validationEngine.jquery.css",
								   "/static/jquery.mobile-1.1.1/jquery.mobile-1.1.1.min.css");
		$this->head['js'] = array("/static/js/jquery-1.7.2.min.js",
								  "/static/js/jquery.validationEngine.js",
								  "/static/js/jquery.validationEngine-en.js",
								  "/static/js/underscore-min.js",
								  "/static/js/backbone-min.js",
								  "/static/js/script.js",
								  "/static/jquery.mobile-1.1.1/jquery.mobile-1.1.1.min.js");
	}
	
	public function index() 
	{
		$this->login();
	}
	
	public function login()
	{
		if(!$this->user) {
			redirect($this->loginUrl);
		}
		else {
			echo 1;
		}
	}
}

/* End of file home.php */
/* Location: ./application/controllers/fb.php */
