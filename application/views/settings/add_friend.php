	<div data-role='content'>
		
		<form name='add_friend' action="/settings/add_friend/" method="post" id='add_friend' data-ajax="false">
			
			<div class='label'>Friend's Name:</div>
			
			<div>
				<input type='text' name='name' id='name' class='validate[required]' placeholder='Type a name here' />
			</div>
			
			<ul data-role='listview' id="user_list"></ul>
			
			<script id="user_template" type="text/template">
				<li class='short_summary'>
					<div class="list_title"><%= username %></div>
					<div class="information"><%= email %></div>
					<div class="image_container">
						<img src="<%= photo %>" />
					</div>
				</li>
			</script>
			
			<div>
				<input type='submit' value='Send Request' data-theme='b' />
			</div>
		
		</form>
		
	</div>
	
	<script type="text/javascript" src="/static/js/friend_list.js"></script>
	<script type="text/javascript" src="/static/js/script.js"></script>
