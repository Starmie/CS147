<?php
	session_start();
	if(!isset($_SESSION["latitude"])) {
		$_SESSION["latitude"] = $_GET["lat"];
	}
	if(!isset($_SESSION["longitude"])) {
		$_SESSION["longitude"] = $_GET["lon"];
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Reading Page</title>
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

	<div data-role="header" data-theme="e" data-id="sameheader" class="nav" data-position="fixed" data-tap-toggle="false">
		<?php
			$sort = $_GET["sort"];
			if ($sort == "near") {
				echo "<h1>Nearby Posts</h1>";
			} else if ($sort == "popular") {
				echo "<h1>Popular Posts</h1>";
			} else {
				echo "<h1>Newest Posts</h1>";
			}
		?>
		<?php
			if (!isset($_SESSION["username"])) {
				echo "<a href='login.php' data-icon='check' class='ui-btn-right'>Login</a>";
			}
			else {
				echo "<h1 class='ui-btn-right'>Hi ", $_SESSION["username"],"! <a href='logout.php' data-icon='check'>Logout</a>",  "</h1>";
			}
		?>		
<!--		<a href="login.php" data-icon="check" class="ui-btn-right">Login</a>
-->		
		<div id="sorting" data-role="navbar" data-iconpos="right">
		<ul>
		<?php
			$location_args = "&lat=".$_GET["lat"]."&lon=".$_GET["lon"];
			$ascending = $_GET["ascending"];
			$next = abs($ascending-1);
			$icon = "arrow-u";
			if ($next == 1) {
				$icon = "arrow-d";
			}
			echo "<li>";
			if ($sort == "near") {
				echo "<a href='read.php?sort=near&ascending=".$next."' data-role='button' class='ui-btn-active' data-icon='".$icon."'>Nearest</a>";
			} else {
				echo "<a href='read.php?sort=near&ascending=0' data-role='button'>Nearest</a>";
			}
			echo "</li>";
			/*
			echo "<li>";
			if ($sort == "popular") {
				echo "<a href='read.php?sort=popular&ascending=".$next."' data-role='button' class='ui-btn-active' data-icon='".$icon."'>Popular</a>";
			} else {
				echo "<a href='read.php?sort=popular&ascending=0' data-role='button'>Popular</a>";
			}
			echo "</li>";
			*/
			echo "<li>";
			if ($sort == "new") {
				echo "<a href='read.php?sort=new&ascending=".$next."' data-role='button' class='ui-btn-active' data-icon='".$icon."'>Newest</a>";
			} else {
				echo "<a href='read.php?sort=new&ascending=0' data-role='button'>Newest</a>";
			}
			echo "</li>";
		?>
		</ul>
		</div>
	</div><!-- /header -->

	<div id="content" data-role="content">
		<!--
		<div id="history">
			<?php
				if (isset($_SESSION["username"])) {
					echo "<a href='user.php'>History</a>";
				}
			?>
		</div>
		-->
		
		<!-- Get messages from database here -->
		
		<!-- Javascript,which could potentially replace the php below it. But it's not working yet :( -->
		<!--
		<div id="js_entries"></div>
		<script type="text/javascript">
			function getURLParameter(name) {
 			   return decodeURI(
		        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
			    );
			}
			 $(document).live('pageinit', function(event){
                $.getJSON('message_json.php', {sort: getURLParameter('sort'), ascending: getURLParameter('ascending')}, function(data) {
                        $.each(data, function(key, val) {                        
                    	  var html = "<div class='entry' id='"+val.id+"'>";
                    	  html = html + "<div class='message'>" + val.text + "</div>";
                          var url = "view_post.php?id=" + val.id;
                          var link = "<a href='"+url+"'>see more</a>";
                          html = html + "<div class='details'>xxx feet away score: " +
                          	val.score + " posted: " + val.date +" "+ link + "</div>";
                          html = html + "</div>";
                          
                          var entry = $("<div>", {
                          	"class": "entry",
                          	style: "cursor: pointer",
                          	click: function() { $.mobile.changePage(url); }
                          });
                          var message = $("<div>", {
                          	"class": "message",
                          	text: val.text
                          });
                          var details = $("<div>", {
                          	"class": "details",
                          	text: "xxx feet away score: " + val.score + "posted: " +
                          		val.date
                          });
                          entry.append(message);
                          entry.append(details);
                          $('#js_entries').append(entry);
                        });
                });
	        });
		</script>
		-->
		
		<?php
		include("config.php");
		$latitude = $_SESSION["latitude"];
		$longitude = $_SESSION["longitude"];
		$query = "SELECT id, user, text, image, date, score, ( 3959 * acos( cos( radians(".$latitude.") ) * cos( radians( X(location) ) ) * cos( radians( Y(location) ) - radians(".$longitude.") ) + sin( radians(".$latitude.") ) * sin( radians( X(location) ) ) ) ) AS distance FROM messages HAVING distance < 1";
		$amount = 13;
		$sort = $_GET["sort"];
		/** Build query  **/
		if ($sort == "popular") {
			$query = $query." ORDER BY score";
		}
		else if ($sort == "new") {
			$query = $query." ORDER BY date";
		}
		else {
			/*** Order by location ***/
			$query = $query." ORDER BY -distance";
			$result = mysql_query($query);
			$row = mysql_fetch_assoc($result);
		}
		if ($_GET["ascending"] == 1) {
			$query = $query." ASC";
		} else {
			$query = $query." DESC";
		}
		$query = $query." LIMIT ".$amount;
		$result = mysql_query($query);
		while ($row = mysql_fetch_assoc($result)) {
			echo "<div class='entry'>";
			if (file_exists("uploads/".$row['image'])) {
				echo "<img class='thumbnail' src='uploads/".$row["image"]."' width='250'/>";
			}
			echo "<div class='message'>";
			echo $row["text"];
			echo "</div>";
			echo "<div class='details'>";
			$loc_result = mysql_query("SELECT AsText(location) FROM messages WHERE id=".$row["id"]);
			$geom_str = mysql_fetch_assoc($loc_result);
			$post_lat;
			$post_lon;
			foreach($geom_str as $value) {
				$lat_start = strpos($value, "(");
				$lon_start = strpos($value, " ")+1;
				$post_lat = substr($value, 6, $lon_start-7);
				$post_lon = substr($value, $lon_start, strlen($value)-$lon_start);
			}
			$distance = ( 3959 * acos( cos( deg2rad($latitude) ) * cos( deg2rad( $post_lat ) ) * cos( deg2rad( $post_lon ) - deg2rad($longitude) ) + sin( deg2rad($latitude) ) * sin( deg2rad( $post_lat ) ) ) );
			$distance = $distance * 5280;  //convert from miles to feet
			$distance = round($distance);
			echo "About ".$distance." feet away";
			//echo " Score: ".$row["score"];
			$db = $row["date"];
			$timestamp = strtotime($db);
			$date = date("m-d-Y", $timestamp);	
			echo " Posted: ".$date;
			echo "\t<a href='view_post.php?id=".$row["id"]."'>see more</a>";
			echo "</div>";
			echo "</div>";
	    }
		?>
		
	</div><!-- /content -->

	<div data-role="footer" data-theme="e" data-id="samefooter" class="nav" data-position="fixed" data-tap-toggle="false">
	<div data-role="navbar" class="nav" data-grid="a">
	<ul>
		<li><a href="read.php" id="read" data-icon="search" class="ui-btn-active ui-state-persist">Read</a></li>
		<li><a href="write.php" id="write" data-icon="plus">Write</a></li>
	</ul>
	</div>
	</div><!-- /footer -->
	</div><!-- /page -->
	
	</body>
</html>