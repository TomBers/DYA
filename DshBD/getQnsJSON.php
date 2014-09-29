<?php

session_start();

if(isset($_SESSION['DYA_id'])){
$usr = $_SESSION['DYA_id'];
} else{
	$usr = 15;
}

include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');
mysqli_query($db,"SET NAMES utf8;");
$resp = array();


	$usrGrp = "";

	$groupQuery = "SELECT `userid` FROM `userGroups` WHERE `Group` IN (SELECT `Group` from `userGroups` where `userid` = '$usr')"; 
	$result = mysqli_query($db,$groupQuery);
	while($row = mysqli_fetch_assoc($result))
	  {
	   $usrGrp .= $row['userid'].",";
	}
// 
	$usrGrp = rtrim($usrGrp,",");

	
	
	
	
	if($usrGrp == ""){
		
	$sql = "SELECT DISTINCT `code`,`question`,`qType`,`group` FROM `questions` LEFT JOIN `responses` ON `questions`.`code` = `responses`.`eventCode` WHERE `userId`='$usr' ORDER BY `questions`.`group`,`questions`.`id` ASC;";
}
else{
		$sql = "SELECT DISTINCT `code`,`question`,`qType`,`group` FROM `questions` LEFT JOIN `responses` ON `questions`.`code` = `responses`.`eventCode` WHERE `userId` in ($usrGrp) ORDER BY `questions`.`group`,`questions`.`id` ASC;";
}
	



	$result = mysqli_query($db,$sql);
	while($row = mysqli_fetch_assoc($result))
	  {
	  $resp[] = $row;
	}
	echo json_encode($resp);

mysqli_close($db);

// echo $sql;




?>