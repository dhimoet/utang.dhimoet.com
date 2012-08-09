<div data-role='page' data-title='<?=$title;?>' id='<?=strtolower($title);?>'>
  
	<div data-theme='b' data-role='header' data-position='fixed'>
		<h3><?=$title;?></h3>
		<?if($title == 'Home') {?>
		<a onclick='window.location.reload()' data-role='button' data-icon='refresh'>Refresh</a>
		<?} else {?>
		<a data-rel="back" data-role='button' data-icon='back'>Back</a>
		<?}?>
		<a href='/main/add_transaction/' data-role='button' data-icon='plus'>Add</a>
	</div>

