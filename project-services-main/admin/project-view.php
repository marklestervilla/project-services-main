<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/dbcon.php');
include('modal/task-modal-add.php');

$proj_id = isset($_GET['proj_id']) ? $_GET['proj_id'] : '';

$stmt = $con->prepare('SELECT project_progress FROM project WHERE id = ?');
$stmt->bind_param('i', $proj_id);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $project_progress = $row['project_progress'];
    }
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Project View</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Project View</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4">
        <?php
        $query = "SELECT project.*, categories.name AS category_name, customers.name AS customer_name 
                  FROM project 
                  LEFT JOIN categories ON project.category_id = categories.id
                  LEFT JOIN customers ON project.customers_id = customers.id
                  WHERE project.id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $proj_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
        ?>
            <div class="card mt-4 shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Project Details
                        <a href="project-index.php" class="btn btn-danger float-right mx-2 btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="<?php echo "uploads_file/" . $row['image']; ?>" class="img-fluid" style="width: 600px; height: 500px;" alt="Project Plan">
                        </div>
                        <div class="col-md-6">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th scope="row">Category</th>
                                        <td><?php echo $row['category_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Project Name</th>
                                        <td><?php echo $row['project_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Client Name</th>
                                        <td><?php echo $row['customer_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Description</th>
                                        <td><?php echo $row['description']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Address</th>
                                        <td><?php echo $row['address']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Project Manager</th>
                                        <td>
                                            <?php
                                            $project_manager_name = $row['position'];
                                            $manager_query = "SELECT * FROM employee WHERE name=?";
                                            $manager_stmt = $con->prepare($manager_query);
                                            $manager_stmt->bind_param('s', $project_manager_name);
                                            $manager_stmt->execute();
                                            $manager_result = $manager_stmt->get_result();

                                            if ($manager_row = $manager_result->fetch_assoc()) {
                                                $manager_image = $manager_row['image'];
                                                echo '<div style="display: flex; align-items: center;">';
                                                echo '<img src="uploads_emp/' . $manager_image . '" alt="Project Manager" class="rounded-circle" style="max-width: 50px; margin-right: 10px;">';
                                                echo '<span>' . $row['position'] . '</span>';
                                                echo '</div>';
                                            } else {
                                                echo 'No image available';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Date Start</th>
                                        <td><?php echo date("F j, Y", strtotime($row['date_start'])); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Due Date</th>
                                        <td><?php echo date("F j, Y", strtotime($row['due_date'])); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Status</th>
                                        <td>
                                            <?php
                                            $status = $row['status'];
                                            $badge_class = '';
                                            switch ($status) {
                                                case 0:
                                                    $badge_class = 'bg-primary'; // Pending
                                                    break;
                                                case 1:
                                                    $badge_class = 'bg-secondary'; // Preparing
                                                    break;
                                                case 2:
                                                    $badge_class = 'bg-warning'; // On-Progress
                                                    break;
                                                case 3:
                                                    $badge_class = 'bg-success'; // Completed
                                                    break;
                                                case 4:
                                                    $badge_class = 'bg-danger'; // Cancelled
                                                    break;
                                                case 5:
                                                    $badge_class = 'bg-danger'; // Archived
                                                    break;
                                                default:
                                                    $badge_class = 'bg-secondary'; // Default
                                                    break;
                                            }
                                            echo '<span class="badge ' . $badge_class . '">' . getStatusText($status) . '</span>';
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Progress %</th>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: <?php echo $project_progress ?>%" aria-valuenow="<?php echo $project_progress ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $project_progress ?>%</div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="alert alert-warning mt-4" role="alert">
                No Record Found
            </div>
        <?php
        }
        ?>

        <!-- Task List Card -->

        <div class="card">
            <div class="card-header">
                <h5>Task List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Task Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Worker</th>
                                <th scope="col" style="width: 200px;">Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $task_query = "SELECT task.*, project.project_name AS project_name
                                           FROM task
                                           LEFT JOIN project ON task.project_id = project.id
                                           WHERE task.project_id = ?";
                            $task_stmt = $con->prepare($task_query);
                            $task_stmt->bind_param('i', $proj_id);
                            $task_stmt->execute();
                            $task_result = $task_stmt->get_result();

                            while ($row = $task_result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $row['task_name']; ?></td>
                                    <td>
                                        <?php
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
                                            case 5:
                                                $badge_class = 'bg-success'; // Archived
                                                break;
                                            default:
                                                $badge_class = 'bg-secondary'; // Default
                                                break;
                                        }
                                        echo '<span class="badge ' . $badge_class . '">' . getStatusText($status) . '</span>';
                                        ?>
                                    </td>
                                    <td><?php echo $row['workers']; ?></td>
                                    <td class="text-nowrap">
                                        <button class="btn btn-sm btn-info view-task" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#viewTaskModal"><i class="fas fa-eye"></i> View</button>
                                        <button class="btn btn-sm btn-secondary" onclick="window.location.href='task-set-status.php?id=<?php echo $row['id']; ?>'">
                                            <i class="fas fa-edit"></i> Edit / Set Status
                                        </button>
                                    </td>
                                </tr>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <style>
            .table th,
            .table td {
                vertical-align: middle;
            }

            .text-nowrap {
                white-space: nowrap;
            }

            .btn {
                margin-right: 5px;
            }
        </style>

        <!-- Task View Modal -->
        <div class="modal fade" id="viewTaskModal" tabindex="-1" role="dialog" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title" id="viewTaskModalLabel">Task View</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <!-- Task details will be loaded dynamically here -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('includes/script.php');
include('includes/footer.php');
?>

<script>
    $(document).ready(function() {
        $('.view-task').click(function(e) {
            e.preventDefault();
            var taskId = $(this).data('id');
            $.ajax({
                url: 'task-view.php',
                type: 'GET',
                data: {
                    id: taskId
                },
                success: function(response) {
                    $('#viewTaskModal .modal-body').html(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
        $('#viewTaskModal').on('hidden.bs.modal', function() {
            location.reload();
        });
    });
</script>

<?php
function getStatusText($status)
{
    switch ($status) {
        case 0:
            return 'Pending';
        case 1:
            return 'Preparing';
        case 2:
            return 'On-progress';
        case 3:
            return 'Completed';
        case 4:
            return 'Cancelled';
        case 5:
            return 'Archived';
        default:
            return 'Unknown';
    }
}

function getPriorityText($priority)
{
    switch ($priority) {
        case 0:
            return 'Low';
        case 1:
            return 'Medium';
        case 2:
            return 'High';
        default:
            return 'Unknown';
    }
}
?>