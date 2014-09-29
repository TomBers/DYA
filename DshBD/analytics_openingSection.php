<?php

include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');
session_start();

if(isset($_SESSION['DYA_id'])){
$user = $_SESSION['DYA_id'];
} else { $user = 15;}


       

//"SELECT count(*) FROM `responses` WHERE `user`='166';";
$row = mysqli_fetch_assoc(mysqli_query($db,"SELECT count(`code`) as qnc FROM `questions` WHERE `userId`='$user'"));

$qCnt = $row['qnc'];

$row = mysqli_fetch_assoc(mysqli_query($db,"SELECT count(`id`) as anc FROM `responses` WHERE `user`='$user'"));
$aCnt = $row['anc'];
?>


<style>
#navBtns .btn{
	width:175px;
	margin-bottom:10px;
}

#aos{
	margin-bottom:20px;
	padding-bottom:20px;
	border-bottom:2px solid black;
	
}
#stats{
	border:1px solid black;
	margin-left:15px;
	margin-right:15px;
	margin-bottom:25px;
}

#tasks{
	border:1px solid red;
	padding-top:20px;
}
</style>
<div id='aos' class="container" >
	<div class="row">


		<div id="stats" class="col-sm-3">
			<h2>Statistics :</h2><br>
			<p>Questions I have asked :  <strong><?php echo $qCnt ?></strong></p><br>  
			<p>Answers I have given : <strong><?php echo $aCnt ?></strong></p><br>	
		</div>
		
	
			<div  id="navBtns" class="col-sm-2">
			
			<?php if(isset($_SESSION['DYA_id'])){ ?>
			
			<a href="/QM2/cQn.php?new=true"><button type="button" class="btn btn-primary" >Ask a Question</button></a>
			<a href="/QM2/preview.php"><button type="button" class="btn btn-success">Create A Survey</button></a>
			<a href="/QM2/preview.php?view=quiz"><button type="button" class="btn btn-success">Create A Quiz</button></a>
			<?php } else { ?>
			
				<a href="/pages/howto.php"><button type="button" class="btn btn-primary" >Ask a Question</button></a>
				<a href="/pages/howto.php"><button type="button" class="btn btn-success">Create A Survey</button></a>
				<a href="/pages/howto.php"><button type="button" class="btn btn-success">Create A Quiz</button></a>
			
			<?php 
			}
			
			if(isset($_SESSION['account']) && $_SESSION['account'] != 'NULL'){ ?>
			<a href="/QM2/preview.php?view=liveview"><button type="button" class="btn btn-success">Create A LiveView</button></a>
			<?php } ?>
			</div>
		
	

	</div>
</div>

     

       

