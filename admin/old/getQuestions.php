<?php
$uid = $_POST["uid"];
// echo $type;
include ($_SERVER['DOCUMENT_ROOT'].'/CDB.php');

	$sql = "SELECT `code`,`question`,`active`,`qType`,`option1`,`option2`,`option3`,`option4`,`option5`,`primaryColour`,`secondaryColour`,`draw` FROM `questions` WHERE `userId` ='$uid'";
	
	
	
	
	$result = mysqli_query($db,$sql);

	$results = array();
	while($row = mysqli_fetch_assoc($result))
	  {
		$results[] = $row;
	}
		echo json_encode($results);

mysqli_close($db);


?>

