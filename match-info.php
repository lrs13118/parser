<?php include 'parser/db-connect.php'; ?> 
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<?php
	$content_query = mysqli_query ($connection, "SELECT * FROM matches WHERE id = ". $_GET['id'] ."");
	$content = mysqli_fetch_assoc ($content_query) ?>
	<title><?php echo $content['title'];?></title>
	<link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>
	<div class="container">
		<div class="nav"></div>
		<div class="content"><?php echo $content['content'];?></div>
		<div class="sidebar"></div>
	</div>
</body>
</html>