<?php
include("../configs/_config.php");
session_start();
if (!isset($_SESSION['membership']) || empty($_SESSION['membership'])) {
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="nofollow, noindex" />
    <title>Dashboard - BRRC Ports Status</title>
    <link href="../css/bootstrap-custom.min.css" rel="stylesheet" >
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
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Update Status
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reports.php">Reports</a>
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

    $lookupQuery = "SELECT * FROM ports
    ORDER BY id ASC;";

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

<?php
$header = '';
$status = '';
$comments = '';
$report = '';
$rows = '';
$reportText = '';
$updateText = '';

foreach ($portArray as $port) {

    $header .= '<th class="text-center no-break">Port ' . $port['id'] . '</th>';

    $status .= '<td class="text-center">' . ($port['status'] == 1 ? '<span class="label label-success">Up</span>' : '<span class="label label-danger">Down</span>') . '</td>';

    if ($port['status'] == 0) {
        $statusQuery = "SELECT id, comment, created_at FROM reports WHERE port_id = " . $port['id'] . " ORDER BY `id` DESC LIMIT 1";
        if ($result = $mysqli->query($statusQuery)) {
            while ($line = $result->fetch_assoc()) {
                $comments = '<span class="text-center">' . $line['comment'] . '</span>';
                $reportDate = '<span>Reported on ' . date('Y/m/d', strtotime($line['created_at'])) . '</span>';
                $updateText = '<button class="btn btn-primary" id="updatePort" data-port="' . $port['id'] . '" data-report="' . $line['id'] . '">Update</button>';
            }
        }
    } else {
        $comments = "";
        $reportDate = "";
        $updateText = "";
    }

    $report .= '<td class="text-center">' . $reportDate . '</td>';

    $rows .= '<tr>';

    $rows .= '<th class="no-break">Port ' . $port['id'] . '</th>';

    $rows .= '<td class="text-center">' . ($port['status'] == 1 ? '<span class="label label-success">Up</span>' : '<span class="label label-danger">Down</span>') . '</td>';

    $rows .= '<td>' . $comments . '</td>';

    $rows .= '<td>' . $reportDate . '</td>';

    $rows .= '<td>' . $updateText . '</td>';

    $rows .= '</tr>';

}

?>

	<div class="container">
        <br><br>
		<div class="">
			<table class="table table-bordered table-hover table-striped table-condensed">
				<thead>

					<tr>

						<th>&nbsp;</th>

						<th>Status</th>

						<th>Comments</th>

                        <th>Report Date</th>
                        
                        <th>Update Staus</th>

					</tr>

				</thead>

				<tbody>

				<?php echo $rows; ?>

				</tbody>

			</table>

		</div>

		<p>Use the "Report" link under any of the ports to report a problem.  Please review the comments to avoid reporting an issue that is already known.</p>

	</div>




<?php

$mysqli->close();

?>
<script src="../js/update.js" type="text/javascript"></script>
</body>

</html>