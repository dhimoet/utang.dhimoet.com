<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facebookuser_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function set()
	{
		$this->my_fb->set_extended_access_token();
		
		$data = array(
			'session_id' => $this->session->userdata('session_id'),
			'user_id' => $this->my_fb->get_user(),
			'token' => $this->my_fb->get_access_token(),
		);
		$query = $this->db->get_where('facebook_users', array('user_id' => $data['user_id']));
		//print_rf($query->row_array()); die;
		$row = $query->row_array();
		if(empty($row)) {
			$this->db->insert('facebook_users', $data);
		}
		else {
			$this->db->where('user_id', $data['user_id']);
			$this->db->update('facebook_users', $data);
		}
	}
	
	public function get($session_id = false)
	{
		if(!$session_id) {
			$session_id = $this->session->userdata('session_id');
		}
		$query = $this->db->get_where('facebook_users', array('session_id' => $session_id));
		$q = $query->row_array();
		//print_rf($q); die;
		if(empty($q)) {
			return false;
		}
		else {
			return $query->row();
		}
	}
}
