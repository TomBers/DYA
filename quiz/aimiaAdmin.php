<?php

include('../topBar.php');

?>
<link href="/css/bootstrap-switch.min.css" rel="stylesheet">
<script src="/js/bootstrap-switch.min.js"></script>
<script>
$( document ).ready(function() { 

// Load each question into the page
	var user = 'quiz=AimiaQuiz';
	$.ajax({
			    type:'POST',
			    data:user,
			    url:'/quiz/getUserQns.php',
			    success:function(res) {
					
					console.log(res);
					var jsn = $.parseJSON(res);
																					// console.log(jsn);
																					
							for(var x in jsn){
								var chkBx = '<div id="outline">';
								chkBx += '<div id="lab">'+jsn[x].question+'</div>';
								chkBx += '<label id="sliderLabel">';
								chkBx += '<input type="checkbox" id="'+jsn[x].code+'"/>';
								chkBx += '<span id="slider"><span id="sliderOn">ON</span><span id="sliderOff">OFF</span><span id="sliderBlock"></span></span></label></div>';
								$('#chBoxes').append(chkBx);
											}

					$(":checkbox").each(function() { 
																var dataString="code="+this.id+"&checked=false";
																	$.ajax({
																			    type:'POST',
																			    data:dataString,
																			    url:'/quiz/changeQuizState.php',
																			    success:function(res) {
																				}
																			});
															});

					$(":checkbox").change(function() {   
													// alert(this.checked);
							var dataString="code="+this.id+"&checked="+this.checked;
								$.ajax({
										    type:'POST',
										    data:dataString,
										    url:'/quiz/changeQuizState.php',
										    success:function(res) {
											// alert('bob');
		
											}
										});
						});
			
				}
			});
});
</script>
<style>

p {
  
}
#outline{
	display:block;
	overflow:auto;
}
#sliderLabel {
    border: 1px solid #a2a2a2;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;    
    border-radius: 3px;
    cursor: pointer;
    display: block;
    height: 30px;
    margin: 0 auto;
    overflow: hidden;
    position: relative;
    width: 100px;
}
#sliderLabel input {
    display: none;
}
#sliderLabel input:checked + #slider {
    left: 0px;
}
#slider {
    left: -50px;
    position: absolute;
    top: 0px;
    -moz-transition: left .25s ease-out;
    -webkit-transition: left .25s ease-out;
    -o-transition: left .25s ease-out;
    transition: left .25s ease-out;
}
#sliderOn, #sliderBlock, #sliderOff,#label {
    display: block;
    font-family: arial, verdana, sans-serif;
    font-weight: bold;
    height: 30px;
    line-height: 30px;
    position: absolute;
    text-align: center;
    top: 0px;
}
#sliderOn {
    background: #3269aa;
    background: -moz-linear-gradient(top,  #3269aa 0%, #82b3f4 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#3269aa), color-stop(100%,#82b3f4));
    background: -webkit-linear-gradient(top,  #3269aa 0%,#82b3f4 100%);
    background: -o-linear-gradient(top,  #3269aa 0%,#82b3f4 100%);
    background: -ms-linear-gradient(top,  #3269aa 0%,#82b3f4 100%);
    background: linear-gradient(top,  #3269aa 0%,#82b3f4 100%);
    color: white;
    left: 0px;
    width: 54px;
}
#sliderBlock {
    background: #d9d9d8;
    background: -moz-linear-gradient(top,  #d9d9d8 0%, #fcfcfc 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#d9d9d8), color-stop(100%,#fcfcfc));
    background: -webkit-linear-gradient(top,  #d9d9d8 0%,#fcfcfc 100%);
    background: -o-linear-gradient(top,  #d9d9d8 0%,#fcfcfc 100%);
    background: -ms-linear-gradient(top,  #d9d9d8 0%,#fcfcfc 100%);
    background: linear-gradient(top,  #d9d9d8 0%,#fcfcfc 100%);
    border: 1px solid #a2a2a2;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    border-radisu: 3px;
    height: 28px;
    left: 50px;
    width: 50px;
}
#sliderOff {
    background: #f2f3f2;
    background: -moz-linear-gradient(top,  #8b8c8b 0%, #f2f3f2 50%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#8b8c8b), color-stop(50%,#f2f3f2));
    background: -webkit-linear-gradient(top,  #8b8c8b 0%,#f2f3f2 50%);
    background: -o-linear-gradient(top,  #8b8c8b 0%,#f2f3f2 50%);
    background: -ms-linear-gradient(top,  #8b8c8b 0%,#f2f3f2 50%);
    background: linear-gradient(top,  #8b8c8b 0%,#f2f3f2 50%);
    color: #8b8b8b;
    left: 96px;
    width: 54px;
}

#label{
	background: #f2f3f2;
    background: -moz-linear-gradient(top,  #8b8c8b 0%, #f2f3f2 50%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#8b8c8b), color-stop(50%,#f2f3f2));
    background: -webkit-linear-gradient(top,  #8b8c8b 0%,#f2f3f2 50%);
    background: -o-linear-gradient(top,  #8b8c8b 0%,#f2f3f2 50%);
    background: -ms-linear-gradient(top,  #8b8c8b 0%,#f2f3f2 50%);
    background: linear-gradient(top,  #8b8c8b 0%,#f2f3f2 50%);
    color: #8b8b8b;
    left: 96px;
    width: 54px;
}

#lab{
	
   
    float:left;
    font-size:22px;
    width:700px;
}
#outline{
	padding-bottom:15px;
	padding-top:15px;
	border-bottom:1px solid #3269aa;
	
}

</style>

<div id="wrapper" class="container">
<h1>Quiz Admin</h1><br>

<div id="chBoxes"></div>

</div>