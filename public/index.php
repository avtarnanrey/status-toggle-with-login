<?php
include_once("../configs/_config.php");

$lookupQuery = "

	SELECT p.*, r.created_at, r.name, r.comment

	FROM ports p

	LEFT JOIN reports r ON r.port_id = p.id AND r.report_status = 'pending'

	ORDER BY p.id ASC;";



$portArray = array();

if ($result = $mysqli->query($lookupQuery)) {
	//Cycle through the results, and build up the result array

	while ($line = $result->fetch_assoc()) {
		$portArray[$line['id']] = $line;
	}
	/* free result set */
	$result->free();
}

//else{

//	die('Query failed: ' . $mysqli->error . "\n");

//}



//Now output the doc format for the page:

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



		<title>BRRC Port Status</title>



		<link href="../css/bootstrap-custom.min.css" rel="stylesheet" />

		<link href="../css/global.css" rel="stylesheet" />

	</head>



	<body>

	<?php

$header = '';

$status = '';

$comments = '';

$report = '';

$rows = '';

foreach ($portArray as $port) {

	$header .= '<th class="text-center no-break">Port ' . $port['id'] . '</th>';

	$status .= '<td class="text-center">' . ($port['status'] == 1 ? '<span class="label label-success">Up</span>' : '<span class="label label-danger">Down</span>') . '</td>';

	$comments .= '<td class="text-center">' . ($port['status'] == 0 ? $port['comment'] : '') . '</td>';



		//Determine if there is a pending issue report

	if ($port['status'] == 1) {

		$reportText = '<a href="report.php?port_id=' . $port['id'] . '&type=report">Report</a>';

	} else {

		$reportText = '<span>Reported on ' . date('Y/m/d', strtotime($port['created_at'])) . '</span>';

	}



	$report .= '<td class="text-center">' . $reportText . '</td>';



	$rows .= '<tr>';

	$rows .= '<th class="no-break">Port ' . $port['id'] . '</th>';

	$rows .= '<td class="text-center">' . ($port['status'] == 1 ? '<span class="label label-success">Up</span>' : '<span class="label label-danger">Down</span>') . '</td>';

	$rows .= '<td>' . $port['comment'] . '</td>';

	$rows .= '<td>' . $reportText . '</td>';

	$rows .= '</tr>';

}

?>

	<div class="container">

		<h3>BRRC Port Status Board</h3>

		<div class="hidden-xs">

			<table class="table table-bordered table-hover table-condensed">

			<thead>

				<tr>

					<th>&nbsp;</th>

					<?php echo $header; ?>

				</tr>

			</thead>

			<tbody>

				<tr>

					<th>Status</th>

					<?php echo $status; ?>

				</tr>

				<tr>

					<th>Comments</th>

					<?php echo $comments; ?>

				</tr>

				<tr>

					<th>Report Issue</th>

					<?php echo $report; ?>

				</tr>

			</tbody>

		</table>

		</div>



		<div class="visible-xs">

			<table class="table table-bordered table-hover table-striped table-condensed">

				<thead>

					<tr>

						<th>&nbsp;</th>

						<th>Status</th>

						<th>Comments</th>

						<th>Problems</th>

					</tr>

				</thead>

				<tbody>

				<?php echo $rows; ?>

				</tbody>

			</table>

		</div>

		<p>Use the "Report" link under any of the ports to report a problem.  Please review the comments to avoid reporting an issue that is already known.</p>

	</div>

	</body>

</html>





<?php

$mysqli->close();

?>