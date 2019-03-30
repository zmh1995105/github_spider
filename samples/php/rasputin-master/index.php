<?php

session_start();

if ( !isset( $_SESSION['username'] ) ) {
	header( 'Location: login.html' );
}

?>

<html>
<head>
	<title>Rasputin</title>

</head>
<body>

	<li><a href="shell.php">Webshell command execution</a></li>
	<li><a href="sudoShell.php">sudo Shell</a></li>
	<li><a href="editor.php">File editor</a></li>
	<li><a href="mysql.php">MySQL query execution</a></li>
	<li><a href="info.php">PHP information</a></li>

	<center>
		<form action="logout.php" method="post">
			<input type="submit" value="logout">
		</form>
	</center>

</body>
</html>
