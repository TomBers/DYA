<?php
error_reporting(E_ALL);
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
$j = $_POST['pg'];

if(isset($_POST['div'])){
	$div = $_POST['div'];
}else {$div="drawArea"; }
if(isset($_POST['preview'])){
	$preview = $_POST['preview'];
}else {$preview = 0;}

// $mem = new Memcached();
// $mem->addServer("127.0.0.1", 11211);
// 
// $cache = $mem->get(strtolower($j));
// 
// if($cache){
// 	// print_r($cache);
// 	$qType = $cache['qType'];
// 		$next = $cache['agreeNext'];
// 		$active = $cache['active'];
// 		$draw = $cache['draw'];
// 		$sldURL = $cache['sliderURL'];
// 		$sldText = $cache['sliderText'];
// 		$draw = $cache['draw'];
// 		$options = $cache['options'];
// 		$qn = $cache['questionHTML'];
// 		$end = $cache['end'];
// 		$login = $cache['login'];	
// 	
// }else{

	$THE_HOST = "2340d350c269f9aa5de101d9842d904fc1aa3c82.rackspaceclouddb.com";
    $THE_USER = "atdesign";
    $THE_PWD = "TLdjdACu6R69";
    $THE_DB = "dya";

		$db = new MYSQLi($THE_HOST,$THE_USER,$THE_PWD,$THE_DB);
        if (!$db) { 
             die('Could not connect to the database: '.mysqli_connect_error() ); 
        }	

	mysqli_query($db,"SET NAMES utf8;");
	$query="SELECT questionHTML,qType,active,agreeNext,draw,sliderURL,sliderText,draw,options,end,login FROM `questions` WHERE `code`='$j' LIMIT 1;";

	$result = mysqli_query($db, $query);
	$row = mysqli_fetch_assoc($result); 
	$qType = $row['qType'];
	$active = $row['active'];
	$next = $row['agreeNext'];
	$draw = $row['draw'];
	$sldURL = $row['sliderURL'];
	$sldText = $row['sliderText'];
	$options = $row['options'];
	$qn = $row['questionHTML'];
	$end = $row['end'];
	$login = $row['login'];
	
	// $mem->set(strtolower($j),$row) or die("Couldn't save anything to memcached...");
// }

$lgnop = json_decode($login);


// Deal with User inteaction and active 

