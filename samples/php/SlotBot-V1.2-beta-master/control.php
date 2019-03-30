<?php
/*
 *
 * @author Slotleet
 * @email Slotleet@gmail.com
 * @website Sec4ever.com
 */
if($_GET['get'] == "GET"){
	include("mods/RSS - Take A Look For Latest Vuln's.php");
}
  if (file_exists("validdomain.php")) {
    include("validdomain.php");
	if ($validDomain == "false") {
	  die("Unauthorized Domain: Please contact support.");
	}
  } else {
    die("Missing VALIDDOMAIN.PHP Files: Please contact support.");
  }

  if (file_exists("conf.php")) {
    include("conf.php");
  } else {
    header('Location: setup/');
  }
  
  session_start();
  if (empty($_SESSION['code'])) {
    header( 'Location: index.php' ) ;
    die();
  }


	foreach (glob("static/*.php") as $filename)
	{
		include $filename;
	}

  include("tpl/head.html");
  echo "<CENTER>";
  $obj = new quotes();	
  echo "</CENTER>";
?>
<br><br><br>
<?$obj = new showbot();?>	
<?include("tpl/foot.html");
	
