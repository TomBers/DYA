<?php

$qzCode = $_POST['quiz'];
if(startsWith($qzCode,'http://')){echo 1;}
else{
include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');

$sql = "SELECT `active` FROM `questions` WHERE `code`='$qzCode' LIMIT 1";

$result = mysqli_query($db,$sql);
$row = mysqli_fetch_array($result);
echo $row['active'];
mysqli_close($db);
}

function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

?>