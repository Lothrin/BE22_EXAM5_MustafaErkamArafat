<?php
session_start();


if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}
if (isset($_SESSION["admin"])) {
    header("Location: index.php");
    exit();
}

require_once "connection.php";
function getCurrentYear()
{
    return date("Y");
}

$sql = "SELECT * FROM `cars` WHERE `status` = 'Available'";

$result = mysqli_query($conn, $sql);
$layout = "";
$car_status = "";
$alert = "";
$c_year = getCurrentYear();

if (mysqli_num_rows($result) == 0) {
    $layout = "<p>No cars available currently.";
} else {
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($rows as $key => $value) {

        $layout .=  "<div class='col my-4'>
                        <div class='card' style='width: 100%;'>
                            <img src='{$value["image"]}' class='card-img-top' alt='...' style='height: 200px; object-fit: cover;'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$value["brand"]}</h5>
                                <p class='card-text'>{$value["model"]}</p>
                                <p class='card-text'>({$value["production_year"]})</p> 
        

                                <a href='details.php?id={$value["ID"]}' class='btn btn-success'>Details</a>
                                <a href='reserve.php?id={$value["ID"]}' class='btn btn-warning'>Reserve</a>


                            </div>
                        </div>
                    </div>";
    }
}


$layoutRes = "";
$sqlReserved = "SELECT * FROM cars WHERE `status` = 'Reserved'";
$resultRes = mysqli_query($conn, $sqlReserved);

if (mysqli_num_rows($resultRes) == 0) {
    $layoutRes = "<p class=' m-3 text-success'>All cars are available!</p>";
} else {
    $rows = mysqli_fetch_all($resultRes, MYSQLI_ASSOC);

    foreach ($rows as $key => $value) {

        $layoutRes .=  "<div class='col my-4'>
                        <div class='card' style='width: 100%;'>
                            <img src='{$value["image"]}' class='card-img-top' alt='...' style='height: 200px; object-fit: cover;'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$value["brand"]}</h5>
                                <p class='card-text'>{$value["model"]}</p>
                                <p class='card-text'>({$value["production_year"]})</p> 
        

                                <a href='details.php?id={$value["ID"]}' class='btn btn-success'>Details</a>


                            </div>
                        </div>
                    </div>";
    }
}

$showAll = "";
if (isset($_POST['fetch_oldtimers'])) {
    $sqlOld = "SELECT * FROM cars WHERE `production_year` <= $c_year - 30 AND `status` = 'Available'";
    $result_old = mysqli_query($conn, $sqlOld);

    if (mysqli_num_rows($result_old) == 0) {
        $layout = "<p>No items found!</p>";
    } else {
        $showAll = "<button type='submit' name='fetch_all' class='nav-button'>Show All</button>";
        if (isset($_POST['fetch_all'])) {
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

            foreach ($rows as $key => $value) {
                $layout .=  "<div class='col my-4'>
                                <div class='card' style='width: 100%;'>
                                    <img src='{$value["image"]}' class='card-img-top' alt='...' style='height: 200px; object-fit: cover;'>
                                    <div class='card-body'>
                                        <h5 class='card-title'>{$value["brand"]}</h5>
                                        <p class='card-text'>{$value["model"]}</p>
                                        <p class='card-text'>({$value["production_year"]})</p> 
                
        
                                        <a href='details.php?id={$value["ID"]}' class='btn btn-success'>Details</a>
                                        <a href='reserve.php?id={$value["ID"]}' class='btn btn-warning'>Reserve</a>
        
        
                                    </div>
                                </div>
                            </div>";
            }
        }
        $layout = "";
        $rows = mysqli_fetch_all($result_old, MYSQLI_ASSOC);

        foreach ($rows as $key => $value) {
            $layout .=  "<div class='col my-4'>
                        <div class='card' style='width: 100%;'>
                            <img src='{$value["image"]}' class='card-img-top' alt='...' style='height: 200px; object-fit: cover;'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$value["brand"]}</h5>
                                <p class='card-text'>{$value["model"]}</p>
                                <p class='card-text'>({$value["production_year"]})</p> 
        

                                <a href='details.php?id={$value["ID"]}' class='btn btn-success'>Details</a>
                                <a href='reserve.php?id={$value["ID"]}' class='btn btn-warning'>Reserve</a>


                            </div>
                        </div>
                    </div>";
        }
    }
}
$user_id = $_SESSION['user'];
$sqlU = "SELECT * FROM users WHERE id = $user_id";
$resultU = mysqli_query($conn, $sqlU);

$user = mysqli_fetch_assoc($resultU);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="index_navbar.css">
    <link rel="stylesheet" href="index_body.css">


    <title>Car Rental</title>
</head>
<nav class="admin-navbar">
    <div class="navbar-container">
        <a href="index.php" class="navbar-brand">Car Rental</a>
        <h4 class="text-center text-light mt-2"><span><img class="m-2" width="35px" src="<?= ($user['picture']) ?>" alt=""></span>Welcome <?= htmlspecialchars($user['first_name']) ?>!</h4>

        <form method="POST" action="" class="navbar-form">
            <button type="submit" name="fetch_oldtimers" class="nav-button">Show Oldtimers</button>
            <?= $showAll ?>
        </form>
        <div class="navbar-links">
            <a class="nav-link logout" href="logout.php?logout">Logout</a>
        </div>
    </div>
</nav>

<body>

    <div class="container">

        <?php
        if (isset($_SESSION['alert']) && !empty($_SESSION['alert'])) {
            echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
            echo htmlspecialchars($_SESSION['alert']);
            echo '</div>';
            unset($_SESSION['alert']);
        }
        ?>

        <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-xs-1 custom-row">
            <?= $layout ?>


        </div>
        <div class="container">
            <h3>Already Reserved</h3>
            <div class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-1 row-cols-xs-1 custom-row">
                <?= $layoutRes ?>


            </div>
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