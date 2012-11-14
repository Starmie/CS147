<!DOCTYPE html>
<html>
	<head>
		<title>Write Post</title>
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
	
	<div data-role="page" data-theme="e">

	<div data-role="header" data-theme="e" data-id="sameheader" data-position="fixed" data-tap-toggle="false">
		<h1>Write</h1>
	</div><!-- /header -->
		
	<div id="content" data-role="content">
		<script src="js/script.js"></script>

		<div class="upload_form_cont">
                <form id="upload_form" enctype="multipart/form-data" method="post" action="submit.php" data-ajax="false">
                    <div>
		          <div><input id="latitude" name="latitude" type="hidden" /></div>
			   <div><input id="longitude" name="longitude" type="hidden" /></div>
			   <div><input type="text" maxlength="1000" autocapitalize="on" name="message" id="message" placeholder="Message" /></div>
                        <div><input type="file" name="image_file" id="image_file" onchange="fileSelected();" /></div>
                    </div>
			<div>
                        <input type="submit" value="Upload" />
                    </div>
                    <div class="errorMessage" id="error">You should select valid image files only!</div>
                    <div class="errorMessage" id="error2">An error occurred while uploading the file</div>
                    <div class="errorMessage" id="abort">The upload has been canceled by the user or the browser dropped the connection</div>
                    <div class="errorMessage" id="warnsize">Your image is too large. Please upload a smaller file.</div>

                    <div id="progress_info">
                        <div id="progress"></div>
                        <div id="progress_percent">&nbsp;</div>
                    </div>
                </form>

            </div>		
	<script type="text/javascript">
		$("#latitude").val(localStorage.getItem("latitude"));
		$("#longitude").val(localStorage.getItem("longitude"));
		function success(position) {
			//alert('success!');
			$("#latitude").val(position.coords.latitude);
			$("#longitude").val(position.coords.longitude);
	    	console.log(position.coords.latitude);
			console.log(position.coords.longitude);
		}
		function error(msg) {
			//alert('uh oh ');
			$("#content").html("Unfortunately, you won't be able to post messages unless you have geolocation enabled. Please check your settings!");
		}
		/*
		if (navigator.geolocation) {
			//alert('getting location');
			navigator.geolocation.getCurrentPosition(success, error);
		} else {
			alert('could not get location...');
			error('unsupported');
		}
		*/
	</script>	
		
	</div><!-- /content -->
	
	<div data-role="footer" data-theme="e" data-id="samefooter" class="nav" data-position="fixed" data-tap-toggle="false">
	<div data-role="navbar" class="nav" data-grid="a">
	<ul>
		<li><a href="read.php?sort=near&ascending=0" id="read" data-icon="search">Read</a></li>
		<li><a href="write.php" id="write" data-icon="plus" class="ui-btn-active ui-state-persist">Write</a></li>
	</ul>
	</div>
	</div><!-- /footer -->
	</div><!-- /page -->
	</body>
</html>