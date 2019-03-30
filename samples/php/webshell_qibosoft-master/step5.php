<?php

	$File_webshell = "admin.php";
/*
	if( file_exists( $File_webshell ) ) 
	{
		echo "Can found the file. <br>";
		$file_content = fopen( $File_webshell , "rb");
		if ( $file_content != NULL )
		{
			echo "Can read this.";
		}
		else
		{
			echo "But, Can't not read the content.";
		}

	}
	else
	{
		echo "Can't not fonud the file.";
	}

	echo "<br>"
*/

	$Webshell_all 		= "";
	$Webshell_process	= "";

	$Webshell_all = fopen("admin.php","rb");
	fread($Webshell_all,2160);
	$Webshell_process = explode( "\t",base64_decode( fread( $Webshell_all,272 ) ) ); 
	print_r( $Webshell_all );
	print_r( $Webshell_process ); 
?>