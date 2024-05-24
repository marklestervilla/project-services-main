<?php

include '../config/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['category_id']) && isset($_POST['project_name']) && isset($_POST['customers_id']) && isset($_POST['description']) && isset($_POST['address']) && isset($_POST['position']) && isset($_FILES['image']) && isset($_POST['date_start']) && isset($_POST['due_date']) && isset($_POST['num_task']) && isset($_POST['status'])) {

        $categoryId = $_POST['category_id'];
        $projectName = $_POST['project_name'];
        $customersId = $_POST['customers_id'];
        $description = $_POST['description'];
        $address = $_POST['address'];
        $position = $_POST['position'];
        $dateStart = $_POST['date_start'];
        $dueDate = $_POST['due_date'];
        $numTask = $_POST['num_task'];
        $status = $_POST['status'];
        
        $image = $_FILES['image']['name'];
        $targetDir = "../uploads_file/";
        $targetFile = $targetDir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

        $insert_query = "INSERT INTO project 
        (category_id, project_name, customers_id, description, address, position, image, date_start, due_date, project_num_task, status)
        VALUES
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $con->prepare($insert_query);
        $stmt->bind_param("isissssssii", $categoryId, $projectName, $customersId, $description, $address, $position, $image, $dateStart, $dueDate, $numTask, $status);
        if ($stmt->execute()) {
            echo '0';
        } else {
            '1';
        }
    }
}

