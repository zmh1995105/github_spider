<?php

define("MARKER_GREEN", 0); //未被污染
define("MARKER_RED", 1);   //被污染

/* 自定义函数的污染类型 */
define("FUNC_TAINT_NONE",   0); //无污染
define("FUNC_TAINT_RETURN", 1); //返回值被外部输入污染
define("FUNC_TAINT_PARAM",  2); //威胁函数参数与自定义函数参数关联
define("FUNC_TAINT_VUL",    4); //自定义函数内存在完整漏洞

/**
 *  reflection类型的威胁函数调用
 */
class ReflectionFunc
{
    public $assignVariable; //分配给的变量
    public $cmdExec;        //威胁函数
    public $keyParamPos;    //后续调用invoke方法时检查的参数位置
    public $line;           //所在行号
}

/**
 * 变量定义
 */
class VarDeclare
{
    public $name;            //变量名
    public $value;
    public $taintFuncs;      //威胁函数名称，不存在则不设置
    public $taintParams;     //威胁参数名称，不存在则不设置
    public $marker;
    public $line;
    public $array_key;
    public $funcParamDepend; //该变量与函数参数相关联的参数位置
    public $dependencies;

    function __construct()
    {
        $this->taintFuncs      = array();
        $this->taintParams     = array();
        $this->marker          = MARKER_GREEN;
        $this->line            = 0;
        $this->array_key       = array();
        $this->funcParamDepend = array();
        $this->dependencies    = array();
    }
}

/* 漏洞节点定义 */
class VulnNode
{
    public $taintFunc;         //威胁函数
    public $taintParam;        //威胁参数
    public $funcParamDepend;   //函数内漏洞依赖函数参数的位置
    public $line;

    public function __construct()
    {
        $this->taintFunc       = "";
        $this->taintParam      = "";
        $this->funcParamDepend = array();
    }
}

/**
 *  函数定义
 */
class FuncDeclare
{
    public $name;
    public $vulnTree;         //函数内的漏洞节点
    public $marker;           //标记，确定污染类型
    public $parameters;
    public $funcParamDepend;  //函数内漏洞依赖的参数位置
    public $returnParams;     //与返回值相关联的外部输入
    public $dependencies;

    function __construct()
    {
        $this->name            = "";
        $this->vulnTree        = array();
        $this->marker          = FUNC_TAINT_NONE;
        $this->parameters      = array();
        $this->funcParamDepend = array();
        $this->returnParams    = array();
        $this->dependencies    = array();
    }
}

/* 子树威胁信息定义 */
class ThreatInfo
{
    public $threatFuncs;
    public $threatParams;
    public $funcParamDepend;//记录子树依赖函数参数的位置

    public function __construct()
    {
        $this->threatFuncs     = array();
        $this->threatParams    = array();
        $this->funcParamDepend = array();
    }
}
