
<style>
#commentsContainer{
	width:90%;
	margin: 0 auto;
}
#commentsCount{

	border-bottom:solid 3px #2C5D70;
	margin-bottom:10px;
}
#comment img {
	max-width:50px;
	max-height:50px;
	display:inline-block;
	
}
#comment{
	margin-bottom:10px;
}
#commentName{
	display:inline;
	margin-left:10px;
	font-weight:bold;
}
#commentUser{display:inline;}
#commentTxt{
	display:block;
	margin-left:60px;
}
</style>

<?php

function showComments($code){

include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');


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

}




?>