<?php
session_start();
$showAlert = false;
$showError = 0;
// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
//     header("location: login.php");
//     exit;
// }

include 'db_connect.php';

// $email = $_SESSION['email'];

// $sql = "SELECT * FROM `users` WHERE `email` = '$email'";
// $result = mysqli_query($conn, $sql);

// if ($result) {
//     if (mysqli_num_rows($result) > 0) {
//         $userData = mysqli_fetch_assoc($result);
//     } else {
//         echo "User data not found.";
//         exit;
//     }
// } else {
//     echo "Error fetching user data: " . mysqli_error($conn);
//     exit;
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $card_num = $_POST["card_number"];
    $expire = $_POST["expire"];
    $cvv = $_POST["cvv"];

    $existSql = "SELECT * FROM `card` WHERE `c_name` = '$name'";
    $res = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($res);
    if ($numExistRows > 0) {
        $showError = "Already a Member of Premium";
    } else {
        $sql = "INSERT INTO `blog_db`.`card` (`c_name`, `c_email`,`c_num`, `c_expire`, `c_cvv`, `dt`) VALUES ('$name', '$email', '$card_num', '$expire', '$cvv', current_timestamp())";
        $res = mysqli_query($conn, $sql);
        if($res)
        {
            $showAlert = true;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="../css/checkout.css">
</head>

<body>
    <section class="h-100 h-custom" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card">
                        <div class="card-body p-4">

                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="alert_div" style="margin-top: 15rem; height:5vh">
                                        <?php
                                        if ($showAlert) {
                                            echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                        <strong>Success!</strong>You have successfully made a payment
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

                                </div>
                                <div class="col-lg-5">
                                    <div class="card bg-primary text-white rounded-3">
                                        <div class="card-body">
                                            <!-- <div class="d-flex justify-content-between align-items-center mb-4">
                                                <h5 class="mb-0">Card details</h5>
                                                <img src="<?php echo $userData['file']; ?>" class="img-fluid rounded-3"
                                                    style="width: 45px;" alt="Avatar">
                                            </div> -->

                                            <p class="small mb-2">Card type</p>
                                            <a href="#!" type="submit" class="text-white"><i
                                                    class="fab fa-cc-mastercard fa-2x me-2"></i></a>
                                            <a href="#!" type="submit" class="text-white"><i
                                                    class="fab fa-cc-visa fa-2x me-2"></i></a>
                                            <a href="#!" type="submit" class="text-white"><i
                                                    class="fab fa-cc-amex fa-2x me-2"></i></a>
                                            <a href="#!" type="submit" class="text-white"><i
                                                    class="fab fa-cc-paypal fa-2x"></i></a>

                                            <form class="mt-4" method="post">
                                                <div data-mdb-input-init class="form-outline form-white mb-4">
                                                    <input type="text" id="typeName"
                                                        class="form-control form-control-lg" siez="17"
                                                        placeholder="Cardholder's Name" name="name" />
                                                    <label class="form-label" for="typeName">Cardholder's Name</label>
                                                </div>

                                                <div data-mdb-input-init class="form-outline form-white mb-4">
                                                    <input type="email" id="typeEmail"
                                                        class="form-control form-control-lg" siez="17"
                                                        placeholder="Email" name="email" />
                                                    <label class="form-label" for="typeEmail">Email</label>
                                                </div>

                                                <div data-mdb-input-init class="form-outline form-white mb-4">
                                                    <input type="text" id="typeText"
                                                        class="form-control form-control-lg" siez="17"
                                                        placeholder="1234 5678 9012 3457" minlength="19" maxlength="19"
                                                        name="card_number" />
                                                    <label class="form-label" for="typeText">Card Number</label>
                                                </div>

                                                <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        <div data-mdb-input-init class="form-outline form-white">
                                                            <input type="text" id="typeExp"
                                                                class="form-control form-control-lg"
                                                                placeholder="MM/YYYY" size="7" id="exp" minlength="7"
                                                                maxlength="7" name="expire" />
                                                            <label class="form-label" for="typeExp">Expiration</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div data-mdb-input-init class="form-outline form-white">
                                                            <input type="password" id="typeText"
                                                                class="form-control form-control-lg"
                                                                placeholder="&#9679;&#9679;&#9679;" size="1"
                                                                minlength="3" maxlength="3" name="cvv" />
                                                            <label class="form-label" for="typeText">Cvv</label>
                                                        </div>
                                                    </div>
                                                </div>



                                                <hr class="my-4">

                                                <div class="d-flex justify-content-between">
                                                    <p class="mb-2">Subtotal</p>
                                                    <p class="mb-2">$20.00</p>
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <p class="mb-2">Tax</p>
                                                    <p class="mb-2">$5.00</p>
                                                </div>

                                                <div class="d-flex justify-content-between mb-4">
                                                    <p class="mb-2">Total(Incl. taxes)</p>
                                                    <p class="mb-2">$25.00</p>
                                                </div>

                                                <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                                    class="btn btn-info btn-block btn-lg">
                                                    <div class="d-flex justify-content-between">
                                                        <span>$25.00</span>
                                                        <span>Checkout <i
                                                                class="fas fa-long-arrow-alt-right ms-2"></i></span>
                                                    </div>
                                                </button>
                                            </form>

                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
</body>

</html>