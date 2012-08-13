	<div data-role='content'>
		
		<ul data-role='listview'>
			<?foreach($friends as $friend) {?>
			<li class='short_summary'>
				<a href='/main/summary/<?=$friend['id']?>/<?=$friend['total']?>'>
					<div class='list_title'><?=$friend['username']?></div>
					<div class='<?=($friend['total'] < 0)?'amount_owed':'amount_owned';?>'>
						You should 
						<?=($friend['total'] < 0) ?
							'collect $'.money_format('%i', $friend['total']*-1) :
							'return $'.money_format('%i', $friend['total']);?>
					</div>
					<div class='information'>
						<?=isset($friend['Timestamp']) ?
							'Last activity on '.$friend['Timestamp'] :
							'No activity'?>
					</div>
				</a>
			</li>
			<?}?>
		</ul>
		
	</div><!-- content container -->

