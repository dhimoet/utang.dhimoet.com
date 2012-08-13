	<div data-role='content'>
		
		<div class='details_label'>Transaction With:</div>
		
		<div class='list_title'><?=$friend['username']?></div>
		
		<hr />
		
		<div class='details_label'>Action:</div>
		
		<div class='list_title <?=($transaction['Amount'] < 0)?'amount_owed':'amount_owned';?>'>
			<strong>
				You <?=($transaction['Amount'] < 0)?'gave':'received';?> $
				<?if($transaction['Amount'] < 0) {
					echo money_format('%i', $transaction['Amount'] * -1);
				} else {
					echo money_format('%i', $transaction['Amount']);
				}?>
			</strong>
		</div>
		
		<hr />
		
		<div class='details_label'>Date/Time:</div>
		
		<div class='list_title'>
			<?=friendly_date_time($transaction['Timestamp']);?>
		</div>
		
		<hr />
		
		<div class='details_label'>Descriptions:</div>
		
		<div class='list_title'>
			<?=$transaction['Title'];?>
			<br />
			<?=$transaction['Description'];?>
		</div>
		
		<hr />
		
		<div class='details_label information'>
			This transaction was added by: <?=$transaction['Reporter'];?>
		</div>
		
	</div><!-- content container -->
