<!-- Task Modal Add -->
<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="addTaskModalLabel">
                    <i class="fas fa-plus-circle"></i> Add Task
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" id="projectTaskForm">
                    <!-- Hidden fields to pass additional data -->
                    <input type="hidden" name="project_name" id="project_name">
                    <input type="hidden" name="category_id" id="category_id">
                    <input type="hidden" name="pcustomer_id" id="pcustomer_id">
                    <input type="hidden" name="description" id="description">
                    <input type="hidden" name="address" id="address">
                    <input type="hidden" name="position" id="position">
                    <input type="hidden" name="date_start" id="date_start">
                    <input type="hidden" name="due_date" id="due_date">
                    <input type="hidden" name="status" id="status">

                    <!-- Task Details -->
                    <div class="form-group">
                        <label for="taskNameAdd">Task Name</label>
                        <input type="text" class="form-control" id="taskNameAdd" name="task_name"
                            placeholder="Enter task name" required>
                    </div>
                    <div class="form-group">
                        <label for="taskDescriptionAdd">Description</label>
                        <textarea class="form-control" id="taskDescriptionAdd" name="task_description" rows="3"
                            placeholder="Enter task description" required></textarea>
                    </div>

                    <hr>

                    <!-- Workers Selection -->
                    <div class="form-group">
                        <label for="workers">Worker:</label>
                        <div class="worker-con"></div>
                        <select id="workers" name="workers" class="form-control">
                            <option value="" selected disabled>--Select Workers--</option>
                            <?php
                            $workers_query = "SELECT * FROM employee WHERE position = 'Worker'";
                            $available_workers = mysqli_query($con, $workers_query);
                            $workers_count = mysqli_num_rows($available_workers);
                            if ($workers_count > 0) {
                                foreach ($available_workers as $worker) {
                                    echo "<option value='{$worker['name']}'>{$worker['name']}</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No Available Workers</option>";
                            }
                            ?>
                        </select>
                        <div class="selected-workers mt-2">
                            <div id="selected-workers-list"></div>
                        </div>
                    </div>

                    <hr>

                    <!-- Button to Show/Hide Materials -->
                    <label>Materials:
                        <button type="button" id="toggleMaterials" class="btn btn-success btn-sm">Show Material
                            List</button>
                    </label>



                    <!-- Materials Selection -->
                    <div class="form-group" id="materialsList" style="display: none;">
                        <!-- <label>Material List:</label> -->
                        <?php
$products_query = "SELECT * FROM products";
$available_products = mysqli_query($con, $products_query);
$product_count = mysqli_num_rows($available_products);
if ($product_count > 0) {
    foreach ($available_products as $product) {
        $formatted_price = number_format($product['price'], 2); // Format the price with commas
        echo "<div class='form-group'>
                <label for='{$product['name']}'>{$product['name']} (Price: ₱ {$formatted_price})</label>
                <input type='number' id='{$product['name']}' name='{$product['name']}' class='form-control product-quantity' min='0' data-price='{$product['price']}' data-available='{$product['quantity']}'>
            </div>";
    }
} else {
    echo "<p>No Available Products</p>";
}
?>


                        <div class="form-group">
                            <label>Total Price:</label>
                            <input type="text" id="totalPrice" name="total_price" class="form-control" readonly>
                        </div>
                    </div>



                    <hr>

                    <!-- Equipment Selection -->
                    <div class="form-group">
                        <label for="equipment">Equipment:</label>
                        <select id="equipment" name="equipment" class="form-control">
                            <option value="" selected disabled>--Select Equipment--</option>
                            <?php
                            $equipment_query = "SELECT * FROM equipment";
                            $available_equipment = mysqli_query($con, $equipment_query);
                            $equipment_count = mysqli_num_rows($available_equipment);
                            if ($equipment_count > 0) {
                                foreach ($available_equipment as $equip) {
                                    echo "<option value='{$equip['name']}'>{$equip['name']}</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No Available Equipment</option>";
                            }
                            ?>
                        </select>
                        <div class="selected-equipment mt-2">
                            <div id="selected-equipment-list"></div>
                        </div>
                    </div>

                    <hr>

                    <!-- Task Dates and Priority -->
                    <div class="form-group">
                        <label for="taskStartDateAdd">Start Date</label>
                        <input type="datetime-local" class="form-control" id="taskStartDateAdd" name="task_start_date"
                            required min="<?php echo date('Y-m-d\TH:i'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="taskDueDateAdd">Due Date</label>
                        <input type="datetime-local" class="form-control" id="taskDueDateAdd" name="task_due_date"
                            required min="<?php echo date('Y-m-d\TH:i'); ?>">
                    </div>

                    <div class="form-group">
                        <label for="taskPriorityAdd">Priority</label>
                        <select id="taskPriorityAdd" name="task_priority" class="form-control" required>
                            <option value="" hidden>Select Priority Level</option>
                            <option value="0">Low</option>
                            <option value="1">Medium</option>
                            <option value="2">High</option>
                        </select>
                    </div>

                    <!-- Hidden Status -->
                    <input type="hidden" id="taskStatusAdd" name="task_status" class="form-control" value="0" required
                        readonly>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button id="saveTaskBtn" class="btn btn-info">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../js/createProject.js"></script>
<script>

$(document).ready(function() {
    const productInputs = document.querySelectorAll('.product-quantity');
    const totalPriceField = document.getElementById('totalPrice');

    productInputs.forEach(input => {
        input.addEventListener('input', calculateTotalPrice);
    });

    function calculateTotalPrice() {
        let total = 0;
        productInputs.forEach(input => {
            const price = parseFloat(input.getAttribute('data-price'));
            const quantity = parseInt(input.value) || 0;
            total += price * quantity;
        });
        totalPriceField.value = total.toFixed(2);
    }

    $('#taskStartDateAdd').change(function() {
        // Get the selected start date value
        const startDate = new Date($(this).val());
        // Calculate the due date by adding one week to the start date
        const dueDate = new Date(startDate.getTime() + 7 * 24 * 60 * 60 * 1000);
        // Format the due date in YYYY-MM-DDTHH:MM format required by datetime-local input
        const formattedDueDate = dueDate.toISOString().slice(0, 16);
        // Set the value and min attribute of the due date input field
        $('#taskDueDateAdd').val(formattedDueDate);
        $('#taskDueDateAdd').attr('min', formattedDueDate); // Set the minimum allowed date
    });


    $('#saveTaskBtn').click(function(event) {
        event.preventDefault();
        $.ajax({
            url: './modal/addTask.php',
            type: "POST",
            data: $('#projectTaskForm').serialize(),
            success: function(response) {
                console.log(response);
                $('#addTaskModal').modal('hide');
                $('#selected-workers-list').empty();
                $('#selected-equipment-list').empty();
                $('#projectTaskForm')[0].reset();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    $('#materialsList').change(function() {
        let isValid = true;
        productInputs.forEach(input => {
            const quantity = parseInt(input.value) || 0;
            const availableQuantity = parseInt(input.getAttribute('data-available')) || 0;
            if (quantity > availableQuantity) {
                isValid = false;
                alert(`The entered quantity for ${input.name} exceeds the available quantity.`);
                return false;
            }
        });

        if (!isValid) {
            return;
        }
    });

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

<script>
$(document).ready(function() {
    $('#toggleMaterials').click(function() {
        $('#materialsList').toggle();
        if ($('#materialsList').is(':visible')) {
            $(this).text('Hide Materials');
        } else {
            $(this).text('Show Material List');
        }
    });
});
</script>

<style>
.selected-workers,
.selected-equipment {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.selected-workers span,
.selected-equipment span {
    margin-right: 10px;
}
</style>