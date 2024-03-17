<!DOCTYPE html>
<html>
	<head>
	
		<title>
		  <?= isset($title) ? $title : 'Site Web' ?>
		</title> 
		
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="/css/stylesheet.css" type="text/css" />
	</head>
	<body>
		<?php echo $content; ?>
	</body>
</html>