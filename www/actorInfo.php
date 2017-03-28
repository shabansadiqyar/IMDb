<html>
<body>

<h2>Find Actor Information</h2>
<form action=./searchpage.php method="GET">
    <input type="text" name="keyword">
    <input type="submit" value="Find">
</form>
    
<h3>Actor Information</h3>
<?php
	$aid = $_GET["aid"];

    $db_connection = mysql_connect("localhost", "cs143", ""); 
    if(!$db_connection) {
        die("Connection failed");
    }
    mysql_select_db("CS143", $db_connection);
    $query = "SELECT * FROM Actor WHERE id=$aid";
    $actor_info  = mysql_query($query, $db_connection);    
    if (!$actor_info) {
        echo mysql_error($db_connection);
    }
    else {
        $row = mysql_fetch_row($actor_info);
        echo "Name: $row[2] $row[1]<br>\n";
        echo "Sex: $row[3] <br>\n";
        echo "Date of Birth: $row[4] <br>\n";
        if ($row[5]==NULL)
            {
        echo "Date of Death: Still Alive\n";
            }
        else echo "Date of Death: $row[5] <br>\n";
    }
    echo "<h3>Actor's Movies</h3>";
    $movie_query = "SELECT M.* FROM MovieActor MA, Movie M WHERE MA.aid=$aid AND MA.mid=M.id ORDER BY M.year DESC";
    $movie_info = mysql_query($movie_query, $db_connection);
    if (!movie_info) {
        echo mysql_error($db_connection); 
    }
    else {
        while($row = mysql_fetch_row($movie_info)) {
            echo "Movie: ", "<a href=\"./movieInfo.php?mid=$row[0]\">$row[1] ($row[2])</a> <br>\n";
        }    
    }
    mysql_free_result($actor_info);
    mysql_free_result($movie_info);
?>
    
</body>
</html>
