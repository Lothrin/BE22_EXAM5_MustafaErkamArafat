<?php
session_start();



if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}
require_once "connection.php";




$id = $_GET["id"];

$sql = "SELECT * FROM cars WHERE id = $id ";

$result = mysqli_query($conn, $sql);

$value = mysqli_fetch_assoc($result);
$navbar = "";
$showAll = "<button type='submit' name='fetch_all' class='nav-button'>Show All</button>";

if (isset($_SESSION["admin"])) {

    $layoutUI = "<a class='btn btn-warning btn-sm' href='update.php?id={$value["ID"]}'>Update</a>
                <a class='btn btn-danger btn-sm' href='delete.php?id={$value["ID"]}'>Delete</a>";
    $btn_res = "";
    $navbar = "<nav class='admin-navbar'>
    <div class='navbar-container'>
        <a href='index.php' class='navbar-brand'>Car Rental</a>
        <form method='POST' action=' class='navbar-form'>
            <button type='submit' name='fetch_reserved' class='nav-button'>Reservations</button>
            <button type='submit' name='fetch_all' class='nav-button'>Show All</button>
        </form>
        <div class='navbar-links'>
            <a class='nav-link' href='create.php'>Create Item</a>
            <a class='nav-link logout' href='logout.php?logout'>Logout</a>
        </div>
    </div>
    </nav>";
} else {
    $user_id = $_SESSION["user"];
    $navbar = "<nav class='admin-navbar'>
    <div class='navbar-container'>
        <a href='index.php' class='navbar-brand'>Car Rental</a>
        <form method='POST' action=' class='navbar-form'>
            <button type='submit' name='fetch_oldtimers' class='nav-button'>Show Oldtimers</button>
            $showAll
        </form>
        <div class='navbar-links'>
            <a class='nav-link logout' href='logout.php?logout'>Logout</a>
        </div>
    </div>
</nav>";

    $layoutUI = "";

    $sqlR = "SELECT * FROM car_rent WHERE `user_id` = '$user_id' AND `car_id` = '$id'";
    $resultR = mysqli_query($conn, $sqlR);
    $r_value = mysqli_fetch_assoc($resultR);
}
if (!empty($r_value["reserve_date"])) {
    $r_date = " <p class='card-text mb-1'><strong>Reserve Date:</strong> {$r_value["reserve_date"]}</p>";
    $btn_res = "";
} else {
    $r_date = "";
    $btn_res = "<a href='reserve.php?id={$value["ID"]}' class='btn btn-warning'>Reserve</a>";
}

$layout = "<div class='col mb-4'>
                <div class='card h-100 text-center' style='width: 100%;'>
                    <img src='{$value["image"]}' class='card-img-top' alt='...' style='height: 350px; object-fit: cover;'>
                    <div class='card-body'>
                        <h5 class='card-title mb-3'>{$value["brand"]}</h5>
                        <p class='card-text text-muted mb-1'>({$value["model"]})</p>
                        <p class='card-text mb-2'>{$value["description"]}</p>
                        <p class='card-text mb-1'><strong>Production Year:</strong> {$value["production_year"]}</p>
                        <p class='card-text mb-1'><strong>Price:</strong> {$value["price"]}</p>
                        <p class='card-text mb-1'><strong class='text-success'>Status</strong> {$value["status"]}</p>
                        {$r_date}
                       
                        <a href='index.php' class='btn btn-success'>Go Back</a>
                        {$btn_res}

                         {$layoutUI}
                    </div>
                </div>
            </div>";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="index_navbar.css">
    <link rel="stylesheet" href="index_body.css">
    <title>Details</title>
</head>
<?= $navbar ?>

<body>

    <div class="container">
        <?= $layout ?>

    </div>
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