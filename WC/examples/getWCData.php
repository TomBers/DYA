<?php

include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');


	$sql = "SELECT `response` FROM `responses` JOIN `users` ON `responses`.`user`=`users`.`id` WHERE `eventCode`='NJGDM' AND `response` != '' ORDER BY `responses`.`id` DESC";
	$result = mysqli_query($db,$sql);
	$num_rows = mysqli_num_rows($result);
	
	$comments = array();
	
	while($row = mysqli_fetch_array($result))
	  {
		
		$sepWords = explode(" ",$row['response']);
		$comments = array_merge($comments,$sepWords);
		
	}

	echo json_encode($comments);

mysqli_close($db);




?>