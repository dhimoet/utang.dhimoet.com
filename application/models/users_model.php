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
	 * This returns 0 for empty list
	 */
	public function get_friends_ids()
	{
		// get user id's from the 2nd column of the table
		$my_id = $this->session->userdata['user_id'];
		$this->db->select('UserID2 as id');
		$this->db->where('Type', 'friend');
		$this->db->where('UserID1', $my_id);
		$query = $this->db->get('userrelationships');
		$friend_ids = $query->result_array();
		
		// get user id's from the 2nd column of the table
		$this->db->select('UserID1 as id');
		$this->db->where('Type', 'friend');
		$this->db->where('UserID2', $my_id);
		$query = $this->db->get('userrelationships');
		$friend_ids = array_merge($friend_ids, $query->result_array());
		
		if(empty($friend_ids)) {
			return 0;
		}
		else {
			// trim array
			$friend_ids_ = array();
			foreach($friend_ids as $friend) {
				array_push($friend_ids_, $friend['id']);
			}
	
			return $friend_ids_;
		}
	}
	
	/**
	 * Get a object of friends informations
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
		
		return $query->row_array();
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
		$query = $this->db->get('notifications');
		
		return $query->result_array();
	}
	
	public function clear_notifications()
	{
		$this->db->where('ReceiverId', $this->session->userdata['user_id']);
		$this->db->update('notifications', array('Viewed' => 1));
	}

	public function get_amount_owed($friend_id)
	{
		$this->db->select_sum('Amount');
		$this->db->where('Borrower', $this->session->userdata['user_id']);
		$this->db->where('Lender', $friend_id);
		$query = $this->db->get('transactions');
		
		return $query->row()->Amount;
	}
	
	public function get_amount_owned($friend_id)
	{
		$this->db->select_sum('Amount');
		$this->db->where('Lender', $this->session->userdata['user_id']);
		$this->db->where('Borrower', $friend_id);
		$query = $this->db->get('transactions');
		
		return $query->row()->Amount;
	}
	
	public function get_amount_total($friend_id)
	{
		return $this->get_amount_owed($friend_id) - $this->get_amount_owned($friend_id);
	}
	
	public function get_last_interaction($friend_id)
	{
		$result = $this->get_last_transaction_column($this->session->userdata['user_id'], $friend_id);
		$result_ = $this->get_last_transaction_column($friend_id, $this->session->userdata['user_id']);
		
		// compare which one is the latest
		// compare the ID's for now
		if(empty($result)) {
			$result['id'] = 0;
		}
		if(empty($result_)) {
			$result_['id'] = 0;
		}
		
		if($result['id'] > $result_['id']) {
			return $result;
		}
		else {
			return $result_;
		}
	}
	
	public function get_last_transaction_column($borrower, $lender)
	{
		$this->db->where('Borrower', $borrower);
		$this->db->where('Lender', $lender);
		$this->db->order_by('Timestamp', 'desc');
		$query = $this->db->get('transactions', 1);
		
		return $query->row_array();
	}
	
	public function get_transactions($friend_id = '')
	{
		$result = $this->get_transactions_column($this->session->userdata['user_id'], $friend_id);
		$result_ = $this->get_transactions_column($friend_id, $this->session->userdata['user_id']);
		$result = array_merge($result, $result_);
		array_multisort($result, SORT_DESC);
		
		return $result;
	}
	
	public function get_transactions_column($borrower, $lender)
	{
		$this->db->like('Borrower', $borrower);
		$this->db->like('Lender', $lender);
		$this->db->order_by('Timestamp', 'desc');
		$query = $this->db->get('transactions', 10);
		
		return $query->result_array();
	}
	
	public function get_transaction($id)
	{
		$query = $this->db->get_where('transactions', array('id' => $id));
		
		return $query->row_array();
	}
	
	public function set_transaction_amount($transaction)
	{
		if($transaction['Lender'] == $this->session->userdata['user_id']) {
			$transaction['Amount'] = (float)$transaction['Amount'] * -1;
		}
		
		return $transaction['Amount'];
	}
}
