<?php

include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');

$newcode = $_POST["newcode"];


$checkFree = "SELECT code FROM questions WHERE code='$newcode'";
$result = mysqli_query($db, $checkFree);
if(mysqli_num_rows($result) > 0){
	echo '0';
}else {
echo '1';
}

?>