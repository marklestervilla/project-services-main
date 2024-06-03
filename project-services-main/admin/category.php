<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('config/dbcon.php');
?>

<!-- Edit Category Modal -->
<div class="modal fade" id="categoryEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateCategory">
                <div class="modal-body">

                    <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>

                    <input type="hidden" name="category_id" id="category_id">

                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" name="status" id="status" style="width:30px;height:30px;" value="1">

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

<!-- Delete Category Modal -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-trash"></i> Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this category?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a id="deleteCategoryBtn" class="btn btn-danger" href="#">Delete</a>
            </div>
        </div>
    </div>
</div>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <?php alertMessage(); ?>

                    <div class="card">
                        <div class="card-header">
                            <h4>
                                Material Category
                                <a href="category-create.php" class="btn btn-primary float-right btn-sm"><i
                                        class="fas fa-plus-circle"></i> Add Category</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <?php
                        $poscat = getAll('poscategories', 'status'); // Fetch only unavailable categories
                        if(!$poscat){
                          echo '<h4>Something Went Wrong!</h4>';
                          return false;
                        }
                        if(mysqli_num_rows($poscat) > 0)
                        {
                        ?>
                            <table id="myCategory" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Manage</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach($poscat as $Item) : ?>
                                    <tr>
                                        <td><?= $Item['name'] ?></td>
                                        <td><?= $Item['description'] ?></td>
                                        <td>
                                            <?php
                                if($Item['status'] == 1){
                                    echo '<span class="badge bg-danger">Unavailable</span>';
                                }else{
                                    echo '<span class="badge bg-primary">Available</span>';
                                }
                                ?>
                                        </td>

                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                    id="actionDropdown" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false"><i class="fas fa-cog"></i>
                                                    Actions
                                                </button>

                                                <div class="dropdown-menu"
                                                    aria-labelledby="actionDropdown<?= $Item['id']; ?>">
                                                    <button type="button"
                                                        class="editCategoryBtn dropdown-item btn-success btn-sm"
                                                        data-category-id="<?= $Item['id']; ?>">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <button type="button" class="dropdown-item deleteCategoryBtn"
                                                        data-category-id="<?= $Item['id']; ?>">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
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
    $(document).ready(function() {
        // Edit category button click
        $(document).on('click', '.editCategoryBtn', function() {
            var category_id = $(this).data('category-id');

            $.ajax({
                type: "GET",
                url: "code-pos.php?category_id=" + category_id,
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        alert(res.message);
                    } else if (res.status == 200) {
                        $('#category_id').val(res.data.id);
                        $('#name').val(res.data.name);
                        $('#description').val(res.data.description);
                        $('#status').prop('checked', res.data.status == 1 ? true : false);
                        $('#categoryEditModal').modal('show');
                    }
                }
            });
        });

        // Delete category button click
        $(document).on('click', '.deleteCategoryBtn', function() {
            var category_id = $(this).data('category-id');
            $('#deleteCategoryBtn').attr('href', 'code-pos.php?delete_category=' + category_id);
            $('#deleteCategoryModal').modal('show');
        });

        // Submit update category form
        $(document).on('submit', '#updateCategory', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("update_category", true);

            $.ajax({
                type: "POST",
                url: "code-pos.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response); // Debugging output
                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errorMessageUpdate').removeClass('d-none');
                        $('#errorMessageUpdate').text(res.message);
                    } else if (res.status == 200) {
                        $('#errorMessageUpdate').addClass('d-none');
                        $('#categoryEditModal').modal('hide');
                        $('#updateCategory')[0].reset();
                        $('#myCategory').load(location.href + " #myCategory", function() {
                            console.log("Reloaded table"); // Debugging output
                        });
                    } else {
                        $('#errorMessageUpdate').removeClass('d-none');
                        $('#errorMessageUpdate').text(res.message);
                    }
                }
            });
        });
    });
    </script>