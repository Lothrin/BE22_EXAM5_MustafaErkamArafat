<?php
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_SESSION["user"])) {
    header("Location: ../home.php");
    exit();
}
require_once "connection.php";

if (isset($_POST["create"])) {
    $image = cleanInput($_POST["image"]);
    $brand = cleanInput($_POST["brand"]);
    $model = cleanInput($_POST["model"]);
    $description = cleanInput($_POST["description"]);
    $production_year = cleanInput($_POST["production_year"]);
    $price = cleanInput($_POST["price"]);
    $status = 'Available';

    $sql = "INSERT INTO `cars`(`brand`, `model`, `description`, `production_year`, `price`, `image`, `status`) VALUES ('{$brand}','{$model}','{$description}','{$production_year}','{$price}','{$image}','{$status}')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "Success";
    } else {
        echo "Error";
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
    <title>Create</title>
</head>
<nav class="admin-navbar">
    <div class="navbar-container">
        <a href="index.php" class="navbar-brand">Car Rental</a>
        <form method="POST" action="" class="navbar-form">
            <a href="index.php" type='submit' name='fetch_reserved' class='nav-button'>Reservations</a>
            <a href="index.php" type='submit' name='fetch_all' class='nav-button'>Show All</a>
        </form>
        <div class="navbar-links">
            <a class="nav-link" href="create.php">Create Item</a>
            <a class="nav-link logout" href="logout.php?logout">Logout</a>
        </div>
    </div>
</nav>

<body>

    <div class="container">
        <h2>Car Details</h2>
        <form method="post">
            <input name="brand" type="text" placeholder="Car Brand" class="form-control my-2">
            <input name="model" type="text" placeholder="Car Model" class="form-control my-2">
            <input name="image" type="text" placeholder="Item Image" class="form-control my-2">
            <textarea name="description" placeholder="Description" class="form-control my-2"></textarea>
            <input name="production_year" type="number" placeholder="Production Year" class="form-control my-2">
            <input name="price" type="number" placeholder="Price" class="form-control my-2">
            <input type="submit" class="btn btn-primary" name="create" value="Create">
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