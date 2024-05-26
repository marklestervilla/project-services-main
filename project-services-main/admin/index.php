<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('./config/dbcon.php');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <?php
            alertMessage();
            ?>
            <div class="row mb-2">
                <div class="col-sm-6 d-flex">
                    <h1 class="m-0">DASHBOARD</h1>
                    <?php
                    $query = "SELECT * FROM project GROUP BY id";
                    $result = mysqli_query($con, $query);
                    ?>
                    <select name="projects" id="projects">
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="' . $row['id'] . '">' . $row['project_name'] . '</option>';
                        }
                        ?>
                    </select>
                    <?php
                    ?>
                    <button id="generateProject">Generate PDF</button>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3><?= getCount('appointment'); ?></h3>
                            <p>APPOINTMENT</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-calendar"></i>
                        </div>
                        <a href="appointment-view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= getCount('project'); ?></h3>
                            <p>PROJECT</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="project.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= getCount('employee'); ?></h3>
                            <p>EMPLOYEE</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a href="employee.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= getCount('customers'); ?></h3>
                            <p>CUSTOMERS</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="customers.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- <div class="col-md-3 mb-3">
    <div class="card card-body p-3">
      <p class="text-sm mb-0 text-capitalize font-weight-bold">Orders</p>
    </div>
  </div> -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3><?= getCount('orders'); ?></h3>
                            <p>PROJECT ORDERS</p>
                        </div>
                        <div class="icon">
                            <!-- <i class="ion ion-bag"></i> -->
                        </div>
                        <!-- <a href="orders.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>
                                <?php
                                $todayDate = date('Y-m-d');
                                $todayOrders = mysqli_query($con, "SELECT * FROM orders WHERE order_date='$todayDate' ");
                                if ($todayOrders) {
                                    if (mysqli_num_rows($todayOrders) > 0) {
                                        $totalCountOrders = mysqli_num_rows($todayOrders);
                                        echo $totalCountOrders;
                                    } else {
                                        echo "0";
                                    }
                                }
                                ?>
                            </h3>
                            <p>TODAY ORDERS</p>
                        </div>
                        <div class="icon">
                            <!-- <i class="ion ion-bag"></i> -->
                        </div>
                        <!-- <a href="orders.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <hr>
                    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
                    <style>
                        .progress {
                            height: 20px;
                        }
                    </style>
                    
<div class="container mt-5">
    <h2>Projects</h2>
    <table id="project-table" class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Project Name</th>
            <th>Project Manager</th>
            <th>Status</th>
            <th>Progress</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>1</td>
            <td>Project A</td>
            <td>John Doe</td>
            <td>In Progress</td>
            <td>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    <button id="add-project-btn" class="btn btn-primary">Add Project</button>
</div> -->
                </div>
            </div>
        </div>
    </section>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <?php include('includes/script.php'); ?>
    <?php include('includes/footer.php'); ?>
    <script>
        $(document).ready(() => {
            // let projectIdCounter = 2;

            // function addProjectRow() {
            //     projectIdCounter++;

            //     const progressPercentage = Math.floor(Math.random() * 100) + 1;
            //     const newRow = document.createElement("tr");
            //     newRow.innerHTML = `
            //                         <td>${projectIdCounter}</td>
            //                         <td>Project ${String.fromCharCode(65 + projectIdCounter)}</td>
            //                         <td>Manager ${projectIdCounter}</td>
            //                         <td>In Progress</td>
            //                         <td>
            //                             <div class="progress">
            //                                 <div class="progress-bar bg-success" role="progressbar" style="width: ${progressPercentage}%;"
            //                                     aria-valuenow="${progressPercentage}" aria-valuemin="0" aria-valuemax="100">${progressPercentage}%</div>
            //                             </div>
            //                         </td>
            //                     `;
            //     document.getElementById("project-table").getElementsByTagName("tbody")[0].appendChild(newRow);
            // }


            // document.getElementById("add-project-btn").addEventListener("click", function() {
            //     addProjectRow();
            // });

            $('#generateProject').on('click', function() {
                fetch(`fetch_project.php?proj_id=${$('#projects').val()}`)
                    .then(response => response.json())
                    .then(data => {
                        const tableBody = [
                            [{
                                text: 'Material',
                                bold: true
                            }, {
                                text: 'Quantity',
                                bold: true
                            }, {
                                text: 'Cost',
                                bold: true
                            }]
                        ];

                        data.tasks.forEach(task => {
                            task.materials.forEach(material => {
                                let cost = parseFloat(material.cost);
                                tableBody.push([material.name, material.quantity, cost.toFixed(2)]);
                            });
                            tableBody.push([{
                                text: 'Total Cost',
                                colSpan: 2,
                                alignment: 'right'
                            }, {}, task.total_cost.toFixed(2)]);
                        });

                        let docDefinition = {
                            content: [{
                                    text: "Project Name: " + data.project_name,
                                    fontSize: 16,
                                    bold: true,
                                    margin: [0, 0, 0, 10]
                                },
                                {
                                    text: "Total Workers: " + data.total_workers,
                                    fontSize: 14,
                                    margin: [0, 0, 0, 10]
                                },
                                {
                                    text: "Address: " + data.address,
                                    fontSize: 14,
                                    margin: [0, 0, 0, 10]
                                },
                                {
                                    text: "Total Tasks: " + data.total_tasks,
                                    fontSize: 14,
                                    margin: [0, 0, 0, 10]
                                },
                                {
                                    text: "Total Cost: ₱" + parseFloat(data.total_cost).toFixed(2),
                                    fontSize: 14,
                                    margin: [0, 0, 0, 10]
                                },
                                {
                                    text: "Materials Used: " + data.all_materials,
                                    fontSize: 14,
                                    margin: [0, 0, 0, 10]
                                },
                                {
                                    text: "Equipments Used: " + data.all_equipments,
                                    fontSize: 14,
                                    margin: [0, 0, 0, 10]
                                },
                                {
                                    text: 'Material Costing',
                                    fontSize: 14,
                                    bold: true,
                                    margin: [0, 0, 0, 10]
                                },
                                {
                                    table: {
                                        headerRows: 1,
                                        widths: ['*', '*', '*'],
                                        body: tableBody
                                    }
                                }
                            ]
                        };

                        pdfMake.createPdf(docDefinition).open();
                    });
            });
        });
    </script>
</div>