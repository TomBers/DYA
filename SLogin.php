<?php
if(!isset($_REQUEST['redirect'])){
$redirect="https://www.doyouagree.co.uk";
}
else{
	$redirect =  $_GET['redirect'];
}

session_start();
$_SESSION['redirect'] = $redirect;

?>

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
	<meta http-equiv="X-UA-Compatible" content="IE=9">

	<script src="/js/bootstrap.min.js"></script>
</head>
<style>
img{

	    display: block;
	    margin: 0 auto;
	margin-top:20px;
	height: auto;
	    max-height: 100%;

	    width: auto;
	    max-width: 100%;

}
#twitter{
	margin-top:40px;
}
h1{
	text-align:center;
}
.col-xs-6{

}
</style>
<html>


<body>
	<div class="container">
			<div class="row">
			<div class="col-xs-6 col-md-offset-4 col-md-2">
				<a href="auth.php?provider=Facebook"><img src="images/fb.png"></a>
			</div>
			<div class="col-xs-6 col-md-2">
				<a href="auth.php?provider=Twitter"><img id="twitter" src="images/twitter.png"></a>
			</div>
	</div>
	<div class="row">
		<div class="col-xs-6 col-md-offset-4 col-md-2">
			<a href="auth.php?provider=Google"><img src="images/google.png"></a>
			</div>
			<div class="col-xs-6 col-md-2">
			<a href="linkedIn.php"><img src="images/linkedin.jpg"></a>
		</div>
	</div>
		<div class='col-xs-12 col-md-offset-3 col-md-6' id="emailSignup">
			<h1>OR register with e-mail</h1>
			<br>

			<form action="saveUser.php" method="POST">
			 <label for="name">Name</label><input type="text" class="form-control" name="name" id="name" placeholder="Name"/>
			<label for="email">E-mail</label><input type="email" class="form-control" name="email" id="email" placeholder="E-mail"/>
			<input type="hidden" name="redirect" value="<?php echo $redirect;?>">	
			<br><br>	
			<input type="submit" class="btn btn-lg btn-primary btn-block" value="Submit">
			
		</div>
</div>
<link href='/css/andreea.css' rel='stylesheet' type='text/css'>
</body>
</html>