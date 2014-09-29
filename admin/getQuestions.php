<?php
$uid = $_POST['user']; //$_COOKIE['DYA_id'];
// echo $type;
include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');
mysqli_query($db,"SET NAMES utf8;");
	$sql = "SELECT `code`,`question`,`active`,`qType`,`agreeNext`,`questionHTML`,`options`,`colours`,`draw` FROM `questions` WHERE `userId` ='$uid' ORDER BY `id` DESC";
	
	
	
	
	$result = mysqli_query($db,$sql);

	$results = array();
	while($row = mysqli_fetch_assoc($result))
	  {
		$results[] = $row;
	}
		echo json_encode($results);

mysqli_close($db);


?>

