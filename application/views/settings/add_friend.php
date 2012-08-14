	<div data-role='content'>
		
		<form name='add_friend' action="/settings/add_friend/?msg=0" method="post" id='add_friend' data-ajax="false">
			
			<div class='label'>Friend's Name:</div>
			
			<div>
				<input type='text' name='name' id='name' class='validate[required]' placeholder='Type a name here' />
				<input type='hidden' name='email' id='email' value='' />
			</div>
			
			<ul data-role='listview' id="user_list"></ul>
			
			<script id="user_template" type="text/template">
				<a href="javascript:void(0)">
					<div class="list_title"><%= username %></div>
					<div class="information"><%= email %></div>
					<div class="image_container">
						<img src="<%= photo %>" />
					</div>
				</a>
			</script>
			
			<div>
				<input type='submit' value='Send Request' data-theme='b' />
			</div>
		
		</form>
		
	</div>

