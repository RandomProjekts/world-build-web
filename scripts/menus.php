<?php
$conn = require (__DIR__ . "/connection.php");
function peopleMenu($id) {
	$query = $conn->prepare( "SELECT * FROM people where id=?" );
	$query->bind_param( 'i', $id );
	$query->execute();
	$result = $query->get_result()->fetch_assoc();
	echo ($result);
}