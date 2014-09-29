<?php
// print_r($_POST);
session_start();



if(isset($_SESSION['DYAQzScore'])) {
	$runningScore = $_SESSION['DYAQzScore']; 	
}
else{
	$runningScore = 0;	
}
if(! isset($_SESSION['answered'])){
	$_SESSION['answered'] = array();
}


error_reporting(E_ALL);
include "../DYA_CDB.php";

mysqli_query($db,"SET NAMES utf8;");
$user=$_SESSION['DYA_id'];
$code = $_POST['qn'];
$options = explode(",", $_POST['options']);
// print_r($options);

// GET Answer

// $sql = "SELECT qnFlag,answer,agreeNext FROM qzAnswers JOIN questions ON code WHERE code='$code' LIMIT 1";
$sql = "SELECT qnFlag,answer,agreeNext FROM qzAnswers JOIN questions ON `qzAnswers`.code=`questions`.code WHERE `qzAnswers`.code='$code' LIMIT 1";
$result = mysqli_query($db,$sql);


$row = mysqli_fetch_array($result);

// print_r($row);

$nxt = $row['agreeNext'];


$answers = json_decode($row['answer']);
// print_r($answers);

$score = 0;
foreach ($answers as $answer){
	$answer = filter_var($answer, FILTER_SANITIZE_NUMBER_INT) - 1;
	if(in_array($answer,$options)){$score += 1;}
}



if($row['qnFlag'] == "START"){
	$_SESSION['answered'] = array();
	
	$_SESSION['DYAQzScore'] = 0;
	$_SESSION['DYAQzCode'] = $code;
	$runningScore = 0;
}

if(! in_array($code, $_SESSION['answered']) ){
  $runningScore += $score;
}
$_SESSION['DYAQzScore'] = $runningScore;

array_push($_SESSION['answered'],$code);

if ($row['qnFlag'] == "END"){
	$QZusr = $_SESSION['DYA_id'];
	$QZcode = $_SESSION['DYAQzCode'];
	$QZScore = $_SESSION['DYAQzScore'];
	$sql = "INSERT INTO `dya`.`qzResponses` (`user`, `quizCode`, `score`) VALUES ('$QZusr', '$QZcode', '$QZScore')";
	mysqli_query($db,$sql);
	
}
 echo json_encode(array($score,$runningScore,$nxt));
 // echo "$score,$runningScore,$nxt";



?>