 var lon = 0;
 var lat = 0;	
var isProcessing = false;
	

 function detectUserLocation() {
    if(navigator.geolocation) {
      var timeoutVal = 10 * 1000 * 1000;

      navigator.geolocation.watchPosition(
        mapToPosition, 
        alertError,
        { enableHighAccuracy: true, timeout: timeoutVal, maximumAge: 0 }
      );
    } else {
      alert("Geolocation is not supported by this browser");
    }
    
    function alertError(error) {
      var errors = { 
        1: 'Permission denied',
        2: 'Position unavailable',
        3: 'Request timeout'
      };

      alert("Error: " + errors[error.code]);
    }
  }

	function mapToPosition(position){
      lon = position.coords.longitude;
      lat = position.coords.latitude;
      // alert(lat);
    }



function setOption(opt,pge,drawTodiv){
	
	cOpt = opt;
	var $radios = $('input:radio[name=radio]');
	$radios.filter('[value='+cOpt+']').prop('checked', true);
	// console.log('setOption ' + opt + ' ' + pge + ' ' + drawTodiv);
	
    validateForm(pge,'PIC',drawTodiv);
}



function startFeedback(pg,getGPS){
 
	if(getGPS === undefined){ getGPS  = false;}
	if(getGPS){detectUserLocation();}

	// return pg;
	var lastQn = getCookie('usrLstQn');
	var currentQz = getCookie('currentQz');

		
		if(currentQz == pg && lastQn != pg && lastQn.indexOf("http") == -1){
			return lastQn;
		}else {
			setCookie('usrLstQn',pg);
			setCookie('currentQz',pg);
			return pg;
		}	
}



function getCookie(cname)
{
var name = cname + "=";
var ca = document.cookie.split(';');
for(var i=0; i<ca.length; i++) 
  {
  var c = ca[i].trim();
  if (c.indexOf(name)==0) return c.substring(name.length,c.length);
  }
return "";
}

function setCookie(cname,cvalue)
{
var exdays = 3;
var d = new Date();
d.setTime(d.getTime()+(exdays*24*60*60*1000));
var expires = "expires="+d.toGMTString();
// document.cookie = cname + "=" + cvalue + "; " + expires;
document.cookie = cname + "=" + cvalue + ";expires=" + expires + ";domain=.doyouagree.co.uk;path=/";
}





function loadQnHere(qn,div,preview){
	
    
	if(preview === undefined){
	preview=0;
	}
	// console.log(qn +' '+div);
	if(qn.indexOf("http") != -1 ){
		window.location.href = qn;
	}
	else {
		var dataString = 'pg='+qn;
			dataString += '&div='+div;
			dataString += '&preview='+preview;
		$.ajax({
				    type:'POST',
				    data:dataString,
				    url:'form.php',
				    success:function(res) {
					// console.log(res);
					$( "#"+div ).html( res );
					}
	});
  }
	
}



function quizForm(page,div,draw){

	if(isProcessing){return;}


	// if(draw === undefined) {draw = true;}
	// draw = true;

	// page = sortProgress(page);

	var options = getRadio();
	// alert(options);
	var dataString = "";
	dataString += "&qn="+page;
	dataString += "&options="+options;
	dataString += "&draw="+draw;

	isProcessing = true;
	$.ajax({
		type:'POST',
		data:dataString,
		url:'/UX/quizAnswer.php',
		success:function(res) {
			isProcessing = false;

							var json = $.parseJSON(res);	
							

							console.log(json);
							var qzMsg = "";
							if(json[0] != 0){
								qzMsg = "Correct!";
							}
							else {
								qzMsg = "Incorrect!"
							}
							var qzAnswer = "<div id=\"quizAnswer\" style=\"text-align:center;\"><h3>"+qzMsg+" </h3><br><br><h3>Total : "+json[1]+" pts</h3><br><br><div id=\"nxtBtn\" class=\"btn btn-lg btn-primary btn-block\" name=\"" + json[2]  + "\" style=\"width:40%;margin:0 auto;\" onclick=\"loadQnHere('" + json[2] + "','" + div + "')\">NEXT</div> </div>";				
							// $("#"+div).html(qzAnswer);
							$("#drawArea").html(qzAnswer);
						}
					
				});
			}


