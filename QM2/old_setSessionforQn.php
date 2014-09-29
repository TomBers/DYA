<?php
$qn = $_REQUEST['code'];
session_start();
error_reporting(E_ALL | E_STRICT);
include $_SERVER['DOCUMENT_ROOT']."/DYA_CDB.php";


$sql = "SELECT `code`,`question`,`qType`,`options` FROM `questions` WHERE `code`='$qn' LIMIT 1";
$result = mysqli_query($db,$sql);
$row = mysqli_fetch_array($result);

// print_r($row);

if($row['qType'] == 'QZ'){
	$sql2 = "SELECT `answer` FROM `qzAnswers` WHERE `code`='$qn' LIMIT 1";
	$result2 = mysqli_query($db,$sql2);
	$row2 = mysqli_fetch_array($result2);
	$ans = json_decode($row2['answer']);
	$_SESSION['qnParams']['answer'] = $ans[0];
}

// print_r($row2);

$_SESSION['qType'] = $row['qType'];
$_SESSION['DYAcode'] = $row['code'];

$opts = json_decode($row['options']);

$_SESSION['qnParams']['question'] = $row['question'];
$_SESSION['qnParams']['opt1'] = $opts[0];
$_SESSION['qnParams']['opt2'] = $opts[1];
$_SESSION['qnParams']['opt3'] = $opts[2];
$_SESSION['qnParams']['opt4'] = $opts[3];
$_SESSION['qnParams']['opt5'] = $opts[4];




// print_r($_SESSION);

header("Location: createQn.php");


?>