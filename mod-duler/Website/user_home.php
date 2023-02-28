<?php 
    session_start();
    include('dbconnect.php');
?>

<html>

<head>
    <title>Mod-duler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="./CSS/sidebar.css" rel="stylesheet">
    <style>
        .create_botton{
            background: transparent;
            border-radius: 20px; 
            padding-left: 8px; 
            padding-right: 8px; 
            border-color: #1c0c5b; 
            border-style: solid;
        }
        .card{
            border-color: transparent;
        }
        h2{
            display: inline;
        }
    </style>
</head>

<body>
    <?php include('Element/navbar.php') ?>
    <!-- ส่วนหน้าหลัก แบ่งออกเป็น project ที่ผู้ใช้เป็นเจ้าของ ซึ่งจะมีปุ่มสร้างโปรเจคให้ในส่วนนี้ด้วย และที่ผู้ใช้เป็นสมาชิก -->
    <div class="container list">
        <div class="row"> 
            <div class="col-sm">
                <div class="card">
                    <div class="card-body">
                        <div class="border-bottom pb-2">
                            <h2>Your projects</h2>
                            &nbsp;&nbsp;<button onclick="window.location.href='createproject.php'" class="create_botton">+&nbsp;Create Project</button>
                        </div>
                        <?php
                            $hasProject = $database->getReference('Project/')->getSnapshot()->numChildren();
                            if ($hasProject > 0) {
                                $UserID = $_SESSION["UserID"];
                                $projectkey = $database->getReference('Project/')->getValue();
                                foreach ($projectkey as $key => $row) {
                                    if ($row['ProjectManager'] == $UserID) { //แสดงผลชื่อโปรเจคและข้อมูลในกรณีที่ projectmanager ตรงกับไอดีของผู้ใช้ปัจจุบัน
                                        echo "<div class='card'><div class='card-body'>";
                                        echo "<h5 class='card-title'><a href='project_overview.php?key=" . $key . "'>" . $row['ProjectName'] . "</a></h5>";
                                        echo "<p class ='card-text'>" . $row['Description'] . "</p>";
                                        echo "<p class ='card-text'><small class='text-muted'> End Date : " . $row['EndDate'] . "</small></p>";
                                        echo " </div></div>";
                                    }
                                }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card">
                    <div class="card-body">
                        <div class="border-bottom pb-2">
                            <h2>Other projects</h2>
                        </div>
                        <?php
                            $Username = $_SESSION["Username"];
                            $projectkey = $database->getReference('Project/')->getValue();
                            foreach ($projectkey as $key => $row) {
                                try { //ดักกรณีที่ไม่มีสมาชิกในโปรเจคนั้นๆเลย (มีแค่เจ้าของโปรเจคซึ่งอยู่ในส่วน ProjectManager)
                                    $projectref = $database->getReference('Project/' . $key)->getChild("Member");
                                    $Member = $projectref->getChildKeys();
                                    foreach ($Member as $member)
                                        if (strcmp($Username, $member) == 0) {
                                            echo "<div class='card'><div class='card-body'>";
                                            echo "<h5 class='card-title'><a href='project_overview.php?key=" . $key . "'>" . $row['ProjectName'] . "</a></h5>";
                                            echo "<p class ='card-text'>" . $row['Description'] . "</p>";
                                            echo "<p class ='card-text'><small class='text-muted'> End Date : " . $row['EndDate'] . "</small></p>";
                                            echo " </div></div>";
                                        }
                                } catch (OutOfRangeException $e) {}
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ส่วนล่างสุดของหน้า มีปุ่มเพื่อให้กดแล้วขึ้นไปด้านบน -->
    <div class="container">
        <footer class="py-3 my-4">
            <p class="text-center p-3 border-top"><a href="#" class="text-muted">Back to Top</a></p>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>