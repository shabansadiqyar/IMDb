<html>
<body>
<h2>Find Movie Information</h2>
<p>
<form action=./searchpage.php method="GET">
    <input type="text" name="keyword">
    <input type="submit" value="Find">
</form>
</p>    

<h2>Movie Information</h2>
<?php
	$mid = $_GET["mid"];
    $db_connection = mysql_connect("localhost", "cs143", ""); 
    if(!$db_connection) {
        die("Connection failed");
    }
    mysql_select_db("CS143", $db_connection);
    $query = "SELECT * FROM Movie WHERE id=$mid";
    $actor_info  = mysql_query($query, $db_connection);
    $director_info = mysql_query("SELECT D.first, D.last FROM Director D, MovieDirector MD WHERE MD.mid=$mid AND MD.did=D.id", $db_connection);    
    $genre_info = mysql_query("SELECT genre FROM MovieGenre MG WHERE MG.mid=$mid", $db_connection);
    $movie_name="";
    if (!$actor_info) {
        echo mysql_error($db_connection);
    }
    else {
        $row = mysql_fetch_row($actor_info);
        echo "Name: $row[1] <br>\n";
        echo "Year: $row[2] <br>\n";
        echo "Rating: $row[3] <br>\n";
        echo "Producer: $row[4] <br>\n";
        $movie_name = $row[1];
        $row = mysql_fetch_row($director_info);
        echo "Director: $row[0] $row[1]";
        while ($row = mysql_fetch_row($director_info)) {
            echo ", $row[0] $row[1]";
        }
        echo "<br>\n";
        $row = mysql_fetch_row($genre_info);
        echo "Genre: $row[0]";
        while ($row = mysql_fetch_row($genre_info)) {
            echo ", $row[0]";
        }
        echo "<br>\n";
    }
    
    echo "<h3>Actors/Actresses in Movie</h3>";
    $cast_query = "SELECT A.*, MA.role FROM MovieActor MA, Actor A WHERE MA.mid=$mid and MA.aid=A.id";
    $cast_info = mysql_query($cast_query, $db_connection);
    if (!cast_info) {
        echo mysql_error($db_connection); #Display query error
    }
    else {
        while($row = mysql_fetch_row($cast_info)) {
            echo "Actor: ", "<a href=\"./actorInfo.php?aid=$row[0]\">$row[2] $row[1]</a> as $row[6]<br>\n";
        }    
    }
    
    echo "<h3>Review of Movie</h3>";
    $rating_summary = mysql_query("SELECT AVG(rating), COUNT(*) FROM Review WHERE mid=$mid GROUP BY mid", $db_connection);
    $summary = mysql_fetch_row($rating_summary);
    echo "Average score of $summary[1] reviews: $summary[0] <br><br>\n";
    $review_query = "SELECT * FROM Review WHERE mid=$mid ORDER BY time DESC";
    $review_info = mysql_query($review_query, $db_connection);
    if (!review_info) {
        echo mysql_error($db_connection); 
    }
    else {
        echo "Comments: <br>\n";
        while($row = mysql_fetch_row($review_info)) {
            echo "$row[3] out of 5 - $row[1], $row[0] <br>\n";
            echo "$row[4] <br><br>\n";
        }    
    }
    mysql_free_result($cast_info);
    mysql_free_result($review_info);
?> 
<h3>Add a Comment to the Movie</h3>
<form action=./addComments.php method="GET">
    Movie: 
    <select name="mid">
        <option value="<?php echo $mid; ?>"><?php echo $movie_name; ?></option>
    </select> <br>
    Name: 
    <input type="text" name="name"><br>
    Rating: 
    <select name="rating">
        <option value="">Select rating</option>
        <option value="0">0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select><br>
    Comment:<br>
    <textarea name="comment" cols=50 rows=10></textarea> 
    <input type="submit" value="Add to Database"></input>
</form>
</body>
</html>
