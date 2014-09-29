<?php
error_reporting(E_ALL);
include "../DYA_CDB.php";	

$j = $_POST['pg'];

if(isset($_POST['preview'])){
	$preview = $_POST['preview'];
}else {$preview = 0;}

if(isset($_POST['div'])){
	$div = $_POST['div'];
}else {$div="drawArea"; }

mysqli_query($db,"SET NAMES utf8;");
$query="SELECT questionHTML,qType,agreeNext,draw,sliderURL,sliderText,draw,options FROM `questions` WHERE `code`='$j' LIMIT 1;";

$result = mysqli_query($db, $query);
$row = mysqli_fetch_assoc($result); 
$qType = $row["qType"];
$next = $row['agreeNext'];
$draw = $row['draw'];
$sldURL = $row['sliderURL'];
$sldText = $row['sliderText'];
$draw = $row['draw'];
$options = $row['options'];


echo '<div id="wrapper">';
echo $row["questionHTML"];
echo '<div id="sliderHint"></div> </div>';

switch($qType){
	case "SLD":
	writeSLD($j,$div,$draw,$sldURL,$sldText,$preview);
	break;
	case "CMMT":
	writeCMMT($j,$div);
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

	function writeCMMT($j,$div){
		echo "<div id=\"comment\" style=\"display:none\"></div>";
		echo "<textarea rows=\"4\" cols=\"50\" id=\"commentForm\" class=\"form-control\" name=\"email\" placeholder=\"Comment\" onkeyup=\"document.getElementById('comment').innerHTML=document.getElementById('commentForm').value;\" required autofocus></textarea>";
		if(!$preview)	echo "<br><div class=\"btn btn-lg btn-primary btn-block\" style=\"width:60%;margin:0 auto;\" onclick=\"storeComment('$j','$div')\" >Next</div><br>";
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

