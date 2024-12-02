-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2024 at 03:08 PM
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
-- Database: `rotc_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_emails`
--

CREATE TABLE `admin_emails` (
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_emails`
--

INSERT INTO `admin_emails` (`email`) VALUES
('admin1@example.com'),
('admin2@example.com'),
('james@gmail.com'),
('julius.tenido@mdci.edu.ph'),
('juliusmtenido@gmail.com'),
('lovely@gmail.com'),
('lovelymae@gmail.com'),
('lovelymascardo@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Course` varchar(100) NOT NULL,
  `Attendance` varchar(50) NOT NULL,
  `Final_Score` decimal(5,2) NOT NULL,
  `Serial_Number` varchar(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `Name`, `Address`, `Course`, `Attendance`, `Final_Score`, `Serial_Number`, `user_id`, `email`) VALUES
(3, 'james', 'tugawe', 'bscs', '3', 100.00, 'none', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` enum('admin','student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `Email`, `Password`, `Role`) VALUES
(1, 'julius.tenido@mdci.edu.ph', '$2y$10$zijeMB9U7oA0VR5gK3aszeqMLhY0cfMuYzu327TyBYOWa2gpYbjGK', 'admin'),
(2, 'lovelymae.mascardo@mdci.edu.ph', '$2y$10$KQNSUSEglPyJg0/oC/kXMu5rPB70jDIy97h3R/l6YTh.D7oUoKSDe', 'student'),
(3, 'julius@gmail.com', '$2y$10$2ANqmRlcATOwdbP3EhLuceDHxBtqEyexb6mN8gRGe3yvLl862SGPO', 'student'),
(4, 'julius123@gmail.com', '$2y$10$5KEt38vC0o0zjbKHEYyC9uRjiIIQ.PvKz8tpTnWGd63QX535Pt8OS', 'student'),
(5, 'julius1234@gmail.com', '$2y$10$rwFwwHmZUYmQPojEit4xQ.clK0S5LKVi7QTm.94y5u1Y.OtHj76SK', 'student'),
(6, 'lovely@gmail.com', '$2y$10$FX/JcrY12ANPkjB7Sf/PmutAL6LiRfxEoS.nGqpaOo5PRCuwkkgGa', 'student'),
(7, 'james@gmail.com', '$2y$10$GA5WiWBV/Efnd1Oepo52R.p1c0j8Z4v/h3mhA53pdyck2qAIbVaye', 'admin'),
(8, 'lovelymae@gmail.com', '$2y$10$lyaeD/UgxTdd..lttRMj0ueMN3FuuWzp0MuBacdUln/zkkvgMSwEq', 'admin'),
(9, 'lovelymascardo@gmail.com', '$2y$10$VEgPgGcmzkn62ANRqE92Zu/cUGQ5z/nHpb1QAgsPYR6oJ9O5T76ji', 'student'),
(10, 'james123@gmail.com', '$2y$10$R4Gvn8xC/sxehwGSVz/zm.Jhu1hbmbMJqdqEAuJi5K3OTPug5bQ4e', 'student'),
(11, 'juliustenido@gmail.com', '$2y$10$KFGDaX7a25Ty.Ajj3tZoY.BeiIPcpsoQSJPSIBFx1mzpETAxo2iUy', 'student'),
(12, 'juliusmtenido@gmail.com', '$2y$10$yP6BxzhiphfEMYvOmmxU..fcJ.Ph/AkinjkPlK8AS4lahHm2i00GW', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_emails`
--
ALTER TABLE `admin_emails`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
