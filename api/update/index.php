<?php
include("../../configs/_config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $portId = mysqli_real_escape_string($db, $_POST['portId']);

    $sql = "UPDATE ports SET status = 1 WHERE id = " . $portId;
    if (mysqli_query($db, $sql)) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 0;
}

?>