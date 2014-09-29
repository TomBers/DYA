<?php

include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');


$code = $_POST["code"];
$opt = $_POST["funcOpt"];

echo $opt;


	if($opt == "delete"){
		
		$getImg = "SELECT questionHTML FROM questions WHERE code = '$code'";
		$result = mysqli_query($db, $getImg);
		$row = mysqli_fetch_assoc($result);
		
		$doc = new DOMDocument();
		$doc->loadHTML($row['questionHTML']);
		$imgs = $doc->getElementsByTagName('img');
	
		foreach($imgs as $img){
			unlink($_SERVER['DOCUMENT_ROOT'].''.$img->getAttribute('src')); 
		}
		
		
		$delQn = "DELETE FROM `dya`.`questions` WHERE `questions`.`code` = '$code'";
		mysqli_query($db,$delQn);
	}
		
		$delResp = "DELETE FROM `dya`.`responses` WHERE `eventCode` = '$code'";
			mysqli_query($db,$delResp);
		
		// print_r($row);	
		mysqli_close($db);
		// echo "Order has been changed";


	
?>