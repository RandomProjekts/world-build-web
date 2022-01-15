<html>
<head>
<title>People</title>
<meta charset="utf-8">
</head>
<body>
<?php
$config = require ("../config.php");

if (isset($_GET['id'])) {
   $id = $_GET['id'];
} else {
   echo("no person selected");
   exit();
}
// Create connection
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['DBname']);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

// Query
$query = $conn->prepare("SELECT * FROM people where id=?");
$query->bind_param('i', $id);
$query->execute();
$result = $query->get_result()->fetch_assoc();
echo ($result['name']);

if (file_exists("../img/" . $result['name'] . ".JPG")) {
    echo ("<img src=" . "../img/" . $result['name'] . ".JPG" . "><img/>");
}
?> 

<?php 
$conn->close();
?>
</body>
</html>
