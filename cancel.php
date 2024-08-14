<?php
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

require_once "connection.php";

$id = $_GET["id"];
$user_id = $_SESSION["admin"];


$sqlCancel = "DELETE FROM `car_rent` WHERE `car_id` = $id";

if (!mysqli_query($conn, $sqlCancel)) {
    $_SESSION['alert'] = "Cancellation Error";
} else {
    $sqlUpdateCar = "UPDATE `cars` SET `status` = 'Available' WHERE `id` = '$id'";
    mysqli_query($conn, $sqlUpdateCar);
    $_SESSION['alert'] = "Cancelled successfully!";
}

header("Location: index.php");
exit();
