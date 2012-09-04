	<script>
		function logout() {
			self.location = '<?=$this->users_model->get_logout_url();?>';
		}
	</script>

	<div data-role='content' class='centered'>
		
		<ul data-role='listview' data-inset='true'>
			
			<li>
				<a href='/settings/add_friend/'>Add a Friend</a>
			</li>
		
		</ul>
		
		<ul data-role='listview' data-inset='true' <?=($notif)?"data-theme='b'":'';?>>
			
			<li>
				<a href='/settings/notifications/'>Notifications<span class='ui-li-count'><?=$notif;?></span></a>
			</li>
		
		</ul>
		
		<ul data-role='listview' data-inset='true'>
			
			<li>
				<a href='/settings/update_status/'>Update Facebook Status</a>
			</li>
			<!--<li>
				<a href='/settings/change_password/'>Change Password</a>
			</li>-->
			<li>
				<a href='/settings/report_tool/'>Report to Developer</a>
			</li>
			<li>
				<a href='/settings/help/'>Help</a>
			</li>
			
		</ul>
      
		<a href='javascript:void(0)' data-role='button' data-theme='e' data-ajax='false' onclick='logout();'>
			Logout <?=$this->users_model->get_username($this->ion_auth->user()->row()->id);?>
		</a>
	
	</div>
