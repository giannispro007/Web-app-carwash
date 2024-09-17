<?php

require_once 'includes/config_session.inc.php';
require_once 'includes/signup_view.inc.php';
require_once 'includes/login_view.inc.php';
require_once 'includes/dbh.inc.php';

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <link
            rel="stylesheet"
            href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link
            href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i"
            rel="stylesheet">
        <title>All Appointments</title>

        <style></style>
    </head>
    <body>
    <div class="navbar row fixed-top no-gutters">
        <div class="col-3 d-flex justify-content-start">
            <?php if (isset($_SESSION["user_id"])) :?>
                <a class="home-btn" href="box.php">
                    <div class="row align-items-center no-gutters">
                        <div class="col-3">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="20"
                                height="20"
                                fill="#fff"
                                class="bi bi-house-door"
                                viewbox="0 0 20 20">
                                <path
                                    d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4z"/>
                            </svg>
                        </div>
                        <div class="col-9 logout-btn-text">
                            Home
                        </div>
                    </div>
                </a>
            <?php endif; ?>
        </div>
        <div class="col-6">
            <h2>All Appointments</h2>
        </div>
        <div class="col-3 d-flex justify-content-end">
            <?php if (isset($_SESSION["user_id"])) :  ?>
                <a class="logout-btn" href="includes/logout.inc.php">
                    <div class="row align-items-center no-gutters">
                        <div class="col-9 logout-btn-text">
                            Logout
                        </div>
                        <div class="col-3">
                            <svg fill="#ffffff" height="800px" width="800px" version="1.1" id="Capa_1" 
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                    viewBox="0 0 384.971 384.971" xml:space="preserve">
                                <g>
                                    <g id="Sign_Out">
                                        <path d="M180.455,360.91H24.061V24.061h156.394c6.641,0,12.03-5.39,12.03-12.03s-5.39-12.03-12.03-12.03H12.03
                                            C5.39,0.001,0,5.39,0,12.031V372.94c0,6.641,5.39,12.03,12.03,12.03h168.424c6.641,0,12.03-5.39,12.03-12.03
                                            C192.485,366.299,187.095,360.91,180.455,360.91z"/>
                                        <path d="M381.481,184.088l-83.009-84.2c-4.704-4.752-12.319-4.74-17.011,0c-4.704,4.74-4.704,12.439,0,17.179l62.558,63.46H96.279
                                            c-6.641,0-12.03,5.438-12.03,12.151c0,6.713,5.39,12.151,12.03,12.151h247.74l-62.558,63.46c-4.704,4.752-4.704,12.439,0,17.179
                                            c4.704,4.752,12.319,4.752,17.011,0l82.997-84.2C386.113,196.588,386.161,188.756,381.481,184.088z"/>
                                    </g>
                                </g>
                            </svg>
                        </div>
                    </div>
                </a>
            <?php endif; ?>
        </div>
    </div>

        <div class="appointments-container mt-5">
        <?php
require_once 'includes/dbh.inc.php'; // Include your database connection file

// Retrieve all appointments from the database
try {
    $stmt = $pdo->query("SELECT * FROM appointments");
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Check if appointments were found
if ($appointments) {
    // Display the list of appointments
    echo "<h2></h2>";
    echo "<ul>";
    foreach ($appointments as $appointment) {
        // Retrieve user information associated with the appointment
        $user_id = $appointment['user_id'];
        $stmt_user = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt_user->execute([$user_id]);
        $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

        // Display appointment details
        echo "<li>";
        echo "User: " . $user['username'] . " | ";
        echo "Date: " . $appointment['appointment_date'] . " | ";
        echo "Time: " . $appointment['appointment_time'];
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "No appointments found.";
}
?>

        </div>

        <div class="col-12 text-center mb-5">
            <a href="box.php" class="back-btn">Back</a>
        </div>

    </body>
</html>