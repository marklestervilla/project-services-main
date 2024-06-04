<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('config/dbcon.php');

?>



<!-- Edit Customer Modal -->
<div class="modal fade" id="customerEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Edit Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateCustomer">
                <div class="modal-body">

                    <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>

                    <input type="hidden" name="customer_id" id="customer_id">

                    <div class="form-group">
                        <label for="">Full Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="status" name="status">
                            <label class="form-check-label" for="status">Status *
                                (UnChecked=CashPayment, Checked=OnlinePayment)</label>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Customer Modal -->

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="confirmDeleteModalLabel"> <i class="fas fa-trash"></i> Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5> <b> Are you sure you want to delete this customer?</b></h5>

            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> -->
                <a href="#" id="deleteCustomerBtn" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</a>
            </div>
        </div>
    </div>
</div>

<!-- //Delete Customer Modal -->


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                <?php 
                alertMessage();
                ?>

                    <div class="card">
                        <div class="card-header">
                            <h2>
                                <i class="fas fa-user"></i> Customer Record
                                <a href="customers-create.php" class="btn btn-primary btn-sm float-right"> <i
                                        class="fas fa-plus-circle"></i> Add Customer</a>
                            </h2>
                        </div>
                        <div class="card-body">
                            <?php
                        $customers = getAll('customers');
                        if(!$customers){
                          echo '<h4>Something Went Wrong!</h4>';
                          return false;
                        }
                        if(mysqli_num_rows($customers) > 0)
                        {
                        ?>
                            <table id="example1" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <!-- <th># ID</th> -->
                                        <th>Full Name</th>
                                        <th>Email Address</th>
                                        <th>Phone Number</th>
                                        <!-- <th>Payment Mode</th> -->
                                        <th>Manage</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach($customers as $customer) : ?>
                                    <tr>
                                        <!-- <td><?= $customer['id'] ?></td> -->
                                        <td><?= $customer['name'] ?></td>
                                        <td><?= $customer['email'] ?></td>
                                        <td><?= $customer['phone'] ?></td>
                                        <!-- <td>
                                            <?php
                                if ($customer['status'] == 1) {
                                    echo '<span class="badge bg-primary">Online Payment</span>';
                                } else {
                                    echo '<span class="badge bg-success">Cash Payment</span>';
                                }
                                ?>
                                        </td> -->
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-cog"></i> Actions
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <button type="button" value="<?= $customer['id']; ?>"
                                                        class="dropdown-item editCustomerBtn btn btn-success">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <a class="dropdown-item deleteCustomerBtn" href="#"
                                                        data-customer-id="<?= $customer['id']; ?>">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </td>


                                    </tr>

                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>

                        <?php
                    }
                    else
                    {
                      ?>
                        <h4 class="mb-0">No Record Found</h4>
                        <?php
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include('includes/script.php'); ?>
    <?php include('includes/footer.php'); ?>

    <script>
    $(document).on('click', '.editCustomerBtn', function() {
        var customer_id = $(this).val();

        $.ajax({
            type: "GET",
            url: "code-pos.php?customer_id=" + customer_id,
            success: function(response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 422) {
                    alert(res.message);
                } else if (res.status == 200) {
                    $('#customer_id').val(res.data.id);
                    $('#name').val(res.data.name);
                    $('#email').val(res.data.email);
                    $('#phone').val(res.data.phone);
                    $('#status').prop('checked', res.data.status == 1);

                    $('#customerEditModal').modal('show');
                }
            }
        });
    });

    $(document).on('submit', '#updateCustomer', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append("update_customer", true);

        $.ajax({
            type: "POST",
            url: "code-pos.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 422) {
                    $('#errorMessageUpdate').removeClass('d-none');
                    $('#errorMessageUpdate').text(res.message);
                } else if (res.status == 200) {
                    $('#errorMessageUpdate').addClass('d-none');
                    $('#customerEditModal').modal('hide');
                    $('#updateCustomer')[0].reset();

                    location.reload();
                } else {
                    $('#errorMessageUpdate').removeClass('d-none');
                    $('#errorMessageUpdate').text(res.message);
                }
            }
        });
    });
    </script>


    <script>
    $(document).ready(function() {
        $('.deleteCustomerBtn').click(function(e) {
            e.preventDefault(); // Prevent default action of link
            var customerId = $(this).data('customer-id'); // Get customer ID from data attribute
            $('#deleteCustomerBtn').attr('href', 'customers-delete.php?id=' +
                customerId); // Set href attribute of delete button
            $('#confirmDeleteModal').modal('show'); // Show modal dialog
        });
    });
    </script>