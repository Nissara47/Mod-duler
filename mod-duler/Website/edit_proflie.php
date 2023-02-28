<html>
<head>
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="./CSS/sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/createproject.css">
</head>
<body>
    <!-- navbar -->
    <?php 
    session_start();
    include('./Element/navbar.php'); 
    ?>

    <!-- main content -->
    <form method="post"> 
    <h3>EDIT PROFILE</h3>  
    <!-- create input, button -->  
    <label>New Name</label><input id="name" name="name" type="text"><br>
    New Email<br><input id="email" name="email" type="text"><br>
    New Password<br><input type="text" id="npass" name="npass"><br>
    Old Password<br>(for confirm change password)<br><input type="text" id="olpass" name="olpass"><br>

    <button type="submit" name="edit">EDIT</button>
    <button onclick="location.href='user_home.php?key=<?= $_SESSION['UserID'] ?>'" class ="end_button" type="button" name="cancle">CANCEL</button>

    <?php
    //query part
    include('dbconnect.php');
    $Username = $_SESSION["UserID"] ;  
    $key = $database -> getReference('User/'.$Username) -> getValue();
    $check = 4;
    //edit profile part
    if(isset($_POST['edit'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $npass = $_POST['npass']; 
        $olpass = $_POST['olpass'];
            //check empty input (If empty, insert old data to db)   
            if(empty($_POST['name'])){
                $name = $key['Name'];
                $check--;
            }
            if(empty($_POST['email'])){
                $email = $key['Email'];
                $check--;
            }
            if(empty($_POST['npass']) || empty($_POST['olpass'])){
                $npass = $key['Password'];
                $check--;
            }
            else if($olpass != $key['Password']){ //check ว่า password ที่กรอกตรงกับ password เดิมหรือไม่เพื่อยืนยันตัวตน
                echo "<script>";
                echo "alert(\"password not match, plese try again\");";
                echo "</script>";
                $npass = $key['Password'];
                $name = $key['Name'];
                $email = $key['Email'];
            }
            else if(empty($_POST['olpass']) && empty($_POST['npass'])){
                $npass = $key['Password'];
                $check--;
            }
            //update db 
            $postData = [
                $Username => [
                      'Name' => $name,
                      'Email' => $email,
                      'Password' => $npass,
                      'Username' => $key['Username']
                 ]    
            ];
            $ref = 'User/';
            $database -> getReference($ref) -> update($postData); //update data to db
            echo "<script>";
            if($check == 0){
                echo "alert(\"edit success\");";
            }else{
                echo "alert(\"data not change\");";
            }
            echo 'window.location.href="user_home.php"';
            echo "</script>";
        }
    ?>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>

