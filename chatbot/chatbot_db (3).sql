-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2025 at 07:06 PM
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
-- Database: `chatbot_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sender_name` varchar(100) NOT NULL,
  `department` enum('Admin Department','Admin - Skill Development','Skill Development','Admin - Employment Department','Employment Department','Admin - Labour Department','Labour Department') DEFAULT NULL,
  `message` text DEFAULT NULL,
  `files` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`files`)),
  `reply_to` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_broadcast` tinyint(1) DEFAULT 0,
  `is_notified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `sender_name`, `department`, `message`, `files`, `reply_to`, `created_at`, `is_broadcast`, `is_notified`) VALUES
(3, 1, 'Super Admin', 'Admin Department', 'Hi', '[]', NULL, '2025-03-31 08:18:42', 0, 0),
(4, 1, 'Super Admin', 'Admin Department', 'Hi there is 1 training program of JAVA course give all the instructions to all the user', '[]', NULL, '2025-03-31 09:27:02', 0, 1),
(5, 3, 'Skill Admin', 'Admin - Skill Development', 'There is an training program of JAVA course', '[]', NULL, '2025-03-31 09:30:27', 0, 1),
(6, 1, 'Super Admin', 'Admin Department', 'Hi,there is a placemaent coming after an week.', '[]', NULL, '2025-03-31 09:48:48', 0, 0),
(7, 4, 'Employment Admin', 'Employment Department', 'Hi,there is a placemaent coming after an week', '[]', NULL, '2025-03-31 16:36:36', 1, 1),
(11, 6, 'nandP', 'Skill Development', 'okay', '[]', 5, '2025-04-01 16:20:11', 0, 1),
(12, 6, 'nandP', 'Skill Development', 'Hi to everyone', '[]', NULL, '2025-04-01 16:40:10', 0, 0),
(15, 7, 'Employment User 1', 'Employment Department', 'Hi,everyone', '[]', NULL, '2025-04-01 17:02:47', 0, 1),
(16, 1, 'Super Admin', 'Admin Department', 'Hi', '[]', NULL, '2025-04-02 03:41:55', 1, 0),
(17, 1, 'Super Admin', 'Admin Department', 'Hi,there is an meeting at 12:30', '[]', NULL, '2025-04-02 14:25:24', 0, 0),
(18, 1, 'Super Admin', 'Admin Department', 'Hi,there is meeting at 12:30', '[]', NULL, '2025-04-02 14:27:08', 1, 0),
(19, 3, 'Skill Admin', 'Admin - Skill Development', 'Hi there is meeting at 12:30', '[]', NULL, '2025-04-02 15:03:30', 0, 0),
(29, 2, 'Labour Admin', 'Labour Department', 'Hi there is meeting at 12:30', '[]', NULL, '2025-04-02 15:46:49', 0, 0),
(30, 2, 'Labour Admin', 'Labour Department', 'Hi there is meeting at 12:30', '[]', NULL, '2025-04-02 16:44:44', 0, 0),
(31, 3, 'Skill Admin', 'Admin - Skill Development', 'Hi there is meeting at 12:30', '[]', NULL, '2025-04-02 16:45:55', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `message_recipients`
--

DROP TABLE IF EXISTS `message_recipients`;
CREATE TABLE `message_recipients` (
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message_recipients`
--

INSERT INTO `message_recipients` (`id`, `message_id`, `recipient_id`, `created_at`, `is_read`) VALUES
(3, 3, 2, '2025-03-31 08:18:42', 0),
(4, 4, 3, '2025-03-31 09:27:02', 0),
(5, 5, 6, '2025-03-31 09:30:27', 0),
(6, 6, 4, '2025-03-31 09:48:48', 0),
(7, 7, 7, '2025-03-31 16:36:36', 0),
(11, 11, 3, '2025-04-01 16:20:11', 0),
(14, 15, 9, '2025-04-01 17:02:47', 0),
(15, 17, 2, '2025-04-02 14:25:24', 0),
(16, 17, 3, '2025-04-02 14:25:24', 0),
(17, 17, 9, '2025-04-02 14:25:24', 0),
(18, 19, 6, '2025-04-02 15:03:30', 0),
(28, 29, 5, '2025-04-02 15:46:49', 0),
(29, 30, 5, '2025-04-02 16:44:44', 0),
(30, 31, 6, '2025-04-02 16:45:55', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message_id`, `user_id`, `created_at`, `is_read`) VALUES
(36, 29, 5, '2025-04-02 15:46:49', 0),
(37, 30, 5, '2025-04-02 16:44:44', 0),
(38, 31, 6, '2025-04-02 16:45:55', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `user_type` enum('super_admin','department_admin','employee') NOT NULL,
  `department` enum('Labour Department','Skill Development','Employment Department','Admin Department') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `fullname`, `user_type`, `department`, `created_at`) VALUES
(1, 'Shah Dhairya', '1shahdhairya@gmail.com', 'password', 'Super Admin', 'super_admin', 'Admin Department', '2025-03-31 05:31:54'),
(2, 'Tanmay Sevak', 'tanmaysevak93@gmail.com', 'password', 'Labour Admin', 'department_admin', 'Labour Department', '2025-03-31 05:31:54'),
(3, 'Nand Patel', 'nandp23@gmail.com', 'password', 'Skill Admin', 'department_admin', 'Skill Development', '2025-03-31 05:31:54'),
(4, 'Zeel Rajkotiya', 'zeelrajkotiya@gmail.com', 'password', 'Employment Admin', 'department_admin', 'Employment Department', '2025-03-31 05:31:54'),
(5, 'tanmayB', 'shahdhairya28082008@gmail.com', 'password', 'Labour User 1', 'employee', 'Labour Department', '2025-03-31 05:31:54'),
(6, 'nandP', 'nandp6157@gmail.com', 'password\r\n', 'Skill User 1', 'employee', 'Skill Development', '2025-03-31 05:31:54'),
(7, 'zeelR', 'zeelrajkotiya@gmail.com', 'password', 'Employment User 1', 'employee', 'Employment Department', '2025-03-31 05:31:54'),
(9, 'NP12', '', 'nandpatel12', 'Employment User 2', 'employee', 'Employment Department', '2025-04-01 11:06:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `messages_ibfk_2` (`reply_to`),
  ADD KEY `idx_messages_status` (`is_broadcast`,`is_notified`);

--
-- Indexes for table `message_recipients`
--
ALTER TABLE `message_recipients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_id` (`message_id`),
  ADD KEY `recipient_id` (`recipient_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_id` (`message_id`),
  ADD KEY `idx_notifications_user` (`user_id`,`is_read`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `message_recipients`
--
ALTER TABLE `message_recipients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`reply_to`) REFERENCES `messages` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `message_recipients`
--
ALTER TABLE `message_recipients`
  ADD CONSTRAINT `message_recipients_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `message_recipients_ibfk_2` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
