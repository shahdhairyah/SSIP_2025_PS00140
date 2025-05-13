-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2025 at 04:15 PM
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
-- Database: `employment_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_metrics`
--

CREATE TABLE `dashboard_metrics` (
  `id` int(11) NOT NULL,
  `metric_name` varchar(255) NOT NULL,
  `metric_value` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dashboard_metrics`
--

INSERT INTO `dashboard_metrics` (`id`, `metric_name`, `metric_value`, `icon`, `created_at`) VALUES
(1, 'Job Seekers', 45782, 'bi-person-badge', '2025-03-17 15:22:26.487939'),
(2, 'Vacancies Listed', 2845, 'bi-briefcase', '2025-03-17 15:22:26.487939'),
(3, 'Placements (YTD)', 12458, 'bi-check-circle', '2025-03-17 15:22:26.487939'),
(4, 'Employment Exchanges', 32, 'bi-building', '2025-03-17 15:22:26.487939');

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
-- Table structure for table `employment_trends`
--

CREATE TABLE `employment_trends` (
  `year` int(11) NOT NULL,
  `job_seekers` int(11) NOT NULL,
  `placements` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employment_trends`
--

INSERT INTO `employment_trends` (`year`, `job_seekers`, `placements`) VALUES
(2020, 35000, 20000),
(2021, 38000, 22000),
(2022, 41000, 25000),
(2023, 44000, 28000),
(2024, 47000, 31000),
(2025, 51000, 34000);

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
-- Table structure for table `job_placements`
--

CREATE TABLE `job_placements` (
  `candidate_id` varchar(20) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `placement_date` date DEFAULT NULL,
  `salary_range` varchar(20) DEFAULT NULL,
  `generated_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_placements`
--

INSERT INTO `job_placements` (`candidate_id`, `name`, `position`, `company`, `placement_date`, `salary_range`, `generated_on`) VALUES
('#EMP-2025-1042', 'Amit Sharma', 'Software Developer', 'TechSolutions Inc.', '2025-04-15', '₹6-8 LPA', '2025-03-16 08:04:57'),
('#EMP-2025-1043', 'Neha Patel', 'Marketing Specialist', 'Global Brands Ltd.', '2025-04-14', '₹5-7 LPA', '2025-03-16 08:04:57'),
('#EMP-2025-1044', 'Rajesh Kumar', 'Mechanical Engineer', 'Precision Engineering Co.', '2025-04-12', '₹4-6 LPA', '2025-03-16 08:04:57'),
('#EMP-2025-1045', 'Priya Singh', 'HR Manager', 'Sunrise Industries', '2025-04-10', '₹8-10 LPA', '2025-03-16 08:04:57'),
('#EMP-2025-1046', 'Vikram Malhotra', 'Data Analyst', 'DataTech Solutions', '2025-04-08', '₹7-9 LPA', '2025-03-16 08:04:57');

-- --------------------------------------------------------

--
-- Table structure for table `job_sectors`
--

CREATE TABLE `job_sectors` (
  `sector` varchar(50) NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_sectors`
--

INSERT INTO `job_sectors` (`sector`, `count`) VALUES
('Education', 150),
('Healthcare', 200),
('IT & Software', 350),
('Manufacturing', 250),
('Others', 80),
('Retail', 100);

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
-- Table structure for table `report_department`
--

CREATE TABLE `report_department` (
  `id` int(11) NOT NULL,
  `department` varchar(50) DEFAULT NULL,
  `percentage` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report_department`
--

INSERT INTO `report_department` (`id`, `department`, `percentage`) VALUES
(1, 'Labour', 30),
(2, 'Skill Development', 25),
(3, 'Employment', 15),
(4, 'Industrial Relations', 15),
(5, 'Factories & Boilers', 15);

-- --------------------------------------------------------

--
-- Table structure for table `report_frequency`
--

CREATE TABLE `report_frequency` (
  `id` int(11) NOT NULL,
  `frequency` varchar(50) DEFAULT NULL,
  `reports_count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report_frequency`
--

INSERT INTO `report_frequency` (`id`, `frequency`, `reports_count`) VALUES
(1, 'Monthly', 25),
(2, 'Quarterly', 18),
(3, 'Half-Yearly', 12),
(4, 'Annual', 7),
(5, 'Special', 15);

-- --------------------------------------------------------

--
-- Table structure for table `safety_certifications`
--

CREATE TABLE `safety_certifications` (
  `certificate_id` varchar(20) NOT NULL,
  `factory_name` varchar(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `valid_until` date DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `status_class` varchar(20) NOT NULL,
  `generated_on` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `safety_certifications`
--

INSERT INTO `safety_certifications` (`certificate_id`, `factory_name`, `type`, `issue_date`, `valid_until`, `status`, `status_class`, `generated_on`) VALUES
('#FB-2025-1042', 'Eastern Steel Works', 'Boiler Certification', '2025-04-15', '2026-04-14', 'Valid', 'success', '2025-03-16 08:25:31.742919'),
('#FB-2025-1043', 'Global Textiles Ltd.', 'Factory Safety', '2025-04-12', '2026-04-11', 'Valid', 'success', '2025-03-16 08:25:31.742919'),
('#FB-2025-1044', 'Precision Engineering', 'Machinery Safety', '2025-04-10', '2026-04-09', 'Valid', 'success', '2025-03-16 08:25:31.742919'),
('#FB-2025-1045', 'Sunrise Chemicals', 'Hazardous Materials', '2025-04-08', '2026-04-07', 'Valid', 'success', '2025-03-16 08:25:31.742919'),
('#FB-2025-1046', 'Western Manufacturing', 'Boiler Certification', '2025-04-05', '2026-04-04', 'Valid', 'success', '2025-03-16 08:25:31.742919');

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
-- Indexes for table `employment_trends`
--
ALTER TABLE `employment_trends`
  ADD PRIMARY KEY (`year`);

--
-- Indexes for table `f_name`
--
ALTER TABLE `f_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_placements`
--
ALTER TABLE `job_placements`
  ADD PRIMARY KEY (`candidate_id`);

--
-- Indexes for table `job_sectors`
--
ALTER TABLE `job_sectors`
  ADD PRIMARY KEY (`sector`);

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
-- Indexes for table `report_department`
--
ALTER TABLE `report_department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report_frequency`
--
ALTER TABLE `report_frequency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `safety_certifications`
--
ALTER TABLE `safety_certifications`
  ADD PRIMARY KEY (`certificate_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dashboard_metrics`
--
ALTER TABLE `dashboard_metrics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `f_name`
--
ALTER TABLE `f_name`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- AUTO_INCREMENT for table `report_department`
--
ALTER TABLE `report_department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `report_frequency`
--
ALTER TABLE `report_frequency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
