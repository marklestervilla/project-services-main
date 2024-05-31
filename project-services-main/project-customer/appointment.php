<div class="container">
    <div class="row mt-3">
        <div class="col-md-12">
            <a href="../project-customer/customer-index.php" class="btn btn-success">Back to Homepage</a>
        </div>
    </div>
</div>

<!-- Code Function Appointment -->
<?php
function build_calendar($month, $year)
{
    $mysqli = new mysqli('localhost', 'root', '', 'project_system');

    $stmt = $mysqli->prepare("SELECT * FROM appointment WHERE MONTH(DATE) = ? AND YEAR(DATE) = ?");
    $stmt->bind_param('ss', $month, $year);
    $bookings = array();

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookings[] = $row['DATE'];
            }

            $stmt->close();
        }
    }


    $daysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];

    $datetoday = date('Y-m-d');

    $calendar = "<table class='table table-bordered'>";
    $calendar .= "<center><h2>$monthName $year</h2>";
    $calendar .= "<a class='btn btn-xs btn-success' href='?month=" . date('m', mktime(0, 0, 0, $month - 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month - 1, 1, $year)) . "'>Previous Month</a> ";
    $calendar .= " <a class='btn btn-xs btn-danger' href='?month=" . date('m') . "&year=" . date('Y') . "'>Current Month</a> ";
    $calendar .= "<a class='btn btn-xs btn-primary' href='?month=" . date('m', mktime(0, 0, 0, $month + 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month + 1, 1, $year)) . "'>Next Month</a></center><br>";


    $calendar .= "<tr>";
    foreach ($daysOfWeek as $day) {
        $calendar .= "<th  class='header'>$day</th>";
    }

    $currentDay = 1;
    $calendar .= "</tr><tr>";


    if ($dayOfWeek > 0) {
        for ($k = 0; $k < $dayOfWeek; $k++) {
            $calendar .= "<td  class='empty'></td>";
        }
    }

    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    $status_query = "SELECT DATE, STATUS FROM appointment WHERE MONTH(DATE) = $month AND YEAR(DATE) = $year";
    $status_result = $mysqli->query($status_query);

    $appointmentStatus = [];
    if ($status_result) {
        while ($row = $status_result->fetch_assoc()) {
            $appointmentStatus[$row['DATE']] = $row['STATUS'];
        }
    }
    while ($currentDay <= $numberDays) {

        if ($dayOfWeek == 7) {

            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";

        $dayname = strtolower(date('l', strtotime($date)));
        $eventNum = 0;
        $today = $date == date('Y-m-d') ? "today" : "";
        if ($date < date('Y-m-d')) {
            $calendar .= "<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs' disabled>N/A</button>";
        } elseif (in_array($date, $bookings)) {
            // Check the status of the appointment
            $STATUS = $appointmentStatus[$date];

            if ($STATUS == 'Approved') {
                $calendar .= "<td class='$today'><h4>$currentDay</h4> <a href='appoint.php?date=" . $date . "' class='btn btn-success btn-xs'> <span class='glyphicon glyphicon-ok'></span> Available</a>";
            } elseif ($STATUS == 'Cancelled') {
                $calendar .= "<td class='$today'><h4>$currentDay</h4> <a href='appoint.php?date=" . $date . "' class='btn btn-success btn-xs'> <span class='glyphicon glyphicon-ok'></span> Available</a>";
            } elseif ($STATUS == 'Deleted') {
                $calendar .= "<td class='$today'><h4>$currentDay</h4> <a href='appoint.php?date=" . $date . "' class='btn btn-success btn-xs'> <span class='glyphicon glyphicon-ok'></span> Available</a>";
            } elseif (in_array($date, $bookings)) {
                $calendar .= "<td class='$today'><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'> <span class='glyphicon glyphicon-lock'></span> Already Appoint</button>";
            }
        } else {
            $calendar .= "<td class='$today'><h4>$currentDay</h4>
             <a href='appoint.php?date=" . $date . "' class='btn btn-success btn-xs'> <span class='glyphicon glyphicon-ok'></span> Available</a>";
        }

        $calendar .= "</td>";
        $currentDay++;
        $dayOfWeek++;
    }

    if ($dayOfWeek != 7) {

        $remainingDays = 7 - $dayOfWeek;
        for ($l = 0; $l < $remainingDays; $l++) {
            $calendar .= "<td class='empty'></td>";
        }
    }

    $calendar .= "</tr>";
    $calendar .= "</table>";
    echo $calendar;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <title>GBUA Services</title>
    <style>
        @media only screen and (max-width: 760px),
        (min-device-width: 802px) and (max-device-width: 1020px) {

            /* Force table to not be like tables anymore */
            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }

            .empty {
                display: none;
            }

            /* Hide table headers (but not display: none;, for accessibility) */
            th {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            /*
		Label the data
		*/
            td:nth-of-type(1):before {
                content: "Sunday";
            }

            td:nth-of-type(2):before {
                content: "Monday";
            }

            td:nth-of-type(3):before {
                content: "Tuesday";
            }

            td:nth-of-type(4):before {
                content: "Wednesday";
            }

            td:nth-of-type(5):before {
                content: "Thursday";
            }

            td:nth-of-type(6):before {
                content: "Friday";
            }

            td:nth-of-type(7):before {
                content: "Saturday";
            }


        }

        /* Smartphones (portrait and landscape) ----------- */

        @media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
            body {
                padding: 0;
                margin: 0;
            }
        }

        /* iPads (portrait and landscape) ----------- */

        @media only screen and (min-device-width: 802px) and (max-device-width: 1020px) {
            body {
                width: 495px;
            }
        }

        @media (min-width:641px) {
            table {
                table-layout: fixed;
            }

            td {
                width: 33%;
            }
        }

        .row {
            margin-top: 20px;

        }

        .today {
            background: #ccc;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" style="background:#F3F8FF; color: #000; border-radius:20px; border: 1px solid #000;">
                    <?php
                    $dateComponents = getdate();
                    if (isset($_GET['month']) && isset($_GET['year'])) {
                        $month = $_GET['month'];
                        $year = $_GET['year'];
                    } else {
                        $month = $dateComponents['mon'];
                        $year = $dateComponents['year'];
                    }
                    echo build_calendar($month, $year);
                    ?>
                </div>
            </div>
        </div>
    </div>

    </div>

    </section>

</body>

</html>

</div>
</div>
</div>
</div>