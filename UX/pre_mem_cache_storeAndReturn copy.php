<?php


if(isset($_POST['rating'])){
	$rating = $_POST['rating'] / 100;
}else{ $rating = -1;}
if(isset($_POST['options'])){
	$options = $_POST['options'];
}else {$options = array();}

if(isset($_POST['store'])){
	
	if(isset($_COOKIE['DYA_id'])){$id = $_COOKIE['DYA_id'];}
	else{$id=-1;}
	
storeRes($_POST['qn'],$id,$_POST['qType'],$_POST['lat'],$_POST['lon'],$rating,$_POST['comment'],$options);
}
echo returnDat($_POST['qn'],$rating,$options);



function storeRes($eventCode,$user,$qType,$lat,$lon,$rating,$comment,$options){
	error_reporting(E_ALL);
	include "../DYA_CDB.php";
	mysqli_query($db,"SET NAMES utf8;");
	
	
	if( $qType == "SLD" ){$responses[] = $rating; }
	else if ( $qType == "CMMT" ) { $responses[] = sanitize($comment); }
	else {
		$tmpOptions = explode(',',$options);
		foreach ($tmpOptions as $val){if($val != ""){$responses[] = "$val";}}
		}
		


	foreach ($responses as $response){
	$sql = "INSERT INTO `dya`.`responses` (`eventCode`, `user`,`loc`, `response`) VALUES ('$eventCode', '$user', GeomFromText( ' POINT($lat $lon) ' ), '$response') ON DUPLICATE KEY UPDATE response='$response';"; 
	
	$qry = $db->prepare($sql);
	$qry->execute();
	
	// mysqli_query($db, $sql);
	}
	// mysqli_close($db);
	
}

function returnDat($eventCode,$rating,$options){
	
	error_reporting(E_ALL);
	include "../DYA_CDB.php";
	mysqli_query($db,"SET NAMES utf8;");

	
	$rows = array();
	$sld = FALSE;


	
	$SLDsql = "SELECT questions.question,questions.questionHTML,questions.qType,questions.agreeNext,questions.options,questions.colours,AVG(responses.response),COUNT(distinct responses.user,responses.timeStamp) FROM `dya`.questions JOIN `dya`.responses ON questions.code = responses.eventCode WHERE `eventcode` ='$eventCode' LIMIT 1;";


	
	$result = mysqli_query($db, $SLDsql);
		while ($row = mysqli_fetch_assoc($result)) {
			
			if($row['qType'] == 'SLD'){$sld = TRUE;}
			$row['agreeNext'] = getNextQn($row['agreeNext'],$row['qType'],$rating,$options);
			
			if($row['qType'] == 'PIC'){
				$tmpImg = array();
				$doc = new DOMDocument();
				$doc->loadHTML($row['questionHTML']);
				    $imgs = $doc->getElementsByTagName('img');
				
					foreach($imgs as $img){
				     $tmpImg[] = $img->getAttribute('src');
				}
					$row['imgLinks'] = json_encode($tmpImg);
		}
			
			if(startsWith($row['agreeNext'],'http://') || startsWith($row['agreeNext'],'www.')){
								setcookie('usrLstQn', '',1,"/");
								setcookie('currentQz', '',1,"/");
							}
							else { 
				$timeOut = time()+60480000;
				setcookie("usrLstQn", $row['agreeNext'] ,$timeOut,"/");	
				}
			
			$rows[] = $row;
		}

		if($sld == FALSE){
				$SLDsql = "SELECT response,COUNT(*) as count FROM `dya`.responses WHERE `eventcode` ='$eventCode' GROUP BY `response` ORDER BY `response` ASC;";
				
				
				$result = mysqli_query($db, $SLDsql);
					while ($row = mysqli_fetch_assoc($result)) {
						$rows[] = $row;
					}
				}	
		
		mysqli_close($db);
		return json_encode($rows);
}	

function getNextQn($nextQns,$qType,$rating,$opts){
	

	if(isJson($nextQns)){
		$nq = json_decode($nextQns);
		$tmpOptions = explode(',',$opts);
		$opt = $tmpOptions[0];
		$int = filter_var($opt, FILTER_SANITIZE_NUMBER_INT);
		 if($int == ""){$int=0;}
		
		if($qType == 'SLD' && $rating < 0.5 && count($nq) >= 2){return $nq[0];}
		else if($qType == 'SLD' && $rating >= 0.5 && count($nq) >= 2){return $nq[1];}
		else if( ($qType == 'RDO' || $qType == 'PIC') && count($nq) >= $int){return $nq[$int];}
		else {return $nq[0];}		
	}
	else{return $nextQns;}
	
}

function cleanInput($input) {

  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
  );

    $output = preg_replace($search, '', $input);
    return $output;
  }
?>
<?php
function sanitize($input) {
    if (is_array($input)) {
        foreach($input as $var=>$val) {
            $output[$var] = sanitize($val);
        }
    }
    else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $input  = cleanInput($input);
        $output = mysql_real_escape_string($input);
    }
    return $output;
}

function isJson($string) {
 json_decode($string);
 return (json_last_error() == JSON_ERROR_NONE);
}	

function startsWith($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}

?>
	
