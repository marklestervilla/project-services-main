<?php
include('authentication.php');

include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('config/dbcon.php');
?>

<!-- Modal -->

<!-- Add Categories Modal -->
<div class="modal fade" id="AddCategoryModal" tabindex="-1" role="dialog" aria-labelledby="AddCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="AddCategoryModalLabel"> <i class="fas fa-plus-circle"></i> Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add your form fields here for adding a user -->
                <form action="code.php" method="POST">
                    <div class="form-group">
                        <label for="category">Category Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" required rows="3"></textarea>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="addCategory" class="btn btn-info">Save</button>
            </div>
            </form>

        </div>
    </div>
</div>
<!-- //Add Categories Modal -->

<!-- Edit Category Modal -->
<div class="modal fade" id="categoriesEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Edit Project Categories</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateCategories">
                <div class="modal-body">
                    <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>

                    <input type="hidden" name="categories_id" id="categories_id">

                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
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


<!-- // Modal -->

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
                            <h4>
                                Project Categories
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#AddCategoryModal">
                                    <i class="fas fa-plus-circle"></i>
                                    Add Category
                                </button>
                            </h4>
                        </div>
                        <div class="card-body">
                            <table id="myCategories" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Created At</th>
                                        <th>Manage</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM categories";
                                    $query_run = mysqli_query($con, $query);

                                    if (mysqli_num_rows($query_run) > 0) {
                                        foreach ($query_run as $categoryitem) {
                                            // echo $cateitem['id'];
                                    ?>
                                            <tr>
                                                <td><?php echo $categoryitem['name']; ?></td>
                                                <td><?php echo date('M d, Y h:i A', strtotime($categoryitem['created_at'])); ?>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-cog"></i> Actions
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <button type="button" value="<?= $categoryitem['id']; ?>" class="dropdown-item editCategoriesBtn btn btn-success">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </button>
                                                            <form action="code.php" method="POST">
                                                                <input type="hidden" name="category_delete_id" value="<?php echo $categoryitem['id']; ?>">
                                                                <button type="submit" name="deleteCategory" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this category?');">
                                                                    <i class="fas fa-trash-alt"></i> Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>


                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="6">No Record Found.</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php include('includes/script.php'); ?>
    <?php include('includes/footer.php'); ?>

    <script>
        $(document).on('click', '.editCategoriesBtn', function() {

            var categories_id = $(this).val();
            // alert(categories_id);

            $.ajax({
                type: "GET",
                url: "code.php?categories_id=" + categories_id,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {

                        alert(res.message);
                    } else if (res.status == 200) {

                        $('#categories_id').val(res.data.id);
                        $('#name').val(res.data.name);
                        $('#description').val(res.data.description);
                        $('#created_at').val(res.data.created_at);

                        $('#categoriesEditModal').modal('show');
                    }
                }
            });

        });

        $(document).on('submit', '#updateCategories', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("update_categories", true);

            $.ajax({
                type: "POST",
                url: "code.php",
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

                        $('#categoriesEditModal').modal('hide');
                        $('#updateCategories')[0].reset();

                        $('#myCategories').load(location.href + " #myCategories");
                    }
                }
            });
        });
    </script>