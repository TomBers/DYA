<?php

include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');

$qzCode = $_POST['quiz'];

$sql = "SELECT `users`.`firstname`,`users`.`lastname`,`users`.`imgURL`,`qzResponses`.`score` FROM `qzResponses` INNER JOIN `users` ON `users`.`id` = `qzResponses`.`user` WHERE `quizCode` = '$qzCode' ORDER BY `score` DESC";

$result = mysqli_query($db,$sql);
$num_rows = mysqli_num_rows($result);




$rows = array();
$cnt =1;
while($row = mysqli_fetch_array($result))
  {
		
		$rank= ordSuffix($cnt);
		$cnt++;
		$row['rank'] = $rank;
		$rows[] = $row;
	}


mysqli_close($db);

echo json_encode($rows);
function ordSuffix($i) {
						   $str = "$i";
						   $t = $i > 9 ? substr($str,-2,1) : 0;
						   $u = substr($str,-1);
						   if ($t==1) return $str . 'th';
							   else switch ($u) {
							       case 1: return $str . 'st';
							       case 2: return $str . 'nd';
							       case 3: return $str . 'rd';
							       default: return $str . 'th';
								   }
							}

?>