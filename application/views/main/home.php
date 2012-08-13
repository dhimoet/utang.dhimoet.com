	<div data-role='content'>
		
		<ul data-role='listview'>
			<?foreach($friends as $friend) {?>
			<li class='short_summary'>
				<a href='/main/summary/<?=$friend['id']?>/<?=$friend['total']?>'>
					<div class='list_title'><?=$friend['username']?></div>
					<div class='<?=($friend['total'] < 0)?'amount_owed':'amount_owned';?>'>
						You should 
						<?if($friend['total'] < 0) {
							echo 'collect $ ' . money_format('%i', $friend['total'] * -1);
						} else {
							echo 'return $ ' . money_format('%i', $friend['total']);
						}?>
					</div>
					<div class='information'>
						<?if(isset($friend['Timestamp'])) {
							echo 'Last activity on '. friendly_date($friend['Timestamp']);
						}
						else {
							echo 'No activity';
						}?>
					</div>
				</a>
			</li>
			<?}?>
			<li data-role="list-divider">
				You are logged in as <?=$this->session->userdata['user_id'];?>
			</li>
		</ul>
		
	</div><!-- content container -->

