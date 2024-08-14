<?php
session_start();

if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit();
}

if (isset($_SESSION["admin"])) {
    header("Location: index.php");
    exit();
}


require_once "connection.php";



$error = false;

$fname = $lname = $phone_number = $address = $email = $pass = $picture = $status = '';
$fnameError = $lnameError = $phoneError = $addressError = $emailError = $passError = $picError = '';



if (isset($_POST['btn-signup'])) {
    $fname = cleanInput($_POST["first_name"]);

    $lname = cleanInput($_POST["last_name"]);

    $email = cleanInput($_POST["email"]);

    $password = cleanInput($_POST["password"]);

    $phone_number = cleanInput($_POST["phone_number"]);

    $address = cleanInput($_POST["address"]);

    $picture = cleanInput($_POST['picture']);

    $status = "user";

    if (empty($fname)) {
        $error = true;
        $fnameError = "First name cannot be empty!";
    } elseif (strlen($fname) < 3) {
        $error = true;
        $fnameError = "First name cannot be less than 3 characters!";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $fname)) {
        $error = true;
        $fnameError = "First name must contain only letters and spaces!";
    }

    if (empty($lname)) {
        $error = true;
        $lnameError = "Last name cannot be empty!";
    } elseif (strlen($lname) < 3) {
        $error = true;
        $lnameError = "Last name cannot be less than 3 characters!";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $lname)) {
        $error = true;
        $lnameError = "Last name must contain only letters and spaces!";
    }

    if (empty($phone_number)) {
        $error = true;
        $phoneError = "Phone number cannot be empty!";
    }
    if (empty($address)) {
        $error = true;
        $addressError = "Address cannot be empty!";
    }
    if (empty($picture)) {
        $picture = "avatar.jpg";
    }
    if (empty($email)) {
        $error = true;
        $emailError = "Email cannot be empty!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please type a valid email!";
    } else {
        $searchIfEmailExists = "SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $searchIfEmailExists);
        if (mysqli_num_rows($result) != 0) {
            $error = true;
            $emailError = "Email already exists!";
        }
    }

    if (empty($password)) {
        $error = true;
        $passError = "Password cannot be empty!";
    } elseif (strlen($password) < 6) {
        $error = true;
        $passError = "Password cannot be less than 6 characters!";
    }

    if (!$error) {
        $password = hash('sha256', $password);

        $sql = "INSERT INTO `users`(`first_name`, `last_name`, `password`, `phone_number`, `email`, `address`, `picture`, `status`) VALUES ('$fname','$lname','$password','$phone_number','$email','$address','$picture', '$status')";


        if (!mysqli_query($conn, $sql)) {
            $_SESSION['alert'] = "Registration failed!";
        } else {
            $_SESSION['alert'] = "Registration Successful!";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
    <link rel="stylesheet" href="index_navbar.css">
    <link rel="stylesheet" href="index_body.css">
</head>
<nav class="admin-navbar">
    <div class="navbar-container">
        <a href="index.php" class="navbar-brand">Car Rental</a>
        <form method="POST" action="" class="navbar-form">
            <a class="nav-button" href="login.php">Login</a>
        </form>
    </div>
</nav>

<body>
    <div class="container my-5">
        <h2 class="mb-3">Registration Form</h2>
        <?php
        if (isset($_SESSION['alert']) && !empty($_SESSION['alert'])) {
            echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
            echo htmlspecialchars($_SESSION['alert']);
            echo '</div>';
            unset($_SESSION['alert']);
        }
        ?>

        <form action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data" method="POST">
            <div class="mb-3">
                <label for="name">First Name</label>
                <input type="text" class="form-control" id="name" name="first_name" value="<?= $fname ?>">
                <p class=" text-danger"><?= $fnameError ?></p>
            </div>
            <div class="mb-3">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="last_name" value="<?= $lname ?>">
                <p class=" text-danger"><?= $lnameError ?></p>
            </div>
            <div class="mb-3">
                <label for="phone_number">Phone Number</label>
                <input type="number" class="form-control" id="phone_number" name="phone_number" value="<?= $phone_number ?>">
                <p class=" text-danger"><?= $phoneError ?></p>
            </div>
            <div class="mb-3">
                <label for="picture">Picture</label>
                <input type="text" class="form-control" id="picture" name="picture" value="<?= $email ?>">
            </div>
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>">
                <p class=" text-danger"><?= $emailError ?></p>
            </div>
            <div class="mb-3">
                <label for="address">Address</label>
                <input type="address" class="form-control" id="address" name="address" value="<?= $address ?>">
                <p class=" text-danger"><?= $addressError ?></p>
            </div>
            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
                <p class=" text-danger"><?= $passError ?></p>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-success" name="btn-signup">Register</button>
            </div>
        </form>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
<footer class="custom-footer">
    <div class="footer-content">
        <p>&copy; 2024 Copyright</p>
        <p class="footer-author">Mustafa Erkam Arafat - CodeFactory</p>
    </div>
</footer>

</html>