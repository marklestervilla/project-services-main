<?php
header('Content-Type: application/json');

include('config/dbcon.php');

$proj_id = $_GET['proj_id'];

// Query to get project and customer details
$query = "
    SELECT 
        project.project_name, 
        project.address, 
        COUNT(task.id) AS total_tasks, 
        SUM(task.cost) AS total_cost, 
        GROUP_CONCAT(task.materials SEPARATOR ', ') AS all_materials, 
        GROUP_CONCAT(task.equipments SEPARATOR ', ') AS all_equipments, 
        SUM(CASE WHEN task.workers IS NOT NULL AND task.workers != '' THEN LENGTH(task.workers) - LENGTH(REPLACE(task.workers, ',', '')) + 1 ELSE 0 END) AS total_workers,
        customers.name AS customer_name,
        customers.phone AS customer_phone,
        customers.email AS customer_email
    FROM 
        project 
    LEFT JOIN 
        task ON task.project_id = project.id 
    LEFT JOIN 
        customers ON project.customers_id = customers.id
    WHERE 
        project.id = ? 
    GROUP BY 
        project.id
";

$stmt = $con->prepare($query);
$stmt->bind_param('i', $proj_id);
$stmt->execute();
$result = $stmt->get_result();
$response = [];

if ($row = $result->fetch_assoc()) {
    // Initialize response
    $response = [
        'project_name' => $row['project_name'],
        'address' => $row['address'],
        'total_workers' => $row['total_workers'],
        'total_tasks' => $row['total_tasks'],
        'total_cost' => $row['total_cost'],
        'all_materials' => $row['all_materials'],
        'all_equipments' => $row['all_equipments'],
        'customer_name' => $row['customer_name'],
        'customer_phone' => $row['customer_phone'],
        'customer_email' => $row['customer_email'],
        'tasks' => [],
        'grouped_materials' => []
    ];

    // Query to get task details
    $tasks_query = "
        SELECT 
            task.task_name, 
            task.materials, 
            task.cost 
        FROM 
            task 
        WHERE 
            task.project_id = ?
    ";

    $tasks_stmt = $con->prepare($tasks_query);
    $tasks_stmt->bind_param('i', $proj_id);
    $tasks_stmt->execute();
    $tasks_result = $tasks_stmt->get_result();
    $material_totals = [];

    while ($task_row = $tasks_result->fetch_assoc()) {
        $materials = explode(', ', $task_row['materials']);
        $task_costs = [];

        foreach ($materials as $material) {
            // Fetch the price of the material
            $product_query = "SELECT price FROM products WHERE name = ?";
            $product_stmt = $con->prepare($product_query);
            $product_stmt->bind_param('s', $material);
            $product_stmt->execute();
            $product_result = $product_stmt->get_result();

            if ($product_row = $product_result->fetch_assoc()) {
                $price = $product_row['price'];

                // Aggregate material quantities and costs
                if (isset($material_totals[$material])) {
                    $material_totals[$material]['quantity'] += 1;
                    $material_totals[$material]['total_cost'] += $price;
                } else {
                    $material_totals[$material] = [
                        'quantity' => 1,
                        'total_cost' => $price
                    ];
                }

                // Add material to task costs
                $task_costs[] = [
                    'name' => $material,
                    'quantity' => 1,
                    'cost' => $price
                ];
            }
        }

        // Add task details to the response
        $response['tasks'][] = [
            'task_name' => $task_row['task_name'],
            'materials' => $task_costs,
            'total_cost' => array_sum(array_column($task_costs, 'cost'))
        ];
    }

    // Add grouped materials to the response
    foreach ($material_totals as $material => $totals) {
        $response['grouped_materials'][] = [
            'name' => $material,
            'quantity' => $totals['quantity'],
            'total_cost' => $totals['total_cost']
        ];
    }
}

echo json_encode($response);

$con->close();
?>
