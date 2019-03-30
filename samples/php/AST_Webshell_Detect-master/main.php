<?php

require_once "config/sinks.php";
require_once "lib/UserConfig.php";
require_once "lib/Scanner.php";

/* 确保tokenizer扩展已经被加载 */
if (extension_loaded('tokenizer') === false)
{
    echo 'Please enable the PHP tokenizer extension to run detect.';
    exit;
}

/* 不限制脚本执行时间 */
set_time_limit(0);

/* 获取用户配置各路径 */

$detectPath      = getScanPath();
$isDetectSubDir  = getIsScanSubDir();
$logFilePath     = getLogFilePath();

/*
$scanFunctions   = getScanFunctions();

$detectPath       = "webshell_sample";
$isDetectSubDir   = true;
$logFilePath      = "ResultLog";
*/

$scanFunctions    = array_merge($F_EXEC, $F_CODE, $F_XSS, $F_HTTP_HEADER, $F_SESSION_FIXATION,
    $F_REFLECTION, $F_FILE_READ, $F_FILE_AFFECT, $F_FILE_INCLUDE,
    $F_DATABASE, $F_XPATH, $F_LDAP, $F_CONNECT, $F_POP, $F_OTHER);           //待扫描的威胁函数集合

$verbosity        = 1;                 //检测级别：1 --- 需要检测威胁函数的威胁参数；2 --- 不检测威胁函数的威胁参数；


$scanner = new \Scanner\Scanner($detectPath, $isDetectSubDir, $logFilePath, $scanFunctions);
$scanner->run();