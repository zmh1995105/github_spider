<?php
/**
 * 特征码webshell扫描器
 * @author  Greatfar
 * Date :  2018.09.06
 */

define("SELF",php_self());
error_reporting(E_ERROR);
ini_set('max_execution_time',20000);
ini_set('memory_limit','512M');
$is_log = true;   //日志标记
$is_bak = true;   //备份标记
$is_del = false;  //删除标记
define("LOG_PATH","/tmp/");
define("BAK_PATH","/tmp/");

/**
 * 获取当前脚本名字
 * @return [type] 当前php名字
 */
function php_self(){
  $php_self=substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
  return $php_self;
}

/**
 * 处理window路径为标准路径
 * @param  [type] $dir 路径
 * @return [type]      标准路径
 */
function strdir($str) {
	return str_replace(array('\\','//','//'),array('/','/','/'),chop($str));
}

/**
 * 记录日志
 * @param array $info 日记记录
 */
function log_info(array $info) {
    $time = date('Y-m-d H:i:s');
    array_unshift($info, $time);
    $info = array_map('json_encode', $info);
    file_put_contents(LOG_PATH . 'webshellkill.log', implode(' | ', $info) . "\r\n", FILE_APPEND);
}

/**
 * 备份文件
 * @param string $source_path 源文件
 */
function copy_file($source_path) {
	$file_name = substr($source_path,strrpos($source_path,'/')+1);
	$target_path = BAK_PATH.$file_name."-".time().".bak";
    if(!file_exists(BAK_PATH)) {
        mkdir(BAK_PATH);
    }
	if(copy($source_path, $target_path)) {
        echo "{$source_path}&nbsp;&nbsp;--&gt;&nbsp;&nbsp;<span style='color:#f00;font-weight:bold;'>文件已备份</span>&nbsp;&nbsp;--&gt;&nbsp;&nbsp;{$target_path}<br><br>";
        if($GLOBALS['is_log']) {
            @log_info(array('backup file:',$source_path,$target_path));
        }
    }
}

/**
 * 代码中自定义特征代码进行查杀
 * 正表达式数组
 * 把webshell特征代码以正则表达式的方式写到该数组中，即可查找包含这些字符串的webshell
 * 如下方要查找的webshell包含：base64_decode(base64_decode 或包含 YUhSMGNEb3ZMM0JvY0dGd2F 或包含 thinkapi=base64_decode 或包含 @e#html这些字符串
 */
$matches = array(
    '/base64_decode(base64_decode/i',
	'/YUhSMGNEb3ZMM0JvY0dGd2F/i',
    '/thinkapi=base64_decode/i',
	'/@e#html/i'
);

//如果用户输入了特征代码，使用用户输入的特征代码片段进行查杀
if(isset($_POST['subcode']) && !empty($_POST['subcode'])) {
    $matches = array("/{$_POST['subcode']}/i");
}

/**
 * 查杀webshell主函数
 * @param  [type] $dir     查找目录
 * @param  [type] $exs     扩展名
 * @param  [type] $matches 正则表达式匹配数组,用于特征代码查找
 * @return [type]          返回值，查找完成返回true
 */
function antivirus($dir,$exs,$matches) {
    if(($handle = @opendir($dir)) == NULL) return false;
    while(false !== ($name = readdir($handle))) {
        if($name == '.' || $name == '..') continue;
        $path = $dir.$name;
        if(strstr($name,SELF)) continue;
        if(is_dir($path)) {
            if(is_readable($path)) antivirus($path.'/',$exs,$matches);
        }else {
            if(!preg_match($exs,$name)) continue;
            if(filesize($path) > 10000000) continue;
            $fp = fopen($path,'r');
            $code = fread($fp,filesize($path));
            fclose($fp);
            if(empty($code)) continue;
            foreach($matches as $matche) {
                $array = array();
                preg_match($matche,$code,$array);
                if(!$array) continue;
                if(strpos($array[0],"\x24\x74\x68\x69\x73\x2d\x3e")) continue;
                $len = strlen($array[0]);
                if($len > 6 && $len < 200) {
                    echo '特征 <input type="text" style="width:250px;" value="'.htmlspecialchars($array[0]).'">    '.$path.'<p></p>';
                    if($GLOBALS['is_del']) {
                        if($GLOBALS['is_bak']) {  //备份文件
                        	@copy_file($path);
                        }
                        unlink($path);  //删除文件
                        echo "{$path}&nbsp;&nbsp;--&gt;&nbsp;&nbsp;<span style='color:#f00;font-weight:bold;'>文件已删除</span><br><br>";
                        if($GLOBALS['is_log']) {
                        	@log_info(array('delete file:',$path));
                        }
                    }
                    flush(); ob_flush(); break;
                }
            }
            unset($code,$array);
        }
    }
    closedir($handle);
    return true;
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>webshell killer by Greatfar</title>
</head>
<body>
	<?php
		echo '<form method="POST">';
		echo '扫描路径: <input type="text" name="dir" value="'.($_POST['dir'] ? strdir($_POST['dir'].'/') : strdir($_SERVER['DOCUMENT_ROOT'].'/')).'" style="width:398px;"><p></p>';
		echo '文件类型: <input type="text" name="exs" value="'.($_POST['exs'] ? $_POST['exs'] : '.php|.inc|.phtml').'" style="width:398px;"><p></p>';
		echo '特征代码: <input type="text" name="subcode" value="'.($_POST['subcode'] ? $_POST['subcode'] : '').'" style="width:398px;"><p></p>';
		echo '删除文件: <input type="checkbox" name="isdel" value="true"/><p></p>';
		echo '<input type="submit" style="width:80px;" value="扫描"><p></p>';
		echo '</form>';
		//如果查杀路径存在 && 指定了查杀扩展名 --> 执行扫描
		if(file_exists($_POST['dir']) && $_POST['exs']) {
		    $dir = strdir($_POST['dir'].'/');
		    $exs = '/('.str_replace('.','\\.',$_POST['exs']).')/i';
            if(isset($_POST['isdel']) && $_POST['isdel'] =="true") {
                $is_del = true;
            }
		    echo antivirus($dir,$exs,$matches) ? '<br><p></p>扫描完毕!' : '<br> <p></p>扫描中断';
		}
	?>
</body>
</html>
