	<title>Link Questions</title>

<link href='/css/connectQuestions.css' rel='stylesheet' type='text/css'>
<script src="/js/bootbox.min.js"></script>	

</head>	
	<?php 
		// include('../topBar.php'); 
		if(isset($_SESSION['account']) && $_SESSION['account'] != 'NULL'){
			$limit = 0;
		}else{
			$limit = 1;
		}
		
		if($createdQnType != ""){$vw = $createdQnType;}
		else {$vw = $_REQUEST['view']; }
		if($vw == ""){$vw='connect';}
	?>
		
<div class="container">
	<?php
	
	if($vw == 'liveview'){
		echo "<span id=\"codeHighlight\">Create LiveView </span>";
	}  
	else if($vw == 'quiz'){
			echo "<span id=\"codeHighlight\">Create Quiz </span>";
		}
		else if($vw == 'edit'){
				echo "<span id=\"codeHighlight\">Edit Questions </span>";
			}
	else{
			echo "<span id=\"codeHighlight\">Link Previous Questions </span>";
		}
	
	?>

	<div class="row">
		
	
	       <?php if($vw != 'edit') { ?>
	         <div id="qns" class="col-md-4"></div>
	         <div id="rcol" class="col-md-8">
	            <ul id="sortedlist" class="sortable list"></ul>
				<input type="submit" id="submitButton" onclick="showorder('<?php echo $vw; ?>')" class="btn btn-primary" >
				<?php } else {?>
					 <div id="qns" class="col-md-6"></div>
					<?php } ?>
	        </div>
	    </div>
	</div>
	<script src="/js/jquery.sortable.js"></script>
	<script src="/QM2/connect.js"></script>
	<script>
	var qnCode ="";
	jQuery( document ).ready(function() {
		
			<?php echo "var view = '$vw';"; ?>
			var dataString="&view="+view;
		            	$.ajax({
		        					type:'POST',
		        					data:dataString,
		        					url:'getLinkQns.php',
		        						success:function(res) {
												res = res.replace(/,\s*$/, "");
		  
												var allQns ="";
												var qns = res.split("|");
												qns.pop();
												allQns += '<table class="table table-striped" id="qnTable"><thead><tr><td>Question</td><td>Group</td>';
												
												allQns += '<td>Edit</td>';
												if(view == 'edit') {
												allQns += '<td>Clear Data</td><td>Delete Qn</td>';
											}
												else{allQns += '<td></td>';}
												
												allQns += '</tr></thead><tbody>';
												for(var v in qns){
													var pt = qns[v].split("~");
													// console.log(qns[v]);										
													allQns += '<tr id=\"'+pt[0]+'\"><td><a href="http://www.doyouagree.co.uk/'+pt[0]+'" target="_blank">'+pt[1]+'</a></td><td>'+pt[2]+'</td>';
												
													allQns += '<td><a href="cQn.php?edit='+pt[0]+'">Edit</a></td>'; 
													if(view == 'edit'){	
												allQns += '<td><input type="button" id="'+pt[0]+'" class="clearBtn" value="Clear"><td><input type="button" id="'+pt[0]+'" class="delBtn" value="Delete">';
											}else{
													allQns += '<td><input type="button" id="'+pt[0]+'" class="addBtn" value=">">';}
													allQns +='</tr>';
										
												}
												
												allQns += '</tbody></table>';
												$("#qns").html(allQns);
												$(".addBtn").on('click', function() {
															qnID=this.id;
															dealWithListMovement(qnID,'<?php echo $limit;?>');
													
													});
													
													$(".clearBtn").on('click', function() {
																deleteQn(this.id,'clear');
														});
													
														$(".delBtn").on('click', function() {
																	qnID=this.id;
																	deleteQn(qnID,'delete');

															});
													
		        							}				
		        				});
		
		

	});
	
	</script>
<link href='/css/andreea.css' rel='stylesheet' type='text/css'>