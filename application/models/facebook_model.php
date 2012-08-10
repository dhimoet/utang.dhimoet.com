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
		$this->db->select('UserID');
		$query = $this->db->get_where('users_facebook', array('UserID' => $user['user_id']));
		
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
		if (!empty($user))
		{
			$email    = $user['username'] . '@facebook.com';
			
			$data = array(
				'UserID' => $user['user_id'],
				'FirstName' => $user['first_name'],
				'LastName' => $user['last_name'],
				'Name' => $user['first_name'] .' '. $user['last_name'],
				'UserName' => $user['username'],
				'Email' => $user['username'] . '@facebook.com',
			);
			
			$this->db->insert('users_facebook', $data);
		}
	}
	
	public function login($user_id) 
	{
		if ($user_id)
		{ 
			//if the login is successful
			//redirect them back to the home page
			$this->session->set_flashdata('message', $user_id);
			redirect($this->config->item('base_url'), 'refresh');
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
		$query = $this->db->get_where('users_facebook', array('UserID' => $user['user_id']));		
		$stored_user = $query->row_array();
		
		// compare first name
		if($stored_user['FirstName'] != $user['first_name']) {
			return true;
		}
		// compare last name
		if($stored_user['LastName'] != $user['last_name']) {
			return true;
		}
		// compare username
		if($stored_user['UserName'] != $user['username']) {
			return true;
		}

		return false;
	}
	
	public function update_user($user)
	{
		$email    = $user['username'] . '@facebook.com';
		
		$data = array(
			'UserID' => $user['user_id'],
			'FirstName' => $user['first_name'],
			'LastName' => $user['last_name'],
			'Name' => $user['first_name'] .' '. $user['last_name'],
			'UserName' => $user['username'],
			'Email' => $user['username'] . '@facebook.com',
		);
		
		$this->db->where('UserID', $user['user_id']);
		$this->db->update('users_facebook', $data);
	}
}
