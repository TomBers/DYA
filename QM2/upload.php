<?php

require_once('ImageManipulator.php');
// Allowed extentions.
$allowedExts = array("gif", "jpeg", "jpg", "png");

// Get filename.
$temp = explode(".", $_FILES["file"]["name"]);

// Get extension.
$extension = end($temp);

// An image check is being done in the editor but it is best to
// check that again on the server side.
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& in_array($extension, $allowedExts)) {
    // Generate new random name.
    $name = sha1(microtime()) . "." . $extension;

    // Save file in the uploads folder.

	
	$manipulator = new ImageManipulator($_FILES['file']['tmp_name']);

	$newImage = $manipulator->resample(600, 600);
	// move uploaded file from temp to uploads directory
	$manipulator->save($_SERVER['DOCUMENT_ROOT']."/QM2/uploads/" . $name);
	
    // move_uploaded_file($_FILES["file"]["tmp_name"], $_SERVER['DOCUMENT_ROOT']."/QM2/uploads/" . $name);

    // Generate response.
    $response = new StdClass;
    $response->link = "/QM2/uploads/" . $name;
    echo stripslashes(json_encode($response));
}
?>