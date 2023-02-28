<?php 

    session_start();

    function querymem($key){
        include('dbconnect.php');
        $ref = $database -> getReference('Project/'.$key.'/');
        $manager = $database -> getReference('User/'.$_SESSION['UserID'].'/Name/') -> getValue();
        echo "<option value='$manager'>$manager</option>";
        $member = array();
        try{
            $fetch = $ref -> getChild('Member') -> getValue();
            foreach($fetch as $user){
                $member[] = $user['Name'];
            }
            foreach ($member as $mem_select) {
                echo "<option value='$mem_select'>$mem_select</option>";
            }
        }catch(OutOfRangeException $e){}     
    }

?>