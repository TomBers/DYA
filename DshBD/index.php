<!DOCTYPE html>
<?php
include('../topBar.php');

include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');

session_start();
$user = $_SESSION['DYA_id'];



// $sql = "SELECT * FROM `users` WHERE `id` = '$user'";
$sql = "select (SELECT loginService FROM `users` WHERE `id` = '$user') as loginService,\n"
    . " (SELECT firstName FROM `users` WHERE `id` = '$user') as firstName, \n"
    . "	 (SELECT lastName FROM `users` WHERE `id` = '$user') as lastName, \n"
    . "	 (SELECT dateOfBirth FROM `users` WHERE `id` = '$user') as dateOfBirth,\n"
    . "	 (SELECT gender FROM `users` WHERE `id` = '$user') as gender,\n"
    . "	 (SELECT email FROM `users` WHERE `id` = '$user') as email, \n"
	. "	 (SELECT account FROM `users` WHERE `id` = '$user') as account, \n"
    . " (SELECT COUNT(*) FROM `questions` WHERE `userId` = '$user') as questionCount,\n"
    . "	 (SELECT COUNT(*) FROM `responses` WHERE `user` = '$user') as answerCount";


// look to getting more Data on questions asked and answered?
// SELECT * FROM `users` JOIN `questions` ON `users`.`id`=`questions`.`userId` WHERE `users`.`id` = '6'

$result = mysqli_query($db,$sql);

while($row = mysqli_fetch_array($result))
  {
      

?>
<script src="/js/jeditable.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
$(function() {
        
  $(".dblclick").editable("save.php", { 
      indicator : "<img src='/images/loader.gif'>",
      tooltip   : "Doubleclick to edit...",
      event     : "dblclick",
      style  : "inherit"

});

$(".editable_select").editable("save.php", { 
   indicator : '<img src="/images/loader.gif">',
   data   : "{'M':'Male','F':'Female','N':'Rather not say'}",
   type   : "select",
   submit : "OK",
   style  : "inherit",
 });

});
</script>
<style>
b.dblclick form input{
/*	font-size:24px;*/
	font-size:10px;
	height:125px;
}
b.dblclick{
	font-size:14px;
	height:125px;
}
#stats{
	font-size:18px;
}
#settings{
	
}

</style>
<div id="settings" class="container" >

		<h1>Profile Settings</h1>
       <div class="col-md-2">
        	
			<img src="<?php echo $_SESSION["DYA_imageURL"]; ?>" height="100" width="100">
			</div>
			<div class="col-md-3">
			<p>Login Service : <strong><?php echo $row["loginService"] ?></strong> <br>     
			First Name : <b class="dblclick" style="display: inline" id="firstName"><?php echo $row["firstName"]; ?></b><br>
			Last Name : <b class="dblclick" style="display: inline" id="lastName"><?php echo $row["lastName"]; ?></b><br>
		    Date of Birth : <b class="dblclick" style="display: inline" id="dateOfBirth"><?php echo $row["dateOfBirth"]; ?></b><br>
			Gender : <b class="editable_select" style="display: inline" id="gender"><?php echo $row["gender"]; ?></b><br>
			E-mail : <b class="dblclick" style="display: inline" id="email"><?php echo $row["email"]; ?></b>
			<br><br>Double click your data to edit.
			</p>
			<br><br>
			<h2>Account Type : <?php if($row['account'] != null){echo $row['account'];}else{echo 'Free';}?></h2>	
				
				<br><br>
			
			<a type="button" href="/logout.php" class="btn btn-lg btn-default">Logout</a>
           </div>

		<div id='stats' class="col-md-4">
	            Questions I have asked :  <strong><?php echo $row["questionCount"] ?></strong><br>  
				Answers I have given : <strong><?php echo $row["answerCount"] ?></strong><br>
				Analyse Answers : <a href="analytics.php">Here</a>
	           </div>
         


</div>
        
     

       

<?php 
}
?>
<link href='/css/andreea.css' rel='stylesheet' type='text/css'>