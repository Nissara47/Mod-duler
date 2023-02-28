<?php //query part
include('dbconnect.php');
session_start();
$key = $_GET['key'];
$manager = $_SESSION["Username"];
$ref = $database->getReference('Project/' . $key . '/');
$Taskname = $_GET['task'];
$keytask = $database->getReference('Project/' . $key . '/Task/' . $Taskname)->getValue();
$data = $ref->getValue();
$start = $data['StartDate'];
$end = $data['EndDate'];
?>
<html>

<head>
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="./CSS/sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/createproject.css">
    <script src="checkdate.js"></script>

</head>

<body>
    <!-- navbar -->
    <?php include('./Element/navbar.php'); ?>

    <!-- main content -->
    <form method="post">
        <h3>EDIT TASK</h3>
        <!-- create input, button, select -->
        <label>Description</label><input id="discription" name="discription" type="text"><br>
        Start Date<br><input type="date" id="startdate" name="startdate" <?php echo "min=" . $start . " max=" . $end . " value=" . $keytask['StartDate']; ?>><br>
        End Date<br><input type="date" id="enddate" name="enddate" <?php echo "min=" . $start . " max=" . $end . " value=" . $keytask['EndDate']; ?>><br>

        Responsibility of<br><select name="member" class="form-select" id="member">
            <!-- query member from db -->
            <option value="">-- select mem --</option>
            <?php
            include('function-for-member.php');
            querymem($key);
            ?>
        </select><br>

        <input style="display:none;" name="create" id="submit_bt" type='submit' />
        <button type="button"  onclick="checkdate()">EDIT</button>
        <button type="submit" id = "delete" onclick="return confirm('Are you sure?')" name="deletetask">DELETE</button>
        <button onclick="location.href='task_view.php?key=<?= $key ?>'" class ="end_button" type="button" name="cancle">CANCEL</button>

        <!-- edit -->
        <?php
        $check = 2;
        if (isset($_POST['create'])) {
            $discription = $_POST['discription'];
            $startdate = $_POST['startdate'];
            $enddate = $_POST['enddate'];
            $member_select = $_POST['member'];

            //check empty input (If empty, insert old data to db)     
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
            if ($_POST['member'] == null) {
                $member_select = $keytask['Responsibility'];
                $check--;
            }

            //update db 
            $postData = [
                'Description' => $discription,
                'StartDate' => $startdate,
                'EndDate' => $enddate,
                'Status' => $keytask['Status'],
                'Responsibility' => $member_select
            ];
            $ref = 'Project/' . $key . '/Task/' . $Taskname;
            $database->getReference($ref)->update($postData); //update data to db
            
            echo "<script>";
            if ($check == 0 && $startdate == $keytask['StartDate'] && $enddate == $keytask['EndDate']) {
                echo  "alert(\"data not change\");";
            } else {
                echo "alert(\"edit success\");";
            }
            echo "location.href='task_view.php?key=" . $key . "&filter=" . $_GET['filter'] . "'"; //edit task success, back to page task view
            echo "</script>";
        } //delete remove from db
        else if (isset($_POST['deletetask'])) {
            $database->getReference('Project/' . $key . '/Task/' . $Taskname)->remove();
            echo "<script>";
            echo "alert(\"delete success\");";
            echo "location.href='task_view.php?key=" . $key . "&filter=" . $_GET['filter'] . "'";
            echo "</script>";
        }


        ?>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>