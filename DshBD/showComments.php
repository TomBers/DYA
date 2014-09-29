<?php

$code = $_REQUEST['code'];


include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');

// echo "BOB";
	$sql = "SELECT `imgURL`,`firstname`,`lastname`,`response` FROM `responses` JOIN `users` ON `responses`.`user`=`users`.`id` WHERE `eventCode`='$code' AND `response` != '' ORDER BY `responses`.`id` DESC";
	$result = mysqli_query($db,$sql);
	$num_rows = mysqli_num_rows($result);
	
	echo "<div id=\"commentsContainer\">";
	echo "<div id=\"commentsCount\">";
	echo "$num_rows Comments";
	echo "</div>";
	while($row = mysqli_fetch_array($result))
	  {
		echo "<div id=\"comment\">";
		$img = $row['imgURL'];
		$name = $row['firstname']." ".$row['lastname'];
		$comment = $row['response'];
		echo "<div id=\"commentUser\"><img src=\"$img\">";
		echo "<div id=\"commentName\">$name</h3></div></div><div id=\"commentTxt\">$comment</div>";
		echo "</div>";
		
	}
	echo "</div>";

mysqli_close($db);






?>