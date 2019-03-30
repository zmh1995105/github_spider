<?php
	session_start();

	if(isset($_SESSION['logout'])) {
		unset($_SESSION['logout']);
		session_destroy();
		header('WWW-Authenticate: Basic realm="Login"');
		header('HTTP/1.0 401 Unauthorized');
		exit(0);
	}

	if(isset($_POST['logout'])) {
		unset($_POST['logout']);
		$_SESSION['logout'] = 1;
		header('Location: /');
		exit(0);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		html, body{
			margin:0;
		    height: 99vh;
		}
	</style>
	<script>
		function clearForm() {
			document.getElementById('cmd').value = '';
		}
	</script>
</head>
<body bgcolor="#000000" style="color:#19DA00">
	<div style="height: 10%;">
		<form action="console.php" method="POST" target="console" onsubmit="setTimeout('clearForm()', 200); return true" autocomplete="off" style="float:left;">
			<?php echo $_SERVER['REMOTE_USER'] ?>$ <input id="cmd" name="cmd" type="text" onblur="this.focus()" style="border-style:none; background-color:#000000; color:#19DA00" size=100 autofocus>
			<input id="send" name="send" type="submit" value="Send" style="margin:0px;"/>
			<input id="Reset" name="Reset" type="submit" value="Reset" style="margin-left:10px;"/>
		</form>
		<form method="POST" action="" style="float:left;">
			<input id="logout" name="logout" type="submit" value="Logout" style="margin-left:10px";/>
		</form>
	</div>
	<div style="height:90%">
		<iframe id="console" name="console" src="console.php" width="100%" style="height: 100%; border: none"></iframe>
	</div>
</body>
</html>
