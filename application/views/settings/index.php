	<div data-role='content'>
		
		<ul data-role='listview' data-inset='true'>
			
			<li>
				<a href='/settings/add_friend/'>Add a Friend</a>
			</li>
		
		</ul>
		
		<ul data-role='listview' data-inset='true'>
			
			<li>
				<a href='/settings/notifications/'>Notifications<span class='ui-li-count'><?=$notif;?></span></a>
			</li>
		
		</ul>
		
		<ul data-role='listview' data-inset='true'>
			
			<li>
				<a href='/settings/change_password/'>Change Password</a>
			</li>
			<li>
				<a href='/settings/report_tool/'>Report to Developer</a>
			</li>
			<li>
				<a href='/settings/help/'>Help</a>
			</li>
			
		</ul>
      
		<a href='<?=$this->users_model->get_logout_url();?>' data-role='button' data-theme='e' data-ajax='false'>
			Logout <?=$this->users_model->get_username($this->session->userdata['user_id']);?>
		</a>
	
	</div>
