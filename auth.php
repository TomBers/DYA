<?php

session_start();
include('SLConfig.php');
include('hybridauth/Hybrid/Auth.php');
if(isset($_GET['provider']))
{
$provider = $_GET['provider'];
try{
    $hybridauth = new Hybrid_Auth( $config );
    $authProvider = $hybridauth->authenticate($provider);
    $user_profile = $authProvider->getUserProfile();
    if($user_profile && isset($user_profile->identifier))
    {
	
	include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');
	
	$imageURL = $user_profile->photoURL;
	$loginService = $provider;
	$firstName =$user_profile->firstName;
	$lastName = $user_profile->lastName;
	$nickname = $user_profile->displayName;
	$dateOfBirth = "".$user_profile->birthDay."/".$user_profile->birthMonth."/".$user_profile->birthYear;
	$gender = $user_profile->gender;
	$email = $user_profile->email;
	// imageURL,loginService, firstName,lastName,nickname,profilename,dateOfBirth,gender,email
    	$sql = "INSERT INTO `dya`.`users` (`imgURL`, `loginService`, `firstName`, `lastName`, `profileName`, `dateOfBirth`, `gender`, `email`) VALUES ('$imageURL' , '$loginService', '$firstName', '$lastName', '$nickname', '$dateOfBirth', '$gender', '$email') ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id);";
		
		// echo $sql;
		
		mysqli_query($db,$sql);
		// 		
				$_SESSION['DYA_id'] = mysqli_insert_id($db);
				$id = $_SESSION['DYA_id'];
				$_SESSION['DYA_name'] = $nickname;
				$_SESSION['DYA_imageURL'] = $imageURL;
		// 		
		
		if($_SESSION['redirect'] == 'https://www.doyouagree.co.uk'){
				$getBillingInfo = "SELECT `account`,`paymentId` FROM `users` WHERE `id` = '$id' LIMIT 1";
				$result = mysqli_query($db,$getBillingInfo);
				$row = mysqli_fetch_assoc($result);
				$_SESSION['account'] = $row['account'];
				$_SESSION['paymentId'] = $row['paymentId'];
		}
				$redirect = $_SESSION['redirect'];
				header("Location: $redirect");
		
    }           
 
    }
    catch( Exception $e )
    { 
         switch( $e->getCode() )
         {
                case 0 : echo "Unspecified error."; break;
                case 1 : echo "Hybridauth configuration error."; break;
                case 2 : echo "Provider not properly configured."; break;
                case 3 : echo "Unknown or disabled provider."; break;
                case 4 : echo "Missing provider application credentials."; break;
                case 5 : echo "Authentication failed The user has canceled the authentication or the provider refused the connection.";
                         break;
                case 6 : echo "User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.";
                         $authProvider->logout();
                         break;
                case 7 : echo "User not connected to the provider.";
                         $authProvider->logout();
                         break;
                case 8 : echo "Provider does not support this feature."; break;
        }
 
        echo "<br /><br /><b>Original error message:</b> " . $e->getMessage();
 
        echo "<hr /><h3>Trace</h3> <pre>" . $e->getTraceAsString() . "</pre>";
 
    }
 
}

?>