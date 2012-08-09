<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

	public function index() {
    
	}
    
	public function sendReport() 
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
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
