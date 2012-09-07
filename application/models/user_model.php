<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_facebook_uid($id)
	{
		$this->db->select('facebook_user_id');
		$query = $this->db->get_where('users', array('id' => $id));
		
		return $query->row()->facebook_user_id;
	}
	
	/**
	 * Get an array of friends informations
	 */
	public function get_friends($key = '')
	{
		$friends_ids = $this->userrelationship_model->get_friends_ids();
				
		// get friends information
		$this->db->select('id, username, email, facebook_username');
		$this->db->where_in('id', $friends_ids);
		$query = $this->db->get('users');
		
		return $query->result_array();
	}
	
	public function get_friend($id)
	{
		$this->db->select('id, username, email, facebook_username');
		$query = $this->db->get_where('users', array('id' => $id));
		
		return $query->row_array();
	}
	
	/**
	 * Get an array of not friends
	 */
	public function get_not_friends($key = '')
	{
		$friends_ids = $this->userrelationship_model->get_friends_ids();		
		$this->db->select('id, username, email, facebook_username');
		$this->db->like('username', $key);
		$this->db->where('id !=', $this->ion_auth->user()->row()->id);
		if(!empty($friends_ids)) {
			$this->db->where_not_in('id', $friends_ids);
		}
		$query = $this->db->get('users');
		$users = $query->result_array();
		array_multisort($users);
		
		return $users;
	}
	
	public function get_id($email)
	{
		$this->db->select('id');
		$query = $this->db->get_where('users', array('email' => $email));

		return $query->row()->id;
	}
	
	public function get_username($id)
	{
		$this->db->select('username');
		$query = $this->db->get_where('users', array('id' => $id));

		return $query->row()->username;
	}
	
	public function get_logout_url()
	{
		$user = $this->get_facebook_uid($this->ion_auth->user()->row()->id);
		if($user) {
			return '/fb/logout/';
		}
		else {
			return '/auth/logout/';
		}
	}
}
