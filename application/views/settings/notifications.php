	<div data-role='content'>
		
		<ul data-role='listview'>
			<?foreach($notifications as $notification) {?>
			<li class='short_summary'>
				<?if($notification['Type'] == 'friend_request') {
					$url = "/settings/friend_request/{$notification['id']}/{$notification['friend']['id']}";
				} elseif($notification['Type'] == 'added_transaction') {
					$url = '/main/details/';
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
						<?}?>
					</div>
				</a>
			</li>
			<?}?>
		</ul>
		
	</div><!-- content container -->
