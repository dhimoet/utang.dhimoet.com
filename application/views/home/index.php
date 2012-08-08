<div data-role='page' data-title='home' id='home'>
  
	<div data-theme='b' data-role='header' data-position='fixed'>
		<h3><?=$title;?></h3>
		<a onclick='window.location.reload()' data-role='button' data-icon='refresh'>Refresh</a>
		<a href='/utang/add/' data-role='button' data-icon='plus'>Add</a>
	</div>
  
	<div data-role='content'>
		<ul data-role='listview'>
			<li class='short_summary'>
				<a href='/summary/'>
					<div class='friend_name'><h1>First Last</h1></div>
					<div class='amount_owned'>You should collect $100</div>
					<div class='timestamp_1'>Last activity on Aug 06, 2012</div>
				</a>
			</li>
		</ul>
	</div><!-- content container -->
  
	<div data-role='footer' data-position='fixed' >
		<div data-role="controlgroup" data-type="horizontal">
			<a href="/utang/home/" data-role="button" data-icon="home" data-iconpos='top' style='width:33%'>Home</a>
			<a href="/utang/activity/" data-role="button" data-icon="star" data-iconpos='top' style='width:33%'>Activity</a>
			<a href="/utang/settings/" data-role="button" data-icon="gear" data-iconpos='top' style='width:33%'>Settings</a>
		</div>
	</div>

</div><!-- index container -->
