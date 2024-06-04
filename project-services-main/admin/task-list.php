<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('config/dbcon.php');

?>


<!-- Edit Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateTask">

                    <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>

                    <input type="hidden" name="task_id" id="task_id" readonly>

                    <div class="form-group">
                        <label for="">Task Name</label>
                        <input type="text" name="task_name" id="task_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter Task Description"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Start Date</label>
                        <input type="datetime-local" class="form-control" name="start_date" id="start_date" required />

                        <label for="">Due Date</label>
                        <input type="datetime-local" class="form-control" name="due_date" id="due_date" required />
                    </div>

                    <div class="form-group">
                        <label for="priority">Priority:</label>
                        <select class="form-control" name="priority" id="priority" required>
                            <option value="0">Low</option>
                            <option value="1">Medium</option>
                            <option value="2">High</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select class="form-control" name="status" id="status" required>
                            <option value="0">Pending</option>
                            <option value="1">Preparing</option>
                            <option value="2">On-Progress</option>
                            <option value="3">Completed</option>
                            <option value="4">Cancelled</option>
                        </select>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


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
                        <li class="breadcrumb-item active">Task List</li>
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
                        <h4><b>Task List / Progress</b>
                            <a href="javascript:history.go(-1)" class="btn btn-danger float-right btn-sm"><i class="fas fa-arrow-alt-circle-left"></i> Go Back</a>
                        </h4>


                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Project ID</th>
                                    <th>Task Name</th>
                                    <th>Project Name</th>
                                    <th>Status</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT task.*, project.project_name AS project_name
                                          FROM task
                                          LEFT JOIN project ON task.project_id = project.id";
                                $query_run = mysqli_query($con, $query);

                                if ($query_run) {
                                    while ($row = mysqli_fetch_assoc($query_run)) {
                                ?>
                                        <tr>
                                            <td><?php echo $row['project_id']; ?></td>
                                            <td><?php echo $row['task_name']; ?></td>
                                            <td><?php echo $row['project_name']; ?></td>
                                            <td><?php
                                                $status = $row['status'];
                                                $badge_class = '';
                                                switch ($status) {
                                                    case 0:
                                                        $badge_class = 'bg-secondary'; // Pending
                                                        break;
                                                    case 1:
                                                        $badge_class = 'bg-info'; // Preparing
                                                        break;
                                                    case 2:
                                                        $badge_class = 'bg-primary'; // On-Progress
                                                        break;
                                                    case 3:
                                                        $badge_class = 'bg-success'; // Completed
                                                        break;
                                                    case 4:
                                                        $badge_class = 'bg-danger'; // Cancelled
                                                        break;
                                                    default:
                                                        $badge_class = 'bg-secondary'; // Default
                                                        break;
                                                }
                                                echo '<span class="badge ' . $badge_class . '">' . getStatusText($status) . '</span>';
                                                ?>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-cog"></i> Actions
                                                    </button>

                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                        <!-- <a class="dropdown-item" href="task-edit.php?id=<?= $row['id']; ?>"><i
                                                        class="fas fa-pencil-alt"></i> Edit</a> -->

                                                        <button type="button" class="dropdown-item editTaskBtn" data-toggle="modal" data-target="#editTaskModal" data-id="<?= $row['id']; ?>">
                                                            <i class="fas fa-pencil-alt"></i> Edit
                                                        </button>


                                                        <form action="code-proj.php" method="POST">
                                                            <button type="submit" class="dropdown-item text-danger" name="taskDelete" value="<?= $row['id']; ?>"><i class="fas fa-trash-alt"></i> Delete</button>
                                                        </form>

                                                    </div>
                                                </div>
                                            </td>




                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "Query failed: " . mysqli_error($con);
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <?php include('includes/script.php'); ?>
    <script>
        $(document).ready(function() {
            $('.editTaskBtn').click(function() {
                var task_id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    url: "code-proj.php",
                    data: {
                        task_id: task_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 422) {
                            alert(response.message);
                        } else if (response.status == 200) {
                            $('#editTaskModal #task_id').val(response.data.id);
                            $('#editTaskModal #task_name').val(response.data.task_name);
                            $('#editTaskModal #description').val(response.data.description);
                            $('#editTaskModal #start_date').val(response.data.start_date);
                            $('#editTaskModal #due_date').val(response.data.due_date);
                            $('#editTaskModal #status').val(response.data.status);
                            $('#editTaskModal #priority').val(response.data.priority);

                            $('#editTaskModal').modal('show');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
        $(document).on('submit', '#updateTask', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("update_task", true);

            $.ajax({
                type: "POST",
                url: "code-proj.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errorMessageUpdate').removeClass(response);
                        $('#errorMessageUpdate').text(res.message);
                    } else if (res.status == 200) {
                        $('#errorMessageUpdate').addClass('d-none');
                        $('#editTaskModal').modal('hide');
                        $('#updateTask')[0].reset();

                        // Redirect to task-list.php after successful update
                        window.location.href = 'task-list.php';
                    }
                }
            });
        });
    </script>




    <?php include('includes/footer.php'); ?>

    <?php
    // Function to get status text based on status code
    function getStatusText($status)
    {
        switch ($status) {
            case 0:
                return 'Pending';
                break;
            case 1:
                return 'Preparing';
                break;
            case 2:
                return 'On-progress';
                break;
            case 3:
                return 'Completed';
                break;
            case 4:
                return 'Cancelled';
                break;
            default:
                return 'Unknown';
                break;
        }
    }


    ?>