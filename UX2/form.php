<?php 
//header('content-type: application/json; charset=utf-8');

$code = strtolower($_POST['code']);

$mem = new Memcached();
$mem->addServer("127.0.0.1", 11211);

$cache = $mem->get($code);

if($cache){
		echo json_encode($cache);	
}else{
	include $_SERVER['DOCUMENT_ROOT']."/DYA_CDB.php";

	// mysqli_query($db,"SET NAMES utf8;");
		$stmt= $db->prepare("SELECT code,questionHTML,qType,agreeNext,draw,sliderURL,sliderText,options FROM `questions` WHERE `code`=? LIMIT 1;");
		$stmt->bind_param('s',$code);
		$stmt->execute();
	
	
		$result = $stmt->get_result();
		while ($row = $result->fetch_assoc()){
				echo json_encode($row);
			}


	$mem->set($code,$row) or die("Couldn't save anything to memcached...");
}


?>