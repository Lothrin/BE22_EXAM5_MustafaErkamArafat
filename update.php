<?php
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit();
}


require_once "connection.php";
$id = $_GET["id"];
$sql = "SELECT * from cars WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);



if (isset($_POST["update"])) {
    $brand = cleanInput($_POST["brand"]);
    $model = cleanInput($_POST["model"]);
    $image = $_POST["image"];
    $description = cleanInput($_POST["description"]);
    $production_year = cleanInput($_POST["production_year"]);
    $price = cleanInput($_POST["price"]);
    $status = cleanInput($_POST["status"]);

    $sqlUpdate = "UPDATE `cars` SET `brand`='{$brand}',`model`='{$model}',`image`='{$image}',`description`= '{$description}',`production_year`='{$production_year}', `price` = '{$price}', `status` = '{$status}' WHERE id = $id";


    $resultUpdate = mysqli_query($conn, $sqlUpdate);

    if ($resultUpdate) {
        echo "Success";
        header("Location: index.php");
        exit();
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
    <title>Update</title>
</head>

<nav class="admin-navbar">
    <div class="navbar-container">
        <a href="index.php" class="navbar-brand">Car Rental</a>
        <form method="POST" action="" class="navbar-form">
            <button type='submit' name='fetch_reserved' class='nav-button'>Reservations</button>
            <button type='submit' name='fetch_all' class='nav-button'>Show All</button>
        </form>
        <div class="navbar-links">
            <a class="nav-link" href="create.php">Create Item</a>
            <a class="nav-link logout" href="logout.php?logout">Logout</a>
        </div>
    </div>
</nav>

<body>
    <div class="container">
        <h1>Update Product</h1>
        <form method="post" enctype="multipart/form-data">
            <input id="brand" type="text" placeholder="Car Brand" class="form-control mt-3" name="brand" value="<?= $row["brand"] ?>">
            <input id="model" type="text" placeholder="Car Model" class="form-control mt-3" name="model" value="<?= $row["model"] ?>">
            <input type="text" placeholder="Product Image" class="form-control mt-3" name="image" value="<?= $row["image"] ?>">
            <input id="description" type="text" placeholder="Description" class="form-control mt-3" name="description" value="<?= $row["description"] ?>">
            <input id="production_year" type="number" placeholder="Production Year" class="form-control mt-3" name="production_year" value="<?= $row["production_year"] ?>">
            <input type="number" step="0.1" placeholder="Price" class="form-control mt-3" name="price" value="<?= $row["price"] ?>">
            <input id="status" type="text" placeholder="Status" class="form-control mt-3" name="status" value="<?= $row["status"] ?>">

            <input type="submit" class="btn btn-primary mt-3" value="Update Product" name="update">
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