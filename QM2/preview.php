<!DOCTYPE html>	
<?php
include('../topBar.php'); 



$code = $_GET["code"];
if($code != ""){

// Check if the current user is the user associated with the question - if not, then tell them or show page

include $_SERVER['DOCUMENT_ROOT']."/DYA_CDB.php";

$sql = "select `userID` from questions where code='$code'";

$response = mysqli_query($db, $sql);

$row = mysqli_fetch_assoc($response);
session_start();
if($row['userID'] != $_SESSION['DYA_id']) {
	// echo $row['userID']." ".$_COOKIE['DYA_id'];
		echo "Sorry this is not a question you have set";
}
else{

?>
<link href='/css/createQn.css' rel='stylesheet' type='text/css'>




<div id='newQnInfo' class="container" >
	<div class="row">
		<div id="qnPreview" class="col-sm-6">
			<div id="preview">
					<iframe scrolling="auto" src="https://www.doyouagree.co.uk/UX/DYA_SV.php?code=<?php echo $code;?>&askLogin=false&preview=true" style="width:100%;border-width: 0px;overflow: hidden;height:350px"></iframe>
			</div>
			<div id="edit"><span id='code'>Code : <strong><?php echo $code;?></strong></span><span id='editBtn'><a href="/edit/<?php echo $code;?>">Edit</a></span></div>

		</div>


		<div id="qnShare" class="col-sm-6">

			<h2>Your question has been created!</h2>
			Share this question

			<br><a href="http://www.doyouagree.co.uk/<?php echo $code;?>" target="_blank">DoYouAgree.co.uk/<?php echo $code;?></a>
			<br><br>
			<button type="button" id="askAnother" class="btn btn-success" onclick="javascript:location.href='http://www.doyouagree.co.uk/QM2/cQn.php?new=true&ModPagespeed=off'">Create Another Question</button><br><br>
			<p>Or start linking the questions below to create a survey</p>
			<!-- <button type="button" class="btn btn-info" onclick="loadTool('link')">Link your Questions</button> -->
		</div>
	</div>
</div>


<?php 
	} 
}


if($_SESSION['qnParams']['qType'] == 'QZ'){
	$createdQnType='quiz';
}
include('connectQns.php');
?>
	


<?php //} ?>
<script type="text/javascript">


    // var code = '<?php echo $code; ?>';
	// $('#preview').load('http://www.doyouagree.co.uk/UX/DYA_SV.php?askLogin=false&code='+code);
</script>

