<?php
setcookie("DYA_id", '' , time() - 3600 );
setcookie("DYA_name", '', time() - 3600);
setcookie("DYA_imageURL", '', time() - 3600);

unset($_COOKIE['DYA_id']);
unset($_COOKIE['DYA_name']);


// print_r($_POST);
    $qz ="";
	$nickname="";
	
		if(isset($_POST['nickname'])){$nickname=$_POST['nickname'];}
		else{$nickname=uniqid();}
	
	if(isset($_POST['quiz'])){
		include('CDB.php');
		
		$login = uniqid();
		
		$qz = $_POST['quiz'];
	
			$sql = "INSERT INTO `contacts`.`users` (`firstName`,`loginService`) VALUES ('$nickname','$login');";
			mysqli_query($db,$sql);
				$timeOut = time()+604800;
				
				setcookie("DYA_id", mysqli_insert_id($db),$timeOut);
				setcookie("DYA_name", $nickname,$timeOut);
				header("Location: http://www.doyouagree.co.uk/UI/DYA.php?code=$qz");
}
else{
	echo "Sorry - Some thing has gone wrong.";
}
	?>