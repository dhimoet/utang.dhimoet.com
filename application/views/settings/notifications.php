	<div data-role='content'>
		
		<ul data-role='listview'>
			<?foreach($notifications as $notification) {?>
			<li class='short_summary'>
				<?if($notification['Type'] == 'friend_request') {
					$url = "/settings/friend_request/{$notification['id']}/{$notification['friend']['id']}";
				} elseif($notification['Type'] == 'added_transaction') {
					$url = "/main/details/{$notification['TransactionId']}/{$notification['friend']['id']}";
				} else {
					$url = 'javascript:void(0)';
				}?>
				<a href='<?=$url;?>'>
					<div class='content_header'>
						<span class="list_title">
							<?=$notification['friend']['username'];?>
						</span> 
						<?if($notification['Type'] == 'friend_request') {?>
							has sent you a friend request
						<?} elseif($notification['Type'] == 'added_transaction') {?>
							has added a transaction
						<?} elseif($notification['Type'] == 'friend') {?>
							has accepted your friend request
						<?} elseif($notification['Type'] == 'rejected') {?>
							has rejected your friend request!
						<?}?>
					</div>
				</a>
			</li>
			<?}?>
		</ul>
		
	</div><!-- content container -->
