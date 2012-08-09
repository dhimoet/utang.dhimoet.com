	<div data-role='content'>
		
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
		
	</div>
