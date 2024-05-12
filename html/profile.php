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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $newUsername = $_POST["username"];
  $newEmail = $_POST["email"];
  $newPhone = $_POST["phone"];

  if (!empty($_FILES["file_upload"]["name"])) {
    $filename = $_FILES["file_upload"]["name"];
    $tempname = $_FILES["file_upload"]["tmp_name"];
    $folder = "image/" . $filename;

    move_uploaded_file($tempname, $folder);
    $updateSql = "UPDATE `users` SET `file` = '$folder', `name` = '$newUsername', `email` = '$newEmail', `phone` = '$newPhone' WHERE `email` = '$email'";
  } else {
    $updateSql = "UPDATE `users` SET `name` = '$newUsername', `email` = '$newEmail', `phone` = '$newPhone' WHERE `email` = '$email'";
  }

  if (mysqli_query($conn, $updateSql)) {
    if ($newEmail != $email) {
      $_SESSION['email'] = $newEmail;
    }
    header("location: profile.php");
    exit;
  } else {
    echo "Error updating user information: " . mysqli_error($conn);
    exit;
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../css/profile.css">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
  <!-- MDB -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css" rel="stylesheet" />
</head>

<body>
  <section class="vh-100" style="background-color: #FEFAF6;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-lg-9 mb-8 mb-lg-0">
          <div class="card mb-3" style="border-radius: .5rem;">
            <div class="row g-0">
              <div class="col-md-4 gradient-custom text-center text-white"
                style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                <?php
                if (!$userData['file']) {
                  echo '<img src="../images/user.png" alt="Profile"  style="width: 6rem; height: 6rem; border-radius: 50%; margin-top:0.8rem;">';
                } else {

                  echo '<img src="' . $userData['file'] . '" alt="Profile" style="width: 8rem; height: 8rem; border-radius: 50%; margin-top:0.8rem;">';
                }
                ?>
                <!-- <img src="<?php echo $userData['file']; ?>" alt="Profile" class="img-fluid my-5" style="width: 15rem; height:15rem; border-radius: 50%;" /> -->

                <h4><?php echo $userData['name']; ?></h4>
                <!-- <p><?php echo $userData['role']; ?></p> -->
                <i class="far fa-edit mb-5" id="editIcon" style="cursor: pointer;"></i>
              </div>
              <div class="col-md-8"
                style="align-items: center;display: flex; justify-content: center; flex: 0 0 auto; width: 66.66666667%;">
                <div class="card-body p-4">
                  <h4>Information</h4>
                  <!-- Form for editing user information -->
                  <form method="post" id="editForm" style="display: none;" enctype="multipart/form-data">
                    <div class="mb-3">
                      <label for="file_upload">Upload Profile Image:
                        <input type="file" name="file_upload" class="file_upload"></label>
                    </div>
                    <div class="mb-3">
                      <label for="username" class="form-label">Username</label>
                      <input type="text" class="form-control" id="username" name="username"
                        value="<?php echo $userData['name']; ?>">
                    </div>
                    <div class="mb-3">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" class="form-control" id="email" name="email"
                        value="<?php echo $userData['email']; ?>">
                    </div>
                    <div class="mb-3">
                      <label for="phone" class="form-label">Phone</label>
                      <input type="text" class="form-control" id="phone" name="phone"
                        value="<?php echo $userData['phone']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                  </form>
                  <!-- End of form -->
                  <hr class="mt-0 mb-4">
                  <div class="row pt-1">
                    <div class="col-6 mb-3">
                      <h4>Email</h4>
                      <p><?php echo $userData['email']; ?></p>
                    </div>
                    <div class="col-6 mb-3">
                      <h4>Phone</h4>
                      <?php
                      if (!$userData['phone']) {
                        echo 'Add Mobile Number';
                      } else {
                        echo '<p>' . $userData['phone'] . '</p>';
                      }
                      ?>
                    </div>
                  </div>
                  <!-- <h6>Blogs</h6>
                  <hr class="mt-0 mb-4">
                  <div class="row pt-1">
                    <div class="col-6 mb-3">
                      <h6>Recent</h6>
                      <p class="text-muted">Lorem ipsum</p>
                    </div>
                  </div> -->
                  <div class="d-flex justify-content-start">
                    <a href="#!"><i class="fab fa-facebook-f fa-lg me-3"></i></a>
                    <a href="#!"><i class="fab fa-twitter fa-lg me-3"></i></a>
                    <a href="#!"><i class="fab fa-instagram fa-lg"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- MDB -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.umd.min.js"></script>
  <script>
    // Add event listener to edit icon
    document.getElementById("editIcon").addEventListener("click", function () {
      // Toggle display of edit form
      document.getElementById("editForm").style.display = "block";
    });
  </script>
</body>

</html>