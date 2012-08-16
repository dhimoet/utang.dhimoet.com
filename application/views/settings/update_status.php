	<div data-role='content'>
		
		<form name='update_status' action="/settings/update_status/?msg=1" method="post" data-ajax="false">
			
			<div class='label'>Message:</div>
			
			<div>
				<textarea name='message' id='message' class='validate[required]' placeholder='This will go to your newsfeed'></textarea>
			</div>

			<div>
				<input type='submit' value='Publish now!' data-theme='b' />
			</div>
		
		</form>
		
	</div>
