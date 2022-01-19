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
echo "Connected successfully<br />";

// Query
$query = $conn->prepare("SELECT * FROM people where id=?");
$query->bind_param('i', $id);
$query->execute();
$result = $query->get_result()->fetch_assoc();

if (empty($result)) {
    echo ("Does not exist");
    exit();
}


?> 
<div class="layout" role="main">
	<div>
		<p>Name</p>
		<h1><?php echo ($result['name']); ?></h1>
	</div>
	
		<?php 
		if (file_exists("../img/" . $result['name'] . ".JPG")) {
		    $b64img = base64_encode(file_get_contents("../img/" . $result['name'] . ".JPG"));
		    echo ("
                <div>
                    <p>Appearance</p>
                    <div><img src='data:image/png;base64,$b64img'></img></div>
                </div>
                ");
		}
		?>
	<div>
		<p>Gender</p>
		<p><?php 
		if ($result['gender'] == 'f') {
		  echo("Female");
		} elseif ($result['gender'] == 'm') {
		  echo("Male");
		}
		
		?></p>
	</div>
	<div>
		<?php
		if (!empty($result['age'])) {
		    echo("
                <p>Age</p>
                <p>" . $result['age'] . " Years</p>"
		        );
		  }
		?>
	</div>
</div>

<?php 
$conn->close();
?>
</body>
</html>
