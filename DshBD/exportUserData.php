<?php

include ($_SERVER['DOCUMENT_ROOT'].'/DYA_CDB.php');

$user = $_COOKIE['DYA_id'];
// $sql = "select * from `responses` INNER JOIN \n"
//     . "(SELECT DISTINCT `code` FROM `users` INNER JOIN `questions` ON `users`.`id`=`questions`.`userId` WHERE `users`.`id`='72') AS code\n"
//     . "where `responses`.`eventCode`=`code`";

$sql = "select `question`,`eventCode`,`timeStamp`,`response` from `responses` INNER JOIN \n"
    . "(SELECT DISTINCT `questions`.`question`,`code` FROM `users` INNER JOIN `questions` ON `users`.`id`=`questions`.`userId` WHERE `users`.`id`='$user') AS code\n"
    . "where `responses`.`eventCode`=`code`";


$export = mysqli_query ( $db, $sql ) or die ( "Sql error : " . mysqli_error( ) );


// $hdr = mysqli_fetch_fields($export);
// print_r($hdr);
$header ='Question,Code,TimeStamp,Response';
// 
//   foreach ($fieldinfo as $val) {
//    	echo $val;
// 	$header .=  $val.",";
//    	}

while( $row = mysqli_fetch_row( $export ) )
{
    $line = '';
    foreach( $row as $value )
    {                                            
        if ( ( !isset( $value ) ) || ( $value == "" ) )
        {
            $value = ",";
        }
        else
        {
            $value = str_replace( '"' , '""' , $value );
            $value = '"' . $value . '"' . ",";
        }
        $line .= $value;
    }
    $data .= trim( $line ) . "\n";
}
$data = str_replace( "\r" , "" , $data );

if ( $data == "" )
{
    $data = "\n(0) Records Found!\n";                        
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=data.csv");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data";









?>