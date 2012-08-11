	<div data-role='content'>
		
		<ul data-role='listview'>
			<?foreach($notifications as $notif) {?>
			<li class='short_summary'>
				<a href='/main/details/'>
					<div class='content_header'>
						<span class="list_title">
							<?=$this->users_model->get_friend($notif['SenderId'])->username;?>
						</span> 
						<?if($notif['Type'] == 'friend_request') {?>
							has sent you a friend request
						<?} elseif($notif['Type'] == 'added_transaction') {?>
							has added a transaction
						<?}?>
					</div>
				</a>
			</li>
			<?}?>
		</ul>
		
	</div><!-- content container -->
