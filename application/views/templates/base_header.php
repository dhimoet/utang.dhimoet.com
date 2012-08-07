<?=$doctype?>

<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	
	<title><?=$title?></title>
	
	<?foreach($css as $item) {?><link rel="stylesheet" type="text/css" href="<?=$item?>" />
	<?}?><?foreach($js as $item) {?><script type="text/javascript" src="<?=$item?>"></script>
	<?}?><?=(isset($other)) ? $other : "";?>

</head>
<body>

