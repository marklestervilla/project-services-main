<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../config/dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskMax = "SELECT id FROM task ORDER BY id DESC LIMIT 1";
    $taskIdResult = $con->query($taskMax);
    $current_task_id = ($taskIdResult && $taskIdResult->num_rows > 0) ? $taskIdResult->fetch_assoc()['id'] + 1 : 1;

    $query = "SELECT id FROM project ORDER BY id DESC LIMIT 1";
    $idResult = $con->query($query);
    $current_id = ($idResult && $idResult->num_rows > 0) ? $idResult->fetch_assoc()['id'] + 1 : 1;

    $task_name = $con->real_escape_string($_POST['task_name'] ?? '');
    $task_description = $con->real_escape_string($_POST['task_description'] ?? '');
    $equipment = $con->real_escape_string($_POST['equipment'] ?? '');
    $task_start_date = $con->real_escape_string($_POST['task_start_date'] ?? '');
    $task_due_date = $con->real_escape_string($_POST['task_due_date'] ?? '');
    $task_priority = $con->real_escape_string($_POST['task_priority'] ?? '');
    $task_status = $con->real_escape_string($_POST['task_status'] ?? '');
    $total_price = $con->real_escape_string($_POST['total_price'] ?? '');

    $selected_workers = $_POST['selected_workers'] ?? [];
    $selected_workers_str = implode(",", $selected_workers);

    $material_names_query = "SELECT name FROM products";
    $material_names_result = $con->query($material_names_query);
    $material_names = [];

    while ($row = $material_names_result->fetch_assoc()) {
        $material_names[] = $row['name'];
    }

    $materials_used = [];
    $material_costs = [];
    $con->begin_transaction();

    try {
        // Check if quantity is sufficient
        $isQuantitySufficient = true;

        foreach ($_POST as $field_name => $value) {
            if (in_array($field_name, $material_names) && !empty($value)) {
                $material_name = $con->real_escape_string($field_name);
                $quantity = (int)$value;

                // Check if the quantity is sufficient
                $check_quantity_query = "SELECT quantity FROM products WHERE name = '$material_name'";
                $result = $con->query($check_quantity_query);

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $available_quantity = (int)$row['quantity'];

                    if ($quantity > $available_quantity) {
                        $isQuantitySufficient = false;
                        break;
                    }
                }
            }
        }

        if (!$isQuantitySufficient) {
            throw new Exception("Insufficient quantity for one or more materials.");
        }

        // Continue with task insertion
        foreach ($_POST as $field_name => $value) {
            if (in_array($field_name, $material_names) && !empty($value)) {
                $material_name = $con->real_escape_string($field_name);
                $quantity = (int)$value;

                for ($i = 0; $i < $quantity; $i++) {
                    $materials_used[] = $material_name;
                }

                $update_query = "UPDATE products SET quantity = quantity - $quantity WHERE name = '$material_name'";
                if (!$con->query($update_query)) {
                    throw new Exception("Error executing update query for $material_name: " . $con->error);
                }
            }
        }
        
        $materials_used_str = implode(", ", $materials_used);

        $selected_equipment = $_POST['selected_equipment'] ?? [];
        $selected_equipment_str = implode(",", $selected_equipment);

        $task_sql = "INSERT INTO task (id, project_id, task_name, description, start_date, workers, materials, equipments, due_date, status, priority, cost)
                     VALUES ('$current_task_id', '$current_id', '$task_name', '$task_description', '$task_start_date', '$selected_workers_str', '$materials_used_str', '$selected_equipment_str', '$task_due_date', '$task_status', '$task_priority', '$total_price')";

        if (!$con->query($task_sql)) {
            throw new Exception("Error executing task insert query: " . $con->error);
        }

        $con->commit();
        $response = [
            'status' => 'success',
            'message' => 'Form data processed successfully',
        ];
    } catch (Exception $e) {
        $con->rollback();
        $response = [
            'status' => 'error',
            'message' => $e->getMessage(),
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    http_response_code(405);
    echo 'Method Not Allowed';
}

$con->close();
?>

