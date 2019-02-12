<?php
include("../../configs/_config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 

    $myusername = mysqli_real_escape_string($db, $_POST['username']);
    $mypassword = mysqli_real_escape_string($db, crypt($_POST['password'], SALT));

// $myObj = new stdClass();
// $myObj->name = "Janta";
// $myObj->age = 30;
// $myObj->password = "Singh";
// $arr = 'data' => $myObj
// echo json_encode($myObj);
    $sql = "SELECT * FROM users WHERE username = '$myusername' and password = '$mypassword'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    // $active = $row['active'];

    $count = mysqli_num_rows($result);

    function updateLastLogin($db, $user)
    {
        $sql = "UPDATE `users` SET last_login=now() WHERE username = '$user'";
        $result = mysqli_query($db, $sql);
    }

      // If result matched $myusername and $mypassword, table row must be 1 row

    if ($count == 1) {
        $_SESSION['membership'] = $row['membership_id'];
        $_SESSION['login_user'] = $myusername;
        $_SESSION['name'] = $row['name'];
        $_SESSION['email'] = $row['email'];
        updateLastLogin($db, $myusername);
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 0;
}

?>