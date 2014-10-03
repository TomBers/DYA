<?php 
error_reporting(E_ERROR | E_PARSE); 

    // phpinfo(); 
    // $THE_HOST = "2340d350c269f9aa5de101d9842d904fc1aa3c82.rackspaceclouddb.com";
    //     $THE_USER = "atdesign";
    //     $THE_PWD = "TLdjdACu6R69";

	$THE_HOST = "localhost";
    $THE_USER = "root";
    $THE_PWD = "root";
    $THE_DB = "dya";
        
        // 
        // Connect to the database 
        // 
       // $db=mysqli_connect($THE_HOST,$THE_USER,$THE_PWD,$THE_DB);
		$db = new MYSQLi($THE_HOST,$THE_USER,$THE_PWD,$THE_DB);
        if (!$db) { 
             die('Could not connect to the database: '.mysqli_connect_error() ); 
        } 
?>
