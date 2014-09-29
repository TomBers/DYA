<?php
include("../topBar.php");
?>
<!doctype html>
<head>
	<meta charset="utf-8">
	<title>Edit Questions</title>

</head>
<style>
b{
	margin-left:5px;
	margin-right:5px;
	font-size:14px;
}
.dblclick{
	display: inline;
}
input{
	font-size:24px;
	min-height: 50px;
	min-width:150px;
}

</style>
<body>
<div class="container">	
	<div id="users"></div>
	<div id="userQuestions"></div>
	
	<section>
		<div id="qns">
		</div>
	</section>
	<section>
		<ul id="sortedlist" class="sortable list">
			
		</ul>
	</section>
	
    <script src="/js/jeditable.js" type="text/javascript" charset="utf-8"></script>
	<script>
	
	
	$( document ).ready(function() {
		
			$.ajax({
						type:'POST',
						url:'getUsrs.php',
							success:function(res) {
							var select ='<select name="users" id="usrs" onchange="getQns(this)"><option value=""></option>';
								var usrs = res.split("|");

								for(var person in usrs){
									// console.log(person);
									var nmeId = usrs[person].split(",");				
									   select += '<option value="'+nmeId[1]+'">'+nmeId[0]+'</option>';
								}
								select += '</select>';
								// console.log(select);

									$("#users").html(select);
										}				
					});

		});
		
		function getQns(sel){
			var dataString="user="+sel.value;
			// console.dir(sel.value);
			$.ajax({
				type:'POST',
				data:dataString,
				url:'/admin/getQuestions.php',
				success:function(res) {
					// console.log(res);
					var allQns ="";
					allQns += '<table class="table table-striped"><thead><tr><td>Code</td><td>Question</td><td>Active</td><td>Question Type</td><td>Next</td><td>Qn Html</td><td>Options</td><td>Colours</td><td>Show Data</td></tr></thead><tbody>';
					rdat = JSON.parse(res);
					// console.log(rdat);
					for(var x in rdat){
						allQns += '<tr>';

						if(rdat[x]['qType'] == 'QZ'){																																			
							allQns += '<td><b class="dblclick" id="'+rdat[x]['code']+',code,QZ">'+rdat[x]['code']+'</b></td>';
						}
						else{
							allQns += '<td><b class="dblclick"  id="'+rdat[x]['code']+',code">'+rdat[x]['code']+'</b></td>';
						}

						allQns += '<td><b class="dblclick"  id="'+rdat[x]['code']+',question">'+rdat[x]['question']+'</b></td>';

						if(rdat[x]['active'] == '1'){
							allQns += '<td><b class="editable_select_binary" style="display: inline" id="'+rdat[x]['code']+',active">Yes</b>';
						}
						else {
							allQns += '<td><b class="editable_select_binary" style="display: inline" id="'+rdat[x]['code']+',active">No</b>';
						}
						allQns += '<td><b class="editable_select" style="display: inline" id="'+rdat[x]['code']+',qType">'+rdat[x]['qType']+'</b></td>';
						allQns += '<td><b class="dblclick"  id="'+rdat[x]['code']+',agreeNext">'+rdat[x]['agreeNext']+'</b></td>';
						allQns += '<td><b class="dblclick"  id="'+rdat[x]['code']+',questionHTML">'+rdat[x]['questionHTML']+'</b></td>';
						allQns += '<td><b class="dblclick"  id="'+rdat[x]['code']+',options">'+rdat[x]['options']+'</b></td>';
						allQns += '<td><b class="dblclick"  id="'+rdat[x]['code']+',colours">'+rdat[x]['colours']+'</b></td>';

						if(rdat[x]['draw'] == '1'){
							allQns += '<td><b class="editable_select_binary" style="display: inline" id="'+rdat[x]['code']+',draw">Yes</b></td></tr>';
						}
						else {
							allQns += '<td><b class="editable_select_binary" style="display: inline" id="'+rdat[x]['code']+',draw">No</b></td></tr>';
						}

					}
					allQns += '</tbody></table><br>';
					// alert(allQns);

					$("#qns").html(allQns);
					$(".dblclick").editable("/admin/saveQuestions.php", { 
						indicator : "<img src='/images/loader.gif'>",
						tooltip   : "Doubleclick to edit...",
						event     : "dblclick",
						style  : "inherit",


					});

					$(".editable_select").editable("/admin/saveQuestions.php", { 
						indicator : '<img src="/images/loader.gif">',
						data   : "{'SLD':'SLD','RDO':'RDO','CHK':'CHK','IMG':'IMG','CMMT':'CMMT','QZ':'QZ'}",
						type   : "select",
						submit : "OK",
						style  : "inherit",
					});

					$(".editable_select_binary").editable("/admin/saveQuestions.php", { 
						indicator : '<img src="/images/loader.gif">',
						data   : "{'1':'YES','0':'NO'}",
						type   : "select",
						submit : "OK",
						style  : "inherit",
					});
				}

				});

		}
	

	
	
	



	</script>
</div>
</body>
</html>
