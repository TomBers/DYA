<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/pages/stripe/stripeConfig.php');
include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');

$token  = $_POST['stripeToken'];

$customer = Stripe_Customer::create(array(
	'email' => $_POST['stripeEmail'],
	'card'  => $token
		));

	$customer->subscriptions->create(array("plan" => "monthly"));


	// Post Payment Details to DB (for change of subscription and cancelation)
	session_start();
	$uid = $_SESSION['DYA_id'];
	$paymentEmail = $_POST['stripeEmail'];
	$updateCustomer = "UPDATE users SET `account`='PRO',`paymentId`='$customer->id',`paymentEmail`='$paymentEmail'  WHERE `id`='$uid'";
	mysqli_query($db,$updateCustomer);
	mysqli_close($db);





	echo '<h1>Successfully subscribed</h1>';
	?>