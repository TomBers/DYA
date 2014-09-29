<?php 
include "../DYA_CDB.php";

$search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
  );

$code = strtolower($_REQUEST['code']);
$ccode = preg_replace($search, '', $code);
$pg = mysql_real_escape_string($ccode);


$query="select `code` from `questions` where code='$pg' AND active='1'";
$resource = mysqli_query($db, $query);
// echo mysqli_num_rows($resource);
if (mysqli_num_rows($resource) <= 0) {
	// echo "Not in DB";
// 	// the code is not in the database
	header("Location: /UX/index.php?err=2");
}




?>
<!DOCTYPE HTML>

<html>
<link rel="stylesheet" type="text/css" type="text/css" href="/css/style.css">
<link rel="stylesheet" type="text/css" href="/UI/CBStyle.css"/>
<link href="/css/bootstrap.min.css" type="text/css" rel="stylesheet">

<script src="/js/jquery.tools.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/Chart.js"></script>
<script src="/js/bootbox.min.js"></script>
<script src="/UX/dya.js"></script>
<head>
	<style>
	.qnDiv{
		width:100%;
		border:1px solid black;
		text-align:center;
		margin: 10px auto;
	}
	img.center{
		max-width:50px;
		max-height:50px;
	}
	#wrapper p{
		font-family:arial;
	 	font-size:14px;
	}
	#slider input[type="range"]{
		width:90%;
	    -webkit-appearance: none;
	    -moz-apperance: none;
	    border-radius: 6px;
	    height: 6px;
		margin: 25px auto;
	    background-image: -webkit-gradient(
	        linear,
	        left top,
	        right top,
	        color-stop(0.49, #94A14E),
	        color-stop(0.50, #C5C5C5)
	    );
	}

	#slider input[type='range']::-webkit-slider-thumb {
	    -webkit-appearance: none !important;
	    background-image: url(/images/slider_icon3.png);
	   
	    height: 60px;
	    width: 60px;
	}

	</style>
	
	<meta charset="utf-8">

	<title>Do You Agree</title>
	
	<script type="text/javascript">
	
	$( document ).ready(function() {
		
		var code = 'quiz=<?php echo $_GET['code'];?>';
		$.ajax({
				    type:'POST',
				    data:code,
				    url:'/quiz/getUserQns.php',
				    success:function(res) {

						// console.log(res);
						var jsn = $.parseJSON(res);
						startFeedback(usr,false,jsn[0].code,'true');
						for(i = 0;i < jsn.length; i++ ){
							$("body").append('<div class="qnDiv" id="'+jsn[i].code+'"></div>');
							loadQnHere(jsn[i].code);
						}
						// console.log(jsn);					
			}
		});
	    
	});
	
	
	<?php
	if(isset($_COOKIE['DYA_id'])){
		echo "var userLoggedin=1;";
	}
	else{
		echo "var userLoggedin=0;";
	}
	
	?>
	var usr = <?php 
        session_start();
					$nu=1; 
					if( isset( $_COOKIE['DYA_id'] ) || isset( $_REQUEST['askLogin'] ) ){
						echo $_COOKIE['DYA_id'];
					} else if( isset( $_SESSION['wantsAnon'] ) ) {echo '2';}
					else{echo $nu; } ?>;
	
	
	$.ajaxSetup({
	    beforeSend:function(){
	        // show gif here, eg:
	        $("#loading").show();
	    },
	    complete:function(){
	        // hide gif here, eg:
	        $("#loading").hide();
				$('input[type="range"]').change(function () {

				    var val = ($(this).val() - $(this).attr('min')) / ($(this).attr('max') - $(this).attr('min'));

				    $(this).css('background-image',
				                '-webkit-gradient(linear, left top, right top, '
				                + 'color-stop(' + val + ', #94A14E), '
				                + 'color-stop(' + val + ', #C5C5C5)'
				                + ')'
				                );

				});
	    }
	});

	


	
	</script>
	
</head>

<body>
	
	<div id="loading"><img class="center" src="/images/menuIcon.png"> 
		</div>
		
		
	
</body>

</html>
	





