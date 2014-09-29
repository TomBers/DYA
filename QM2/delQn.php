<?php

include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');


$code = $_POST["code"];
$opt = $_POST["funcOpt"];




	if($opt == 'delete'){
		$delQn = "DELETE FROM `dya`.`questions` WHERE `questions`.`code` = '$code'";
		mysqli_query($db,$delQn);
	}
		
		$delResp = "DELETE FROM `dya`.`responses` WHERE `eventCode` = '$code'";
			mysqli_query($db,$delResp);
		
		// print_r($row);	
		mysqli_close($db);
		// echo "Order has been changed";


	
?>