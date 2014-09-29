<!DOCTYPE html>	
<?php
ini_set ('display_errors', '1');
error_reporting (E_ALL | E_STRICT); 
	if(!isset($_REQUEST['redirect'])){
	$redirect="http://www.doyouagree.co.uk";
	}
	else{
		$redirect =  $_GET['redirect'];
	}

?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="/css/normalize.css" media="screen">
	<style>


	#emailSignup{
		margin: 0 auto;
		max-width:500px;
		text-align:center;
	}
	</style>

	<script>
	function saveUser(){
		var name = $('#name').val();
		var email = $('#email').val();
		var redirect = '<?php echo $redirect; ?>';
		var dataString = 'name='+name;
		dataString += '&email='+email; 
		$.ajax({
			type:'POST',
			data:dataString,
			url:'/saveUser.php',
			success:function(res) {
				window.location.href = redirect;
			}
		});

	}

	// function setCookie(cname,cvalue)
	// {
	// 	var exdays = 300;
	// 	var d = new Date();
	// 	d.setTime(d.getTime()+(exdays*24*60*60*1000));
	// 	var expires = "expires="+d.toGMTString();
	// 	document.cookie = cname + "=" + cvalue + "; " + expires;
	// }
	</script>

</head>
<body>
	<?php

if(!isset($_REQUEST['token'])){
	
	session_start();
	$_SESSION['redirect'] = $redirect;
	// $_SESSION['multiView'] = $_GET['multiView'];
	
	include($_SERVER['DOCUMENT_ROOT'].'/topBar.php');
	?>

	<div class='container'>
		<div class='row'>
			<div class='col-md-6'>
				<h1>Login with Social Media</h1>
				<script src="//hub.loginradius.com/include/js/LoginRadius.js" ></script> <script type="text/javascript"> var options={}; options.login=true; LoginRadius_SocialLogin.util.ready(function () { $ui = LoginRadius_SocialLogin.lr_login_settings;$ui.interfacesize = "";$ui.apikey = "073cabed-0038-4a7a-8622-570d4ce92cec";$ui.callback=""; $ui.lrinterfacecontainer ="interfacecontainerdiv"; LoginRadius_SocialLogin.init(options); }); </script>
				<div class="interfacecontainerdiv" style="text-align:center;"></div>
			</div>

			<div class='col-md-6' id="emailSignup">
				<h1>OR with e-mail</h1>
				<br>


				NAME :<input type="text" class="form-control" name="name" id="name" placeholder="Name"/>
				E-MAIL :<input type="email" class="form-control" name="email" id="email" placeholder="E-mail"/>	
				<br><br>	

				<input id="button" class="btn btn-lg btn-primary btn-block" type="submit" value="Sign in" onclick="saveUser()"/>
			</div>
		</div>
	</div>	

	<?php
}else{
	include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');
	include($_SERVER['DOCUMENT_ROOT'].'/login/LoginRadiusSDK.php');
	include($_SERVER['DOCUMENT_ROOT'].'/login/LoginRadiusContacts.php');
	
	// LoginRadius API secret
	$api_secret = 'c8f97186-ea7e-45e2-95b3-d131b61cbe45';
		$loginRadiusObject = new LoginRadiusContacts($api_secret, $_REQUEST['token']);
		$userProfile = $loginRadiusObject->loginradius_get_data();
	
		$EmailValue=isset($userProfile->Email[0]->Value)?$userProfile->Email[0]->Value:$userProfile->Email;
			$sql = "INSERT INTO `dya`.`users` (`imgURL`, `loginService`, `firstName`, `lastName`, `nickname`, `profileName`, `dateOfBirth`, `gender`, `email`) VALUES ('$userProfile->ThumbnailImageUrl' , '$userProfile->Provider', '$userProfile->FirstName', '$userProfile->LastName', '$userProfile->NickName', '$userProfile->ProfileName', '$birthDate', '$userProfile->Gender', '$EmailValue') ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id);";
			
			mysqli_query($db,$sql);
			
			session_start();
			$_SESSION['DYA_id'] = mysqli_insert_id($db);
			$id = $_SESSION['DYA_id'];
			$_SESSION['DYA_name'] = $userProfile->FirstName;
			$_SESSION['DYA_imageURL'] = $userProfile->ThumbnailImageUrl;
			
			$getBillingInfo = "SELECT `account`,`paymentId` FROM `users` WHERE `id` = '$id' LIMIT 1";
			$result = mysqli_query($db,$getBillingInfo);
			$row = mysqli_fetch_assoc($result);
			$_SESSION['account'] = $row['account'];
			$_SESSION['paymentId'] = $row['paymentId'];
			// $timeOut = time()+60480000;
			
			// setcookie("session_id", session_id(),$timeout,"/");
			// 			
			// 			setcookie("DYA_id", mysqli_insert_id($db),$timeOut,"/");
			// 			setcookie("DYA_name", $userProfile->FirstName,$timeOut,"/");
			// 			setcookie("DYA_imageURL", $userProfile->ThumbnailImageUrl,$timeOut,"/");
			// 			echo mysqli_insert_id($db);
			
			header("Location: $redirect");



		}

		?>
	</td>
</tr>
</table>


</body>
</html>