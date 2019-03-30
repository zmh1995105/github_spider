<?php
session_start();
$id=$_POST['id'];
$pw=$_POST['pw'];
$mysqli=mysqli_connect("localhost", "jaycho", "Upper$$546", "ETI");

$check="SELECT * FROM user_info WHERE userid='$id'";
$result=$mysqli->query($check);
if($result->num_rows==1){
	$row=$result->fetch_array(MYSQLI_ASSOC); //fetch one row as an array
	if($row['userpw']==$pw){
		$_SESSION['userid']=$id;	// make a session variable if login was success
		$_SESSION['name']=$row['name'];
		if(isset($_SESSION['userid']))
		{
			header('Location: ./main.php'); // move a page if login was success
		}
		else {
			echo "failed to save a session";
		}
	}
	else{
		header('Location: ./login_failed.html');
	}
}
else {
	header('Location: ./login_failed.html');
}
?>