function validateForm(page,qType,div,draw){

	if(isProcessing){return;}
	
	if(draw === undefined){ draw = 1;}
	
	var rating = $( "#rangeinput" ).val();
	var options = getCheckBoxes();
	if (options.length == 0) {options = getRadio();}
	var comment = $( "#comment").text();

	var dataString = "";
	dataString += "&qn="+page;
	dataString += "&qType="+qType;
	dataString += "&rating="+rating;
	dataString += "&options="+options;
	dataString += "&comment="+comment;
	dataString += "&lat="+lat;
	dataString += "&lon="+lon;
	dataString += "&store=true";
	dataString += "&draw="+draw;

	isProcessing = true;
	$.ajax({
		type:'POST',						
		data:dataString,
		url:'storeAndReturn.php',
		success:function(res) {
			isProcessing = false;
			var json = $.parseJSON(res);
				var nextQn = json[0].agreeNext.toString();
				setCookie('usrLstQn',nextQn);
	
					if(draw == 0 || json[0].qType =='CMMT'){
						loadQnHere(nextQn,div);
						
					}else{
						 drawOptions(res,div,'1');
					}
		}
	});
							
}

function removeDiv(div){
	$("#"+div).remove();
}


function drawOptions(jr,div,draw,parse,drawNext){
     if(parse === undefined) parse = 1;
	 if(drawNext === undefined) drawNext = 1;
	var json;
	if(parse == 0){json = jr; }
	else{ json = $.parseJSON(jr);}
	// console.log(json);
	
	var noResponses = json[0]['COUNT(*)'];	
	
	// console.log(json[0].agreeNext);
	if(drawNext == 0){
		json[0].question = '';
	}
	
	if(noResponses > 0){
		var drawCanvas = "<div id=\"canvas-container\"><h3>"+json[0].question+"</h3><canvas id=\""+div+"_canvas\" width=\"325\" height=\"215\"></canvas><div id=\""+div+"_key\"></div>"; 
	}
	else {
		var drawCanvas = "<div id=\"canvas-container\"><h3>No Answers Yet</h3>";
	}
	if(drawNext == 1){
		drawCanvas += "<div id=\"nxtBtn\" class=\"btn btn-lg btn-primary btn-block\" name=\""+json[0].agreeNext+"\" style=\"width:40%;margin:0 auto;\" onclick=\"loadQnHere('" + json[0].agreeNext + "','"+div+"')\">NEXT</div> </div>";	
	
	
			var opts = {
				//Boolean - Whether we should show a stroke on each segment
				segmentShowStroke : false,
				//String - The colour of each segment stroke
				segmentStrokeColor : "#fff",
				//Number - The width of each segment stroke
				segmentStrokeWidth : 4,
				//Boolean - Whether we should animate the chart	
				animation : true,
				//Number - Amount of animation steps
				animationSteps : 100,
				//String - Animation easing effect
				animationEasing : "easeOutBounce",
				//Boolean - Whether we animate the rotation of the Pie
				animateRotate : true,
				//Boolean - Whether we animate scaling the Pie from the centre
				animateScale : false,
				//Function - Will fire on animation completion.
				onAnimationComplete : null
			}
}
else {
		var opts = {
			//Boolean - Whether we should show a stroke on each segment
			segmentShowStroke : false,
			//String - The colour of each segment stroke
			segmentStrokeColor : "#fff",
			//Number - The width of each segment stroke
			segmentStrokeWidth : 4,
			//Boolean - Whether we should animate the chart	
			animation : false,
			//Number - Amount of animation steps
			animationSteps : 100,
			//String - Animation easing effect
			animationEasing : "easeOutBounce",
			//Boolean - Whether we animate the rotation of the Pie
			animateRotate : true,
			//Boolean - Whether we animate scaling the Pie from the centre
			animateScale : false,
			//Function - Will fire on animation completion.
			onAnimationComplete : null
		}
}
					
		$("#"+div).html(drawCanvas);
		var ctx = document.getElementById(div+"_canvas").getContext("2d");
		
		var col = JSON.parse(json[0].colours);
		
		
	if(json[0].qType == 'SLD'){
		// console.log(json);
		
		var primaryCol = col[0];
		var secondaryCol = col[1];
			var agree=Math.round(parseFloat( json[0]['AVG(responses.response)'] ) *100);
			// alert(agree);																																							
			var disagree = 100-agree;
			

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
			
			new Chart(ctx).Doughnut(data,opts);

			
			$( "#"+div+"_key" ).html("<div id=\"noResponses\">No of Responses : "+ noResponses +"</div>");
		
	}
	else{
	var data = [];
	

	var lbls = JSON.parse(json[0].options);

	var graphDat = [];
	var keyDat = [];
	var imgIndx = [];
 	
	for(i=1; i<json.length;i++){
		j = json[i].response;
		var segment = {
						value  : parseInt(json[i].count),
						color  : col[j]
						};
	
					graphDat.push(segment);
					
			}
		
	        new Chart(ctx).Pie(graphDat,opts); 
		
		if(drawNext == 1){ 
			if(json[0].qType == 'PIC'){
			drawPicKey(jr,div,parse);
			}else{
			$( "#"+div+"_key" ).html(drawGraphKey(jr,div,parse));
			}
			}
			// $( "#"+div+"_key" ).html("<div id=\"noResponses\">No of Responses : "+ noResponses +"</div>");
			$( "#"+div+"_key" ).append("<div id=\"noResponses\">No of Responses : "+ noResponses +"</div>");
		}			
}

