<?php require_once($_SERVER['DOCUMENT_ROOT'].'/pages/stripe/stripeConfig.php'); ?>

<form action="singleCharge.php" method="post">
  <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
          data-panel-label="One off Payment"
		  data-label="One off Payment"
		  data-key="<?php echo $stripe['publishable_key']; ?>"
          data-amount="7500" 
		  data-description="Buy for 1 event"
		  data-currency="gbp"
		  data-name="DoYouAgree"></script>
</form>
	<form action="subscription.php" method="post">	
		<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
					data-panel-label="Buy Monthly Plan"
					data-label="Monthly Plan"
		          data-key="<?php echo $stripe['publishable_key']; ?>"
		          data-amount="5000" 
				  data-description="1 Month"
				  data-currency="gbp"
				  data-name="DoYouAgree"></script>
</form>	
			
