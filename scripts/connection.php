<?php
$config = require ($_SERVER['DOCUMENT_ROOT'] . "../config.php");
// Create connection
$conn = new mysqli ( $config ['servername'], $config ['username'], $config ['password'], $config ['DBname'] );

// Check connection
if ($conn->connect_error) {
	die ( "Connection failed: " . $conn->connect_error );
}
return $conn;
?>