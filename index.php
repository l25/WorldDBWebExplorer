<?php
include('db_login.php');
function connect(){
	require('db_login.php');
	//connect to database
	return $mysqli = new mysqli($db_host, $db_username, $db_password, $db_database);
}
function get_table_columns($table_name){
	$mysqli = connect();
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	}else{
		$query = "SHOW COLUMNS FROM ".$table_name;
		$res = $mysqli->query($query);
		if (!$res) {
			die("Cannot make query: <br />(".$mysqli->errno . ")". $mysqli->error);
		}else{
			return $res;
		}
		$res->close();
	}
}
function draw_table($res, $table_name){
	get_table_columns();
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
	echo "<tfoot>";
	echo "<tr><td colspan=\"3\">" . $res->num_rows . "</td></tr>";
	echo "<tr>";
	echo "<th scope=\"col\">Code</th>";
	echo "<th scope=\"col\">Country</th>";
	echo "<th scope=\"col\">Continent</th>";
	echo "</tr>";
	echo "</tfoot>";
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
function draw_countries_table(&$res){
	echo "<table class=\"countries\">";
	echo "<caption>Countries</caption>";
	echo "<colgroup>";
	echo "<col class=\"code\" />";
	echo "<col class=\"name\" />";
	echo "<col class=\"continent\" />";
/*	echo "<col class=\"region\" />";
	echo "<col class=\"surfacearea\" />";
	echo "<col class=\"indepyear\" />";
	echo "<col class=\"population\" />";
	echo "<col class=\"lifeexpectancy\" />";
	echo "<col class=\"gnp\" />";
	echo "<col class=\"gnpold\" />";
	echo "<col class=\"localname\" />";
	echo "<col class=\"governmentform\" />";
	echo "<col class=\"headofstate\" />";
	echo "<col class=\"capital\" />";
	echo "<col class=\"code2\" />";*/
	echo "</colgroup>";
	echo "<thead>";
	echo "<tr>";
	echo "<th scope=\"col\">Code</th>";
	echo "<th scope=\"col\">Country</th>";
	echo "<th scope=\"col\">Continent</th>";
/*	echo "<th scope=\"col\">Region</th>";
	echo "<th scope=\"col\">SurfaceArea</th>";
	echo "<th scope=\"col\">IndepYear</th>";
	echo "<th scope=\"col\">Population</th>";
	echo "<th scope=\"col\">LifeExpectancy</th>";
	echo "<th scope=\"col\">GNP</th>";
	echo "<th scope=\"col\">GNPOld</th>";
	echo "<th scope=\"col\">Continent</th>";
	echo "<th scope=\"col\">Continent</th>";
	echo "<th scope=\"col\">Continent</th>";
	echo "<th scope=\"col\">Continent</th>";
	echo "<th scope=\"col\">Continent</th>";
	echo "<th scope=\"col\">Continent</th>";
	echo "<th scope=\"col\">Continent</th>";
	echo "<th scope=\"col\">Continent</th>";
	echo "<th scope=\"col\">Continent</th>";
	echo "<th scope=\"col\">Continent</th>";*/
	echo "</tr>";
	echo "</thead>";
	echo "<tfoot>";
	echo "<tr><td colspan=\"3\">" . $res->num_rows . "</td></tr>";
	echo "<tr>";
	echo "<th scope=\"col\">Code</th>";
	echo "<th scope=\"col\">Country</th>";
	echo "<th scope=\"col\">Continent</th>";
	echo "</tr>";
	echo "</tfoot>";
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
function default_query_db(){
	$mysqli = connect();
	//check for successful connection
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	}else{
		$query = "select * from country";
		//execute query
		$res = $mysqli->query($query);
		if (!$res) {
			die("Cannot make query: <br />(".$mysqli->errno . ")". $mysqli->error);
		}else{
			//fetch data
			draw_countries_table($res);
		}
		$res->close();
	}
}
function query_db($qstring){	
	$mysqli = connect();
	//check for successful connection
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	}else{
		$query = "select * from country where Name like '%".$qstring."%'";
		//execute query
		$res = $mysqli->query($query);
		if (!$res) {
			die("Cannot make query: <br />(".$mysqli->errno . ")". $mysqli->error);
		}else{
			draw_countries_table($res);
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
		<div class="field_names">
			<?php
				//$res = get_table_columns("country");
				
			?>
		</div>
		<div class="content">
		<?php
		$search = htmlentities($_GET["search"]);
		$self = htmlentities($_SERVER['PHP_SELF']);
		if ($search != NULL) {
			query_db($search);
		}else{
			default_query_db();
		}
		?>
			
		</div>
		<div class="footer">
			<div class="author">Valeria Studio</div>
		</div>
	</div>	
</body>
</html>