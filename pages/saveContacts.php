<?php
// print_r($_POST);
// $name = $_POST['name'];
 $msg = $_POST['name']." ".$_POST['email']." ".$_POST['comments'];

mail('tom@doyouagree.co.uk', "Contact from Homepage", $msg);

?>