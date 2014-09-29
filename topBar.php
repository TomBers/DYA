<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="keywords" content="Do You Agree, Agreement, Voting, Poll, Live Feedback">
	<meta name="description" content="Do You Agree to questions posed at events and places">
	<meta name="author" content="Tom Berman">
	<link rel="shortcut icon" href="/favicon.ico" >
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

	    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes" />	
	<title>Do You Agree</title>
	<link href="/css/bootstrap.min.css" rel="stylesheet">
	<link href='/css/topBar.css' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700' rel='stylesheet' type='text/css'>
		<meta http-equiv="X-UA-Compatible" content="IE=9">
</head>


<!--[if lt IE 9]>
 <script src="/js/html5shiv.min.js" type="text/javascript"></script>
 <script src="/js/respond.min.js" type="text/javascript"></script>
<![endif]-->

<!-- This is Google Analytics code -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-46011123-1', 'auto');
  ga('send', 'pageview');

</script>
<!-- End of GA -->

<div class="container">
	<div class="col-sm-10-offset-1">	
		<div id="topNav" class="navbar navbar-default navbar-static-top" >
			<div class="navbar-header">
				<a class="navbar-brand" href="/index.php"><img id="logo" src="/images/dya_logo.png"></a>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

			</div>

			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					<?php
					if (session_status() == PHP_SESSION_NONE) {
					    session_start();
					}
					if( !isset( $_SESSION['DYA_id'])  ){ 
						?>
					
					<li><a href="/SLogin.php?redirect=QM2/cQn.php?new=true">Create Survey</a></li>
					<li><a href="/answer">Answer Survey</a></li>	
					<li><a href="#">Features</a></li>
					<li><a href="/index.php#examples">Examples</a></li>
					<li><a href="/prices">Pricing</a></li>
					<li><a id="login" href="/SLogin.php?login=true">login</a></li>	
					<?php 
					}
					else { ?>
						<li><a href="/ask">Create Survey</a></li>
						<li><a href="/answer">Answer Survey</a></li>	
						<li><a href="/dashboard">Dashboard</a></li>
						<li><a href="/index.php#examples">Examples</a></li>
						<li><a href="/prices">Pricing</a></li>
						<li><a id="login" href="/DshBD/index.php">Settings</a></li>
						
					<?php } ?>
				
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>
</div>


	<script src="/js/jquery.tools.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>

