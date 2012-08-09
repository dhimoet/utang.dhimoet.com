	<div data-role='content'>
		
		<form name='add_friend' action="/settings/add_friend/" method="post" id='add_friend' data-ajax="false">
			
			<div class='label'>Friend's Name:</div>
			
			<div>
				<input type='text' name='name' id='name' class='validate[required]' placeholder='Type a name here' />
			</div>
			
			<div>
				<select id="name_list">
					<option value=''>Browse here</option>
				</select>
			</div>
			
			<div>
				<input type='submit' value='Send Request' data-theme='b' />
			</div>
		
		</form>
		
	</div>