function drawPicKey(jr,div,parse,noKeyDiv){

		if(noKeyDiv === undefined){drawDiv = div+'_key';}
		else {drawDiv = div; }
		if(parse === undefined){parse = 1;}

		var json;
		if(parse == 0){json = jr; }
		else{ json = $.parseJSON(jr);}
		
		qn = json[0].code;
		// console.log(qn);

	var dataString = "qn="+qn;
	// console.log(dataString);

	$.ajax({
		type:'POST',						
		data:dataString,
		url:'/UX/getImageKey.php',
		success:function(res) {
		

			

			var lbls = JSON.parse(json[0].options);
			var col = JSON.parse(json[0].colours);
			var graphDat = [];
			var keyDat = [];
			var imgIndx = [];

			for(i=0; i<lbls.length;i++){
				var key = {
					label  : lbls[i],
					color  : col[i]
				};
				keyDat.push(key);
				imgIndx.push(i);	
			}
			var kcol = "<div class=\"chart-legend\"><ul>";

			var imgsPath = JSON.parse(res);
			for (var key in keyDat){
				try{
					imgSrc = imgsPath[imgIndx[key]];
					// console.log(imgSrc);
				} catch(e){
					imgSrc = '';
				}
				kcol += "<li><img src=\""+imgSrc+"\" style=\"width:50px;height:50px;border-bottom:4px solid "+keyDat[key]['color']+"\"></li>";
			}
			kcol += "</ul></div>";
		
			$( "#"+drawDiv ).append(kcol);
		}
	});


}

function drawGraphKey(jr,div,parse){
	
	
	 if(parse === undefined) parse = 1;
	
	var json;
	if(parse == 0){json = jr; }
	else{ json = $.parseJSON(jr);}
	
	var lbls = JSON.parse(json[0].options);
	var col = JSON.parse(json[0].colours);
	var graphDat = [];
	var keyDat = [];
	var imgIndx = [];
 	
	for(i=0; i<lbls.length;i++){
		// j = json[i].response;
		
		var key = {
				label  : lbls[i],
				color  : col[i]
			};
				
					keyDat.push(key);
					imgIndx.push(i);	
			}
			
			var kcol = "<div class=\"chart-legend\"><ul>";
				for (var key in keyDat) {
					kcol += "<li style=\"color:"+keyDat[key]['color']+"\">"+ keyDat[key]['label'] +"</li>";
				}
			kcol += "</ul></div>";
		    // console.log(kcol);		
		    return kcol;	
}




function getCheckBoxes(){	
	var userSel = [];
	$("input:checkbox").each(function(){
	    var $this = $(this);
	    if($this.is(":checked")){
	        userSel.push($this.attr("name"));
	    }
	});
	return(userSel);
}
function getRadio(){	
	var radioSel = [];
	$("input:radio").each(function(){
	    var $this = $(this);
	    if($this.is(":checked")){
	        radioSel.push($this.attr("value"));
	    }
	});
	return(radioSel);
}


function showValue(val) {

	var element = document.getElementById('rangevalue');
	element.innerHTML = val;
}