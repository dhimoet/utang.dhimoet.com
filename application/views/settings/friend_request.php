	<div data-role='content'>
		
		<div class='details_label'>Friend Request From:</div>
		
		<div class='list_title'><?=$friend['username'];?></div>
		
		<hr />
		
		<div class='details_label'>Date/Time:</div>
		
		<div class='list_title'>
			<?=friendly_date_time($notification['Timestamp']);?>
		</div>
		
		<hr />
		
		<div class='details_label'>Options:</div>
		
		<div class='list_title ui-grid-a'>
			<div class="ui-block-a">
				<form action='/settings/accept_friend/<?=$friend['id']?>'>
					<input type='submit' value='Accept' data-theme='b' />
				</form>
			</div>
			<div class="ui-block-b">
				<form action='/settings/reject_friend/'>
					<input type='submit' value='Reject' />
				</form>
			</div>
		</div>
		
		<hr />
		
		<div class='details_label information'>

		</div>
		
	</div><!-- content container -->
