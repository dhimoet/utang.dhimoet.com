<?=$doctype?>

<html>
<head>
	<title><?=$title?></title>
	
	<?foreach($css as $item) {?><link rel="stylesheet" type="text/css" href="<?=$item?>" />
	<?}?><?foreach($js as $item) {?><script type="text/javascript" src="<?=$item?>"></script>
	<?}?><?=(isset($other)) ? $other : "";?>

</head>
<body>

