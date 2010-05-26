<?php
/* 
header random generator 
By Vito Tafuni - vitotafuni_AT_gmail_DOT_com 
*/
$headers = glob("header*.jpg"); 
$header = $headers[rand(1,count($headers))-1];
header('Content-type: image/jpeg');
readfile($header);
exit;
?>
