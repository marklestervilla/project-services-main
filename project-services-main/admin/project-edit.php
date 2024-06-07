<?php
include('../admin/config/dbcon.php');
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');

// Fetch the uploaded project from the database with category names

$sql = "SELECT project.*, categories.name AS category_name 
        FROM project 
        JOIN categories ON project.category_id = categories.id";
$result = $con->query($sql);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Project</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php alertMessage(); ?>
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-edit"></i>Edit Project
                        <a href="project-index.php" class="btn btn-danger btn-sm float-right"><i class="fas fa-arrow-left"></i> Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <?php
                        $id = $_GET['proj_id'];
                        $project_query = "SELECT * FROM project WHERE id='$id'";
                        $project_query_run = mysqli_query($con, $project_query);

                        if (mysqli_num_rows($project_query_run) > 0) {
                            foreach ($project_query_run as $row) {
                        ?>
                                <form action="code-proj.php" method="POST" enctype="multipart/form-data">
                                    <div class="col-md-2 mb-3">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>" class="form-control" />
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label>Select Category:</label>
                                        <select name="category_id" class="form-control mySelect2" required>
                                            <option value="" selected disabled hidden>Select Category</option>
                                            <?php
                                            $categories = getAll('categories');
                                            if ($categories) {
                                                if (mysqli_num_rows($categories) > 0) {
                                                    foreach ($categories as $cateItem) {
                                                        $selected = ($cateItem['id'] == $row['category_id']) ? 'selected' : '';
                                                        echo '<option value="' . $cateItem['id'] . '" ' . $selected . '>' . $cateItem['name'] . '</option>';
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
                                    <div class="col-md-8 mb-3">
                                        <div class="form-group">
                                            <label for="project_name" class="form-label">Project Name</label>
                                            <input type="text" class="form-control" name="project_name" value="<?php echo $row['project_name']; ?>" id="project_name">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-6">
                                        <div class="form-group">
                                            <label for="">Description </label>
                                            <textarea name="description" class="form-control" rows="5"><?php echo $row['description']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-6">
                                        <div class="form-group">
                                            <label for="">Address *</label>
                                            <textarea id="summernote" name="address" class="form-control" rows="5"><?php echo $row['address']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="">Project Manager</label>
                                        <?php
                                        $available_managers_query = "SELECT * FROM employee WHERE position='Project Manager' AND name NOT IN (SELECT DISTINCT position FROM project)";
                                        $available_managers_run = mysqli_query($con, $available_managers_query);
                                        if (mysqli_num_rows($available_managers_run) > 0) {
                                        ?>
                                            <select name="project_manager" class="form-control" required>
                                                <option value="" disabled>--Select Manager--</option>
                                                <?php
                                                foreach ($available_managers_run as $manager) {
                                                    $selected = ($manager['name'] == $row['position']) ? "selected" : "";
                                                ?>
                                                    <option value="<?= $manager['name'] ?>" <?= $selected ?>><?= $manager['name'] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        <?php
                                        } else {
                                        ?>
                                            <select name="project_manager" class="form-control" disabled>
                                                <option value="" disabled>No Available Project Manager</option>
                                            </select>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="name">Project Plan Image *</label>
                                            <input type="file" class="form-control" name="image" />
                                            <div class="col-md-6 mb-3">
                                                <img src="<?php echo "uploads_file/" . $row['image']; ?>" width="100" height="100" alt="Project Plan Image">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="">Date Start</label>
                                    <input type="date" id="projectStartEdit" name="date_start" value="<?php echo $row['date_start']; ?>" class="form-control" />
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="">Due Date</label>
                                    <input type="date" id="projectDueEdit" name="due_date" value="<?php echo $row['due_date']; ?>" class="form-control" />
                                </div>
                            </div>

                                    <div class="col-md-3 mb-3">
                                        <div class="form-group">
                                            <label for="status">Status:</label>
                                            <select name="status" class="form-control" value="<?php echo $row['status']; ?>">
                                                <option value="0">Pending</option>
                                                <option value="1">Preparing</option>
                                                <option value="2">On-Progress</option>
                                                <option value="3">Completed</option>
                                                <option value="4">Cancelled</option>
                                                <option value="5">Archived</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary float-right" name="updateProject">Update Project</button>
                                        </div>
                                    </div>

                                </form>
                        <?php
                            }
                        } else {
                            echo "No Data Found";
                        }

                        ?>


                    </div>
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

<script>
        $(document).ready(function() {
            $('#summernote').summernote();

            function formatDate(date) {
                var year = date.getFullYear();
                var month = (date.getMonth() + 1).toString().padStart(2, '0');
                var day = date.getDate().toString().padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            $('#projectStartEdit').change(function() {
                var startDate = new Date($(this).val());
                var dueDate = new Date(startDate.getTime() + (30 * 24 * 60 * 60 * 1000)); // Add 30 days to start date
                $('#projectDueEdit').val(formatDate(dueDate)); // Set due date 30 days after start date
            });

            $('#projectStartEdit').trigger('change');
        });
    </script>
<script>
// Update Due Date input based on selected Start Date
            $('#projectStartEdit').change(function() {
                var startDate = new Date($(this).val());
                var minDueDate = new Date(startDate);
                minDueDate.setDate(minDueDate.getDate() +
                1); // Set minimum due date to be one day after start date
                $('#projectDueEdit').attr('min', formatDate(minDueDate));
            });

            // Disable past dates for Due Date input
            $('#projectDueEdit').change(function() {
                var dueDate = new Date($(this).val());
                var startDate = new Date($('#projectStartAdd').val());

                if (dueDate < startDate) {
                    alert('Due Date cannot be before Start Date.');
                    $(this).val('');
                }
            });

        // Get today's date
        var today = new Date();

        // Set the minimum value for Date Start input
        document.getElementById('projectStartEdit').min = formatDate(today);

        // Set the minimum value for Due Date input based on today's date
        var initialDueDate = new Date(today);
        initialDueDate.setDate(initialDueDate.getDate() + 1); // Minimum due date is one day after today's date
        document.getElementById('projectDueEdit').min = formatDate(initialDueDate);

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
        $('#projectStartEdit').change(function() {
            var startDate = new Date($(this).val());
            var dueDate = new Date(startDate.getTime() + (30 * 24 * 60 * 60 * 1000)); // Add 30 days to start date
            $('#projectDueEdit').val(formatDate(dueDate)); // Set due date 30 days after start date

            // Ensure the due date is at least one day after the start date
            var minDueDate = new Date(startDate);
            minDueDate.setDate(minDueDate.getDate() + 1); // Minimum due date is one day after the start date
            $('#projectDueEdit').attr('min', formatDate(minDueDate));
        });

        // Ensure the due date is not before the start date
        $('#projectDueEdit').change(function() {
            var dueDate = new Date($(this).val());
            var startDate = new Date($('#projectStartEdit').val());

            if (dueDate <= startDate) {
                alert('Due Date cannot be before or the same as Start Date.');
                $(this).val('');
            }
        });

        // Set the minimum value for Date Start input to today's date
        var today = new Date();
        document.getElementById('projectStartEdit').min = formatDate(today);

        // Set initial due date and minimum due date when the page loads
        $('#projectStartEdit').trigger('change');
    });
</script>


    <?php include('includes/footer.php'); ?>