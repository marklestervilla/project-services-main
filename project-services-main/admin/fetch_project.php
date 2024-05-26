<?php
header('Content-Type: application/json');

include('config/dbcon.php');

$proj_id = $_GET['proj_id'];

$query = "SELECT project.project_name, project.address, COUNT(task.id) AS total_tasks, SUM(task.cost) AS total_cost, GROUP_CONCAT(DISTINCT task.materials SEPARATOR ', ') AS all_materials, GROUP_CONCAT(DISTINCT task.equipments SEPARATOR ', ') AS all_equipments, CASE WHEN task.workers IS NOT NULL AND task.workers != '' THEN LENGTH(task.workers) - LENGTH(REPLACE(task.workers, ',', '')) + 1 ELSE 0 END AS total_workers FROM project LEFT JOIN task ON task.project_id = project.id WHERE project.id = $proj_id GROUP BY project.id";

$result = mysqli_query($con, $query);

$response = [];

if ($row = mysqli_fetch_assoc($result)) {
    $response = [
        'project_name' => $row['project_name'],
        'address' => $row['address'],
        'total_workers' => $row['total_workers'],
        'total_tasks' => $row['total_tasks'],
        'total_cost' => $row['total_cost'],
        'all_materials' => $row['all_materials'],
        'all_equipments' => $row['all_equipments'],
        'tasks' => []
    ];

    $tasks_query = "
        SELECT 
            task.task_name, 
            task.materials, 
            task.cost 
        FROM 
            task 
        WHERE 
            task.project_id = $proj_id
    ";

    $tasks_result = mysqli_query($con, $tasks_query);

    while ($task_row = mysqli_fetch_assoc($tasks_result)) {
        $materials = explode(', ', $task_row['materials']);
        $task_costs = [];

        foreach ($materials as $material) {
            $product_query = "SELECT price FROM products WHERE name = '$material'";
            $product_result = mysqli_query($con, $product_query);

            if ($product_row = mysqli_fetch_assoc($product_result)) {
                $task_costs[] = [
                    'name' => $material,
                    'quantity' => 1,
                    'cost' => $product_row['price']
                ];
            }
        }

        $response['tasks'][] = [
            'task_name' => $task_row['task_name'],
            'materials' => $task_costs,
            'total_cost' => array_sum(array_column($task_costs, 'cost'))
        ];
    }
}

echo json_encode($response);

mysqli_close($con);
