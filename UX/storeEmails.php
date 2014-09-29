<?php
error_reporting(E_ALL);
include "../DYA_CDB.php";

mysqli_query($db,"SET NAMES utf8;");


$eventCode = $_POST['mpg'];

$tmpComment = $_POST['comment'];

$search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
  );
 
	
    $tmpC = preg_replace($search, '', $tmpComment);
    $comment = mysql_real_escape_string($tmpC);




$sql = "INSERT INTO `dya`.`emails` (`id`, `eventCode`,`email`) VALUES (NULL, '$eventCode','$comment');";


	mysqli_query($db,$sql);
	mysqli_close($db);

?>
	
