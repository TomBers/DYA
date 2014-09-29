<?php

include ($_SERVER['DOCUMENT_ROOT'].'/CDB.php');

	



$data = json_decode(stripslashes($_POST['data']));

  // here i would like use foreach:

	for($i = 0; $i < (count($data) - 1 ) ; $i++){
		$a = $data[$i];
		$b = $data[$i+1];
		// echo "Link $a to $b \n";
		// echo "UPDATE  `contacts`.`questions` SET  `agreeNext` =  '$b' WHERE  `questions`.`code` ='$a' \n";
		$sql = "UPDATE  `contacts`.`questions` SET  `agreeNext` =  '$b' WHERE  `questions`.`code` ='$a';";
		$result = mysqli_query($db,$sql);
		
	}

mysqli_close($db);
  // foreach($data as $d){
  //      echo $d.",";
  //   }

	echo "Order has been changed";
?>