<!DOCTYPE HTML>
	<?php 
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
$pg = strtolower($_REQUEST['code']);
if(isset($_REQUEST['preview'])){$preview = $_REQUEST['preview'];}else{$preview=0;}
if(isset($_SESSION['DYA_id'])){$user = $_SESSION['DYA_id'];}else{$user=-1;}

// $mem = new Memcached();
// $mem->addServer("127.0.0.1", 11211);

?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="CBStyle.css"/>
	<link rel="stylesheet" type="text/css" href="ANS.css"/>
	<link href="/css/bootstrap.min.css" type="text/css" rel="stylesheet">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<script src="/js/jquery.tools.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/Chart.js"></script>
	<script src="/js/bootbox.min.js"></script>
	<script src="dya.js"></script>

	<title>DoYouAgree</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> <meta name="apple-mobile-web-app-capable" content="yes" />
	<meta charset="utf-8">

	<title>Do You Agree</title>

	<script type="text/javascript">
	loadQnHere(startFeedback('<?php echo $pg; ?>'),'drawArea','<?php echo $preview; ?>');

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






