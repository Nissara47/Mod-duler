<?php
    session_start();
    include('dbconnect.php');
    $ref = $database->getReference('Project/' . $_GET['key'] . '/');
    $data = $ref->getValue();
    $start = $data['StartDate'];
    $end = $data['EndDate'];
    $ProjectID = $_GET['key'];

?>

<html>
<head>
    <title>create task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="./CSS/sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/createproject.css">
    <script src="checkdate.js"></script>
</head>

<body>
    <!-- navbar -->
    <?php include('Element/navbar.php') ?>

    <!-- create task -->
    
    <form id='createtask' autocomplete="off" method="post" >
        <h3>CREATE TASK</h3>
        Taskname<input id="taskname" name="taskname" type="text" required><br>
        Description<input id="discription" name="discription" type="text" required><br>
        Start Date<input type="date" id="startdate" name="startdate" <?php echo 'min=' . $start . ' max=' . $end; ?> required><br>
        End Date<input type="date" id="enddate" name="enddate" <?php echo 'min=' . $start . ' max=' . $end; ?> required><br>

        Responsibility of <select name="member" class="form-select" id="member" required>
            <option value="">-- select member --</option>
            <?php 
            include('function-for-member.php');
            querymem($ProjectID);
            ?>
        </select><br>
        
        <input style="display:none;" id="submit_bt" type='submit'>
        <button type="button" onclick="checkdate()" id="create" name="create">CREATE</button>
        <button onclick="location.href='task_view.php?key=<?= $ProjectID ?>'" class ="end_button" type="button" name="cancle">CANCEL</button>
        
    </form>

    <?php 
    $check = 0;
    if(isset($_POST['taskname'])){
        $task = $database -> getReference('Project/'.$ProjectID.'/Task') -> getValue();
        foreach($task as $key => $data){
            if($data['TaskName'] == $_POST['taskname']){
                echo "<script>";
                echo 'alert("The task name is not available\nPlease use another name");';
                echo 'window.history.back()';
                echo "</script>";
                $check = 1;
            }
        }
    }
    if(isset($_POST['discription'])){
        $taskname = $_POST['taskname'];
        $discription = $_POST['discription'];
        $startdate = $_POST['startdate']; 
        $enddate = $_POST['enddate'];
        $member_select = $_POST['member'];

        if($check != 1){
            $postData = [
                'TaskName' => $taskname,                       
                'Description' => $discription,
                'StartDate' => $startdate,
                'EndDate' => $enddate,
                'Status' => false,
                'Responsibility' => $member_select  
            ];
            $database -> getReference('Project/'.$ProjectID.'/Task') -> push($postData);
            echo "<script>";
            echo 'alert("Task Create Successfully");';
            echo 'window.location.href = "task_view.php?key='.$ProjectID.'"';
            echo "</script>";
        }
    } ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>