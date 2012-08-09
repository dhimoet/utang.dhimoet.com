	<div data-role='content'>
		<div class='content_header'>
			<div>First Last</div>
			<div class='amount_total amount_owned'>$500.00</div>
		</div>
		<ul data-role='listview'>
			<?for($i=0; $i<10; $i++) {?>
			<li class='short_summary'>
				<a href='/main/details/' data-transition='slide'>
					<div class='list_title'>Title</div>
					<div class='information'>Aug 06, 2012</div>
					<div class='list_amount amount_owned'>$100.00</div>
				</a>
			</li>
			<?}?>
		</ul>
	</div><!-- content container -->
