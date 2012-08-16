	<div data-role='content'>
		
		<ul data-role='listview'>
			<?foreach($transactions as $transaction) {?>
			<li class='short_summary'>
				<a href='/main/details/<?=$transaction['id']?>/<?=$transaction['friend_id']?>'>
					<div class='list_title'><?=$transaction['Title']?></div>
					<div class='<?=($transaction['Amount'] < 0)?'amount_owed':'amount_owned';?>'>
						<?if($transaction['Amount'] < 0) {
							echo 'You gave $ ' . money_format('%i', $transaction['Amount'] * -1);
						} else {
							echo 'You received $ ' . money_format('%i', $transaction['Amount']);
						}?>
					</div>
					<div class='information'><?=friendly_date($transaction['Timestamp'])?></div>
				</a>
			</li>
			<?}?>
		</ul>
		
	</div><!-- content container -->
