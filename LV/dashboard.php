<style>
#container{
	width:100%;
	overflow:hidden;
}
#frame{

	float:left;
	border-width: 0px;
	overflow: hidden; 
	width:33%;
	height:50%;	
}
#frame2{

	float:left;
	border: 0px solid red;
	overflow: hidden; 
	width:33%;
	height:70%;	
}
#wordCloud{
	float:left;
	width:33%;

	border: 0px solid red;
}

.twitter-timeline{
	width:100%;
	height:300px;
}

</style>






<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

<div id="container">

<iframe id="frame" scrolling="no" src="http://162.13.147.58:8000/?code=qxqn"></iframe>


<img id="wordCloud" src="/images/wordCloud.png"></img>

<iframe id="frame2" scrolling="no" src="http://162.13.147.58:8000/?code=qurd"></iframe>

</div>
<?php 	


// <a class="twitter-timeline" href="https://twitter.com/DoYouAgreeApp" data-widget-id="443368990098718720">Tweets by @DoYouAgreeApp</a>
// <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	
// echo "Hello";


 
// $eventName = $_REQUEST["code"];
// include "../CDB.php";
//  
// $query  = "SELECT eventCode FROM eventQuestions where eventName ='$eventName';";
//  
// $result = mysqli_query($db,$query);
//  
// $qs = array();
// while ($row = mysqli_fetch_assoc($result)) {
// array_push($qs,$row['eventCode']);
// }
// 
// mysqli_close($db);
// 
// 
// 
// 
// 	
// $cnt=0;
// foreach($qs as &$val){
	

	
// echo "<iframe id=\"frame\" scrolling=\"no\" src=\"http://162.13.147.58:8000/?code=$val\" style=\"border-width: 1px;overflow: hidden; width:30%;height:50%;\"></iframe>";
	

	
	// }
	
	echo "<br><br>";
	if($_REQUEST["tid"] != "") {
	$tid = $_REQUEST["tid"];

	echo "<a class=\"twitter-timeline\" href=\"https://twitter.com\" data-widget-id=\"$tid\">Tweets</a>";

	}		
 
?>
