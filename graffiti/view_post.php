<?php
	session_start();
?>

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
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

		
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>

	<body>
	
	<div data-role="page" data-theme="e" data-add-back-btn="true">
	<?php
		include("config.php");
		$id = $_GET["id"];
		$query = "SELECT * FROM messages WHERE id=".$id."";
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result);
		$db = $row["date"];
		$timestamp = strtotime($db);
		$date = date("m-d-Y", $timestamp);
	?>

	<div data-role="header" data-theme="e" data-id="sameheader" data-position="fixed" data-tap-toggle="false">
		<?php
			echo "<h1>Post from ".$date."</h1>";
		?>
	</div><!-- /header -->
		
	<div data-role="content">

		<div class="image">
			<?php
				if (file_exists("uploads/".$row['image'])) {
					echo "<img class='image' src='uploads/".$row["image"]."' width='280'/>";
				}
			?>
		</div>
	
		<?php
			echo "<p>".$row["text"]."</p>";
		    $loc_result = mysql_query("SELECT AsText(location) FROM messages WHERE id=".$_GET["id"]);
			$geom_str = mysql_fetch_assoc($loc_result);
			$post_lat;
			$post_lon;
			foreach($geom_str as $value) {
				$lat_start = strpos($value, "(");
				$lon_start = strpos($value, " ")+1;
				$post_lat = substr($value, 6, $lon_start-7);
				$post_lon = substr($value, $lon_start, strlen($value)-$lon_start-1);
			}
			$latitude = $_SESSION["latitude"];
			$longitude = $_SESSION["longitude"];
			$distance = ( 3959 * acos( cos( deg2rad($latitude) ) * cos( deg2rad( $post_lat ) ) * cos( deg2rad( $post_lon ) - deg2rad($longitude) ) + sin( deg2rad($latitude) ) * sin( deg2rad( $post_lat ) ) ) );
			$distance = $distance * 5280;  //convert from miles to feet
			$distance = round($distance);
			echo "<p>About ".$distance." feet away</p>";
		?>

<!-- This is where the map gets inserted -->
		<div id="mapcanvas" style="height:280px; width:280px;"></div>

	<script type="text/javascript">

	$('div').live('pageshow',function(event, ui){
	
		var map;
		    
		    var latitude = <?php
			echo $post_lat;
			?>;
		    var longitude = <?php
			echo $post_lon;
			?>;

		    var latlng = new google.maps.LatLng(latitude, longitude);

		    var myOptions = {
		        zoom: 16,
		        center: latlng,
		        mapTypeControl: false,
		        navigationControlOptions: {
		            style: google.maps.NavigationControlStyle.SMALL
		        },
		        mapTypeId: google.maps.MapTypeId.ROADMAP
		    };
		
		    map = new google.maps.Map(document.getElementById('mapcanvas'), myOptions);
		
		    var marker = new google.maps.Marker({
		        position: latlng,
		        map: map,
		        title: "Message location",
		    });

				});
		</script>
	</div><!-- /content -->
	<div data-role="footer" data-theme="e" data-id="samefooter" class="nav" data-position="fixed" data-tap-toggle="false">
	<div data-role="navbar" class="nav" data-grid="a">
	<ul>
		<li><a href="read.php" id="read" data-icon="search" class="ui-btn-active ui-state-persist">Read</a></li>
		<li><a href="write.php" id="write" data-icon="plus" >Write</a></li>
	</ul>
	</div>	</div><!-- /page -->
	

	</body>
</html>