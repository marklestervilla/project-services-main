<?php
header('Content-Type: application/json');

include '../config/dbcon.php';

$json = file_get_contents('php://input');
$tasks = json_decode($json, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($tasks) {

        // get corresponding project id
        $stmt = $con->prepare("SELECT MAX(id) AS project_id FROM project");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $projectId = $row['project_id'];

        $stmt = $con->prepare("INSERT INTO task 
            (project_id, task_name, description, start_date, due_date, status, priority)
            VALUES (?, ?, ?, ?, ?, ?, ?)");

        foreach ($tasks as $task) {
            if (
                isset($task['task_name']) && isset($task['task_description']) && isset($task['task_start_date']) && isset($task['task_due_date']) && isset($task['task_status']) && isset($task['task_priority'])
            ) {
                $taskName = $task['task_name'];
                $taskDescription = $task['task_description'];
                $taskStartDate = $task['task_start_date'];
                $taskDueDate = $task['task_due_date'];
                $taskStatus = $task['task_status'];
                $taskPriority = $task['task_priority'];

                $stmt->bind_param("issssii", $projectId, $taskName, $taskDescription, $taskStartDate, $taskDueDate, $taskStatus, $taskPriority);
                if (!$stmt->execute()) {
                    echo json_encode('1'); 
                    exit;
                }
            } else {
                echo json_encode('9'); // Missing parameters
                exit;
            }
        }
        echo json_encode('0'); // Success
    } else {
        echo json_encode('9'); // No tasks data
    }
}

