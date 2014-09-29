<!DOCTYPE html>
<head>


	<link rel="stylesheet" type="text/css" href="/UX/CBStyle.css"/>
	<link rel="stylesheet" type="text/css" href="/css/andreea.css"/>
	<link rel="stylesheet" type="text/css" href="/UX2/UX.css"/>
	<!--[if IE ]>
	<style>
		#slider input[type="range"]{height:30px;}
		
	</style>
	<![endif]-->
	
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> <meta name="apple-mobile-web-app-capable" content="yes" />
	<script src="zepto.min.js"></script>
</head>
<?php
$code = $_REQUEST['code'];
?>
<script>
 
 drawForm('<?php echo $code; ?>');


function drawForm(qn){

$.ajax({
  type: 'POST',
  url: 'form.php',
  // data to be added to query string:
  data: { code: qn },
  // type of data we are expecting in return:
  dataType: 'json',
  timeout: 300,
  context: $('body'),
  success: function(data){
    console.log(data);
	$('#drawArea').append('<div id="wrapper">'+data.questionHTML+'<div id="sliderHint"></div></div>');
	 addInputElement(data);
	
	if(data.qType == 'SLD'){
		$('input[type="range"]').change(function () {
	
		    var val = ($(this).val() - $(this).attr('min')) / ($(this).attr('max') - $(this).attr('min'));
			 $('#rangevalue').text(val * 100);
		    $(this).css('background-image',
		                '-webkit-gradient(linear, left top, right top, '
		                + 'color-stop(' + val + ', #f15c51), '
		                + 'color-stop(' + val + ', #C5C5C5)'
		                + ')'
		                );
		});
	}
  },
  error: function(xhr, type){
    return type;
  }
})
}

function addInputElement(dat){
	var cd = dat.code;
	var dr = dat.draw;
	var opts = ((dat.options) ? dat.options : '');
	switch(dat.qType){
		case "SLD":
		writeSLD(cd,dr,dat.sliderURL,dat.sliderText);
		break;
		case "CMMT":
		writeCMMT(cd,dr);
		break;
			case "RDO":
		writeRDO(cd,dr,opts);
		break;
			case "CHK":
		writeCHK(cd,dr,opts);
		break;
			case "PIC":
		writePIC(cd,dr,opts);
		break;
			case "QZ":
		writeQZ(cd,dr,opts);					
		break;

		}
}


function writeSLD(cd,dr,sldURL,sldText){
	
	var fm = "";
	// if(sldURL != ""){
	// 	fm += "<style>input[type="range"]::-webkit-slider-thumb{background-image: url("+sldURL+")} </style>";
	// }	
	// fm += '<div id="slider"><input class="bar" id="rangeinput" type="range" name="value" value="50" min="0" max="100" step="1"	onchange="showValue(this.value)" />';
		
		fm += '<div id="slider"><input class="bar" id="rangeinput" type="range" name="value" value="50" min="0" max="100" step="1" />';

	// if(sldText == ""){
		fm += '<br><br><div id="slidTxt" align="center"><span id="preSlideTxt">I Agree : </span><span id="rangevalue" align="center" >50</span><span id="postSlideTxt">%</span></div></div><br>';
	// }
	// else{
	// 	$pieces = explode("X",$sldText);
	// 	echo "<br><br><div id=\"slidTxt\" align=\"center\"><span id=\"preSlideTxt\">$pieces[0]</span><span id=\"rangevalue\" align=\"center\" >50</span><span id=\"postSlideTxt\">$pieces[1]</span></div></div><br>";
	// }

	fm+= '<div class="btn btn-lg btn-primary btn-block" style="width:40%;margin:0 auto;" onclick="validateForm('+cd+',"SLD","drawArea","1")" >Submit</div>';
	$('#drawArea').append(fm);
}




</script>
<body>
	<div id='drawArea'></div>
</body>	
	