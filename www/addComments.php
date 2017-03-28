<html>

<h2>Add a Review for a Movie</h2><p>
<form action=./addComments.php method="GET">
	Movie: 
	<select name="mid">
		<option value=""><?php echo "Select a movie"; ?></option>
		<?php
			#connect to db
		    $db_connection = mysql_connect("localhost", "cs143", ""); 
		    if(!$db_connection) {
		        die("Connection failed");
		    }
		    mysql_select_db("CS143", $db_connection);
		    $movie_info = mysql_query("SELECT title, id FROM Movie ORDER BY title ASC", $db_connection);
		    while($row = mysql_fetch_row($movie_info)) {
		?>
		<option value="<?php echo $row[1]; ?>"><?php echo $row[0]; ?></option>
		<?php
			}
		?>
	</select><br>


	Name:
	<input type="text" name="name">
	Rating
	<select name="rating">
		<option value="">Select rating</option>
		<option value="0">0</option>
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
	
	</select><br>
	Comment<br>
	<textarea name="comment" cols=50 rows=10></textarea>	
	<input type="submit" value="Add to Database"></input>
</form>

<?php
	$mid = $_GET["mid"];
	$name = $_GET["name"];
	$rating = $_GET["rating"];
	$comment = $_GET["comment"];
	if ($mid != "" && $name != "" && $rating !="") {
		$exist = mysql_query("SELECT 1 FROM Review WHERE mid=$mid AND name=\"$name\" LIMIT 1", $db_connection);
		if (mysql_fetch_row($exist)) {
			echo "User already made a Review";
		}
		else {
		    $add_query = "INSERT INTO Review VALUES (\"$name\", CURRENT_TIMESTAMP(), $mid, $rating, \"$comment\")";
		    if (mysql_query($add_query, $db_connection)) {
		    	echo "Success";
			} else {
		    	echo "Error: " . $add_query . "<br>" . mysql_error($db_connection);
			}
		}
	}
    mysql_free_result($movie_info);
?>

</html>
