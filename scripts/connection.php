<?php
/*
 * this file is a wrapper for the Connection class defined in
 * scripts/Connection.class.php
 * usage [DEPRECATED]: $conn = require 'connection.php'
 */

require_once 'Connection.class.php';
$conn = new Connection();
return $conn->getConnection();
