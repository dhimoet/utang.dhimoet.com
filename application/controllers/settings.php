<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		/*** check login statuses ***/
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/logout', 'refresh');
		}
		// get user's session and token
		$fu = $this->facebookuser_model->get();
		if($fu && $fu->token) {
			$access_token = array($fu->token);
		}
		else {
			$access_token = array();
		}
		$this->load->library('my_fb', $access_token);
		if(!$this->my_fb->logged_in())
		{
			//redirect them to the login page
			redirect('auth/logout', 'refresh');
		}
		
		/*** construct html page ***/
		$title = ucwords(str_replace('_', ' ',$this->router->fetch_method()));
		$this->head['title'] = $title;
		
		/*** get notification number ***/
		$this->data['notif'] = $this->notification_model->get_notification_number();
	}
	
	public function index()
	{
		$this->settings();
	}
	
	public function settings()
	{
		$this->load->view('templates/base_header', $this->head);
		$this->load->view('templates/nav_header', $this->head);
		$this->load->view('settings/index', $this->data);
		$this->load->view('templates/overlay_template');
		$this->load->view('backbone_js', $this->head['title']);
		$this->load->view('templates/nav_footer');
		$this->load->view('templates/base_footer');
	}
	
	public function add_friend()
	{
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		
		if ($this->form_validation->run() == true) {
			// store to database
			$id1 = $this->ion_auth->user()->row()->id;
			$id2 = $this->user_model->get_id($this->input->post('email'));
			$this->userrelationship_model->set_relationship($id1, $id2);
			
			redirect('/settings/settings/?msg=6', 'refresh');
		}
		else {
			// display an add friend form
			$this->load->view('templates/base_header', $this->head);
			$this->load->view('templates/nav_header', $this->head);
			$this->load->view('settings/add_friend', $this->data);
			$this->load->view('templates/overlay_template');
			$this->load->view('backbone_js', $this->head['title']);
			$this->load->view('templates/nav_footer');
			$this->load->view('templates/base_footer');
		}
	}
	
	public function update_status()
	{
		$this->form_validation->set_rules('message', 'Message', 'required');
		
		if ($this->form_validation->run() == true) {
			// post to facebook
			$uid = $this->user_model->get_facebook_uid($this->ion_auth->user()->row()->id);
			$url = "https://graph.facebook.com/{$uid}/feed";
			$params = array(
				'message' => $this->input->post('message'),
			);
			$this->my_fb->make_request($url, $params);
			redirect('/settings/settings/?msg=4', 'refresh');
		}
		else {
			$this->load->view('templates/base_header', $this->head);
			$this->load->view('templates/nav_header', $this->head);
			$this->load->view('settings/update_status', $this->data);
			$this->load->view('backbone_js', $this->head['title']);
			$this->load->view('templates/nav_footer');
			$this->load->view('templates/nav_footer');
			$this->load->view('templates/base_footer');
		}
	}
	
	public function notifications()
	{
		$notifications = $this->notification_model->get_notifications();
		
		foreach($notifications as &$notification) {
			$notification['friend'] = $this->user_model->get_friend($notification['SenderId']);
		}
		$this->data['notifications'] = $notifications;

		$this->load->view('templates/base_header', $this->head);
		$this->load->view('templates/nav_header', $this->head);
		$this->load->view('settings/notifications', $this->data);
		$this->load->view('templates/nav_footer');
		$this->load->view('templates/base_footer');
		
		$this->notification_model->clear_notifications();
	}
	
	public function friend_request($id, $user_id)
	{
		// get notification details
		$this->data['notification'] = $this->notification_model->get_notification($id);
		// get user/friend information
		$this->data['friend'] = $this->user_model->get_friend($user_id);
		
		$this->load->view('templates/base_header', $this->head);
		$this->load->view('templates/nav_header', $this->head);
		$this->load->view('settings/friend_request', $this->data);
		$this->load->view('templates/nav_footer');
		$this->load->view('templates/base_footer');
	}
	
	public function respond_request($type, $notification_id, $friend_id)
	{
		// change the type on userrelationship table
		$my_id = $this->ion_auth->user()->row()->id;
		$this->userrelationship_model->set_relationship($friend_id, $my_id, $type, 'inactive', $notification_id);
		
		redirect('/settings/', 'refresh');
	}
	
	public function report_tool()
	{
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		
		if ($this->form_validation->run() == true) {
			$from = array(
				'name' => $this->ion_auth->user()->row()->username,
				'address' => $this->ion_auth->user()->row()->email,
			);
			$email = array(
				'title' => $this->input->post('title'),
				'description' => $this->input->post('description')
			);
			
			// send email to admin
			if($this->email_model->send_admin($from, $email)) {
				redirect('/settings/settings/?msg=1', 'refresh');
			}
			else {
				redirect('/settings/settings/?msg=0', 'refresh');
			}
		}
		else {
			$this->load->view('templates/base_header', $this->head);
			$this->load->view('templates/nav_header', $this->head);
			$this->load->view('settings/report_tool', $this->data);
			$this->load->view('templates/nav_footer');
			$this->load->view('templates/base_footer');
		}
	}
	
	public function help()
	{
		$this->load->view('templates/base_header', $this->head);
		$this->load->view('templates/nav_header', $this->head);
		$this->load->view('settings/help', $this->data);
		$this->load->view('templates/nav_footer');
		$this->load->view('templates/base_footer');
	}
}

/* End of file home.php */
/* Location: ./application/controllers/settings.php */
