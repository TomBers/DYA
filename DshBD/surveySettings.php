<?php
include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');
$code = $_POST["code"];


$checkFree = "SELECT active,draw,agreeNext,`group`,login FROM questions WHERE `group`='$code' AND `end`='1'";
$result = mysqli_query($db, $checkFree);
$resp = array();

	while($row = mysqli_fetch_assoc($result))
	  {
	  $resp[] = $row;
	}
	echo json_encode($resp);

mysqli_close($db);

?>