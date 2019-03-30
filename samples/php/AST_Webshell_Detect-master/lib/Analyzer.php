<?php

namespace Analyzer;

require_once dirname(__FILE__)."/../vendor/autoload.php";
require_once dirname(__FILE__)."/SubTreeNodeChecker.php";
require_once dirname(__FILE__)."/Constructer.php";
require_once dirname(__FILE__)."/ASTBuilder.php";
require_once dirname(__FILE__)."/../config/sources.php";

use PhpParser\Node;
use PhpParser\NodeAbstract;
use PhpParser\NodeTraverser;
use PhpParser\Error;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Node\Name;
use PhpParser\Node\Expr\Include_;

use SubTreeNodeChecker\SubTreeNodeChecker;

/* 节点遍历选项 */
define("TRAVERSE_NOP",            null);                                 //无操作
define("TRAVERSE_STOP_TRAVERSAL", NodeTraverser::STOP_TRAVERSAL);        //停止遍历
define("TRAVERSE_STOP_CHILD",     NodeTraverser::DONT_TRAVERSE_CHILDREN);//跳过子节点的变量
define("TRAVERSE_REMOVE_NODE",    NodeTraverser::REMOVE_NODE);           //删除当前变量的节点

/**
 *  AST遍历器定义
 */
class ASTTraverser extends NodeTraverser
{
    public function __construct()
    {
        parent::__construct();
    }

    public function traverse(array $nodes)
    {
        try
        {
            parent::traverse($nodes);
        }
        catch (Error $e)
        {
            /* 记录出错信息 */
            echo "AST traverse failed!";
            return false;
        }
        return true;
    }
}

/**
 *  AST节点检查器定义
 */
class ASTNodeChecker extends NodeVisitorAbstract
{
    public $results;              //保存全部检测结果
    private $ReflectionResults;   //保存ReflectionFunction实例化结果

    private $parentStack;         //父节点栈

    private $varDependecyUndone;  //未确定依赖关系的变量
    private $varDeclaresGlobal;
    private $globalsFromFunc;
    private $funcDeclares;        //所有自定义函数
    private $taintFuncs;          //漏洞自定义函数

    private $isInFunction;        //当前检测是否在函数定义中
    private $functionName;        //当前函数名
    private $varDeclaresLocal;    //当前函数定义的本地变量
    private $putInGlobalScope;    //函数内global声明的变量

    private $isInClass;           //当前检测是否在类定义中

    private $traverseOption;      //遍历选项

    public $scanFile;             //当前检测文件名
    public $includeFiles;         //检测文件中包含的文件名

    private $scanFunctions;
    private $externalInput;

    public function __construct($scanFunctions)
    {
        $this->scanFunctions = $scanFunctions;
        $this->externalInput["V"] = $GLOBALS["V_USERINPUT"];
        $this->externalInput["F"] = array_merge($GLOBALS["F_FILE_INPUT"], $GLOBALS["F_DATABASE_INPUT"], $GLOBALS["F_OTHER_INPUT"]);
    }

    /* 在AST遍历之前调用 */
    public function beforeTraverse(array $nodes)
    {
        /* 遍历之前初始化 */
        $this->results            = array();
        $this->ReflectionResults  = array();
        $this->parentStack        = array();

        $this->varDependecyUndone = array();
        $this->varDeclaresGlobal  = array();
        $this->funcDeclares       = array();
        $this->taintFuncs         = array();

        $this->isInFunction       = false;
        $this->functionName       = '';
        $this->varDeclaresLocal   = array();
        $this->putInGlobalScope   = array();

        $this->isInClass          = false;

        $this->traverseOption     = TRAVERSE_NOP;

        $this->includeFiles       = array();

        $this->externalInput["F"] = array_merge($GLOBALS["F_FILE_INPUT"], $GLOBALS["F_DATABASE_INPUT"], $GLOBALS["F_OTHER_INPUT"]); //检测过程中会加入新函数，在此处重置
    }

    /* 在AST遍历结束后调用 */
    public function afterTraverse(array $nodes)
    {

    }

