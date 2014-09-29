<?php
$cde = $_POST["code"];
// echo $type;
include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');

	$sql = "DELETE FROM `dya`.`responses` WHERE `responses`.`eventCode` = '$cde';";
	$result = mysqli_query($db,$sql);


mysqli_close($db);


?>