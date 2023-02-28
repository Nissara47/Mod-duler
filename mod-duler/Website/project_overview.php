<html>
    <head>
        <title>Project | Mod-duler</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="./CSS/sidebar.css" rel="stylesheet">
        <!-- get project data from database -->
        <?php
            session_start();
            include('dbconnect.php');
            $ProjectID = $_GET['key'];
            $ref = $database -> getReference('Project/'.$ProjectID.'/');
            $check = $ref -> getChild('Task') -> getValue(); //สร้างตัวแปรเพื่อเช็คว่ามี task หรือไม่
            $data = $ref -> getValue();
        ?>
    </head>
    <body>
        <!-- navbar -->
        <?php include('Element/navbar.php') ?>

        <!-- main content -->
        <div class="main">
            <!-- sidebar -->
            <?php include('Element/sidebar.php') ?>

            <!-- description section -->
            <div class="content" style="padding: 20px;">
                <h1> 
                    <?php echo $data['ProjectName']; ?>
                </h1>
                <!-- Date -->
                <p style="padding-left: 10px; font-style:italic; margin-bottom:0;">
                    <?php
                        $start = strtotime($data['StartDate']);
                        $end = strtotime($data['EndDate']);
                        echo date('l, d/m/y', $start)." - ".date('l, d/m/y', $end);
                    ?>
                </p>
                <!-- Description -->
                <h2 style="font-size: 1.25rem; padding-left: 10px; display:inline;">
                    Description: 
                </h2>
                <p style="display:inline; font-size: 1.25rem;">
                    <?php echo $data['Description']; ?>
                </p>
                <br>
                <!-- Project Owner -->
                <h2 style="font-size: 1.25rem; padding-left: 10px; display:inline;">
                    Project Owner 
                </h2>
                <p style="display:inline; font-size: 1.25rem;">
                    <?php 
                        $ManagerName = $database -> getReference('User/'.$data['ProjectManager'].'/Name/') -> getValue();
                        echo $ManagerName; 
                    ?>
                </p><br><br>
                <?php if ($_SESSION['UserID'] == $data['ProjectManager']) { ?>
                    <a href="editproject.php?key=<?= $ProjectID ?>" class="btn btn-outline-primary"> Edit Project </a>
                    <a href="project_delete.php?key=<?= $ProjectID ?>" onclick="return confirm('Are you sure?')" class="btn btn-outline-danger"> Delete Project </a>
                <?php } ?>

                <!-- task Chart -->
                <?php 
                    if($check==true){ //ส่วนสำหรับนับ task ที่ทำเสร็จและไม่เสร็จโดยเก็บใส่ตัวแปร $done
                        $snapshot = $ref -> getChild('Task') -> getSnapshot();
                        $num = $snapshot -> numChildren();
                        $task = $snapshot -> getValue();
                        $done = 0;
                        foreach($task as $t){
                            if($t['Status']==true){
                                $done++;
                            }
                        }
                ?>
                    <div id="piechart">
                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
                            google.charts.load('current', {'packages':['corechart']});
                            google.charts.setOnLoadCallback(drawChart);

                            function drawChart() {
                                var data = google.visualization.arrayToDataTable([
                                            ['Status of Task', 'Tasks'],
                                            ['Not complete', <?php echo $num-$done; ?>],
                                            ['Complete', <?php echo $done; ?>],
                                            ]);
                                var options = {'title':'Tasks', 'width':550, 'height':400, 'colors':['#916bbf','#3d2c8d']};

                                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                                chart.draw(data, options);
                            }
                        </script>
                    </div>
                <?php } ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>