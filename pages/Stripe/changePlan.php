<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/pages/stripe/stripeConfig.php');
include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');

// print_r($_POST);

$plan=$_POST['plan'];

// Post Payment Details to DB (for change of subscription and cancelation)
session_start();
$uid = $_SESSION['DYA_id'];

$getCustomer = "SELECT * FROM users WHERE `id`='$uid' LIMIT 1";
$rsult = mysqli_query($db,$getCustomer);

$row = mysqli_fetch_assoc($rsult);
// print_r($row);
mysqli_close($db);

$cuId = $row['paymentId'];
// 
$cu = Stripe_Customer::retrieve($cuId);
// // Find subscription is
try {
	$sub = $cu->subscriptions->all();
	if( ! empty($sub['data'])){
		$sub_id = $sub['data'][0]['id'];
		if($plan != 'cancel'){
			$su = $cu->subscriptions->retrieve($sub_id);
			$su->plan = $plan;
			$su->save();
			echo "<h1>Changed to : $plan</h1>";
		}else{
			$su = $cu->subscriptions->retrieve($sub_id)->cancel();
			echo "<h1>Canceled</h1>";
		}

	} else{
		if($plan != 'cancel'){
			$cu->subscriptions->create(array("plan" => $plan));
			echo "Changed to $plan";
		}else{
			echo "You did not have a subscription";
		}
	}

	// $sub_id = $sub['data'][0]['id'];

} catch(Stripe_CardError $e) {
	echo $e;
}

// if($plan == 'cancel'){
	// 	$su = $cu->subscriptions->retrieve($sub_id)->cancel();
	// 	echo "<h1>Canceled</h1>";
	// }else{
		// 	$su = $cu->subscriptions->retrieve($sub_id);
		// 	$su->plan = $plan;
		// 	$su->save();
		// 	echo "<h1>Changed to : $plan</h1>";
		// }

		// $su = $cu->subscriptions->retrieve($sub_id)->cancel();
		// echo "Canceled";
		// $su->plan = "6months";
		// $su->save();

		// $su = $cu->subscriptions->retrieve($sub_id);
		// $su->plan = "6months";
		// $su->save();
		// print_r($su);


		?>