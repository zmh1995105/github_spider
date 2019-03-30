<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>PHP web shell scan</title>
</head>
<body>
</body>
<?php
define("SELF",php_self());
error_reporting(E_ERROR);
ini_set('max_execution_time',20000);
ini_set('memory_limit','512M');
header("content-Type: text/html; charset=utf-8");
function weevelyshell($file){
    $content=file_get_contents($file);
    if(
        (
        preg_match('#(\$\w{2,4}\s?=\s?str_replace\("\w+","","[\w_]+"\);\s?)+#s',$content)&&
      preg_match('#(\$\w{2,4}\s?=\s?"[\w\d\+\/\=]+";\s?)+#',$content)&&               preg_match('#\$[\w]{2,4}\s?=\s\$[\w]{2,4}\(\'\',\s?\$\w{2,4}\(\$\w{2,4}\("\w{1,4}",\s?"",\s?\$\w{2,4}\.\$\w{2,4}\.\$\w{2,4}\.\$\w{2,4}\)\)\);\s+?\$\w{2,4}\(\)\;#',$content))
          ||
          (preg_match('#\$\w+\d\s?=\s?str_replace\(\"[\w\d]+\",\"\",\"[\w\d]+\"\);#s',$content)&&
        preg_match('#\$\w+\s?=\s?\$[\w\d]+\(\'\',\s?\$[\w\d]+\(\$\w+\(\$\w+\(\"[[:punct:]]+\",\s?\"\",\s?\$\w+\.\$\w+\.\$\w+\.\$\w+\)\)\)\);\s?\$\w+\(\);#s',$content))
        ){
        return true;
    }
}
function callbackshell($file){
    $content=file_get_contents($file);
    if(
        preg_match('#\$\w+\s?=\s?\$_(?:GET|POST|REQUEST|COOKIE|SERVER)\[.*?\]#is',$content)&&
        preg_match('#\$\w+\s?=\s?(?:new)?\s?array\w*\s?\(.*?_(?:GET|POST|REQUEST|COOKIE|SERVER)\[.*?\].*?\)+#is',$content)&&
        preg_match('#(?:array_(?:reduce|map|udiff|walk|walk_recursive|filter)|u[ak]sort)\s?\(.*?\)+?#is',$content)
        )
            return true;
}
function php_self(){
  $php_self=substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
  return $php_self;
}
$matches = array(
        '/mb_ereg_replace\([\'\*\s\,\.\"]+\$_(?:GET|POST|REQUEST|COOKIE|SERVER)\[[\'\"].*?[\'\"][\]][\,\s\'\"]+e[\'\"]'/is,
        '/preg_filter\([\'\"\|\.\*e]+.*\$_(?:GET|POST|REQUEST|COOKIE|SERVER)/is',
        '/create_function\s?\(.*assert\(/is',
        '/ini_get\(\'safe_mode\'\)/i',
        '/get_current_user\(.*?\)/i',
        '/@?assert\s?\(\$.*?\)/i',
        '/proc_open\s?\(.*?pipe\',\s?\'w\'\)/is',
    '/sTr_RepLaCe\s?\([\'\"].*?[\'\"],[\'\"].*?[\'\"]\s?,\s?\'a[[:alnum:][:punct:]]+?s[[:alnum:][:punct:]]+?s[[:alnum:][:punct:]]+?e[[:alnum:][:punct:]]+?r[[:alnum:][:punct:]]+?t[[:alnum:][:punct:]]+?\)/i',
        '/preg_replace_callback\(.*?create_function\(/is',
        '/filter_var(?:_array)?\s?.*?\$_(?:GET|POST|REQUEST|COOKIE|SERVER)\[[\'\"][[:punct:][:alnum:]]+[\'\"]\][[:punct:][:alnum:][:space:]]+?assert[\'\"]\)/is',
        '/ob_start\([\'\"]+assert[\'\"]+\)/is',
        '/new\s?ReflectionFunction\(.*?->invoke\(/is',
      '/PDO::FETCH_FUNC/',
        '/\$\w+.*\s?(?:=|->)\s?.*?[\'\"]assert[\'\"]\)?/i',
        '/\$\w+->(?:sqlite)?createFunction\(.*?\)/i',
        '/eval\([\"\']?\\\?\$\w+\s?=\s?.*?\)/i',
        '/eval\(.*?gzinflate\(base64_decode\(/i',
        '/copy\(\$HTTP_POST_FILES\[\'\w+\'\]\s?\[\'tmp_name\'\]/i',
        '/register_(?:shutdown|tick)_function\s?\(\$\w+,\s\$_(?:GET|POST|REQUEST|COOKIE|SERVER)\[.*?\]\)/is',
        '/register_(?:shutdown|tick)_function\s?\(?[\'\"]assert[\"\'].*?\)/i',
        '/call_user_func.*?\([\"|\']assert[\"|\'],.*\$_(?:GET|POST|REQUEST|COOKIE|SERVER)\[[\'|\"].*\]\)+/is',
      '/preg_replace\(.*?e.*?\'\s?,\s?.*?\w+\(.*?\)/i',
    '/function_exists\s*\(\s*[\'|\"](popen|exec|proc_open|system|passthru)+[\'|\"]\s*\)/i',
    '/(exec|shell_exec|system|passthru)+\s*\(\s*\$_(\w+)\[(.*)\]\s*\)/i',
    '/(exec|shell_exec|system|passthru)+\s*\(\$\w+\)/i',
    '/(exec|shell_exec|system|passthru)\s?\(\w+\(\"http_.*\"\)\)/i',
         '/(?:john\.barker446@gmail\.com|xb5@hotmail\.com|shopen@aventgrup\.net|milw0rm\.com|www\.aventgrup\.net|mgeisler@mgeisler\.net)/i',
      '/Php\s*?Shell/i',
    '/((udp|tcp)\:\/\/(.*)\;)+/i',
    '/preg_replace\s*\((.*)\/e(.*)\,\s*\$_(.*)\,(.*)\)/i',
    '/preg_replace\s*\((.*)\(base64_decode\(\$/i',
    '/(eval|assert|include|require|include_once|require_once)+\s*\(\s*(base64_decode|str_rot13|gz(\w+)|file_(\w+)_contents|(.*)php\:\/\/input)+/i',
    '/(eval|assert|include|require|include_once|require_once|array_map|array_walk)+\s*\(.*?\$_(?:GET|POST|REQUEST|COOKIE|SERVER|SESSION)+\[(.*)\]\s*\)/i',
    '/eval\s*\(\s*\(\s*\$\$(\w+)/i',
      '/((?:include|require|include_once|require_once)+\s*\(?\s*[\'|\"]\w+\.(?!php).*[\'|\"])/i',
    '/\$_(\w+)(.*)(eval|assert|include|require|include_once|require_once)+\s*\(\s*\$(\w+)\s*\)/i',
    '/\(\s*\$_FILES\[(.*)\]\[(.*)\]\s*\,\s*\$_(GET|POST|REQUEST|FILES)+\[(.*)\]\[(.*)\]\s*\)/i',
    '/(fopen|fwrite|fputs|file_put_contents)+\s*\((.*)\$_(GET|POST|REQUEST|COOKIE|SERVER)+\[(.*)\](.*)\)/i',
    '/echo\s*curl_exec\s*\(\s*\$(\w+)\s*\)/i',
    '/new com\s*\(\s*[\'|\"]shell(.*)[\'|\"]\s*\)/i',
    '/\$(.*)\s*\((.*)\/e(.*)\,\s*\$_(.*)\,(.*)\)/i',
    '/\$_\=(.*)\$_/i',
    '/\$_(GET|POST|REQUEST|COOKIE|SERVER)+\[(.*)\]\(\s*\$(.*)\)/i',
    '/\$(\w+)\s*\(\s*\$_(GET|POST|REQUEST|COOKIE|SERVER)+\[(.*)\]\s*\)/i',
    '/\$(\w+)\s*\(\s*\$\{(.*)\}/i',
    '/\$(\w+)\s*\(\s*chr\(\d+\)/i'
);
function antivirus($dir,$exs,$matches) {
    if(($handle = @opendir($dir)) == NULL) return false;
    while(false !== ($name = readdir($handle))) {
        if($name == '.' || $name == '..') continue;
        $path = $dir.$name;
        if(strstr($name,SELF)) continue;
        //$path=iconv("UTF-8","gb2312",$path);
        if(is_dir($path)) {
            //chmod($path,0777);/*主要针对一些0111的目录*/
            if(is_readable($path)) antivirus($path.'/',$exs,$matches);
        } elseif(strpos($name,';') > -1 || strpos($name,'%00') > -1 || strpos($name,'/') > -1) {
            echo '特征 <input type="text" style="width:250px;" value="解析漏洞">     '.$path.'<p></p>'; flush(); ob_flush();
        }
        else {
            if(!preg_match($exs,$name)) continue;
            if(filesize($path) > 10000000) continue;
            $fp = fopen($path,'r');
            $code = fread($fp,filesize($path));
            fclose($fp);
            if(empty($code)) continue;
            if(weevelyshell($path)){
            echo '特征 <input type="text" style="width:250px;" value="weevely 加密shell">     '.$path.'<p></p>'; flush(); ob_flush();
        }elseif(callbackshell($path)){
                echo '特征 <input type="text" style="width:250px;" value="Callback shell">     '.$path.'<p></p>'; flush(); ob_flush();
        }
            foreach($matches as $matche) {
                $array = array();
                preg_match($matche,$code,$array);
                if(!$array) continue;
                if(strpos($array[0],"\x24\x74\x68\x69\x73\x2d\x3e")) continue;
                $len = strlen($array[0]);
                if($len > 6 && $len < 200) {
                    echo '特征 <input type="text" style="width:250px;" value="'.htmlspecialchars($array[0]).'">    '.$path.'<p></p>';
                    flush(); ob_flush(); break;
                }
            }
            unset($code,$array);
        }
    }
    closedir($handle);
    return true;
}
function strdir($str) { return str_replace(array('\\','//','//'),array('/','/','/'),chop($str)); }
echo '<form method="POST">';
echo '路径: <input type="text" name="dir" value="'.($_POST['dir'] ? strdir($_POST['dir'].'/') : strdir($_SERVER['DOCUMENT_ROOT'].'/')).'" style="width:398px;"><p></p>';
echo '后缀: <input type="text" name="exs" value="'.($_POST['exs'] ? $_POST['exs'] : '.php|.inc|.phtml').'" style="width:398px;"><p></p>';
echo '操作: <input type="submit" style="width:80px;" value="scan"><p></p>';
echo '</form>';
if(file_exists($_POST['dir']) && $_POST['exs']) {
    $dir = strdir($_POST['dir'].'/');
    $exs = '/('.str_replace('.','\\.',$_POST['exs']).')/i';
    echo antivirus($dir,$exs,$matches) ? '</br ><p></p>扫描完毕!' : '</br > <p></p>扫描中断';
}
?>
</html>
