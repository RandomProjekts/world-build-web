<html>

<head>
	<?php
	$conn = require(__DIR__ . "/connection.php");
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	} else {
		echo ("no person selected");
		echo ("<title>People</title>");
		exit();
	}

	// Query
	$query = $conn->prepare("SELECT * FROM people where id=?");
	$query->bind_param('i', $id);
	$query->execute();
	$result = $query->get_result()->fetch_assoc();

	if (empty($result)) {
		echo ("Does not exist");
		echo ("<title>People</title>");
		exit();
	}

	?>
	<title><?php echo ($result['name']); ?> - People</title>
	<meta charset="utf-8">
	<?php
		if (file_exists("../img/" . $result['name'] . "_icon.jpg")) {
			$b64img = base64_encode(file_get_contents("../img/" . $result['name'] . "_icon.jpg"));
			echo ("<link rel='icon' href='data:image/png;base64,$b64img'>");
		}
		?>
	<link rel="stylesheet" href="./css/people.css">
	<link rel="stylesheet" href="./css/peopleSmall.css" media="all and (max-aspect-ratio: 3/5)">
</head>

<body>

	<table role="main">
		<caption>
			<h1><?php echo ($result['name']); ?></h1>
		</caption>

		<?php
		$imgpath = "../img/" . $result['name'] . ".jpg";
		if (file_exists($imgpath)) {
			$b64img = base64_encode(file_get_contents($imgpath));
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
					echo ("Female");
				} elseif ($result['gender'] == 'm') {
					echo ("Male");
				}

				?>
			</td>
		</tr>
			<?php
			if (!empty($result['age'])) {
				echo ("
				<tr>
		                	<th>Age</th>
		                	<td>" . $result['age'] . " Years</td>
				</tr>
				");
			}
			?>
		
	</table>
</body>

<?php
// Main color of color sheme (appearance image) and version with alpha = 0
if (file_exists($imgpath)) {
	include_once(__DIR__ . "/scripts/themecolor.php");
	if (empty($result['themecolor'])) {
		$themecolor = findthemecolor(__DIR__ . "/" . $imgpath); // imgpath adjusted for colorextract script
	} else {
		$themecolor = adjustlightness($result['themecolor']);
	}

	if (!empty($themecolor)) {
		echo ("
	<style>
		:root {
			--rowcolor: " . $themecolor . ";
			--rowcolor-transparent: " . $themecolor . "00;
		}
	</style>
	");
	}
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