    /* 在遍历该节点的子节点前被调用。按照参数类型进行不同的处理。*/
    public function enterNode(Node $node)
    {
        $nodeType = $node->getType();

        /* 重置遍历选项 */
        $this->traverseOption = TRAVERSE_NOP;

        /* 设置节点的父节点属性 */
        if (!empty($this->parentStack))
        {
            $node->setAttribute("parent", $this->parentStack[count($this->parentStack)-1]);
        }

        /* 节点入栈 */
        $this->parentStack[] = $node;

        /* 根据节点类型进行不同的处理 */
        switch ($nodeType)
        {
            case "Expr_Eval":        //eval函数调用
                $this->handleExprEval($node);
                break;
            case "Expr_Include":     //include调用
                $this->handleExprInclude($node);
                break;
            case "Expr_FuncCall":   //函数调用
                $this->handleExprFuncCall($node);
                break;
            case "Expr_New":        //new对象
                $this->handleExprNew($node);
                break;
            case "Expr_MethodCall": //方法调用
                $this->handleExprMethodCall($node);
                break;
            case "Stmt_Function":   //函数声明
                $this->handleStmtFunction($node);
                break;
            case "Stmt_Return":    //函数返回值
                $this->handleStmtReturn($node);
                break;
            case "Expr_AssignRef":
			case "Expr_AssignOp_Concat":
            case "Expr_Assign":     //“=”、“.=”和引用赋值
                $this->handleExprAssign($node);
                break;
            case "Expr_Variable":   //变量
                $this->handleExprVariable($node);
                break;
            case "Scalar_String":   //字符串
                $this->handleScalarString($node);
                break;
            case "Stmt_Global":     //global $a;
                $this->handleStmtGlobal($node);
                break;
            case "Stmt_Class":      //类定义
                $this->handleStmtClass($node);
                break;
            default:
                break;
        }

        /* 返回当前节点的遍历选项 */
        return $this->traverseOption;
    }

    /**
     *  遍历完该节点所有子节点后被调用
     *
     * @param Node $node 遍历到的节点
     */
    public function leaveNode(Node $node)
    {
        $nodeType = $node->getType();

        /* 根据不同节点类型进行不同的清理处理 */
        switch ($nodeType)
        {
            case "Stmt_Function":
                $this->finishStmtFunction($node);
                break;
            case "Expr_AssignRef":
            case "Expr_AssignOp_Concat":
            case "Expr_Assign":
                $this->finishExprAssign($node);
                break;
            case "Stmt_Class":
                $this->finishStmtClass($node);
                break;
            default:
                break;
        }

        /* 节点出栈 */
        array_pop($this->parentStack);
    }

    /* 处理类型为Expr_Eval(eval函数调用)的节点 */
    private function handleExprEval(Node $node)
    {
        /* 只需获取参数子树的威胁信息 */
        $threatInfo = $this->getSubTreeThreatInfo($node->expr);

        /* 添加漏洞节点到函数定义 */
        if ($this->isInFunction)
        {
            $this->addVulnNodeToFunc("eval", $threatInfo->threatParams, $threatInfo->funcParamDepend, $node->getLine());
        }

        /* 记录结果 */
        $this->recordResult(array("eval"), $threatInfo->threatParams, $node->getLine());

        /* 跳过子树的遍历 */
        $this->traverseOption = TRAVERSE_STOP_CHILD;
    }

    /**
     *  处理类型为Expr_Include类型的节点
     */
    private function handleExprInclude(Node $node)
    {
        if ($this->getNodeType($node->expr)== "Scalar_String")
        {
            $includeFile = $node->expr->value;
            $parts = parse_url($includeFile);

            /* 判断是否为远程文件 */
            if (array_key_exists("scheme", $parts) || array_key_exists("host", $parts))
            {
                /* 得到include类型 */
                if ($node->type == Include_::TYPE_INCLUDE)
                {
                    $taintFunc = "include";
                }
                elseif ($node->type == Include_::TYPE_INCLUDE_ONCE)
                {
                    $taintFunc = "include_once";
                }
                elseif ($node->type == Include_::TYPE_REQUIRE)
                {
                    $taintFunc = "require";
                }
                elseif ($node->type == Include_::TYPE_REQUIRE_ONCE)
                {
                    $taintFunc = "require_once";
                }

                /* 结果记录 */
                $this->results[$taintFunc][] = array("lineNum" => $node->getLine(), "taintedParam" => $includeFile);
            }
            /* 本地文件 */
            else
            {
                /* 当前只处理include相对路径和绝对路径 */
                if (stripos($includeFile, "/") === 0)
                {
                    $includeFilePath = $includeFile;
                }
                else
                {
                    $includeFilePath = realpath(dirname($this->scanFile).'/'.$includeFile);
                }

                if(!empty($includeFilePath))
                {
                    $this->includeFiles[] = $includeFilePath;
                }
            }
        }

        /* 跳过子节点的遍历 */
        $this->traverseOption = TRAVERSE_STOP_CHILD;
    }

