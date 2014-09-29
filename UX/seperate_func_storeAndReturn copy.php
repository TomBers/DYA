<?php


if(isset($_POST['rating'])){
	$rating = $_POST['rating'] / 100;
}else{ $rating = -1;}
if(isset($_POST['options'])){
	$options = $_POST['options'];
}else {$options = array();}
if(isset($_POST['draw'])){
	$draw = $_POST['draw'];
}else{ $draw = 1;}



if(isset($_POST['store'])){

	if(isset($_COOKIE['DYA_id'])){$id = $_COOKIE['DYA_id'];}
	else{$id=-1;}

	storeRes($_POST['qn'],$id,$_POST['qType'],$_POST['lat'],$_POST['lon'],$rating,$_POST['comment'],$options);
}
echo returnDat($_POST['qn'],$rating,$options,$draw);



function storeRes($eventCode,$user,$qType,$lat,$lon,$rating,$comment,$options){
	error_reporting(E_ALL);
	include "../DYA_CDB.php";
	mysqli_query($db,"SET NAMES utf8;");

	if( $qType == "SLD" ){$responses[] = $rating; }
	else if ( $qType == "CMMT" ) { $responses[] = $comment; }
	else {
		$tmpOptions = explode(',',$options);
		foreach ($tmpOptions as $val){if($val != ""){$responses[] = "$val";}}
	}

	foreach ($responses as $response){
		$sql = 'INSERT INTO `responses` (`eventCode`, `user`,`loc`, `response`) VALUES (?, ?, GeomFromText( ? ), ?) ON DUPLICATE KEY UPDATE response=?'; 
		$point = "POINT($lat $lon)";	

		$qry = $db->prepare($sql);
		$qry->bind_param('sisss',$eventCode,$user,$point,$response,$response);
		$qry->execute();
		$qry->close();
	}


}

function returnDat($eventCode,$rating,$options,$draw){

	$rows = array();	
	// $nextCode = $eventCode.'_next';
	// 	
	// 		$mem = new Memcached();
	// 		$mem->addServer("127.0.0.1", 11211);
	// 		$cache = $mem->get($nextCode);
	// 
	// 		if($draw == 0 && $cache){
	// 			if(empty($options)){$qType = "SLD";}
	// 			else{$qType = "RDO";}
	// 			
	// 			$next = getNextQn($cache,$qType,$rating,$opts);
	// 				if(startsWith($next,'http://') || startsWith($next,'www.')){
	// 					setcookie('usrLstQn', '',1,"/");
	// 					setcookie('currentQz', '',1,"/");
	// 				}
	// 				else { 
	// 					$timeOut = time()+60480000;
	// 					setcookie("usrLstQn", $next ,$timeOut,"/");	
	// 				}
	// 			
	// 			return $next;
	// }else{
		// error_reporting(E_ALL);
		include "../DYA_CDB.php";
		mysqli_query($db,"SET NAMES utf8;");


		$sld = FALSE;


		$SLDsql = "SELECT questions.question,questions.questionHTML,questions.qType,questions.agreeNext,questions.options,questions.colours,AVG(responses.response),COUNT(distinct responses.user,responses.timeStamp) FROM `dya`.questions JOIN `dya`.responses ON questions.code = responses.eventCode WHERE `eventcode` ='$eventCode' LIMIT 1;";



		$result = mysqli_query($db, $SLDsql);
		while ($row = mysqli_fetch_assoc($result)) {
			if($row['qType'] == 'SLD'){$sld = TRUE;}
			$row['agreeNext'] = getNextQn($row['agreeNext'],$rating,$options);
			// $mem->set($nextCode,$row['agreeNext']) or die("Couldn't save anything to memcached...");

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
	// }
}	

function getNextQn($nextQns,$qType,$rating,$opts){

	// return 'FEUNO';
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

function isJson($string) {
	json_decode($string);
	return (json_last_error() == JSON_ERROR_NONE);
}	

function startsWith($haystack, $needle)
{
	return $needle === "" || strpos($haystack, $needle) === 0;
}

?>

