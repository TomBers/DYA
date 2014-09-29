<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/pages/stripe/Stripe.php');

$stripe = array(
  "secret_key"      => "sk_test_QU22aGBNUCaBCE3QPXC3l7VK",
  "publishable_key" => "pk_test_AkB5qB9u1heaegvfkr2lLVfX"
);

Stripe::setApiKey($stripe['secret_key']);

?>

