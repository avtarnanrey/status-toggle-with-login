<?php
include("../../configs/_config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $portId = mysqli_real_escape_string($db, $_POST['portId']);
    $reportId = mysqli_real_escape_string($db, $_POST['reportId']);

    $sql = "UPDATE ports SET status = 1 WHERE id = " . $portId;
    $reportSql = "UPDATE reports SET report_status = 'resolved' WHERE id = " . $reportId;
    if (mysqli_query($db, $sql) && mysqli_query($db, $reportSql)) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 0;
}

?>