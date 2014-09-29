<?php
include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');
session_start();
$uid = $_SESSION['DYA_id'];

	$usrGrp = "";

	$groupQuery = "SELECT `userid` FROM `userGroups` WHERE `Group` IN (SELECT `Group` from `userGroups` where `userid` = '$uid')"; 
	$result = mysqli_query($db,$groupQuery);
	while($row = mysqli_fetch_assoc($result))
	  {
	   $usrGrp .= $row['userid'].",";
	}
// 
	$usrGrp = rtrim($usrGrp,",");



// echo $type;


if($_REQUEST['view'] == 'quiz'){

	if($usrGrp == ""){
		$sql = "SELECT `code`,`question`,`group` FROM `questions` WHERE `userId`='$uid' AND `qType`='QZ' ORDER BY `group`,`id` DESC  ";
	}
	else{
		$sql = "SELECT `code`,`question`,`group` FROM `questions` WHERE `userId` in ($usrGrp) AND `qType`='QZ' ORDER BY `group`,`id` DESC  ";
	}
}
else{

	if($usrGrp == ""){
		$sql = "SELECT `code`,`question`,`group` FROM `questions` WHERE `userId`='$uid' ORDER BY `group`,`id` DESC ";
	}
	else{
		$sql = "SELECT `code`,`question`,`group` FROM `questions` WHERE `userId` in ($usrGrp) ORDER BY `group`,`id` DESC ";
	}
}
	
	mysqli_query($db,"SET NAMES utf8;");
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