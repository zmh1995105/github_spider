<?php
session_start();
$res=session_destroy(); 	//delete all session variables
if($res){
	header('Location: ./main.php');
	}
?>
