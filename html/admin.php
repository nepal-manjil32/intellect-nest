<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}

include 'db_connect.php';

$email = $_SESSION['email'];

$sql = "SELECT * FROM `users` WHERE `email` = '$email'";
$result = mysqli_query($conn, $sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $userData = mysqli_fetch_assoc($result);
    } else {
        echo "User data not found.";
        exit;
    }
} else {
    echo "Error fetching user data: " . mysqli_error($conn);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IntellectNest</title>
    <link rel="stylesheet" href="../css/admin.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Abel&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Abel&family=Aclonica&display=swap');
    </style>
</head>

<body>

    <!-- Nav Bar-->
    <header>
        <div class="nav-bar">
            <div id="logo">
                <a href="../html/admin.php"><img src="../images/logo.png" width="30%"></a>
            </div>
            <div id="right-nav">
                <a href="../html/index.html" id="log_out">Log Out</a>
            </div>
        </div>
    </header>
    <hr />

    <!-- Central Body -->
    <main>
        <div class="left-panel">
            <a href="./newpost.php" id="new-post">
                <div>
                    <img src="../images/add.png" width="20%">
                    <p>New Post</p>
                </div>
            </a>
            <div id="profile">
                <?php
                if (!$userData['file']) {
                    echo '<img src="../images/user.png" width="25%">';
                } 
                else
                {
                    echo '<img src="' . $userData['file'] . '" alt="Profile" style="width: 8rem; height: 8rem; border-radius: 50%;">';
                }
                ?>
                <p style="font-size:1.5rem; font-weight:600;"><?php echo $userData['name'] ?></p>
                <a href="profile.php" id="profile">Visit Profile</a>
            </div>
            <a href="blog.php" id="view-blog" target="_blank">
                <div>
                    <img src="../images/upload.png" width="25%">
                    <p onclick=blog_fcn() class="view_blog">View Blog</p>
                </div>
            </a>
        </div>

        <div class="right-panel">
            <a href="./business.php" target="_blank">
                <div class="business">
                    <img src="../images/business.png">
                    <h2>Business</h2>
                </div>
            </a>
            <a href="./politics.php" target="_blank">
                <div class="poltics">
                    <img src="../images/government.png">
                    <h2>Politics</h2>
                </div>
            </a>
            <a href="./tech.php" target="_blank">
                <div class="tech">
                    <img src="../images/tech.png">
                    <h2>Technology</h2>
                </div>
            </a>
            <a href="./space.php" target="_blank">
                <div class="space">
                    <img src="../images/astronaut.png">
                    <h2>Space</h2>
                </div>
            </a>
        </div>
    </main>
    <!-- Footer -->
    <footer>
        <div class="footer">
            <p style="font-family: Verdana, Geneva, Tahoma, sans-serif;">© IntellectNest 2024</p>
        </div>
    </footer>

    <script>
        function blog_fcn()
        {
            window.open("blog.php")
        }
    </script>     
</body>

</html>
