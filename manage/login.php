<?php
session_start();
if (isset($_SESSION['membership']) || !empty($_SESSION['membership'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex,nofollow" />
    <title>BRRC Ports Dashboard - Login</title>
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
            <div id="login-error" class="alert alert-danger" style="display: none">
                <strong>Sorry!</strong> Username of password combination is wrong.
            </div>
            <div id="username-password-error" class="alert alert-warning" style="display: none">
                Username or password field is empty!.
            </div>
            <br>
            <form action="" method="post" id="loginForm">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" aria-describedby="username" placeholder="Enter username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                </div>
                <button type="submit" id="login" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
    <script src="../js/login.js" type="text/javascript"></script>
</body>

</html>