    /**
     *  处理类型为Expr_FuncCall的节点
     */
    private function handleExprFuncCall(Node $node)
    {
        $threatInfo   = new \ThreatInfo();

        /* 直接函数名调用 */
        if ($this->getNodeType($node->name) == "Name")
        {
            $funcName = $node->name->parts[0];

            /* 函数为预定义威胁函数或者被污染的自定义函数 */
            if (isset($this->scanFunctions[$funcName]) || in_array($funcName, $this->taintFuncs))
            {
                $keyParamsPos = $this->getKeyParamPos($threatInfo->threatFuncs);
                $threatInfo->threatFuncs[] = $funcName;
            }

            /* 将自定义函数内global声明的变量添加到全局变量列表中 */
            if (isset($this->funcDeclares[$funcName]) && isset($this->globalsFromFunc[$funcName]))
            {
                foreach ($this->globalsFromFunc[$funcName] as $var)
                {
                    $this->varDeclaresGlobal[$var->name] = $var;
                }
            }
        }
        /* 其他形式调用 */
        else
        {
            $keyParamsPos = array();

            /* 查找函数名子树的威胁信息 */
            $funcNameThreatInfo = $this->getSubTreeThreatInfo($node->name);
            if (empty($funcNameThreatInfo->threatFuncs) && empty($funcNameThreatInfo->threatParams))
            {
                $threatInfo->threatFuncs[] = "Unknown";
                $keyParamsPos[0] = 0;
            }
            elseif (!empty($funcNameThreatInfo->threatFuncs))
            {
                $threatInfo->threatFuncs = $funcNameThreatInfo->threatFuncs;
                $keyParamsPos = $this->getKeyParamPos($threatInfo->threatFuncs);
            }
            else
            {
                /* 外部输入也可能作为函数名，并且需要扫描所有位置的参数 */
                $threatInfo->threatFuncs = $funcNameThreatInfo->threatParams;
                $keyParamsPos[0] = 0;
            }

            $threatInfo->funcParamDepend = array_merge($threatInfo->funcParamDepend, array_diff($funcNameThreatInfo->funcParamDepend, $threatInfo->funcParamDepend));
        }

        /* 继续检测参数部分 */
        if (!empty($threatInfo->threatFuncs) && !empty($keyParamsPos))
        {
            foreach ($node->args as $key => $value)
            {
                if (in_array($key+1, $keyParamsPos) || ($keyParamsPos[0] == 0))
                {
                    $threatInfoTemp = $this->getSubTreeThreatInfo($node->args[$key]);
                    $threatInfo->threatParams    = array_merge($threatInfo->threatParams, array_diff($threatInfoTemp->threatParams, $threatInfo->threatParams));
                    $threatInfo->funcParamDepend = array_merge($threatInfo->funcParamDepend, array_diff($threatInfoTemp->funcParamDepend, $threatInfo->funcParamDepend));
                }
            }
        }

        /* 添加漏洞节点到函数定义 */
        if ($this->isInFunction && !empty($threatInfo->threatFuncs))
        {
            $this->addVulnNodeToFunc(implode(" ", $threatInfo->threatFuncs), $threatInfo->threatParams, $threatInfo->funcParamDepend, $node->getLine());
        }

        /* 添加到未确定依赖关系的变量中 */
        $this->addThreatInfoToDepenUndone($threatInfo->threatFuncs, $threatInfo->threatParams, $threatInfo->funcParamDepend);

        /* 跳过子节点的遍历 */
        $this->traverseOption = TRAVERSE_STOP_CHILD;

        /* 结果记录 */
        $this->recordResult($threatInfo->threatFuncs, $threatInfo->threatParams, $node->getLine());
    }

