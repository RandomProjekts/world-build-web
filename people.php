<?php
	header("Content-type:application/json");
	$conn = require (__DIR__ . "/scripts/connection.php");
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	} else {
		header('HTTP Error 404: Not Found', 404);
		exit();
	}

	// Query
	$query = $conn->prepare("SELECT * FROM people where id=?");
	$query->bind_param('i', $id);
	$query->execute();
	$result = $query->get_result()->fetch_assoc();

	if (empty($result)) {
		header('HTTP Error 404: Not Found', 404);
		exit();
	}
	function makeJson($index, $last=FALSE) {
		global $result,$output;
		if (isset($result[$index])) { 
			$output->$index = $result[$index];
		}
	}
	$output = new stdClass();
	makeJson('gender');
	makeJson('birth-day');
	makeJson('birth-year');
	makeJson('story');
?>
{
			"name": "<?= $result['name'] ?>",
			"gender": "<?= $result['gender'] ?>",
			<?php if (file_exists("./img/" . $result['name'] . ".jpg")) { echo '"imglink": "/img/' . $result['name'] . '.jpg",'; }
			if (file_exists("./img/" . $result['name'] . "_icon.png")) { echo '"iconlink": "/img/' . $result['name'] . '_icon.png",'; }
			
			if ((!empty($result['bust'])) || (!empty($result['waist'])) || (!empty($result['hip']))) {
				echo '"body-measurements": {';
				makeJson('weight');
				makeJson('height');
				makeJson('bust');
				makeJson('waist');
				makeJson('hip', TRUE);
				echo '}';
			}
			?>
}
<?php
echo json_encode($output);
// this may be an option \/
// echo json_encode($result);
$conn->close();
?>