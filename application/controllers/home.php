<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		//check login status
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
        
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
	
	public function index() {
		$this->load->view('templates/base_header', $this->head);
		$this->load->view('home/index');
		$this->load->view('templates/base_footer');
	}

	public function home() {
		
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
