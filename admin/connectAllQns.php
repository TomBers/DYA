<?php
include("../topBar.php");
?>

<!doctype html>
<head>
	<meta charset="utf-8">
	<title>Link Questions</title>
	<style>
	
	
	#cntner{
		width:100%;
		display:inline-block;
	}
	#leftCol{
	float:left;	
	display:inline;
	width:30%;
	}
	#rightCol{
		width:70%;
		float:right;
		display:inline;
	}
	
	#qns{	
	}
	#sortedlist{
	overflow: auto;
	}
	
	/*	#features {
				margin: auto;
				width: 460px;
				font-size: 0.9em;
			}*/
		.connected, .sortable, .exclude, .handles {
			margin: auto;
			padding: 0;
			width: 410px;
			-webkit-touch-callout: none;
			-webkit-user-select: none;
			-khtml-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}
		.sortable.grid {
			overflow: hidden;
		}
		.connected li, .sortable li, .exclude li, .handles li {
			list-style: none;
			border: 1px solid #CCC;
			background: #F6F6F6;
			font-family: "Tahoma";
			color: #1C94C4;
			margin: 5px;
			padding: 5px;
		}
		.handles span {
			cursor: move;
		}
		li.disabled {
			opacity: 0.5;
		}
		.orderQnList{
			border:1px solid red;
			overflow: auto;
		}
			.remove{
				
				display:inline;
				float:right;
				color:red;
			}
		
		.sortable.grid li {
			line-height: 80px;
			float: left;
			width: 80px;
			height: 80px;
			text-align: center;
		}
		li.highlight {
			background: #FEE25F;
		}
		ul.sortable.list li {
		    line-height: 14px;
		}
		#connected {
			width: 440px;
			overflow: hidden;
			margin: auto;
		}
		.connected {
			float: left;
			width: 400px;
		}
		.connected.no2 {
			float: right;
		}
		li.sortable-placeholder {
			border: 1px dashed #CCC;
			background: none;
		}
	
		#codeHighlight{
			font-size:22px;
			display:block;
		}
		#rightButton{
			float:right;
		}
	</style>

</head>	

<div class="container">
	<div id="users"></div>
	
	<?php
	if($_REQUEST['view'] == 'connect'){
		echo "<span id=\"codeHighlight\">Create Questions </span>";
	}
	else if($_REQUEST['view'] == 'dashboard'){
		echo "<span id=\"codeHighlight\">Create Dashboard </span>";
	}  
	else if($_REQUEST['view'] == 'quiz'){
			echo "<span id=\"codeHighlight\">Create Quiz </span>";
		}
	?>

		<div id="leftCol">
			<div id="qns"></div>
		</div>
		<div id="rightCol">
			<ul id="sortedlist" class="sortable list"></ul>
		</div>
		<input type="submit" id="rightButton" onclick="showorder()">
	</div>
</div>

	<script src="/js/jquery.sortable.js"></script>
	<script>
	var qnCode ="";
	$( document ).ready(function() {
		
		console.log('ready');
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
			
				<?php $vw = $_REQUEST['view']; echo "var view = '$vw';"; ?>
				
				var dataString="&view="+view;
				dataString +='&user='+sel.value;
				console.log(dataString);
			            	$.ajax({
			        					type:'POST',
			        					data:dataString,
			        					url:'usrLinkQns.php',
			        						success:function(res) {
													res = res.replace(/,\s*$/, "");
			  
													var allQns ="";
													var qns = res.split("|");
													qns.pop();
													allQns += '<table class="table table-striped" id="qnTable"><thead><tr><td>Code</td><td>Question</td><td>Group</td>';
													allQns += '<td>Edit</td>';
													allQns += '<td>Order</td></tr></thead><tbody>';
													for(var v in qns){
														var pt = qns[v].split("~");
														// console.log(qns[v]);										
														allQns += '<tr id=\"'+pt[0]+'\"><td>'+pt[0]+'</td><td>'+pt[1]+'</td><td>'+pt[2]+'</td>';
														allQns += '<td><a href="setSessionforQn.php?code='+pt[0]+'">Edit</a></td>'; 
														allQns += '<td><input type="button" id="'+pt[0]+'" class="addBtn" value=">"></tr>';
											
													}
													
													allQns += '</tbody></table>';
													$("#qns").html(allQns);
													$(".addBtn").click(function() {
														    // alert( this.id );
																qnID=this.id;
																dealWithListMovement(qnID);
														
														});
														
														
			        							}				
			        				});
			
			
	
		
		$('.sortable').sortable().bind('sortupdate', function() {
		    getFirstItem();
		});
	}
	
	function dealWithListMovement(qnID){
				code=$("#"+qnID+" td").first().text();
				
				qn = $("#"+qnID+" td:nth-child(2)").text();
				
				gp = $("#"+qnID+" td:nth-child(3)").text();
			
				
				var listAdd='<li class="orderQnList" id="'+qnID+'"><span class="code">'+code+'</span> <span class="qn">'+qn+'</span> <span class="group">'+gp+'</span><div class="remove" id='+code+'>X</div></li>'; 
				$('#sortedlist').append(listAdd);

				$('tr#'+qnID).remove();

		    

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
				getFirstItem();
				
				$('.remove').unbind('click').click(function(){
					console.log( "clicked on", jQuery(this), "which has id", jQuery(this).attr('id') );
					code = $(this).parent().find('.code').text();
					qn= $(this).parent().find('.qn').text();
					gp = $(this).parent().find('.group').text();
					$(this).parent().remove();
					
					var bakToList ='<tr id=\"'+code+'\"><td>'+code+'</td><td>'+qn+'</td><td>'+gp+'</td><td><a href="setSessionforQn.php?code='+code+'">Edit</a></td><td><input type="button" id="'+code+'" class="addBtn" value=">"></tr>';
					$('#qnTable tr:last').after(bakToList);
					$(".addBtn").unbind('click').click(function() {
						    // alert( this.id );
								qnID=this.id;
								dealWithListMovement(qnID);
						
						});
					
					
				});
		
	}
	
	
    
		function getFirstItem(){
			// $("#"+qnID+" td").first().text()
		var cde= $("ul#sortedlist li .code").first().text(); //.slice(0, -1);
		$(".pollTitle").text(cde);
		qnCode = cde; 
			
		}
        function showorder()
        {
			var r=confirm("Are you sure you want to change the order of these questions?");
			if (r==true)
			  {
			var optionTexts = [];
			<?php 
				if($_REQUEST['view'] == 'connect'){
					echo "optionTexts.push('connect');";
				}
				else if($_REQUEST['view'] == 'dashboard'){
					echo "optionTexts.push('dashboard');";
				}
				else if($_REQUEST['view'] == 'quiz'){
					echo "optionTexts.push('quiz');";
				}
			?>
			
			$("ul#sortedlist li .code").each(function() { optionTexts.push($(this).text()) });
            var view = optionTexts[0]; 
			var dataString =JSON.stringify(optionTexts);
			// alert(dataString);
			$.ajax({
									    type:'POST',
									    data:{data : dataString},
									    url:'/QM/setOrder.php',
									    success:function(res) {
										//alert(res)
										// alert(qnCode);
										window.location.href = 'promote.php?code='+qnCode+'&view='+view;
										}
									});
				}
				

        }
			$(function() {
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
			});
	</script>

</body>
</html>
