<?php 

	$connection = mysqli_connect ('127.0.0.1', 'admin', '1', 'novaleads');
	if ($connection == false){
		echo 'Не удалось подключиться к базе данных(';
		echo mysqli_connect_error();
		exit();
	}
?>