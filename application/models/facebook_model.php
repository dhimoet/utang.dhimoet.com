<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facebook_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Match username in database
	 */
	public function is_registered_user(Array $user) 
	{
		$this->db->select('facebook_user_id');
		$query = $this->db->get_where('users', array('facebook_user_id' => $user['user_id']));
		
		// make sure that the entry only returns 1, not 0 or greater than 1
		if($query->num_rows() === 1) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public function create_user(Array $user)
	{
		if(!empty($user)) 
		{
			$username = $user['first_name'] .' '. $user['last_name'];
			$password = generatePassword($user);
			$email = isset($user['email'])?$user['email']:$user['username'] . '@facebook.com';
			$additional_data = $additional_data = array(
				'first_name' => $user['first_name'],
				'last_name'  => $user['last_name'],
				'facebook_user_id' => $user['user_id'],
				'facebook_username' => $user['username']
			);
			
			if ($this->ion_auth->register($username, $password, $email, $additional_data))
			{
				// publish to his wall
				$url = "https://graph.facebook.com/{$user['user_id']}/feed";
				$params = array(
					'name' => 'UtangApp',
					'message' => 'I have just signed up for UtangApp!',
					'link' => 'http://utang.dhimoet.com',
					'description' => 'Everyone borrows and lends money all the time. Just enter the number here and let this app calculates and keep the records!', 
				);
				$this->my_fb->make_request($url, $params);
				
				//check to see if we are creating the user
				//redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->login($user);
			}
			else
			{
				redirect("auth", 'refresh');	
			}
		}
	}
	
	public function login($user) 
	{
		if (!empty($user))
		{
			$this->db->select('email');
			$query = $this->db->get_where('users', array('facebook_user_id' => $user['user_id']));
			$email = $query->row()->email;
			
			//if the login is successful
			//redirect them back to the home page
			if ($this->ion_auth->login($email, generatePassword($user), true))
			{ 
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect($this->config->item('base_url'), 'refresh');
			}
		}
		else
		{ 
			//if the login was un-successful
			//redirect them back to the login page
			redirect('auth/login', 'refresh');
		}
	}
	
	public function user_updated($user)
	{
		$query = $this->db->get_where('users', array('facebook_user_id' => $user['user_id']));		
		$stored_user = $query->row_array();
		
		// compare first name
		if($stored_user['first_name'] != $user['first_name']) {
			return true;
		}
		// compare last name
		if($stored_user['last_name'] != $user['last_name']) {
			return true;
		}
		// compare username
		if($stored_user['username'] != $user['username']) {
			return true;
		}

		return false;
	}
	
	public function update_user($user)
	{
		$email    = $user['username'] . '@facebook.com';
		
		$data = array(
			'first_name' => $user['first_name'],
			'last_name' => $user['last_name'],
			'username' => $user['first_name'] .' '. $user['last_name'],
			'email' => $user['username'] . '@facebook.com',
		);
		
		$this->db->where('facebook_user_id', $user['user_id']);
		$this->db->update('users', $data);
	}
	
	public function get_user_type($user)
	{
		$this->db->select('email');
		$query = $this->db->get_where('users', array('id' => $this->session->userdata['user_id']));
		
		$domain = explode('@', $query->row()->email);
		
		return $domain[1];
	}
}
