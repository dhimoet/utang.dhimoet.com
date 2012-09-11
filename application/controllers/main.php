<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		/*** check login statuses ***/
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/logout', 'refresh');
		}
		
		if(!$this->my_fb->logged_in())
		{
			// get user's session and token
			$fu = $this->facebookuser_model->get();
			if($fu && $fu->token) {
				$config = array('access_token' => $fu->token);
				$this->my_fb->initialize($config);
			}
			else {
				//redirect them to the login page
				redirect('auth/logout', 'refresh');
			}
		}
		
		/*** construct html page ***/
		$title = ucwords(str_replace('_', ' ',$this->router->fetch_method()));
		$this->head['title'] = $title;
		
		/*** get notification number ***/
		$this->data['notif'] = $this->notification_model->get_notification_number();
	}
	
	public function index()
	{
		$this->head['title'] = "Home";
		$this->home();
	}
	
	public function home()
	{
		// get friends' basic information (array)
		$friends = $this->user_model->get_friends();
		
		// get interaction with each friend
		foreach($friends as &$friend) {
			// get last interaction
			$last_interaction = $this->transaction_model->get_last_interaction($friend['id']);
			array_shift($last_interaction); 
			$friend = array_merge($friend, $last_interaction);
			
			// get total transaction amount
			$friend['total'] = $this->transaction_model->get_amount_total($friend['id']);
		}
		$this->data['friends'] = $friends;
		
		$this->load->view('templates/base_header', $this->head);
		$this->load->view('templates/nav_header', $this->head);
		$this->load->view('main/home', $this->data);
		$this->load->view('templates/overlay_template');
		$this->load->view('backbone_js', $this->head['title']);
		$this->load->view('templates/nav_footer');
		$this->load->view('templates/base_footer');
	}
	
	public function summary($friend_id = 0, $total = 0)
	{
		if($friend_id && $this->userrelationship_model->is_friend($friend_id)) {
			// get a specific user/friend information
			$friend = $this->user_model->get_friend($friend_id);
			$this->data['friend'] = $friend;
			$this->data['friend']['total'] = $total;
			
			// get all transactions from that friend
			$transactions = $this->transaction_model->get_transactions($friend_id);
			foreach($transactions as &$transaction) {
				$transaction['Amount'] = $this->transaction_model->set_transaction_amount($transaction);
			}
			$this->data['transactions'] = $transactions;
		}
		else {
			$this->data['friend'] = array(
				'username' => 'User not found!',
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
	
	public function details($id = 0, $friend_id = 0)
	{
		// get a specific transaction
		$transaction = $this->transaction_model->get_transaction($id);
		
		// match the parameters with the entry from database
		if(!empty($transaction) && ($transaction['Borrower'] == $friend_id || $transaction['Lender'] == $friend_id)) {
			$is_valid = true;
		}
		else {
			$is_valid = false;
		}
		
		if(!empty($transaction) && $is_valid && $this->userrelationship_model->is_friend($friend_id)) {
			

			$this->data['friend'] = $this->user_model->get_friend($friend_id);
			
			if($transaction['Reporter'] == $friend_id) {
				$transaction['reporter_name'] = $this->data['friend']['username'];
			}
			else {
				$transaction['reporter_name'] = 'You';
			}
			$transaction['Amount'] = $this->transaction_model->set_transaction_amount($transaction);
			// calculate the age of this transaction
			$transaction['age'] = get_age($transaction['Timestamp']);
			$this->data['transaction'] = $transaction;
		}
		else {
			$this->data['friend'] = array(
				'username' => 'Data Error!',
			);
			$this->data['transaction'] = array(
				'Amount' => 0,
				'Timestamp' => '0000-00-00 00:00:00',
				'Title' => '',
				'Description' => 'We received incorrect data and were unable to process it',
				'reporter_name' => '',
				'age' => 0
			);
		}
		
		$this->load->view('templates/base_header', $this->head);
		$this->load->view('templates/nav_header', $this->head);
		$this->load->view('main/details', $this->data);
		$this->load->view('templates/overlay_template');
		$this->load->view('backbone_js', $this->head['title']);
		$this->load->view('templates/nav_footer');
		$this->load->view('templates/base_footer');
	}
	
	public function history()
	{
		// get all transaction related to this user
		$transactions = $this->transaction_model->get_transactions();
		foreach($transactions as &$transaction) {
			$transaction['Amount'] = $this->transaction_model->set_transaction_amount($transaction);
			// get a specific user/friend
			if($transaction['Borrower'] != $this->ion_auth->user()->row()->id) {
				$transaction['friend_id'] = $transaction['Borrower'];
			}
			else {
				$transaction['friend_id'] = $transaction['Lender'];
			}
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
		$this->form_validation->set_rules('add_transaction[user]', 'User', 'required');
		$this->form_validation->set_rules('add_transaction[amount]', 'Amount', 'required');
		$this->form_validation->set_rules('add_transaction[title]', 'Title', 'required');
		
		if ($this->form_validation->run() == true) {
			$transaction = $this->input->post('add_transaction');
			// store to database
			if($this->transaction_model->save_transaction($transaction)) {
				redirect('/main/home/?msg=3', 'refresh');
			}
			else {
				redirect('/main/home/?msg=7', 'refresh');
			}
		}
		else {
			// get a list of friends
			$this->data['friends'] = $this->user_model->get_friends();
		
			$this->load->view('templates/base_header', $this->head);
			$this->load->view('templates/nav_header', $this->head);
			$this->load->view('main/add_transaction', $this->data);
			$this->load->view('templates/overlay_template');
			$this->load->view('backbone_js', $this->head['title']);
			$this->load->view('templates/nav_footer');
			$this->load->view('templates/base_footer');
		}
	}
	
	public function delete_transaction($transaction_id, $friend_id) 
	{
		// match the transaction and the owner
		$condition = array(
			'id' => $transaction_id,
		);
		$query = $this->db->get_where('transactions', $condition);

		if($query->num_rows() === 1 
				&& $query->row()->Reporter == $this->ion_auth->user()->row()->id
				&& get_age($query->row()->Timestamp) < 60) {
			$this->transaction_model->delete_transaction($transaction_id);
			
			// create a notification
			$this->notification_model->set_notification($friend_id, 'deleted_transaction', 'active', $transaction_id);
			redirect('/main/home/?msg=5', 'refresh');
		}
		else {
			redirect('/main/home/?msg=0', 'refresh');
		}
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
