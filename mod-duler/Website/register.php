<html>

<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/login.css">
</head>

<body>
    <!-- resgister box and logo which can redirect to homepage -->
    <main class="text-center login_box form-signin"> 
        <!-- use text-center to align item to center of page -->
        <a href="./index.html"><img src="../Material/Logo/White.png" width="254" height="50"></a>
        <form autocomplete="off" name="Regis" method="post" action="Register.php">
            <!-- use form-floating for floating label -->
            <div class="form-floating started text-white">
                <input required class="form-control started" id="username" name="Username" type="text" placeholder="Username">
                <label for="username">Username</label>
            </div>
            <div class="form-floating text-white">
                <input required class="form-control middle" id="password" name="Password" type="password" placeholder="Password">
                <label for="password">Password</label>
            </div>
            <div class="form-floating text-white">
                <input required class="form-control middle" id="name" name="Name" type="text" placeholder="Name">
                <label for="name">Name</label>
            </div>
            <div class="form-floating ended text-white">
                <input required class="form-control ended" id="email" name="Email" type="email" placeholder="Email">
                <label for="email">Email</label>
            </div>
            <div class="d-grid">
                <button class="btn btn-color" type="submit" name="save_push">Register</button>
            </div>
        </form>
</body>
</html>

<?php
include('dbconnect.php');
if (isset($_POST['save_push'])) {
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];
    $Name = $_POST['Name'];
    $Email = $_POST['Email'];
    $check =0;

    $refuse = "User/";
    $fetchdata = $database->getReference($refuse)->getValue();
    foreach($fetchdata as $key => $row){
        if ($row['Username'] == $Username ){ //check that Is this username available to use?
            echo "<script>";
            echo "alert(\"This Username is not available.\");";
            echo "window.history.back()";
            echo "</script>";
            $check = 1; 
        }
        if($row['Email'] == $Email){ //check that Is this email available to use?
            echo "<script>";
            echo "alert(\"This Email is not available.\");";
            echo "window.history.back()";
            echo "</script>";
            $check = 1;
        }
    }
    if($check != 1){ // if username and email are available then add data to database
    $data = [
        'Username' => $Username,
        'Password' => $Password,
        'Name' => $Name,
        'Email' => $Email,];
        $ref = "User/";
        $postdata = $database->getReference($ref)->push($data);}
    if($postdata){ //if adding data is success.
        echo "<script>";
        echo "alert(\"Register success!\");";
        echo 'window.location.href="login.php"';
        echo "</script>";
    }
} 
?>