<?php
include "../DYA_CDB.php";
mysqli_query($db,"SET NAMES utf8;");

$rows = array();

if(isset($_POST['rating'])){
	$rating = $_POST['rating'] / 100;
}else{ $rating = -1;}
if(isset($_POST['options'])){
	$options = $_POST['options'];
}else {$options = array();}

session_start();
if(isset($_SESSION['DYA_id'])){
$id=$_SESSION['DYA_id'];
}else{$id=-1;}




$ec = $_POST['qn'];
$qType = $_POST['qType'];
$lat = $_POST['lat'];
$lon = $_POST['lon'];


if( $qType == "SLD" ){$responses[] = $rating; }
else if ( $qType == "CMMT" && isset($_POST['comment'])) { $responses[] = $db->real_escape_string($_POST['comment']); }
else {
	$tmpOptions = explode(',',$options);
	foreach ($tmpOptions as $val){if($val != ""){$responses[] = "$val";}}
}

$sql ="";
foreach ($responses as $response){
	$sql .= "INSERT INTO `responses` (`eventCode`, `user`,`loc`, `response`) VALUES ('$ec', '$id', GeomFromText( ' POINT($lat $lon) ' ), '$response') ON DUPLICATE KEY UPDATE response='$response';"; 	
}
if($qType == 'CMMT'){
	$sql .= "SELECT questions.agreeNext FROM `dya`.questions WHERE `code` ='$ec' LIMIT 1;";
}
else{
$sql .= "SELECT questions.code,questions.question,questions.qType,questions.agreeNext,questions.options,questions.colours,AVG(responses.response),COUNT(*) FROM `dya`.questions JOIN `dya`.responses ON questions.code = responses.eventCode WHERE `eventcode` ='$ec' LIMIT 1;";
$sql .= "SELECT response,COUNT(*) as count FROM `dya`.responses WHERE `eventcode` ='$ec' GROUP BY `response` ORDER BY `response` ASC";
}

if ($db->multi_query($sql)) {
    do {
        /* store first result set */
        if ($result = $db->store_result()) {
            while ($row = $result->fetch_assoc()) {
				$rows[] = $row;
				if($row['qType'] == 'SLD'){
					$db->close();	
				}
            }
            $result->free();
        }
        /* print divider */
        if ($db->more_results()) {
            //printf("-----------------\n");
        }
    } while ($db->next_result());
}
$db->close();


echo json_encode($rows);


?>

