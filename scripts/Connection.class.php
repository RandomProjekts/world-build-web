<?php
/*
 * this class connects to the database via the mysqli interface
 */

class Connection {

	protected static $conn;

	public function __construct() {
		if (!isset(self::$conn)) {
			$config = require ($_SERVER['DOCUMENT_ROOT'] . '/../config.php');
			try {
			// Create connection
			self::$conn = new PDO("mysql:host=$config[servername];dbname=$config[DBname]", $config['username'], $config['password']);
			// Check connection
			} catch (Exception $e) {
				die('Connection failed: ' . $e->getMessage());
			}
		}
	}

	public function getConnection() {
		return self::$conn;
	}

}
