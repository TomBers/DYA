<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$pg = strtolower($_REQUEST['code']);

$exists = $pg.'_exists';


if(isset($_REQUEST['askLogin'])){$auth = $_REQUEST['askLogin'];}else{$auth ='bill';}
if(isset($_REQUEST['preview'])){$preview = $_REQUEST['preview'];}else{$preview=0;}
if(isset($_SESSION['DYA_id'])){$user = $_SESSION['DYA_id'];}else{$user=-1;}

if($pg == 'dya' && $user == -1){
	$auth = 0;
	$user = 1;
}



$mem = new Memcached();
$mem->addServer("127.0.0.1", 11211);

$result = $mem->get($exists);

if ($result) {
	// echo 'memcached';
} else {
    include "../DYA_CDB.php";
	$qry = $db->prepare('select code from questions where code=?');
	$qry->bind_param('s',strtolower($_REQUEST['code']));
	$qry->execute();
	$qry->store_result();
	
	if ($qry->num_rows <= 0) {
		header("Location: /UX/index.php?err=2");	
	}else{
    $mem->set($exists, "exists") or die("Couldn't save anything to memcached...");
	}
}
?>
<!DOCTYPE HTML>

<html>
<head>
<link rel="stylesheet" type="text/css" href="/UX/CBStyle.css"/>
<link href="/css/bootstrap.min.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<script src="/js/jquery.tools.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/Chart.js"></script>
<script src="/js/bootbox.min.js"></script>
<script src="/UX/dya.js"></script>

	<title>DoYouAgree</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> <meta name="apple-mobile-web-app-capable" content="yes" />
	
	<style>
	
	#drawArea{
		margin:10px;
	}
	.btn {border-radius: 0;}
	
	@media screen and (-webkit-min-device-pixel-ratio:0){
	#slider .bar {
		background:gray;
		border:none;
	}
	}
	
	#qnText {
	    font-size: 20px;
	    text-align:center;
	}

	#slider input:focus{
	outline:none;
	}

	#slider{
		padding-top:10px;
		padding-bottom:25px;
	}

	#wrapper{
		text-align:center;
		font-family: 'Source Sans Pro', sans-serif;
		color:#354353;
		font-size:24px;
	}

	input[type="range"]::-webkit-slider-thumb {
		-webkit-appearance: none;
		position: relative;
		top: 0px;
		z-index: 1;
		width: 70px;
		height: 70px;
		cursor: pointer;
		border: 0px;
		background-color:#f15c51;
		border-radius: 50px;

	}

	#slider input[type="range"]{
		width:90%;
		max-width:960px;
 -webkit-appearance: none;
	   	    -moz-apperance: none;
	    height: 6px;
		margin: 25px auto;
	    background-image: -webkit-gradient(
	        linear,
	        left top,
	        right top,
	        color-stop(0.49, #f15c51),
	        color-stop(0.50, #C5C5C5)
	    );

	#rangevalue{
		margin-top:0px;
	}
	div.chart-legend {
	    font-size: 1.4em;
	}
	ul{
		-webkit-padding-start:0px;
	}
	
	#commentForm {
		width:60%;
		margin:0 auto;
	}
	@media screen and (max-width:700px){
		#commentForm {
			width:96%;
			margin:0 auto;
		}
	}

	
	</style>
	<!--[if IE ]>
	<style>
		#slider input[type="range"]{height:30px;}
		
	</style>
	<![endif]-->
	<meta charset="utf-8">

	<title>Do You Agree</title>
	
	<script type="text/javascript">
	
//	$( document ).ready(function() {

		loadQnHere(startFeedback('<?php echo $pg; ?>','<?php echo $user ?>',false,false,'<?php echo $auth; ?>'),'drawArea','<?php echo $preview; ?>');
			
			
			
//	});
	
	$( document ).ajaxComplete(function() {
			$('input[type="range"]').change(function () {

			    var val = ($(this).val() - $(this).attr('min')) / ($(this).attr('max') - $(this).attr('min'));

			    $(this).css('background-image',
			                '-webkit-gradient(linear, left top, right top, '
			                + 'color-stop(' + val + ', #f15c51), '
			                + 'color-stop(' + val + ', #C5C5C5)'
			                + ')'
			                );
			});
	});
	
	
	

	
	</script>
	
</head>
<body>
	<div id="drawArea"></div>
		

	
</body>

</html>
	





