
<html>

<h2>Add a Movie</h2><p>
<form action=./addMovie.php method="GET">
	Title:
	<input type="text" name="title">

	Company:
	<input type="text" name="company"><br>

	Release Year: 
	<?php
		$current_year = date("Y");
		$range = range($current_year, ($current_year - 100));
		echo '<select name="year">';
		echo '<option value="">Year</option>';
		foreach($range as $r) {
			echo '<option value="'.$r.'">'.$r.'</option>';
		}		 
		echo '</select>';
	?>
	

	MPAA Rating
	<select name="rating">
		<option value="">Select rating</option>
		<option value="G">G</option>
		<option value="PG">PG</option>
		<option value="PG-13">PG-13</option>
		<option value="NC-17">NC-17</option>
		<option value="surrendere">surrendere></option>
	</select><br>

	<br>Genre<br>
	<?php
	    $db_connection = mysql_connect("localhost", "cs143", ""); 
	    if(!$db_connection) {
	        die("Connection failed");
	    }
	    mysql_select_db("CS143", $db_connection);
		$genres = mysql_query("SELECT DISTINCT genre FROM MovieGenre ORDER BY genre ASC", $db_connection);
		while($g = mysql_fetch_row($genres)) {
			echo '<input type="checkbox" name="genres[]" value="'.$g[0].'">'.$g[0].'<br></input>';
		}
	?>
	<br>
	<input type="submit" value="Add to Database"></input>
</form>

<?php
	$title = $_GET["title"];
	$company = $_GET["company"];
	$rating = $_GET["rating"];
	$year = $_GET["year"];
	$genres = $_GET["genres"];
	if ($title != "" && $year != "") {
		$exist = mysql_query("SELECT 1 FROM Movie WHERE title=\"$title\" AND year=$year LIMIT 1", $db_connection);
		if (mysql_fetch_row($exist)) {
			echo "Movie already in Database.";
		}
		else {
			$max_id = mysql_fetch_row(mysql_query("SELECT id FROM MaxMovieID", $db_connection));
			$new_max = $max_id[0]+1;
			mysql_query("UPDATE MaxMovieID SET id=$new_max", $db_connection);
		    $add_query = "INSERT INTO Movie VALUES ($new_max, \"$title\", $year, \"$rating\", \"$company\")";
		    if (mysql_query($add_query, $db_connection)) {
		    	echo "Success";
			} else {
		    	echo "Error: " . $add_query . "<br>" . mysql_error($db_connection);
			}
			foreach ($genres as $g) {
				$add_query = "INSERT INTO MovieGenre VALUES($new_max, \"$g\")";
				mysql_query($add_query, $db_connection);
			}
		}
	}
?>

</html>
