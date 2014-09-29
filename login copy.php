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
	var redirect = '<?php echo $_GET['redirect']; ?>';
		var dataString = 'name='+name;
		dataString += '&email='+email; 
		$.ajax({
				    type:'POST',
				    data:dataString,
				    url:'/saveUser.php',
				    success:function(res) {
						setCookie('DYA_name',name);
						setCookie('DYA_id',res);
						setCookie('DYA_imageURL','/images/profile.jpeg');
					
					   window.location.href = "http://www.doyouagree.co.uk/"+redirect;
				}
				});

}

function setCookie(cname,cvalue)
{
var exdays = 300;
var d = new Date();
d.setTime(d.getTime()+(exdays*24*60*60*1000));
var expires = "expires="+d.toGMTString();
document.cookie = cname + "=" + cvalue + "; " + expires;
}
</script>

</head>
<body>
<?php
include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');
include($_SERVER['DOCUMENT_ROOT'].'/topBar.php');

if(!isset($_REQUEST['token'])){
	session_start();
	$_SESSION['redirect'] = $_GET['redirect'];
	$_SESSION['multiView'] = $_GET['multiView'];
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


	   <input type="text" class="form-control" name="name" id="name" placeholder="Name"/>
	   <input type="email" class="form-control" name="email" id="email" placeholder="E-mail"/>	
	   <br><br>	

		<input id="button" class="btn btn-lg btn-primary btn-block" type="submit" value="Sign in" onclick="saveUser()"/>
</div>
	</div>
</div>	
	
	<?php
}else{
	include('login/LoginRadiusSDK.php');
	include('login/LoginRadiusStatusUpdate.php');
	include('login/LoginRadiusContacts.php');
	include('login/LoginRadiusCompany.php');
	include('login/LoginRadiusGroups.php');
	include('login/LoginRadiusMentions.php');
	include('login/LoginRadiusMessage.php');
	include('login/LoginRadiusPosts.php');
	include('login/LoginRadiusGetEvents.php');
	include('login/LoginRadiusGetStatus.php');
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
	
				}
					$EmailValue=isset($userProfile->Email[0]->Value)?$userProfile->Email[0]->Value:$userProfile->Email;
						// Insert User into DB and set session data
						$sql = "INSERT INTO `dya`.`users` (`imgURL`, `loginService`, `firstName`, `lastName`, `nickname`, `profileName`, `dateOfBirth`, `gender`, `email`) VALUES ('$userProfile->ThumbnailImageUrl' , '$userProfile->Provider', '$userProfile->FirstName', '$userProfile->LastName', '$userProfile->NickName', '$userProfile->ProfileName', '$birthDate', '$userProfile->Gender', '$EmailValue') ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id);";

					   $result = mysqli_query($db,$sql);

						// $user = array(
						// 										    'id' => mysqli_insert_id($db),
						// 										    'name' => $userProfile->FirstName,
						// 											'imgURL' => $userProfile->ThumbnailImageUrl,
						// 										);

									// print_r($user);	

						// 		
						
								$timeOut = time()+60480000;
								
								setcookie("DYA_id", mysqli_insert_id($db),$timeOut,"/");
								setcookie("DYA_name", $userProfile->FirstName,$timeOut,"/");
								setcookie("DYA_imageURL", $userProfile->ThumbnailImageUrl,$timeOut,"/");
								session_start();
								if(isset($_SESSION['redirect'])){
								  if($_SESSION['multiView'] == 'true'){ header("Location: http://www.doyouagree.co.uk/MV/".$_SESSION['redirect']);}
								  else{header("Location: http://www.doyouagree.co.uk/".$_SESSION['redirect']);}
							}
							else{
								header("Location: http://www.doyouagree.co.uk");
							}
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