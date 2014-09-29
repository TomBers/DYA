<?php
include "../DYA_CDB.php";

$rows = array();	
if(isset($_REQUEST['qn'])){$eventCode=$_REQUEST['qn'];}
else {return json_encode("No Code");}

mysqli_query($db,"SET NAMES utf8;");


$qry = "SELECT questions.code,questions.question,questions.qType,questions.agreeNext,questions.options,questions.colours,AVG(responses.response),COUNT(*) FROM `dya`.questions JOIN `dya`.responses ON questions.code = responses.eventCode WHERE `eventcode` ='$eventCode' LIMIT 1;";
$qry .= "SELECT response,COUNT(*) as count FROM `dya`.responses WHERE `eventcode` ='$eventCode' GROUP BY `response` ORDER BY `response` ASC";



if ($db->multi_query($qry)) {
    do {
        /* store first result set */
        if ($result = $db->store_result()) {
            while ($row = $result->fetch_assoc()) {
                //print_r($row);
				$rows[] = $row;
				if($row['qType'] == 'SLD'){
					$db->close();
					
				}
            }
            $result->free();
        }
        /* print divider */
        if ($db->more_results()) {
            //printf("-----------------\n");
        }
    } while ($db->next_result());
}
$db->close();


echo json_encode($rows);



?>