<?php
include('showCommnents.php');
?>
<link rel="stylesheet" href="/UI/CBStyle.css"/>
<script src="/js/Chart.js"></script>
<style>
#questions {
 width:20%;
}

#resultBox{
	display:inline-block;
	float:right;
	width:80%;
	
}
#pastQuestions{
	display:inline-block;
	float:left;
}
#questions ul li {
    font-size: 15px;
	list-style-type: none;
}
#questions ul li:hover {
    color:blue;
	cursor: pointer	;
}

#commentsContainer{
	width:90%;
	margin: 0 auto;
}
#commentsCount{

	border-bottom:solid 3px #2C5D70;
	margin-bottom:10px;
}
#comment img {
	max-width:50px;
	max-height:50px;
	display:inline-block;
	
}
#comment{
	margin-bottom:10px;
}
#commentName{
	display:inline;
	margin-left:10px;
	font-weight:bold;
}
#commentUser{display:inline;}
#commentTxt{
	display:block;
	margin-left:60px;
}
	@media screen and (min-width: 501px){
		#canvas-container h3 {
		    margin-left:10%;
		}
		
			
			.chart-legend ul {
			    list-style: none;
			    width: 100%;
			    margin: 20px auto 0;
			}
			
			.chart-legend li {
			    text-indent: 46px;
			    line-height: 36px;
			    position: relative;
			    font-weight: 200;
			    display: inline-block;
			    float: left;
			    font-size: 1.2em;
			}
			.chart-legend  li:before {
			    display: block;
			    width: 20px;
			    height: 26px;
			    position: absolute;
			    left: 0;
			    top: 10px;
			    content: "";
			}
	}

</style>

<script>

