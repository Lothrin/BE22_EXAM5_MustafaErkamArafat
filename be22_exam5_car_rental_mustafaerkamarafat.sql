-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2024 at 07:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `be22_exam5_car_rental_mustafaerkamarafat`
--
CREATE DATABASE IF NOT EXISTS `be22_exam5_car_rental_mustafaerkamarafat` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `be22_exam5_car_rental_mustafaerkamarafat`;

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `ID` int(11) NOT NULL,
  `brand` varchar(20) NOT NULL,
  `model` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `production_year` int(4) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`ID`, `brand`, `model`, `description`, `production_year`, `price`, `image`, `status`) VALUES
(1, 'Lamborghini', 'RS-500', 'Super fast sports car', 2023, 485, 'https://cdn.pixabay.com/photo/2020/09/06/07/37/car-5548242_1280.jpg', 'Available'),
(2, 'Chevrolet', 'Hudson', 'Unforgettable Series - Oldtimer in perfect condition', 1972, 85000, 'https://cdn.pixabay.com/photo/2015/05/28/23/12/auto-788747_640.jpg', 'Available'),
(3, 'Cadillac', 'Luna 300', 'Chevrolet&#039;s classic oldtimer. Suitable companion for car enthusiasts', 1965, 55000, 'https://cdn.pixabay.com/photo/2016/02/13/13/11/oldtimer-1197800_1280.jpg', 'Reserved'),
(5, 'Mustang', '1967 Series', 'Mustang&#039;s 1967 Model, a pearl for lovers.', 1967, 345000, 'https://cdn.pixabay.com/photo/2017/09/01/20/23/ford-2705402_640.jpg', 'Reserved'),
(6, 'Mercedes Benz', '380i', 'Luxury and comfort combined.', 2018, 35000, 'https://cdn.pixabay.com/photo/2015/07/11/23/13/mercedes-benz-841465_640.jpg', 'Available'),
(7, 'Jeep', 'Landrover', 'Landrover, 4x4, will take you anywhere you want', 2015, 20000, 'https://cdn.pixabay.com/photo/2023/03/15/03/46/jeep-7853620_640.jpg', 'Reserved'),
(8, 'Mercedes Benz', 'RS-85', '500HP, 34.000km, recently registered, fair price.', 2021, 75000, 'https://cdn.pixabay.com/photo/2017/03/27/14/56/auto-2179220_640.jpg', 'Reserved'),
(10, 'Porsche', 'Roadster 500GT', 'Lightning fast, durable, sports car', 2023, 125000, 'https://cdn.pixabay.com/photo/2020/01/26/18/52/porsche-4795517_640.jpg', 'Available'),
(11, 'Corvette', 'SS2000', 'Futuristic Corvette sports car in Red', 2020, 145000, 'https://cdn.pixabay.com/photo/2020/02/03/10/02/sports-car-4815234_640.jpg', 'Available'),
(13, 'Volkswagen', 'Bus', 'Great for big families', 1965, 45000, 'https://cdn.pixabay.com/photo/2016/11/29/10/01/vw-bulli-1868890_640.jpg', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `car_rent`
--

CREATE TABLE `car_rent` (
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `reserve_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `car_rent`
--

INSERT INTO `car_rent` (`user_id`, `car_id`, `reserve_date`) VALUES
(5, 3, '2024-08-14'),
(5, 5, '2024-08-14'),
(5, 8, '2024-08-14'),
(12, 7, '2024-08-14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` int(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `first_name`, `last_name`, `email`, `phone_number`, `address`, `picture`, `password`, `status`) VALUES
(5, 'Erkam', 'Arafat', 'test@mail.com', 1231231232, 'rastenfeld 113', 'avatar.jpg', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'user'),
(6, 'Admin', 'Nimda', 'admin@mail.com', 1231231232, 'Zwettl 34', 'https://cdn.pixabay.com/photo/2024/05/24/19/06/bird-8785666_640.jpg', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'admin'),
(7, 'Isabel', 'Gilhofer', 'isi@mail.com', 1231231232, 'Zwettl 12', 'avatar.jpg', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'user'),
(12, 'Isabel', 'Gilhofer', 'isabel@mail.com', 1231231232, 'Zwettl', 'isi@mail.com', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'user'),
(13, 'ahmed', 'baran', 'test2@mail.com', 1231231232, 'vienna', 'avatar.jpg', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `car_rent`
--
ALTER TABLE `car_rent`
  ADD PRIMARY KEY (`user_id`,`car_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
