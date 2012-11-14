<?php
session_start();
include("config.php");

//$_SESSION["username"] = $_POST['email'];
//$email = $_POST['email'];
$email = mysql_real_escape_string($_POST['email']);
$password = $_POST['password'];
//password = md5(mysql_real_escape_string($_POST['password']));


if(!isset($email) || !isset($password)) {
	header("Location: login.php");

} elseif (empty($email) || empty($password)) {
	header("Location: login.php");
} else {
//	$newQuery = "SELECT * FROM `c_cs147_astabile`.`users` WHERE email='".$email."' AND password='".$password."';";
	$newQuery = "SELECT * FROM `c_cs147_astabile`.`users` WHERE email='$email' AND password='$password'";
	$result = mysql_query($newQuery);
	$rowCheck = mysql_num_rows($result);
	if($rowCheck>0){
		$_SESSION["username"] = $email;
		header("Location: read.php?sort=near&ascending=0");
	}
	else
	{
		header("Location: login.php");
	}
//header("Location: read.php");
}
?>

