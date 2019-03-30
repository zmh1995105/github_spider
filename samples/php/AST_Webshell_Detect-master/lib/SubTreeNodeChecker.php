<?php
namespace SubTreeNodeChecker;

require_once dirname(__FILE__)."/../vendor/autoload.php";
require_once dirname(__FILE__)."/Constructer.php";

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

/**
* 子树的节点检查，用于找出子树中存在的威胁信息。无法确定威胁函数或参数则返回Unknown
*/
class SubTreeNodeChecker extends NodeVisitorAbstract
{
    /* 保存子树的威胁信息 */
    public $threatInfo;

    /* 全局定义的变量 */
    private $varDeclaresGlobal;

    /* 函数定义 */
    private $funcDeclares;

    /* 当前检测是否在函数中 */
    private $isInFunction;

    /* 当前函数定义的本地变量 */
    private $varDeclaresLocal;

    /* 需检测的威胁函数 */
    private $scanFunctions;

    /* 需检测的外部输入 */
    private $externalInput;

    public function __construct($isInFunction, $varDeclaresGlobal, $varDeclaresLocal, $funcDeclares, $scanFunctions, $externalInput)
    {
        $this->isInFunction      = $isInFunction;
        $this->varDeclaresGlobal = $varDeclaresGlobal;
        $this->varDeclaresLocal  = $varDeclaresLocal;
        $this->funcDeclares      = $funcDeclares;

        $this->scanFunctions     = $scanFunctions;
        $this->externalInput     = $externalInput;

        $this->threatInfo        = new \ThreatInfo();
    }

    public function enterNode(Node $node)
    {
        $nodeType = $node->getType();

        switch ($nodeType)
        {
            case "Expr_Variable":
                $this->handleExprVariable($node);
                break;
            case "Expr_FuncCall":
                $this->handleExprFuncCall($node);
                break;
            case "Scalar_String":
                $this->handleScalarString($node);
                break;
            default:
                break;
        }
    }

    private function handleExprVariable(Node $node)
    {
        if (is_string($node->name))
        {
            $variableName = $node->name;

            /* 直接判断变量是否为威胁参数 */
            if (in_array($variableName, $this->externalInput["V"]) && !in_array($variableName, $this->threatInfo->threatParams))
            {
                $this->threatInfo->threatParams[] = $variableName;
            }
            else
            {
                /* 获取变量定义列表中的威胁信息 */
                $varList = $this->isInFunction ? $this->varDeclaresLocal:$this->varDeclaresGlobal;

                if (isset($varList[$variableName]))
                {
                    if ($varList[$variableName]->marker == MARKER_RED)
                    {
                        $this->threatInfo->threatFuncs  = array_merge($this->threatInfo->threatFuncs, array_diff($varList[$variableName]->taintFuncs, $this->threatInfo->threatFuncs));
                        $this->threatInfo->threatParams = array_merge($this->threatInfo->threatParams, array_diff($varList[$variableName]->taintParams, $this->threatInfo->threatParams));
                    }

                    $this->threatInfo->funcParamDepend = array_merge($this->threatInfo->funcParamDepend, array_diff($varList[$variableName]->funcParamDepend, $this->threatInfo->funcParamDepend));
                }
            }
        }
    }

