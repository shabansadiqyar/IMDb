<html>
<body>

<h2>Find Actor/Actress/Movie</h2>    
<p>
	<form action=./searchpage.php method="GET">
		<input type="text" name="keyword">
        <input type="submit" value="Find">
	</form>
</p>

<?php
	$query_expr = $_GET["keyword"];
	if ($query_expr!="") { 
        echo "Searching... $query_expr <br>\n"; 
		$db_connection = mysql_connect("localhost", "cs143", ""); 
		if(!$db_connection) {
			die("Connection failed");
		}
		mysql_select_db("CS143", $db_connection);
        
        $arr_keyword = explode(" ", mysql_real_escape_string($query_expr, $db_connection)); 

        $actor_query = "SELECT * FROM Actor WHERE (first AND last) LIKE \"%$arr_keyword[0]%\" OR last LIKE \"%$arr_keyword[0]%\" OR first LIKE \"%$arr_keyword[0]%\"";
        $movie_query = "SELECT * FROM Movie WHERE title LIKE \"%$arr_keyword[0]%\"";
        for ($i=1; $i<sizeof($arr_keyword); $i++) {
            $actor_query = $actor_query . " OR (first AND last) LIKE \"%$arr_keyword[$i]%\" OR last LIKE \"%$arr_keyword[$i]%\" OR first LIKE \"%$arr_keyword[$i]%\"";
            $movie_query = $movie_query . " OR title LIKE \"%$arr_keyword[$i]%\"";  
        }
        $actor_query = $actor_query . ";";
        $movie_query = $movie_query . ";";
        #echo "Actor: ", $actor_query, "<br>";
        #echo "Movie: ", $movie_query, "<br>";
        
        $actor_result  = mysql_query($actor_query, $db_connection);
        echo "<h3>Actor Info:</h3>";
		if (!$actor_result) {
			echo mysql_error($db_connection); 
		}
		else {
            while($row = mysql_fetch_row($actor_result)) {
                echo "Actor: ", "<a href=\"./actorInfo.php?aid=$row[0]\">$row[2] $row[1] ($row[4])</a> <br>\n";
            }
            
			mysql_free_result($actor_result); 
		}
        
        $movie_result  = mysql_query($movie_query, $db_connection);
        echo "<h3>Movie Info:</h3>";
		if (!$movie_result) {
			echo mysql_error($db_connection); 
		}
		else{ 
            while($row = mysql_fetch_row($movie_result)) {
                echo "Movie: ", "<a href=\"./movieInfo.php?mid=$row[0]\">$row[1] ($row[2])</a> <br>\n";
            }
			mysql_free_result($movie_result);
		}    
	}
?>
</body>
</html>
