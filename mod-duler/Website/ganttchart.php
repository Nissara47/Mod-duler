<?php
session_start();
include('dbconnect.php');

//Query part 
$ProjectID = $_GET['key'];
$ref = $database->getReference('Project/' . $ProjectID);
$snapshot = $ref->getSnapShot();
$task = $ref->getChild("Task")->getValue();

if ($task == false) { //if there is no task go back to previous window
  echo "<script>";
  echo "alert(\"There is no task.\");";
  echo "window.history.back()";
  echo "</script>";
}
?>

<html>

<head>
  <title>gantt</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href="./CSS/sidebar.css" rel="stylesheet">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">  

    google.charts.load('current', {
      'packages': ['gantt']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Task ID');
      data.addColumn('string', 'Task Name');
      data.addColumn('string', 'Resource');
      data.addColumn('date', 'Start Date');
      data.addColumn('date', 'End Date');
      data.addColumn('number', 'Duration');
      data.addColumn('number', 'Percent Complete');
      data.addColumn('string', 'Dependencies');

      data.addRows([
        <?php
        foreach ($task as $printtask) { 
          //convert Date to Y,m-1,d format (google API started date at 0)
          $end = DateTime::createFromFormat('Y-m-d', $printtask['EndDate'])->format('Y,m-1,d'); 
          $start = DateTime::createFromFormat('Y-m-d', $printtask['StartDate'])->format('Y,m-1,d');
          //convert task's status from string to int
          if ($printtask['Status'] == 'complete')
          $status = 100;
          else $status = 0;

          //order type of data by google API column format
          echo "['" . $printtask['TaskName'] . "','" . $printtask['TaskName'] . "','" 
          . $printtask['Responsibility'] . "',new Date(". $start . "), new Date(" . $end . ")," 
          . 'null'. "," . $status . "," . 'null' . "],";
        }
        ?>
      ]);

      var options = {
        height: height = data.getNumberOfRows() * 41 + 30, //gantt chart's height depends on amount of rows
        gantt: {
          criticalPathEnabled: false,
          trackHeight: 30
        }
      };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));
      chart.draw(data, options);

      window.addEventListener('resize', function() { //if the size of window changed then redraw gantt chart.
          chart.draw(data, options);
      }, false);
    }
  </script>
</head>

<body>
  <?php include('Element/navbar.php') ?>
  <div class="main">
    <?php include('Element/sidebar.php') ?>
    <div id="chart_div" class="content" style="padding: 20px;"></div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>