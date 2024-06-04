<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../admin/index.php" class="brand-link d-flex align-items-center">
        <img src="assets/dist/img/icon-gbua.jpg" alt="GBUA Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8; width: 50px; height: 50px;">
        <div class="ml-2" style="line-height: 1;">
            <span class="brand-text font-weight-bold"
                style="font-size: 1.5rem; color: #007bff; letter-spacing: 0.05rem;">
                GBUA
            </span>
            <span class="brand-text font-weight-light" style="font-size: 1.5rem; color: white;">
                SERVICES
            </span>
        </div>
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
                <?php 
                $current_file_name = basename($_SERVER['SCRIPT_NAME']);
                ?>
                <li class="nav-item">
                    <a href="index.php" class="nav-link <?= ($current_file_name == 'index.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="appointment-view.php"
                        class="nav-link <?= ($current_file_name == 'appointment-view.php') ? 'active' : ''; ?>">
                        <i class="nav-icon far fa-calendar-check"></i>
                        <span class="badge badge-warning right"><?= getCount('appointment'); ?></span>
                        <p>Appointment</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="categories.php"
                        class="nav-link <?= ($current_file_name == 'categories.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>Categories</p>
                    </a>
                </li>



                <?php if($_SESSION['auth_role'] == '2') : ?>

                <li
                    class="nav-item has-treeview <?= in_array($current_file_name, ['equipment.php', 'products.php', 'category-create.php', 'category.php']) ? 'menu-open' : ''; ?>">
                    <a href="#"
                        class="nav-link <?= in_array($current_file_name, ['equipment.php', 'products.php', 'category-create.php', 'category.php']) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Inventory <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="equipment.php"
                                class="nav-link <?= ($current_file_name == 'equipment.php') ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>Equipments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="products.php"
                                class="nav-link <?= ($current_file_name == 'products.php') ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-box-open"></i>
                                <p>Materials</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="category.php"
                                class="nav-link <?= ($current_file_name == 'category.php') ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>View Category</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <?php endif; ?>


                <li
                    class="nav-item has-treeview <?= in_array($current_file_name, ['project-create.php', 'project-index.php']) ? 'menu-open' : ''; ?>">
                    <a href="#"
                        class="nav-link <?= in_array($current_file_name, ['project-create.php', 'project-index.php']) ? 'active' : ''; ?>">
                        <i class="nav-icon fa fa-paperclip"></i>
                        <span class="badge badge-info right"><?= getCount('project'); ?></span>
                        <p>Project Plan <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="project-create.php"
                                class="nav-link <?= ($current_file_name == 'project-create.php') ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>Create Project</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="project-index.php"
                                class="nav-link <?= ($current_file_name == 'project-index.php') ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Project List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="task-list.php"
                        class="nav-link <?= ($current_file_name == 'task-list.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-check-circle"></i>
                        <p>Task List</p>
                    </a>
                </li>
                <?php if($_SESSION['auth_role'] == '2') : ?>
                <li class="nav-header">ARCHIVED</li>
                <li class="nav-item">

                    <a href="project-report.php"
                        class="nav-link <?= ($current_file_name == 'project-report.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-folder"></i>
                        <p>Project Record</p>
                    </a>
                </li>
                <?php endif; ?>
                
                <?php if($_SESSION['auth_role'] == '2') : ?>
                <li class="nav-header">INFO</li>
                
                <li
                    class="nav-item has-treeview <?= in_array($current_file_name, ['registered.php', 'employee-create.php', 'employee.php', 'customers-create.php', 'customers.php']) ? 'menu-open' : ''; ?>">
                    <a href="#"
                        class="nav-link <?= in_array($current_file_name, ['registered.php', 'employee-create.php', 'employee.php', 'customers-create.php', 'customers.php']) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-circle text-success"></i>
                        <p>Records <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="registered.php"
                                class="nav-link <?= ($current_file_name == 'registered.php') ? 'active' : ''; ?>">
                                <i class="nav-icon far fa-circle text-warning"></i>
                                <p>Registered User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="employee-create.php"
                                class="nav-link <?= ($current_file_name == 'employee-create.php') ? 'active' : ''; ?>">
                                <i class="nav-icon far fa-circle text-danger"></i>
                                <p>Create Employee</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="employee.php"
                                class="nav-link <?= ($current_file_name == 'employee.php') ? 'active' : ''; ?>">
                                <i class="nav-icon far fa-circle text-danger"></i>
                                <p>View Employee</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="customers-create.php"
                                class="nav-link <?= ($current_file_name == 'customers-create.php') ? 'active' : ''; ?>">
                                <i class="nav-icon far fa-circle text-primary"></i>
                                <p>Create Customer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="customers.php"
                                class="nav-link <?= ($current_file_name == 'customers.php') ? 'active' : ''; ?>">
                                <i class="nav-icon far fa-circle text-primary"></i>
                                <span class="badge badge-danger right me-2"><?= getCount('customers'); ?></span>
                                  <p>View Customers</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>