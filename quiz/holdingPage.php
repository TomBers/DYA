<?php

include('../topBar.php');

?>
<script>

$( document ).ready(function() {getQuizState('<?php $qz=$_GET['quiz']; echo $qz;?>') });

var myVar=setInterval(function(){getQuizState('<?php $qz=$_GET['quiz']; echo $qz;?>')},5000);



function getQuizState(quiz){
// alert(quiz);
  console.log(quiz);
  	var dataString="quiz="+quiz;
    		$.ajax({
    				    type:'POST',
    				    data:dataString,
    				    url:'/quiz/getQuizState.php',
    				    success:function(res) {
    					// alert(res);
    					if(res == 1){
							$('input[type="submit"]').removeAttr('disabled');
						}
						else{$('input[type="submit"]').attr('disabled', 'true'); }
    					}
    				});
  // 			
  		}
</script>
<div id="wrapper" class="container">
<h1><?php echo $_GET['section']; ?></h1>
<p>Click next to go to the next section. If the button is not enabled, the host hast not yet enabled the next section - you will be instructed when it is ready.</p><br>
<form id="fileupload" action="http://www.doyouagree.co.uk/<?php echo $_GET['quiz']; ?>" method="POST" enctype="multipart/form-data">
	<input id="button" disabled class="btn btn-lg btn-primary btn-block" type="submit" value="Next" />
   
</form>

</div>