<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('./config/dbcon.php');

// Fetch project progress and other project details
function getProjectDetails($con) {
    $query = "SELECT id, project_name, project_progress, status FROM project";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Database query failed: " . mysqli_error($con));
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$projectDetails = getProjectDetails($con);
?>

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
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <?php
                $sections = [
                    ['color' => 'primary', 'title' => 'APPOINTMENT', 'icon' => 'calendar', 'link' => 'appointment-view.php'],
                    ['color' => 'success', 'title' => 'PROJECT', 'icon' => 'stats-bars', 'link' => 'project.php'],
                    ['color' => 'warning', 'title' => 'EMPLOYEE', 'icon' => 'person', 'link' => 'employee.php'],
                    ['color' => 'danger', 'title' => 'CUSTOMERS', 'icon' => 'person-add', 'link' => 'customers.php'],
                ];

                foreach ($sections as $section) {
                    echo "
                    <div class='col-lg-3 col-6'>
                        <div class='small-box bg-{$section['color']}'>
                            <div class='inner'>
                                <h3>" . getCount(strtolower($section['title'])) . "</h3>
                                <p>{$section['title']}</p>
                            </div>
                            <div class='icon'>
                                <i class='ion ion-{$section['icon']}'></i>
                            </div>
                            <a href='{$section['link']}' class='small-box-footer'>More info <i class='fas fa-arrow-circle-right'></i></a>
                        </div>
                    </div>";
                }
                ?>
            </div>

            <!-- Project Information Small Box -->
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h6>Project Information</h6>
                        </div>
                        <div class="card-body">
                            <table id="project-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Progress</th>
                                        <th>Status</th>
                                        <th>Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($projectDetails as $project) {
                                        $statusClasses = [
                                            'Pending' => 'badge-secondary',
                                            'Preparing' => 'badge-info',
                                            'On-Progress' => 'badge-primary',
                                            'Completed' => 'badge-success',
                                            'Cancelled' => 'badge-danger',
                                            'Unknown' => 'badge-dark'
                                        ];
                                        $statusTexts = [
                                            0 => 'Pending',
                                            1 => 'Preparing',
                                            2 => 'On-Progress',
                                            3 => 'Completed',
                                            4 => 'Cancelled'
                                        ];

                                        $statusText = $statusTexts[$project['status']] ?? 'Unknown';
                                        $statusClass = $statusClasses[$statusText];

                                        echo "<tr>
                                            <td>{$project['project_name']}</td>
                                            <td>
                                                <div class='progress'>
                                                    <div class='progress-bar' role='progressbar' style='width: {$project['project_progress']}%' aria-valuenow='{$project['project_progress']}' aria-valuemin='0' aria-valuemax='100'>{$project['project_progress']}%</div>
                                                </div>
                                            </td>
                                            <td><span class='badge $statusClass'>$statusText</span></td>
                                            <td><a href='project-view.php?proj_id={$project['id']}' class='btn btn-primary btn-sm'><i class='fas fa-folder'></i> View</a></td>
                                        </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Project Generating Report -->
                <div class="col-lg-6 col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">Generating Project Report</h6>
                        </div>
                        <div class="card-body">
                            <?php
                            $projects = getProjectDetails($con);
                            ?>
                            <div class="form-group">
                                <label for="projects">Select Project</label>
                                <select class="form-control" name="projects" id="projects">
                                    <?php
                                    foreach ($projects as $project) {
                                        echo '<option value="' . $project['id'] . '">' . $project['project_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <button id="generateProject" class="btn btn-success mt-3 float-right"><i
                                    class="far fa-file-pdf"></i> Generate PDF</button>
                        </div>
                    </div>
                </div>
                <!-- End of Project Generating Report -->

            </div>
        </div>
    </section>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<?php include('includes/script.php'); ?>
<?php include('includes/footer.php'); ?>

<script>
$(document).ready(() => {
    $('#generateProject').on('click', function() {
        const projectId = $('#projects').val();
        fetch(`fetch_project.php?proj_id=${projectId}`)
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
                        tableBody.push([material.name, material.quantity, cost
                            .toFixed(2)
                        ]);
                    });
                    tableBody.push([{
                        text: 'Total Cost',
                        colSpan: 2,
                        alignment: 'right'
                    }, {}, task.total_cost.toFixed(2)]);
                });

                const docDefinition = {
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