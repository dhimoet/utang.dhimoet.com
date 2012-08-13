	<div data-role='content'>
		
		<div class='content_header'>
			<div><?=$friend['username']?></div>
			<div class='amount_total <?=($friend['total'] < 0)?'amount_owed':'amount_owned';?>'>$
				<?if($friend['total'] < 0) {
					echo money_format('%i', $friend['total'] * -1);
				} else {
					echo money_format('%i', $friend['total']);
				}?>
			</div>
		</div>
		<ul data-role='listview'>
			<?foreach($transactions as $transaction) {?>
			<li class='short_summary'>
				<a href='/main/details/<?=$transaction['id']?>'>
					<div class='list_title'><?=$transaction['Title'];?></div>
					<div class='information'><?=friendly_date($transaction['Timestamp']);?></div>
					<div class='list_amount <?=($transaction['Amount'] < 0)?'amount_owed':'amount_owned';?>'>$
						<?if($transaction['Amount'] < 0) {
							echo money_format('%i', $transaction['Amount'] * -1);
						} else {
							echo money_format('%i', $transaction['Amount']);
						}?>
					</div>
				</a>
			</li>
			<?}?>
		</ul>
		
	</div><!-- content container -->
