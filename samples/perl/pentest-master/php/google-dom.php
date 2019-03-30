<?php
/**
by Tu5b0l3d | IndoXploit
blog.indoxploit.or.id
Usage: edit the $dork value
**/
error_reporting(0);
print "[ ========================================== ]\n";
        print "Google Dorker With DOM\n";
        print "Coded by: Ilham ( ID-IM )\n";
        print "Greetz: IndoXploit - LinuxSec\n";
        print "[ ========================================== ]\n\n";
error_reporting(0);
function save($data){
		$fp = @fopen("hasil.txt", "a") or die("cant open file");
		fwrite($fp, "$data\n");
		fclose($fp);
}
$links = array(); 
$dork = "linuxsec";
for($i=0;$i<=1000;$i+=10){
$xml = new DOMDocument('1.0', "UTF-8");

$xml->loadHTMLFile("http://www.google.com/search?q=".urlencode($dork)."&start=$i");
echo "Captcha Block. Try again later\n";	

    foreach($xml->getElementsByTagName('cite') as $link) { 
    	
    	$su =  "http://$link->nodeValue";
    	
    	$ahh = parse_url($su, PHP_URL_HOST);
    	if(in_array($ahh, $links) or preg_match("/blogspot/",$ahh)) {
   			 echo "$ahh element is in the array\n";
}
else{
	save("$ahh");
	$links[] = $ahh;
	print_r($links);
}
}
}
 

?>
