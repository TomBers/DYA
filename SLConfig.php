<?php
$config = array("base_url" => "https://www.doyouagree.co.uk/hybridauth/index.php", 
        "providers" => array ( 
            "Google" => array ( 
                "enabled" => true,
                "keys"    => array ( "id" => "314995822186-kc0f3hma52u5v94r2t2mhv5gr2hcddnh.apps.googleusercontent.com", "secret" => "yKAWv2WuNi9IO7bSDwjlX0Uu" ),
 				"scope"           => "https://www.googleapis.com/auth/userinfo.profile ". // optional
				                               "https://www.googleapis.com/auth/userinfo.email"   , // optional
 
            ),
 
            "Facebook" => array ( 
                "enabled" => true,
                "keys"    => array ( "id" => "457300947730087", "secret" => "3b4f473b5dd445586eac7e1f3b662cf1" ),
                "scope" => "email, user_about_me, user_birthday, user_hometown"  //optional.              
            ),
 
			 "LinkedIn" => array ( 
	                "enabled" => true,
	                "keys"    => array ( "key" => "77b0na5rfvo29q", "secret" => "P88dWMGr16chuvhY", "callback" => "https://www.doyouagree.co.uk/hybridauth/index.php" ),
					
				
	            ),
			
            "Twitter" => array ( 
                "enabled" => true,
                "keys"    => array ( "key" => "XfMuQ6FTOSs84F8TQI74cA", "secret" => "lLdDX0l7VcaQFUBATwDGJH1aPF4K4IgqB7hc0QIA" ) 
            ),
        ),
        // if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
        "debug_mode" => false,
        "debug_file" => "debug.log",
    );
?>