$( document ).ready(function() {

	var dataString="type=questions";
	$.ajax({
			    type:'POST',
			    data:dataString,
			    url:'getQandA.php',
			    success:function(res) {
				// alert(res);
					// alert("questions");
					var result = res.split("|");
					var cntnt ="<div id=\"questions\"> <ul>";
					
					result.forEach(function(entry) {
						var pts = entry.split(",");
						if(typeof pts[0] === "undefined" || typeof pts[1] === "undefined"){}
						else {
							// alert(pts[2]);
							// cntnt += "<li onclick=\"loadResult(\""+pts[0]+"\")\">"+pts[1]+"</li>";
							typ = pts[2];
							if(typ == 'EMAIL'){
								
							}
							else if(typ == 'CMMT'){
								cntnt += "<li onclick=\"loadComments(\'"+pts[0]+"\')\">"+pts[0]+"</li>";
							}
							else{
							cntnt += "<li onclick=\"loadResult(\'"+pts[0]+"\')\">"+pts[0]+"</li>";
						}
							}
						});
						cntnt += "</ul></div><br><br><a href=\"exportUserData.php\" target=\"_blank\">Download Data</a>";
					$( "#pastQuestions" ).html( cntnt );	
					}
				
});
 
});


	function loadComments(code){
		var codeString = "code="+code; 
		// alert(codeString);
		$.ajax({
									    type:'POST',
									    data:codeString,
									    url:'showComments.php',
									    success:function(res) {
										// alert('success');
										// alert(res);
										$("#drawArea").html(res);
										}
				});
		
			
	}
	
	function loadResult(code){
		
		var codeString = "code="+code;
		 // alert(codeString);
		$.ajax({
							    type:'POST',
								dataType: 'json',
							    data:codeString,
							    url:'getDataForCode.php',
							    success:function(res) {
								// alert( JSON.stringify(res) );
								var result = eval(res);
								
								var primaryCol;
								var secondaryCol;
								if(result['primaryColour'] && result['secondaryColour']){
									primaryCol = result['primaryColour'];
									secondaryCol = result['secondaryColour'];
								}
								else{
									primaryCol = "#C944F8";
									secondaryCol = "#1D6DF1";
								}
								
								var nextQn = result['agreeNext'].toString();
								// var drawCanvas = "<div id=\"canvas-container\"><h3>"+result['question']+"</h3><canvas id=\"myChart\" width=\"350\" height=\"350\"></canvas><div id=\"key\"></div></div>";				
							var drawCanvas = "<div id=\"canvas-container\"><h3>"+result['question']+"</h3><canvas id=\"myChart\" width=\"325\" height=\"215\"></canvas><div id=\"key\"></div></div>";
							
								$("#drawArea").html(drawCanvas);

								var ctx = document.getElementById("myChart").getContext("2d");
																																					
								
								
								if(result['option1'] == "" ){
										var agree=Math.round(parseFloat( result['AVG(responses.rating)'] ) *100);
										// alert(agree);																																							
										var disagree = 100-agree;
										var responses = parseInt( result['COUNT(responses.eventCode)']);

										var data = [
										{
										value : agree,
										color : primaryCol
										},
										{
										value: disagree,
										color: secondaryCol
										}

										];
										
										new Chart(ctx).Doughnut(data);
										// var kcol = "<div class=\"chart-legend\"><ul><li class=\"agreeLabel\" style=\"background-color: "+primaryCol+"; \">Agree</li><li class=\"disagreeLabel\" style=\"background-color: "+secondaryCol+"; \">Disagree</li></ul></div><br>No of Responses : "+ result['COUNT(responses.eventCode)'];

											// $( "#key" ).html(kcol);
										
										$( "#key" ).html("No of Responses : "+ result['COUNT(responses.eventCode)']);
								}
								else{
									var cols = new Array();
									
									var labels = new Array();
									var values = new Array();
									
									
									if(result['option1'] != ""){
										labels.push(result['option1']);
										values.push(parseInt(result['SUM(responses.option1)']));											
										cols.push("#6F76DC");
										}
										else {
										labels.push("");
										values.push(0);
										col.push("#6F76DC")	
										}
										if(result['option2'] != ""){
											labels.push(result['option2']);
											values.push(parseInt(result['SUM(responses.option2)']));
											cols.push("#2c9c69");
											}
											else {
											labels.push("");
											values.push(0);
											cols.push("#6F76DC")	
											}
											if(result['option3'] != ""){
												labels.push(result['option3']);
												values.push(parseInt(result['SUM(responses.option3)']));
												cols.push("#dbba34");
												}
												else {
												labels.push("");
												values.push(0);
												cols.push("#6F76DC")	
												}
												if(result['option4'] != ""){
													labels.push(result['option4']);
													values.push(parseInt(result['SUM(responses.option4)']));
													cols.push("#c62f29");
													}
													else {
													labels.push("");
													values.push(0);
													cols.push("#6F76DC")	
													}
													if(result['option5'] != ""){
														labels.push(result['option5']);
														values.push(parseInt(result['SUM(responses.option5)']));
														cols.push("#637b85");
														}
														else {
														labels.push("");
														values.push(0);
														cols.push("#6F76DC")	
														}
														
														// var total = parseInt(values[0]) + parseInt(values[1]);
														// alert(total);
															var data = [
															{
																value: values[0],
																color: cols[0]
															},
															{
																value: values[1],																																													
																color: cols[1]
															},
															{
																value: values[2],																																													
																color: cols[2]
															},
															{
																value: values[3],																																													
																color: cols[3]
															},
															{
																value: values[4],																																													
																color: cols[4]
															},
																																													
																															
															];

															new Chart(ctx).Pie(data);
		
							var kcol = "<div class=\"chart-legend\"><ul><li class=\"label1\">"+labels[0]+"</li><li class=\"label2\">"+labels[1]+"</li><li class=\"label3\">"+labels[2]+"</li><li class=\"label4\">"+labels[3]+"</li><li class=\"label5\">"+labels[4]+"</li></ul></div><br>No of Responses : "+ result['COUNT(responses.eventCode)'];
								
									$( "#key" ).html(kcol);
								       
								   
								}
												
							
							    
							}
							  });
	}
</script>

<div id="pastQuestions"></div>
<div id="resultBox"><div id="drawArea">This is where your results with be show - click a question to see the results.</div><div id="key"></div></div>