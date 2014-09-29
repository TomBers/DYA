<?php

include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');


$oldcode = $_POST["oldcode"];
$newcode = $_POST["newcode"];


$checkFree = "SELECT code FROM questions WHERE code='$newcode'";
$result = mysqli_query($db, $checkFree);
if(mysqli_num_rows($result) > 0){
	echo '0';
}else{
	
	$updateName = "UPDATE questions SET `code` = '$newcode' WHERE `code`='$oldcode'";
	mysqli_query($db, $updateName);
	$updateGroups = "UPDATE questions SET `group`='$newcode' WHERE `group`='$oldcode'";
	mysqli_query($db, $updateGroups);

	$updateAnswers = "UPDATE responses SET `eventCode` = '$newcode' WHERE `eventCode`='$oldcode'";
	mysqli_query($db, $updateAnswers);
	
	echo '1';
}
?>