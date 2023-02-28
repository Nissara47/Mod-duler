<!-- ส่วน navbar แบ่งออกเป็นฝั่งโลโก้ด้านขวาสุดกับฝั่งซ้ายสุดที่จะมีตัวอักษรสำหรับไปหน้า Home และ dropdown เป็นชื่อ Username สำหรับ edit profile, logout -->
<header class="p-3 text-white top">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="user_home.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none nav-auto">
                <img src="../Material/Logo/White.png" width="152.4" height="30">
            </a>
            <ul class="nav col-12 col-lg-auto me-lg-auto justify-content-center mb-md-0"></ul>
            <div class="text-end">
                <a href="user_home.php" class="text-decoration-none text-white">Home</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                <div class="dropdown" style="display: inline;">
                    <a href="#" class="link-dark text-decoration-none text-white dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php 
                            echo $_SESSION['Username'];
                        ?>
                    </a>
                    <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="edit_proflie.php">Edit Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Log out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>