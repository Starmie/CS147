<!DOCTYPE html>
<html>
	<head>
		<title>Skratch</title>
		<link rel="apple-touch-icon" href="appicon.png" />
		<link rel="apple-touch-startup-image" href="startup.png">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="viewport" content="width=device-width, user-scalable=no" />
		
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

		<link href="style.css" rel="stylesheet" type="text/css">
	</head>

	<body>
	
	<div data-role="page" id="splash">
	<div id="home" data-role="content">
		
		<!--Get user's location: this needs to be done now so php can access it later-->
		<!--A 'refresh location' button could potentially be added anywhere in the app-->
		<script type="text/javascript">
		var url = "read.php?sort=near&ascending=0";
		function success(position) {
			var latitude = position.coords.latitude;
			var longitude = position.coords.longitude;
			localStorage.setItem("latitude", latitude);
			localStorage.setItem("longitude", longitude);
			url = url+"&lat="+latitude+"&lon="+longitude;
			console.log(url);
			window.location = url;
		}
		function error(msg) {
			//indicate app won't be working fully somehow
			window.location = url;
		}
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(success, error);
		} else {
			alert('could not get location...');
			error('unsupported');
		}
		
		</script>
		
	</div><!-- /content -->
	</div><!-- /page -->
	
	</body>
</html>