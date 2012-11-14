<!DOCTYPE html>
<html>
	<head>
		<title>User Page</title>
		<link rel="apple-touch-icon" href="appicon.png" />
		<link rel="apple-touch-startup-image" href="startup.png">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="viewport" content="width=device-width, user-scalable=no" />
		
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
		
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>

	<body>
	
	<div data-role="page" data-add-back-btn="true">

	<div data-role="header" data-id="sameheader" data-position="fixed" data-tap-toggle="false">
		<h1>Post History</h1>
	</div><!-- /header -->
		
	<div data-role="content">
		<div class="message">
			<p>[myexample1]</p>
			<p>[myexample2]</p>
		<div/>
		<a href="read.php">Back</a>
	</div><!-- /content -->
	<?php
	include("footer.php");
	?>
	</div><!-- /page -->

	</body>
</html>