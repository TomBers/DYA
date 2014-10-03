<!DOCTYPE html>
<link href='/css/createQn.css' rel='stylesheet' type='text/css'>
<?php 
include('../topBar.php');

if(!isset($_SESSION['DYA_id'])){
	header('Location: http://www.doyouagree.co.uk/login.php');
}
setupQnParameters();

function setupQnParameters() {


	// 3 Possible Options :
	// 1) New Question - destroy Session params and continue
	// 2) Edit previous question - back button pressed
	// 3) Need to edit past questions - not the most recent one
	session_start();
	if(isset($_REQUEST['new'])){
		unset($_SESSION['DYAcode']);
		unset($_SESSION['qnParams']);
	}
	else if(isset($_REQUEST['edit'])){

		// echo "Edit existing question";
		$_SESSION['qnParams'] = '';
		include $_SERVER['DOCUMENT_ROOT']."/DYA_CDB.php";
		// Load question parameters into SESSION Variable

		$tcde =  $_REQUEST['edit'];
		$_SESSION['DYAcode'] =$tcde;
		mysqli_query($db,"SET NAMES utf8;");

		$qry = "select qType,questionHTML,options from `questions` where `code`='$tcde' LIMIT 1";

		$row = mysqli_fetch_assoc(mysqli_query($db,$qry));

		// print_r($row);
		$_SESSION['qnParams']['qType'] = $row['qType'];
		$_SESSION['qnParams']['html'] = $row['questionHTML'];
		$topts = json_decode($row['options']);

		for ($i = 0; $i < count($topts); $i++){
			$j = $i+1;
			$_SESSION['qnParams']['opt'.$j] = $topts[$i];
		}
		if($row['qType'] == 'QZ'){
			$qry = "select `answer` from `qzAnswers` where `code`='$tcde' LIMIT 1";
			$row = mysqli_fetch_assoc(mysqli_query($db,$qry));
			$tansw = json_decode($row['answer']);
			$_SESSION['qnParams']['answer'] = $tansw[0];


		}



	}
}


?>
<link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../css/froala_editor.min.css" rel="stylesheet" type="text/css">


<script src="/js/froala_editor.min.js"></script>
<script src="/js/holder.js"></script>

