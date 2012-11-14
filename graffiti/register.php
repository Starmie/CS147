<!DOCTYPE html>
<html>
	<head>
		<title>Individual Post</title>
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
	
	<div data-role="page" data-theme="e" data-add-back-btn="true">

	<div data-role="header" data-theme="e">
	<h1>Register</h1>

	</div><!-- /header -->
		
	<div data-role="content">	
		<form enctype="multipart/form-data" action="submit_registration.php" method="POST" id="login">
			<input type="text" autocapitalize="on" name="email" id="email" value="" placeholder="Your Email"/>
			<input type="password" autocapitalize="on" name="password" id="password" value="" placeholder="Password"/>
			<input type="submit" value="Register" />					
		</form>
	</div>
	<h2> Already have an account?<a href="login.php">[login]</a> </h2>
	</div>		
	</div><!-- /content -->
<?php
	include("footer.php");
	?>
	</div><!-- /page -->
	

	</body>
</html>