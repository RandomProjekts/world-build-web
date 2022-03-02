<!DOCTYPE html>
<html>

<head>
	<?php
	$conn = require(__DIR__ . "/scripts/connection.php");
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	} else {
		# echo ("no person selected");
		echo ("
				<title>People</title>
				<link rel='icon' href='./img/default_icon.png'>
			");
		require(__DIR__ . "/scripts/menus.php");
		peopleMenu();
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
	<title><?= $result['name'] ?> - People</title>
	<meta charset="utf-8">
	<?php
	if (file_exists("./img/" . $result['name'] . "_icon.jpg")) {
		echo ("<link rel='icon' href='./img/" . $result['name'] . "_icon.jpg'>");
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
		$imgpath = "./img/" . $result['name'] . ".jpg";
		if (file_exists($imgpath)) {
			echo ("<link rel='stylesheet' href='./css/rowFix.css'>");
			echo ("
		                <tr>
		                    <td><img src='$imgpath'></img></td>
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
				} elseif ($result['gender'] == 'd') {
					echo ("Non-Binary");
				}

				?>
			</td>
		</tr>

		<?php
		if ((!empty($result['birth-day'])) && (!empty($result['birth-year']))) {
			echo ("<tr>
		                <th>Birthday</th>
		                <td>" . $result['birth-day'] . ". " . $result['birth-year'] . "</td>
				</tr>");
		}
		?>
		<?php
		if (!empty($result['weight'])) {
			echo ("<tr>
		                <th>Weight</th>
		                <td>" . $result['weight'] . " kg</td>
				</tr>");
		}
		?>
		<?php
		if (!empty($result['height'])) {
			echo ("<tr>
		                <th>Height</th>
		                <td>" . $result['height'] . " m</td>
				</tr>");
		}
		?>
		<?php
		if (!empty($result['story'])) {
			echo ("<tr>
		                <th>Story</th>
		                <td>" . $result['story'] . "</td>
				</tr>");
		}
		?>
		<?php
		if ((!empty($result['bust'])) && (!empty($result['waist'])) && (!empty($result['hip']))) {
			echo ("<tr>
		                <th>Sizes</th>
		                <td>" . $result['bust'] . " | " . $result['waist'] . " | " . $result['hip'] . " cm</td>
				</tr>");
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
	function displayImage(img) {
		let div = document.createElement("div");
		let copy = document.createElement("img");
		copy.src = img.src;
		div.id = "popup";
		div.appendChild(copy);
		document.body.insertBefore(div, document.body.firstChild);
		img.style.display = "none"; // hide original image
		div.addEventListener("click", () => {
			document.body.removeChild(div)
			img.style.display = "unset";
		});
	}

	// shorten length of rows next to image
	var img = document.getElementsByTagName("img");
	if (img.length != 0) {
		img = img[0] // first image
		var rows = Array.from(document.getElementsByTagName("tr"));
		rows.forEach((tr) => {
			if (tr.offsetTop < img.height) {
				tr.classList.add("aside");
			}
		});
		img.addEventListener("click", () => {
			displayImage(img);
		});
	}
	// hide content of rows that are "taller" than 30% of the viewport width and show only preview
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