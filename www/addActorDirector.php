<html>

<h2>Add an Actor or Director</h2><p>
<form action=./addActorDirector.php method="GET">
	Actor <input type="radio" name="type" value="Actor">
	Director <input type="radio" name="type" value="Director">
	<br>

	First Name:
	<input type="text" name="first">

	Last name:
	<input type="text" name="last">
	<br>

	Sex:
	<select name="sex">
		<option value="">Sex</option>
		<option value="Male">Male</option>
		<option value="Female">Female</option>
	</select>
	<br>
	Date of birth:
	<?php
		$current_year = date("Y");
		$range = range($current_year, ($current_year - 100));
		echo '<select name="dob_year">';
		echo '<option value="">Year</option>';
		foreach($range as $r) {
			echo '<option value="'.$r.'">'.$r.'</option>';
		}		 
		echo '</select>';
	?>
	<?php
		echo '<select name="dob_month">';
		echo '<option value="">Month</option>';
	    for( $i = 1; $i <= 12; $i++ ) {
	        $month_num = str_pad( $i, 2, 0, STR_PAD_LEFT );
	        $month_name = date( 'F', mktime( 0, 0, 0, $i + 1, 0, 0, 0 ) );
	        echo '<option value="' .$month_num. '">' .$month_name. '</option>';
	    }
	    echo '</select>';
	?>
	<?php
		echo '<select name="dob_day">';
		echo '<option value="">Day</option>';
		foreach (range(1,31) as $r) {
			$d = str_pad($r, 2, 0, STR_PAD_LEFT);
			echo '<option value="'.$d.'">'.$r.'</option>';
		}
		echo '</select>';
	?>
	
	Date of death:
	<?php
		$current_year = date("Y");
		$range = range($current_year, ($current_year - 60));
		echo '<select name="dod_year">';
		echo '<option value="">Year</option>';
		foreach($range as $r) {
			echo '<option value="'.$r.'">'.$r.'</option>';
		}		 
		echo '</select>';
	?>
	<?php
		echo '<select name="dod_month">';
		echo '<option value="">Month</option>';
	    for( $i = 1; $i <= 12; $i++ ) {
	        $month_num = str_pad( $i, 2, 0, STR_PAD_LEFT );
	        $month_name = date( 'F', mktime( 0, 0, 0, $i + 1, 0, 0, 0 ) );
	        echo '<option value="' .$month_num. '">' .$month_name. '</option>';
	    }
	    echo '</select>';
	?>
	<?php
		echo '<select name="dod_day">';
		echo '<option value="">Day</option>';
		foreach (range(1,31) as $r) {
			$d = str_pad($r, 2, 0, STR_PAD_LEFT);
			echo '<option value="'.$d.'">'.$r.'</option>';
		}
		echo '</select>';
	?>

	<br>
	<input type="submit" value="Add to Database"></input>
</form>

<?php
    $db_connection = mysql_connect("localhost", "cs143", ""); 
    if(!$db_connection) {
        die("Connection failed");
    }
    mysql_select_db("CS143", $db_connection);
	$type = $_GET["type"];
	$last = $_GET["last"];
	$first = $_GET["first"];
	$sex = $_GET["sex"];
	$dob_year = $_GET["dob_year"];
	$dob_month = $_GET["dob_month"];
	$dob_day = $_GET["dob_day"];
	$dod_year = $_GET["dod_year"];
	$dod_month = $_GET["dod_month"];
	$dod_day = $_GET["dod_day"];
	if ($dob_year != "" && $dob_month != "" && $dob_day != "") {
		$dob = date("Y-m-d",mktime(0,0,0,$dob_month,$dob_day,$dob_year));
	}
	else {
		$dob = "NULL";
	}
	
	if ($dod_year != "" && $dod_month != "" && $dod_day != "") {
		$dod = date("Y-m-d",mktime(0,0,0,$dod_month,$dod_day,$dod_year));
	}
	else {
		$dod = "NULL";
	}
	if ($first != "" && $last != "" && $sex != "" && $dob != "") {
	    $db_connection = mysql_connect("localhost", "cs143", ""); 
	    if(!$db_connection) {
	        die("Connection failed");
	    }
	    mysql_select_db("CS143", $db_connection);
		if ($type=="Actor") {
			$exist = mysql_query("SELECT 1 FROM Actor WHERE last=\"$last\" AND first=\"$first\" LIMIT ONLY 1", $db_connection);
		}
		else {
			$exist = mysql_query("SELECT 1 FROM Director WHERE last=\"$last\" AND first=\"$first\" LIMIT ONLY 1", $db_connection);
		}
		if (mysql_fetch_row($exist)) {
			echo "Actor/Director already exists in the Database.";
		}
		else {
			$max_id = mysql_fetch_row(mysql_query("SELECT id FROM MaxPersonID", $db_connection));
			$new_max = $max_id[0]+1;
			if ($type=="Actor" && $dod=="NULL") {
			    $add_query = "INSERT INTO Actor VALUES ($new_max, \"$last\", \"$first\", \"$sex\", \"$dob\", $dod)";
			}
			else if ($type=="Actor")
			{
				$add_query = "INSERT INTO Actor VALUES ($new_max, \"$last\", \"$first\", \"$sex\", \"$dob\", \"$dod\")";
			}
			else if ($type=="Director" && $dod=="NULL") {
				$add_query = "INSERT INTO Director VALUES ($new_max, \"$last\", \"$first\", \"$dob\", $dod)";
			}
			else if ($type=="Director") {
				$add_query = "INSERT INTO Director VALUES ($new_max, \"$last\", \"$first\", \"$dob\", \"$dod\")";
			}
		    if (mysql_query($add_query, $db_connection)) {
		    	echo "Success";
		    	mysql_query("UPDATE MaxPersonID SET id=$new_max", $db_connection); 
			} else {
		    	echo "Error: " . $add_query . "<br>" . mysql_error($db_connection);
			}
		}
	}
	else
	{
		echo "<Must fill out first, last, sex, dob.";
	}
?>

</html>
