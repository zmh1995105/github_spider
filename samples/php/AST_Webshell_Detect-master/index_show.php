<?php
    include_once "lib/Scanner.php";
    include_once "lib/Configure.php";

    define("TEMP_DIR", "temp");
    define("TEMP_FILE", "temp/temp.php");
    define("LOG_FILE_PATH", "ResultLog");
?>

<html>
<head>
    <meta charset="utf-8">
    <title>webshell检测</title>
</head>
<body>

<form action="" method="post">
    <div align="center"><b>检测代码</b><br>
    <textarea id="code" cols="100" rows="25" name="code" wrap="hard"></textarea><br>
    <input type="submit" value="提交">
    </div>
</form>

<script>
    var form = document.getElementById("code");
</script>

<HR style="FILTER: alpha(opacity=100,finishopacity=0,style=3)" width="80%" color=#987cb9 SIZE=3>

<div align="center">
    <b>检测结果</b><br>
</div>

<?php
    $results = "";

    if (isset($_POST["code"]) && !empty($_POST["code"]))
    {
        $code = $_POST["code"];

        /* 创建临时文件 */
        mkdir(TEMP_DIR, 0777);
        $tempFile = fopen(TEMP_FILE, "w");
        fwrite($tempFile, $code);

        $scanner = new \Scanner\Scanner(TEMP_DIR, false, LOG_FILE_PATH);
        $scanner->files = $scanner->getScanFiles($scanner->scanPath , $scanner->isScanSubDirs);
        $scanner->detectMonitor->detectFiles = $scanner->files;

        $scanner->scanFile($scanner->files[0], false);
        foreach ($scanner->logger->result[$scanner->files[0]] as $key => $result)
        {
            if (($key == "isIncluded") || ($key == "isASTBuildFailed"))
            {
                continue;
            }
            $results .= $key.":\n";
            foreach ($result as $param)
            {
                $results .= "&nbsp&nbsp&nbsp&nbsp"."lineNum:".$param["line"]."&nbsp&nbsp&nbsp&nbsp"."param:".$param["param"]."\n";
            }
        }
        $results .= "\n";
        $results = "<div align='center'><textarea cols=\"100\" rows=\"25\" name=\"code\" wrap=\"hard\">".$results."</textarea></div>";

        echo $results;

        /* 继续检测该文件中include的文件 */
        if (isset($scanner->includeFiles[$scanner->files[0]]))
        {
            foreach ($scanner->includeFiles[$scanner->files[0]] as $includeFile)
            {
                if (in_array(substr($includeFile, strrpos($includeFile, '.')), $GLOBALS['configure']['extension']) &&
                    file_exists($includeFile))
                {
                    $scanner->scanFile($includeFile, true);
                }
            }
            unset($scanner->includeFiles[$scanner->files[0]]);
        }

        fclose($tempFile);
        unlink(TEMP_FILE);
        rmdir(TEMP_DIR);
    }
?>

</body>
</html>