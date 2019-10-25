<?php 
	include 'parser/db-connect.php';
	include 'parser/parse.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Список матчей</title>
	<link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>
	<div class="container">
		<div class="nav"></div>
		<div class="list">
			<?php
			$matches_query = mysqli_query ($connection, "SELECT * FROM matches");
			while ($matches = mysqli_fetch_assoc ($matches_query)) { ?>
			<div> <a href=match-info.php?id=<?php echo $matches['id'];?>> <?php echo $matches['title'];?> </a></div>
			<?php } ?>
		</div>
		<div class="sidebar"></div>
	</div>
</body>
</html>
