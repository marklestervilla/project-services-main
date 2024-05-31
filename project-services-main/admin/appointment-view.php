<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
?>

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
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Appointment</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <!-- <th>ID</th> -->
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Time</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM appointment WHERE id";
                $query_run = mysqli_query($con, $query);

                if (mysqli_num_rows($query_run) > 0) {
                    foreach ($query_run as $row) {
                ?>
                        <tr>
                            <!-- <td><?= $row['id']; ?></td> -->
                            <td><?= $row['FIRSTNAME']; ?></td>
                            <td><?= $row['LASTNAME']; ?></td>
                            <td><?= $row['PHONE']; ?></td>
                            <td><?= $row['EMAIL']; ?></td>
                            <td><?= date('g:i A', strtotime($row['TIME'])); ?></td>
                            <td><?= date("F d, Y", strtotime($row['DATE'])); ?></td>
                            <td><?= $row['STATUS']; ?></td>
                            <td>
                                <form id="form-<?= $row['id']; ?>" method="post" action="code.php" class="d-flex">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <button type="button" class="btn btn-success btn-sm flex-fill me-2" onclick="confirmAction('approve', <?= $row['id']; ?>, 'Are you sure you want to approve this appointment?')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm flex-fill me-2" onclick="confirmAction('cancel', <?= $row['id']; ?>, 'Are you sure you want to cancel this appointment?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm flex-fill" onclick="confirmAction('delete', <?= $row['id']; ?>, 'Are you sure you want to delete this appointment?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <input type="hidden" id="appoint_btn-<?= $row['id']; ?>" name="appoint_btn">
                                </form>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='8'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('includes/script.php'); ?>
<script>
    function confirmAction(action, id, message) {
        Swal.fire({
            title: 'Confirm',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, do it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('appoint_btn-' + id).value = action;
                document.getElementById('form-' + id).submit();
            }
        });
    }   
</script>
<?php include('includes/footer.php'); ?>