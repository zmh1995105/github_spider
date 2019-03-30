<?php
$id=$_POST['id'];
$pw=$_POST['pw'];
$pwc=$_POST['pwc'];
$name=$_POST['name'];
$email=$_POST['email'];

if($pw!=$pwc)	// pw is not equal to pw correct string
{
	echo "check the password and password correct string.";
	echo "<a href=signup.html>back page</a>";
	exit();
}

if($id==NULL || $pw==NULL || $name==NULL || $email==NULL)
{
	echo "plz fill out all blanks.";
	echo "<a href=signup.html>back page</a>";
	exit();
}

$mysqli=mysqli_connect("localhost", "jaycho", "Upper$$546", "test2");

$check="SELECT * from user_info WHERE userid='$id'";
$result=$mysqli->query($check);
if($result->num_rows==1)
{
	echo "overlapped ID";
	echo "<a href=signup.html>back page</a>";
	exit();
}

$signup=mysqli_query($mysqli, "INSERT INTO user_info (userid, userpw, name, email) VALUES ('$id', '$pw', '$name', '$email')");
if($signup){
	echo "sign up success!";
	echo "<a href=./logout.php";
}

?>
