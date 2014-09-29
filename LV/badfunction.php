//print_r($res);
function getQuestionData($evnts) {

$rslts = array();

$num = 0;
$avg = 0;
$question = "";
$qry = 0;
$tcode = 'dya1';

$query  = "SELECT AVG(rating) FROM pm where eventCode ='$tcode';";
$query .= "SELECT COUNT(eventCode) FROM pm where eventCode ='$tcode';";
$query .= "SELECT question FROM questions where code='$tcode';";

if (mysqli_multi_query($db, $query)) {
    do {
  
        if ($result = mysqli_store_result($db)) {
            while ($row = mysqli_fetch_assoc($result)) {
		  // print_r($row);
		 //  echo $qry;
		if($qry == 0){$avg = $row["AVG(rating)"] * 100; $array_push($rslts,$avg)}
		if($qry == 1){$num = $row["COUNT(eventCode)"]; } 
		if($qry == 2){$question = $row["question"]; } 
		
	}
            mysqli_free_result($result);
        }
        
        if (mysqli_more_results($db)) {	    
		$qry++;    
	//printf("-----------------\n");
        }
    } while (mysqli_next_result($db));
}


print_r($rslts);


return $rslts;
}