	<div data-role='content'>
		
		<div class='details_label'>Friend Request From:</div>
		
		<div class='list_title'><?=$friend['username'];?></div>
		
		<hr />
		
		<div class='details_label'>Date/Time:</div>
		
		<div class='list_title'>
			<?=friendly_date_time($notification['Timestamp']);?>
		</div>
		
		<hr />
		<?if($notification['Status'] == 'active') {?>
		<div class='details_label'>Options:</div>
		
		<div class='list_title ui-grid-a'>
			<div class="ui-block-a">
				<form action='/settings/respond_request/friend/<?=$notification['id']?>/<?=$friend['id']?>' data-ajax='false'>
					<input type='submit' value='Accept' data-theme='b' />
				</form>
			</div>
			<div class="ui-block-b">
				<form action='/settings/respond_request/rejected/<?=$notification['id']?>/<?=$friend['id']?>' data-ajax='false'>
					<input type='submit' value='Reject' />
				</form>
			</div>
		</div>
		
		<hr />
		<?}?>
		
	</div><!-- content container -->