    /**
     * 处理Expr_New类节点
     */
    private function handleExprNew(Node $node)
    {
        $threatInfo = new \ThreatInfo();

        /* 目前只处理ReflectionFunction类 */
        if (($this->getNodeType($node->class) != "Name") ||
            ($node->class->parts[0] != "ReflectionFunction"))
        {
            return ;
        }

        $className = $node->class->parts[0];

        switch ($className)
        {
            case "ReflectionFunction":
                /* 第一个参数为字符串，且为威胁函数名 */
                if (($this->getNodeType($node->args[0]->value) == "Scalar_String") &&
                    (isset($this->scanFunctions[$node->args[0]->value->value]) || in_array($node->args[0]->value->value, $this->taintFuncs)))
                {
                    $threatInfo->threatFuncs[] = $node->args[0]->value->value;
                }
                /* 参数为其他形式 */
                else
                {
                    /* 获取第一个参数的威胁函数和威胁参数 */
                    $threatInfo = $this->getSubTreeThreatInfo($node->args[0]);
                    if (empty($threatInfo->threatFuncs))
                    {
                        $threatInfo->threatFuncs = $threatInfo->threatParams;
                    }
                }

                if (!empty($threatInfo->threatFuncs))
                {
                    $parentNode  = $node->getAttribute("parent");
                    $keyParamPos = $this->getKeyParamPos($threatInfo->threatFuncs);

                    /* 如果父节点是赋值语句Expr_Assign，说明new的对象赋给了变量 */
                    if (($parentNode->getType() == "Expr_Assign") &&
                        ($parentNode->var->getType() == "Expr_Variable") &&
                        is_string($parentNode->var->name))
                    {
                        /* 记录reflection的对象赋值，在遍历结束后记录结果日志 */
                        $reflectionTaint                 = new \ReflectionFunc();
                        $reflectionTaint->cmdExec        = $threatInfo->threatFuncs;
                        $reflectionTaint->args           = array(); //在调用invoke方法时记录参数
                        $reflectionTaint->assignVariable = $parentNode->var->name;
                        $reflectionTaint->keyParamPos    = $keyParamPos;
                        $reflectionTaint->line           = $node->getLine();
                        $this->ReflectionResults[$parentNode->var->name] = $reflectionTaint;
                    }
                    /* 如果父节点是方法调用Expr_MethodCall，且调用方法为invoke */
                    elseif (($parentNode->getType() == "Expr_MethodCall") && ($parentNode->name == "invoke"))
                    {
                        /* 如果父节点是方法调用，并且调用的方法为invoke，判断调用参数是否为威胁参数 */
                        foreach ($parentNode->args as $key => $value)
                        {
                            if (in_array($key+1, $keyParamPos) || ($keyParamPos[0] == 0))
                            {
                                $threatInfoTemp = $this->getSubTreeThreatInfo($parentNode->args[$key]);
                                $threatInfo->threatParams = array_merge($threatInfo->threatParams, array_diff($threatInfoTemp->threatParams, $threatInfo->threatParams));
                            }
                        }

                        /* 结果记录 */
                        $this->recordResult($threatInfo->threatFuncs, $threatInfo->threatParams, $node->getLine());
                    }
                }
                break;
            default:
                break;
        }

        /* 跳过子节点的遍历 */
        $this->traverseOption = TRAVERSE_STOP_CHILD;
    }

    /* 处理Expr_MethodCall类型的节点 */
    private function handleExprMethodCall(Node $node)
    {
        $threatInfo = new \ThreatInfo();

        /* 变量方式方法调用$a->method(),并且该变量为被污染的ReflectionResults对象 */
        if (($node->var->getType() == "Expr_Variable") &&
            (is_string($node->var->name)) &&
            (isset($this->ReflectionResults[$node->var->name])))
        {
            /* 目前只检测invoke方法 */
            if (is_string($node->name) && ($node->name == "invoke"))
            {
                $ReflectionResults = $this->ReflectionResults[$node->var->name];

                /* 获取参数的威胁参数类型 */
                foreach ($node->args as $key => $value)
                {
                    if (in_array($key+1, $ReflectionResults->keyParamPos) || ($ReflectionResults->keyParamPos[0] == 0))
                    {
                        $threatInfoTemp = $this->getSubTreeThreatInfo($node->args[$key]);
                        $threatInfo->threatParams = array_merge($threatInfo->threatParams, array_diff($threatInfoTemp->threatParams, $threatInfo->threatParams));
                    }
                }

                /* 记录结果 */
                $this->recordResult($this->ReflectionResults[$node->var->name]->cmdExec, $this->ReflectionResults[$node->var->name]->args, $node->getLine());
            }
        }

        /* 跳过子节点的遍历 */
        $this->traverseOption = TRAVERSE_STOP_CHILD;
    }

