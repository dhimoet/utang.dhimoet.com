<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function set_notification($to, $type, $status = 'active', $id = null)
	{
		$data = array(
			'SenderId' => $this->ion_auth->user()->row()->id,
			'ReceiverId' => $to,
			'Type' => $type,
			'Status' => $status,
		);
		if($status == 'active' && ($type == 'added_transaction' || $type == 'deleted_transaction')) {
			$data['TransactionId'] = $id;
		}
		$this->db->insert('notifications', $data);
		
		if($status == 'inactive') {
			$this->db->where('id', $id);
			$this->db->update('notifications', array('Status' => $status));
		}
	}
	
	public function get_notification_number()
	{
		$this->db->where('ReceiverId', $this->ion_auth->user()->row()->id);
		$this->db->where('Viewed', 0);
		$query = $this->db->get('notifications');

		return $query->num_rows;
	}
	
	public function get_notification($id)
	{
		$query = $this->db->get_where('notifications', array('id' => $id));
		
		return $query->row_array();
	}
	
	public function get_notifications()
	{
		$this->db->where('ReceiverId', $this->ion_auth->user()->row()->id);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('notifications');
		
		return $query->result_array();
	}
	
	public function clear_notifications()
	{
		$this->db->where('ReceiverId', $this->ion_auth->user()->row()->id);
		$this->db->update('notifications', array('Viewed' => 1));
	}
}
