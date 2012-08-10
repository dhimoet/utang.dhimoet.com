<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

	public function index() {
    
	}
    
	public function send_report() 
	{
		$this->load->library('email');
		
		$title = $this->input->post('title');
		$description = $this->input->post('description');
		$message = "<div><strong>Title:</strong></div>\n";
		$message.= "<div>{$title}</div>\n";
		$message.= "<div><strong>Description:</strong></div>\n";
		$message.= "<div>{$description}</div>\n";
		
		$user = $this->ion_auth->user()->row();
		$from_address = $user->email;
		$from_name = $user->first_name .' '. $user->last_name;

		$this->email->from($from_address, $from_name);
		$this->email->to('admin@dhimoet.com', 'Dhimoet Admin'); 
		$this->email->subject('An UtangApp user has submitted a report');
		$this->email->message($message);	

		if($this->email->send()) {
			echo "success";
		}
		else {
			echo "failed";
		}
	}
	
	public function get_users() 
	{
		$key = $this->input->post('key');
		
		// get from users table
		$this->db->select('username, email');
		$this->db->like('username', $key);
		$query = $this->db->get('users');
		$user_list = $query->result();
		
		echo json_encode($user_list);
		
		// get from users_facebook table
		//$this->db->select('Email', 'Name');
		//$this->db->like('Name', $key);
		//$query = $this->db->get('users_facebook');
		//array_push($user_list, $query->result_array());
		//$user_list = $query->result_array();
		//print_rf($user_list); die;
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
