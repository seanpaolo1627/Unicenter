-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2025 at 03:07 AM
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
-- Database: `crud_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `assign_designations`
--

CREATE TABLE `assign_designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_num` varchar(255) NOT NULL,
  `designation_id` bigint(20) UNSIGNED NOT NULL,
  `employee_type` enum('REGULAR','PROJECT','SEASONAL','FIXED-TERM','CASUAL','PROBATIONARY') NOT NULL,
  `probationary` varchar(255) NOT NULL,
  `daily_role` varchar(255) NOT NULL,
  `status` enum('ACTIVE','RESIGNED','AWOL') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assign_designations`
--

INSERT INTO `assign_designations` (`id`, `emp_num`, `designation_id`, `employee_type`, `probationary`, `daily_role`, `status`, `created_at`, `updated_at`) VALUES
(1, '2', 1, 'PROBATIONARY', '25', 'OJT', 'ACTIVE', '2025-06-08 06:31:27', '2025-06-08 06:31:27');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dept_name` varchar(255) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `dept_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Engineering', 'ACTIVE', '2025-06-08 06:24:51', '2025-06-08 06:24:51'),
(2, 'Accounting', 'ACTIVE', '2025-06-08 06:25:07', '2025-06-08 06:25:07');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `designation_name` varchar(255) NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `designation_name`, `department_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Engineering Head', 1, 'ACTIVE', '2025-06-08 06:25:44', '2025-06-08 16:57:57');

-- --------------------------------------------------------

--
-- Table structure for table `employeasts`
--

CREATE TABLE `employeasts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_num` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `address_line` varchar(255) NOT NULL,
  `brgy` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employeasts`
--

INSERT INTO `employeasts` (`id`, `emp_num`, `lastname`, `firstname`, `middlename`, `address_line`, `brgy`, `city`, `province`, `zipcode`, `created_at`, `updated_at`) VALUES
(1, '1', 'test', 'test', 'test', '123 Street', 'test', 'test', 'test', '123', '2025-06-08 06:20:30', '2025-06-08 06:20:30'),
(2, '2', 'Cameguing', 'Sean', 'Galve', '123 Street', 'Magugpo South', 'Tagum City', 'Davao Del Norte', '8100', '2025-06-08 06:30:44', '2025-06-08 06:30:44'),
(3, '2', 'Langones', 'Miguel Paolo', 'F.', '123 Street', 'East', 'Davao City', 'Davao Del Norte', '8000', '2025-06-08 16:52:36', '2025-06-08 16:52:36');

-- --------------------------------------------------------

--
-- Table structure for table `payrolls`
--

CREATE TABLE `payrolls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `basic_salary` decimal(10,2) NOT NULL,
  `additionals` decimal(10,2) NOT NULL DEFAULT 0.00,
  `deductions` decimal(10,2) NOT NULL DEFAULT 0.00,
  `government_contributions` decimal(10,2) NOT NULL DEFAULT 0.00,
  `professional_tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `loans` decimal(10,2) NOT NULL DEFAULT 0.00,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_net_pay` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assign_designations`
--
ALTER TABLE `assign_designations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_assign_designations_designation` (`designation_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_designations_department` (`department_id`);

--
-- Indexes for table `employeasts`
--
ALTER TABLE `employeasts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payrolls_employee` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assign_designations`
--
ALTER TABLE `assign_designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employeasts`
--
ALTER TABLE `employeasts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payrolls`
--
ALTER TABLE `payrolls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assign_designations`
--
ALTER TABLE `assign_designations`
  ADD CONSTRAINT `fk_assign_designations_designation` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `designations`
--
ALTER TABLE `designations`
  ADD CONSTRAINT `fk_designations_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD CONSTRAINT `fk_payrolls_employee` FOREIGN KEY (`employee_id`) REFERENCES `employeasts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
