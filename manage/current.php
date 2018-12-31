<?php
include_once("./configs/_config.php");

$lookupQuery = "

	SELECT p.*, r.created_at, r.name

	FROM ports p

	LEFT JOIN reports r ON r.port_id = p.id AND r.status = 'pending'

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="nofollow, noindex" />
    <title>Dashboard - BRRC Ports Status</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
    <link href="css/global.css" rel="stylesheet">
</head>

<body>
    <div class="header container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light d-flex justify-content-between">
            <a class="navbar-brand" href="#">BRRC Port Status</a>

            <div class="" id="navbarSupportedContent">
                <div class="form-inline my-2 my-lg-0">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="home.php">Update Status</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="current.php">Current Status
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="container">

	<?php

$header = '';

$status = '';

$comments = '';

$report = '';

$rows = '';

foreach ($portArray as $port) {

    $header .= '<th class="text-center no-break">Port ' . $port['id'] . '</th>';

    $status .= '<td class="text-center">' . ($port['status'] == 1 ? '<span class="label label-success">Up</span>' : '<span class="label label-danger">Down</span>') . '</td>';

    $comments .= '<td class="text-center">' . $port['comments'] . '</td>';



		//Determine if there is a pending issue report

    if ($port['created_at'] === null) {

        $reportText = '<a href="report.php?port_id=' . $port['id'] . '&type=report">Report</a>';

    } else {

        $reportText = '<span>Reported on ' . date('Y/m/d', strtotime($port['created_at'])) . '</span>';

    }



    $report .= '<td class="text-center">' . $reportText . '</td>';



    $rows .= '<tr>';

    $rows .= '<th class="no-break">Port ' . $port['id'] . '</th>';

    $rows .= '<td class="text-center">' . ($port['status'] == 1 ? '<span class="label label-success">Up</span>' : '<span class="label label-danger">Down</span>') . '</td>';

    $rows .= '<td>' . $port['comments'] . '</td>';

    $rows .= '<td>' . $reportText . '</td>';

    $rows .= '</tr>';

}

?>

		<br><br>

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