    private function handleExprFuncCall(Node $node)
    {
        /* 直接函数名调用 */
        if ($node->name->getType() == "Name")
        {
            $funcName = $node->name->parts[0];

            /* 函数为威胁函数 */
            if (in_array($funcName, $this->scanFunctions) && !in_array($funcName, $this->threatInfo->threatFuncs))
            {
                $this->threatInfo->threatFuncs[] = $funcName;
            }
            /* 函数为用户自定义函数 */
            elseif (array_key_exists($funcName, $this->funcDeclares))
            {
                $funcThreatInfo = $this->getFuncParamDependThreatInfo($funcName);
                $this->threatInfo->threatFuncs  = array_merge($this->threatInfo->threatFuncs,  array_diff($funcThreatInfo->threatFuncs, $this->threatInfo->threatFuncs));
                $this->threatInfo->threatParams = array_merge($this->threatInfo->threatParams, array_diff($funcThreatInfo->threatParams,$this->threatInfo->threatParams));
            }
        }
        /* 变量形式调用:$a() */
        elseif(($node->name->getType() == "Expr_Variable") && (is_string($node->name->name)))
        {
            $variableName = $node->name->name;

            /* 变量为外部输入变量 */
            if (in_array($variableName, $this->externalInput["V"]) && !in_array($node->name->name, $this->threatInfo->threatParams))
            {
                $this->threatInfo->threatParams[] = $variableName;
            }
            else
            {
                /* 获取变量定义列表中的威胁信息 */
                $varList = $this->isInFunction ? $this->varDeclaresLocal:$this->varDeclaresGlobal;

                if (isset($varList[$variableName]))
                {
                    $this->threatInfo->threatFuncs  = array_merge($this->threatInfo->threatFuncs, array_diff($varList[$variableName]->taintFuncs, $this->threatInfo->threatFuncs));
                    $this->threatInfo->threatParams = array_merge($this->threatInfo->threatParams, array_diff($varList[$variableName]->taintParams, $this->threatInfo->threatParams));

                    $this->threatInfo->funcParamDepend = array_merge($this->threatInfo->funcParamDepend, array_diff($varList[$variableName]->funcParamDepend, $this->threatInfo->funcParamDepend));
                }
            }
        }
    }

    /* 对于代码中字符串的处理，查找字符串中是否存在威胁函数或参数来确定其威胁信息 */
    private function handleScalarString(Node $node)
    {
        $taintedFunc  = "";
        $taintedParam = "";
        $stringValue  = $node->value;

        /* 在字符串中查找威胁函数 */
        foreach ($this->scanFunctions as $function =>$value)
        {
            if (!(strpos($stringValue, $function) === false))
            {
                $taintedFunc = $function;
                break;
            }
        }

        /* 在字符串中查找威胁参数 */
        foreach ($this->externalInput["V"] as $param)
        {
            if (!(strpos($stringValue, $param) === false))
            {
                $taintedParam = $param;
                break;
            }
        }

        if (!empty($taintedParam))
        {
            foreach ($this->externalInput["F"] as $param)
            {
                if (!(strpos($stringValue, $param) === false))
                {
                    $taintedParam = $param;
                    break;
                }
            }
        }

        /* 记录威胁信息 */
        if (!empty($taintedFunc) && !in_array($taintedFunc, $this->threatInfo->threatFuncs))
        {
            $this->threatInfo->threatFuncs[] = $taintedFunc;
        }

        if (!empty($taintedParam) && !in_array($taintedParam, $this->threatInfo->threatParams))
        {
            $this->threatInfo->threatParams[] = $taintedParam;
        }
    }

    /* 获取自定义函数中与参数相关联的威胁信息 */
    private function getFuncParamDependThreatInfo($funcName)
    {
        $threatInfo = new \ThreatInfo();

        if (!isset($this->funcDeclares[$funcName]) && !($this->funcDeclares[$funcName]->marker & FUNC_TAINT_PARAM))
        {
            return $threatInfo;
        }

        foreach ($this->funcDeclares[$funcName]->vulnTree as $vulnNode)
        {
            if (!empty($vulnNode->funcParamDepend))
            {
                if (!empty($vulnNode->taintFunc) && !in_array($vulnNode->taintFunc, $threatInfo->threatFuncs))
                {
                    $threatInfo->threatFuncs[] = $vulnNode->taintFunc;
                }

                if (!empty($vulnNode->taintParam) && !in_array($vulnNode->taintParam, $threatInfo->threatParams))
                {
                    $threatInfo->threatParams[] = $vulnNode->taintParam;
                }
            }
        }

        return $threatInfo;
    }
}