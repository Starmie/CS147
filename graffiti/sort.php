<?php
	session_start();
	$_SESSION["ascending"] = $_POST["ascending"];
	$_SESSION["sort"] = $_POST["sort"];	
	header("Location: read.php");
?>