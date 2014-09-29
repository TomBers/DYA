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
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700' rel='stylesheet' type='text/css'>
</head>


<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>
body{
	font-family: 'Source Sans Pro', sans-serif;
	color:#354353;
}

h1{
	font-size:32px;
	font-weight:700;
}

h2{
	font-size:24px;
	color:#f15c51;
	font-weight:300;
}
h3{
	fontsize:18px;
	font-weight:700;
}
p{
	font-weight:400;
}


ul{
	-webkit-padding-start:0px;
}
a.navbar-brand {
    margin-bottom: 12px;
}
.container{
/*	border:1px solid red;*/
}
#topNav{
	background:white;
	border:none;
}

#logo{
	padding-top:80px;
}
#login{
	position:absolute;
	top:-75px;
	left:-110px;
text-transform:lowercase;
}



.navbar-nav{
	padding-top:95px;
	padding-left:200px;
}


.navbar-nav ul{
	padding-left:20px;
}

ul.nav.navbar-nav li a {
	
	text-transform:uppercase;
/*    color: red;*/
}

ul.nav.navbar-nav li a:hover {color:#f15c51;}

@media screen and (max-width: 1200px){
	.navbar-nav{
		
		padding-left:0px;
	}	
}

@media screen and (max-width: 768px){
	.navbar-nav{
		padding-top:0px;
		padding-left:0px;
	}
	#logo{
		padding-top:10px;
	}
	#login{
		position:relative;
		top:0px;
		left:0px;
	   text-transform:lowercase;
	}	
	
}


</style>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<div class="container">
	<div class="col-sm-10-offset-1">	
		<div id="topNav" class="navbar navbar-default navbar-static-top" >
			<div class="navbar-header">
				<a class="navbar-brand" href="/index.php"><img id="logo" src="images/dya_logo.png"></a>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

			</div>

			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="/login.php?redirect=QM2/cQn.php?new=true">Create Survey</a></li>
					<li><a href="/index.php#about">Answer Survey</a></li>	
					<li><a href="/UX/index.php">Features</a></li>
					<li><a href="/geo/distMap.php">Examples</a></li>
					<li><a href="/index.php#contact">Industries</a></li>
					<li><a href="/pages/prices.php">Pricing</a></li>
					<li><a id="login" href="/login.php?login=true">login/register</a></li>	
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>
</div>


	<script src="js/jquery.tools.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
