<?php
session_start();
// if (!isset($_SESSION['membership']) || empty($_SESSION['membership'])) {
//     header('Location: login.php');
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex,nofollow" />
    <title>BRRC Ports Dashboard - Add User</title>
    <link href="../css/bootstrap-custom.min.css" rel="stylesheet">
    <link href="../css/global.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="text-center">
            <div class="spacer50"></div>
            <img src="../img/logo.gif" alt="BRRC Logo" />
            <h4>BRRC Ports Management</h4>
            <div class="spacer50"></div>
        </div>
        <div class="col-xs-12 col-sm-8 col-md-4 align-center">
            <div id="signup-error" class="alert alert-danger" style="display: none">
                <strong>Sorry!</strong> Username, Email or Member ID already has login.
            </div>
            <div id="username-error" class="alert alert-warning" style="display: none">
                Username field is empty!.
            </div>
            <div id="email-error" class="alert alert-warning" style="display: none">
                email field is empty!.
            </div>
            <div id="member-error" class="alert alert-warning" style="display: none">
                member field is empty!.
            </div>
            <div id="password-error" class="alert alert-warning" style="display: none">
                password field is empty!.
            </div>
            <br>
            <form action="" method="post" id="signupForm">
            <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" aria-describedby="name" placeholder="Enter Name">
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="email" placeholder="Enter Email">
                </div>
                <div class="form-group">
                    <label for="membership">Membership Id</label>
                    <input type="text" class="form-control" name="membership" id="membership" aria-describedby="membership" placeholder="Enter Membership Id">
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" aria-describedby="username" placeholder="Enter username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                </div>
                <button type="submit" id="signup" class="btn btn-primary">Sign Up</button>
            </form>
        </div>
    </div>
    <script src="../js/signup.js" type="text/javascript"></script>
</body>

</html>