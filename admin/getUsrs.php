<?php
$uid = $_POST["uid"];
// echo $type;
include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');

	$sql = "SELECT `firstName`,`lastName`,`id` FROM `users` WHERE `id` NOT IN (0,1)";
	$result = mysqli_query($db,$sql);
	while($row = mysqli_fetch_array($result))
	  {
		$fn = $row['firstName'];
		$sn = $row['lastName'];
		$id = $row['id'];
		echo "$fn $sn,$id|";
	  // print_r($row);
	}

mysqli_close($db);


?>