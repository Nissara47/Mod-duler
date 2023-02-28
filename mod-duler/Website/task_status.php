<?php

session_start();
include('dbconnect.php');
$ProjectKey = $_GET['key'];
$TaskKey = $_GET['task'];

// query part
$TaskRef = $database -> getReference('Project/'.$ProjectKey) ->getChild("Task") ->getChild($TaskKey);
$TaskInfo = $TaskRef->getValue();

// change value
if ($TaskInfo['Status'] == True) {
    $postdata = ['Status' => false];
    $TaskRef -> update($postdata);
} else {
    $postdata = ['Status' => true];
    $TaskRef -> update($postdata);
}

echo "<script>";
echo "location.href='task_view.php?key=". $ProjectKey ."&filter=" . $_GET['filter'] . "'";
echo "</script>";

?>