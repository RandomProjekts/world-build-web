<?php
/*
 * this class connects to the database via the mysqli interface
 */

class Connection {

	protected static $conn;

	public function __construct() {
		if (!isset(self::$conn)) {
			$config = require ($_SERVER['DOCUMENT_ROOT'] . '/../config.php');
			// Create connection
			self::$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['DBname']);

			// Check connection
			if (self::$conn->connect_error) {
				die('Connection failed: ' . self::$conn->connect_error);
			}
		}
	}

	public function getConection() {
		return self::$conn;
	}

}
