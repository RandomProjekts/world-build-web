<html>
<head>
<title>Physics</title>
<meta charset="utf-8">
</head>
<body>
<?php
$config = require ("../config.php");
// Create connection
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['DBname']);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$conn->close();
?> 
</body>
</html>