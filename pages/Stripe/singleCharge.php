<?php
  require_once($_SERVER['DOCUMENT_ROOT'].'/pages/stripe/stripeConfig.php');

print_r($_POST);

  $token  = $_POST['stripeToken'];

  $customer = Stripe_Customer::create(array(
      'email' => $_POST['stripeEmail'],
      'card'  => $token
  ));

	echo "Single Charge <br><br>";
	echo $customer->id;
	// print_r($customer);

	session_start();
	$_SESSION['paymentId'] = $customer->id;
	$_SESSION['account'] = 'PRO';
	$uid = $_SESSION['DYA_id'];
	$updateCustomer = "UPDATE users SET `account`='PRO' WHERE `id`='$uid'";
	// mysqli($db,$updateCustomer);

  $charge = Stripe_Charge::create(array(
      'customer' => $customer->id,
      'amount'   => 7500,
      'currency' => 'gbp'
  ));

  echo '<h1>Successfully charged</h1>';
?>