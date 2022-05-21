<?php
	require_once 'scripts/Connection.class.php';
?><!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Credit</title>
    </head>
    <body>
		<ul>
			<?php
				$conn = (new Connection())->getConection();
				$query = $conn->prepare("SELECT * FROM credits");
				$query->execute();
				$result = $query->get_result();
				foreach($result as $row) {
					echo "<li><a href=\"$row[site]\">$row[name]</a></li>";
				}
			?>
		</ul>
    </body>
</html>
