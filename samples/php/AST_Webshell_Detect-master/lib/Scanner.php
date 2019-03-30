<?php

    namespace Scanner;

    require_once dirname(__FILE__)."/../config/general.php";
    require_once dirname(__FILE__)."/../vendor/autoload.php";
    require_once dirname(__FILE__)."/Analyzer.php";
    require_once dirname(__FILE__)."/ASTBuilder.php";
    require_once dirname(__FILE__)."/Logger.php";

    use ASTBuilder\ASTBuilder;
    use Analyzer\ASTTraverser;
    use Analyzer\ASTNodeChecker;
    use Logger\Logger;

    /**
     * webshell扫描器定义，用于集成其他检测组件
    */
    class Scanner
    {
        /* AST构建器 */
        private $ASTBuilder;

        /* AST遍历器 */
        private $ASTTraverser;

        /* 节点检查器 */
        private $ASTNodeChecker;

        /* 日志记录器 */
        private $logger;

        /* 检测效果监视器 */
        private $detectMonitor;

        /* 检测结果数组 */
        private $results;

        /* 待检测文件 */
        private $scanFiles;

        /* include的本地文件，在源文件检测完后检测include的文件 */
        private $includeFiles;

        /* 扫描路径 */
        private $scanPath;

        /* 是否扫描子目录 */
        private $isScanSubDirs;

        /**
         * 初始化各组件
         */
        public function __construct($scanPath, $isScanSubDirs, $logFilePath, $scanFunctions)
        {
            /* 创建各检测组件 */
            $this->ASTBuilder      = new ASTBuilder();
            $this->ASTTraverser    = new ASTTraverser();
            $this->ASTNodeChecker  = new ASTNodeChecker($scanFunctions);
            $this->logger          = new Logger($logFilePath);
            $this->detectMonitor   = new DetectionMonitor($logFilePath);

            $this->results         = array();
            $this->scanFiles       = array();
            $this->includeFiles    = array();

            $this->scanPath        = $scanPath;
            $this->isScanSubDirs   = $isScanSubDirs;

            /* 关联遍历器和节点检查器 */
            $this->ASTTraverser->addVisitor($this->ASTNodeChecker);
        }


        /* main function 扫描目录，解析、检测每一个文件 */
        public function run()
        {
            global $FILE_TYPES;
            $this->scanFiles = $this->getScanFiles($this->scanPath, $this->isScanSubDirs);

            /* 记录所有待检测文件 */
            $this->detectMonitor->detectFiles = $this->scanFiles;

            /* 限制检测文件的数量 */
            if (count($this->scanFiles) > MAX_SCAN_FILECOUNT)
            {
                die("Warning: scan file count exceed limits!");
            }

            foreach ($this->scanFiles as $file)
            {
                /* 检测单个文件 */
                $this->scanFile($file, false);
                $this->logger->outputToFile($file, false);

                /* 记录AST构建成功但未成功检测的文件和成功检测的文件 */
                if (($this->logger->result[$file]["isSucceeded"] == false) &&
                    ($this->logger->result[$file]["isASTBuildFailed"] == false) &&
                    ($this->logger->result[$file]["isHasPattern"] == true))
                {
                    /* 未成功检测，但是存在威胁函数或威胁参数特征 */
                    $this->detectMonitor->hasPatternFiles[] = $this->logger->file;
                }
                elseif ($this->logger->result[$file]["isSucceeded"] == true)
                {
                    $this->detectMonitor->detectedFiles[] = $this->logger->file;
                }
                elseif ($this->logger->result[$file]["isASTBuildFailed"] == false)
                {
                    $this->detectMonitor->undetectedFiles[] = $this->logger->file;
                }

                /* 继续检测该文件中include的文件 */
                if (isset($this->includeFiles[$file]))
                {
                    foreach ($this->includeFiles[$file] as $includeFile)
                    {
                        if (in_array(substr($includeFile, strrpos($includeFile, '.')), $FILE_TYPES) &&
                             file_exists($includeFile))
                        {
                            $this->scanFile($includeFile, true);
                            $this->logger->outputToFile($includeFile, true);
                        }
                    }
                    unset($this->includeFiles[$file]);
                }
            }

            /* 输出检测效果信息 */
            $this->detectMonitor->outputDetectInfo();
        }

        /**
         * 扫描待检测目录，获取待检测的所有文件
         *
         * @param string $path          获取待扫描的文件路径
         * @param bool   $isScanSubdirs 是否需要扫描子目录
         * @return string[]             待扫描文件路径数组
        */
        public function getScanFiles($path, $isScanSubdirs)
        {
            global $FILE_TYPES;
            $result = array();

            if (is_dir($path))
            {
                $handle = opendir($path);

                if ($handle)
                {
                    while (false !== ($file = readdir($handle)))
                    {
                        if ($file !== '.' && $file !== '..')
                        {
                            $name = $path . '/' . $file;
                            if (is_dir($name) && $isScanSubdirs)
                            {
                                $ar = $this->getScanFiles($name, true);
                                foreach ($ar as $value)
                                {
                                    if (in_array(substr($value, strrpos($value, '.')), $FILE_TYPES))
                                    {
                                        $result[] = realpath($value);
                                    }
                                }
                            }
                            elseif (in_array(substr($name, strrpos($name, '.')), $FILE_TYPES))
                            {
                                $result[] = realpath($name);
                            }
                        }
                    }
                    closedir($handle);
                }
            }
            elseif (is_file($path) && in_array(substr($path, strrpos($path, '.')), $FILETYPES))
            {
                $result[] = realpath($path);
            }

            return $result;
        }

        /**
         * 检测单个文件
         */
        public function scanFile($filePath, $isIncluded)
        {
            $this->logger->setFile($filePath, $isIncluded);
            $ASTBuildstart = microtime(true);

            try
            {
                /* 生成AST */
                $AST = $this->ASTBuilder->parser->parse(file_get_contents($filePath));
                if ((null === $AST) || ((count($AST) == 1) && ($AST[0]->getType() == "Stmt_InlineHTML")))
                {
                    /* AST构建失败 */
                    $this->detectMonitor->ASTBuildFailedFiles[] = $filePath;
                    $this->logger->result[$filePath]["isASTBuildFailed"] = true;
                    return ;
                }
            }
            catch (\Exception $e)
            {
                /* AST构建失败 */
                $this->detectMonitor->ASTBuildFailedFiles[] = $filePath;
                $this->logger->result[$filePath]["isASTBuildFailed"] = true;
                return ;
            }

            /* 记录AST构建时间 */
            $this->detectMonitor->ASTBuildTime += microtime(true) - $ASTBuildstart;

            /* 遍历AST，进行节点检查 */
            $ASTAnalysisstart = microtime(true);
            $this->ASTNodeChecker->scanFile = $filePath;
            if($this->ASTTraverser->traverse($AST))
            {
                /* 记录结果 */
                foreach ($this->ASTNodeChecker->results as $key => $values)
                {
                    foreach ($values as $value)
                    {
                        $this->logger->resultLog($key, $value["lineNum"], $value["taintedParam"]);
                    }
                }

                /* 记录检测文件中include的文件,include文件中的include不再检测 */
                if ($isIncluded == false)
                {
                    $this->includeFiles[$filePath] = array();
                    foreach ($this->ASTNodeChecker->includeFiles as $includeFile)
                    {
                        $this->includeFiles[$filePath][] = $includeFile;
                    }
                }
            }

            /* 记录AST分析时间 */
            $this->detectMonitor->ASTAnalysisTime += microtime(true) - $ASTAnalysisstart;
        }
    }

    /* 检测效果监视类 */
    class DetectionMonitor
    {
        /* 所有检测文件 */
        public $detectFiles;

        /* AST构建失败文件 */
        public $ASTBuildFailedFiles;

        /* 成功检测的文件 */
        public $detectedFiles;

        /* 未成功检测，但是存在威胁函数或威胁参数特征的文件 */
        public $hasPatternFiles;

        /* 未成功检测的文件 */
        public $undetectedFiles;

        /* AST构建时间 */
        public $ASTBuildTime;

        /* AST分析时间 */
        public $ASTAnalysisTime;

        /* 日志文件路径 */
        public $logFilePath;

        public function __construct($logFilePath)
        {
            $this->detectFiles = array();
            $this->ASTBuildFailedFiles = array();
            $this->detectedFiles = array();
            $this->hasPatternFiles = array();
            $this->undetectedFiles = array();
            $this->ASTBuildTime = 0;
            $this->ASTAnalysisTime = 0;
            $this->logFilePath = $logFilePath;
        }

        /* 输出检测效果信息*/
        public function outputDetectInfo()
        {
            $newLine = "";

            if (php_sapi_name() == "cli")
            {
                $newLine = "\n";
            }
            else
            {
                $newLine = "<br>";
            }

            printf("Detection Info:".$newLine);
            printf("  Total detect files count:                      %d".$newLine, count($this->detectFiles));
            printf("  Success detect files count:                    %d".$newLine, count($this->detectedFiles));
            printf("  Has threat pattern files count:                %d".$newLine, count($this->hasPatternFiles));
            printf("  Failed detect files(AST build success) count:  %d".$newLine, count($this->undetectedFiles));
            printf("  Failed AST build files count:                  %d".$newLine, count($this->ASTBuildFailedFiles));
            printf("  AST build time:                                %fs".$newLine, $this->ASTBuildTime);
            printf("  AST analysis time:                             %fs".$newLine, $this->ASTAnalysisTime);
            printf("  Path of the result file in detail:             %s".$newLine,  $this->logFilePath);

            printf("Success detect files".$newLine);
            foreach ($this->detectedFiles as $file)
            {
                printf("  %s".$newLine, $file);
            }

            printf("Has threat pattern files".$newLine);
            foreach ($this->hasPatternFiles as $file)
            {
                printf("  %s".$newLine, $file);
            }

            printf("Failed detect files(AST build success)".$newLine);
            foreach ($this->undetectedFiles as $file)
            {
                printf("  %s".$newLine, $file);
            }

            printf("Failed AST build".$newLine);
            foreach ($this->ASTBuildFailedFiles as $file)
            {
                printf("  %s".$newLine, $file);
            }
        }
    }