

function dealWithListMovement(qnID){
			// code=$("#"+qnID).id;
			
			qn = $("#"+qnID+" td:nth-child(1)").text();
			
			gp = $("#"+qnID+" td:nth-child(2)").text();
		
			
			var listAdd='<li id="'+qnID+'"><span class="qn">'+qn+'</span> <span class="group">'+gp+'</span><div class="remove" id='+qnID+'>X</div></li>'; 
			
		
			$('#sortedlist').append(listAdd);
			$('tr#'+qnID).remove();
			// console.log($('#sortedlist li').length);
			

	    

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
					
					
					$('.remove').unbind('click').click(function(){
													
														code = $(this).attr('id');    
														qn= $(this).parent().find('.qn').text();
														gp = $(this).parent().find('.group').text();
														$(this).parent().remove();
														
														var bakToList ='<tr id=\"'+code+'\"><td>'+qn+'</td><td>'+gp+'</td><td><a href="cQn.php?edit='+code+'">Edit</a></td><td><input type="button" id="'+code+'" class="addBtn" value=">"></tr>';
														$('#qnTable tr:last').after(bakToList);
														
														
														$(".addBtn").unbind('click').click(function() {
																	qnID=this.id;
																	dealWithListMovement(qnID,limit);
															
															});
														
														
													});
	
}


function deleteQn(qnID,opt){
	
	console.log('bob');
	console.log(opt);
		var r=confirm("This will delete your question and all responses - are you sure?");
		if (r==true)
		  {	
	
	
// if(opt == 'delete'){$('tr#'+qnID).remove();}


$.ajax({
						    type:'POST',
						    data:{code : qnID, funcOpt : opt},
						    url:'/QM2/delQn.php',
						    success:function(res) {
							 // alert(res);
							 // console.log(res);
							}
						});

}

}

    function showorder(view)
    {
			var optionTexts = [];
			optionTexts.push(view);

			$("ul#sortedlist li").each(function() { 
				// alert($(this).attr('id'));
				optionTexts.push($(this).attr('id')) 
				});
				
		if(optionTexts.length > 1){		
	
		var r=confirm("Are you sure you want to change the order of these questions?");
		if (r==true)
		  {
	
        var view = optionTexts[0];
		var qnCode = optionTexts[1];
		var dataString =JSON.stringify(optionTexts);
		// alert(dataString);
		
				
		$.ajax({
								    type:'POST',
								    data:{data : dataString},
								    url:'setOrder.php',
								    success:function(res) {
									//alert(res)
									// alert(qnCode);
									window.location.href = 'promote.php?code='+qnCode+'&view='+view;
									}
								});
			}
		} else{
			alert('You have not selected any questions to add to the survey');
		}

    }