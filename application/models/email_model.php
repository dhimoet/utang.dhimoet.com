<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function send_admin(Array $from, Array $email)
	{
		$to = array(
			'name' => 'Administrator',
			'address' => 'admin@dhimoet.com',
		);
		
		$email['subject'] = 'An UtangApp user has submitted a report';
		
		return $this->send_email($to, $from, $email);
	}
	
	public function send_email(Array $to, Array $from, Array $email) 
	{
		$email['body'] = "<div><strong>From:</strong></div>\n";
		$email['body'].= "<div>{$from['name']}</div>\n";
		$email['body'].= "<div><strong>Title:</strong></div>\n";
		$email['body'].= "<div>{$email['title']}</div>\n";
		$email['body'].= "<div><strong>Description:</strong></div>\n";
		$email['body'].= "<div>{$email['description']}</div>\n";

		$this->email->from($from['address'], $from['name']);
		$this->email->to($to['address'], $to['name']); 
		$this->email->subject($email['subject']);
		$this->email->message($email['body']);	

		if($this->email->send()) {
			return true;
		}
		else {
			return false;
		}
	}
}
