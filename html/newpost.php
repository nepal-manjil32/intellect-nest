<?php
include 'db_connect.php';
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $userData = array('username' => $username);
    $useremail = $_SESSION['email'];
    $userData = array('useremail' => $useremail);
} else {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IntellectNest</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="../css/newpost.css">
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
                <a href="../html/admin.php"><img src="../images/logo.png" width="100%"></a>
            </div>
            <div id="right-nav">
                <a href="./index.html">Log Out</a>
            </div>
        </div>
    </header>
    <hr />

    <!-- Central Body -->
    <main>
        <div id="main-title">
            <label for="title" id="title-text">Title: </label>
            <input type="text" id="title" name="title">
        </div>
        <div id="main-title">
            <textarea id="paragraph" name="paragraph" rows="30" cols="100"></textarea>
        </div>
        <div>
            <label for="image">Image URL: </label>
            <input type="text" id="image" name="image">
        </div>
        <div>
            <select name="category">
                <option disabled selected>Category</option>
                <option value="Business">Business</option>
                <option value="Politics">Politics</option>
                <option value="Tech">Tech</option>
                <option value="Space">Space</option>
            </select>
        </div>
        <div id="publish">
            <!-- <button><img src="./images/">Publish</button> -->
            <button onclick="publishPost('<?php echo $username ?>','<?php echo $useremail ?>')">Publish</button>
        </div>
        <div role="alert" id="success_alert">
            <div>
                Successfully Posted
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer">
            <p style="font-family: Verdana, Geneva, Tahoma, sans-serif;">© IntellectNest 2024</p>
        </div>
    </footer>
    <script src="newpost.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        function showSuccessMessage() {
            var successDiv = document.querySelector("#success_alert");
            successDiv.style.display = "block";
        }
    </script>
</body>

</html>