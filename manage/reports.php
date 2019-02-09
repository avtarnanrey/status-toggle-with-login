<?php
include_once("../configs/_config.php");

$last10Query = "SELECT * FROM reports ORDER BY id ASC LIMIT 10";
$mostReportedPortQuery = "SELECT port_id, COUNT(*) c FROM reports GROUP BY name HAVING c > 1 ORDER BY c DESC LIMIT 1";

$reportArray = array();

if ($result = $mysqli->query($last10Query)) {
	//Cycle through the results, and build up the result array

	while ($line = $result->fetch_assoc()) {
		$reportArray[$line['id']] = $line;
	}
	/* free result set */
	$result->free();
}

$mostReportedResult = mysqli_query($db, $mostReportedPortQuery);
$mostReportedRow = mysqli_fetch_assoc($mostReportedResult);

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
    <link href="../css/bootstrap-custom.min.css" rel="stylesheet">
    <link href="../css/global.css" rel="stylesheet">
</head>

<body>
    <div class="header container">
	<nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#brrcPortNav" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">BRRC Port Status</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="brrcPortNav">
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Update Status</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="reports.php">Reports
						<span class="sr-only">(current)</span>
					</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    </div>
    <div class="container">

	<?php

// $header = '';

// $status = '';

// $comments = '';

// $report = '';

// $rows = '';

// foreach ($portArray as $port) {

// 	$header .= '<th class="text-center no-break">Port ' . $port['id'] . '</th>';

// 	$status .= '<td class="text-center">' . ($port['status'] == 1 ? '<span class="label label-success">Up</span>' : '<span class="label label-danger">Down</span>') . '</td>';

// 	$comments .= '<td class="text-center">' . $port['comments'] . '</td>';



// 		//Determine if there is a pending issue report

// 	if ($port['created_at'] === null) {

// 		$reportText = '<a href="report.php?port_id=' . $port['id'] . '&type=report">Report</a>';

// 	} else {

// 		$reportText = '<span>Reported on ' . date('Y/m/d', strtotime($port['created_at'])) . '</span>';

// 	}



// 	$report .= '<td class="text-center">' . $reportText . '</td>';



// 	$rows .= '<tr>';

// 	$rows .= '<th class="no-break">Port ' . $port['id'] . '</th>';

// 	$rows .= '<td class="text-center">' . ($port['status'] == 1 ? '<span class="label label-success">Up</span>' : '<span class="label label-danger">Down</span>') . '</td>';

// 	$rows .= '<td>' . $port['comments'] . '</td>';

// 	$rows .= '<td>' . $reportText . '</td>';

// 	$rows .= '</tr>';

// }

?>
		<div class="col-xs-12 col-sm-4">
			<div class="text-center mostReportedContainer">
				<h3 class="text-uppercase">Most Reported Port</h3>
				<div class="txtSizeBig text-danger"><?php echo $mostReportedRow['port_id']; ?></div>
				<div class="lead">Reported <strong><?php echo $mostReportedRow['c']; ?></strong> Times</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-8">
			<h3 class="text-uppercase">Recent 10 Reports</h3>
			<ul class="list-group">
				<li class="list-group-item recentReports">
					<span class="port_id text-uppercase text-primary"><strong>Port</strong></span>
					<span class="name text-uppercase text-primary"><strong>Name</strong></span>
					<span class="membership_id text-uppercase text-primary"><strong>Membership ID</strong></span>
					<span class="comment text-uppercase text-primary"><strong>Comment</strong></span>
					<span class="status text-uppercase text-primary"><strong>Status</strong></span>
				</li>
				<?php
			foreach ($reportArray as $report) {
				$textAlert = ($report['report_status'] == 'pending') ? "text-danger" : "";
				echo '<li class="list-group-item recentReports">
						<span class="port_id">' . $report['port_id'] . '</span>
						<span class="name">' . $report['name'] . '</span>
						<span class="membership_id">' . $report['membership_id'] . '</span>
						<span class="comment">' . $report['comment'] . '</span>
						<span class="status ' . $textAlert . '">' . $report['report_status'] . '</span>
					</li>';
			}
			?>
			</ul>
		</div>
    </div>

	</body>

</html>





<?php

$mysqli->close();

?>