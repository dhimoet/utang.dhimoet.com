<div id='overlay_container'></div>

<script type="text/template" id="overlay_template">
	<div id='overlay_background'></div>
	<div id='overlay_window'>
		<div id='overlay_close_button'>&nbsp;X&nbsp;</div>
		<h1><%= title %></h1>
		<p><%= content %></p>
		<a href="javascript:void(0)" id='overlay_ok_button' data-role="button" data-theme="b" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" class="ui-btn ui-shadow ui-btn-corner-all ui-btn-up-b">
			<span class="ui-btn-inner ui-btn-corner-all">
				<span class="ui-btn-text">OK</span>
			</span>
		</a>
	</div>
</script>
