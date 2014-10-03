<?php

include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');
// 
$inData = json_decode(stripslashes($_POST['data']));

$typ = $inData[0];
array_shift($inData);
$dashcode = $inData[0];
// 
// echo "Updated <br>";
// print_r($inData);

// 
//   // here i would like use foreach:
if ($typ == 'liveview'){
	
	$userid = $_COOKIE['DYA_id'];
	$codes = serialize($inData);
	// echo $codes;
	$sql = "INSERT INTO `dya`.`dashboards` (`id`,`code`, `qns`, `userid`) VALUES (NULL, '$dashcode', '$codes', '$userid') ON DUPLICATE KEY UPDATE `qns`='$codes';";
	
		$result = mysqli_query($db,$sql);
		
		mysqli_close($db);
		echo "Dashboard Created";
	} 
	else{

		for($i = 0; $i < (count($inData) - 1 ) ; $i++){
			$a = $inData[$i];
			$b = $inData[$i+1];
			// echo "Link $a to $b \n";
			// echo "UPDATE  `contacts`.`questions` SET  `agreeNext` =  '$b' WHERE  `questions`.`code` ='$a' \n";
			$sql = "UPDATE  `dya`.`questions` SET  `agreeNext` =  '$b', `group` = '$dashcode',`end` = '0' WHERE  `questions`.`code` ='$a';";
			$result = mysqli_query($db,$sql);

		}
		$indx = count($inData) - 1;
			$last = $inData[$indx];
			$exitCode = 'https://www.doyouagree.co.uk/pages/thankyou.html';
			$updateLast = "UPDATE  `dya`.`questions` SET `agreeNext` = '$exitCode',`group` = '$dashcode',`end` = '1' WHERE  `questions`.`code` ='$last';";
			$result = mysqli_query($db,$updateLast);
		
		if($typ == 'quiz'){
			$start = $inData[0];
			// clearout previous answers
			mysqli_query($db,"UPDATE `qzAnswers` SET `qnFlag`='_' WHERE `code` IN('".implode("','",$inData)."')");	
			
			mysqli_query($db,"UPDATE `qzAnswers` SET `qnFlag`='START' WHERE `code`='$start'");
			mysqli_query($db,"UPDATE `qzAnswers` SET `qnFlag`='END' WHERE `code`='$last'");
		}	
			
		mysqli_close($db);
		// echo "Order has been changed";
	}
	
?>