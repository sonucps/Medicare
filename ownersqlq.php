<?php
	session_start();
	if(!isset($_SESSION['doctor']))
	{
		header("Location: index.html");
		exit();
	};

	if ($_POST['name']=="medicines") $table = "medicine";
	else if ($_POST['name']=="medicines_compounds") $table = "name_compound";
	else if ($_POST['name']=="medicines_pharma") $table = "name_pharma";
	else if ($_POST['name']=="employees") $table = "employee";
	else if ($_POST['name']=="transactions") $table = "transaction";

	include 'config.php';
	if(!($dbconn = @mysqli_connect($dbhost, $dbuser, $dbpass,$db))) exit('Error connecting to database.');
	//mysql_select_db($db);


	if($table!=="employee")
	{
		$sqlq = "SELECT * FROM ".$table.";";
	}
	else if($table=="employee")
	{
		$sqlq = "SELECT * FROM person NATURAL JOIN employee NATURAL JOIN person_email NATURAL JOIN person_tel_no";
	}
	$sqlq = mysqli_query($dbconn,$sqlq);
	if(!$sqlq)
	{
		echo "Query Failed.<br />";
		exit;
	}
	$num_rows = mysqli_num_rows($sqlq);
	echo "<pre>Table Name : ".$table.". Fetched ".$num_rows." rows. Output:<br /><br />";
	echo "<table border=1><tr>";
	for($i = 0; $i < mysqli_num_fields($sqlq); $i++)
	{
		$field_info = mysqli_fetch_field($sqlq);
		echo "<th>{$field_info->name}</th>";
	}
	echo "</tr>";
	while($row = mysqli_fetch_row($sqlq))
	{
		echo "<tr>";
		foreach($row as $_column)
		{
			echo "<td>{$_column}</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
?>