    /* 处理Stmt_Function类型的节点，暂不处理函数内定义函数 */
    private function handleStmtFunction(Node $node)
    {
        if ($this->isInFunction == false)
        {
            $this->isInFunction = true;
        }
        else
        {
            /* 不处理函数内定义函数，设置遍历选项，跳过子节点的遍历 */
            $this->traverseOption = TRAVERSE_STOP_CHILD;
            return ;
        }

        /* 记录函数名 */
        $this->functionName = $node->name;

        /* 添加函数定义 */
        $funcStmt = new \FuncDeclare;
        $funcStmt->name = $node->name;
        $this->funcDeclares[$funcStmt->name] = &$funcStmt;

        /* 记录函数参数 */
        foreach ($node->params as $pos => $parameter)
        {
            if (is_string($parameter->name))
            {
                $funcStmt->parameters[$pos+1] = $parameter->name;
            }
        }
    }

    /* 处理Stmt_Returnl类型的节点 */
    private function handleStmtReturn(Node $node)
    {
        $threatInfo = $this->getSubTreeThreatInfo($node);

        /* 自定义函数的返回值被外部输入污染，将该函数加入到外部输入函数列表中 */
        if (!empty($threatInfo->threatParams))
        {
            /* 记录与函数返回值相关联的外部输入 */
            $funcDeclare = $this->funcDeclares[$this->functionName];
            $funcDeclare->returnParams = array_merge($funcDeclare->returnParams, array_diff($threatInfo->threatParams, $funcDeclare->returnParams));

            /* 将该函数加入到外部输入函数列表中 */
            if (!in_array($this->functionName, $this->externalInput["F"]))
            {
                $this->externalInput["F"][] = $this->functionName;
            }
        }
    }

    /* 处理Expr_Assign类型的节点 */
    private function handleExprAssign(Node $node)
    {
        $variable        = new \VarDeclare();
        $variable->line  = $node->getLine();

        /* $var =  */
        if (($node->var->getType() == "Expr_Variable") && is_string($node->var->name))
        {
            $variable->name = $node->var->name;

            /* 添加变量定义到varDependecyUndone属性内，后续遍历子节点的过程中确定依赖关系 */
            $this->varDependecyUndone[$variable->name] = $variable;

            /* 设置变量属性，后续跳过左分量变量的检测 */
            $node->var->setAttribute("skip", true);
        }
        /* $var[xxx] =  */
        elseif (($node->var->getType() == "Expr_ArrayDimFetch") && ($node->var->var->getType() == "Expr_Variable"))
        {
            if (is_string($node->var->var->name))
            {
                /* $GLOBALS[xxx] */
                if (($node->var->var->name == "GLOBALS") && ($node->var->dim->getType() == "Scalar_String"))
                {
                    $variable->name = $node->var->dim->value;
                    if ($this->isInFunction)
                    {
                        $this->putInGlobalScope[] = $node->var->dim->value;
                    }
                }
                else
                {
                    $variable->name = $node->var->var->name;
                    $variable->array_key[] = $node->var->dim; //后续再改进
                }

                $this->varDependecyUndone[$variable->name] = $variable;

                /* 设置变量属性，后续跳过左分量变量的检测 */
                $node->var->var->setAttribute("skip", true);
            }
        }
    }

    /* 处理Expr_Variable类型的节点 */
    private function handleExprVariable(Node $node)
    {
        $threatFuncs      = "";
        $threatParams     = "";
        $funcParamDepend  = array();

        /* 跳过当前节点的检查 */
        if ($node->getAttribute("skip", false))
        {
            return ;
        }

        /* 判断变量是否为威胁参数 */
        if (is_string($node->name))
        {
            /* 是否为威胁参数 */
            if (in_array($node->name, $this->externalInput["V"]))
            {
                $threatParams = $node->name;
            }
            /* 自定义变量 */
            else
            {
                $varList = $this->isInFunction ? $this->varDeclaresLocal : $this->varDeclaresGlobal;

                /* 自定义的被污染变量 */
                if (isset($varList[$node->name]) && ($varList[$node->name]->marker == MARKER_RED))
                {
                    $threatFuncs     = $varList[$node->name]->taintFuncs;
                    $threatParams    = $varList[$node->name]->taintParams;
                    $funcParamDepend = $varList[$node->name]->funcParamDepend;
                }
                elseif ($this->isInFunction && in_array($node->name, $this->funcDeclares[$this->functionName]->parameters)) //函数参数
                {
                    $funcParamDepend[] = array_search($node->name, $this->funcDeclares[$this->functionName]->parameters);
                }
            }

            /* 添加威胁信息到未确定依赖关系的变量上 */
            $this->addThreatInfoToDepenUndone($threatFuncs, $threatParams, $funcParamDepend);
        }
    }

