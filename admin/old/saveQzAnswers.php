<?php

// print_r($_REQUEST);
// echo $_POST["id"];

$fields = $_POST["id"];

$tmp = explode(",",$fields);
$field=$tmp[1];
$value = $_POST["value"];
$code = $tmp[0]; 
include ($_SERVER['DOCUMENT_ROOT'].'/CDB.php');


	$sql = "UPDATE `qzAnswers` SET `$field`='$value' WHERE `code`='$code'";
	// UPDATE `users` SET `firstName`='Thomas' WHERE `id`='6'
	
	mysqli_query($db,$sql);
	mysqli_close($db);


echo $_POST["value"];
?>