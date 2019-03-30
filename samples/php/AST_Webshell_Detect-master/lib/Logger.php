<?php

namespace Logger;

/**
 * 结果记录和处理
*/
class Logger
{
    public    $result;       //记录日志结果
    public    $file;         //检测文件名
    public    $logFilePath;  //日志文件路径
    public    $logFileHandle;//日志文件句柄

    function __construct($logFilePath)
    {
        $this->result  = array();
        $this->file    = '';
        $this->logFilePath   = $logFilePath;
        $this->logFileHandle = fopen($logFilePath, "w");
    }

    function __destruct()
    {
        fclose($this->logFileHandle);
    }

    /**
     * 初始化文件的检测结果
     */
    public function setFile($filePath, $isIncluded)
    {
        $this->file = $filePath;
        $this->result = array();
        $this->result[$this->file] = array();
        $this->result[$this->file]["isIncluded"] = $isIncluded;  //是否为include的文件
        $this->result[$this->file]["isASTBuildFailed"] = false; //是否AST构建失败
        $this->result[$this->file]["isSucceeded"] = false;      //是否成功检测为webshell
        $this->result[$this->file]["isHasPattern"] = false;     //是否存在威胁函数或威胁参数特征
    }

    /**
     * 检测结果日志记录到文件的结果集中
     */
    public function resultLog($func, $line, $param)
    {
        $this->result[$this->file][$func] = isset($this->result[$this->file][$func]) ? $this->result[$this->file][$func] : array();
        $this->result[$this->file][$func][] = array('line' => $line, 'param' => $param);
    }

    /**
     * 获取检测结果集
     */
    public function getReport()
    {
        return $this->result;
    }

    /* 输出所有文件的检测结果到文件 */
    public function outputToFile($filePath, $isIncluded)
    {
        $path = sprintf("FilePath: %s\n", $filePath);
        $included = sprintf("isIncluded: %s\n", $isIncluded ? "true" : "false");
        fwrite($this->logFileHandle, $path.$included);

        if ($this->result[$filePath]["isASTBuildFailed"] == true)
        {
            /* AST构建失败 */
            fwrite($this->logFileHandle, "  AST build failed!\n\n");
            return;
        }

        foreach ($this->result[$filePath] as $key => $result)
        {
            if (($key == "isIncluded") || ($key == "isASTBuildFailed") || ($key == "isSucceeded") || ($key == "isHasPattern"))
            {
                continue;
            }

            $this->result[$this->file]["isHasPattern"] = true;//存在威胁函数或威胁参数特征

            fwrite($this->logFileHandle, "  ".$key.": \n");
            foreach ($result as $param)
            {
                fwrite($this->logFileHandle, "     lineNum: ".$param["line"]."   param: ".$param["param"]."\n");
                if (($key != "Unknown") && ($param["param"] != "Unknown"))
                {
                    /* 危险函数调用了危险参数，认为是webshell */
                    $this->result[$this->file]["isSucceeded"] = true;
                }
            }
        }
        fwrite($this->logFileHandle, "\n");
        fflush($this->logFileHandle);
    }

    /* 输出单个文件的检测结果到终端 */
    public function outputToTerminal($filePath, $isIncluded)
    {
        echo "FilePath: ".$filePath."\n";
        echo "IsIncluded: ".($isIncluded ? "true":"false")."\n";
        foreach ($this->result[$filePath] as $key => $result)
        {
            if (($key == "isIncluded") || ($key == "isASTBuildFailed"))
            {
                continue;
            }
            echo $key.": \n";
            foreach ($result as $param)
            {
                echo "     lineNum: ".$param["line"]."   param: ".$param["param"]."\n";
            }
        }
        echo "\n";
    }
}