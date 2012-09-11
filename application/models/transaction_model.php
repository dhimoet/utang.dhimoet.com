<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_amount_owed($friend_id)
	{
		$me = $this->ion_auth->user()->row()->id;
		$this->db->select_sum('Amount');
		$this->db->where('Borrower', $me);
		$this->db->where('Lender', $friend_id);
		$this->db->where('Status', 'active');
		$query = $this->db->get('transactions');
		
		return $query->row()->Amount;
	}
	
	public function get_amount_owned($friend_id)
	{
		$me = $this->ion_auth->user()->row()->id;
		$this->db->select_sum('Amount');
		$this->db->where('Lender', $me);
		$this->db->where('Borrower', $friend_id);
		$this->db->where('Status', 'active');
		$query = $this->db->get('transactions');
		
		return $query->row()->Amount;
	}
	
	public function get_amount_total($friend_id)
	{
		return $this->get_amount_owed($friend_id) - $this->get_amount_owned($friend_id);
	}
	
	public function get_last_interaction($friend_id)
	{
		$result = $this->get_last_transaction_column($this->ion_auth->user()->row()->id, $friend_id);
		$result_ = $this->get_last_transaction_column($friend_id, $this->ion_auth->user()->row()->id);
		
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
		$this->db->where('Status', 'active');
		$this->db->order_by('Timestamp', 'desc');
		$query = $this->db->get('transactions', 1);
		
		return $query->row_array();
	}
	
	public function get_transactions($friend_id = '')
	{
		$result = $this->get_transactions_column($this->ion_auth->user()->row()->id, $friend_id);
		$result_ = $this->get_transactions_column($friend_id, $this->ion_auth->user()->row()->id);
		$result = array_merge($result, $result_);
		array_multisort($result, SORT_DESC);
		
		return $result;
	}
	
	public function get_transactions_column($borrower, $lender)
	{
		$this->db->like('Borrower', $borrower);
		$this->db->like('Lender', $lender);
		$this->db->where('Status', 'active');
		$this->db->order_by('Timestamp', 'desc');
		$query = $this->db->get('transactions', 20);
		
		return $query->result_array();
	}
	
	public function get_transaction($id)
	{
		$query = $this->db->get_where('transactions', array('id' => $id));
		
		return $query->row_array();
	}
	
	public function set_transaction_amount($transaction)
	{
		if($transaction['Lender'] == $this->ion_auth->user()->row()->id) {
			$transaction['Amount'] = (float)$transaction['Amount'] * -1;
		}
		
		return $transaction['Amount'];
	}
	
	public function save_transaction(Array $transaction)
	{
		$my_id = $this->ion_auth->user()->row()->id;
		
		if($transaction['action'] == 'I gave') {
			$borrower = $transaction['user'];
			$lender = $my_id;
		}
		else if($transaction['action'] == 'I received') {
			$borrower = $my_id;
			$lender = $transaction['user'];
		}

		$data = array(
			'Borrower' => $borrower,
			'Lender' => $lender,
			'Amount' => $transaction['amount'],
			'Title' => $transaction['title'],
			'Description' => $transaction['description'],
			'Reporter' => $my_id
		);
		
		// get the last transaction by this user
		$last = $this->get_last_interaction($transaction['user']);
		// check if the last transaction is similar within the last 2 minutes
		if(get_age($last['Timestamp']) < 2) {
			if($last['Borrower'] == $data['Borrower']
					&& $last['Lender'] == $data['Lender']
					&& $last['Amount'] == $data['Amount']
					&& $last['Title'] == $data['Title']
					&& $last['Description'] == $data['Description']
					&& $last['Reporter'] == $data['Reporter']) {
				return false;
			}
		}
		// store to database
		$this->db->insert('transactions', $data);
		
		// set notification
		$this->notification_model->set_notification($transaction['user'], 'added_transaction', 'active', $this->db->insert_id());
		
		return true;
	}
	
	public function delete_transaction($transaction_id)
	{
		$data = array(
			'Status' => 'deleted'
		);
		
		$this->db->where('id', $transaction_id);
		$this->db->update('transactions', $data);
	}
}
