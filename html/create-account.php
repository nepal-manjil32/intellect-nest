<?php
$showAlert = false;
$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'db_connect.php';
    $username = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    $existSql = "SELECT * FROM `users` WHERE `name` = '$username' OR `email` = '$email'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);
    if($numExistRows > 0){
        $showError = "Username or Email Already Exists";
    }
    else{
        if(($password == $cpassword)){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `blog_db`.`users` (`name`, `email`, `password`, `cpassword`,`dt`) VALUES ('$username', '$email', '$password', '$cpassword', current_timestamp())";
            $res = mysqli_query($conn, $sql);
            if ($res){
                $showAlert = true;
            }
        }
        else{
            $showError = "Passwords do not match";
        }
    }
}
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Started</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/create-account.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Abel&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Abel&family=Aclonica&display=swap');
    </style>
</head>

<body>
    <!-- Nav Bar -->
    <header>
        <div class="nav-bar">
            <div id="logo">
                <a href="../html/index.html"><img src="../images/logo.png" width="100%"></a>
            </div>
            <div id="mid-nav">
                <ul id="central-side">
                    <li><a href="#">Features</a></li>
                    <li><a href="../html/index.html#middle-body">Pricing</a></li>
                </ul>
            </div>
            <div id="mid-nav">
                <ul id="left-side">
                    <li><a href="../html/login.php">Login</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Central Body -->
    <main style="display: flex; flex-direction: column; margin-bottom: 5rem;">
        <div class="alert_div" style="margin-bottom: 2rem; height:5vh">
            <?php
            if ($showAlert) {
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
        <form action="create-account.php" method="post" onsubmit="return validateForm()">
            <div>
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" required>
                <div id="nameError" class="error-message"></div>
            </div>
            <div>
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" required>
                <div id="emailError" class="error-message"></div>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
                <div id="passwordError" class="error-message"></div>
            </div>
            <div>
                <label for="cpassword">Confirm Password</label>
                <input type="password" name="cpassword" id="cpassword" required>
                <div id="cpasswordError" class="error-message"></div>
            </div>
            <button type="submit">Register</button>
        </form>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer">
            <p style="font-family: Verdana, Geneva, Tahoma, sans-serif;">© IntellectNest 2024</p>
        </div>
    </footer>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
    <script>
        function validateForm() {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const cpassword = document.getElementById('cpassword').value;

            const namePattern = /^[A-Za-z\s]+$/;
            const emailPattern = /\S+@\S+\.\S+/;
            const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+])(?=.*[^\da-zA-Z]).{8,}$/;

            let isValid = true;

            document.getElementById('nameError').innerText = '';
            document.getElementById('emailError').innerText = '';
            document.getElementById('passwordError').innerText = '';
            document.getElementById('cpasswordError').innerText = '';

            if (!name.match(namePattern)) {
                document.getElementById('nameError').innerHTML = '<p style="font-size:0.8rem;">Name should contain only alphabets</p>';
                isValid = false;
            }

            if (!email.match(emailPattern)) {
                document.getElementById('emailError').innerHTML = '<p style="font-size:0.8rem;">Enter a valid email address.</p>';
                isValid = false;
            }

            if (!password.match(passwordPattern)) {
                document.getElementById('passwordError').innerHTML = '<p style="font-size:0.8rem;">Password should have at least 8 characters <br>one uppercase letter, one digit and <br>one special character.</p>';
                isValid = false;
            }

            if (password !== cpassword) {
                document.getElementById('cpasswordError').innerHTML = '<p style="font-size:0.8rem; color:black;">Passwords do not match.</p>';
                isValid = false;
            }

            return isValid;
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>
