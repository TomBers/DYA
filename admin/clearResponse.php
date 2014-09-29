<?php
$id = $_POST["id"];
// echo $type;
include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');

	$sql = "DELETE FROM `dya`.`responses` WHERE `responses`.`id` = '$id';";
	$result = mysqli_query($db,$sql);


mysqli_close($db);


?>