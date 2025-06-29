-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2025 at 01:01 PM
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
-- Database: `laboratorybookingsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `check_equipment`
--

CREATE TABLE `check_equipment` (
  `TO_ID` varchar(10) NOT NULL,
  `Equip_ID` varchar(10) NOT NULL,
  `Available` enum('Yes','No') DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `check_equipment`
--

INSERT INTO `check_equipment` (`TO_ID`, `Equip_ID`, `Available`) VALUES
('TO001', 'EQ001', 'Yes'),
('TO002', 'EQ002', 'No'),
('TO003', 'EQ003', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE `instructor` (
  `Instruc_ID` varchar(10) NOT NULL,
  `Instruc_name` varchar(50) DEFAULT NULL,
  `Instruc_Email` varchar(50) DEFAULT NULL,
  `Department` varchar(50) DEFAULT NULL,
  `TO_ID` varchar(10) DEFAULT NULL,
  `Lecturer_ID` varchar(10) DEFAULT NULL,
  `Subject_ID` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`Instruc_ID`, `Instruc_name`, `Instruc_Email`, `Department`, `TO_ID`, `Lecturer_ID`, `Subject_ID`) VALUES
('INS001', 'Ms. D. Kumari', 'd.kumari@univ.edu', 'Computer Science', 'TO001', 'LEC001', 'SUB101'),
('INS002', 'Mr. E. Ruwan', 'e.ruwan@univ.edu', 'IT', 'TO002', 'LEC002', 'SUB102'),
('INS003', 'Ms. F. Nadeesha', 'f.nadeesha@univ.edu', 'Electronics', 'TO003', 'LEC003', 'SUB103'),
('INS685ea86', 'Sample', 'sample@inst.jfn.ac.lk', 'Computer Department', 'TO004', 'LEC002', 'SUB102'),
('INS6860036', 'vithyashini T', 'tvithya@inst.jfn.ac.lk', 'Electrical Department', 'TO005', 'LEC003', 'SUB103'),
('INS6860eec', 'Thilookshan ', 'Thiluksh@inst.jfn.ac.lk', 'Computer Department', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `laboratory`
--

CREATE TABLE `laboratory` (
  `Lab_ID` varchar(10) NOT NULL,
  `Lab_name` varchar(50) DEFAULT NULL,
  `Capacity` int(11) DEFAULT NULL,
  `Availability` varchar(20) DEFAULT NULL,
  `TO_ID` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laboratory`
--

INSERT INTO `laboratory` (`Lab_ID`, `Lab_name`, `Capacity`, `Availability`, `TO_ID`) VALUES
('LAB001', 'Computer Lab A', 30, 'Available', 'TO001'),
('LAB002', 'Networking Lab', 25, 'Unavailable', 'TO002'),
('LAB003', 'Electronics Lab', 20, 'Available', 'TO003');

-- --------------------------------------------------------

--
-- Table structure for table `laboratory_location`
--

