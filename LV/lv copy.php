 <script src="/js/jquery.tools.min.js"></script>

 <script src="/js/jquery.sortable.js"></script>

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

</script>





<style>
#container{
	width:100%;
	overflow:hidden;
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
			margin: 5px;
			padding: 5px;
			min-width:350px;
			
			
		}
		.sortable li h2{
			
			font-family: "Source Sans Pro","Helvetica Neue",Helvetica,Arial,sans-serif;
		}
		
		.sortable.grid li {
			float: left;
			width: 20%;
		
			text-align: center;
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
	background:white;
	border-width: 0px;
	overflow: hidden; 
	height:275px;
}

	#commentsContainer{
		line-height:14px;
		font-family: "Source Sans Pro","Helvetica Neue",Helvetica,Arial,sans-serif;
		font-size: 14px;
		height:100%;
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

	

</style>
<?php



 
$eventName = $_REQUEST["code"];
include "../DYA_CDB.php";
 
$query  = "SELECT qns FROM dashboards where code ='$eventName';";
 
$result = mysqli_query($db,$query);
 

while ($row = mysqli_fetch_assoc($result)) {
	$codes = (unserialize($row['qns']));

}






echo "<ul id=\"sortable2\" class=\"sortable grid\">";

foreach ($codes as &$cde){
	$sql  = "SELECT question,qType FROM questions where code ='$cde';";
	$result = mysqli_query($db,$sql);
	while ($row = mysqli_fetch_assoc($result)) {
		$typ = ($row['qType']);
		$qn = $row['question'];
	}
	if($typ == 'CMMT'){
		echo "<li><h2>$qn</h2><div class=\"cmmt\" id=\"$cde\"><div>";

	}
	else if($type == 'SLD'){
	 echo "<li><h2>$qn</h2><iframe scrolling=\"no\" id=\"frame\" src=\"http://162.13.147.58:8000/?code=$cde&slider=true\"></iframe>";
	}
	else{
	echo "<li><h2>$qn</h2><iframe scrolling=\"no\" id=\"frame\" src=\"http://162.13.147.58:8000/?code=$cde\"></iframe>";
	}
}
echo "</ul>";	

mysqli_close($db);

if($_REQUEST["tid"] != "") {
$tid = $_REQUEST["tid"];

echo "<a class=\"twitter-timeline\" href=\"https://twitter.com\" data-widget-id=\"$tid\">Tweets</a>";

}	
		 
?>

	
	

