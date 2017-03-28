<html>

<h2>Add a Director to a Movie</h2><p>
<form action=./addDirector.php method="GET">
	Director:
	<select name="did">
		<option value=""><?php echo "Select a director"; ?></option>
		<?php
	            $db_connection = mysql_connect("localhost", "cs143", ""); 
		    if(!$db_connection) {
		        die("Connection failed");
		    }
		    mysql_select_db("CS143", $db_connection);
		    $director_info = mysql_query("SELECT first, last, id FROM Director ORDER BY last, first ASC", $db_connection);
		    while($row = mysql_fetch_row($director_info)) {
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

	<input type="submit" value="Add to Database">
</form>

<?php
	$did = $_GET["did"];
	$mid = $_GET["mid"];
	if ($did != "" && $mid != "") {
	    $exist = mysql_query("SELECT 1 FROM MovieDirector WHERE mid=$mid AND did=$did LIMIT 1", $db_connection);
	    if (mysql_fetch_row($exist)) {
	    	echo "Director already part of movie";
	    }
	    else {
		    $add_query = "INSERT INTO MovieDirector VALUES ($mid, $did)";
		    if (mysql_query($add_query, $db_connection)) {
		    	echo "Success";
			} else {
		    	echo "Error: " . $add_query . "<br>" . mysql_error($db_connection);
			}
		}
	}
    mysql_free_result($director_info);
    mysql_free_result($movie_info);
?>

</html>
