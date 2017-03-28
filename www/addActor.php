<html>

<h2>Add Actor to Movie</h2><p>
<form action=./addActor.php method="GET">
	Actor: 
	<select name="aid">
		<option value=""><?php echo "Select an actor"; ?></option>
		<?php
		    $db_connection = mysql_connect("localhost", "cs143", ""); 
		    if(!$db_connection) {
		        die("Connection failed");
		    }
		    mysql_select_db("CS143", $db_connection);
		    $actor_info = mysql_query("SELECT first, last, id FROM Actor ORDER BY last, first ASC", $db_connection);
		    while($row = mysql_fetch_row($actor_info)) {
		?>
		<option value="<?php echo $row[2]; ?>"><?php echo "$row[0] $row[1]"; ?></option>
		<?php
			}
		?>
	</select> <br>

	Movie: 
	<select name="mid">
		<option value=""><?php echo "Select a movie"; ?></option>
		<?php
		    $movie_info = mysql_query("SELECT title, id FROM Movie ORDER BY title ASC", $db_connection);
		    while($row = mysql_fetch_row($movie_info)) {
		?>
		<option value="<?php echo $row[1]; ?>"><?php echo $row[0]; ?></option>
		<?php
			}
		?>
	</select><br>

	Role:
	<input type="text" name="role"><br>
	<input type="submit" value="Add to Database">
</form>

<?php
	$aid = $_GET["aid"];
	$mid = $_GET["mid"];
	$role = $_GET["role"];
	if ($mid != "" && $mid != "") { 
		$exist = mysql_query("SELECT 1 FROM MovieActor WHERE mid=$mid AND aid=$aid LIMIT 1", $db_connection);
		if (mysql_fetch_row($exist)) {
			echo "Actor already part of Movie.";
		}
		else {
		    $add_query = "INSERT INTO MovieActor VALUES ($mid, $aid, \"$role\")";
		    if (mysql_query($add_query, $db_connection)) {
		    	echo "Success";
			} else {
		    	echo "Error: " . $add_query . "<br>" . mysql_error($db_connection);
			}
		}
	}
    mysql_free_result($actor_info);
    mysql_free_result($movie_info);
?>

</html>
