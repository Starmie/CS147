<?php
session_start();
include("config.php");

unset($_SESSION["username"]);
header("Location: read.php");

?>
