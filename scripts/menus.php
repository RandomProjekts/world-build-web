<?php
function peopleMenu() {
	$conn = require (__DIR__ . "/connection.php");
	$query = $conn->query("SELECT name FROM people");
	$id = 1;
	echo "<section role='navigation'>";
	while ( $value = $query->fetch() ) {
		echo "<a href='/people.php?id=" . $id . "'><img src='/img/";
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/img/$value[0]_icon.png")) {
			echo $value[0];
		} else {
			echo "default";
		}
		echo "_icon.png'></img><br>$value[0]</a>";
		$id ++;
	}
	echo "</section>";
}
