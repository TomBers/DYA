<?php
include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');
$name = $_POST['name'];
$email = $_POST['email'];
$redirect = $_POST['redirect'];

// print_r($_POST);


$stmt = $db->prepare("INSERT INTO `dya`.`users` (`imgURL`, `loginService`, `firstName`, `email`) VALUES ('/images/profile.jpeg' , 'signup', ?, ?) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)");
$stmt->bind_param('ss',$name,$email);
$stmt->execute();

//$sql = "INSERT INTO `dya`.`users` (`imgURL`, `loginService`, `firstName`, `email`) VALUES ('/images/profile.jpeg' , 'signup', '$name', '$email') ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id);";
// $result = mysqli_query($db,$sql);

// echo mysqli_insert_id($db);

session_start();
$_SESSION['DYA_id'] = mysqli_insert_id($db);
$_SESSION['DYA_name'] = $name;
$_SESSION['DYA_imageURL'] = '/images/profile.jpeg';

if($redirect == 'https://www.doyouagree.co.uk'){
		$getBillingInfo = "SELECT `account`,`paymentId` FROM `users` WHERE `id` = '$id' LIMIT 1";
		$result = mysqli_query($db,$getBillingInfo);
		$row = mysqli_fetch_assoc($result);
		$_SESSION['account'] = $row['account'];
		$_SESSION['paymentId'] = $row['paymentId'];
}


header('Location: '.$redirect);

?>