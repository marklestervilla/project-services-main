<?php

include '../config/dbcon.php';

function calculateProgress($totalTasks, $completedTasks)
{ // function to compute formula => "completed / total task x 100 then round off"
    if ($totalTasks == 0) {
        return 0; // no division by zero fixed
    }
    return ($completedTasks / $totalTasks) * 100;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['task_name']) && isset($_POST['project_name']) && isset($_POST['task_description']) && isset($_POST['start_date']) && isset($_POST['due_date']) && isset($_POST['priority']) && isset($_POST['status']) && isset($_POST['id']) && isset($_POST['project_id']) && isset($_POST['comment'])) {

        $new_task_name = $_POST['task_name']; // 1
        $new_task_desc = $_POST['task_description']; // 2
        $new_start_date = $_POST['start_date']; // 3
        $new_due_date = $_POST['due_date']; // 4
        $new_task_status = $_POST['status'];
        $new_task_priority = $_POST['priority'];
        $task_id = $_POST['id'];
        $project_id = $_POST['project_id'];
        $comment = $_POST['comment'];

        if ($new_task_status === "3") {
            $stmt = $con->prepare('SELECT project_num_task, task_num_completed FROM project WHERE id = ?'); // fetch the needed data
            $stmt->bind_param('i', $project_id);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    $totalTasks = $row['project_num_task']; // total number of tasks
                    $completedTasks = $row['task_num_completed']; // number of completed tasks
                    $completedTasks++; // increment the completed tasks

                    $progress = calculateProgress($totalTasks, $completedTasks);
                    $roundedProgress = round($progress); // current progress
                    $stmt = $con->prepare('UPDATE project SET task_num_completed = ?, project_progress = ? WHERE id = ?');
                    $stmt->bind_param('iii', $completedTasks, $roundedProgress, $project_id);
                    if ($stmt->execute()) {
                        if ($roundedProgress == 100) {
                            $status = 3;
                            $stmt = $con->prepare('UPDATE project SET status = ? WHERE id = ?');
                            $stmt->bind_param('ii', $status, $project_id);
                            $stmt->execute();
                        }
                        $stmt = $con->prepare('UPDATE task SET status = ? WHERE id = ?');
                        $stmt->bind_param('ii', $new_task_status, $task_id);
                        if ($stmt->execute()) {
                            echo '0'; // task uncompleted
                        }
                    };
                }
            }
        } else if ($new_task_status === "4") {
            $stmt = $con->prepare('SELECT project_num_task, task_num_completed FROM project WHERE id = ?'); // fetch the needed data
            $stmt->bind_param('i', $project_id);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    $totalTasks = $row['project_num_task']; // total number of tasks
                    $completedTasks = $row['task_num_completed']; // number of completed tasks
                    $totalTasks--; // decrement the total tasks

                    $progress = calculateProgress($totalTasks, $completedTasks);
                    $roundedProgress = round($progress); // current progress
                    $stmt = $con->prepare('UPDATE project SET task_num_completed = ?, project_progress = ? WHERE id = ?');
                    $stmt->bind_param('iii', $completedTasks, $roundedProgress, $project_id);
                    if ($stmt->execute()) {
                        if ($roundedProgress == 100) {
                            $status = 3;
                            $stmt = $con->prepare('UPDATE project SET status = ? WHERE id = ?');
                            $stmt->bind_param('ii', $status, $project_id);
                            $stmt->execute();
                        }
                        $stmt = $con->prepare('SELECT status FROM task WHERE id = ?');
                        $stmt->bind_param('i', $task_id);
                        if ($stmt->execute()) {
                            $result = $stmt->get_result();
                            $stmt = $con->prepare('UPDATE task SET status = ?, comment = ? WHERE id = ?');
                            $stmt->bind_param('isi', $new_task_status, $comment, $task_id);
                            $stmt->execute();
                            echo '0';
                        }
                    };
                }
            }
        } else {
            $stmt = $con->prepare('SELECT project_num_task, task_num_completed FROM project WHERE id = ?'); // fetch the needed data
            $stmt->bind_param('i', $project_id);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    $totalTasks = $row['project_num_task'];
                    $completedTasks = $row['task_num_completed'];

                    $stmt = $con->prepare('SELECT * FROM task WHERE id = ?');
                    $stmt->bind_param('i', $task_id);

                    if ($stmt->execute()) {
                        $result = $stmt->get_result();
                        if ($row = $result->fetch_assoc()) {
                            $current_task_status = $row['status'];

                            if ($current_task_status == 4) {
                                $progress = calculateProgress($totalTasks, $completedTasks); // re calculate
                                $roundedProgress = round($progress); // current progress

                                $status = 0;

                                if ($roundedProgress != 100) {
                                    $status = 0;
                                } else {
                                    $status = 3;
                                }

                                $stmt = $con->prepare('UPDATE project SET task_num_completed = ?, project_progress = ?, status = ? WHERE id = ?');
                                $stmt->bind_param('iiii', $completedTasks, $roundedProgress, $status, $project_id);

                                if ($stmt->execute()) {
                                    $stmt = $con->prepare('UPDATE task SET status = ? WHERE id = ?');
                                    $stmt->bind_param('ii', $new_task_status, $task_id);
                                    $stmt->execute();
                                };
                                echo '0';
                            } else if ($current_task_status == 3) {
                                $completedTasks--;

                                $progress = calculateProgress($totalTasks, $completedTasks); // re calculate
                                $roundedProgress = round($progress); // current progress

                                $status = 0;

                                if ($roundedProgress == 100) {
                                    $status = 3;
                                } else {
                                    $status = 0;
                                }

                                $stmt = $con->prepare('UPDATE project SET task_num_completed = ?, project_progress = ?, status = ? WHERE id = ?');
                                $stmt->bind_param('iiii', $completedTasks, $roundedProgress, $status, $project_id);

                                if ($stmt->execute()) {
                                    $stmt = $con->prepare('UPDATE task SET task_name = ?, description = ?, start_date = ?, due_date = ?, status = ?, priority = ? WHERE id = ?');
                                    $stmt->bind_param('ssssiii', $new_task_name, $new_task_desc, $new_start_date, $new_due_date, $new_task_status, $new_task_priority, $task_id);
                                    $stmt->execute();
                                };
                                echo '0';
                            } else {
                                $progress = calculateProgress($totalTasks, $completedTasks); // re calculate
                                $roundedProgress = round($progress); // current progress

                                $status = 0;

                                if ($roundedProgress != 100) {
                                    $status = 0;
                                } else {
                                    $status = 3;
                                }

                                $stmt = $con->prepare('UPDATE project SET task_num_completed = ?, project_progress = ?, status = ? WHERE id = ?');
                                $stmt->bind_param('iiii', $completedTasks, $roundedProgress, $status, $project_id);

                                if ($stmt->execute()) {
                                    $stmt = $con->prepare('UPDATE task SET status = ? WHERE id = ?');
                                    $stmt->bind_param('ii', $new_task_status, $task_id);
                                    $stmt->execute();
                                    echo '0';
                                }
                            }
                        }
                    }
                } else {
                    echo '1';
                }
            }
        }
    }
}
?>
