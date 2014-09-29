<!DOCTYPE html>
<style>


.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  height: auto;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>
<script>
function gotoCode(){
	var cde = $("#code").val();
	window.location.replace("http://www.doyouagree.co.uk/"+cde);
}
</script>
<body>
			<?php 
			include("../topBar.php"); 
			?>
		  <div class="container">
			<?php
				if(isset($_GET['err'])){
							echo "<div class=\"alert alert-warning\"><strong>Sorry</strong> That was not a valid code.</div>";
						}
			?>
		      <div class="form-signin">
		        <h2 class="form-signin-heading">Enter Code :</h2>
		        <input type="text" class="form-control" id="code" name="code" onChange="javascript:this.value=this.value.toLowerCase();" placeholder="Code" required autofocus>	<br>	     		        
		        <button class="btn btn-lg btn-primary btn-block" type="submit" onclick="gotoCode()">Submit</button>
		     </div>

		    </div>
		

</body>
	<link href='/css/andreea.css' rel='stylesheet' type='text/css'>