if($active != 1 || $qType == ""){
	

	echo "<br><br>Question Does not exist or is not active - please check your link";

}else if($lgnop->{'force'} == 1 && !isset($_SESSION['DYA_id'])){
	$loginChain ="?redirect=$j";
	if($lgnop->{'fb'}){$loginChain .='&facebook=true';}
	if($lgnop->{'twitter'}){$loginChain .='&twitter=true';}
	if($lgnop->{'google'}){$loginChain .='&google=true';}
	if($lgnop->{'linkedin'}){$loginChain .='&linkedin=true';}
	// echo $loginChain;
	
		
	header('Location: https://www.doyouagree.co.uk/SLogin.php'.$loginChain);
	
	
}else{

if($end == 1){
	unset($_COOKIE['usrLstQn']);
	unset($_COOKIE['currentQz']);
}

echo '<div id="wrapper">';
echo $qn;
echo '<div id="sliderHint"></div> </div>';

switch($qType){
	case "LND":
	writeLND($j,$div,$preview);
	break;
	case "SLD":
	writeSLD($j,$div,$draw,$sldURL,$sldText,$preview);
	break;
	case "CMMT":
	writeCMMT($j,$div,$preview);
	break;
		case "RDO":
	writeRDO($j,$options,$div,$draw,$preview);
	break;
		case "CHK":
	writeCHK($j,$options,$div,$draw,$preview);
	break;
		case "PIC":
	writePIC($j,$options,$div,$draw,$preview);
	break;
		case "QZ":
	writeQZ($j,$options,$div,$draw,$preview);					
	break;

	}
}
	function writeQZ($j,$options,$div,$draw,$preview){
		$options = json_decode($options);
		echo "<div id=\"formElements\">";
		for($i = 0; $i < count($options) ; $i++){
			$options[$i]=stripslashes($options[$i]);
			echo "<input type=\"radio\" name=\"radio\" value=\"$i\" id=\"radio$i\" class=\"css-checkbox\" /><label for=\"radio$i\" class=\"rbcss-label\">$options[$i]</label>";
		}
		echo "</div>";
		if(!$preview) echo "<div class=\"btn btn-lg btn-primary btn-block\" style=\"width:40%;margin:0 auto;\" onclick=\"quizForm('$j','$div','$draw')\" >Answer</div>"; 
	}

	function writeLND($j,$div,$preview){
		if(!$preview) echo "<div class=\"btn btn-lg btn-primary btn-block\" style=\"width:40%;margin:0 auto;\" onclick=\"validateForm('$j','LND','$div','0')\" >Start</div>";
	}

	function writeCHK($j,$options,$div,$draw,$preview){
		$options = json_decode($options);
		echo "<div id=\"formElements\">";
		for($i = 0; $i < count($options) ; $i++){
			$options[$i]=stripslashes($options[$i]);
			echo "<input type=\"checkbox\" name=\"$i\" id=\"checkbox$i\" class=\"css-checkbox\" /><label for=\"checkbox$i\" class=\"cbcss-label\">$options[$i]</label>";
		}
		echo "</div>";
		if(!$preview) echo "<div class=\"btn btn-lg btn-primary btn-block\" style=\"width:40%;margin:0 auto;\" onclick=\"validateForm('$j','CHK','$div','$draw')\">Submit</div>";
	}


	function writePIC($j,$options,$div,$draw,$preview){
		$options = json_decode($options);
		echo "<div id=\"formElements\">";
		for($i = 0; $i < count($options) ; $i++){
			$options[$i]=stripslashes($options[$i]);
			echo "<input type=\"radio\" name=\"radio\" value=\"$i\" id=\"radio$i\" style=\"display:none;\" />";
		}
		echo "</div>";
		echo "<div id=\"$j\" style=\"display:none;\">$div</div>"; 
		if(!$preview) dealWithPicClick($j,$div);
	}


	function writeRDO($j,$options,$div,$draw,$preview){
		$options = json_decode($options);
		echo "<div id=\"formElements\">";
		for($i = 0; $i < count($options) ; $i++){
			$options[$i]=stripslashes($options[$i]);
			echo "<input type=\"radio\" name=\"radio\" value=\"$i\" id=\"radio$i\" class=\"css-checkbox\" /><label for=\"radio$i\" class=\"rbcss-label\">$options[$i]</label>";
		}
		echo "</div>";
		if(!$preview) echo "<div class=\"btn btn-lg btn-primary btn-block\" style=\"width:40%;margin:0 auto;\" onclick=\"validateForm('$j','CHK','$div','$draw')\">Submit</div>";
	}


	function writeSLD($j,$div,$draw,$sldURL,$sldText,$preview){
		if($sldURL != ""){
			echo "<style>input[type=\"range\"]::-webkit-slider-thumb{background-image: url($sldURL)} </style>";
		}	
		echo "<div id=\"slider\"><input class=\"bar\" id=\"rangeinput\" type=\"range\" name=\"value\" value=\"50\" min=\"0\" max=\"100\" step=\"1\"
			onchange=\"showValue(this.value)\" />";

		if($sldText == ""){
			echo "<br><br><div id=\"slidTxt\" align=\"center\"><span id=\"preSlideTxt\">I Agree : </span><span id=\"rangevalue\" align=\"center\" >50</span><span id=\"postSlideTxt\">%</span></div></div><br>";
		}
		else{
			$pieces = explode("X",$sldText);
			echo "<br><br><div id=\"slidTxt\" align=\"center\"><span id=\"preSlideTxt\">$pieces[0]</span><span id=\"rangevalue\" align=\"center\" >50</span><span id=\"postSlideTxt\">$pieces[1]</span></div></div><br>";
		}

		if(!$preview) echo "<div class=\"btn btn-lg btn-primary btn-block\" style=\"width:40%;margin:0 auto;\" onclick=\"validateForm('$j','SLD','$div','$draw')\" >Submit</div>";

	}

	function writeCMMT($j,$div,$preview){
		echo "<div id=\"comment\" style=\"display:none\"></div>";
		echo "<textarea rows=\"4\" cols=\"50\" id=\"commentForm\" class=\"form-control\" name=\"email\" placeholder=\"Comment\" onkeyup=\"document.getElementById('comment').innerHTML=document.getElementById('commentForm').value;\" required autofocus></textarea>";
		if(!$preview)	echo "<br><div class=\"btn btn-lg btn-primary btn-block\" style=\"width:60%;margin:0 auto;\" onclick=\"validateForm('$j','CMMT','$div','$draw')\" >Next</div><br>";
		include('getComments.php');
		showComments($j);
	}

	function dealWithPicClick($pg,$div){
		?>
		<script>
		$( document ).ready(function() {		
			$( "img" ).click(function() {
				var index = $( "img" ).index( this );
				setOption(index,'<?php echo $pg; ?>','<?php echo $div; ?>');
			});
		});
		</script>
		<?php

	}



	?>

