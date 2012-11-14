<?php
session_start();
include("config.php");

$newUser = $_POST['email'];
$newPassword = $_POST['password'];
$newQuery = "INSERT INTO `c_cs147_astabile`.`users` (`email`, `password`) VALUES ('".$newUser."', '".$newPassword."');";
$result = mysql_query($newQuery);
if (empty($newUser) || empty($newPassword)) {
	header("Location: register.php");
} else {
	$_SESSION["username"]=$newUser;
	header("Location: read.php?sort=near&ascending=0");
}
?>

