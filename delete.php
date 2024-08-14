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


$sqlDelete = "DELETE FROM `cars` WHERE id = $id";
mysqli_query($conn, $sqlDelete);
header("Location: index.php");
