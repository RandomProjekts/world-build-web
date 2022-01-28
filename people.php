<html>
<head>
<title>People</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/people.css">
</head>
<body>
<?php
$conn = require ("./connection.php");
if (isset ( $_GET ['id'] )) {
	$id = $_GET ['id'];
} else {
	echo ("no person selected");
	exit ();
}

// Query
$query = $conn->prepare ( "SELECT * FROM people where id=?" );
$query->bind_param ( 'i', $id );
$query->execute ();
$result = $query->get_result ()->fetch_assoc ();

if (empty ( $result )) {
	echo ("Does not exist");
	exit ();
}

?> 
<table role="main">
	<caption>
		<h1><?php echo ($result['name']); ?></h1>
	</caption>
	
	<?php 
		if (file_exists("../img/" . $result['name'] . ".JPG")) {
		    $b64img = base64_encode(file_get_contents("../img/" . $result['name'] . ".JPG"));
		    echo ("
                <tr>
                    <th>Appearance</th>
                    <td><img src='data:image/png;base64,$b64img'></img></td>
                </tr>
                ");
		}
	?>
	<tr>
		<th>Gender</th>
		<td><?php 
		if ($result['gender'] == 'f') {
		  echo("Female");
		} elseif ($result['gender'] == 'm') {
		  echo("Male");
		}
		
		?></td>
	</tr>
	<tr>
		<?php
		if (!empty($result['age'])) {
		    echo("
                <th>Age</th>
                <td>" . $result['age'] . " Years</td>"
		        );
		  }
		?>
	</tr>
</table>
</body>

<?php
/*  (optional) Main color of color sheme (appearance image) and version with alpha = 0 
	variables are used for coloring the rows in table
	themecolor has to be a hex color string starting with a '#' */
if (!empty($result['themecolor'])) {
	echo("
	<style>
		:root {
			--rowcolor: " . $result['themecolor'] . ";
			--rowcolor-transparent: " . $result['themecolor'] . "00;
		}
	</style>
	");
}

$conn->close();
?>

<script>
	// hide content of rows that are "higher" than 30% of the viewport width and show only preview
	var data = Array.from(document.getElementsByTagName("td"));
	data.forEach(function(td) {
		let h = td.offsetHeight;
		if (h / window.innerWidth > 0.3) {
			td.classList.add("shorten");
			// toggle full content or preview on click
			td.addEventListener("click", (e) => {
				var v = e.target
				while (v.tagName != "TD") {
					v = v.parentNode;
				}
				v.classList.toggle("shorten");
			});
		}
	});
</script>
</html>