<?php
include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');
// print_r($_POST);

$login = array();
if(isset($_POST['login'])){$login['force'] = 1;}else{$login['force'] = 0;}
if(isset($_POST['fb'])){$login['fb'] = 1;}else{$login['fb'] = 0;}
if(isset($_POST['twitter'])){$login['twitter'] = 1;}else{$login['twitter'] = 0;}
if(isset($_POST['google'])){$login['google'] = 1;}else{$login['google'] = 0;}
if(isset($_POST['linkedin'])){$login['linkedin'] = 1;}else{$login['linkedin'] = 0;}

$inLogin = json_encode($login);
$group = $_POST['SurveyName'];
$oldcode =$_POST['oldcode'];
if(isset($_POST['live'])){$live = 1;}
else {$live=0;}
if(isset($_POST['draw'])){$draw = 1;}
else {$draw=0;}

$redirect=$_POST['redirect'];
// 
// 
$updateAll = "UPDATE questions SET active='$live', draw='$draw',`group`='$group',`login`='$inLogin' WHERE `group`='$oldcode'";
mysqli_query($db,$updateAll);
$first = "UPDATE questions SET code='$group' WHERE code='$oldcode'";
mysqli_query($db,$first);
$last = "UPDATE questions SET `agreeNext`='$redirect' WHERE `group`='$group' AND `end`='1'";
mysqli_query($db,$last);
// 
// // loadback to dashboard

$mem = new Memcached();
$mem->addServer("127.0.0.1", 11211);
$cache = $mem->get(strtolower($group));

if($cache){
	$mem->delete(strtolower($group));
}


header('Location: /DshBD/analytics.php');

?>