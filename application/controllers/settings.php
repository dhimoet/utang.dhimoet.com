<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		/*** check login status ***/
		if (!$this->ion_auth->logged_in() && !$this->my_fb->logged_in())
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
		$this->load->view('templates/base_header', $this->head);
		$this->load->view('templates/nav_header', $this->head);
		$this->load->view('settings/index');
		$this->load->view('templates/nav_footer');
		$this->load->view('templates/base_footer');
	}
	
	public function add_friend()
	{
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		
		if ($this->form_validation->run() == true) {
			// store to database
			$data = array(
				'UserID1' => $this->session->userdata['user_id'],
				'UserID2' => $this->users_model->get_user_id($this->input->post('email')),
				'Type' => 'friend_request'
			);
			$this->db->insert('userrelationships', $data);
			
			redirect('/settings/', 'refresh');
		}
		else {
			// display an add friend form
			$this->load->view('templates/base_header', $this->head);
			$this->load->view('templates/nav_header', $this->head);
			$this->load->view('settings/add_friend');
			$this->load->view('templates/nav_footer');
			$this->load->view('templates/base_footer');
		}
	}
	
	public function change_password()
	{
		$this->load->view('templates/base_header', $this->head);
		$this->load->view('templates/nav_header', $this->head);
		$this->load->view('settings/change_password');
		$this->load->view('templates/nav_footer');
		$this->load->view('templates/base_footer');
	}
	
	public function notifications()
	{
		$this->load->view('templates/base_header', $this->head);
		$this->load->view('templates/nav_header', $this->head);
		$this->load->view('settings/notifications');
		$this->load->view('templates/nav_footer');
		$this->load->view('templates/base_footer');
	}
	
	public function report_tool()
	{
		$this->load->view('templates/base_header', $this->head);
		$this->load->view('templates/nav_header', $this->head);
		$this->load->view('settings/report_tool');
		$this->load->view('templates/nav_footer');
		$this->load->view('templates/base_footer');
	}
	
	public function help()
	{
		$this->load->view('templates/base_header', $this->head);
		$this->load->view('templates/nav_header', $this->head);
		$this->load->view('settings/help');
		$this->load->view('templates/nav_footer');
		$this->load->view('templates/base_footer');
	}
}

/* End of file home.php */
/* Location: ./application/controllers/settings.php */
