<?php

// print_r($_REQUEST);
// echo $_POST["id"];

$field = $_POST["id"];
$value = $_POST["value"];
 
include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');
$usr = $_COOKIE['DYA_id'];

      $sql = "UPDATE `users` SET `$field`='$value' WHERE `id`='$usr'";
	// UPDATE `users` SET `firstName`='Thomas' WHERE `id`='6'
	
	mysqli_query($db,$sql);
	mysqli_close($db);


echo $_POST["value"];
?>