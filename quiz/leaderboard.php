<?php

include('../topBar.php');

?>
<style>

.userImage img{
	max-width:50px;
	max-height:50px;
	display:inline-block;
	margin-right:20px;
	margin-bottom:5px;
	
}
.userImage{
	display:inline-block;
	width:40%;
}

#leaderBoardDiv{
	width:100%;
	margin-bottom:10px;
	border-bottom:1px solid #2C5D70;
	text-align:center;
	font-size:16px;
}

#commentUser{display:inline;}

#leaderHeader{
	font-size:22px;
	width:100%;
	text-align:center;
	border-bottom:3px solid #2C5D70;
	margin-bottom:20px;

}
#rank,#commentRank{
	float: left; width: 10%;
		
}
#noPlayers,#commentUser{
	text-align:center;
	width:40%;
	margin: 0 auto;
	display: inline-block; 
}
#commentRank{
margin-top: 15px;
}

#commentUser h3 {
	display:inline;	
	font-size:16px;
	
}

#score,#commentTxt{
	float: right; width: 10%;

}
#commentTxt{
		margin-top: 15px;
}
img{
	max-height:75px;
	max-width:75px;
}

</style>
<script>

$( document ).ready(function() {getLeaderboard('<?php $qz=$_GET['quiz']; echo $qz;?>') });

var myVar=setInterval(function(){getLeaderboard('<?php $qz=$_GET['quiz']; echo $qz;?>')},15000);



function getLeaderboard(quiz){

  // console.log(quiz);
	var dataString="quiz="+quiz;
		$.ajax({
				    type:'POST',
				    data:dataString,
				    url:'/quiz/getLeaderboardData.php',
				    success:function(res) {
					
					var jsn = $.parseJSON(res);
	if(jsn.length > 1){
	var tble = '<div id=\"noPlayers\">'+jsn.length+' players</div>';
}
else{
	var tble = '<div id=\"noPlayers\">'+jsn.length+' player</div>';
}
	tble +='<table class="table table-striped"id="qnTable"><thead><tr><td>Rank</td><td></td><td>Name</td><td>Score</td></tr></thead><tbody>';
					
					
					// var tble = '<div id=\"leaderHeader\"><div id=\"rank\">Rank</div>'; 
					// tble += '<div id=\"noPlayers\">'+jsn.length+' players</div><div id=\"score\">Score</div></div>';
					
						jsn.forEach(function(rslt) {
							
							var name = rslt.firstname+' '+rslt.lastname;
							if(name == ""){name = 'Not Given';}
							// console.log(rslt);
							tble += '<tr><td>'+rslt.rank+'</td>';
							tble += '<td><img src=\"'+rslt.imgURL+'\"></td><td><h3>'+name+'</h3></td>';
							tble += '<td>'+rslt.score+'</td></tr>';
						});
						tble += '</tbody></table>';
						
					
					$('#leaderBoardDiv').html(tble);
					}
				});
			
		}
</script>

<div class='container'>
<div id="leaderBoardDiv"></div>
</div>