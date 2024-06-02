<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('./config/dbcon.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Other head elements -->

    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Smooth zoom effect on hover for specific cards */
        .zoom-card {
            transition: transform 0.3s ease-in-out;
        }

        .zoom-card:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <?php alertMessage(); ?>
                <div class="row mb-2">
                    <div class="col-sm-6 d-flex">
                        <h1 class="m-0">DASHBOARD</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-xl-3 col-md-6 mb-4">
                        <a href="customers.php" class="text-decoration-none">
                            <div class="card shadow h-200 py-2 zoom-card" style="border-left: 4px solid #007bff;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-l font-weight-bold text-primary text-uppercase mb-1">
                                                Appointment</div>
                                            <div class="h1 mb-0 font-weight-bold text-gray-500"><?= getCount('appointment'); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-3x text-gray-100"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <a href="project-index.php" class="text-decoration-none">
                            <div class="card shadow h-200 py-2 zoom-card" style="border-left: 4px solid #28a745;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-l font-weight-bold text-success text-uppercase mb-1">
                                                Project</div>
                                            <div class="h1 mb-0 font-weight-bold text-gray-500"><?= getCount('project'); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-chart-bar fa-3x text-gray-100"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <a href="employee.php" class="text-decoration-none">
                            <div class="card shadow h-200 py-2 zoom-card" style="border-left: 4px solid #ffc107;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-l font-weight-bold text-warning text-uppercase mb-1">
                                                Employee</div>
                                            <div class="h1 mb-0 font-weight-bold text-gray-500"><?= getCount('employee'); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-3x text-gray-100"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <a href="customers.php" class="text-decoration-none">
                            <div class="card shadow h-200 py-2 zoom-card" style="border-left: 4px solid #17a2b8;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-l font-weight-bold text-info text-uppercase mb-1">
                                                Customer</div>
                                            <div class="h1 mb-0 font-weight-bold text-gray-500"><?= getCount('customers'); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-3x text-gray-100"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <hr>

                            <!-- Project Information Small Box -->
                            <div class="row">
                                <div class="col-lg-6 col-6">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">
                                            <h6>Project Information</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="inner">
                                                <table id="projectDataTable" class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Project Name</th>
                                                            <th scope="col">Progress</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">Manage</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $query = "SELECT id, project_name, project_progress, status FROM project";
                                                        $result = mysqli_query($con, $query);

                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $projectId = $row['id'];
                                                            $projectName = $row['project_name'];
                                                            $progress = $row['project_progress'];
                                                            $status = $row['status'];

                                                            switch ($status) {
                                                                case 0:
                                                                    $statusText = 'Pending';
                                                                    $statusClass = 'badge-secondary';
                                                                    break;
                                                                case 1:
                                                                    $statusText = 'Preparing';
                                                                    $statusClass = 'badge-info';
                                                                    break;
                                                                case 2:
                                                                    $statusText = 'On-Progress';
                                                                    $statusClass = 'badge-primary';
                                                                    break;
                                                                case 3:
                                                                    $statusText = 'Completed';
                                                                    $statusClass = 'badge-success';
                                                                    break;
                                                                case 4:
                                                                    $statusText = 'Cancelled';
                                                                    $statusClass = 'badge-danger';
                                                                    break;
                                                                case 5:
                                                                    $statusText = 'Archived';
                                                                    $statusClass = 'badge-success';
                                                                    break;
                                                                default:
                                                                    $statusText = 'Unknown';
                                                                    $statusClass = 'badge-dark';
                                                                    break;
                                                            }

                                                            echo '<tr>';
                                                            echo '<td>' . $projectName . '</td>';
                                                            echo '<td>';
                                                            echo '<div class="progress">';
                                                            echo '<div class="progress-bar" role="progressbar" style="width: ' . $progress . '%" aria-valuenow="' . $progress . '" aria-valuemin="0" aria-valuemax="100">' . $progress . '%</div>';
                                                            echo '</div>';
                                                            echo '</td>';
                                                            echo '<td><span class="badge ' . $statusClass . '">' . $statusText . '</span></td>';
                                                            echo '<td><a href="project-view.php?proj_id=' . $projectId . '" class="btn btn-primary btn-sm"><i class="fas fa-folder"></i> View</a></td>';
                                                            echo '</tr>';
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Include Bootstrap CSS -->
                                <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

                                <!-- Project Generating Report -->
                                <div class="col-lg-6 col-12">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="mb-0">Generating Project Report</h6>
                                        </div>
                                        <div class="card-body">
                                            <!-- Project Selection -->
                                            <div class="form-group">
                                                <label for="projects">Select Project: </label>
                                                <select class="form-control" name="projects" id="projects">
                                                    <?php
                                                    $query = "SELECT * FROM project GROUP BY id";
                                                    $result = mysqli_query($con, $query);
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . $row['id'] . '">' . $row['project_name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- // Project Selection -->

                                            <button id="generateProject" class="btn btn-success float-right">
                                                <i class="fas fa-file-pdf mr-1"></i> Generate PDF
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- // Project Generating Report -->
                            </div>
                            <!-- End of Project Information Small Box -->
                        </div>
                    </div>
                </div>
        </section>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <?php include('includes/script.php'); ?>
        <?php include('includes/footer.php'); ?>

        <script>
            $(document).ready(() => {
                $('#projectDataTable').DataTable();

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
                                    text: 'Total Cost',
                                    bold: true
                                }]
                            ];

                            data.grouped_materials.forEach(material => {
                                let totalCost = parseFloat(material.total_cost);
                                tableBody.push([material.name, material.quantity, totalCost.toFixed(2)]);
                            });

                            let materialsUsedText = "Materials Used: " + data.grouped_materials.map(material => material.name).join(', ');
                            const groupedEquipments = data.all_equipments.split(', ').reduce((acc, equipment) => {
                                acc[equipment] = acc[equipment] ? acc[equipment] + 1 : 1;
                                return acc;
                            }, {});

                            let equipmentsUsedText = "Equipments Used: " + Object.keys(groupedEquipments).join(', ');

                            // Function to convert image to base64 and resize
                            function convertImageToBase64(imageUrl, callback) {
                                const img = new Image();
                                img.crossOrigin = 'Anonymous';
                                img.onload = function() {
                                    const canvas = document.createElement('canvas');
                                    const MAX_WIDTH = 150;
                                    const MAX_HEIGHT = 150;
                                    let width = this.width;
                                    let height = this.height;

                                    if (width > height) {
                                        if (width > MAX_WIDTH) {
                                            height *= MAX_WIDTH / width;
                                            width = MAX_WIDTH;
                                        }
                                    } else {
                                        if (height > MAX_HEIGHT) {
                                            width *= MAX_HEIGHT / height;
                                            height = MAX_HEIGHT;
                                        }
                                    }

                                    canvas.width = width;
                                    canvas.height = height;
                                    const ctx = canvas.getContext('2d');
                                    ctx.drawImage(this, 0, 0, width, height);
                                    const base64String = canvas.toDataURL('image/png').split(',')[1];
                                    callback(base64String);
                                };
                                img.src = imageUrl;
                            }

                            // Call function to convert image to base64 and resize
                            convertImageToBase64('images/icon-gbua-trans.png', function(base64Image) {
                                let docDefinition = {
                                    content: [{
                                            image: `data:image/png;base64,${base64Image}`,
                                            width: 50, // Adjust the width as needed
                                            height: 50, // Adjust the height as needed
                                            alignment: 'center',
                                            margin: [0, 0, 0, 10]
                                        },
                                        {
                                            text: "God Bless Us All Services",
                                            style: 'header'
                                        },
                                        {
                                            text: "Blk 8 Lot 59 Birmingham Village Pulo, Cabuyao Laguna",
                                            style: 'subheader'
                                        },
                                        {
                                            text: "gbuaconstructionservices@gmail.com",
                                            style: 'subheader'
                                        },
                                        {
                                            columns: [{
                                                    width: '*',
                                                    text: [{
                                                            text: 'Customer Details\n',
                                                            style: 'sectionHeader'
                                                        },
                                                        {
                                                            text: `Full Name: ${data.customer_name}\n`
                                                        },
                                                        {
                                                            text: `Phone Number.: ${data.customer_phone}\n`
                                                        },
                                                        {
                                                            text: `Email Address: ${data.customer_email}\n`
                                                        },
                                                    ]
                                                },
                                                {
                                                    width: '*',
                                                    alignment: 'right',
                                                    text: [{
                                                            text: 'Invoice Details\n',
                                                            style: 'sectionHeader'
                                                        },
                                                        {
                                                            text: `Invoice Date: ${new Date().toLocaleDateString()}\n`
                                                        },
                                                        {
                                                            text: `Address: ${data.address}\n`
                                                        },
                                                    ]
                                                }
                                            ]
                                        },
                                        {
                                            text: "Project Details",
                                            style: 'sectionHeader'
                                        },
                                        {
                                            text: `Project Name: ${data.project_name}`,
                                            margin: [0, 0, 0, 10]
                                        },
                                        {
                                            text: `Total Workers: ${data.total_workers}`,
                                            margin: [0, 0, 0, 10]
                                        },
                                        {
                                            text: `Total Tasks: ${data.total_tasks}`,
                                            margin: [0, 0, 0, 10]
                                        },
                                        {
                                            text: `Total Cost: ₱${parseFloat(data.total_cost).toFixed(2)}`,
                                            margin: [0, 0, 0, 10]
                                        },
                                        {
                                            text: materialsUsedText,
                                            margin: [0, 0, 0, 10]
                                        },
                                        {
                                            text: equipmentsUsedText,
                                            margin: [0, 0, 0, 10]
                                        },
                                        {
                                            text: 'Material Costing',
                                            style: 'sectionHeader'
                                        },
                                        {
                                            table: {
                                                headerRows: 1,
                                                widths: ['*', '*', '*'],
                                                body: tableBody
                                            }
                                        }
                                    ],
                                    styles: {
                                        header: {
                                            fontSize: 18,
                                            bold: true,
                                            alignment: 'center'
                                        },
                                        subheader: {
                                            fontSize: 14,
                                            alignment: 'center'
                                        },
                                        sectionHeader: {
                                            fontSize: 14,
                                            bold: true,
                                            margin: [0, 10, 0, 10]
                                        }
                                    }
                                };

                                pdfMake.createPdf(docDefinition).open();
                            });
                        });
                });
            });
        </script>

    </div>