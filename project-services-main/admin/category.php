<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('config/dbcon.php');
?>

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
                                Category
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
                            <table class="table table-bordered">
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
                                                <div class="dropdown-menu" aria-labelledby="actionDropdown">
                                                    <a href="category-edit.php?id=<?= $Item['id']; ?>"
                                                        class="dropdown-item btn-primary btn-sm"><i class="fas fa-edit"></i>
                                                        Edit
                                                    </a>
                                                    <a href="#" onclick="confirmDelete(<?= $Item['id']; ?>)"
                                                        class="dropdown-item btn-danger btn-sm"><i class="fas fa-trash"></i>
                                                        Delete
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
    function confirmDelete(id) {
        $('#deleteCategoryBtn').attr('href', 'category-delete.php?id=' + id);
        $('#deleteCategoryModal').modal('show');
    }
    </script>