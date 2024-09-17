<?php

require_once 'includes/config_session.inc.php';
require_once 'includes/signup_view.inc.php';
require_once 'includes/login_view.inc.php';
require_once 'includes/dbh.inc.php';

?>
<!DOCTYPE html>
<html lang="el">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">

        <style></style>
        <title>CarWash</title>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <link
            rel="stylesheet"
            href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link
            href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i"
            rel="stylesheet">

    </head>
    <body>
        <div class="navbar">
            <h2>CarWash</h2>
        </div>
        <?php if (!isset($_SESSION["user_id"])) { ?>
        <div class="login-form-wrapper">
            <h3 class="mb-2">Sign up</h3>
            <form action="includes/signup.inc.php" method="post">
                <input type="text" class="input-field" name="username" placeholder="Username">
                <input type="password" class="input-field" name="pwd" placeholder="Password">
                <input type="email" class="input-field" name="email" placeholder="Email">
                <button class="login-btn" type="submit">Signup</button>
                <a class="signup-btn" href="index.php">Return to login</a>
            </form>
        </div>

        <?php } ?>

        <?php
check_login_errors();
?>

    </body>
</html>