<html>
    <head>
        <!-- เป็นไฟล์หน้าสำหรับล็อคอิน จะรับค่า Username กับ Password แล้วนำค่าที่ได้ไปเช็คในฐานข้อมูล -->
        <title>login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="CSS/login.css">
    </head>
    <body>
        <!-- login box and logo which can redirect to homepage -->
        <main class="text-center login_box form-signin">
            <!-- use text-center to align item to center of page -->
            <a href="./index.html"><img src="../Material/Logo/White.png" width="254" height="50"></a>
            <form name="loginfrm" method="post" autocomplete="off">
                <!-- use form-floating for floating label -->
                <div class="form-floating text-white">
                    <input class="form-control text-white started" id="username" name="Username" type="text" placeholder="Username" required>
                    <label for="username">Username</label>
                </div>
                <div class="form-floating text-white">
                    <input class="form-control ended" id="password" name="Password" type="password" placeholder="Password" required>
                    <label for="password">Password</label>
                </div>
                <div class="d-grid">
                    <button class="btn btn-color" type="submit">Login</button>
                </div>
            </form>
        </main>

        <?php
            session_start();
            if(isset($_POST['Username'])){
                include('dbconnect.php');
                $Username = $_POST['Username'];
                $Password = $_POST['Password'];
                try {
                    //ชี้ ref ไปที่ตำแหน่งคีย์ User และนำข้อมูลใน user ออกมาทั้งหมด
                    $ref = $database -> getReference('User/');
                    $snapshot = $ref -> getValue();
                    foreach($snapshot as $user => $data){ //วนรอบทีละผู้ใช้แยกออกเป็น $user คือไอดี(คีย์)ของผู้ใช้ และ $data ที่เก็บอาร์เรย์ข้อมูลของ user คนนั้นๆ
                        if($data['Username']==$Username){
                            if($data['Password'] == $Password){
                                //สร้างคีย์เก็บไอดีและ username ของผู้ใช้ เพื่อทำให้นำไป query ง่ายขึ้น
                                $_SESSION["UserID"] = $user;
                                $_SESSION["Username"] = $Username;
                                Header("Location: user_home.php");
                            }else{
                                throw new Exception("Wrong Password"); //กรณีที่เจอ user แต่ว่า password ไม่ตรงกันกับฐานข้อมูล
                            }
                        }
                    }
                    throw new Exception("Wrong Username"); //ถ้าวนทุก User แต่ไม่เจอ แสดงว่ากรอก username ผิด จึงสามารถ throw exception ให้แสดง error ได้
                }catch (Exception $e){
                    echo "<script>";
                    echo "alert(' ".$e->getMessage()." ');";
                    echo "window.history.back()";
                    echo "</script>";
                }
            }
        ?>
    </body>
</html>