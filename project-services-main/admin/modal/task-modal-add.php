<?php
include('config/dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "SELECT id FROM project ORDER BY id DESC LIMIT 1";

    $id = $con->query($query);

    $current_id = 0;

    if ($id->num_rows > 0) {
        $row = $id->fetch_assoc();
        $current_id = $row['id'] + 1;
    } else {
        echo "No records found.";
    }

    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);
    $project_name = mysqli_real_escape_string($con, $_POST['project_name']);
    $customers_id = mysqli_real_escape_string($con, $_POST['pcustomer_id']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $position = mysqli_real_escape_string($con, $_POST['position']);
    $date_start = mysqli_real_escape_string($con, $_POST['date_start']);
    $due_date = mysqli_real_escape_string($con, $_POST['due_date']);
    $status = mysqli_real_escape_string($con, $_POST['status']);

    $project_sql = "INSERT INTO project (id, category_id, project_name, customers_id, description, address, position , date_start, due_date, status)
    VALUES ('$current_id', '$category_id', '$project_name', '$customers_id', '$description', '$address', '$position', '$date_start', '$due_date', '$status')";

    $taskMax = "SELECT id FROM task ORDER BY id DESC LIMIT 1";

    $taskId = $con->query($taskMax);

    $current_task_id = 0;

    if ($id->num_rows > 0) {
        $row = $taskId->fetch_assoc();
        $current_task_id = $row['id'] + 1;
    } else {
        echo "No records found.";
    }

    $task_name = mysqli_real_escape_string($con, $_POST['task_name']);
    $task_description = mysqli_real_escape_string($con, $_POST['task_description']);
    $task_start_date = mysqli_real_escape_string($con, $_POST['task_start_date']);
    $selected_workers = isset($_POST['selected_workers']) ? $_POST['selected_workers'] : array();
    $selected_workers_str = implode(",", $selected_workers);

    $products_query = "SELECT * FROM products";
    $available_products = mysqli_query($con, $products_query);
    $product_count = mysqli_num_rows($available_products);

    $material_names_query = "SELECT name FROM products";
    $material_names_result = mysqli_query($con, $material_names_query);
    $material_names = [];

    while ($row = mysqli_fetch_assoc($material_names_result)) {
        $material_names[] = $row['name'];
    }

    $materials_used = [];

    foreach ($_POST as $field_name => $value) {
        if (in_array($field_name, $material_names)) {
            $material_name = mysqli_real_escape_string($con, $field_name);
            $quantity = mysqli_real_escape_string($con, $value);

            $materials_used[] = $material_name;

            $update_query = "UPDATE products SET quantity = quantity - $quantity WHERE name = '$material_name'";
            mysqli_query($con, $update_query);
        }
    }

    // Convert the array of materials used into a comma-separated string
    $materials_used_str = implode(", ", $materials_used);

    $selected_equipment = isset($_POST['selected_equipment']) ? $_POST['selected_equipment'] : array();
    $selected_equipment_str = implode(",", $selected_equipment);

    $task_due_date = mysqli_real_escape_string($con, $_POST['task_due_date']);
    $task_status = mysqli_real_escape_string($con, $_POST['task_status']);
    $task_priority = mysqli_real_escape_string($con, $_POST['task_priority']);

    $task_sql = "INSERT INTO task (id, project_id, task_name, description, start_date, workers, materials, equipments, due_date, status, priority)
    VALUES ('$current_task_id', '$current_id', '$task_name', '$task_description', '$task_start_date', '$selected_workers_str', '$materials_used_str', '$selected_equipment_str', '$task_due_date', '$task_status', '$task_priority')";

    if ($con->query($task_sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $task_sql . "<br>" . $con->error;
    }

    if ($con->query($project_sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $project_sql . "<br>" . $con->error;
    }
}

?>

<!-- Task Modal Add -->
<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel"> <i class="fas fa-plus-circle"></i> Add Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Your form for adding a task goes here -->

                <!-- removed action code-proj.php -->

                <form method="POST" enctype="multipart/form-data"> <!-- store to addedTasks Array -->
                    <input type="text" name="project_name" id="project_name">
                    <input type="number" name="category_id" id="category_id">
                    <input type="number" name="pcustomer_id" id="pcustomer_id">
                    <input type="text" name="description" id="description">
                    <input type="text" name="address" id="address">
                    <input type="text" name="position" id="position">
                    <!-- <input type="file" name="pimage" id="pimage"> -->
                    <input type="text" name="date_start" id="date_start">
                    <input type="text" name="due_date" id="due_date">
                    <input type="text" name="status" id="status">

                    <div class="form-group">
                        <label for="taskName">Task Name</label>
                        <input type="text" class="form-control" id="taskNameAdd" name="task_name" placeholder="Enter task name" required>
                    </div>
                    <div class="form-group">
                        <label for="taskDescription">Description</label>
                        <textarea class="form-control" id="taskDescriptionAdd" name="task_description" rows="3" placeholder="Enter task description" required></textarea>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>Worker</label>
                        <div class="worker-con">
                        </div>
                        <?php
                        $workers_query = "SELECT * FROM employee WHERE position = 'Worker'";
                        $available_workers = mysqli_query($con, $workers_query);
                        $workers_count = mysqli_num_rows($available_workers);

                        if ($workers_count > 0) {
                        ?>
                            <select id="workers" name="workers" class="form-control">
                                <option value="" selected disabled>--Select Workers--</option>
                                <?php
                                foreach ($available_workers as $workers) {
                                ?>
                                    <option value="<?= $workers['name'] ?>"><?= $workers['name'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        <?php
                        } else {
                        ?>
                            <option value="" disabled>No Available Project Manager</option>
                        <?php
                        }
                        ?>
                        <div class="selected-workers">
                            <h4>Selected Workers:</h4>
                            <div id="selected-workers-list"></div>
                        </div>

                        <label>Materials</label>
                        <?php
                        $products_query = "SELECT * FROM products";
                        $available_products = mysqli_query($con, $products_query);
                        $product_count = mysqli_num_rows($available_products);

                        if ($product_count > 0) {
                            foreach ($available_products as $product) {
                        ?>
                                <div class="form-group">
                                    <label for="<?= $product['name'] ?>"><?= $product['name'] ?></label>
                                    <input type="number" id="<?= $product['name'] ?>" name="<?= $product['name'] ?>" class="form-control" min="0">
                                </div>
                            <?php
                            }
                        } else {
                            ?>
                            <p>No Available Products</p>
                        <?php
                        }
                        ?>

                        <label>Equipment</label>
                        <?php
                        $equipment_query = "SELECT * FROM equipment";
                        $available_equipment = mysqli_query($con, $equipment_query);
                        $equipment_count = mysqli_num_rows($available_equipment);

                        if ($equipment_count > 0) {
                        ?>
                            <select id="equipment" name="equipment" class="form-control">
                                <option value="" selected disabled>--Select Equipment--</option>
                                <?php
                                foreach ($available_equipment as $equipment) {
                                ?>
                                    <option value="<?= $equipment['name'] ?>"><?= $equipment['name'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        <?php
                        } else {
                        ?>
                            <option value="" disabled>No Available Equipment</option>
                        <?php
                        }
                        ?>
                        <div class="selected-equipment">
                            <h4>Selected Equipment:</h4>
                            <div id="selected-equipment-list"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="taskName">Start Date</label>
                        <input type="datetime-local" class="form-control" id="taskStartDateAdd" name="task_start_date" required>

                        <label for="taskName">Due Date</label>
                        <input type="datetime-local" class="form-control" id="taskDueDateAdd" name="task_due_date" required>
                    </div>

                    <div class="form-group">
                        <label for="priority">Priority:</label>
                        <select id="taskPriorityAdd" name="task_priority" class="form-control" required>
                            <option value="" hidden>Select Priority Level</option>
                            <option value="0">Low</option>
                            <option value="1">Medium</option>
                            <option value="2">High</option>
                        </select>
                    </div>

                    <!-- Removed Status Selection fixed to 0 => Pending -->

                    <input type="text" id="taskStatusAdd" name="task_status" class="form-control" value="0" required readonly hidden>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-primary">Save Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- // Task List Card -->
</div>

<script>
    $(document).ready(function() {
        // $('#materials').change(function() {
        //     let selectedValue = $(this).val();
        //     let selectedText = $("#materials option:selected").text();

        //     if (selectedValue) {
        //         $('#selected-materials-list').append(`
        //             <div class="selected-material">
        //                 <input type="hidden" name="selected_materials[]" value="${selectedValue}">
        //                 <span>${selectedText}</span>
        //                 <button type="button" class="btn btn-danger remove-material">Remove</button>
        //             </div>
        //         `);

        //         $('#materials').prop('selectedIndex', 0);
        //     }
        // });

        // $(document).on('click', '.remove-material', function() {
        //     $(this).closest('.selected-material').remove();
        // });

        $('#equipment').change(function() {
            let selectedValue = $(this).val();
            let selectedText = $("#equipment option:selected").text();

            if (selectedValue) {
                $('#selected-equipment-list').append(`
                    <div class="selected-equipment">
                        <input type="hidden" name="selected_equipment[]" value="${selectedValue}">
                        <span>${selectedText}</span>
                        <button type="button" class="btn btn-danger remove-equipment">Remove</button>
                    </div>
                `);

                $('#equipment').prop('selectedIndex', 0);
            }
        });

        $(document).on('click', '.remove-equipment', function() {
            $(this).closest('.selected-equipment').remove();
        });

        $('#workers').change(function() {
            let selectedValue = $(this).val();
            let selectedText = $("#workers option:selected").text();

            if ($('#selected-workers-list input[value="' + selectedValue + '"]').length == 0) {
                if (selectedValue) {
                    $('#selected-workers-list').append(`
                        <div class="selected-workers">
                            <input type="hidden" name="selected_workers[]" value="${selectedValue}">
                            <span>${selectedText}</span>
                            <button type="button" class="btn btn-danger remove-workers">Remove</button>
                        </div>
                    `);

                    $('#workers').prop('selectedIndex', 0);
                }
            } else {
                alert("Worker already selected.");
            }
        });

        $(document).on('click', '.remove-workers', function() {
            $(this).closest('.selected-workers').remove();
        });
    });
</script>