CREATE TABLE `laboratory_location` (
  `Lab_ID` varchar(10) NOT NULL,
  `Location` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laboratory_location`
--

INSERT INTO `laboratory_location` (`Lab_ID`, `Location`) VALUES
('LAB001', 'Building A - Room 101'),
('LAB002', 'Building B - Room 202'),
('LAB003', 'Building C - Room 303');

-- --------------------------------------------------------

--
-- Table structure for table `lab_booking`
--

CREATE TABLE `lab_booking` (
  `Booking_ID` int(11) NOT NULL,
  `Instruc_ID` varchar(10) DEFAULT NULL,
  `Lab_ID` varchar(10) DEFAULT NULL,
  `Usage_date` date DEFAULT NULL,
  `Start_time` time DEFAULT NULL,
  `End_time` time DEFAULT NULL,
  `Status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `notified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_booking`
--

INSERT INTO `lab_booking` (`Booking_ID`, `Instruc_ID`, `Lab_ID`, `Usage_date`, `Start_time`, `End_time`, `Status`, `notified`) VALUES
(2, 'INS002', 'LAB002', '2025-07-02', '14:00:00', '16:00:00', 'Approved', 0),
(3, 'INS003', 'LAB003', '2025-07-03', '09:00:00', '11:00:00', 'Rejected', 0),
(4, 'INS001', 'LAB001', '2025-06-30', '08:00:00', '11:00:00', 'Pending', 0),
(5, 'INS001', 'LAB001', '2025-06-30', '08:00:00', '11:00:00', 'Pending', 0),
(6, 'INS001', 'LAB001', '2025-06-30', '08:00:00', '11:00:00', 'Pending', 0),
(7, 'INS001', 'LAB001', '2025-06-30', '08:00:00', '11:00:00', 'Pending', 0),
(8, 'INS001', 'LAB001', '2025-06-30', '08:00:00', '11:00:00', 'Pending', 0),
(9, 'INS001', 'LAB001', '2025-06-30', '08:00:00', '11:00:00', 'Pending', 0),
(10, 'INS001', 'LAB001', '2025-06-30', '08:00:00', '11:00:00', 'Pending', 0),
(11, 'INS685ea86', 'LAB001', '2025-07-10', '09:00:00', '12:00:00', 'Rejected', 0),
(12, 'INS685ea86', 'LAB001', '2025-06-30', '09:00:00', '11:00:00', 'Pending', 0),
(13, 'INS6860036', 'LAB003', '2025-09-10', '10:30:00', '12:45:00', 'Rejected', 0);

-- --------------------------------------------------------

--
-- Table structure for table `lab_equipment`
--

CREATE TABLE `lab_equipment` (
  `Equip_ID` varchar(10) NOT NULL,
  `Equip_name` varchar(50) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Lab_ID` varchar(10) DEFAULT NULL,
  `Available` enum('Yes','No') DEFAULT 'Yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_equipment`
--

INSERT INTO `lab_equipment` (`Equip_ID`, `Equip_name`, `Quantity`, `Lab_ID`, `Available`) VALUES
('EQ001', 'Raspberry Pi', 10, 'LAB001', 'Yes'),
('EQ002', 'Switch', 5, 'LAB002', 'Yes'),
('EQ003', 'Oscilloscope', 3, 'LAB003', 'Yes'),
('EQ004', 'Bread board', 10, 'LAB003', 'Yes'),
('EQ005', 'Signal generator', 4, 'LAB003', 'Yes'),
('EQ006', 'Cables', 15, 'LAB002', 'Yes'),
('EQ007', 'PCs', 40, 'LAB001', 'No'),
('EQ008', 'Connecting wires', 24, 'LAB003', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `lab_to`
--

CREATE TABLE `lab_to` (
  `TO_ID` varchar(10) NOT NULL,
  `TO_name` varchar(50) DEFAULT NULL,
  `TO_Email` varchar(50) DEFAULT NULL,
  `Instruc_ID` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_to`
--

INSERT INTO `lab_to` (`TO_ID`, `TO_name`, `TO_Email`, `Instruc_ID`) VALUES
('TO001', 'Mr. G. Jayasuriya', 'g.jayasuriya@univ.edu', 'INS001'),
('TO002', 'Ms. H. Anushka', 'h.anushka@univ.edu', 'INS002'),
('TO003', 'Mr. I. Tharindu', 'i.tharindu@univ.edu', 'INS003'),
('TO685eb6fe', 'Sample LabTO', 'sample@to.jfn.ac.lk', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lab_usage_log`
--

CREATE TABLE `lab_usage_log` (
  `Log_ID` varchar(10) NOT NULL,
  `Lab_ID` varchar(10) DEFAULT NULL,
  `Usage_date` date DEFAULT NULL,
  `Start_time` time DEFAULT NULL,
  `End_time` time DEFAULT NULL,
  `Instruc_ID` varchar(10) DEFAULT NULL,
  `TO_ID` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_usage_log`
--

INSERT INTO `lab_usage_log` (`Log_ID`, `Lab_ID`, `Usage_date`, `Start_time`, `End_time`, `Instruc_ID`, `TO_ID`) VALUES
('LOG001', 'LAB001', '2025-07-01', '10:00:00', '12:00:00', 'INS001', 'TO001'),
('LOG002', 'LAB002', '2025-07-02', '14:00:00', '16:00:00', 'INS002', 'TO002'),
('LOG003', 'LAB003', '2025-07-03', '09:00:00', '11:00:00', 'INS003', 'TO003'),
('LOG004', 'LAB001', '2025-06-17', '08:00:00', '11:00:00', 'INS001', 'TO685eb6fe');

-- --------------------------------------------------------

--
-- Table structure for table `lecturer_incharge`
--

CREATE TABLE `lecturer_incharge` (
  `Lecturer_ID` varchar(10) NOT NULL,
  `Subject_ID` varchar(10) NOT NULL,
  `Lec_name` varchar(50) DEFAULT NULL,
  `Lec_Email` varchar(50) DEFAULT NULL,
  `Department` varchar(50) DEFAULT NULL,
  `Subject_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lecturer_incharge`
--

INSERT INTO `lecturer_incharge` (`Lecturer_ID`, `Subject_ID`, `Lec_name`, `Lec_Email`, `Department`, `Subject_name`) VALUES
('LEC001', 'SUB101', 'Dr. A. Silva', 'a.silva@univ.edu', 'Computer Science', 'Digital Logic'),
('LEC002', 'SUB102', 'Dr. B. Fernando', 'b.fernando@univ.edu', 'IT', 'Data Structures'),
('LEC003', 'SUB103', 'Dr. C. Perera', 'c.perera@univ.edu', 'Electronics', 'Microcontrollers');

-- --------------------------------------------------------

--
-- Table structure for table `manage`
--

CREATE TABLE `manage` (
  `TO_ID` varchar(10) NOT NULL,
  `Lab_ID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manage`
--

INSERT INTO `manage` (`TO_ID`, `Lab_ID`) VALUES
('TO001', 'LAB001'),
('TO002', 'LAB002'),
('TO003', 'LAB003');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'sample@inst.jfn.ac.lk', '$2y$10$z5wFUAkK9UhByeD3AAWkCenObLTzBPSXj8W.Z6Y14xPm2LGHfRpa.', '2025-06-27 19:49:15', '2025-06-27 19:49:15'),
(2, 'sample@to.jfn.ac.lk', '$2y$10$UQEKAeHIYSP3uTbr8T/yB.WDh84G4wEhVw2uRaA6CxcooA/oMLrIi', '2025-06-27 20:51:35', '2025-06-27 20:51:35'),
(3, 'tvithya@inst.jfn.ac.lk', '$2y$10$F8/Joyu/mmX25Pwbh6L42ebHJjSJgZw.hq81e6YVUKX4P2KgJ0ClG', '2025-06-28 20:29:52', '2025-06-28 20:29:52'),
(4, 'Thiluksh@inst.jfn.ac.lk', '$2y$10$0/jS7r/oMjR//FAo0h/DhOiM5rtXgEyv6BTYUxc6/SKRyst19tqM6', '2025-06-29 13:14:06', '2025-06-29 13:14:06');

-- --------------------------------------------------------

--
-- Table structure for table `user_tokens`
--

CREATE TABLE `user_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tokens`
--

INSERT INTO `user_tokens` (`id`, `user_id`, `token`, `expires_at`) VALUES
(1, 1, 'c0d82630e7ff3cc369f93f91f48ecf786bb349bc0a1e826458aac707e96d4b8b', '2025-07-04 17:26:34'),
(2, 2, 'e4a356be8a76ab8cf496ae293b43131eebe7ed993821543d574db5fe38bb3979', '2025-07-04 18:52:13'),
(3, 2, 'a525767a6902d52b76311360964c941ecdc9e54e162a7b88a8046069e53262d3', '2025-07-04 18:52:20'),
(4, 1, '62042f7f280e3c80652a282daf228dfcd0eadad9f1112ae2efb830c603fae016', '2025-07-04 21:20:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `check_equipment`
--
ALTER TABLE `check_equipment`
  ADD PRIMARY KEY (`TO_ID`,`Equip_ID`),
  ADD KEY `Equip_ID` (`Equip_ID`);

--
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`Instruc_ID`),
  ADD KEY `Lecturer_ID` (`Lecturer_ID`,`Subject_ID`);

--
-- Indexes for table `laboratory`
--
ALTER TABLE `laboratory`
  ADD PRIMARY KEY (`Lab_ID`),
  ADD KEY `TO_ID` (`TO_ID`);

--
-- Indexes for table `laboratory_location`
--
ALTER TABLE `laboratory_location`
  ADD PRIMARY KEY (`Lab_ID`);

--
-- Indexes for table `lab_booking`
--
ALTER TABLE `lab_booking`
  ADD PRIMARY KEY (`Booking_ID`),
  ADD KEY `Instruc_ID` (`Instruc_ID`),
  ADD KEY `Lab_ID` (`Lab_ID`);

--
-- Indexes for table `lab_equipment`
--
ALTER TABLE `lab_equipment`
  ADD PRIMARY KEY (`Equip_ID`),
  ADD KEY `Lab_ID` (`Lab_ID`);

--
-- Indexes for table `lab_to`
--
ALTER TABLE `lab_to`
  ADD PRIMARY KEY (`TO_ID`),
  ADD KEY `Instruc_ID` (`Instruc_ID`);

--
-- Indexes for table `lab_usage_log`
--
ALTER TABLE `lab_usage_log`
  ADD PRIMARY KEY (`Log_ID`),
  ADD KEY `Lab_ID` (`Lab_ID`),
  ADD KEY `Instruc_ID` (`Instruc_ID`),
  ADD KEY `TO_ID` (`TO_ID`);

--
-- Indexes for table `lecturer_incharge`
--
ALTER TABLE `lecturer_incharge`
  ADD PRIMARY KEY (`Lecturer_ID`,`Subject_ID`);

--
-- Indexes for table `manage`
--
ALTER TABLE `manage`
  ADD PRIMARY KEY (`TO_ID`,`Lab_ID`),
  ADD KEY `Lab_ID` (`Lab_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lab_booking`
--
ALTER TABLE `lab_booking`
  MODIFY `Booking_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_tokens`
--
ALTER TABLE `user_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `check_equipment`
--
ALTER TABLE `check_equipment`
  ADD CONSTRAINT `check_equipment_ibfk_1` FOREIGN KEY (`TO_ID`) REFERENCES `lab_to` (`TO_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `check_equipment_ibfk_2` FOREIGN KEY (`Equip_ID`) REFERENCES `lab_equipment` (`Equip_ID`) ON DELETE CASCADE;

--
-- Constraints for table `instructor`
--
ALTER TABLE `instructor`
  ADD CONSTRAINT `instructor_ibfk_1` FOREIGN KEY (`Lecturer_ID`,`Subject_ID`) REFERENCES `lecturer_incharge` (`Lecturer_ID`, `Subject_ID`) ON DELETE CASCADE;

--
-- Constraints for table `laboratory`
--
ALTER TABLE `laboratory`
  ADD CONSTRAINT `laboratory_ibfk_1` FOREIGN KEY (`TO_ID`) REFERENCES `lab_to` (`TO_ID`);

--
-- Constraints for table `laboratory_location`
--
ALTER TABLE `laboratory_location`
  ADD CONSTRAINT `laboratory_location_ibfk_1` FOREIGN KEY (`Lab_ID`) REFERENCES `laboratory` (`Lab_ID`) ON DELETE CASCADE;

--
-- Constraints for table `lab_booking`
--
ALTER TABLE `lab_booking`
  ADD CONSTRAINT `lab_booking_ibfk_1` FOREIGN KEY (`Instruc_ID`) REFERENCES `instructor` (`Instruc_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `lab_booking_ibfk_2` FOREIGN KEY (`Lab_ID`) REFERENCES `laboratory` (`Lab_ID`) ON DELETE CASCADE;

--
-- Constraints for table `lab_equipment`
--
ALTER TABLE `lab_equipment`
  ADD CONSTRAINT `lab_equipment_ibfk_1` FOREIGN KEY (`Lab_ID`) REFERENCES `laboratory` (`Lab_ID`) ON DELETE CASCADE;

--
-- Constraints for table `lab_to`
--
ALTER TABLE `lab_to`
  ADD CONSTRAINT `lab_to_ibfk_1` FOREIGN KEY (`Instruc_ID`) REFERENCES `instructor` (`Instruc_ID`) ON DELETE CASCADE;

--
-- Constraints for table `lab_usage_log`
--
ALTER TABLE `lab_usage_log`
  ADD CONSTRAINT `lab_usage_log_ibfk_1` FOREIGN KEY (`Lab_ID`) REFERENCES `laboratory` (`Lab_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `lab_usage_log_ibfk_2` FOREIGN KEY (`Instruc_ID`) REFERENCES `instructor` (`Instruc_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `lab_usage_log_ibfk_3` FOREIGN KEY (`TO_ID`) REFERENCES `lab_to` (`TO_ID`) ON DELETE CASCADE;

--
-- Constraints for table `manage`
--
ALTER TABLE `manage`
  ADD CONSTRAINT `manage_ibfk_1` FOREIGN KEY (`TO_ID`) REFERENCES `lab_to` (`TO_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `manage_ibfk_2` FOREIGN KEY (`Lab_ID`) REFERENCES `laboratory` (`Lab_ID`) ON DELETE CASCADE;

--
-- Constraints for table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
