<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		/*** check login status ***/
		if (!$this->ion_auth->logged_in() || !$this->my_fb->logged_in())
		{
			// give error message
            header('HTTP/1.0 401 Unauthorized');
            echo("You are not authorized to view this page.");
            exit();
		}
		
		/*** get notification number ***/
		$this->data['notif'] = $this->notification_model->get_notification_number();
	}
	
	public function index()
	{	
		$this->load->view('templates/api_header');
		$this->load->view('api/index', $this->data);
		$this->load->view('templates/base_footer');
	}
	
	public function friends()
	{
		// get friends' basic information (array)
		$friends = $this->user_model->get_friends();
		echo json_encode($friends);
		exit();
	}
}

/* End of file home.php */
/* Location: ./application/controllers/api.php */