<div class="container">
	<h2><strong>Step 1 : </strong> What Question Do you wish to ask?</h2>
	<img data-src='holder.js/110x110/text:Landing Page' id='LND'>
	<img data-src='holder.js/110x110/text:Slider' id='SLD'>
	<img data-src='holder.js/110x110/text:Single Choice' id='RDO'>
	<img data-src='holder.js/110x110/text:Multiple Choice' id='CHK'>
	<img data-src='holder.js/110x110/text:Comment' id='CMMT'>
	<img data-src='holder.js/110x110/text:Picture Select' id='PIC'>
	<img data-src='holder.js/110x110/text:Quiz' id='QZ'>


	<h2><strong>Step 2 : </strong> Set Question (and any images)</h2>
	<form id="fileupload" action="/QM2/svQnNew.php" method="POST" onsubmit="return validateForm()" enctype="multipart/form-data">
		<section id="editor">
			<div id='edit'>
				<?php echo $_SESSION['qnParams']['html']; ?>
			</div>
		</section>
		<div id="qOptions">
			<div id="initalTextBox">
				<h2><strong>Step 3 : </strong> Options for Answer</h2>
				<?php
				
				if(isset($_SESSION['qnParams'])){
					foreach($_SESSION['qnParams'] as $key =>$value){
						if(substr( $key, 0, 3 ) === 'opt'){
							echo "<input type='text' class='form-control' name='$key' id='$key' placeholder='Option $count' value='$value'/>";

							// if($_SESSION['qnParams']['qType'] == 'QZ' && filter_var($_SESSION['qnParams']['answer'], FILTER_SANITIZE_NUMBER_INT) == filter_var($key, FILTER_SANITIZE_NUMBER_INT)){
								$ansNo = "answ".filter_var($key, FILTER_SANITIZE_NUMBER_INT);
								echo "<input type='radio' value='$ansNo' name='answer' class='form-control'";
								if($_SESSION['qnParams']['answer'] === $ansNo){
									echo 'checked';
								}
								echo '/>';
							// }
						}
					}
				}else{
					for($i = 1; $i<6; $i++){
						echo "<input type='text' class='form-control' name='opt$i' id='$opti' placeholder='Option $i'/>";
						echo "<input type='radio' value='answ$i' name='answer' class='form-control' />";
					}
				}
				?>

			
			</div>
			<div id='addMore'>+ Add more</div>
		</div>


		<!--<button onclick="showHTML()">Show HTML</button>
		<button onclick="showTEXT()">Show TEXT</button><br><br> -->
		<br><input id="button" class="btn btn-lg btn-primary btn-block" type="submit" value="Make Question" />
		<input type="hidden" id="qType" name="qType" value="SLD" />
		<input type="hidden" id="html" name="html" value="" />
		<input type="hidden" id="question" name="question" value="" />
		<input type="hidden" id="noImages" name="noImages" value="" />
	</div>

	<script>

	var questionType = 'SLD';
	$( document ).ready(function() {


		$( "#addMore" ).click(function() {
			var n =$('#initalTextBox input[type="text"]').length + 1;
			$('#initalTextBox').append('<input type="text" class="form-control" name="opt'+n+'" id="opt'+n+'"  placeholder="Option '+n+'"/><input type="radio" value="answ'+n+'" name="answer" class="form-control" />');
			setQnType($('#qType').val());
		});


		$("#edit").bind({					
			paste : function(){														
				setTimeout(function () {
					// alert($("#edit").editable("getText"));							    							
					$("#edit").editable("setHTML", $("#edit").editable("getText").trim(), false);

					}, 250);	
				}					
			});

			<?php if(isset($_REQUEST['qnType']) && $_SESSION['qnParams']['qType'] == ""){ ?>
				setQnType('<?php echo $_REQUEST['qnType'];?>');
				<?php	}else { ?>
					setQnType('<?php echo $_SESSION['qnParams']['qType'];?>');
					<?php } ?>

					$( "img" ).click(function() {
						// alert( this.id );
						setQnType(this.id);
					});
				});

				function setQnType(qType){
					$('#qType').val(qType);
					questionType = qType;

					if(qType == 'RDO' || qType =='CHK' || qType == 'QZ' ){
						$('#qOptions').show();	
						if(qType == 'QZ'){$('input[type=radio]').show();}
						else {	$('input[type=radio]').hide();}
					}
					else{
						$('input[type=radio]').hide();
						$('#qOptions').hide();
					}
					$('img').css({"border":"solid 0px white"});
					$('#'+qType).css({"border":"solid 4px black"});
				}

				function validateForm(){

					if(questionType == 'QZ' && !$("input[name='answer']:checked").val()){
						alert('Please choose the correct answer');
						return false;
					}

					$('#noImages').val($('#edit img').length); 
					$('#html').val($("#edit").editable("getHTML"));
					$('#question').val($("#edit").editable("getText"));

					// alert(	$('#question').val());

					if($('#qType').val() == ''){
						$('#qType').val('SLD');
					}

					if($('#question').val() == ''){
						alert('Please enter a question');
						return false;
					}

					if($('#question').val().length > 500){
						alert('Too many characters in your question - please change');
						return false;
					}

					return true;
				}

				$(function(){
					$('#edit').editable({
						inlineMode: false,
						inverseSkin: true,
						minHeight: 100,
						width: 680,
						buttons: ["bold", "italic", "underline", "fontFamily", "fontSize", "color", "formatBlock", "align", "insertOrderedList", "insertUnorderedList", "outdent", "indent", "insertImage", "insertVideo"],
						imageUploadURL: '/QM2/upload.php',
						imageParams: {id: "my_editor"}
					})
				});
				</script>
				<link href='/css/andreea.css' rel='stylesheet' type='text/css'>