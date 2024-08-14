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

// password for admin is 123123

$sql = "SELECT * FROM `cars`";

$result = mysqli_query($conn, $sql);

$layout = "";
$cancel = "";
if (mysqli_num_rows($result) == 0) {
    $layout .= "<p>No items found!</p>";
} else {
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($rows as $key => $value) {
        if ($value["status"] == "Reserved") {
            $cancel = "<br><a class='btn btn-danger btn-sm m-2' href='cancel.php?id={$value["ID"]}'>Cancel Reservation</a>";
        } else {
            $cancel = "";
        }
        $layout .=  "<div class='col my-4'>
                        <div class='card' style='width: 100%;'>
                            <img src='{$value["image"]}' class='card-img-top' alt='...' style='height: 200px; object-fit: cover;'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$value["brand"]}</h5>
                                <p class='card-text'>{$value["model"]}</p>
                                <p class='card-text'>({$value["production_year"]})</p>          
                                <p class='card-text'>{$value["status"]}</p>
                                <a class='btn btn-warning btn-sm' href='update.php?id={$value["ID"]}'>Update</a>
                                <a href='details.php?id={$value["ID"]}' class='btn btn-success'>Details</a>
                                <a class='btn btn-danger btn-sm' href='delete.php?id={$value["ID"]}'>Delete</a>
                                 $cancel 
                                
                            </div>
                        </div>
                    </div>";
    }
}

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

if (isset($_POST['fetch_reserved'])) {
    $sqlReserved = "SELECT * FROM cars WHERE `status` = 'Reserved'";
    $result = mysqli_query($conn, $sqlReserved);

    if (mysqli_num_rows($result) == 0) {
        $layout = "<p class=' m-3 text-success'>All cars are available!</p>";
    } else {
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $layout = "";

        foreach ($rows as $key => $value) {

            $layout .=  "<div class='col my-4'>
                        <div class='card' style='width: 100%;'>
                            <img src='{$value["image"]}' class='card-img-top' alt='...' style='height: 200px; object-fit: cover;'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$value["brand"]}</h5>
                                <p class='card-text'>{$value["model"]}</p>
                                <p class='card-text'>({$value["production_year"]})</p> 
        

                                <a href='details.php?id={$value["ID"]}' class='btn btn-sm btn-success'>Details</a>
                                <a class='btn btn-danger btn-sm m-2' href='cancel.php?id={$value["ID"]}'>Cancel Reservation</a>


                            </div>
                        </div>
                    </div>";
        }
    }
}
function getCurrentYear()
{
    return date("Y");
}

$showAll = "";
$c_year = getCurrentYear();
if (isset($_POST['fetch_oldtimers'])) {
    $sqlOld = "SELECT * FROM cars WHERE `production_year` <= $c_year - 30";
    $result_old = mysqli_query($conn, $sqlOld);

    if (mysqli_num_rows($result_old) == 0) {
        $layout = "<p>No items found!</p>";
    } else {
        $showAll = "<button type='submit' name='fetch_all' class='nav-button'>Show All</button>";
        if (isset($_POST['fetch_all'])) {
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

            foreach ($rows as $key => $value) {
                if ($value["status"] == "Reserved") {
                    $cancel = "<br><a class='btn btn-danger btn-sm m-2' href='cancel.php?id={$value["ID"]}'>Cancel Reservation</a>";
                } else {
                    $cancel = "";
                }
                $layout .=  "<div class='col my-4'>
                                <div class='card' style='width: 100%;'>
                                    <img src='{$value["image"]}' class='card-img-top' alt='...' style='height: 200px; object-fit: cover;'>
                                    <div class='card-body'>
                                        <h5 class='card-title'>{$value["brand"]}</h5>
                                        <p class='card-text'>{$value["model"]}</p>
                                        <p class='card-text'>({$value["production_year"]})</p> 
                
        
                                        <a href='details.php?id={$value["ID"]}' class='btn btn-success'>Details</a>
                                        $cancel 
        
        
                                    </div>
                                </div>
                            </div>";
            }
        }
        $layout = "";
        $rows = mysqli_fetch_all($result_old, MYSQLI_ASSOC);

        foreach ($rows as $key => $value) {
            if ($value["status"] == "Reserved") {
                $cancel = "<br><a class='btn btn-danger btn-sm m-2' href='cancel.php?id={$value["ID"]}'>Cancel Reservation</a>";
            } else {
                $cancel = "";
            }
            $layout .=  "<div class='col my-4'>
                        <div class='card' style='width: 100%;'>
                            <img src='{$value["image"]}' class='card-img-top' alt='...' style='height: 200px; object-fit: cover;'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$value["brand"]}</h5>
                                <p class='card-text'>{$value["model"]}</p>
                                <p class='card-text'>({$value["production_year"]})</p> 
        

                                <a href='details.php?id={$value["ID"]}' class='btn btn-success'>Details</a>
                                $cancel 



                            </div>
                        </div>
                    </div>";
        }
    }
}
$user_id = $_SESSION['admin'];
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
        <h4 class="text-center text-light mt-2">Welcome <span><img width="20px" src="<?= ($user['picture']) ?>" alt=""></span> <?= htmlspecialchars($user['first_name']) ?>!</h4>
        <form method="POST" action="" class="navbar-form">
            <button type='submit' name='fetch_reserved' class='nav-button'>Reservations</button>
            <button type="submit" name="fetch_oldtimers" class="nav-button">Show Oldtimers</button>
            <button type='submit' name='fetch_all' class='nav-button'>Show All</button>
        </form>
        <div class="navbar-links">
            <a class="nav-link" href="create.php">Create Item</a>
            <a class="nav-link logout" href="logout.php?logout">Logout</a>
        </div>
    </div>
</nav>

<body>
    <div class="container custom-container">
        <?php
        if (isset($_SESSION['alert']) && !empty($_SESSION['alert'])) {
            echo '<div class="custom-alert">';
            echo htmlspecialchars($_SESSION['alert']);
            echo '</div>';
            unset($_SESSION['alert']);
        }
        ?>
        <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-xs-1 custom-row">
            <?= $layout ?>
        </div>
    </div>

</body>
<footer class="custom-footer">
    <div class="footer-content">
        <p>&copy; 2024 Copyright</p>
        <p class="footer-author">Mustafa Erkam Arafat - CodeFactory</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</html>