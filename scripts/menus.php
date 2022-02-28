<?php
function peopleMenu() {
	$conn = require (__DIR__ . "/connection.php");
	$query = $conn->prepare( "SELECT name FROM people" );
	$query->execute();
	$id = 1;
	$result = $query->get_result();
	while ($value = mysqli_fetch_array($result)) {
		echo "<a href='/people.php?id=" . $id . "'>" . $value[0] . "</a><br />";
		$id++;
	}
}