<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Legal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		/*** construct html page ***/
		$title = ucwords(str_replace('_', ' ',$this->router->fetch_method()));
		$this->head['title'] = $title;
	}
	
	public function index()
	{
		$this->terms();
	}
	
	public function terms()
	{
		$this->load->view('templates/base_header', $this->head);
		$this->load->view('templates/nav_header');
		$this->load->view('legal/terms');
		$this->load->view('templates/nav_footer');
		$this->load->view('templates/base_footer');
	}
	
	public function privacy()
	{
		$this->load->view('templates/base_header', $this->head);
		$this->load->view('templates/nav_header');
		$this->load->view('legal/privacy');
		$this->load->view('templates/nav_footer');
		$this->load->view('templates/base_footer');
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
