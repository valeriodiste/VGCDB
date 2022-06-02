<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Getting Results...</title>
</head>
<body>
<?php

    $dbconn = pg_connect("host = localhost port =5432 dbname = postgres 
    user = postgres password = vgcdb") 
    or database_error('Could not connect : ' . pg_last_error());

    $character_name = '';
    $universe = "";
    $year1 = "1970";
    $year2 = date("Y");
    $role = array('Protagonist','Antagonist','Secondary','Enemy','Neutral');
    $gender = array('Male','Female','Other');
    $eye_color = array('Black','Blue','Brown','Green','Gray','Orange','Purple','Red','White','Yellow','Pink','None / Undefined');
    $hair_color = array('Black','Blue','Brown','Green','Gray','Orange','Purple','Red','White','Yellow','Pink','Sky Blue','None / Undefined');

    if(!empty($_POST['character_name'])) {
        $character_name = $_POST['character_name'];
    }
    if(!empty($_POST['universe'])) {
        $universe = $_POST['universe'];
    }
    if(!empty($_POST['year1'])) {
        $year1 = $_POST['year1'];
    }
    if(!empty($_POST['year2'])) {
        $year2 = $_POST['year2'];
    }
    if(!empty($_POST['role'])) {
        $role = $_POST['role'];
    }
    if(!empty($_POST['gender'])) {
        $gender = $_POST['gender'];
    }
    if(!empty($_POST['eye_color'])) {
        $eye_color = $_POST['eye_color'];
    }
    if(!empty($_POST['hair_color'])) {
        $hair_color = $_POST['hair_color'];
    }

    foreach($role as $col_value) {
        echo "$col_value\n";
    }
    foreach($gender as $col_value) {
        echo "$col_value\n";
    }
    foreach($eye_color as $col_value) {
        echo "$col_value\n";
    }
    foreach($hair_color as $col_value) {
        echo "$col_value\n";
    }
    echo "Finished\n\n\n";

    $role = implode('\',\'',$role);
    $gender = implode('\',\'',$gender);
    $eye_color = implode('\',\'',$eye_color);
    $hair_color = implode('\',\'',$hair_color);

	$query = "SELECT * FROM characters WHERE name = '$character_name' OR universe = '$universe' OR (year>=$year1 AND year<=$year2) OR
	(role IN ('$role') AND gender IN ('$gender') AND eye IN ('$eye_color') AND hair IN ('$hair_color')) ORDER BY universe, LENGTH(role) DESC";


    $result = pg_query($query) or database_error('Query failed : '.pg_last_error());
           
    echo "<table>\n";
    while($line = pg_fetch_array($result, null, PGSQL_NUM)) {

        $name = $line[0];
        $universe = $line[1];
        $year = $line[2];
        $role = $line[3];
        $gender = $line[4];
        $eye = $line[5];
        $hair = $line[6];
        $image = $line[7];
        $color1 = $line[8];
        $color2 = $line[9];
        $short_description = $line[10];
        $long_description = $line[11];
        $importance = $line[12];

        echo "\t<tr>\n";

        echo "\t\t<td>name: $name;</td>";
        echo "\t\t<td>universe: $universe;</td>";
        echo "\t\t<td>year: $year;</td>";
        echo "\t\t<td>role: $role;</td>";
        echo "\t\t<td>gender: $gender;</td>";
        echo "\t\t<td>eye: $eye;</td>";
        echo "\t\t<td>hair: $hair;</td>";

        echo "\t</tr>\n";
    }
    echo "</table>\n";
    pg_free_result($result);
    pg_close($dbconn);
?>   
</body>
</html>