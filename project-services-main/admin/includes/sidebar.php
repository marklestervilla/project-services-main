<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="assets/dist/img/icon-gbua.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">GBUA Services</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="assets/dist/img/pfpicon.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    <?php 
                    if(isset($_SESSION['auth'])) {
                        echo $_SESSION['auth_user']['user_name']; 
                    } else {
                        echo "Not Logged In.";
                    }
                    ?>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="index.php" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="appointment-view.php" class="nav-link">
                        <i class="nav-icon far fa-calendar-check"></i>
                        <p>Appointment</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="categories.php" class="nav-link">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>Categories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="equipment.php" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Equipments</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="products.php" class="nav-link">
                        <i class="nav-icon fas fa-box-open"></i>
                        <p>Materials</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="order-create.php" class="nav-link">
                        <i class="nav-icon far fa-plus-square"></i>
                        <p>Create Order</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="orders.php" class="nav-link">
                        <i class="nav-icon far fa-list-alt"></i>
                        <span class="badge badge-warning right"><?= getCount('orders'); ?></span>
                        <p>Orders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="category-create.php" class="nav-link">
                        <i class="nav-icon far fa-folder"></i>
                        <p>Create Category</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="category.php" class="nav-link">
                        <i class="nav-icon far fa-folder"></i>
                        <p>View Category</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="project-create.php" class="nav-link">
                        <i class="nav-icon fa fa-paperclip"></i>
                        <span class="badge badge-info right"><?= getCount('project'); ?></span>
                        <p>Create Project</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="project-index.php" class="nav-link">
                        <i class="nav-icon fa fa-paperclip"></i>
                        <p>Project List</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="task-list.php" class="nav-link">
                        <i class="nav-icon fas fa-check-circle"></i>
                        <p>Task List</p>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="productivity-list.php" class="nav-link">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <p>Productivity List</p>
                    </a>
                </li> -->
                <li class="nav-header">GENERATING REPORTS</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-file"></i>
                        <p>Project Reports</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-file"></i>
                        <p>Task Reports</p>
                    </a>
                </li>
                <li class="nav-header">INFO</li>
                <li class="nav-item">
                    <a href="registered.php" class="nav-link">
                        <i class="nav-icon far fa-circle text-warning"></i>
                        <p>Registered User</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="employee-create.php" class="nav-link">
                        <i class="nav-icon far fa-circle text-danger"></i>
                        <p>Create Employee</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="employee.php" class="nav-link">
                        <i class="nav-icon far fa-circle text-danger"></i>
                        <p>View Employee List</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="customers-create.php" class="nav-link">
                        <i class="nav-icon far fa-circle text-primary"></i>
                        <p>Create Customer</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="customers.php" class="nav-link">
                        <i class="nav-icon far fa-circle text-primary"></i>
                        <p>View Customer</p>
                    </a>
                </li>
                <li class="nav-header">SETTINGS</li>
                <li class="nav-item">
                    <a href="settings.php" class="nav-link">
                        <i class="nav-icon far fa-circle"></i>
                        <p>Software Settings</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
