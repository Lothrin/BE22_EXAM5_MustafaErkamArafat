<?php

$hostName = "localhost";
$userName = "root";
$password = "";
$dbName = "be22_exam5_car_rental_mustafaerkamarafat";

$conn = mysqli_connect($hostName, $userName, $password, $dbName);

function cleanInput($input)
{
    $data = trim($input);
    $data = strip_tags($data);
    $data = htmlspecialchars($data);

    return $data;
}
