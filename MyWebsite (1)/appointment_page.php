<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/signup_view.inc.php';
require_once 'includes/login_view.inc.php';
require_once 'includes/dbh.inc.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle appointment deletion
if (isset($_POST['delete_appointment'])) {
    $appointment_id = $_POST['delete_appointment'];
    try {
        $stmt_delete = $pdo->prepare("DELETE FROM appointments WHERE id = ?");
        $stmt_delete->execute([$appointment_id]);
        echo "Appointment deleted successfully.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Handle appointment submission or update
if (isset($_POST['submit_appointment'])) {
    // Sanitize and validate input before using in SQL queries
    $appointment_date = $_POST['date'];
    $appointment_time = $_POST['time'];
    $phone_number = $_POST['phone_number'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $license_plate_number = $_POST['license_plate_number'];
    $email = $_POST['email'];
    $additional_info = $_POST['additional_info'];
    $edit_appointment_id = $_POST['edit_appointment_id'];

    try {
        if ($edit_appointment_id) {
            // Update existing appointment
            $stmt_update = $pdo->prepare("UPDATE appointments SET appointment_date = ?, appointment_time = ?, phone_number = ?, name = ?, surname = ?, license_plate_number = ?, email = ?, additional_info = ? WHERE id = ?");
            $stmt_update->execute([$appointment_date, $appointment_time, $phone_number, $name, $surname, $license_plate_number, $email, $additional_info, $edit_appointment_id]);
            echo "Appointment updated successfully.";
        } else {
            try {
                // Insert new appointment
                $stmt_insert = $pdo->prepare("INSERT INTO appointments (user_id, appointment_date, appointment_time, phone_number, name, surname, license_plate_number, email, additional_info) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt_insert->execute([$user_id, $appointment_date, $appointment_time, $phone_number, $name, $surname, $license_plate_number, $email, $additional_info]);
                echo "Appointment scheduled successfully.";
            } catch (\Throwable $th) {
                echo "Appointment day already shecudled!";
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Appointment Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .action-buttons {
            display: flex;
            align-items: center;
        }

        .action-buttons button {
            margin-right: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            min-width: 70px; /* Adjust the width as needed */
        }

        /* Style for the delete button */
        .action-buttons .delete-button {
            width: 70px; /* Set a fixed width for delete button */
        }
    </style>
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
            <h2>Appointment Page</h2>
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
<h3>
    <?php
    // output_username();
    ?>
</h3>



<?php 

$currentDateTimestamp = strtotime($_GET['date']);
$yesterday = strtotime($_GET['date'] . "-1 day");
$tommorow = strtotime($_GET['date'] . "+1 day");

$today = date("Y-m-d", time());
$yestardayDate = date("Y-m-d", $yesterday);

$shouldShowYesterday = $today <= $yestardayDate;


?>

<div class="appointment-timetable-wrapper">
    <div class="row calendar-header mt-5 no-gutters">
        <div class="col-12 current-date-wrapper d-flex justify-content-center align-items-center">
            <?php if($shouldShowYesterday) : ?>
                <a href="?date=<?=date("Y-m-d", $yesterday)?>" class="prev-next-arrow">
                    <
                </a>
            <?php endif; ?>
            <h2><?=date("d F Y", $currentDateTimestamp)?></h2>
            <a href="?date=<?=date("Y-m-d", $tommorow)?>" class="prev-next-arrow">
                >
            </a>
        </div>
    </div>
    <table class="appointment-timeslots-table">
        <tr>
            <th>Time</th>
            <th>Action</th>
        </tr>

        <?php
        // Define the start and end time for appointments
        $start_time = strtotime('8:00 AM');
        $end_time = strtotime('8:00 PM');

        // Loop through each 15-minute interval and display as appointment slots
        for ($current_time = $start_time; $current_time <= $end_time; $current_time += 900) { // 900 seconds = 15 minutes
            $formatted_time = date('H:i', $current_time); // Format time as HH:MM
            $formatted_date = $_GET['date']; // Use the date provided via GET parameter

            // Check if the appointment slot is already booked
            $stmt_check = $pdo->prepare("SELECT * FROM appointments WHERE appointment_date = ? AND appointment_time = ?");
            $stmt_check->execute([$formatted_date, $formatted_time]);
            $row = $stmt_check->fetch(PDO::FETCH_ASSOC); ?>
            <tr>
                <td class="appointment-time <?= !$row ? 'green' : 'red' ?>">
                    <?=$formatted_time?>
                </td>
                <td class="appointment-actions row no-gutters">
                    <!-- todo : edit, view, delete actions -->

                    <?php if (is_array($row) && ($row['user_id'] == $user_id || $user_id == 1)) : ?>
                        <button class='col-4 action-btn btn btn-light' onclick='openViewPopup(
                            "<?=$formatted_date?>", 
                            "<?=$formatted_time?>", 
                            "<?=$row["phone_number"]?>", 
                            "<?=$row["name"]?>", 
                            "<?=$row["surname"]?>",
                            "<?=$row["license_plate_number"]?>", 
                            "<?=$row["email"]?>", 
                            "<?=$row["additional_info"]?>", 
                            "<?=$row["id"]?>")'>
                            <svg width="25px" height="25px" viewBox="0 0 1024 1024" 
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill="#000000" d="M512 160c320 0 512 352 512 352S832 864 512 864 0 512 0 512s192-352 512-352zm0 64c-225.28 0-384.128 208.064-436.8 288 52.608 79.872 211.456 288 436.8 288 225.28 0 384.128-208.064 436.8-288-52.608-79.872-211.456-288-436.8-288zm0 64a224 224 0 1 1 0 448 224 224 0 0 1 0-448zm0 64a160.192 160.192 0 0 0-160 160c0 88.192 71.744 160 160 160s160-71.808 160-160-71.744-160-160-160z"/></svg>
                        </button>
                            
                        <button class='col-4 action-btn btn btn-light' onclick='openEditPopup(
                            "<?=$formatted_date?>", 
                            "<?=$formatted_time?>", 
                            "<?=$row["phone_number"]?>", 
                            "<?=$row["name"]?>", 
                            "<?=$row["surname"]?>",
                            "<?=$row["license_plate_number"]?>", 
                            "<?=$row["email"]?>", 
                            "<?=$row["additional_info"]?>", 
                            "<?=$row["id"]?>")'>
                            <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none"  
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>

                        <form method='post' class="col-4">
                            <input type='hidden' name='delete_appointment' value="<?=$row['id']?>">
                            <button type='submit' class='action-btn btn btn-light'>
                                <svg  width="25px" height="25px" viewBox="0 0 1024 1024" 
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill="#000000" d="M160 256H96a32 32 0 0 1 0-64h256V95.936a32 32 0 0 1 32-32h256a32 32 0 0 1 32 32V192h256a32 32 0 1 1 0 64h-64v672a32 32 0 0 1-32 32H192a32 32 0 0 1-32-32V256zm448-64v-64H416v64h192zM224 896h576V256H224v640zm192-128a32 32 0 0 1-32-32V416a32 32 0 0 1 64 0v320a32 32 0 0 1-32 32zm192 0a32 32 0 0 1-32-32V416a32 32 0 0 1 64 0v320a32 32 0 0 1-32 32z"/></svg>
                            </button>
                        </form>
                    <?php elseif(!$row): ?>
                        <button class="col-12 btn btn-light action-btn" onclick='openPopup("<?=$formatted_date?>", "<?=$formatted_time?>")'>Select time slot</button>
                    <?php else: ?>
                        <button class='col-12 action-btn btn btn-light' onclick='openViewPopup(
                            "<?=$formatted_date?>", 
                            "<?=$formatted_time?>", 
                            "<?=$row["phone_number"]?>", 
                            "<?=$row["name"]?>", 
                            "<?=$row["surname"]?>",
                            "<?=$row["license_plate_number"]?>", 
                            "<?=$row["email"]?>", 
                            "<?=$row["additional_info"]?>", 
                            "<?=$row["id"]?>")'>
                            <svg width="25px" height="25px" viewBox="0 0 1024 1024" 
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill="#000000" d="M512 160c320 0 512 352 512 352S832 864 512 864 0 512 0 512s192-352 512-352zm0 64c-225.28 0-384.128 208.064-436.8 288 52.608 79.872 211.456 288 436.8 288 225.28 0 384.128-208.064 436.8-288-52.608-79.872-211.456-288-436.8-288zm0 64a224 224 0 1 1 0 448 224 224 0 0 1 0-448zm0 64a160.192 160.192 0 0 0-160 160c0 88.192 71.744 160 160 160s160-71.808 160-160-71.744-160-160-160z"/></svg>
                        </button>
                    <?php endif; ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

<!-- Popup of appointment / user or admin can edit the appointment -->
<div id="popupForm" style="display: none;">
    <h3>Appointment Details</h3>
    <form id="appointmentForm" method="post" class="form-floating">
        <input type="hidden" id="popupDate" name="date" value="">
        <input type="hidden" id="popupTime" name="time" value="">
        <input type="hidden" id="editAppointmentId" name="edit_appointment_id" value="">
        <label for="phone_number">Phone Number</label>
        <input type="tel" pattern="[0-9]{10}" name="phone_number" id="phone_number" placeholder="Phone Number" required class="form-control">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" placeholder="Name" required class="form-control">
        <label for="surname">Surname</label>
        <input type="text" name="surname" id="surname" placeholder="Surname" required class="form-control">
        <label for="license_plate_number">License Plate Number</label>
        <input type="text" name="license_plate_number" id="license_plate_number" placeholder="License plate number" required class="form-control">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Email" required class="form-control">
        <label for="additional_info">Additional Info</label>
        <textarea name="additional_info" id="additional_info" placeholder="Additional Information" class="form-control"></textarea>
        <div class="action-buttons">
            <button type="submit" class="btn btn-primary" name="submit_appointment" id="confirmButton">Confirm</button>
            <button type="button" class="btn btn-secondary" onclick="closePopup()">Close</button>
        </div>
    </form>
</div>

<script>
    function openPopup(date, time) {
        document.getElementById('popupDate').value = date;
        document.getElementById('popupTime').value = time;
        document.getElementById('popupForm').style.display = 'block';
        document.getElementById('phone_number').value = '';
        document.getElementById('name').value = '';
        document.getElementById('surname').value = '';
        document.getElementById('license_plate_number').value = '';
        document.getElementById('email').value = '';
        document.getElementById('additional_info').value = '';
        document.getElementById('editAppointmentId').value = '';
        document.getElementById('confirmButton').innerHTML = 'Confirm';
        document.getElementById('confirmButton').style.display = 'block';
    }

    function openEditPopup(date, time, phoneNumber, name, surname, licensePlate, email, additionalInfo, appointmentId) {
        document.getElementById('popupDate').value = date;
        document.getElementById('popupTime').value = time;
        document.getElementById('phone_number').value = phoneNumber;
        document.getElementById('name').value = name;
        document.getElementById('surname').value = surname;
        document.getElementById('license_plate_number').value = licensePlate;
        document.getElementById('email').value = email;
        document.getElementById('additional_info').value = additionalInfo;
        document.getElementById('editAppointmentId').value = appointmentId;
        document.getElementById('popupForm').style.display = 'block';
        document.getElementById('confirmButton').innerHTML = 'Update';
        document.getElementById('confirmButton').style.display = 'block';
    }
    
    function openViewPopup(date, time, phoneNumber, name, surname, licensePlate, email, additionalInfo, appointmentId) {
        document.getElementById('popupDate').value = date;
        document.getElementById('popupTime').value = time;
        document.getElementById('phone_number').value = phoneNumber;
        document.getElementById('name').value = name;
        document.getElementById('surname').value = surname;
        document.getElementById('license_plate_number').value = licensePlate;
        document.getElementById('email').value = email;
        document.getElementById('additional_info').value = additionalInfo;
        document.getElementById('editAppointmentId').value = appointmentId;
        document.getElementById('popupForm').style.display = 'block';
        document.getElementById('popupForm').classList.add("view-only");
        document.getElementById('confirmButton').style.display = 'none';
    }

    function closePopup() {
        document.getElementById('popupForm').style.display = 'none';
        document.getElementById('popupForm').classList.remove("view-only");
    }
</script>

<div class="col-12 text-center mb-5">
            <a href="box.php" class="back-btn">Back</a>
        </div>


</body>
</html>
