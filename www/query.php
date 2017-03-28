<html>
<head><title><h1>CS 143 Project 1A</h1></title></head>
<body>
<h1> CS 143 Project 1A </h1>
<h2>Created By: Shaban Sadiqyar </h2>
<h3> Type a query starting with Select. </h3>
<h4> Example: SELECT * FROM Actor WHERE id='10';</h4>

<form action=./query.php method="GET">
<textarea name="user_query" cols=60 rows=8>

<?php 
	$user_query=$_GET["user_query"];
        echo $user_query; 
?></textarea>	

	<input type="submit" value="Submit">
	</form>

<?php
	$user_query=$_GET["user_query"];
	if ($user_query!=""){ 
              $db_connection=mysql_connect("localhost", "cs143", ""); 
	      if(!$db_connection) {
			print "Connection failed.";
                        exit (1);
		}
		mysql_select_db("CS143", $db_connection);
		$outcome_query=mysql_query($user_query, $db_connection);
		echo "<h3>Results from MySQL:</h3>";
		
                if (!$outcome_query) {
			$errmsg=mysql_error($db_connection);
                        print "Connection failed: $errmsg";
		}
		else{
			echo "<table border=1 cellspacing=1 cellpadding=2>";
			echo "<tr align=center>";
			
			$columns=mysql_num_fields($outcome_query);
			for($j=0; $j<$columns; $j++){
				$attibutes = mysql_fetch_field($outcome_query);
				echo "<td><b>{$attributes->name}</b></td>";
			}
			echo "</tr>\n";
			while($rows=mysql_fetch_row($outcome_query)){
				echo "<tr align=center>";
				foreach($rows as $cells)
					if ($cells)echo "<td>$cells</td>";
					else echo "<td>N/A</td>";
				echo "</tr>\n";
			}
			mysql_free_result($outcome_query); 
		        mysql_close($db_connection);
		}	
	}
?>
</body>
</html>
