<?php
    /**
     *  该文件定义了获取用户配置项的函数
    */

    /* 获取检测目录或文件的路径 */
    function getScanPath()
    {
        $detectPath = "";

        if (isset($_POST["DetectPath"]) && !empty($_POST["DetectPath"]))
        {
            $detectPath = realpath($_POST["DetectPath"]);
            if (empty($detectPath))
            {
                echo $_POST["DetectPath"].": Path doesn't exist!";
                exit;
            }
        }
        else
        {
            echo "Please input a Path!";
            exit;
        }

        return $detectPath;
    }

    /* 获取是否检测子目录配置 */
    function getIsScanSubDir()
    {
        $isDetectSubDir = true;

        if (!isset($_POST["DetectSubDir"]))
        {
            $isDetectSubDir = false;
        }

        return $isDetectSubDir;
    }

    /* 根据用户配置，获取日志文件目录 */
    function getLogFilePath()
    {
        $logFilePath = "";

        if (isset($_POST["LogFilePath"]) && !empty($_POST["LogFilePath"]))
        {
            $logFilePath = $_POST["LogFilePath"];
        }
        else
        {
            /* 默认文件路径 */
            $logFilePath = dirname(__FILE__)."/"."ResultLog";
        }

        return $logFilePath;
    }

    /* 根据用户配置，获取带扫描的威胁函数集合 */
    function getScanFunctions()
    {
        $scan_functions = array();

        if (isset($_POST["vector"]))
        {
            require_once dirname(__FILE__)."/../config/sinks.php";

            switch ($_POST['vector'])
            {
                case 'xss':
                    $scan_functions = $F_XSS;
                    break;
                case 'httpheader':
                    $scan_functions = $F_HTTP_HEADER;
                    break;
                case 'fixation':
                    $scan_functions = $F_SESSION_FIXATION;
                    break;
                case 'code':
                    $scan_functions = $F_CODE;
                    break;
                case 'ri':
                    $scan_functions = $F_REFLECTION;
                    break;
                case 'file_read':
                    $scan_functions = $F_FILE_READ;
                    break;
                case 'file_affect':
                    $scan_functions = $F_FILE_AFFECT;
                    break;
                case 'file_include':
                    $scan_functions = $F_FILE_INCLUDE;
                    break;
                case 'exec':
                    $scan_functions = $F_EXEC;
                    break;
                case 'database':
                    $scan_functions = $F_DATABASE;
                    break;
                case 'xpath':
                    $scan_functions = $F_XPATH;
                    break;
                case 'ldap':
                    $scan_functions = $F_LDAP;
                    break;
                case 'connect':
                    $scan_functions = $F_CONNECT;
                    break;
                case 'other':
                    $scan_functions = $F_OTHER;
                    break;
                case 'unserialize':
                    {
                        $scan_functions = $F_POP;
                    }
                    break;
                case 'client':
                    $scan_functions = array_merge(
                        $F_XSS,
                        $F_HTTP_HEADER,
                        $F_SESSION_FIXATION
                    );
                    break;
                case 'server':
                    $scan_functions = array_merge(
                        $F_CODE,
                        $F_REFLECTION,
                        $F_FILE_READ,
                        $F_FILE_AFFECT,
                        $F_FILE_INCLUDE,
                        $F_EXEC,
                        $F_DATABASE,
                        $F_XPATH,
                        $F_LDAP,
                        $F_CONNECT,
                        $F_POP,
                        $F_OTHER
                    );
                    break;
                case 'all':
                default:
                    $scan_functions = array_merge(
                        $F_XSS,
                        $F_HTTP_HEADER,
                        $F_SESSION_FIXATION,
                        $F_CODE,
                        $F_REFLECTION,
                        $F_FILE_READ,
                        $F_FILE_AFFECT,
                        $F_FILE_INCLUDE,
                        $F_EXEC,
                        $F_DATABASE,
                        $F_XPATH,
                        $F_LDAP,
                        $F_CONNECT,
                        $F_POP,
                        $F_OTHER
                    );
                    break;
            }
        }

        return $scan_functions;
    }

    /* 获取检测级别:1 --- 需要检测威胁函数是否调用威胁参数；2 --- 不检测威胁函数是否调用威胁参数 */
    function getDetectVerbosity()
    {
        $verbosity = 1;
        if (isset($_POST['verbosity']))
        {
            $verbosity = $_POST['verbosity'];
        }

        return $verbosity;
    }