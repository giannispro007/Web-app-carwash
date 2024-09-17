<?php
require_once 'includes/dbh.inc.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['submit_appointment'])) {
    // Process form submission
    $appointment_date = $_POST['date'];
    $appointment_time = $_POST['time'];
    $phone_number = $_POST['phone_number'];
    $name = $_POST['name'];
    $surname = $_POST['surname']; // Corrected 'surname' key
    $license_plate_number = $_POST['license_plate_number'];
    $email = $_POST['email'];
    $additional_info = $_POST['additional_info'];

    try {
        // Insert appointment details into the appointments table
        $stmt = $pdo->prepare("INSERT INTO appointments (user_id, appointment_date, appointment_time, phone_number, name, surname, license_plate_number, email, additional_info) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $appointment_date, $appointment_time, $phone_number, $name, $surname, $license_plate_number, $email, $additional_info]);

        // Redirect to the index page or any other page as needed
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        // Display error message if something goes wrong with the database query
        echo "Error: " . $e->getMessage();
    }
}
?>
