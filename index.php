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
function draw_countries_table(&$res){
	echo "<table class=\"countries\">";
	echo "<caption>Countries (".$res->num_rows.")</caption>";
	echo "<colgroup>";
	if(empty($_POST['columns'])){
		$columns = get_table_columns("country");
	}else{
		$columns = $_POST['columns'];
	}
	$N = count($columns);						
	for($i=0; $i < $N; $i++){
		echo "<col class=\"$columns[$i]\" />";
	}
	echo "</colgroup>";
	echo "<thead>";
	echo "<tr>";
	for($i=0; $i < $N; $i++){
		echo "<th scope=\"col\">$columns[$i]</th>";
	}
	echo "</tr>";
	echo "</thead>";
	echo "<tfoot>";
	echo "<tr>";
	if ($res->num_rows>30) {
		for($i=0; $i < $N; $i++){
			echo "<th scope=\"col\">$columns[$i]</th>";
		}
	}	
	echo "</tr>";
	echo "</tfoot>";
	echo "<tbody>";
	while($row = $res->fetch_array()){
		echo "<tr>";
		for($i=0; $i < $N; $i++){
			echo "<td>$row[$i]</td>";
		}	
		echo "</tr>";															
	}
	echo "</tbody>";
	echo "</table>";
}
function default_query_db($columnset){
	$mysqli = connect();
	//check for successful connection
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	}else{
		$query = "select $columnset from country";
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
function query_db($columnset, $qstring){	
	$mysqli = connect();
	//check for successful connection
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	}else{
		$query = "select $columnset from country where Name like '%".$qstring."%'";
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
	<div class="header">
		<div class="logo">MySQL's World Database Explorer</div>
	</div>
	<div class="content">
		<ul class="nav">
			<li>Countries</li>
			<li>Cities</li>
		</ul>
		<div class="searchForm">
			<form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="POST">
				<label for="search" class="label">Search: 
					<input type="text" name="search" />
				</label>
				<input type="submit" value="Go!" />
						
				Select columns to show: <br />
				<?php
					$res = get_table_columns("country");
					$i = 0;
					while($row = $res->fetch_array()){
						echo "<label><input type=\"checkbox\" name=\"columns[]\" value=\"".$row[0]."\" />".$row[0]."</label>";					
						$i += 1;
					}
				?>
<!--			<input type="submit" name="columnsSubmit" value ="Submit" />-->
			</form>
<!--clean for production />-->			
			<?php			
				$columns = $_POST['columns'];
				if(empty($columns)){
					echo("You didn't select anything.");
					$columnset = " * ";
				}else{
					$N = count($columns);
					echo("You selected $N column(s): ");
					$columnset = " ";
					for($i=0; $i < $N; $i++){
						echo($columns[$i]." ");
						$columnset = $columnset . $columns[$i];
						if ($i < ($N-1)){
							$columnset = $columnset . ", ";
						} else { $columnset = $columnset . " ";}
					}
				}
			?>
<!--clean for production />-->			
		</div>
		<div class="result">
		<?php
		$search = htmlentities($_POST["search"]);
		$self = htmlentities($_SERVER['PHP_SELF']);
		if ($search != NULL) {
			query_db($columnset, $search);
		}else{
			default_query_db($columnset);
		}
		?>
		</div>
	</div>	
	<div class="footer">
		<div class="author">Valeria Studio</div>
	</div>
</body>
</html>