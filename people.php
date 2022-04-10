<!DOCTYPE html>
<html>

<head>
	<?php
	$conn = require (__DIR__ . "/scripts/connection.php");
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	} else {
		# echo ("no person selected");
		echo "
					<title>People</title>
					<link rel='icon' href='./img/default_icon.png'>
					<link rel='stylesheet' href='./css/fonts.css'>
					<link rel='stylesheet' href='/css/menu_people.css'>
					";
		require_once (__DIR__ . "/scripts/menus.php");
		peopleMenu();
		exit();
	}

	// Query
	$query = $conn->prepare("SELECT * FROM people where id=?");
	$query->bind_param('i', $id);
	$query->execute();
	$result = $query->get_result()->fetch_assoc();

	if (empty($result)) {
		echo "Does not exist";
		echo "<title>People</title>";
		exit();
	}

	?>
	<title><?= $result['name'] ?> - People</title>
<meta charset="utf-8">
	<?php
	if (file_exists("./img/$result[name]_icon.png")) {
		echo "<link rel='icon' href='./img/$result[name]_icon.png'>";
	}
	?>
	<link rel="stylesheet" href="./css/fonts.css">
	<link rel="stylesheet" href="./css/people.css">
	<link rel="stylesheet" href="./css/peopleSmall.css" media="all and (max-aspect-ratio: 3/5)">
	<script src="/scripts/people_styling.js"></script>
</head>

<body>
	<a href="people.php">Back to TOC</a>
	<table role="main">
		<caption>
			<h1><?=$result['name']?></h1>
		</caption>

		<?php
		$imgpath = "./img/$result[name].jpg";
		if (file_exists($imgpath)) {
			echo "<link rel='stylesheet' href='./css/rowFix.css'>";
			echo "
			                <tr>
			                    <td><img src='$imgpath'></img></td>
			                </tr>
			                ";
		}
		?>
		<tr>
			<th>Gender</th>
			<td><?php
			switch ($result['gender']) {
				case 'f':
				echo 'Female';
				break;
				case 'm':
				echo 'Male';
				break;
				case 'd':
				echo 'Non-Binary';
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
			                <td>$result[weight]&nbsp;kg</td>
					</tr>");
		}
		?>
		<?php
		if (!empty($result['height'])) {
			echo ("<tr>
			                <th>Height</th>
			                <td>$result[height]&nbsp;m</td>
					</tr>");
		}
		?>
		<?php
		if (!empty($result['story'])) {
			echo ("<tr>
			                <th>Story</th>
			                <td>$result[story]</td>
					</tr>");
		}
		?>
		<?php
		if ((!empty($result['bust'])) && (!empty($result['waist'])) && (!empty($result['hip']))) {
			echo ("<tr>
			                <th>Sizes</th>
			                <td>$result[bust] | $result[waist] | $result[hip]&nbsp;cm</td>
					</tr>");
		}
		?>

	</table>
	<a href="people.php?id=<?= $id-1 ?>">prev</a>
	<a href="people.php?id=<?= $id+1?>">next</a>
</body>

<?php
// Main color of color sheme (appearance image) and version with alpha = 0
if (file_exists($imgpath)) {
	require_once (__DIR__ . "/scripts/themecolor.php");
	if (empty($result['themecolor'])) {
		$themecolor = findthemecolor(__DIR__ . "/" . $imgpath); // imgpath adjusted for colorextract script
	} else {
		$themecolor = adjustlightness($result['themecolor']);
	}

	if (!empty($themecolor)) {
		echo "
	<style>
		:root {
			--rowcolor: $themecolor;
			--rowcolor-transparent: " . $themecolor . "00;
		}
	</style>
	";
	}
}

$conn->close();
?>

</html>