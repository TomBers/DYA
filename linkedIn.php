<?php

if(!isset($_REQUEST['redirect'])){
$redirect="https://www.doyouagree.co.uk";
}
else{
	$redirect =  $_GET['redirect'];
}

session_start();
$_SESSION['redirect'] = $redirect;

// Change these
define('API_KEY',      '77b0na5rfvo29q'                                          );
define('API_SECRET',   'P88dWMGr16chuvhY'                                       );
// define('REDIRECT_URI', 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']);

define('REDIRECT_URI', 'https://www.doyouagree.co.uk/linkedIn.php');

define('SCOPE',        'r_fullprofile r_emailaddress rw_nus'                        );
 
// You'll probably use a database
//session_name('linkedin');

 
// OAuth 2 Control Flow
if (isset($_GET['error'])) {
    // LinkedIn returned an error
    print $_GET['error'] . ': ' . $_GET['error_description'];
    exit;
} elseif (isset($_GET['code'])) {
    // User authorized your application
    if ($_SESSION['state'] == $_GET['state']) {
        // Get token so you can make API calls
        getAccessToken();
    } else {
        // CSRF attack? Or did you mix up your states?
        exit;
    }
} else { 
    if ((empty($_SESSION['expires_at'])) || (time() > $_SESSION['expires_at'])) {
        // Token has expired, clear the state
        $_SESSION = array();
    }
    if (empty($_SESSION['access_token'])) {
        // Start authorization process
        getAuthorizationCode();
    }
}
 
// Congratulations! You have a valid token. Now fetch your profile 
$user = fetch('GET', '/v1/people/~:(firstName,lastName,emailAddress,picture-url,location,industry,positions)');
// print_r($user);
// /////////////////////////////////////

include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');
// 	
	$imageURL = $user->pictureUrl;
	$loginService = 'linkedIn';
	$firstName = $user->firstName;
	$lastName = $user->lastName;
	$email = $user->emailAddress;
	$industry = $user->industry;

	$jobTitle = $user->positions->values[0]->title;
	$company = $user->positions->values[0]->company->name;
	$geo = $user->location->name;
	
// 	
	$sql = "INSERT INTO `dya`.`users` (`imgURL`, `loginService`, `firstName`, `lastName`, `email`,`industry`,`jobTitle`,`company`,`geo`) VALUES ('$imageURL' , '$loginService', '$firstName', '$lastName', '$email','$industry','$jobTitle','$company','$geo') ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id);";
	

	
	mysqli_query($db,$sql);
	
	$_SESSION['DYA_id'] = mysqli_insert_id($db);
	$id = $_SESSION['DYA_id'];
	$_SESSION['DYA_name'] = $nickname;
	$_SESSION['DYA_imageURL'] = $imageURL;
	

if($_SESSION['redirect'] == 'https://www.doyouagree.co.uk'){
	$getBillingInfo = "SELECT `account`,`paymentId` FROM `users` WHERE `id` = '$id' LIMIT 1";
	$result = mysqli_query($db,$getBillingInfo);
	$row = mysqli_fetch_assoc($result);
	$_SESSION['account'] = $row['account'];
	$_SESSION['paymentId'] = $row['paymentId'];
}

	header("Location: $redirect");

// ////////////////////////////////////

// print "Hello $user->firstName $user->lastName. $user->emailAddress $user->pictureUrl";
exit;
 
function getAuthorizationCode() {
    $params = array('response_type' => 'code',
                    'client_id' => API_KEY,
                    'scope' => SCOPE,
                    'state' => uniqid('', true), // unique long string
                    'redirect_uri' => REDIRECT_URI,
              );
 
    // Authentication request
    $url = 'https://www.linkedin.com/uas/oauth2/authorization?' . http_build_query($params);
     
    // Needed to identify request when it returns to us
    $_SESSION['state'] = $params['state'];
 
    // Redirect user to authenticate
    header("Location: $url");
    exit;
}
     
function getAccessToken() {
    $params = array('grant_type' => 'authorization_code',
                    'client_id' => API_KEY,
                    'client_secret' => API_SECRET,
                    'code' => $_GET['code'],
                    'redirect_uri' => REDIRECT_URI,
              );
     
    // Access Token request
    $url = 'https://www.linkedin.com/uas/oauth2/accessToken?' . http_build_query($params);
     
    // Tell streams to make a POST request
    $context = stream_context_create(
                    array('http' => 
                        array('method' => 'POST',
                        )
                    )
                );
 
    // Retrieve access token information
    $response = file_get_contents($url, false, $context);
 
    // Native PHP object, please
    $token = json_decode($response);
 
    // Store access token and expiration time
    $_SESSION['access_token'] = $token->access_token; // guard this! 
    $_SESSION['expires_in']   = $token->expires_in; // relative time (in seconds)
    $_SESSION['expires_at']   = time() + $_SESSION['expires_in']; // absolute time
     
    return true;
}
 
function fetch($method, $resource, $body = '') {
    $params = array('oauth2_access_token' => $_SESSION['access_token'],
                    'format' => 'json',
              );
     
    // Need to use HTTPS
    $url = 'https://api.linkedin.com' . $resource . '?' . http_build_query($params);
    // Tell streams to make a (GET, POST, PUT, or DELETE) request
    $context = stream_context_create(
                    array('http' => 
                        array('method' => $method,
                        )
                    )
                );
 
 
    // Hocus Pocus
    $response = file_get_contents($url, false, $context);
 
    // Native PHP object, please
    return json_decode($response);
}