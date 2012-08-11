<script>
$(document).ready(function() {
	<?if($notif) {?>
		/*** bind notification popup ***/
		$('#settings').validationEngine('showPrompt', <?=$notif;?>, 'red', 'topLeft');
	<?}?>
});
</script>

	<div data-role='footer' data-position='fixed' >
		<div data-role="controlgroup" data-type="horizontal">
			<a href="/main/home/" data-role="button" data-icon="home" 
				data-iconpos='top' style='width:33%'>Home</a>
			<a href="/main/history/" data-role="button" data-icon="star" 
				data-iconpos='top' style='width:33%'>Activity</a>
			<a href="/settings/index/" data-role="button" data-icon="gear" 
				data-iconpos='top' style='width:33%' id='settings'>Settings</a>
		</div>
	</div>

</div><!-- index container -->
