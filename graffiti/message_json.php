<?php
	header("Content-type: text/javascript");
	include("config.php");
	
	$query = "SELECT * FROM messages";
	
	$amount = 13;
	$sort = $_GET["sort"];
	if ($sort == "popular") {
		$query = $query." ORDER BY score";
	}
	else if ($sort == "new") {
		$query = $query." ORDER BY date";
	}
	else {
		//order by location....
		$query = $query." ORDER BY id";
	}
	
	$ascending = $_GET["ascending"];
	if ($ascending == 1) {
		$query = $query." ASC";
	} else {
		$query = $query." DESC";
	}
	$query = $query." LIMIT ".$amount;
	
	$db_data = array();
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)) {
		array_push($db_data, $row);
	}
	
	echo json_encode($db_data);
?>