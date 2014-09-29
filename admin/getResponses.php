<?php
$code = $_POST["uid"];
 // echo $code;
include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');
// 
	$sql = "SELECT `id`,`user`,`timeStamp`,`response` FROM `responses` WHERE `eventCode`='$code'";
	$result = mysqli_query($db,$sql);
	while($row = mysqli_fetch_array($result))
	  {
	
		$rid = $row['id'];
		$usr = $row['user'];
		$ts = $row['timeStamp'];
		$resp =$row['response'];
		echo "$rid $usr $ts $resp <button type=\"button\" onclick=\"clearData('$rid')\">Clear</button> <br>";
// 		
// 		
// 		
// 	  // print_r($row);
	}
// 
mysqli_close($db);


?>