-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2025 at 04:16 PM
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
-- Database: `skill_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_metrics`
--

CREATE TABLE `dashboard_metrics` (
  `id` int(11) NOT NULL,
  `metric_name` varchar(100) NOT NULL,
  `metric_value` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `icon` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dashboard_metrics`
--

INSERT INTO `dashboard_metrics` (`id`, `metric_name`, `metric_value`, `created_at`, `icon`) VALUES
(1, 'Training Centers', '48', '2025-03-16 05:12:29', 'bi-building'),
(2, 'Active Trainees', '12,458', '2025-03-16 05:12:29', 'bi-people'),
(3, 'Courses Offered', '124', '2025-03-16 05:12:29', 'bi-journal-text'),
(4, 'Placement Rate', '78%', '2025-03-16 05:12:29', 'bi-graph-up');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`) VALUES
(1, 'Labour', 'Labour-related activities and welfare schemes'),
(2, 'Skill Development', 'Programs and training for skill development'),
(3, 'Employment', 'Employment-related initiatives and statistics'),
(4, 'Industrial Relations', 'Managing industrial relations and disputes'),
(5, 'Factories & Boilers', 'Regulations and safety compliance for factories');

-- --------------------------------------------------------

--
-- Table structure for table `department_progress`
--

CREATE TABLE `department_progress` (
  `id` bigint(20) NOT NULL,
  `dept_name` varchar(100) NOT NULL,
  `dept_progress` varchar(5) NOT NULL,
  `status_class` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_progress`
--

INSERT INTO `department_progress` (`id`, `dept_name`, `dept_progress`, `status_class`) VALUES
(1, 'Skill Development Portal', '75%', 'success'),
(2, 'Labour Welfare Initiative', '45%', 'warning'),
(3, 'Employment Database Migration', '90%', 'info');

-- --------------------------------------------------------

--
-- Table structure for table `f_name`
--

CREATE TABLE `f_name` (
  `id` bigint(20) NOT NULL,
  `fullname` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `description`, `department`, `icon`, `timestamp`) VALUES
(1, 'New policy document uploaded', 'Labour Department has uploaded a new policy document regarding minimum wages.', 'Labour', 'document', '2025-04-16 10:00:00'),
(2, 'Quarterly review meeting scheduled', 'Skill Development Department has scheduled a quarterly review meeting for next week.', 'Skill Development', 'calendar', '2025-04-15 12:00:00'),
(3, 'Employment statistics updated', 'Employment Department has updated the quarterly employment statistics.', 'Employment', 'stats', '2025-04-14 08:00:00'),
(4, 'New staff onboarding completed', 'Industrial Relations Department has completed onboarding of 15 new staff members.', 'Industrial Relations', 'people', '2025-04-13 09:30:00'),
(5, 'System maintenance scheduled', 'System maintenance is scheduled for this weekend. Please save your work accordingly.', NULL, 'warning', '2025-04-12 18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `department` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `deadline` date NOT NULL,
  `budget` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `status_class` varchar(20) DEFAULT NULL,
  `progress` int(11) NOT NULL CHECK (`progress` between 0 and 100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `project_name`, `department`, `start_date`, `deadline`, `budget`, `status`, `status_class`, `progress`) VALUES
(1, 'Labour Welfare Portal', 'Labour', '2025-01-01', '2025-06-30', '₹45 Lakhs', 'On Track', 'success', 80),
(2, 'Skill Development Database', 'Skill Development', '2025-02-15', '2025-08-15', '₹38 Lakhs', 'Delayed', 'warning', 60),
(3, 'Employment Exchange Modernization', 'Employment', '2025-03-01', '2025-09-30', '₹52 Lakhs', 'On Track', 'success', 85),
(4, 'Industrial Relations Management System', 'Industrial Relations', '2025-01-15', '2025-07-15', '₹40 Lakhs', 'At Risk', 'danger', 50),
(5, 'Factory Safety Monitoring System', 'Factories & Boilers', '2025-02-01', '2025-07-31', '₹48 Lakhs', 'On Track', 'success', 75);

-- --------------------------------------------------------

--
-- Table structure for table `project_budget`
--

CREATE TABLE `project_budget` (
  `id` int(11) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `allocated_budget` decimal(10,2) DEFAULT NULL,
  `utilized_budget` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_budget`
--

INSERT INTO `project_budget` (`id`, `category`, `allocated_budget`, `utilized_budget`) VALUES
(1, 'Labour', 45.00, 30.00),
(2, 'Skill Dev.', 35.00, 25.00),
(3, 'Employment', 52.00, 35.00),
(4, 'Industrial', 40.00, 28.00),
(5, 'Factories', 48.00, 32.00);

-- --------------------------------------------------------

--
-- Table structure for table `project_status`
--

CREATE TABLE `project_status` (
  `id` int(11) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `percentage` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_status`
--

INSERT INTO `project_status` (`id`, `status`, `percentage`) VALUES
(1, 'On Track', 55.00),
(2, 'Delayed', 20.00),
(3, 'At Risk', 15.00),
(4, 'Completed', 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `report_name` varchar(255) NOT NULL,
  `department` varchar(100) NOT NULL,
  `generated_on` date NOT NULL,
  `generated_by` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `type_class` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `report_name`, `department`, `generated_on`, `generated_by`, `type`, `type_class`) VALUES
(1, 'Labour Welfare Schemes Performance Q1 2025', 'Labour', '2025-04-15', 'Dr. Rajesh Kumar', 'Quarterly', 'primary'),
(2, 'Skill Development Programs Impact Analysis', 'Skill Development', '2025-04-10', 'Ms. Anita Desai', 'Special', 'info'),
(3, 'Employment Trends Analysis 2025', 'Employment', '2025-04-05', 'Mr. Vikram Singh', 'Annual', 'warning'),
(4, 'Industrial Disputes Resolution Efficiency', 'Industrial Relations', '2025-04-01', 'Ms. Priya Sharma', 'Quarterly', 'primary'),
(5, 'Factory Safety Compliance Report', 'Factories & Boilers', '2025-03-28', 'Mr. Suresh Patel', 'Monthly', 'success');

-- --------------------------------------------------------

--
-- Table structure for table `top_skills`
--

CREATE TABLE `top_skills` (
  `id` int(11) NOT NULL,
  `skill_name` varchar(100) NOT NULL,
  `demand_percentage` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `top_skills`
--

INSERT INTO `top_skills` (`id`, `skill_name`, `demand_percentage`, `created_at`) VALUES
(1, 'Data Analytics', 85, '2025-03-16 05:12:29'),
(2, 'Digital Marketing', 78, '2025-03-16 05:12:29'),
(3, 'Web Development', 72, '2025-03-16 05:12:29'),
(4, 'Cloud Computing', 68, '2025-03-16 05:12:29'),
(5, 'Machine Learning', 65, '2025-03-16 05:12:29');

-- --------------------------------------------------------

--
-- Table structure for table `training_enrollment`
--

CREATE TABLE `training_enrollment` (
  `id` int(11) NOT NULL,
  `month` varchar(10) NOT NULL,
  `it_software` int(11) NOT NULL,
  `manufacturing` int(11) NOT NULL,
  `healthcare` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_enrollment`
--

INSERT INTO `training_enrollment` (`id`, `month`, `it_software`, `manufacturing`, `healthcare`, `created_at`) VALUES
(1, 'Jan', 1200, 800, 600, '2025-03-16 05:12:29'),
(2, 'Feb', 1350, 850, 650, '2025-03-16 05:12:29'),
(3, 'Mar', 1500, 900, 700, '2025-03-16 05:12:29'),
(4, 'Apr', 1650, 950, 750, '2025-03-16 05:12:29'),
(5, 'May', 1800, 1000, 800, '2025-03-16 05:12:29'),
(6, 'Jun', 2000, 1050, 850, '2025-03-16 05:12:29');

-- --------------------------------------------------------

--
-- Table structure for table `training_programs`
--

CREATE TABLE `training_programs` (
  `id` int(11) NOT NULL,
  `program_id` varchar(20) NOT NULL,
  `program_name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `duration` varchar(50) NOT NULL,
  `location` varchar(255) NOT NULL,
  `total_seats` int(11) NOT NULL,
  `booked_seats` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `status_class` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_programs`
--

INSERT INTO `training_programs` (`id`, `program_id`, `program_name`, `start_date`, `duration`, `location`, `total_seats`, `booked_seats`, `status`, `status_class`, `created_at`) VALUES
(1, '#TRN-2025-042', 'Advanced Web Development', '2025-04-20', '3 Months', 'Central Training Center', 50, 40, 'Filling Fast', 'warning', '2025-03-16 05:12:29'),
(2, '#TRN-2025-043', 'Digital Marketing Essentials', '2025-04-25', '2 Months', 'East Zone Institute', 40, 35, 'Open', 'success', '2025-03-16 05:12:29'),
(3, '#TRN-2025-044', 'Cloud Computing Fundamentals', '2025-05-01', '3 Months', 'Tech Training Hub', 45, 25, 'Open', 'success', '2025-03-16 05:12:29'),
(4, '#TRN-2025-045', 'Data Science Bootcamp', '2025-05-05', '4 Months', 'Central Training Center', 50, 50, 'Filled', 'danger', '2025-03-16 05:12:29'),
(5, '#TRN-2025-046', 'Mobile App Development', '2025-05-10', '3 Months', 'West Zone Institute', 40, 20, 'Open', 'success', '2025-03-16 05:12:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dashboard_metrics`
--
ALTER TABLE `dashboard_metrics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department_progress`
--
ALTER TABLE `department_progress`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `f_name`
--
ALTER TABLE `f_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_budget`
--
ALTER TABLE `project_budget`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_status`
--
ALTER TABLE `project_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `top_skills`
--
ALTER TABLE `top_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_enrollment`
--
ALTER TABLE `training_enrollment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_programs`
--
ALTER TABLE `training_programs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `program_id` (`program_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dashboard_metrics`
--
ALTER TABLE `dashboard_metrics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `department_progress`
--
ALTER TABLE `department_progress`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `f_name`
--
ALTER TABLE `f_name`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `project_budget`
--
ALTER TABLE `project_budget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `project_status`
--
ALTER TABLE `project_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `top_skills`
--
ALTER TABLE `top_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `training_enrollment`
--
ALTER TABLE `training_enrollment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `training_programs`
--
ALTER TABLE `training_programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
