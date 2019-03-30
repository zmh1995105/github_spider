if(isset($_GET["update_chmod"])){
if(change_chmod($_GET["chmod"],$_GET["newchmod"])){
$alert_display=TRUE;
$alert_style="success";
$alert_message="İzinler düzenlendi.";
}else{
$alert_display=TRUE;
$alert_style="danger";
$alert_message="İzinler düzenlenemedi.";    
}
}
if(isset($_GET["update_name"])){
change_name($_GET["rename"],$_GET["newname"]);
}
if(isset($_POST["update_file"])){
if(update_file($_POST["edit"],$_POST["content"])){
$alert_display=TRUE;
$alert_style="success";
$alert_message="Dosya düzenlendi.";
}else{
$alert_display=TRUE;
$alert_style="danger";
$alert_message="Dosya düzenlenemedi.";    
}
}

if(isset($_POST["new_file"])){
if(create_file($_POST["newfile"],$_POST["content"])){
$alert_display=TRUE;
$alert_style="success";
$alert_message="Dosya oluşturuldu.";
$location='?path='.$_GET["path"].'&view='.$_GET["path"].$_POST["newfile"];
header("Location: $location");
}else{
$alert_display=TRUE;
$alert_style="danger";
$alert_message="Dosya oluşturulamadı.";    
}
}

if(isset($_POST["new_folder"])){
if(create_folder($_POST["newfolder"])){
$alert_display=TRUE;
$alert_style="success";
$alert_message="Klasör oluşturuldu.";
$location='?path='.$_GET["path"];
header("Location: $location");
}else{
$alert_display=TRUE;
$alert_style="danger";
$alert_message="Klasör oluşturulamadı.";    
}
}

if(isset($_POST["uploadfile"])){
if(isset($_POST["zip"])){
$zip=TRUE;
}else {$zip=FALSE;}
if(upload($zip)){
$alert_display=TRUE;
$alert_style="success";
$alert_message="Dosya yüklendi.";
$location='?path='.$_GET["path"];
header("Location: $location");
}else{
$alert_display=TRUE;
$alert_style="danger";
$alert_message="Dosya yüklenemedi.";    
}
}
if(isset($_GET["delete"])){
if(delete_file($_GET['delete'])){
$alert_display=TRUE;
$alert_style="success";
$alert_message="Silindi.";
}else{
$alert_display=TRUE;
$alert_style="danger";
$alert_message="Silinemedi.";    
}
}

if(isset($_GET["download"])){
return download_file($_GET['download'],FALSE);
}

if(isset($_GET["downloadgz"])){
return download_file($_GET['downloadgz'],TRUE);
}
