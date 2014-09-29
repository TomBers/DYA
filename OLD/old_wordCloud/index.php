<?php

require_once 'Unirest.php';

// Testing code : 9ZmdRzxmrz7I5ZasFjDsXVC9WGIUMgqj

$txt = "Do You Agree simplifies customer feedback, better engages audiences and gives you higher response rates. Ask an audience for their opinion via touch screen designed interface and view the results on a real-time dashboard. You can access your audience through multiple device compatibility and social media integration, which provides meaningful quantifiable data from your audience.";

$response = Unirest::post(
  "https://gatheringpoint-word-cloud-maker.p.mashape.com/index.php",
  array(
    "X-Mashape-Authorization" => "9ZmdRzxmrz7I5ZasFjDsXVC9WGIUMgqj"
  ),
  array(
    "height" => "300",
    "textblock" => $txt,
    "width" => "300",
    "config" => "n\/a"
  )
);

 // print_r($response);

// echo "------------";
$url = $response->body->url;

 echo "<img src=\"$url\"></img>";

?>

