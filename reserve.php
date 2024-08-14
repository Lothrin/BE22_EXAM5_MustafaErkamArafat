<?php
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

require_once "connection.php";

function getCurrentDate()
{
    return date("Y-m-d");
}

$id = $_GET["id"];
$user_id = $_SESSION["user"];
$reserve_date = getCurrentDate();


$sqlCheck = "SELECT * FROM `car_rent` WHERE `user_id` = '$user_id' AND `car_id` = '$id'";
$result = mysqli_query($conn, $sqlCheck);

if (mysqli_num_rows($result) > 0) {

    $_SESSION['alert'] = "You have already reserved this car.";
    header("Location: index.php");
    exit();
}

$sqlReserve = "INSERT INTO `car_rent`(`user_id`, `car_id`, `reserve_date`) VALUES ('{$user_id}','{$id}','{$reserve_date}')";
if (!mysqli_query($conn, $sqlReserve)) {
    $_SESSION['alert'] = "Reservation failed.";
} else {
    $_SESSION['alert'] = "Car reserved successfully!";
}

$sqlUpdateCar = "UPDATE `cars` SET `status` = 'Reserved' WHERE `id` = '$id'";
mysqli_query($conn, $sqlUpdateCar);



header("Location: index.php");
