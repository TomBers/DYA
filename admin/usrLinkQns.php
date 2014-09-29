<?php
$uid = $_POST['user'];
// echo $type;
include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');

if($_REQUEST['view'] == 'quiz'){
	$sql = "SELECT `code`,`question`,`group` FROM `questions` WHERE `userId`='$uid' AND `qType`='QZ' ORDER BY `group` ";
}
else{
	$sql = "SELECT `code`,`question`,`group` FROM `questions` WHERE `userId`='$uid' ORDER BY `group` ";
}
	
	
	$result = mysqli_query($db,$sql);
	while($row = mysqli_fetch_array($result))
	  {
		$cd = $row['code'];
		$qn = $row['question'];
		$gp = $row['group'];
		echo "$cd~$qn~$gp|";
	  // print_r($row);
	}

mysqli_close($db);


?>