    /* 处理Scalar_String类型的节点 */
    private function handleScalarString(Node $node)
    {
        $taintFunc   = '';
        $taintParam  = '';
        $stringValue = $node->value;

        /* 如果字符串的值是威胁函数或威胁参数名称，则认为其污染了依赖该节点的所有变量和函数 */
        if (isset($this->scanFunctions[$stringValue]))
        {
            $taintFunc = $stringValue;
        }

        if (in_array($stringValue, $this->externalInput["V"]) || in_array($stringValue, $this->externalInput["F"]))
        {
            $taintParam = $stringValue;
        }

        /* 记录威胁信息到函数和变量的undone list上 */
        $this->addThreatInfoToDepenUndone($taintFunc, $taintParam, array());
    }

    /* 处理Stmt_Global类型的节点 */
    private function handleStmtGlobal(Node $node)
    {
        if ($this->isInFunction)
        {
            /* 记录函数内的global变量声明 */
            $this->globalsFromFunc[$this->functionName] = array();

            foreach ($node->vars as $var)
            {
                if (($var->getType() == "Expr_Variable") && (is_string($var->name)))
                {
                    if ((isset($this->varDeclaresGlobal[$var->name])))
                    {
                        /* 覆盖掉旧的本地变量定义 */
                        $this->varDeclaresLocal[$var->name] =  clone $this->varDeclaresGlobal[$var->name];
                    }

                    $this->putInGlobalScope[] = $var->name;
                }
            }
        }
    }

    /* 处理Stmt_Class类型的节点 */
    private function handleStmtClass(Node $node)
    {
        /* 后续实现类中方法的检测 */
        $this->isInClass      = true;
        $this->traverseOption = TRAVERSE_STOP_CHILD;
    }

    /* StmtFunction类型节点子节点遍历结束处理 */
    private function finishStmtFunction(Node $node)
    {
        /* 函数定义结束，清空本地变量 */
        if (($this->isInFunction == true) && ($this->functionName == $node->name))
        {
            $this->isInFunction = false;
            $this->functionName = '';
            $this->varDeclaresLocal = array();
            $this->putInGlobalScope = array();
        }
    }

    private function finishExprAssign(Node $node)
    {
        /* 把varDeclareUndone上的变量定义移动到全局或本地变量定义中 */
        if (($node->var->getType() == "Expr_Variable") && is_string($node->var->name) && isset($this->varDependecyUndone[$node->var->name]))
        {
            $variableName = $node->var->name;
            if ($this->isInFunction)
            {
                /* 直接赋值，覆盖之前的定义 */
                $this->varDeclaresLocal[$variableName] = $this->varDependecyUndone[$variableName];

                if(isset($this->putInGlobalScope[$variableName]))
                {
                    $this->globalsFromFunc[$this->functionName] = $this->varDependecyUndone[$variableName];
                }
            }
            else
            {
                $this->varDeclaresGlobal[$variableName] = $this->varDependecyUndone[$variableName];
            }
            unset($this->varDependecyUndone[$variableName]);
        }
    }

    private function finishStmtClass(Node $node)
    {
        $this->isInClass      = false;
    }

    /* 新建遍历器来遍历指定子树，获取子树的威胁信息 */
    private function getSubTreeThreatInfo($subAST)
    {
        $traverser = new ASTTraverser();
        $visitor   = new SubTreeNodeChecker($this->isInFunction, $this->varDeclaresGlobal, $this->varDeclaresLocal, $this->funcDeclares, $this->scanFunctions, $this->externalInput);

        if (!is_array($subAST))
        {
            $subAST = array($subAST);
        }

        /* 关联遍历器和检查器，并开始遍历操作 */
        $traverser->addVisitor($visitor);
        $traverser->traverse($subAST);

        return $visitor->threatInfo;
    }

