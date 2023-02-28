<?php
    $currentPage = basename($_SERVER["SCRIPT_FILENAME"], '.php'); //เก็บชื่อไฟล์ไว้ในตัวแปรสำหรับเช็คและเปลี่ยนค่ารูปใน sidebar
?>

<script>
    function sidebar_change(){
        var filename = "<?php echo $currentPage; ?>";
        if(filename == "project_overview"){
            document.getElementById("overview").classList.add("active");
            document.getElementById("overview_img").src = "../Material/Pictures/overview.png";
        }else if(filename == "task_view"){
            document.getElementById("task").classList.add("active");
            document.getElementById("task_img").src = "../Material/Pictures/task.png";
        }else if(filename == "member"){
            document.getElementById("member_page").classList.add("active");
            document.getElementById("member_img").src = "../Material/Pictures/member.png";
        }else{
            document.getElementById("gantt").classList.add("active");
            document.getElementById("gantt_img").src = "../Material/Pictures/gantt-chart.png";
        }
    }
</script>

<div class="bg-light flex-shrink-0 sidebar">
    <ul style="list-style: none; margin-top:0px;" class="flex-column nav mb-auto" >
        <li>
            <a id="overview" class="py-3 border-bottom nav-link" title="Overview" href="project_overview.php?key=<?php echo $_GET['key']; ?>">
                <img id="overview_img" src="../Material/Pictures/overview_c.png" style="width: 24px; height:24px;">&nbsp;&nbsp;Overview
            </a>
        </li>
        <li>
            <a id="task" class="nav-link py-3 border-bottom" title="Task" href="task_view.php?key=<?php echo $_GET['key']; ?>">
                <img id="task_img" src="../Material/Pictures/task_c.png" style="width: 24px; height:24px;">&nbsp;&nbsp;Task
            </a>
        </li>
        <li>
            <a id="member_page" class="nav-link py-3 border-bottom" title="Member" href="member.php?key=<?php echo $_GET['key']; ?>">
                <img id="member_img" src="../Material/Pictures/member_c.png" style="width: 24px; height:24px;">&nbsp;&nbsp;Member
            </a>
        </li>
        <li>
            <a id="gantt" class="nav-link py-3" title="Gantt Chart" href="ganttchart.php?key=<?php echo $_GET['key']; ?>">
                <img id="gantt_img" src="../Material/Pictures/gantt-chart_c.png" style="width: 24px; height:24px;">&nbsp;&nbsp;Gantt
            </a>
        </li>
    </ul>
</div>

<script>
    sidebar_change();
</script>