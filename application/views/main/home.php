<div data-role='page' data-title='<?=$title;?>' id='<?=strtolower($title);?>'>
  
	<div data-theme='b' data-role='header' data-position='fixed'>
		<h3><?=$title;?></h3>
		<a onclick='window.location.reload()' data-role='button' data-icon='refresh'>Refresh</a>
		<a href='/utang/add/' data-role='button' data-icon='plus'>Add</a>
	</div>
  
	<div data-role='content'>
		<ul data-role='listview'>
			<?for($i=0; $i<10; $i++) {?>
			<li class='short_summary'>
				<a href='/main/summary/'>
					<div class='list_title'>First Last</div>
					<div class='amount_owned'>You should collect $100.00</div>
					<div class='timestamp_1'>Last activity on Aug 06, 2012</div>
				</a>
			</li>
			<?}?>
		</ul>
	</div><!-- content container -->
  
	<div data-role='footer' data-position='fixed' >
		<div data-role="controlgroup" data-type="horizontal">
			<a href="/main/home/" data-role="button" data-icon="home" data-iconpos='top' style='width:33%'>Home</a>
			<a href="/main/history/" data-role="button" data-icon="star" data-iconpos='top' style='width:33%'>Activity</a>
			<a href="/main/settings/" data-role="button" data-icon="gear" data-iconpos='top' style='width:33%'>Settings</a>
		</div>
	</div>

</div><!-- index container -->
