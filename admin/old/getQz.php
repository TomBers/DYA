<?php
$uid = $_POST["uid"];
// echo $type;
include ($_SERVER['DOCUMENT_ROOT'].'/CDB.php');

	$sql = "SELECT `qzAnswers`.`code`,`qnFlag`,`qzAnswers`.`option1`,`qzAnswers`.`option2`,`qzAnswers`.`option3`,`qzAnswers`.`option4`,`qzAnswers`.`option5` FROM `qzAnswers` INNER JOIN `questions` on `questions`.`code`=`qzAnswers`.`code` WHERE `userId` ='$uid' AND `qType`='QZ'";
	
	
	
	
	$result = mysqli_query($db,$sql);

	$results = array();
	while($row = mysqli_fetch_assoc($result))
	  {
		$results[] = array(
		      'code' => $row['code'],
		      'qnFlag' => $row['qnFlag'],
		      'option1' => $row['option1'],
			  'option2' => $row['option2'],
			  'option3' => $row['option3'],
			  'option4' => $row['option4'],
			  'option5' => $row['option5']
		   );
	}
		echo json_encode($results);

mysqli_close($db);


?>

