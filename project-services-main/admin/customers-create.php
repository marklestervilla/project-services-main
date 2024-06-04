<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('config/dbcon.php');
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
                        <li class="breadcrumb-item active">Add Customer</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <style>
        .container {
            max-width: 600px;
        }
        .form-group {
            margin-bottom: 20px;
        }
    </style>

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-success">
                            <h2> <i class="fas fa-plus-circle"></i> Add New Customer
                                <!-- <a href="customers.php" class="btn btn-danger btn-sm float-right"><i
                                        class="fas fa-arrow-left"></i> Back</a> -->
                            </h2>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <div class="container mt-5">
                                <form action="code-pos.php" method="POST">
                                    <div class="form-group">
                                        <label for="name">Full Name:</label>
                                        <input type="text" class="form-control" name="name"
                                            placeholder="Enter Customer Name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control" name="email"
                                            placeholder="Enter Email Address" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone:</label>
                                        <input type="tel" class="form-control" name="phone"
                                            placeholder="Enter Contact no." required>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="status" name="status">
                                            <label class="form-check-label" for="status">Status *
                                                (UnChecked=CashPayment, Checked=OnlinePayment)</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="card-footer">
                                    <button type="submit" name="saveCustomer" class="btn btn-primary float-right"><i class="fas fa-save"></i> Save</button>
                                    <a href="customers.php" class="btn btn-danger float-right me-2">Back</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include('includes/script.php'); ?>
    <?php include('includes/footer.php'); ?>