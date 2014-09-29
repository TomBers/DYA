<?php 
error_reporting(E_ALL | E_STRICT);


// print_r($_POST);
include $_SERVER['DOCUMENT_ROOT']."/DYA_CDB.php";
session_start();
$_SESSION['qnParams'] = $_POST;

mysqli_query($db,"SET NAMES utf8;");

// Generate Unique SHort Code

function checkCodeExists($gcode){

	include $_SERVER['DOCUMENT_ROOT']."/DYA_CDB.php";

	$sql = "select `code` from questions where code='$gcode'";
	$response = mysqli_query($db, $sql);
	$numRows = mysqli_num_rows($response);
	mysqli_free_result($response);
	return $numRows;	
}


function createRandomString($string_length, $character_set) {
	$random_string = array();
	for ($i = 1; $i <= $string_length; $i++) {
		$rand_character = $character_set[rand(0, strlen($character_set) - 1)];
		$random_string[] = $rand_character;
	}
	shuffle($random_string);
	return implode('', $random_string);
}

function validUniqueString($string_collection, $new_string, $existing_strings='') {
	if (!strlen($string_collection) && !strlen($existing_strings))
		return true;
	$combined_strings = $string_collection . ", " . $existing_strings;
	return (strlen(strpos($combined_strings, $new_string))) ? false : true;
}



function createRandomStringCollection($string_length, $number_of_strings, $character_set, $existing_strings = '') {
	$string_collection = '';
	for ($i = 1; $i <= $number_of_strings; $i++) {
		$random_string = createRandomString($string_length, $character_set);
		while (!validUniqueString($string_collection, $random_string, $existing_strings)) {
			$random_string = createRandomString($string_length, $character_set);
		}
		$string_collection .= ( !strlen($string_collection)) ? $random_string : ", " . $random_string;
	}
	return $string_collection;
}

$character_set = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$existing_strings = "";
$string_length = 5;
$number_of_strings = 1;
$webpath='';

if(isset($_SESSION['DYAcode'])) {
	$code = $_SESSION['DYAcode']; 	
}
else{
	$code = createRandomStringCollection($string_length, $number_of_strings, $character_set,$existing_strings);
	while (checkCodeExists($code) != 0) {
		$code = createRandomStringCollection($string_length, $number_of_strings, $character_set, $existing_strings);
	}
	$_SESSION['DYAcode'] = $code;	
}

	$mem = new Memcached();
	$mem->addServer("127.0.0.1", 11211);
	$cache = $mem->get(strtolower($code));
	
	if($cache){
		$mem->delete(strtolower($code));
	}
	

	$qst = $_POST["question"];
	$html = $_POST["html"];


	
	$qtype = $_POST["qType"];
	$tOptions = array();
	$tColours = array();
	
	// Set colours
	$tColours[] = "#00A0B0";
	$tColours[] = "#CC333F";
	$tColours[] = "#EB6841";
	$tColours[] = "#EDC951";
	$tColours[] = "#6A4A3C";

	if($qtype == 'PIC'){
		for($i = 0; $i < $_POST['noImages']; $i++){
			$tOptions[] = $i;
			if($i > 4){$tColours[] = rand_color();}
		}
	
	} else if($qtype == 'SLD'){
				$tColours[] = "#E73F3F";
				$tColours[] = "#F76C27";
	} else{
		$j = 0;
		foreach( $_POST as $opt => $val) {
			if(startsWith($opt,'opt')){
				// $tmp = preg_replace($search, '', $val);
				// $tmp = mysql_real_escape_string($val);
				if($val != "") {
					$tOptions[] = $val;
					if($j > 4){$tColours[] = rand_color();}
					$j++;
					}
			}

		}
	}
	
	
	
	$opts = json_encode( $tOptions );
	$colours = json_encode( $tColours );
	
	
	// $colours = json_encode( array("#E73F3F","#F76C27","#E7E737","#6D9DD1","#7E45D3") );


	
	$next = "http://www.doyouagree.co.uk/pages/thankyou.html";


	$user = $_SESSION['DYA_id'];

	$stmt = $db->prepare('INSERT INTO `dya`.`questions` (`userId`,`code`, `question`,`questionHTML`, `agreeNext`,`qType`,`options`,`colours` ) VALUES (?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE `question`=?,`questionHTML`= ?,`qType`=?,`options`=?,`colours`=?');
	$stmt->bind_param('issssssssssss', $user,$code,$qst,$html,$next,$qtype,$opts,$colours,$qst,$html,$qtype,$opts,$colours);
	$stmt->execute();
	

	// $Insert = mysqli_query($db,"INSERT INTO `dya`.`questions` (`id`, `userId`,`code`, `question`,`questionHTML`, `active`, `agreeNext`,`qType`,`options`,`colours` ) VALUES (NULL, '$user','$code', '$qst', '$html','1', '$next','$qtype','$opts','$colours') ON DUPLICATE KEY UPDATE `question`='$qst',`questionHTML`= '$html',`qType`='$qtype',`options`='$opts',`colours`='$colours';");

	if($qtype == 'QZ' && isset( $_POST['answer'] )){
	
			$answer = json_encode(array($_POST['answer']));
			mysqli_query($db,"INSERT INTO `dya`.`qzAnswers` (`code`, `qnFlag`, `answer`) VALUES ('$code', '','$answer') ON DUPLICATE KEY UPDATE `answer`='$answer';");
	}
	

	header("Location: preview.php?code=$code");






function startsWith($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}

function rand_color() {
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}


?>