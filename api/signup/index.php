<?php
include("../../configs/_config.php");
session_start();

// States
$username_exists = false;
$email_exists = false;
$member_exists = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
    $myname = mysqli_real_escape_string($db, $_POST['name']);
    $myemail = mysqli_real_escape_string($db, $_POST['email']);
    $mymembership = mysqli_real_escape_string($db, $_POST['membership']);
    $myusername = mysqli_real_escape_string($db, $_POST['username']);
    $mypassword = mysqli_real_escape_string($db, crypt($_POST['password'], SALT));

    // Check if username exists
    $usernameCheckSQL = "SELECT username FROM users WHERE username = '$myusername'";
    $result = mysqli_query($db, $usernameCheckSQL);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if (mysqli_num_rows($result) > 0) {
        $username_exists = true;
    }

    // Check if email exists
    $emailCheckSQL = "SELECT email FROM users WHERE email = '$myemail'";
    $result = mysqli_query($db, $emailCheckSQL);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if (mysqli_num_rows($result) > 0) {
        $email_exists = true;
    }

    // Check if membership id is exists
    $membershipCheckSQL = "SELECT membership_id FROM users WHERE membership_id = '$mymembership'";
    $result = mysqli_query($db, $membershipCheckSQL);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if (mysqli_num_rows($result) > 0) {
        $member_exists = true;
    }

    if ($username_exists == false && $email_exists == false && $member_exists == false) {
        $sql = "INSERT INTO users (name, email, membership_id, username, password) VALUES ('$myname', '$myemail', '$mymembership', '$myusername', '$mypassword')";

        if ($db->query($sql) === true) {
            echo 1;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo 0;
    }
} else {
    echo 0;
}

?>