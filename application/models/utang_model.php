<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utang_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Match username in database
	 */
	public function is_registered_user($email) 
	{
		$this->db->select('email');
		$query = $this->db->get_where('users', array('email' => $email));
		
		// make sure that the entry only returns 1, not 0 or greater than 1
		if($query->num_rows() == 1) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public function fb_create_user(Array $user)
	{
		if (!empty($user))
		{
			$username = strtolower($user['first_name']) . ' ' . strtolower($user['last_name']);
			$email    = $user['email'];
			$password = $user['password'];

			$additional_data = array(
				'first_name' => $user['first_name'],
				'last_name'  => $user['last_name'],
			);
		}
		if (!empty($user) && $this->ion_auth->register($username, $password, $email, $additional_data))
		{ 
			//check to see if we are creating the user
			//redirect them back to the admin page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		}
	}
	
	public function fb_login(Array $user) 
	{
		if ($this->ion_auth->login($user['email'], $user['password'], true))
			{ 
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect($this->config->item('base_url'), 'refresh');
			}
			else
			{ 
				//if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
			}
	}
}
