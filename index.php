<?php
include('db_login.php');
function default_query_db($qstring){
	require('db_login.php');
	/* $db_host='127.0.0.1';
	$db_database='world';
	$db_username='myuser';
	$db_password='mk8t'; */
	//connect to database
	$mysqli = new mysqli($db_host, $db_username, $db_password, $db_database);
	//check for successful connection
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	}else{
		//write query text to variable
		$query = "select * from country";
		//execute query
		$res = $mysqli->query($query);
		if (!$res) {
			die("Cannot make query: <br />(".$mysqli->errno . ")". $mysqli->error);
		}else{
			//fetch data
			echo "<table class=\"countries\">";
			echo "<caption>Countries</caption>";
			echo "<colgroup>";
			echo "<col class=\"code\" />";
			echo "<col class=\"name\" />";
			echo "<col class=\"continent\" />";
			echo "</colgroup>";
			echo "<thead>";
			echo "<tr>";
			echo "<th scope=\"col\">Code</th>";
			echo "<th scope=\"col\">Country</th>";
			echo "<th scope=\"col\">Continent</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			while($row = $res->fetch_assoc()){
				$code = $row["Code"];
				$name = $row["Name"];
				$continent = $row["Continent"];
				echo "<tr>";
					echo "<td>$code</td>";
					echo "<td>$name</td>";
					echo "<td>$continent</td>";
				echo "</tr>";															
			}
			echo "</tbody>";
			echo "</table>";
		}
		$res->close();
	}
}

function query_db($qstring){
	require('db_login.php');
	/*$db_host='127.0.0.1';
	$db_database='world';
	$db_username='myuser';
	$db_passwo rd='mk8t';*/
	//connect to database
	$mysqli = new mysqli($db_host, $db_username, $db_password, $db_database);
	//check for successful connection
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	}else{
		//write query text to variable
		$query = "select * from country";
		//execute query
		$res = $mysqli->query($query);
		if (!$res) {
			die("Cannot make query: <br />(".$mysqli->errno . ")". $mysqli->error);
		}else{
			//fetch data
			echo "<table class=\"countries\">";
			echo "<caption>Countries</caption>";
			echo "<colgroup>";
			echo "<col class=\"code\" />";
			echo "<col class=\"name\" />";
			echo "<col class=\"continent\" />";
			echo "</colgroup>";
			echo "<thead>";
			echo "<tr>";
			echo "<th scope=\"col\">Code</th>";
			echo "<th scope=\"col\">Country</th>";
			echo "<th scope=\"col\">Continent</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			while($row = $res->fetch_assoc()){
				$code = $row["Code"];
				$name = $row["Name"];
				$continent = $row["Continent"];
				echo "<tr>";
					echo "<td>$code</td>";
					echo "<td>$name</td>";
					echo "<td>$continent</td>";
				echo "</tr>";															
			}
			echo "</tbody>";
			echo "</table>";
		}
		$res->close();
	}
}
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>MySQL's World DB Explorer</title>
	<link rel="stylesheet" href="css/styles.css">
</head>
<body>
	<div class="content">
		<div class="header">
			<div class="logo">MySQL's World Database Explorer</div>
		</div>
		<div class="nav">
			<ul>
				<li>Countries</li>
				<li>Cities</li>
			</ul>
		</div>
		<div class="searchForm">
			<form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="GET">
				<label>Search: 
					<input type="text" name="search" />
				</label>
				<input type="submit" value="Go!" />
			</form>
		</div>
		<div class="content">
		<?php
		$search = htmlentities($_GET["search"]);
		$self = htmlentities($_SERVER['PHP_SELF']);
		if ($search != NULL) {
			query_db($search);
		}else{
			default_query_db($search);
		}
		?>
			
		</div>
		<div class="footer">
			<div class="author">Valeria Studio</div>
		</div>
	</div>	
</body>
</html>