<?php
include("../../configs/_config.php");
?>

<!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<meta name="description" content="">

	<meta name="author" content="">

	<meta name="robots" content="noindex,nofollow"/>



	<title>BRRC Port Status - Report Submitted</title>



	<link href="bootstrap.min.css" rel="stylesheet" />

</head>



<body>



<?php

//$portId = isset($_GET['port_id']) && is_numeric($_GET['port_id']) && $_GET['port_id'] > 0 && $_GET['port_id'] < 12 ? $_GET['port_id'] : null;

//

////If someone is fucking with us, get out of here

//if ($portId === null) redirect('/status.php');



$portId = $_POST['port_id'];

$portDown = $_POST['port_down'];

$name = $_POST['name'];

$description = $_POST['description'];





if ($portDown == 1) {

//Update the status of the port

	$sql = "UPDATE ports p SET status = 0 WHERE p.id = ?;";



	if (!($stmt = $mysqli->prepare($sql))) {

		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;

		die();

	}



	if (!$stmt->bind_param("i", $portId)) {

		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;

	}



	if (!$stmt->execute()) {

		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;

	}



	$stmt->close();
}



//Submit the report

$insertSQL = "INSERT INTO reports (port_id, name, comment, reported_port_status) VALUES (?, ?, ?, ?);";



if (!($insertStmt = $mysqli->prepare($insertSQL))) {

	echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;

	die();

}



if (!$insertStmt->bind_param("issi", $portId, $name, $description, $portDown)) {

	echo "Binding parameters failed: (" . $insertStmt->errno . ") " . $insertStmt->error;

}



if (!$insertStmt->execute()) {

	echo "Execute failed: (" . $insertStmt->errno . ") " . $insertStmt->error;

}



$insertStmt->close();

//Send mail

$to = 'eaperry@rogers.com';

$subject = "Port #$portId report";

$message = "Port #$portId needs attention\n $description";

$headers = 'From: ports@rangeburlington.ca' . "\r\n" .

	'Reply-To: noreply@rangeburlington.ca' . "\r\n" .

	'X-Mailer: PHP/' . phpversion();



mail($to, $subject, $message, $headers);



?>

<div class="container">



	<h3>Your issue has been submitted. Thanks!</h3>

	<hr />

	<p><a href="/index.php">Back to Status Board</a></p>



</div>

</body>

</html>



<?php

function redirect($uri = '', $method = 'auto', $code = null)

{

	// IIS environment likely? Use 'refresh' for better compatibility

	if ($method === 'auto' && isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== false) {

		$method = 'refresh';

	} elseif ($method !== 'refresh' && (empty($code) or !is_numeric($code))) {

		if (isset($_SERVER['SERVER_PROTOCOL'], $_SERVER['REQUEST_METHOD']) && $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1') {

			$code = ($_SERVER['REQUEST_METHOD'] !== 'GET')

				? 303	// reference: http://en.wikipedia.org/wiki/Post/Redirect/Get

			: 307;

		} else {

			$code = 302;

		}

	}



	switch ($method) {

		case 'refresh':

			header('Refresh:0;url=' . $uri);

			break;

		default:

			header('Location: ' . $uri, true, $code);

			break;

	}

	exit;

}



?>





<?php

$mysqli->close();

?>