<?php
error_reporting(E_ALL);
include "../DYA_CDB.php";
mysqli_query($db,"SET NAMES utf8;");


$ec = $_REQUEST['qn'];


$qry = "SELECT questionHTML FROM `dya`.questions WHERE `code` ='$ec' LIMIT 1;";

if(!$result = $db->query($qry)){
    die('There was an error running the query [' . $db->error . ']');
}else{
	$row = $result->fetch_assoc();
	$tmpImg = array();
	$doc = new DOMDocument();
	$doc->loadHTML($row['questionHTML']);
	$imgs = $doc->getElementsByTagName('img');

	foreach($imgs as $img){
		$tmpImg[] = $img->getAttribute('src');
	}
	echo json_encode($tmpImg);
	
}

?>
	