    /* 把威胁函数和威胁参数加到所有未确定依赖的变量和函数上 */
    private function addThreatInfoToDepenUndone($threatFunc, $threatParam, $funcParamDepend)
    {
        if (empty($threatFunc) && empty($threatParam) && empty($funcParamDepend))
        {
            return ;
        }

        /* 添加到var list */
        foreach ($this->varDependecyUndone as $key => $var)
        {
            /* 添加威胁函数 */
            if (!empty($threatFunc) && is_string($threatFunc) && !in_array($threatFunc, $var->taintFuncs))
            {
                $this->varDependecyUndone[$key]->taintFuncs[] = $threatFunc;
            }
            elseif (!empty($threatFunc) && is_array($threatFunc))
            {
                $this->varDependecyUndone[$key]->taintFuncs = array_merge($var->taintFuncs, array_diff($threatFunc, $var->taintFuncs));
            }

            /* 添加威胁参数 */
            if (!empty($threatParam) && is_string($threatParam) && !in_array($threatParam, $var->taintParams))
            {
                $this->varDependecyUndone[$key]->taintParams[] = $threatParam;
            }
            elseif (!empty($threatParam) && is_array($threatParam))
            {
                $this->varDependecyUndone[$key]->taintParams = array_merge($var->taintParams, array_diff($threatParam, $var->taintParams));
            }

            /* 确定marker标记 */
            if (count($this->varDependecyUndone[$key]->taintFuncs) || count($this->varDependecyUndone[$key]->taintParams))
            {
                $this->varDependecyUndone[$key]->marker = MARKER_RED;
            }

            /* 添加函数参数关联位置 */
            $this->varDependecyUndone[$key]->funcParamDepend = array_merge($this->varDependecyUndone[$key]->funcParamDepend, array_diff($funcParamDepend, $this->varDependecyUndone[$key]->funcParamDepend));
        }
    }

    /* 添加漏洞节点到函数定义 */
    private function addVulnNodeToFunc($taintFunc, array $taintParam, array $funcParamDepend, $line)
    {
        /* 新建漏洞节点 */
        $vulnNode = new \VulnNode();
        $vulnNode->taintFunc  = $taintFunc;
        $vulnNode->taintParam = $taintParam;
        $vulnNode->funcParamDepend = $funcParamDepend;
        $vulnNode->line = $line;

        $this->funcDeclares[$this->functionName]->vulnTree[] = $vulnNode;

        if (!empty($vulnNode->funcParamDepend))
        {
            $funcParamDependOld = $this->funcDeclares[$this->functionName]->funcParamDepend;
            $this->funcDeclares[$this->functionName]->funcParamDepend = array_merge($funcParamDependOld, array_diff($vulnNode->funcParamDepend, $funcParamDependOld));
            $this->funcDeclares[$this->functionName]->marker |= FUNC_TAINT_PARAM;
        }

        if (!empty($taintParam))
        {
            $this->funcDeclares[$this->functionName]->marker |= FUNC_TAINT_VUL;
        }

        if (!in_array($this->functionName, $this->taintFuncs))
        {
            $this->taintFuncs[] = $this->functionName;
        }
    }

    /* 获取指定威胁函数的重要参数位置 */
    private function getKeyParamPos(array $threatFuncs)
    {
        $keyParamPos = array();

        foreach ($threatFuncs as $func)
        {
            if (isset($this->scanFunctions[$func])) //预定义威胁函数
            {
                if ($this->scanFunctions[$func][0][0] == 0) //所有参数位置
                {
                    $keyParamPos[0] = 0;
                }
                $keyParamPos = array_merge($keyParamPos, array_diff($this->scanFunctions[$func][0], $keyParamPos));
            }
            elseif (in_array($func, $this->taintFuncs)) //被污染的自定义威胁函数
            {
                $funcDeclare = $this->funcDeclares[$func];
                if ($funcDeclare->marker & FUNC_TAINT_PARAM)
                {
                    $keyParamPos = array_merge($keyParamPos, array_diff($funcDeclare->funcParamDepend, $keyParamPos));
                }
            }
        }

        return $keyParamPos;
    }

    /* 结果记录 */
    private function recordResult(array $threatFuncs, array $threatParams, $line)
    {
        $taintFunc  = empty($threatFuncs) ? "Unknown":implode(" ", $threatFuncs);
        $taintParam = empty($threatParams) ? "Unknown":implode(" ", $threatParams);
        $this->results[$taintFunc][] = array("lineNum" => $line, "taintedParam" => $taintParam);
    }

    /* 获取节点类型 */
    private function getNodeType(Node $node)
    {
        return $node->getType();
    }
}