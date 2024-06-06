<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('config/dbcon.php');

if (isset($_GET['id'])) {
    $task_id = mysqli_real_escape_string($con, $_GET['id']);

    $stmt = $con->prepare('SELECT * FROM task WHERE id = ?');
    $stmt->bind_param('i', $task_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $task = $result->fetch_assoc();

    $project_id = $task['project_id'];

    $stmt = $con->prepare('SELECT project_name FROM project WHERE id = ?');
    $stmt->bind_param('i', $project_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $project = $result->fetch_assoc();
}

?>

<script src="./js/setTaskStatus.js"></script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <?php
            alertMessage();
            ?>

            <div class="row mb-2">
                <div class="col-sm-6">
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit or Set Task Status</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                <i class="fas fa-edit"></i> Edit / Set Task Status
                                <a href="javascript:history.go(-1)" class="btn btn-danger float-right btn-sm"><i class="fas fa-arrow-alt-circle-left"></i> Go Back</a>
                            </h4>
                        </div>

                        <div class="card-body">

                            <form id="taskFormUpdate" method="post" enctype="multipart/form-data"> <!-- Removed action="code-proj.php" -->

                                <input type="hidden" name="task_id" value="<?= $task['id']; ?>">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="taskName">Task Name</label>
                                        <input type="text" class="form-control" name="task_name" value="<?= $task['task_name']; ?>">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Project Name</label>
                                        <input type="text" class="form-control" name="project_name" value="<?= $project['project_name']; ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="taskDescription">Description</label>
                                        <textarea class="form-control" id="taskDescription" name="task_description" rows="3"><?= $task['description']; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="taskName">Start Date</label>
                                        <input type="datetime-local" class="form-control" id="taskStartDateEdit" name="start_date" required
       min="<?= date('Y-m-d\TH:i'); ?>" value="<?= date('Y-m-d\TH:i'); ?>">


                                        <label for="taskName">Due Date</label>
                                        <input type="datetime-local" class="form-control" id="taskDueDateEdit" name="due_date" required value="<?php echo date('Y-m-d\TH:i', strtotime($task['due_date'])); ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="priority">Priority:</label>
                                        <select name="priority" class="form-select">
                                            <option value="0" <?php if ($task['priority'] == 0) echo 'selected'; ?>>Low</option>
                                            <option value="1" <?php if ($task['priority'] == 1) echo 'selected'; ?>>Medium</option>
                                            <option value="2" <?php if ($task['priority'] == 2) echo 'selected'; ?>>High</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status:</label>
                                        <select id="selectedStatus" name="status" class="form-select">
                                            <option value="0" <?php if ($task['status'] == 0) echo 'selected'; ?>>Pending</option>
                                            <option value="1" <?php if ($task['status'] == 1) echo 'selected'; ?>>Preparing</option>
                                            <option value="2" <?php if ($task['status'] == 2) echo 'selected'; ?>>On-Progress</option>
                                            <option value="3" <?php if ($task['status'] == 3) echo 'selected'; ?>>Completed</option>
                                            <option value="4" <?php if ($task['status'] == 4) echo 'selected'; ?>>Cancelled</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12" id="commentSection" style="display: none;">
                                    <div class="form-group">
                                        <label for="comment">Comment</label>
                                        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                                    </div>
                                </div>

                                <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                                <input type="hidden" name="id" value="<?php echo $task_id; ?>">

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Apply Changes</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
    </section>

    <?php include('includes/script.php'); ?>
    <?php include('includes/footer.php'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('selectedStatus');
            const commentSection = document.getElementById('commentSection');

            statusSelect.addEventListener('change', function() {
                if (statusSelect.value === '4') {
                    commentSection.style.display = 'block';
                } else {
                    commentSection.style.display = 'none';
                }
            });

            // Initial check in case the page loads with "Cancelled" status
            if (statusSelect.value === '4') {
                commentSection.style.display = 'block';
            }
        });
    </script>

