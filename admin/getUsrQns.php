<?php
$uid = $_POST["uid"];
// echo $type;
include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');
mysqli_query($db,"SET NAMES utf8;");
	$sql = "SELECT `code`,`question` FROM `questions` WHERE `userId`='$uid'";
	$result = mysqli_query($db,$sql);
	while($row = mysqli_fetch_array($result))
	  {
		$cd = $row['code'];
		$qn = $row['question'];
		echo "$cd $qn <button type=\"button\" onclick=\"clearData('$cd')\">Clear</button> <br>";
	  // print_r($row);
	}

mysqli_close($db);


?>