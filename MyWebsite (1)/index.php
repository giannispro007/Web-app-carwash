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
                <h2>CarWash</h2>
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

<?php
    if (!isset($_SESSION["user_id"])) { ?>
        <div class="login-form-wrapper">
            <h3 class="mt-5">Login</h3>
            <form action="includes/login.inc.php" method="post">
                <input type="text" class="input-field" name="username" placeholder="Username">
                <input type="password" class="input-field" name="pwd" placeholder="Password">
                <button class="login-btn" type="submit">Login</button>
                <a class="signup-btn" href="signup.php">Sign up</a>
            </form>
        </div>
<?php } ?>

<?php
    check_login_errors();
    ?>

<?php
    if (isset($_SESSION["user_id"])) {


        // Function to generate a common calendar for a specific month and year
        function generateMonthlyCalendar($year, $month) {
            // Get the first day of the month
            $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);

            // Get the number of days in the month
            $daysInMonth = date('t', $firstDayOfMonth);

            // Get the name of the month
            $monthName = date('F', $firstDayOfMonth);

            // Get the day of the week for the first day of the month (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
            $firstDayOfWeek = date('w', $firstDayOfMonth);

            // Display buttons to navigate to the previous and next months
            $previousMonth = ($month == 1) ? 12 : $month - 1;
            $previousYear = ($month == 1) ? $year - 1 : $year;
            $nextMonth = ($month == 12) ? 1 : $month + 1;
            $nextYear = ($month == 12) ? $year + 1 : $year;

            // Create a table for the calendar
            ?>
            <div class="row calendar-header mt-5 no-gutters">
                <div class="col-12 current-date-wrapper d-flex justify-content-center align-items-center">
                    <a href="?year=<?php echo $previousYear.'&month='.$previousMonth ?>" class="prev-next-arrow">
                        <
                    </a>
                    <h2><?php echo $monthName.' '.$year; ?></h2>
                    <a href="?year=<?php echo $nextYear.'&month='.$nextMonth ?>" class="prev-next-arrow">
                        >
                    </a>
                </div>
            </div>
            <?php
            echo "<table class='calendar-wrapper'>";
            echo "<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>";

            // Start a new row for the first week
            echo "<tr>";

            // Fill in empty cells for days before the first day of the month
            for ($i = 0; $i < $firstDayOfWeek; $i++) {
                echo "<td></td>";
            }

            // Fill in the cells with the days of the month
            for ($day = 1; $day <= $daysInMonth; $day++) {
                // Start a new row for each week
                if (($firstDayOfWeek + $day - 1) % 7 == 0) {
                    echo "</tr><tr>";
                }
                $date = "$year-$month-$day";

                // Fetch appointments for the current day
                $appointments = getAppointmentsForDay($year, $month, $day);

                $isPreviousThanTodayDate = date("Y-m-d", time()) > date("Y-m-d", strtotime($date));

                $activeAppointments = count($appointments);
                if($activeAppointments == 48 || $isPreviousThanTodayDate) {
                    $dayClass = "red";
                } else if ($activeAppointments == 0) {
                    $dayClass = "green";
                } else {
                    $dayClass = "yellow";
                }
                
                // Display the day as a button
                echo "<td><a class='appointment-day ".$dayClass."' href='appointment_page.php?date=$date'>$day</a>";


                // Display appointment information below the button
                if ($appointments && false) {
                    echo "<div class='appointment-info'>";
                    foreach ($appointments as $appointment) {
                        // Check if the 'time' key exists
                        if (isset($appointment['time'])) {
                            echo "<span>" . $appointment['name'] . "</span><br>";
                            echo "<span>" . $appointment['time'] . "</span><br>";
                        } else {
                            // Handle case where 'time' key is missing or not set
                            echo "<span>" . $appointment['name'] . " - " . $appointment['appointment_time'] . "</span>";
                        }
                    }
                    echo "</div>";
                }
                echo "</td>";
            }

            // Fill in empty cells for days after the last day of the month
            for ($i = 0; ($firstDayOfWeek + $daysInMonth + $i) % 7 != 0; $i++) {
                echo "<td></td>";
            }

            echo "</tr>";
            echo "</table>";
        }

        // Function to get appointments for a specific day
        function getAppointmentsForDay($year, $month, $day) {
            global $pdo; // Assuming $pdo is your PDO object
            $date = "$year-$month-$day";
            $stmt = $pdo->prepare("SELECT * FROM appointments WHERE appointment_date = ?");
            $stmt->execute([$date]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        

        // Check if the month and year are provided via GET parameters
        if(isset($_GET['year']) && isset($_GET['month'])) {
            $year = $_GET['year'];
            $month = $_GET['month'];
        } else {
            // If not, use the current month and year
            $year = date('Y');
            $month = date('n');
        }

        // Display the calendar for the specified month and year
        generateMonthlyCalendar($year, $month);
    }




    ?>

<?php
    if (isset($_SESSION["user_id"])) {
        ?>
<h3>Appointments</h3>
<a class="appointments-btn" href="all_appointments.php">View All Appointments</a>
<?php
    }
    ?>

<?php
    if (isset($_SESSION["user_id"])) : ?>
<div class="col-12 text-center mb-5">
    <a href="box.php" class="back-btn">Back</a>
</div>
<?php endif; ?>

</body>
</html>