<?php
session_start();
$login = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"]) && isset($_POST["password"])) {
    include 'db_connect.php';
    $email = $_POST["email"];
    $password = $_POST["password"];

    // $sql = "Select * from users where username='$username' AND password='$password'";
    $sql = "SELECT * FROM `users` WHERE `email` = '$email'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            // $row = mysqli_fetch_assoc($result);
            if ($password == $row['password']) {
                $login = true;
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $email;
                $username = $row['name'];
                $_SESSION['username'] = $username;
                header("location: admin.php");
                exit();
            } else {
                $showError = "Invalid Credentials";
            }
        }

    } else {
        $showError = "Invalid Credentials. Username OR Password is incorrect OR you are not Registerd";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/login.css">
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
                <a href="../html/index.html"><img src="../images/logo.png" width="100%"></a>
            </div>
            <div id="mid-nav">
                <ul id="central-side">
                    <li><a href="#">Features</a></li>
                    <li><a href="#">Pricing</a></li>
                </ul>
            </div>
            <div id="mid-nav">
                <ul id="left-side">
                    <li><a href="../html/create-account.php">Get Started</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Central Body -->
    <main style="display: flex; flex-direction: column;">
        <div class="alert_div" style="margin-bottom: 2rem; height:5vh">
            <?php
            if ($login) {
                echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your account is now created and you can login
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div> ';
            }
            if ($showError) {
                echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> ' . $showError . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div> ';
            }
            ?>
        </div>
        <form action="login.php" method="post">
            <div>
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>
            <div class="link forget-pass text-left"><a href="forgot-password.php" style="text-decoration: none;">Forgot
                    password?</a></div>
            <!-- Register buttons -->
            <div class="text-center">
                <p>Not a member? <a href="create-account.php">Register</a></p>
            </div>
            <button type="submit">Login</button>
        </form>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer">
            <p style="font-family: Verdana, Geneva, Tahoma, sans-serif;">© IntellectNest 2024</p>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
</body>

</html>