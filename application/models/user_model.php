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
		$this->db->like('username', $key);
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
		$me = $this->ion_auth->user()->row()->id;
		$friends_ids = $this->userrelationship_model->get_friends_ids();		
		$this->db->select('id, username, email, facebook_username');
		$this->db->like('username', $key);
		$this->db->where('id !=', $me);
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
	
	/****************** NEW MODELS BELOW ******************/
	
	/**
	 * get a user's public information
	 *
	 * @access	public
	 * @param	int
	 * @return	object
	 */
	public function get_user($id)
	{
		$this->db->select('id, username, email, first_name, last_name, phone, facebook_user_id, facebook_username');
		$query = $this->db->get_where('users', array('id' => $id));
		
		return $query->row();
	}
	
	/**
	 * get a user's id
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	public function get_user_id($email)
	{
		$this->db->select('id');
		$query = $this->db->get_where('users', array('email' => $email));

		return $query->row()->id;
	}
	
	/**
	 * get all users' public information
	 *
	 * @access	public
	 * @param	array
	 * @return	object
	 */
	public function get_users($identity = array())
	{
		$this->db->select('id, username, email, first_name, last_name, phone, facebook_user_id, facebook_username');
		if(!empty($identity['id'])) {
			$this->db->like('id', $identity['id']);
		}
		if(!empty($identity['username'])) {
			$this->db->or_like('username', $identity['username']);
		}
		if(!empty($identity['email'])) {
			$this->db->or_like('email', $identity['email']);
		}
		if(!empty($identity['first_name'])) {
			$this->db->or_like('first_name', $identity['first_name']);
		}
		if(!empty($identity['last_name'])) {
			$this->db->or_like('last_name', $identity['last_name']);
		}
		if(!empty($identity['phone'])) {
			$this->db->or_like('phone', $identity['phone']);
		}
		if(!empty($identity['facebook_user_id'])) {
			$this->db->or_like('facebook_user_id', $identity['facebook_user_id']);
		}
		if(!empty($identity['facebook_username'])) {
			$this->db->or_like('facebook_username', $identity['facebook_username']);
		}
		$query = $this->db->get('users');
		
		return $query->result();
	}
	
	/**
	 * set a user's information
	 *
	 * @access	public
	 * @param	array
	 * @return	string
	 */
	public function set_user($identity)
	{
		// check user id
		if(!empty($identity['id'])) {
			
		}
	}
}
