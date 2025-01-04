-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2025 at 01:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medion`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin1@example.com', 'admin123'),
(2, 'Ahnaf.admin@gmail.com', '147852');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `d_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `specialty` varchar(50) NOT NULL,
  `location` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `availability` int(11) NOT NULL DEFAULT 0,
  `booked` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`d_id`, `name`, `specialty`, `location`, `contact`, `availability`, `booked`) VALUES
(1, 'Dr. Mumtahina', 'Neurologist', 'Chittagong', '123456789', 5, 5),
(2, 'Dr. Naim', 'Orthopedic', 'Chittagong', '987654321', 10, 0),
(3, 'Dr. Ayan', 'Cardiologist', 'Sydney', '123123123', 10, 0),
(4, 'DR. Awsaf', 'Oncologist', 'Dhaka', '0123456789', 9, 1),
(5, 'DR. Fardin', 'Dermatologist', 'Dhaka', '0123456789', 10, 0),
(6, 'DR. Arib', 'orthopedic', 'Khulna', '0123456789', 8, 2),
(7, 'Dr. Ayman', 'Cardiologist', 'Chittagong', '0123456789', 10, 0),
(8, 'DR. Jhatka', 'Scientist', 'Furfuri nagar', '0123456789', 0, 3),
(9, 'Neutron', 'Neurologist', 'Chittagong', '123456789', 0, 0),
(10, 'Dr. Saloke', 'Surgeon', 'Sylhet', '123456789', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL CHECK (`rating` between 1 and 5),
  `comment` text NOT NULL,
  `suggestions` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `doctor_id`, `customer_id`, `rating`, `comment`, `suggestions`, `created_at`) VALUES
(1, 6, 2, 1, 'fghft', 'retry', '2025-01-03 10:23:35'),
(2, 4, 2, 1, 'vg', 'egeg', '2025-01-03 10:23:56');

-- --------------------------------------------------------

--
-- Table structure for table `mybookings`
--

CREATE TABLE `mybookings` (
  `id` int(11) NOT NULL,
  `d_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `booking_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mybookings`
--

INSERT INTO `mybookings` (`id`, `d_id`, `user_id`, `booking_date`) VALUES
(1, 1, 4, '2025-01-03 11:10:36'),
(2, 6, 4, '2025-01-03 11:18:46'),
(3, 6, 4, '2025-01-03 11:23:17'),
(4, 4, 2, '2025-01-03 15:48:26'),
(5, 1, 2, '2025-01-03 15:50:37'),
(6, 1, 6, '2025-01-03 18:56:50');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `created_at`) VALUES
(1, 4, 90.00, '2025-01-02 15:07:23'),
(2, 4, 90.00, '2025-01-02 15:08:48'),
(3, 4, 90.00, '2025-01-02 15:08:53'),
(4, 4, 90.00, '2025-01-02 15:08:55'),
(5, 4, 30.00, '2025-01-02 15:09:23'),
(6, 3, 50.00, '2025-01-02 15:25:10'),
(7, 4, 10.00, '2025-01-02 17:09:02'),
(8, 4, 30.00, '2025-01-02 17:09:02'),
(9, 4, 10.00, '2025-01-02 17:40:34'),
(10, 4, 10.00, '2025-01-02 17:45:05'),
(11, 2, 30.00, '2025-01-02 17:46:08'),
(12, 2, 30.00, '2025-01-02 17:46:12'),
(13, 2, 50.00, '2025-01-02 17:46:24'),
(14, 1, 600.00, '2025-01-02 18:29:44'),
(15, 1, 600.00, '2025-01-02 18:29:45'),
(16, 1, 70.00, '2025-01-02 18:30:06'),
(17, 1, 70.00, '2025-01-02 18:30:08'),
(18, 6, 10.00, '2025-01-03 12:54:44');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 2, 1, 90.00),
(2, 2, 2, 1, 90.00),
(3, 3, 2, 1, 90.00),
(4, 4, 2, 1, 90.00),
(5, 5, 3, 1, 30.00),
(6, 6, 7, 1, 50.00),
(7, 7, 1, 1, 10.00),
(8, 8, 3, 1, 30.00),
(9, 9, 1, 1, 10.00),
(10, 10, 1, 1, 10.00),
(11, 11, 3, 1, 30.00),
(12, 12, 3, 1, 30.00),
(13, 13, 7, 1, 50.00),
(14, 14, 6, 1, 600.00),
(15, 15, 6, 1, 600.00),
(16, 16, 4, 1, 70.00),
(17, 17, 4, 1, 70.00),
(18, 18, 1, 1, 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(10) NOT NULL,
  `product_name` varchar(20) NOT NULL,
  `price` int(10) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `stock` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_name`, `price`, `product_image`, `stock`) VALUES
(1, 'napa', 10, 'E:\\xampp\\htdocs\\website\\images\\Napa.webp', 9),
(2, 'fexo', 90, 'https://images.app.goo.gl/zXP6ZMS9CKLhANYFA', 8),
(3, 'napa extra', 30, '', 9),
(4, 'monus ', 70, '', 13),
(5, 'Imotil', 100, 'E:\\xampp\\htdocs\\website\\images\\Imotil.jpg', 15),
(6, 'Fia Biomate', 600, 'E:\\xampp\\htdocs\\website\\images\\FIA_Biomed 25.webp', 13),
(7, 'Vitamin -D', 50, 'E:\\xampp\\htdocs\\website\\images\\vital-d-capsule-1000iu-10-capsules.jpeg', 13);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `email`, `password`, `user_id`) VALUES
('sadman', 'sadman@gmail.com', '123456', 1),
('awsaf', 'awsaf@gmail.com', '123456', 2),
('apshari', 'apshari@gmail.com', 'awsaf', 3),
('Ahnaf', 'ahnaf@gmail.com', '123456', 4),
('arib', 'arib@gmail.com', 'aaa', 6),
('suvro', 'suvro@gmail.com', '123456', 7),
('suvro', 'suvro@gmail.com', '123456', 8),
('suvro', 'suvro@gmail.com', '123456', 9),
('hthg', 'gesg@gmail.com', '123456', 10);

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(5) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `user_name`, `password`) VALUES
(1, 'Ahnaf', '123456');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `mybookings`
--
ALTER TABLE `mybookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `d_id` (`d_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_ibfk_1` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mybookings`
--
ALTER TABLE `mybookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`d_id`) ON DELETE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`d_id`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `mybookings`
--
ALTER TABLE `mybookings`
  ADD CONSTRAINT `mybookings_ibfk_1` FOREIGN KEY (`d_id`) REFERENCES `doctors` (`d_id`),
  ADD CONSTRAINT `mybookings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
