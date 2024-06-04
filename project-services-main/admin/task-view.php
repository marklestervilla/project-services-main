<?php
include('authentication.php');
include('includes/header.php');
include('config/dbcon.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>

</head>

<body>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .task-details {
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .task-details p {
            margin: 10px 0;
        }

        .task-details .badge {
            font-size: 14px;
            padding: 5px 10px;
        }

        .task-title {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }

        hr {
            border-top: 1px solid #dee2e6;
        }
    </style>
    </head>

    <body>
        <div class="container">
            <?php
            $con = mysqli_connect("localhost", "root", "", "project_system");
            $id = $_GET['id'];
            $task_query = "SELECT * FROM task WHERE id='$id'";
            $task_query_run = mysqli_query($con, $task_query);

            if (mysqli_num_rows($task_query_run) > 0) {
                foreach ($task_query_run as $row) {
            ?>

                    <div class="task-details">
                        <p class="task-title"><?php echo $row['task_name']; ?></p>

                        <p><strong>Description:</strong> <?php echo $row['description']; ?></p>

                        <p><strong>Status:</strong>
                            <?php
                            $status = $row['status'];
                            $badge_class = '';
                            switch ($status) {
                                case 0:
                                    $badge_class = 'badge-primary'; // Pending
                                    break;
                                case 1:
                                    $badge_class = 'badge-secondary'; // Preparing
                                    break;
                                case 2:
                                    $badge_class = 'badge-warning'; // On-Progress
                                    break;
                                case 3:
                                    $badge_class = 'badge-success'; // Completed
                                    break;
                                case 4:
                                    $badge_class = 'badge-danger'; // Cancelled
                                    break;
                                default:
                                    $badge_class = 'badge-info'; // Default
                                    break;
                            }
                            echo '<span class="badge ' . $badge_class . '">' . getStatusText($status) . '</span>';
                            ?>
                        </p>

                        <p><strong>Priority:</strong>
                            <?php
                            $priority = $row['priority'];
                            $badge_class = '';
                            switch ($priority) {
                                case 0:
                                    $badge_class = 'badge-secondary'; // Low
                                    break;
                                case 1:
                                    $badge_class = 'badge-primary'; // Medium
                                    break;
                                case 2:
                                    $badge_class = 'badge-danger'; // High
                                    break;
                            }
                            echo '<span class="badge ' . $badge_class . '">' . getPriorityText($priority) . '</span>';
                            ?>
                        </p>

                        <p><strong>Start Date:</strong> <?php echo date("F j, Y", strtotime($row['start_date'])); ?></p>

                        <p><strong>End Date:</strong> <?php echo date("F j, Y", strtotime($row['due_date'])); ?></p>

                        <hr>

                        <p><strong>Workers:</strong> <br> <?php echo $row['workers']; ?></p>

                        <hr>

                        <p><strong>Equipment Used:</strong> <br> <?php echo $row['equipments']; ?></p>

                        <hr>

                        <!-- Uncomment if materials are needed -->
                        <!-- <p><strong>Materials:</strong> <?php echo $row['materials']; ?></p>
            <hr> -->

                        <p><strong>Date Created:</strong> <?php echo date('j M Y | g:i A', strtotime($row['created_at'])); ?></p>
                        <p><strong>Cancellation Comment:</strong> <?php echo $row['comment']; ?></p>
                    </div>

            <?php
                }
            } else {
                echo "<div class='alert alert-warning'>No Data Found</div>";
            }
            ?>
        </div>

        <?php include('includes/script.php'); ?>
        <?php include('includes/footer.php'); ?>

        <?php
        // Function to get priority text based on priority code
        function getPriorityText($priority)
        {
            switch ($priority) {
                case 0:
                    return 'Low';
                    break;
                case 1:
                    return 'Medium';
                    break;
                case 2:
                    return 'High';
                    break;
            }
        }
        ?>

        <?php
        // Function to get status text based on status code
        function getStatusText($status)
        {
            switch ($status) {
                case 0:
                    return 'Pending';
                    break;
                case 1:
                    return 'Preparing';
                    break;
                case 2:
                    return 'On-Progress';
                    break;
                case 3:
                    return 'Completed';
                    break;
                case 4:
                    return 'Cancelled';
                    break;
                default:
                    return 'Unknown';
                    break;
            }
        }
        ?>
    </body>

</html>