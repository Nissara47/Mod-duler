<?php

session_start();
include('dbconnect.php');
$ProjectKey = $_GET['key'];

//delete project from database
$database -> getReference('Project/'.$ProjectKey) -> remove();

echo "<script>";
echo "alert(\"delete success\");";
echo "location.href='user_home.php'"; //alert and back to homepage
echo "</script>";
?>