<div data-role='page' data-title='<?=$title;?>' id='<?=strtolower($title);?>'>
  
	<div data-theme='b' data-role='header' data-position='fixed'>
		<h3><?=$title;?></h3>
		
		<?if($title == 'Home') {?>
		<a onclick='window.location.reload()' data-role='button' data-icon='refresh'>Refresh</a>
		<?} else if($title == 'Privacy' or $title == 'Terms') {?>
		<a href='/main/' data-role='button' data-icon='home' data-ajax='false'>Home</a>
		<?} else {?>
		<a data-rel="back" data-role='button' data-icon='back'>Back</a>
		<?}?>
		
		<?if($title == 'Add Friend' or $title == 'Add Transaction') {?>
		<a href='javascript:void(0)' data-role='button' data-icon='plus' id='submit'>Submit</a>
		<?} else if($title == 'Privacy' or $title == 'Terms') {?>

		<?} else {?>
		<a href='/main/add_transaction/' data-role='button' data-icon='plus'>Add</a>
		<?}?>
	</div>

