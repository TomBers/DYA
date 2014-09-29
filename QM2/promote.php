<!DOCTYPE html>	
<?php
include('../topBar.php'); 


$uid = $_COOKIE['DYA_id'];
$code = $_REQUEST["code"];

// Check if the current user is the user associated with the question - if not, then tell them or show page

include $_SERVER['DOCUMENT_ROOT']."/DYA_CDB.php";

// $usrGrp = array();
// 
// $groupQuery = "SELECT `userid` FROM `userGroups` WHERE `Group` IN (SELECT `Group` from `userGroups` where `userid` = '$uid')"; 
// $result = mysqli_query($db,$groupQuery);
// while($row = mysqli_fetch_assoc($result))
//   {
//    $usrGrp[] = $row['userid'];
// }
// 
// $sql = "select `userID` from questions where code='$code'";
// 
// $response = mysqli_query($db, $sql);
// 
// $row = mysqli_fetch_assoc($response);

// if($row['userID'] != $_COOKIE['DYA_id'] || !in_array($row['userID'],$usrGrp) ) {
if(0){
		echo "Sorry this is not a question you have set";
}
else{

session_start();
// print_r($_SESSION['qnParams']);

// Print out Response Page
$shareCode = "https://www.doyouagree.co.uk/$code";
$view = $_REQUEST['view'];

?>


<script>



function iconType(type,code){


if (type == 0){
	var linkElement = '<a href="https://www.doyouagree.co.uk/'+code+'"><img src="https://www.doyouagree.co.uk/images/icon1.png">';
}
else if (type == 1){
	var linkElement = '<a href="https://www.doyouagree.co.uk/'+code+'"><img src="https://www.doyouagree.co.uk/images/icon2.png">';
}
else if (type == 2){
	var linkElement = '<a href="https://www.doyouagree.co.uk/'+code+'"><img src="https://www.doyouagree.co.uk/images/icon3.png">';
}


 var embElent = '<iframe scrolling="no" src="https://www.doyouagree.co.uk/'+code+'" style=\"border-width: 0px;overflow: hidden;height:100%;width:400px;"></iframe>';

// alert(embElent);


document.getElementById('embedArea').value = embElent;
document.getElementById('linkArea').value = linkElement;


}
</script>
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">
stLight.options({publisher: "30b19eb7-9e7b-45e5-a058-70ab98f65639", doNotHash: true, doNotCopy: false, hashAddressBar: false});
</script>

<link href='/css/promote.css' rel='stylesheet' type='text/css'>
<div id='shareSection' class="container" >
	<?php
	echo "<div id=\"locationInfo\">Your ";
	if($view == 'connect'){ echo "Survey : <a href=\"https://www.doyouagree.co.uk/$code\" target=\"_blank\">https://www.doyouagree.co.uk/$code</a></div>";}
	if($view == 'liveview'){ echo "LiveView : <a href=\"https://www.doyouagree.co.uk/liveView/$code\" target=\"_blank\">https://www.doyouagree.co.uk/liveView/$code</a></div>";}
	if($view == 'quiz'){ echo "Quiz : <a href=\"https://www.doyouagree.co.uk/$code\">https://www.doyouagree.co.uk/$code</a><br>LeaderBoard : <a href=\"https://www.doyouagree.co.uk/quiz/leaderboard.php?quiz=$code\" target=\"_blank\">LeaderBoard</a></div>";}
	
	?>
		<div id="qnShare">
			<h2><strong>Share through Social Media</strong></h2>
				<div id= "questionURL">Question code :<b> <?php echo $code;?> </b><br>URL : <a href="httphttps://www.doyouagree.co.uk/<?php echo $code;?>">https://www.doyouagree.co.uk/<?php echo $code;?></a></div><br><br>
				
				<span class='st_facebook_large' st_url="<?php echo $shareCode; ?>" displayText='Facebook'></span>
				<span class='st_twitter_large' st_url="<?php echo $shareCode; ?>" displayText='Tweet'></span>
				<span class='st_linkedin_large' st_url="<?php echo $shareCode; ?>" displayText='LinkedIn'></span>
				<span class='st_googleplus_large' st_url="<?php echo $shareCode; ?>" displayText='Google +'></span>
				<span class='st_email_large' st_url="<?php echo $shareCode; ?>" displayText='Email'></span>
		 </div>
				
				<div id="qnPreview">
					<h2><strong>Embed or Link through e-mail or website</strong></h2>
						<span class="stepHighlight">Paste this into your blog, website or e-mails to link to your survey</span>
						<h3>Embed</h3><textarea id="embedArea"></textarea>
						<h3>Link</h3><textarea id="linkArea">Link Code</textarea>
						<br><br><br><br>
	
						<a href="mailto:info@doyouagree.co.uk">Contact us if you need assistance</a>

				</div>
			</div>
		</div>
		<div class="container">
			<div class="row"> 
				<div class="col-md-4"><p id="whatnowtxt">What now?</p></div>
				<div class="col-md-4"><button type="button" id="anotherSurvey" class="btn btn-primary" onclick="javascript:location.href='https://www.doyouagree.co.uk/QM2/preview.php'">Create Another Survey</button></div>
				
		<div class="col-md-4"><button type="button" class="btn btn-primary" id="dashboard" onclick="javascript:location.href='https://www.doyouagree.co.uk/DshBD/analytics.php'">Go To Your Dashboard</button></div>
		</div></div>
		
		<!-- This sets the Textarea text - looks awkward - but dont remove(yet) -->
				<script>
				iconType('0','<?php echo $code; ?>');
				</script>
			

<?php } ?>


