<?php
$qz = $_POST['quiz'];
// echo $type;
include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');

	$sql = "SELECT `code`,`question`,`agreeNext` FROM `questions` WHERE `group` ='$qz' ORDER BY `id` DESC";
	
	$result = mysqli_query($db,$sql);

	$results = array();
	while($row = mysqli_fetch_assoc($result))
	  {
		$results[] = $row;
	}
		echo json_encode(sortArray($results,$qz));

mysqli_close($db);

function sortArray($rslt,$qz){
	$sorted = array();
	$sorted[] = findElement($rslt,$qz);
	for($i = 1; $i < count($rslt);$i++){
		$j = $i - 1;
		$sorted[] = findElement($rslt,$sorted[$j]['agreeNext']);
		unset($sorted[$j]['agreeNext']);
	}
	return $sorted;	
}

function findElement($arry,$element){

	// return code and question of given element
	foreach ($arry as $val){
		if($val['code'] == $element){return array("code"=>$val['code'],"question"=>$val['question'],"agreeNext"=>$val['agreeNext']);}
	}
	return false; 
	
}
?>