<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		/*** check login status ***/
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		
		/*** construct html page ***/
		$title = ucwords(str_replace('_', ' ',$this->router->fetch_method()));
		$this->head['title'] = $title;
	}
	
	public function index()
	{
		$this->head['title'] = "Home";
		$this->home();
	}
	
	public function home()
	{
		$this->load->view('templates/base_header', $this->head);
		$this->load->view('main/home');
		$this->load->view('templates/base_footer');
	}
	
	public function summary()
	{
		$this->load->view('templates/base_header', $this->head);
		$this->load->view('main/summary');
		$this->load->view('templates/base_footer');
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
