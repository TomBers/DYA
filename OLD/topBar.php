<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="keywords" content="Do You Agree, Agreement, Voting, Poll, Live Feedback">
	<meta name="description" content="Do You Agree to questions posed at events and places">
	<meta name="author" content="Tom Berman">
	<link rel="shortcut icon" href="/favicon.ico" >
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes" />	
	<title>Do You Agree</title>
</head>


<!-- Bootstrap -->
<link href="/css/bootstrap.min.css" rel="stylesheet">
<style>
a.navbar-brand {
    margin-bottom: 12px;
}
</style>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<div class="navbar navbar-default navbar-static-top" >
   <div class="container">
     <div class="navbar-header">
		<a class="navbar-brand" href="/index.php"><img src="/images/menuIcon.png"></a>
       <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
         <span class="sr-only">Toggle navigation</span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
       </button>
       
     </div>
     <div class="collapse navbar-collapse">
       <ul class="nav navbar-nav">
		<?php
		if( !isset( $_COOKIE['DYA_id'])  ){ 
			?>
		 <li><a href="/login.php?redirect=QM2/cQn.php?new=true">Ask</a></li>
         <li><a href="/index.php#about">About</a></li>	
		 <li><a href="/UX/index.php">Answer</a></li>
		 <li><a href="/geo/distMap.php">Nearby (beta)</a></li>
		 <li><a href="/index.php#contact">Contact</a></li>
		 <li><a href="/pages/prices.php">Prices</a></li>
		 <li><a href="/pages/faq.php">FAQ</a></li>	
       </ul>
	   <ul class="nav navbar-nav navbar-right">
		<li><a href="/login.php?login=true">Login</a></li>
		</ul>
		<?php 
		}
		else {
		?>
		 
		 <li><a href="/ask">Ask</a></li>				
		 <li><a href="/DshBD/analytics.php">Dashboard</a></li>	
		 <li><a href="/UX/index.php">Answer</a></li>
		 <li><a href="/geo/distMap.php">Nearby (beta)</a></li>
		 <li><a href="/pages/prices.php">Prices</a></li>
		 <li><a href="/index.php#contact">Contact</a></li>
		 <li><a href="/pages/faq.php">FAQ</a></li>	
		 </ul>
		   <ul class="nav navbar-nav navbar-right">
		
		<?php
								$msg = $_COOKIE['DYA_name'];
								$img = $_COOKIE['DYA_imageURL'];
								echo "<li class=\"navbar-brand\"><img height=\"30\" width=\"30\" src=\"$img\" /></li>";
								echo "<li><a href=\"/DshBD/index.php\">Settings</a></li>";
								echo "<li><a href=\"/logout.php\">Logout</a></li>";
								}	
		?>
	        
	      
     </div><!--/.nav-collapse -->
   </div>
 </div>

	<script src="/js/jquery.tools.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/jeditable.js"></script>