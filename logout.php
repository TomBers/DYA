<?php
session_start();
// unset($_SESSION['DYA_id']);
// unset($_SESSION['DYA_name']);
// unset($_SESSION['DYA_imageURL']);

session_destroy();

?>

<h1>Successfully Logged out
<a href="/index.php">Back to DoYouAgree</a></h1>

