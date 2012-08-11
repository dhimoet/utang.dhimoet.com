	<div data-role='content'>
		
		<?if($this->facebook_model->get_user_type($this->my_fb->get_user_profile()) == 'facebook.com') {?>
	
		<div class='label'>You are logged in using a Facebook account. This feature has been disabled.</div>
		
		<div class='label'>Please send a report for any concerns.</div>
	
		<?} else {?>
		
		<form name='change_password' action="/auth/change_password/" method="post" id='change_password' data-ajax="false">
			
			<div class='label'>Old Password:</div>
			
			<div>
				<input type='password' name='old' class='validate[required]' />
			</div>
			
			<div class='label'>New Password:</div>
			
			<div>
				<input type='password' name='new' id='password' class='validate[required]' />
			</div>
			
			<div class='label'>Confirm New Password:</div>
			
			<div>
				<input type='password' name='new_confirm' class='validate[required,equals[password]]' />
			</div>
			
			<div>
				<input type='submit' value='Submit' data-theme='b' />
			</div>
		
		</form>
		
		<?}?>
		
	</div>