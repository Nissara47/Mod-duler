<!-- This file have 2 part for member action which are invite and delete member -->

<?php
session_start();
include('dbconnect.php');
$ProjectKey = $_GET['key'];

if (isset($_POST['invite'])) {
    $inviteUsername = $_POST['Username'];
    $checkUser = 0;
    $checkMember = 0;

    // query part
    $userref = $database -> getReference('User');
    $Userdata =$userref -> getValue();
    $memberref = $database -> getReference('Project/'.$ProjectKey) ->getChild("Member");
    $hasMember = $memberref -> getValue();

    if ($inviteUsername == $_SESSION['Username']) {// Check if invite yourself
        echo "<script>";
        echo "alert(\"You can't invite yourself!!!\");";
        echo "window.history.back();";
        echo "</script>";
    } else {
        foreach ($Userdata as $user) { // check username in database
            if ($inviteUsername == $user['Username']) {
                $checkUser = 1;
                $name = $user['Name'];
                $email = $user['Email'];
            }
        }
        if ($checkUser == 0) {
            echo "<script>";
            echo "alert(\"Can't find this Username.\");";
            echo "window.history.back();";
            echo "</script>";
        } else {
            if ($hasMember != false) {
                // query member part if has member
                $Member = $memberref->getChildKeys();
                $MemberInfo = $memberref->getValue();
                foreach ($Member as $member) { // check username in member
                    if ($inviteUsername == $member) {
                        $checkMember = 1;
                    }
                }
                if ($checkMember == 1) {
                    echo "<script>";
                    echo "alert(\"You had have this member already.\");";
                    echo "window.history.back();";
                    echo "</script>";
                } else {
                    $postdata = [
                        $inviteUsername => [
                            'Name' => $name,
                            'Email' => $email
                        ]
                    ];
                    $memberref->update($postdata); //add new member to database
                    echo "<script>";
                    echo "alert(\"Invite success!!\");";
                    echo "window.history.back();";
                    echo "</script>";
                }
            } else {
                $postdata = [
                    $inviteUsername => [
                        'Name' => $name,
                        'Email' => $email
                    ]
                ];
                $memberref->update($postdata); //add new member to database
                echo "<script>";
                echo "alert(\"Invite success!!\");";
                echo "window.history.back();";
                echo "</script>";
            }
        }
    }
}
if (isset($_POST['delete'])){
    $DeleteUsername = $_POST['delete'];

    //delete member from database
    $database -> getReference('Project/'.$ProjectKey) ->getChild("Member") 
    -> getChild($DeleteUsername) -> remove();

    echo "<script>";
    echo "alert(\"delete success\");";
    echo "window.history.back()"; //alert and back to memberpage
    echo "</script>";
}
