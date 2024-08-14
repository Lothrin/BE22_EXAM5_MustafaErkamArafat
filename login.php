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
$email = $emailError = $passError = "";
if (isset($_POST["login-btn"])) {
    $email = cleanInput($_POST["email"]);
    $password = cleanInput($_POST["password"]);

    if (empty($email)) {
        $error = true;
        $emailError = "Email is required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter a valid email address!";
    }

    if (empty($password)) {
        $error = true;
        $passError = "Password is required";
    }

    if (!$error) {
        $password = hash("sha256", $password);



        $sql =  "SELECT * FROM `users` WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $sql);


        $row = mysqli_fetch_assoc($result);

        if (mysqli_num_rows($result) == 1) {
            if ($row["status"] == "admin") {
                $_SESSION["admin"] = $row["ID"];
                header("Location: index.php");
            } else {
                $_SESSION["user"] = $row["ID"];
                header("Location: home.php");
                exit();
            }
        } else {
            echo "Incorrect credentials!";
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
    <link rel="stylesheet" href="index_navbar.css">
    <link rel="stylesheet" href="index_body.css">

    <title>Document</title>
</head>
<nav class="admin-navbar">
    <div class="navbar-container">
        <a href="index.php" class="navbar-brand">Car Rental</a>

    </div>
</nav>

<body>
    <div class="container my-5">
        <h1>Login Form</h1>
        <form method="POST" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" autocomplete="off">
            <input type="email" placeholder="example@mail.com" class="form-control mt-3" name="email" value="<?= $email ?>">
            <p class="text-danger"> <?= $emailError ?></p>
            <input type="password" placeholder="Please enter your password here" class="form-control mt-3" name="password">
            <p class="text-danger"> <?= $passError ?></p>
            <input type="submit" value="Login" name="login-btn" class="btn btn-info mt-3">
        </form>
        <p class=" mt-5">Don't have an account?</p>
        <a style="color: black;" class="btn btn-secondary" href="register.php">Register here</a>
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