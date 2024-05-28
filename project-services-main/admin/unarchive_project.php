<?php
include('./config/dbcon.php');

$sql_fetch = "SELECT project_num_task, task_num_completed FROM project WHERE id = ?";

if ($stmt_fetch = $con->prepare($sql_fetch)) {
    $project_id = $_GET['id'];
    $stmt_fetch->bind_param("i", $project_id);
    $stmt_fetch->execute();
    $stmt_fetch->bind_result($project_num_task, $task_num_completed);
    $stmt_fetch->fetch();
    $stmt_fetch->close();

    $new_status = ($project_num_task == $task_num_completed) ? 3 : 0;

    $sql_update = "UPDATE project SET status = ? WHERE id = ?";

    if ($stmt_update = $con->prepare($sql_update)) {
        $stmt_update->bind_param("ii", $new_status, $project_id);

        if ($stmt_update->execute()) {
            header('Location: project-report.php');
        } else {
            echo "ERROR: Could not execute query: $sql_update. " . $con->error;
        }

        $stmt_update->close();
    } else {
        echo "ERROR: Could not prepare query: $sql_update. " . $con->error;
    }
} else {
    echo "ERROR: Could not prepare query: $sql_fetch. " . $con->error;
}
