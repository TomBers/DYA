<?php

// echo "Bob";

if(isset($_COOKIE['DYA_id'])){
$type = $_POST["type"];
// echo $type;
include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');

$usr = $_COOKIE['DYA_id'];

if($type == "answers"){ 
	// echo "Answers";
	$sql = "SELECT `eventCode`,`rating`,`comment` FROM `responses` WHERE `user`='$usr'";
	$result = mysqli_query($db,$sql);
	while($row = mysqli_fetch_array($result))
	  {
		echo $row['eventCode'].",".$row['rating'].",".$row['comment']."|";
	  // print_r($row);
	}
}
else {
	mysqli_query($db,"SET NAMES utf8;");
	// SELECT DISTINCT `code`,`question`,`qType` FROM `questions` JOIN `responses` ON `questions`.`code` = `responses`.`eventCode` WHERE `userId`='72'
	$sql = "SELECT DISTINCT `code`,`question`,`qType`,`group` FROM `questions` JOIN `responses` ON `questions`.`code` = `responses`.`eventCode` WHERE `userId`='$usr' ORDER BY `questions`.`group`,`questions`.`id` DESC;";
	
	// $sql = "SELECT `code`,`question`,`qType`,COUNT(*) FROM `questions` JOIN `responses` ON `questions`.`code` = `responses`.`eventCode` WHERE `userId`='$usr';";
	$result = mysqli_query($db,$sql);
	while($row = mysqli_fetch_array($result))
	  {
	  echo $row['code'].",".$row['question'].",".$row['qType'].",".$row['group'];
	  echo "|";
	}
}
mysqli_close($db);

// echo $sql;
}



?>