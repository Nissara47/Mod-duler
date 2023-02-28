<?php
session_start();
include("dbconnect.php");
$UserID = $_SESSION['UserID'];
$name = $database->getReference('User/' . $_SESSION['UserID'] . '/Name/')->getValue();

// check filter
if (isset($_GET['filter'])) $filter = $_GET['filter'];
else $filter = 0;  //check what filter now if no filter it equal to filter all task

// query part
$ProjectID = $_GET['key'];
$ref = $database->getReference('Project/' . $ProjectID);
$snapshot = $ref->getSnapShot();
$ProjectManager = $ref->getChild('ProjectManager')->getValue();
$Task = $ref->getChild("Task")->getValue();
?>
<html>

<head>
    <title>task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="./CSS/sidebar.css" rel="stylesheet">
</head>

<body>
    <!-- navbar -->
    <?php include('Element/navbar.php') ?>

    <!-- main content -->
    <div class="main">
        <!-- sidebar -->
        <?php include('Element/sidebar.php') ?>

        <!-- task section -->
        <div class="card-md-12 content" style="padding: 20px;">
            <h1 class="display-6">Task
                <!-- create task button section. Show when this user is projectmanager -->
                <?php if ($UserID == $ProjectManager) { ?>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#member" onclick="location.href='createtask.php?key=<?= $ProjectID ?>'">
                        + Create Task
                    </button>
                <?php } ?>
                <!-- filter task dropdown section -->
                <div class="dropdown text-end">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Filter
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="task_view.php?key=<?= $ProjectID ?>&filter=0">all task</a></li>
                        <li><a class="dropdown-item" href="task_view.php?key=<?= $ProjectID ?>&filter=1">my task</a></li>
                    </ul>
                </div>
            </h1>
            <?php
            // if it has task child
            if ($Task != false) {
                // filter = my task
                if ($filter == 1) {
                    foreach ($Task as $TaskKey => $TaskRow) {
                        if ($name == $TaskRow['Responsibility']) {
            ?>
                            <div class="card-body">
                                <h3 class="card-title"><?php echo $TaskRow['TaskName']; ?></h3>
                                <p class="card-text"><small class="text-muted">Responsible by <?php echo $TaskRow['Responsibility']; ?></small></p>
                                <p class="card-text"><?php echo $TaskRow['Description']; ?></p>
                                <!-- show task status -->
                                <?php if ($TaskRow['Status'] == false) { ?>
                                    <p class="text-danger">Not complete</p>
                                <?php } else { ?>
                                    <p class="text-success">complete</p>
                                <?php } ?>
                                <!-- show status checkbox if user is Responsibility -->
                                <?php if ($TaskRow['Status'] == false) { ?>
                                    <h4 onclick="location.href='task_status.php?key=<?= $ProjectID ?>&task=<?= $TaskKey ?>&filter=<?= $filter ?>'" class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                        <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                                    </h4>
                                <?php } else { ?>
                                    <h4 onclick="location.href='task_status.php?key=<?= $ProjectID ?>&task=<?= $TaskKey ?>&filter=<?= $filter ?>'" class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                                        <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                    </h4>
                                <?php } ?>

                                <p class="text-end">
                                    <!-- edit button part chect if projectmanager -->
                                    <?php if ($UserID == $ProjectManager) { ?>
                                        <a href="edittask.php?key=<?= $ProjectID ?>&task=<?= $TaskKey ?>&filter=<?= $filter ?>" class="btn btn-outline-primary"> + Edit Task</a>
                                    <?php } ?>
                                    End date : <?php echo date('l, d/m/y', strtotime($TaskRow['EndDate'])); ?>
                                </p>
                            </div>
                        <?php } ?>
                    <?php }
                } else {
                    // filter = all task
                    foreach ($Task as $TaskKey => $TaskRow) {
                    ?>
                        <div class="card-body">
                            <h3 class="card-title"><?php echo $TaskRow['TaskName']; ?></h3>
                            <p class="card-text"><small class="text-muted">Responsible by <?php echo $TaskRow['Responsibility']; ?></small></p>
                            <p class="card-text"><?php echo $TaskRow['Description']; ?></p>
                            <!-- show task status -->
                            <?php if ($TaskRow['Status'] == false) { ?>
                                <p class="text-danger">Not complete</p>
                            <?php } else { ?>
                                <p class="text-success">complete</p>
                            <?php } ?>
                            <!-- show status checkbox if user is Responsibility -->
                            <?php if ($TaskRow['Responsibility'] == $name) { ?>
                                <?php if ($TaskRow['Status'] == false) { ?>
                                    <h4 onclick="location.href='task_status.php?key=<?= $ProjectID ?>&task=<?= $TaskKey ?>&filter=<?= $filter ?>'" class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                        <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                                    </h4>
                                <?php } else { ?>
                                    <h4 onclick="location.href='task_status.php?key=<?= $ProjectID ?>&task=<?= $TaskKey ?>&filter=<?= $filter ?>'" class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                                        <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                    </h4>
                            <?php }
                            } ?>

                            <p class="text-end">
                                <!-- edit button part. Show when this user is projectmanager. -->
                                <?php if ($UserID == $ProjectManager) { ?>
                                    <a href="edittask.php?key=<?= $ProjectID ?>&task=<?= $TaskKey ?>&filter=<?= $filter ?>" class="btn btn-outline-primary"> + Edit Task</a>
                                <?php } ?>
                                End date : <?php echo date('l, d/m/y', strtotime($TaskRow['EndDate'])); ?>
                            </p>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                No task YEAH!!!!
            <?php } ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>