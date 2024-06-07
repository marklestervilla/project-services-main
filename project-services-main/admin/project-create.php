<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('modal/task-modal-add.php');
?>

<script src="./js/createProject.js"></script> <!-- Create Project & Tasks -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Create Project</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <?php
                alertMessage();
                ?>

                <div class="card">
                    <div class="card-header">
                        <h4>
                            <i class="fas fa-plus-circle"></i> Create Project
                            <a href="project-index.php" class="btn btn-danger btn-sm float-right"><i
                                    class="fas fa-arrow-left"></i> Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="code-proj.php" method="POST" enctype="multipart/form-data">
                            <!-- Removed action="code-proj.php" -->
                            <div class="col-md-12 mb-3">
                                <input type="number" placeholder="Total Task" name="project_num_task"
                                    id="project_num_task" readonly>
                            </div>

                            <hr>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label>Project Name</label>
                                    <input type="text" class="form-control" id="projectNameAdd" name="project_name"
                                        placeholder="Project Name" required>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Select Category:</label>
                                <select id="projectCategoryAdd" name="category_id" class="form-select" required>
                                    <option value="" selected disabled>Select Category</option>
                                    <?php
                                    $categories = getAll('categories');
                                    if ($categories) {
                                        if (mysqli_num_rows($categories) > 0) {
                                            foreach ($categories as $cateItem) {
                                                echo '<option value="' . $cateItem['id'] . '">' . $cateItem['name'] . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">No Category Found!</option>';
                                        }
                                    } else {
                                        echo '<option value="">Something went Wrong!</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Customer:</label>
                                <select id="projectCustomerAdd" name="customers_id" class="form-select" required>
                                    <option value="" selected disabled hidden>Select Client</option>
                                    <?php
                                    $customers = getAll('customers');
                                    if ($customers) {
                                        if (mysqli_num_rows($customers) > 0) {   // same array name and array key same name fixed
                                            foreach ($customers as $customer) {
                                                echo '<option value="' . $customer['id'] . '">' . $customer['name'] . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">No Customers Found!</option>';
                                        }
                                    } else {
                                        echo '<option value="">Something went Wrong!</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-12 mb-6">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea id="projectDescriptionAdd" name="description" class="form-control"
                                        rows="5" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-6">
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea id="projectAddressAdd" name="address" class=" form-control" rows="5"
                                        required></textarea>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Project Manager</label>
                                <?php
                                $available_managers_query = "SELECT * FROM employee WHERE position = 'Project Manager' AND name NOT IN (SELECT DISTINCT position FROM project WHERE status != 5)";
                                $available_managers_run = mysqli_query($con, $available_managers_query);
                                $manager = mysqli_num_rows($available_managers_run);

                                if ($manager > 0) {
                                ?>
                                <select id="projectPositionAdd" name="position" class="form-control" required>
                                    <option value="" selected disabled hidden>--Select Manager--</option>
                                    <?php
                                        foreach ($available_managers_run as $manager) {
                                        ?>
                                    <option value="<?= $manager['name'] ?>"><?= $manager['name'] ?></option>
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
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Project Plan Image</label>
                                    <input type="file" class="form-control" id="projectImageAdd" name="image"
                                        accept="image/*" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="projectStartAdd">Date Start</label>
                                    <input type="date" id="projectStartAdd" name="date_start" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="projectDueAdd">Due Date</label>
                                    <input type="date" id="projectDueAdd" name="due_date" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <input class="form-control" type="text" id="projectStatusCreate" name="status" value="0"
                                    readonly hidden>
                            </div>
                            <div class="card">
                                <button type="submit" class="btn btn-primary float-right" name="saveProject"
                                    <?= $manager == 0 ? 'disabled' : '' ?>>Save Project</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>
                            <i class="fas fa-plus-circle"></i> Add Project Tasks
                            <button type="button" class="btn btn-primary float-right btn-sm" id="addTaskModalBtn">
                                <i class="fas fa-plus-circle"></i> Create Task
                            </button>
                        </h4>
                    </div>
                    <div class="card-body" id="projectCreateTasksList">

                    </div>
                </div>
            </div>
        </div>


        <?php include('includes/script.php'); ?>
        <link href="path/to/summernote.css" rel="stylesheet">
        <script src="path/to/summernote.js"></script>
        <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });
        </script>

        <?php include('includes/footer.php'); ?>

        <script>
        $(document).ready(function() {
            $('#addTaskModalBtn').click(function() {
                $('#project_name').val($('#projectNameAdd').val());
                $('#category_id').val($('#projectCategoryAdd').val());
                $('#pcustomer_id').val($('#projectCustomerAdd').val());
                $('#description').val($('#projectDescriptionAdd').val());
                $('#address').val($('#projectAddressAdd').val());
                $('#position').val($('#projectPositionAdd').val());
                $('#date_start').val($('#projectStartAdd').val());
                $('#due_date').val($('#projectDueAdd').val());
                $('#status').val($('#projectStatusCreate').val());
                $('#addTaskModal').modal('show');
            });

            // Update Due Date input based on selected Start Date
            $('#projectStartAdd').change(function() {
                var startDate = new Date($(this).val());
                var minDueDate = new Date(startDate);
                minDueDate.setDate(minDueDate.getDate() +
                1); // Set minimum due date to be one day after start date
                $('#projectDueAdd').attr('min', formatDate(minDueDate));
            });

            // Disable past dates for Due Date input
            $('#projectDueAdd').change(function() {
                var dueDate = new Date($(this).val());
                var startDate = new Date($('#projectStartAdd').val());

                if (dueDate < startDate) {
                    alert('Due Date cannot be before Start Date.');
                    $(this).val('');
                }
            });
        });

        // Get today's date
        var today = new Date();

        // Set the minimum value for Date Start input
        document.getElementById('projectStartAdd').min = formatDate(today);

        // Set the minimum value for Due Date input based on today's date
        var initialDueDate = new Date(today);
        initialDueDate.setDate(initialDueDate.getDate() + 1); // Minimum due date is one day after today's date
        document.getElementById('projectDueAdd').min = formatDate(initialDueDate);

        // Function to format date as 'YYYY-MM-DD' (required by input type="date")
        function formatDate(date) {
            var year = date.getFullYear();
            var month = (date.getMonth() + 1).toString().padStart(2, '0');
            var day = date.getDate().toString().padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
        </script>

<script>
$(document).ready(function() {
    // Function to format date as 'YYYY-MM-DD' (required by input type="date")
    function formatDate(date) {
        var year = date.getFullYear();
        var month = (date.getMonth() + 1).toString().padStart(2, '0');
        var day = date.getDate().toString().padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // Event listener for start date input change
    $('#projectStartAdd').change(function() {
        var startDate = new Date($(this).val());
        var dueDate = new Date(startDate.getTime() + (30 * 24 * 60 * 60 * 1000)); // Add 30 days to start date
        $('#projectDueAdd').val(formatDate(dueDate)); // Set due date 30 days after start date

        // Make only the first 30 days non-clickable
        $('input[type="date"]').on('change', function() {
            var selectedDate = new Date($(this).val());
            var thirtyDaysLater = new Date(startDate);
            thirtyDaysLater.setDate(thirtyDaysLater.getDate() + 30);

            if (selectedDate <= thirtyDaysLater) {
                $('#projectDueAdd').attr('min', formatDate(thirtyDaysLater));
            } else {
                $('#projectDueAdd').removeAttr('min');
            }
        });
    });

    // Initial setup
    $('#projectStartAdd').trigger('change'); // Trigger change event to set initial due date
});


</script>

    </div>
</div>