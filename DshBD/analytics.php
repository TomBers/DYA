<!DOCTYPE html>
<html>
<body>
<?php 
include('../topBar.php');
include('analytics_openingSection.php');
include('showCommnents.php');


?>
<script src="/js/Chart.js"></script>
<script src="/UX/dya.js"></script>
<script src="/js/jqueryui.js"></script>
<script src="/js/bootbox.min.js"></script>	

<link href='/css/dashboard.css' rel='stylesheet' type='text/css'>

<script>

$( document ).ready(function() {

	$.ajax({
		type:'POST',				
		url:'/DshBD/getQnsJSON.php',
		success:function(res) {
			// console.log(res);
			var json = $.parseJSON(res);
			// console.log(json);

			var groups = Array();
			json.forEach(function(obj) { 
				// console.log(obj);

				if(obj.group == ""){obj.group = "Ungrouped";}
				// if we have seen the group before - append to that, else append a new div with element title


				if(groups.indexOf(obj.group) == -1){
					if(obj.group != "Ungrouped"){								
						$("#accordion").append('<h3>'+obj.group+'  <span class="admin" id="'+obj.group+'_"><small>admin</small></span></h3><div id="'+obj.group+'"></div>');}
						else{
							$("#accordion").append('<h3>'+obj.group+'</h3><div id="'+obj.group+'"></div>');
						}
					}
					groups.push(obj.group);



					if(obj.qType == "CMMT"){
						var link = '<a href="" onclick="loadComments(\''+obj.code+'\');return false;">'+obj.question+'</a><br>';
					}
					else {
						var link = '<a href="" onclick="loadResult(\''+obj.code+'\');return false;">'+obj.question+'</a><br>';
					}

					$("#"+obj.group).append(link);
					$("#accordion").accordion("refresh");


				});


			}

		});

		$( "#accordion" ).accordion({
			heightStyle: "content"
		});
		$("#accordion").accordion("refresh");

		$(document).on('click','.admin',function(e){
			qn = $(this).attr("id").substring(0,$(this).attr("id").length -1);
			loadAdmin(qn);
			
			
			// renameSurvey(qn,'<?php echo $_SESSION['account']; ?>');
		});



	});

	function loadAdmin(cde){
		
		$.ajax({
			type:'POST',
			data:{code : cde},
			url:'/DshBD/surveySettings.php',
			success:function(res) {
				  // alert(res);
				
				
				
				
				
					var json = $.parseJSON(res);
					
					var admin = '<form id="myForm" name="input" action="/DshBD/saveSettings.php" method="POST">';
					
						admin += '<label>Survey Name : <input type="text" id="SurveyName" name="SurveyName" value="'+json[0].group+'"></label><br>';
						admin += '<input type="hidden" name="oldcode" id="oldcode" value="'+cde+'"/><br>';
					if(json[0].active == 1){
				 		admin += '<label><input type="checkbox" name="live" checked /> Survey Live</label><br>';
				}else{
					admin += '<label><input type="checkbox" name="live"/> Survey Live</label><br>';
				}
				
					var lginSts = $.parseJSON(json[0].login);
				
					if(lginSts.force == 1){ admin += '<label><input type="checkbox" name="login" checked /> Force Login</label><br><br>';
					}else{ admin += '<label><input type="checkbox" name="login" /> Force Login</label><br><br>';}
					
					if(lginSts.fb == 1){admin += '<label><input type="checkbox" name="fb" checked/> Facebook Login</label><br>';
					}else{ admin += '<label><input type="checkbox" name="fb"/> Facebook Login</label><br>';}
					
					if(lginSts.twitter == 1){ 	admin += '<label><input type="checkbox" name="twitter" checked/> Twitter Login</label><br>';
					}else{ 	admin += '<label><input type="checkbox" name="twitter"/> Twitter Login</label><br>';}
					
					if(lginSts.google == 1){ admin += '<label><input type="checkbox" name="google" checked/> Google Login</label><br>';
					}else{ admin += '<label><input type="checkbox" name="google"/> Google Login</label><br>';}
					
					if(lginSts.linkedin == 1){ admin += '<label><input type="checkbox" name="linkedin" checked/> LinkedIn Login</label><br>';
					}else{ admin += '<label><input type="checkbox" name="linkedin"/> LinkedIn Login</label><br>';}
					    
						
					
						
						
						
						if(json[0].draw == 1){
						admin += '<br><br><label><input type="checkbox" name="draw" checked/> Draw Graphs</label><br>';
					}else {
						admin += '<br><br><label><input type="checkbox" name="draw"/> Draw Graphs</label><br>';
					}
						admin += '<label>Redirect URL : <input type="text" name="redirect" value="'+json[0].agreeNext+'"></label><br><br><input type="button" id="changeSettings" value="Update"></form>';

					$('#drawArea').html(admin);
					
					$('#changeSettings').click(function() {
						var ncde = $('#SurveyName').val();
						
						$.ajax({
							type:'POST',
							data:{newcode : ncde},
							url:'/DshBD/checkFree.php',
							success:function(res) {
								if( $('#oldcode').val() == $('#SurveyName').val() ){$('#myForm').submit();}
								else if( res == 1){ $('#myForm').submit();}
								else {
									alert('Survey Name Taken, please choose another one.');
									}
							}});
						
						
					});
					
					
					  
						
					
					
				
				
			}
		});
		
		
		
	
		// Get current 'STATE' 
		
	}
	
	function loadQnControls(cde){
		
		var btns = '';
		<?php if(isset($_SESSION['DYA_id'])){ ?>
			btns += '<button type="button" onclick="editQn(\''+cde+'\')" class="btn btn-lg btn-primary">Edit</button>';
			btns += '<button type="button" onclick="viewQn(\''+cde+'\')" class="btn btn-lg btn-success">View</button>';
			btns += '<button type="button" onclick="promoteQn(\''+cde+'\',\'delete\')" class="btn btn-lg btn-success">Share</button>';
			btns += '<button type="button" onclick="deleteQn(\''+cde+'\',\'clear\')" class="btn btn-lg btn-warning">Clear Data</button>';
			btns += '<button type="button" onclick="deleteQn(\''+cde+'\',\'delete\')" class="btn btn-lg btn-danger">Delete</button>';
		
		<?php }else { ?>
			btns += '<button type="button" class="btn btn-lg btn-primary">Edit</button>';
			btns += '<button type="button" onclick="viewQn(\''+cde+'\')" class="btn btn-lg btn-success">View</button>';
			btns += '<button type="button" onclick="promoteQn(\''+cde+'\',\'delete\')" class="btn btn-lg btn-success">Share</button>';
			btns += '<button type="button" class="btn btn-lg btn-warning">Clear Data</button>';
			btns += '<button type="button" class="btn btn-lg btn-danger">Delete</button>';
			
	
		<?php } ?>

		// console.log(btns);	
		$('#drawArea').prepend(btns);

	}
	
	function renameSurvey(qn,account){
		
		// console.log(account);
			var nc = prompt("Please enter new name", qn);
			
			
			$.ajax({
				type:'POST',
				data:{oldcode : qn,newcode: nc},
				url:'/DshBD/renameQn.php',
				success:function(res) {
					// alert(res);
					// console.log(res);
					if(res == 0){
						alert('Name Already taken');
					}else{
						location.reload(true);
					}
				}
			});
	
	}

	function editQn(cd){
		window.location.href = '/edit/'+cd;
	}
	function promoteQn(cd){
		window.location.href = '/QM2/promote.php?view=connect&code='+cd;
	}
	function viewQn(cd){
		// window.location.href = '/'+cd;
		window.open('/'+cd, '_blank');
	}

	function deleteQn(qnID,opt){

		// console.log('bob');
		var msg ='';

		if(opt == 'clear'){msg += 'This will clear all responses - are you sure?';}
		else {msg += 'This will delete your question - are you sure?';}

		console.log(opt);
		var r=confirm(msg);
		if (r==true)
		{	


			// if(opt == 'delete'){$('tr#'+qnID).remove();}


			$.ajax({
				type:'POST',
				data:{code : qnID, funcOpt : opt},
				url:'/DshBD/clearOrDelQn.php',
				success:function(res) {
					// alert(res);
					// console.log(res);
					location.reload(true);
				}
			});

		}

	}

	function loadComments(code){
		// console.log(code);


		var codeString = "code="+code; 

		$.ajax({
			type:'POST',
			data:codeString,
			url:'/DshBD/showComments.php',
			success:function(res) {
				$("#drawArea").html(res);
				loadQnControls(code);
				$('#drawArea').append('<div id="downloadData"><a href="exportUserData.php" target="_blank">Download Data</a></div>');
			}
		});


	}

	function loadResult(code){

		var codeString = "qn="+code;

		$.ajax({
			type:'POST',
			data:codeString,
			// url:'/UX/storeAndReturn.php',
			url:'/DshBD/getQnData.php',
			success:function(res) {
				// console.log(res);
				var json = $.parseJSON(res);
				if(json[0]['COUNT(*)'] > 0){
					// Is there a response?  get response count
					drawOptions(res,'drawArea','1');
					$('#drawArea .btn').remove();
					
						<?php if(isset($_SESSION['account']) && $_SESSION['account'] != 'NULL'){ ?>
					$('#drawArea').append('<div id="downloadData"><a href="exportUserData.php" target="_blank">Download Data</a></div>');
					
					<?php } ?>

				}else{
					$('#drawArea').html('<h1>There is no response to this question yet.</h1>')
				}



				loadQnControls(code);
			}
		});
	}
	</script>


	<div class="container">
		<div class="row">
			<div id="accordion" class="col-sm-5" >

			</div>
			<div id="drawArea" class="col-sm-6" >This is where your results with be show - click a question to see the results.</div>
		</div>
	</div>


	<link href='/css/andreea.css' rel='stylesheet' type='text/css'>
</body>
</html>