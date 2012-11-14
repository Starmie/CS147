<?php

session_start();

function bytesToSize1024($bytes, $precision = 2) {
    $unit = array('B','KB','MB');
    return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), $precision).' '.$unit[$i];
}

$sFileName = $_FILES['image_file']['name'];
$sFileType = $_FILES['image_file']['type'];
$sFileSize = bytesToSize1024($_FILES['image_file']['size'], 1);
$sFileExtension = pathinfo($sFileName, PATHINFO_EXTENSION);

include("config.php");
$message = $_POST['message'];
$user = 'anonymous';
if (isset($_SESSION['username'])) {
	$user = $_SESSION['username'];
}
$date = date('Y-m-d H:i:s', time());
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$query = "INSERT INTO `c_cs147_astabile`.`messages` (`id`, `user`, `text`, `image`, `date`, `location`, `score`) VALUES (NULL, '{$user}', '{$message}', '{$sFileExtension}', '{$date}', GeomFromText('POINT({$latitude} {$longitude})'), '0');";
mysql_query($query);
$id = mysql_insert_id();

move_uploaded_file($_FILES['image_file']['tmp_name'], "uploads/{$id}.".$sFileExtension);
header("Location: read.php?sort=new&ascending=0");
?> 