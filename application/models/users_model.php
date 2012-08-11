<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_id($email)
	{
		$this->db->select('id');
		$query = $this->db->get_where('users', array('email' => $email));

		return $query->row()->id;
	}
	
	/**
	 * Get an array of friends id's
	 */
	public function get_friends_ids()
	{
		// get user id's from the 2nd column of the table
		$my_id = $this->session->userdata['user_id'];
		$this->db->select('UserID2 as id');
		$query = $this->db->get_where('userrelationships', array('UserID1' => $my_id));
		$friend_ids = $query->result_array();
		
		// get user id's from the 2nd column of the table
		$this->db->select('UserID1 as id');
		$query = $this->db->get_where('userrelationships', array('UserID2' => $my_id));
		$friend_ids = array_merge($friend_ids, $query->result_array());
		
		// trim array
		$friend_ids_ = array();
		foreach($friend_ids as $friend) {
			array_push($friend_ids_, $friend['id']);
		}

		return $friend_ids_;
	}
	
	/**
	 * Get an array of friends informations
	 */
	public function get_friends($key = '')
	{
		$friends_ids = $this->get_friends_ids();		
		// get friends information
		$this->db->select('id, username, email');
		$this->db->where_in('id', $friends_ids);
		$query = $this->db->get('users');

		return $query->result_array();
	}
	
	public function get_friend($id)
	{
		$this->db->select('id, username, email');
		$query = $this->db->get_where('users', array('id' => $id));
		
		return $query->row();
	}
	
	/**
	 * Get an array of not friends
	 */
	public function get_not_friends($key = '')
	{
		$friends_ids = $this->get_friends_ids();		
		$this->db->select('id, username, email');
		$this->db->like('username', $key);
		$this->db->where('id !=', $this->session->userdata['user_id']);
		if(!empty($friends_ids)) {
			$this->db->where_not_in('id', $friends_ids);
		}
		$query = $this->db->get('users');
		$users = $query->result_array();
		array_multisort($users);
		
		return $users;
	}
	
	/**
	 * Store send friend request to database
	 */
	public function add_friend($id1, $id2)
	{
		$data = array(
			'UserID1' => $id1,
			'UserID2' => $id2,
			'Type' => 'friend_request'
		);
		$this->db->insert('userrelationships', $data);
		
		// create a notification
		$this->set_notification($id2, 'friend_request');
	}
	
	public function set_notification($to, $type)
	{
		$data = array(
			'SenderId' => $this->session->userdata['user_id'],
			'ReceiverId' => $to,
			'Type' => $type
		);
		$this->db->insert('notifications', $data);
	}
	
	public function get_notification_number()
	{
		$this->db->where('ReceiverId', $this->session->userdata['user_id']);
		$this->db->where('Viewed', 0);
		$query = $this->db->get('notifications');

		return $query->num_rows;
	}
	
	public function get_notifications()
	{
		$this->db->where('ReceiverId', $this->session->userdata['user_id']);
		$this->db->where('Viewed', 0);
		$query = $this->db->get('notifications');
		
		return $query->result_array();
	}
	
	public function clear_notifications()
	{
		echo 1; die;
		$this->db->where('ReceiverId', $this->session->userdata['user_id']);
		$this->db->update('notifications', array('Viewed' => 1));
	}
}
