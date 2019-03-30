<html>
<head>
<title>PHP Test</title>
</head>
<body>
<?php

$num=0;
$handler = opendir('D:/xampp/htdocs/upload');
while( ($filename = readdir($handler)) !== false )  {
    
      if($filename != "." && $filename != "..") {
      
        $num++;
      
      }
}
$num1=$num-1;
$num2=$num+1;
$num=$num2;
$dir="./upload/";
$dirname=$dir.$num;
mkdir($dirname);

if ($_FILES["file"]["error"] > 0)
{
    echo "Error：" . $_FILES["file"]["error"] . "<br>";
}
else
{
    echo "filename: " . $_FILES["file"]["name"] . "<br>";
    echo "filetype: " . $_FILES["file"]["type"] . "<br>";
    echo "filesize: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
   
	  if (file_exists($dirname . $_FILES["file"]["name"]))
        {
            echo $_FILES["file"]["name"] . " file exist ";
        }
        else
		{
			
            // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
            move_uploaded_file($_FILES["file"]["tmp_name"], $dirname."/".$_FILES["file"]["name"]);
            echo "file located in: " . $dirname;
        }
	unset($out);
	$c=exec("python D:/xampp/htdocs/detect.py",$out);
	echo "<br>";

	echo "Detection result:";
	if($out[0] = 0){
	echo "It is a safe file.";
	echo "<br>";
	}
	if($out[0] = 1)
	{
	echo "It is a suspicious webshell file.";
	echo "<br>";
	}
}
?>


<a href="http://127.0.0.1/index.html">Go back</a>

</body>
</html>