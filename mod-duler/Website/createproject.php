<?php session_start();
            include('dbconnect.php'); ?>
<html>
<head>
    <title>create project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="./CSS/sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/createproject.css">
    <script src="checkdate.js"></script>
</head>

<body>
    <!-- navbar -->
    <?php include('Element/navbar.php') ?>

        <!-- create project -->
        <form method="post">
            <h3>CREATE PROJECT</h3>
            <!-- create input, button -->
            <label>Projectname</label><input id="projectname" name="projectname" type="text" required><br>
            Description<input id="discription" name="discription" type="text" required><br>
            Start Date<input type="date" id="startdate" name="startdate" required><br>
            End Date<input type="date" id="enddate" name="enddate" required><br>

            <input style="display:none;" type='submit'>    
            <button type="submit" name="create" id="submit_bt">CREATE</button>
            <button onclick="location.href='user_home.php'" class ="end_button" type="button" name="cancle">CANCEL</button>

            <!-- edit -->
            <?php
            if (isset($_POST['create'])) {
                $manager = $_SESSION['UserID'];
                $projectname = $_POST['projectname'];
                $discription = $_POST['discription'];
                $startdate = $_POST['startdate'];
                $enddate = $_POST['enddate'];
                $postData = [
                    'ProjectName' => $projectname,
                    'Description' => $discription,
                    'StartDate' => $startdate,
                    'EndDate' => $enddate,
                    'ProjectManager' => $manager,
                    'Task' => false,
                    'Member' => false
                ];
                $database->getReference('Project')->push($postData);  //push data to db
                echo '<script>';
                echo 'location.href="user_home.php"'; //create project success, back to main page
                echo '</script>';
            }
            ?>
        </form>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>

<script>
    function myFunction() {
        document.getElementById("create").reset();
    }
</script>