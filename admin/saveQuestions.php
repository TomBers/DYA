<?php

// print_r($_REQUEST);
// echo $_POST["id"];

$fields = $_POST["id"];

$tmp = explode(",",$fields);
$qz = false;
if(count($tmp) > 2){
	$qz=true;
}
$field=$tmp[1];
$value = $_POST["value"];
$code = $tmp[0]; 

$mem = new Memcached();
$mem->addServer("127.0.0.1", 11211);
$cache = $mem->get($code);

if($cache){
	$mem->delete($code);
}


include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');

mysqli_query($db,"SET NAMES utf8;");

	if($field == 'code'){
		$tstSql = "SELECT `code` FROM `questions` WHERE `code`='$value'";
		$result = mysqli_query($db,$tstSql);
		$row_cnt = mysqli_num_rows($result);
		// mysqli_close($db);
		// echo $row_cnt;
			if($row_cnt > 0){
				echo "TAKEN";	
						}
							else{
									
									
									$sql = "UPDATE `questions` SET `code`='$value' WHERE `code`='$code'";
									mysqli_query($db,$sql);
									
								
								if($qz == true){
										$sql = "UPDATE `qzAnswers` SET `code`='$value' WHERE `code`='$code'";
										mysqli_query($db,$sql);										
									}
								echo $value;
									
							}
					mysqli_close($db);

	}
	else{
	$sql = "UPDATE `questions` SET `$field`='$value' WHERE `code`='$code'";
	mysqli_query($db,$sql);
	mysqli_close($db);
	echo $value;
	// echo "Saved";
}
	
	
	



?>