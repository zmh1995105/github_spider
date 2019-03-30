<?php

session_start();

require_once( 'sysConfig.php' );

$authUser = $_POST['username'];
$authPass = $_POST['password'];
$authPass = hash( 'sha256', $authPass );

if ( $username == $authUser && $password == $authPass ) {
	$_SESSION['username'] = $authUser;
	header( 'Location: index.php' );
} else {
	header( 'Location: login.html' );
}

?>
