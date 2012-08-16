	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	<div data-role='content' class='centered'>
		
		<ul data-role='listview' data-inset='true'>
			
			<li>
				<a href='/settings/add_friend/'>Add a Friend</a>
			</li>
		
		</ul>
		
		<ul data-role='listview' data-inset='true' data-theme='b'>
			
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
      
		<a href='<?=$this->users_model->get_logout_url();?>' data-role='button' data-theme='e' data-ajax='false'>
			Logout <?=$this->users_model->get_username($this->session->userdata['user_id']);?>
		</a>
		
		<div class="fb-like top_20" 
			data-href="http://utang.dhimoet.com" 
			data-send="false" 
			data-width="450" 
			data-show-faces="true" 
			data-action="like" 
			data-font="verdana">
		</div>
	
	</div>
