<?php
$uid = $_POST["uid"];
// echo $type;
include ($_SERVER['DOCUMENT_ROOT'].'/CDB.php');

	$sql = "SELECT `code` FROM `questions` WHERE `userId`='$uid'";
	$result = mysqli_query($db,$sql);
	while($row = mysqli_fetch_array($result))
	  {
		$cd = $row['code'];
	
		echo "$cd,";
	  // print_r($row);
	}

mysqli_close($db);


?>