package K0U5UK3::Util;
require Exporter;
use Exporter;
use File::Path;
use Digest::MD5;
use K0U5UK3::Error qw(debug warning critical);

@ISA = qw(Exporter);
@EXPORT_OK = qw(read_file cleanup get_md5 concat_path init_dir);

sub read_file($){
   my $file = shift;
   my $text;
   open my $fh, '<', $file or die "Failed read $file : $!\n";
   local $/ = undef;
   $text = <$fh>;
   close($fh);
   return $text;
}

sub cleanup($){
   my $file = shift;
   unlink($file) or critical "Failed unlink $file : $!\n" if -f $file;
}

sub get_md5($){
   my $filename = shift;
   open my $fh, '<', $filename or critical "Failed open $filename : $!\n";
   my $md5 = Digest::MD5->new->addfile($fh)->hexdigest;
   close($fh);
   return $md5;
}

sub concat_path{
   my $concat;
   my @paths = @_;

   foreach my $path (@paths){
      if($path !~ /^\//){
         $path = '/' . $path;
      }
      $concat .= $path;
   }

   return $concat;
}

#ディレクトリがなければ作成する
#再起的に作成することもできる
sub init_dir($){
   my $dir = shift;

   if (!-d $dir){
      mkpath $dir or critical "Failed make $dir : $!";
   }
}

1;
