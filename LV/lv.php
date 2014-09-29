<!DOCTYPE html>	

<!-- <link href="/css/bootstrap.min.css" rel="stylesheet"> -->
 <script src="/js/jquery.tools.min.js"></script>
 <!-- <script src="/js/bootstrap.min.js"></script> -->
 <script src="/js/jquery.sortable.js"></script>

 <script src="/UX/dya.js"></script>

<script>
$( document ).ready(function() {
$('.sortable').sortable();

$('.handles').sortable({
	handle: 'span'
});
$('.connected').sortable({
	connectWith: '.connected'
});
$('.exclude').sortable({
	items: ':not(.disabled)'
});

$(".cmmt").each( function (index) {
	// alert(index + ": " + $( this ).attr('id'));
	var code = $( this ).attr('id');
	ldComments(code);
	var myVar=setInterval(function(){ldComments(code)},5000);
	
	});

	$(".dbox").each( function (index) {
		var code = $( this ).attr('id');
		var codeString = "qn="+code;
		// console.log(codeString);

		$.ajax({
						    type:'POST',
							data:codeString,
							url:'/UX/storeAndReturn.php',
							success:function(res) {
							json = JSON.parse(res);
							if(json[0].qType == 'PIC'){
								drawPicKey(res,json[0].code,'1','1');
							}
							else{$('#'+code).append(drawGraphKey(res,'bob','1'));}
								
								}
					});

	});

});




	function ldComments(code){
		// alert('bob');
	var codeString = "code="+code; 
			// alert(codeString);
			$.ajax({
										    type:'POST',
										    data:codeString,
										    url:'/DshBD/showComments.php',
										    success:function(res) {
											// alert('success');
											// alert(res);
											$("#"+code).html(res);
											}
					});
}


</script>





<style>
#container{
	width:100%;
	overflow:hidden;
}
.container{
	width:100%;
}
.sortable {
			width: 100%;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}
		.sortable.grid {
			overflow: hidden;
		}
		.sortable li {
			list-style: none;
			border: 1px solid #CCC;
	
		}
		.sortable li p{
			text-align: center;
			font-family: "Source Sans Pro","Helvetica Neue",Helvetica,Arial,sans-serif;
			padding-bottom:0px;
		}
		
		.sortable.grid li {
			float: left;
			width: 350px;
			
		}
		.handle {
			cursor: move;
		}
		.sortable.connected {
		
			min-height: 100px;
			float: left;
		}
		li.disabled {
			opacity: 0.5;
		}
		li.highlight {
			background: #FEE25F;
		}
		li.sortable-placeholder {
			border: 1px dashed #CCC;
			background: none;
		}
#frame{
	margin: 0 auto;
	border:none;
	overflow: hidden; 
	min-height:300px;
	width:100%;
}

	#commentsContainer{
		line-height:14px;
		font-family: "Source Sans Pro","Helvetica Neue",Helvetica,Arial,sans-serif;
		font-size: 14px;
		width:90%;
		color: #555555;
		display:block;
		background:white;
		
		margin: 0 auto;
		overflow-x:hidden;
		overflow-y:hidden;
		text-align: left;
	}
	#commentsCount{

		border-bottom:solid 3px #2C5D70;
		margin-bottom:10px;
		margin-left:0px;
	}
	#comment img {
		max-width:50px;
		max-height:50px;
		display:inline;
		margin:0px;
		padding:0px;
	}
	#comment{
		margin-bottom:10px;
		margin-left:0px;
	}
	#commentName{
		display:inline;
		position: relative;
		left: 0px;
		top: -30px;
		margin-left:10px;
		font-weight:bold;
	}
	#commentUser{display:inline;}
	#commentTxt{
			width:80%;
			display:block;
			position: relative;
			left: 60px;
			top: -27px;
	}

.chart-legend li{
	display:block;
	width:100%;
	border:none;
	font-family: "Source Sans Pro","Helvetica Neue",Helvetica,Arial,sans-serif;
	text-align:center;
}

ul{
	
	-webkit-padding-start:0px;

}
	

</style>

<div class="container">
	<div class="col-sm-3">

</div>
<div class="col-sm-9">
	
<ul id="sortable2" class="sortable grid">
	
	<li>
	<a class="twitter-timeline" href="https://twitter.com/DoYouAgreeApp" data-widget-id="443368990098718720">Tweets by @DoYouAgreeApp</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</li>
	
<?php



 
$eventName = $_REQUEST["code"];
include "../DYA_CDB.php";
 
$query  = "SELECT qns FROM dashboards where code ='$eventName';";
 
$result = mysqli_query($db,$query);
 

while ($row = mysqli_fetch_assoc($result)) {
	$codes = (unserialize($row['qns']));

}







$cnt = 0;
foreach ($codes as &$cde){
	$sql  = "SELECT question,qType FROM questions where code ='$cde';";
	$result = mysqli_query($db,$sql);
	while ($row = mysqli_fetch_assoc($result)) {
		$typ = ($row['qType']);
		$qn = $row['question'];
	}
	if($typ == 'CMMT'){
		echo "<li><p>$qn</p><div class=\"cmmt\" id=\"$cde\"><div>";

	}
	else if($type == 'SLD'){
	 echo "<li><div class=\"dbox\" id=\"$cde\"><p>$qn</p><iframe scrolling=\"no\" id=\"frame\" src=\"https://134.213.63.117:8000/?code=$cde&slider=true\"></iframe></div>";
		
	}
	else{
	echo "<li><div class=\"dbox\" id=\"$cde\"><p>$qn</p><iframe scrolling=\"no\" id=\"frame\" src=\"https://134.213.63.117:8000/?code=$cde\"></iframe></div>";
		
	}
	$cnt++;
}
	

mysqli_close($db);

// if($_REQUEST["tid"] != "") {
$tid = '443368990098718720';//$_REQUEST["tid"];

//echo "<a class=\"twitter-timeline\" href=\"https://twitter.com\" data-widget-id=\"$tid\">Tweets</a>";

// }	
		 
?>

</ul>

</div></div>
	
	

