<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/pages/stripe/stripeConfig.php');
include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');



	// Post Payment Details to DB (for change of subscription and cancelation)
	session_start();
	$uid = $_SESSION['DYA_id'];
	
	$getCustomer = "SELECT * FROM users WHERE `id`='$uid' LIMIT 1";
	$rsult = mysqli_query($db,$getCustomer);
	
	$row = mysqli_fetch_assoc($rsult);
	// print_r($row);
	mysqli_close($db);
	
	$cuId = $row['paymentId'];
	
	$cu = Stripe_Customer::retrieve($cuId);
	// Find subscription is
	
	$sub = $cu->subscriptions->all(array('limit'=>1));
	$sub_id = $sub['data'][0]['id'];

	// $su = $cu->subscriptions->retrieve($sub_id)->cancel();
	// echo "Canceled";
	// $su->plan = "6months";
	// $su->save();
	
	// $su = $cu->subscriptions->retrieve($sub_id);
	// $su->plan = "6months";
	// $su->save();
	// print_r($su);


	?>