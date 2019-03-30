function check_login($password){
if(isset($_POST['passwd'])){
$passwd=$_POST['passwd'];
if($passwd == $password){
$_SESSION["password"]=md5($passwd);
$_SESSION["rexlog"]=TRUE;
}}else{
if (isset($_SESSION['password'])){
if($_SESSION['password']===md5($password)){
$_SESSION["rexlog"]=TRUE;
}else{
$_SESSION["rexlog"]=FALSE;
}
if($_SESSION["rexlog"]!=TRUE){
get_login();
die();
}
}else{
get_login();
die();
}}
}

function get_login(){
echo '<form method=POST><input type="password" name="passwd" /><input type="submit" value="Login" /></form>';
}

function logout(){
unset($_SESSION["password"]);
unset($_SESSION["rexlog"]);
session_destroy();
header('Location: ?login');
}

function homedir(){
return realpath(dirname(__FILE__)).'/';}

function homeurl(){
$query = $_SERVER['PHP_SELF'];
$path = pathinfo( $query );
$link = $path['basename'];
return $link;
}
