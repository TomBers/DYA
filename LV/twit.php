<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
 <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
 <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>



<style>


#sframe { float : both; display:inline; width : 300px; height : 350px ; border: 0px solid white;
 zoom: 1; -moz-transform: scale(1); -moz-transform-origin: 0 0; border-width: 0px;}

#wrap { 
	display: inline;
	float : both;
    width: 300px;
    height: 350px;
    padding: 5px;
    overflow: hidden;
}
#frame {  
	float : both;
	border-width: 0px;
	display:inline;
	margin: -10px 21px;
    -ms-zoom: 1;
    -ms-transform-origin: 0 0;
    -moz-transform: scale(1);
    -moz-transform-origin: 0px 0px;
    -o-transform: scale(1);
    -o-transform-origin: 0px 0px;
    -webkit-transform: scale(1);
    -webkit-transform-origin: 0 0;
}
#frame {
	border-width: 0px;
	display:inline;
	float : both;
    width: 490px;
    height: 700px;
    overflow: hidden;
}
#dragTwit {width: 310px; height: 720px; padding: 0.5em;display:inline;}
div.ui-widget-content.ui-draggable{
	border: 0px solid #C0C0C0;

}

div.ui-widget-content.ui-draggable:hover, div.ui-widget-content.ui-draggable:focus{
	border: 15px solid #C0C0C0;
	
}


</style>

<script>
  $(function() {
    $( "#dragTwit" ).draggable();
  });
  </script>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

<?php

if($_REQUEST["tid"] != "") {
$tid = $_REQUEST["tid"];
echo "<div id=\"dragTwit\" class=\"ui-widget-content\">";
echo "<a class=\"twitter-timeline\" href=\"https://twitter.com\" data-widget-id=\"$tid\">Tweets</a>";


echo "</div>";
}


 
$eventName = $_REQUEST["code"];
include "../CDB.php";
 
$query  = "SELECT eventCode FROM eventQuestions where eventName ='$eventName';";
 
$result = mysqli_query($db,$query);
 
$qs = array();
while ($row = mysqli_fetch_assoc($result)) {
array_push($qs,$row['eventCode']);
}

mysqli_close($db);
//print_r($qs);
 
//Setup JScript params and style for elements of dashboard

$aSize = sizeof($qs) * 2;

echo "<style>";
for($i = 0 ; $i < $aSize ; $i++){
	echo "#draggable$i { width: 310px; height: 360px; padding: 0.5em; }";
	
}
echo "</style>";

echo "<script>";
for($j = 0 ; $j < $aSize ; $j++){
	echo "$(function() { $( \"#draggable$j\" ).draggable();});";
	
}
echo "</script>";


 $cnt = 0;
foreach($qs as &$val){

echo "<div id=\"draggable$cnt\" class=\"ui-widget-content\">";
	echo "<iframe id='sframe' src=\"http://www.doyouagree.co.uk/$val.html\"></iframe></div>";
		$cnt++;	
}	


foreach($qs as &$val){
	echo "<div id=\"draggable$cnt\" class=\"ui-widget-content\">";
		echo "<iframe id='frame' src=\"http://www.doyouagree.co.uk:8000/?code=$val\"></iframe></div>";
			$cnt++;
	
	}
	
		
 
?>
