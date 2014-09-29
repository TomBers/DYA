<?php

include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');

$code = $_POST['code'];
$active = 0;
if($_POST['checked'] == 'true'){
	$active = 1;
}

$sql = "UPDATE `questions` SET `active`='$active' WHERE `code`='$code'";

$result = mysqli_query($db,$sql);


mysqli_close($db);

?>