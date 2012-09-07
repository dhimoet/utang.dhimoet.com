<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userrelationship_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Get an array of friends id's
	 * This returns 0 for empty list
	 */
	public function get_friends_ids()
	{
		// get user id's from the 2nd column of the table
		$my_id = $this->ion_auth->user()->row()->id;
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
	
	public function is_friend($friend_id)
	{
		$condition1 = array(
			'Type' => 'friend',
			'UserID1' => $this->ion_auth->user()->row()->id,
			'UserID2' => $friend_id,
		);
		$condition2 = array(
			'Type' => 'friend',
			'UserID1' => $friend_id,
			'UserID2' => $this->ion_auth->user()->row()->id,
		);
		
		$query1 = $this->db->get_where('userrelationships', $condition1);
		$query2 = $this->db->get_where('userrelationships', $condition2);
		
		return $query1->num_rows() + $query2->num_rows();
	}
	
	/**
	 * Store send friend request to database
	 */
	public function set_relationship($id1, $id2, $type = 'friend_request', $status = 'active', $notification_id = 0)
	{
		$data = array(
			'UserID1' => $id1,
			'UserID2' => $id2,
			'Type' => $type
		);
		$data2 = array(
			'UserID1' => $id2,
			'UserID2' => $id1,
			'Type' => $type
		);
		// check for existing entries
		$query = $this->db->get_where('userrelationships', $data);
		$query2 = $this->db->get_where('userrelationships', $data2);
		if(!$query->num_rows() && !$query2->num_rows()) {
			if($type == 'friend_request') {
				$this->db->insert('userrelationships', $data);
			}
			else {
				$this->db->where(array('UserID1' => $id1, 'UserID2' => $id2));
				$this->db->update('userrelationships', $data);
			}
			
			// create a notification
			if($this->ion_auth->user()->row()->id == $id1) {
				$to = $id2;
			}
			else {
				$to = $id1;
			}
			$this->notification_model->set_notification($to, $type, $status, $notification_id);
		}
		else {
			// error message
		}
	}
}
