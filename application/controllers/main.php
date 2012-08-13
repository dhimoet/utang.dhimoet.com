<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		/*** check login status ***/
		if (!$this->ion_auth->logged_in() && !$this->my_fb->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		
		/*** construct html page ***/
		$title = ucwords(str_replace('_', ' ',$this->router->fetch_method()));
		$this->head['title'] = $title;
		
		/*** get notification number ***/
		$this->data['notif'] = $this->users_model->get_notification_number();
	}
	
	public function index()
	{
		$this->head['title'] = "Home";
		$this->home();
	}
	
	public function home()
	{
		// get friends' basic information (array)
		$friends = $this->users_model->get_friends();
		
		// get interaction with each friend
		foreach($friends as &$friend) {
			// get last interaction
			$last_interaction = $this->users_model->get_last_interaction($friend['id']);
			array_shift($last_interaction); 
			$friend = array_merge($friend, $last_interaction);
			
			// get total transaction amount
			$friend['total'] = $this->users_model->get_amount_total($friend['id']);
		}
		$this->data['friends'] = $friends;
		
		$this->load->view('templates/base_header', $this->head);
		$this->load->view('templates/nav_header', $this->head);
		$this->load->view('main/home', $this->data);
		$this->load->view('templates/nav_footer');
		$this->load->view('templates/base_footer');
	}
	
	public function summary($friend_id = 0, $total = 0)
	{
		if($friend_id && $total) {
			// get a specific user/friend information
			$friend = $this->users_model->get_friend($friend_id);
			$this->data['friend'] = $friend;
			$this->data['friend']['total'] = $total;
			
			// get all transactions from that friend
			$transactions = $this->users_model->get_transactions($friend_id);
			foreach($transactions as &$transaction) {
				$transaction['Amount'] = $this->users_model->set_transaction_amount($transaction);
			}
			$this->data['transactions'] = $transactions;
		}
		else {
			$this->data['friend'] = array(
				'username' => '',
				'total' => 0,
			);
			$this->data['transactions'] = array();
		}

		$this->load->view('templates/base_header', $this->head);
		$this->load->view('templates/nav_header', $this->head);
		$this->load->view('main/summary', $this->data);
		$this->load->view('templates/nav_footer');
		$this->load->view('templates/base_footer');
	}
	
	public function details($id = 0)
	{
		if($id) {
			// get a specific transaction
			$transaction = $this->users_model->get_transaction($id);
			
			// get a specific user/friend
			if($transaction['Borrower'] != $this->session->userdata['user_id']) {
				$friend_id = $transaction['Borrower'];
			}
			else {
				$friend_id = $transaction['Lender'];
			}
			$this->data['friend'] = $this->users_model->get_friend($friend_id);
			
			if($transaction['Reporter'] == $friend_id) {
				$transaction['Reporter'] = $this->data['friend']['username'];
			}
			else {
				$transaction['Reporter'] = 'You';
			}
			$transaction['Amount'] = $this->users_model->set_transaction_amount($transaction);
			$this->data['transaction'] = $transaction;
		}
		else {
			$this->data['friend'] = array(
				'username' => '',
			);
			$this->data['transaction'] = array(
				'Amount' => 0,
				'Timestamp' => '0000-00-00 00:00:00',
				'Title' => '',
				'Description' => '',
				'Reporter' => ''
			);
		}
		
		$this->load->view('templates/base_header', $this->head);
		$this->load->view('templates/nav_header', $this->head);
		$this->load->view('main/details', $this->data);
		$this->load->view('templates/nav_footer');
		$this->load->view('templates/base_footer');
	}
	
	public function history()
	{
		// get all transaction related to this user
		$transactions = $this->users_model->get_transactions();
		foreach($transactions as &$transaction) {
			$transaction['Amount'] = $this->users_model->set_transaction_amount($transaction);
		}
		$this->data['transactions'] = $transactions;
		
		$this->load->view('templates/base_header', $this->head);
		$this->load->view('templates/nav_header', $this->head);
		$this->load->view('main/history', $this->data);
		$this->load->view('templates/nav_footer');
		$this->load->view('templates/base_footer');
	}
	
	public function add_transaction()
	{
		$this->load->view('templates/base_header', $this->head);
		$this->load->view('templates/nav_header', $this->head);
		$this->load->view('main/add_transaction', $this->data);
		$this->load->view('templates/nav_footer');
		$this->load->view('templates/base_footer');
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
