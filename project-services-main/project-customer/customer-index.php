<?php
$pageTitle = "Dashboard";
include('../project-customer/includes/header.php');
?>
<?php include('../project-customer/includes/navbar.php'); ?>
<?php include('../project-customer/includes/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- <h1 class="m-0">Customer</h1> -->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Customer</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Custom styles for this template -->
    <link href="carousel.css" rel="stylesheet">
    </head>

    <body>

        <main role="main">

            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="first-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="First slide">
                        <div class="container">
                            <div class="carousel-caption text-left">
                                <h1>Example headline.</h1>
                                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi
                                    porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
                                </p>
                                <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="second-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Second slide">
                        <div class="container">
                            <div class="carousel-caption">
                                <h1>Another example headline.</h1>
                                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi
                                    porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
                                </p>
                                <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="third-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Third slide">
                        <div class="container">
                            <div class="carousel-caption text-right">
                                <h1>One more for good measure.</h1>
                                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi
                                    porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
                                </p>
                                <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

            <!-- Marketing messaging and featurettes
      ================================================== -->
            <!-- Wrap the rest of the page in another container to center all the content. -->

            <div class="container marketing">

                <!-- Three columns of text below the carousel -->
                <div class="row">
                    <div class="col-lg-4">
                        <img class="rounded-circle" src="src/bluehouse.png" alt="Generic placeholder image" width="150" height="150">
                        <h2>Residential</h2>
                        <p>We create dream homes that are tailored to your lifestyle. From cozy cottages to opulent
                            estates, our residential construction services bring your vision to life through quality
                            craftsmanship and attention to detail.</p>
                        <!-- <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p> -->
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <img class="rounded-circle" src="src/greenhouse.png" alt="Generic placeholder image" width="150" height="150">
                        <h2>Commercial</h2>
                        <p>Creating spaces that inspire success. Our commercial construction expertise turns ideas into
                            vibrant offices, retail centers, and hospitality venues, delivering innovative designs and
                            functional environments that help businesses thrive.</p>
                        <!-- <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p> -->
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <img class="rounded-circle" src="src/orangehouse.png" alt="Generic placeholder image" width="150" height="150">
                        <h2>Industrial</h2>
                        <p>Making progress with strong infrastructure. Our industrial construction solutions improve
                            efficiency and productivity by constructing warehouses, factories, and logistics centers
                            that are designed for smooth operations and long-term growth.</p>
                        <!-- <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p> -->
                    </div><!-- /.col-lg-4 -->
                </div><!-- /.row -->


                <!-- START THE FEATURETTES -->

                <hr class="featurette-divider">

                <div class="row featurette">
                    <div class="col-md-7">
                        <h2 class="featurette-heading">First featurette heading. <span class="text-muted">It'll blow
                                your mind.</span></h2>
                        <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta
                            felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce
                            dapibus, tellus ac cursus commodo.</p>
                    </div>
                    <div class="col-md-5">
                        <img class="featurette-image img-fluid mx-auto" data-src="holder.js/500x500/auto" alt="Generic placeholder image">
                    </div>
                </div>

                <hr class="featurette-divider">

                <div class="row featurette">
                    <div class="col-md-7 order-md-2">
                        <h2 class="featurette-heading">Oh yeah, it's that good. <span class="text-muted">See for
                                yourself.</span></h2>
                        <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta
                            felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce
                            dapibus, tellus ac cursus commodo.</p>
                    </div>
                    <div class="col-md-5 order-md-1">
                        <img class="featurette-image img-fluid mx-auto" data-src="holder.js/500x500/auto" alt="Generic placeholder image">
                    </div>
                </div>

                <hr class="featurette-divider">

                <div class="row featurette">
                    <div class="col-md-7">
                        <h2 class="featurette-heading">For more details. <span class="text-muted">Inquire Now!</span>
                        </h2>
                        <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta
                            felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce
                            dapibus, tellus ac cursus commodo.</p>
                    </div>
                    <div class="col-md-5">
                        <img class="featurette-image img-fluid mx-auto" data-src="holder.js/500x500/auto" alt="Generic placeholder image">
                    </div>
                </div>

                <hr class="featurette-divider">

                <div class="row featurette">



                    <!-- Code Function Appointment -->
                    <?php
function build_calendar($month, $year) {
	$mysqli = new mysqli('localhost', 'root', '', 'project_system');

                        $stmt = $mysqli->prepare("SELECT * FROM appointment WHERE MONTH(DATE) = ? AND YEAR(DATE) = ?");
                        $stmt->bind_param('ss', $month, $year);
                        $bookings = array();

    if($stmt->execute()){
        $result = $stmt->get_result();

        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $bookings[] = $row['DATE'];
            }
            
            $stmt->close();
        }
       
    }
	
    
     $daysOfWeek = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
     $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
     $numberDays = date('t',$firstDayOfMonth);
     $dateComponents = getdate($firstDayOfMonth);
     $monthName = $dateComponents['month'];
     $dayOfWeek = $dateComponents['wday'];

    $datetoday = date('Y-m-d');
   
    $calendar = "<table class='table table-bordered'>";
    $calendar .= "<center><h2>$monthName $year</h2>";
    $calendar.= "<a class='btn btn-xs btn-success' href='?month=".date('m', mktime(0, 0, 0, $month-1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month-1, 1, $year))."'>Previous Month</a> ";
    $calendar.= " <a class='btn btn-xs btn-danger' href='?month=".date('m')."&year=".date('Y')."'>Current Month</a> ";
    $calendar.= "<a class='btn btn-xs btn-primary' href='?month=".date('m', mktime(0, 0, 0, $month+1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month+1, 1, $year))."'>Next Month</a></center><br>";
    
   
      $calendar .= "<tr>";
     foreach($daysOfWeek as $day) {
          $calendar .= "<th  class='header'>$day</th>";
     } 

                        $currentDay = 1;
                        $calendar .= "</tr><tr>";


     if ($dayOfWeek > 0) { 
         for($k=0;$k<$dayOfWeek;$k++){
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
            $today = $date==date('Y-m-d')? "today" : "";
         if($date<date('Y-m-d')){
             $calendar.="<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs' disabled>N/A</button>";
         }elseif (in_array($date, $bookings)) {
            // Check the status of the appointment
            $STATUS = $appointmentStatus[$date];
           
            if ($STATUS== 'Approved') {
                $calendar .= "<td class='$today'><h4>$currentDay</h4> <a href='appoint.php?date=".$date."' class='btn btn-success btn-xs'> <span class='glyphicon glyphicon-ok'></span> Available</a>";
            } elseif ($STATUS == 'Canceled') {
                $calendar .= "<td class='$today'><h4>$currentDay</h4> <a href='appoint.php?date=".$date."' class='btn btn-success btn-xs'> <span class='glyphicon glyphicon-ok'></span> Available</a>";
            } elseif ($STATUS == 'Deleted') {
                $calendar .= "<td class='$today'><h4>$currentDay</h4> <a href='appoint.php?date=".$date."' class='btn btn-success btn-xs'> <span class='glyphicon glyphicon-ok'></span> Available</a>";
            }
            elseif(in_array($date, $bookings)){
                $calendar.="<td class='$today'><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'> <span class='glyphicon glyphicon-lock'></span> Already Appoint</button>";
            }
         }else{
             $calendar.="<td class='$today'><h4>$currentDay</h4>
             <a href='appoint.php?date=".$date."' class='btn btn-success btn-xs'> <span class='glyphicon glyphicon-ok'></span> Available</a>";
         }
            
          $calendar .="</td>";
          $currentDay++;
          $dayOfWeek++;
     }

     if ($dayOfWeek != 7) { 
     
          $remainingDays = 7 - $dayOfWeek;
            for($l=0;$l<$remainingDays;$l++){
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



</div>

<!-- /END THE FEATURETTES -->

</div><!-- /.container -->

<!-- FOOTER -->
<footer class="container">

</footer>
</main>

<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<footer class="main-footer">
    <p class="float-right">
        <a href="#" class="btn btn-sm btn-primary">
            <i class="fas fa-arrow-circle-left"></i> Back to top
        </a>
    </p>
    <p>&copy; 2023-2024 GBUA, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.2.0
    </div>
</footer>


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->

</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<?php include('../project-customer/includes/script.php'); ?>
<?php include('../project-customer/includes/footer.php'); ?>