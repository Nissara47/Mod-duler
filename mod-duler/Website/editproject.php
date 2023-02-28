<?php 
session_start();
include('dbconnect.php');
$key = $_GET['key'];
$keytask = $database->getReference('Project/' . $key)->getValue();
$check = 2;
?>

<html>

<head>
    <title>Edit Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="./CSS/sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/createproject.css">
    <script src="checkdate.js"></script>

</head>

<body>
    <!-- navbar -->
    <?php
    include('./Element/navbar.php'); ?>

    <!-- main content -->
    <form method="post">
        <!-- edit project form -->
        <h3>EDIT PROJECT</h3>
        <label>New Name</label><input id="name" name="name" type="text"><br>
        New Description<br><input id="discription" name="discription" type="text"><br>
        New Start Date<br><input type="date" id="startdate" name="startdate"><br>
        New End Date<br><input type="date" id="enddate" name="enddate"><br>
        <input style="display:none;" name="edit" id="submit_bt" type='submit' />
        <button type="button" onclick="checkdate()">EDIT</button>
        <button onclick="location.href='project_overview.php?key=<?= $key ?>'" class ="end_button" type="button" name="cancle">CANCEL</button>

        <?php

        if (isset($_POST['edit'])) { //if click on edit button
            $name = $_POST['name'];
            $discription = $_POST['discription'];
            $startdate = $_POST['startdate'];
            $enddate = $_POST['enddate'];
            //if user did not fill these boxs then use the same data as before.
            if (empty($_POST['discription'])) {
                $discription = $keytask['Description'];
                $check--;
            }
            if (empty($_POST['startdate'])) {
                $startdate = $keytask['StartDate'];
            }
            if (empty($_POST['enddate'])) {
                $enddate = $keytask['EndDate'];
            }
            if (empty($_POST['name'])) {
                $name = $keytask['ProjectName'];
                $check--;
            }
            //update data part.
            $postData = [
                $key => [
                    'Description' => $discription,
                    'StartDate' => $startdate,
                    'EndDate' => $enddate,
                    'ProjectName' => $name,
                    'ProjectManager' => $_SESSION['UserID'],
                    'Member' => $keytask['Member'],
                    'Task' => $keytask['Task']
                ]
            ];
            $ref = 'Project/';
            $database->getReference($ref)->update($postData);
            echo "<script>";
            if($check == 0 && empty($_POST['startdate']) && empty($_POST['enddate'])) {
                echo  "alert(\"data not change\");";
            } else{
                echo "alert(\"edit success\");";
            }
            echo 'window.location.href = "project_overview.php?key='.$key.'"'; //edit project success, back to project overview
            echo "</script>";
        }

        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</form>

</html>