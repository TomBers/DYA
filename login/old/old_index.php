<html>
<head>
<link rel="stylesheet" type="text/css" href="../normalize.css" media="screen">
<link rel="stylesheet" type="text/css" href="../newStyle.css" media="screen">
</head>
<body>
<?php
include ($_SERVER['DOCUMENT_ROOT'].'/CDB.php');
include('../topBar.php');

if(!isset($_REQUEST['token'])){
	?>
	<div style="border:1px solid #000; width:300px; padding: 10px; margin:50 auto;">
	Login using the Social Media of your choice <br><br>
	<script src="//hub.loginradius.com/include/js/LoginRadius.js" ></script> <script type="text/javascript"> var options={}; options.login=true; LoginRadius_SocialLogin.util.ready(function () { $ui = LoginRadius_SocialLogin.lr_login_settings;$ui.interfacesize = "";$ui.apikey = "073cabed-0038-4a7a-8622-570d4ce92cec";$ui.callback=""; $ui.lrinterfacecontainer ="interfacecontainerdiv"; LoginRadius_SocialLogin.init(options); }); </script>
	<div class="interfacecontainerdiv"></div>
	</div>
	<?php
}else{
	include('LoginRadiusSDK.php');
	include('LoginRadiusStatusUpdate.php');
	include('LoginRadiusContacts.php');
	include('LoginRadiusCompany.php');
	include('LoginRadiusGroups.php');
	include('LoginRadiusMentions.php');
	include('LoginRadiusMessage.php');
	include('LoginRadiusPosts.php');
	include('LoginRadiusGetEvents.php');
	include('LoginRadiusGetStatus.php');
	// LoginRadius API secret
	$api_secret = 'c8f97186-ea7e-45e2-95b3-d131b61cbe45';
	$loginRadiusObject = new LoginRadiusContacts($api_secret, $_REQUEST['token']);
	$userProfile = $loginRadiusObject->loginradius_get_data();
	if($loginRadiusObject->IsAuthenticated == TRUE){
	if($userProfile->Provider == "facebook" || $userProfile->Provider == "twitter" || $userProfile->Provider == "linkedin"){
		//update status
		$makepost = new LoginRadiusStatusUpdate($api_secret, $_REQUEST['token']); 
		$updateStatus = $makepost->loginradius_post_status($to='', $title='LoginRadius PHP SDK', $url='http://loginradius.com/', $imageurl='http://loginradius.com/', $status='LoginRadius PHP SDK Test', $caption='LoginRadius PHP SDK', $description='LoginRadius PHP SDK Test');
	}
	if($userProfile->Provider == "linkedin"){
		//get company
		$getCompany = new LoginRadiusCompany($api_secret, $_REQUEST['token']);
		$getCompany = $getCompany->loginradius_get_company();
	}
	//get contacts
	$getcontacts = new LoginRadiusContacts($api_secret, $_REQUEST['token']);
    $getcontacts = $getcontacts->loginradius_get_contacts();
	if($userProfile->Provider == "facebook"){
		// get groups
		$getGroups = new LoginRadiusGroups($api_secret, $_REQUEST['token']);
		$getGroups = $getGroups->loginradius_get_groups();
	}
	if($userProfile->Provider == "twitter" || $userProfile->Provider == "linkedin"){
		// send messages
		$sendMessage = new LoginRadiusMessage($api_secret, $_REQUEST['token']);
		// Message to Sent - Please change ID, subject and message
		if(is_array($getcontacts) && count($getcontacts) > 0){
    		$sendMessage = $sendMessage->loginradius_send_message($getcontacts[0]->ID, 'LoginRadius PHP SDK Test', 'This message is sent using LoginRadius PHP SDK');
		}
	}
	if($userProfile->Provider == "facebook"){
		// get posts
		$getPosts = new LoginRadiusPosts($api_secret, $_REQUEST['token']);
		$getPosts = $getPosts->loginradius_get_posts();
	}
	if($userProfile->Provider == "twitter"){
		// get Mentions
		$getMentions = new LoginRadiusMentions($api_secret, $_REQUEST['token']);
		$getMentions = $getMentions->loginradius_get_mentions();
	}
	// get status
	$getStatus = new LoginRadiusGetStatus($api_secret, $_REQUEST['token']);
    $getStatus = $getStatus->loginradius_get_status();
	if($userProfile->Provider == "facebook"){
		// get events
		$getEvents = new LoginRadiusGetEvents($api_secret, $_REQUEST['token']);
		$getEvents = $getEvents->loginradius_get_events();
	}
		echo '<h2>Profile Data</h2>';
		?>
		<table border='1'>
			<tr>
				<th valign="top">Profile Pic  </th>
				<th><img height="60" width="60" src="<?php echo $avatar = $userProfile->ThumbnailImageUrl; ?>" /></th>
			</tr>
			<tr>
				<th>Signed in with</th>
				<td><?php echo $provider = ucfirst($userProfile->Provider) ?></td>
			</tr>
			<tr>
				<th>First Name  </th>
				<td><?php echo $fname = ucfirst($userProfile->FirstName) ?></td>
			</tr>
			<tr>
				<th>Last Name  </th>
				<td><?php echo $lname = ucfirst($userProfile->LastName) ?></td>
			</tr>	
			<tr>
				<th>Nickname  </th>
				<td><?php echo $nickName = ucfirst($userProfile->NickName) ?></td>
			</tr>
			<tr>
				<th>Profile Name  </th>
				<td><?php echo $profileName = $userProfile->ProfileName ?></td>
			</tr>
			<tr>
				<th>Birthdate  </th>
				<td><?php echo $birthDate = $userProfile->BirthDate ?></td>
			</tr>
			<tr>
				<th>Gender  </th>
				<td><?php 
					if($userProfile->Gender == 'F'){
						echo 'Female';	  
					}elseif($userProfile->Gender == 'M'){
						echo 'Male';
					}
				}
					$EmailValue=isset($userProfile->Email[0]->Value)?$userProfile->Email[0]->Value:$userProfile->Email;
						// Insert User into DB and set session data
						$sql = "INSERT INTO `contacts`.`users` (`id`, `imgURL`, `loginService`, `firstName`, `lastName`, `nickname`, `profileName`, `dateOfBirth`, `gender`, `email`) VALUES (NULL,'$userProfile->ThumbnailImageUrl' , '$userProfile->Provider', '$userProfile->FirstName', '$userProfile->LastName', '$userProfile->NickName', '$userProfile->ProfileName', '$birthDate', '$userProfile->Gender', '$EmailValue');";

					   $result = mysqli_query($db,$sql);

						// $user = array(
						// 										    'id' => mysqli_insert_id($db),
						// 										    'name' => $userProfile->FirstName,
						// 											'imgURL' => $userProfile->ThumbnailImageUrl,
						// 										);

									// print_r($user);	

						// 		
						
								$timeOut = time()+604800;
								
								setcookie("DYA_id", mysqli_insert_id($db),$timeOut);
								setcookie("DYA_name", $userProfile->FirstName,$timeOut);
								setcookie("DYA_imageURL", $userProfile->ThumbnailImageUrl,$timeOut);
								// setcookie("loginCredentials", $user, $timeOut);
				
			}
	
	// if()
	
		
			
			// echo "Entered ID : ". mysqli_insert_id($db);
			

					?>
				</td>
			</tr>
		</table>

</body>
</html>