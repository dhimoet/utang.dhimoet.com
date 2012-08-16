	<div data-role='content'>
		
		<form name='report_tool' action="/settings/report_tool/" method="post" data-ajax="false">
			
			<div class='label'>Title:</div>
			
			<div>
				<input type='text' name='title' id='title' class='validate[required]' placeholder='What do you want to report?' />
			</div>
			
			<div class='label'>Description:</div>
			
			<div>
				<textarea name='description' id='description' class='validate[required]' placeholder='Please tell me more'></textarea>
			</div>
			
			<div>
				<input type='submit' value='Send Report' data-theme='b' />
			</div>
		
		</form>
		
	</div>
