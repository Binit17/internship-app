-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 02, 2023 at 05:50 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `intern_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `application_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `internship_id` int(11) DEFAULT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','disapproved') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`application_id`, `student_id`, `internship_id`, `application_date`, `status`) VALUES
(18, 2, 1, '2023-07-05 06:54:17', 'pending'),
(19, 3, 1, '2023-07-05 14:06:30', 'approved'),
(20, 4, 1, '2023-07-09 08:43:11', 'pending'),
(21, 2, 2, '2023-07-10 12:25:50', 'pending'),
(22, 4, 2, '2023-07-14 15:03:21', 'pending'),
(24, 4, 2, '2023-07-30 12:03:29', 'pending'),
(25, 4, 3, '2023-08-02 03:12:07', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `internships`
--

CREATE TABLE `internships` (
  `internship_id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `company_name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('open','closed') DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `salary` varchar(20) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `internships`
--

INSERT INTO `internships` (`internship_id`, `admin_id`, `title`, `company_name`, `description`, `start_date`, `end_date`, `status`, `duration`, `salary`, `location`) VALUES
(1, NULL, 'backend engineer', 'leapfrog', 'we need a backend engineer who is fluent in python, django', '2023-07-01', '2023-07-31', 'open', NULL, NULL, NULL),
(2, NULL, 'frontend engineer', 'naamche', 'we need a frontend engineer who is fluent in html,css , react and js', '2023-07-02', '2023-07-24', 'open', NULL, NULL, NULL),
(3, 4, 'php backend engineer', 'Bhoos', 'this is the internships for interested students who have basic knowledge of webdev and php programming language', '2023-07-10', '2023-07-31', 'open', NULL, NULL, NULL),
(4, 4, 'Marketing', 'Naamche', 'We need a candidate who can handle the marketing and advertisement of our company products through online platform.', '2023-08-03', '2023-08-23', 'open', '2 months', '$200/months', 'chandragiri-15,Kathmandu'),
(5, 4, 'marketing', 'zzzzzz', 'zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz', '2023-08-03', '2023-08-09', 'open', NULL, NULL, NULL),
(6, 4, 'HR', 'Goodday', 'we need a HR.', '2023-08-02', '2023-08-21', 'open', '2 months', '$100/month', 'Baghbazar,KTM');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `skills` text NOT NULL,
  `department` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `year_of_study` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `user_id`, `name`, `email`, `phone`, `gender`, `skills`, `department`, `dob`, `status`, `year_of_study`, `created_at`) VALUES
(2, 3, 'Binit', 'binitkc17@gmail.com', '9813277080', 'male', 'none', 'computer', '2003-04-30', 'available', '2077', '2023-07-05 06:28:43'),
(3, 5, 'bishal', 'bishal123@gmail.com', '9876543210', 'male', 'master in all skills', 'computer', '2002-09-09', 'available', '2077', '2023-07-05 14:05:29'),
(4, 6, 'anil paudel', 'anil123@gmail.com', '9876543212', 'male', 'master in all tech stack', 'computer', '2004-07-15', 'available', '2076', '2023-07-09 08:42:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `role` enum('student','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`) VALUES
(3, 'binit', 'binit', 'student'),
(4, 'admin', 'admin', 'admin'),
(5, 'bishal', 'bishal', 'student'),
(6, 'anil', 'anil', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `internship_id` (`internship_id`);

--
-- Indexes for table `internships`
--
ALTER TABLE `internships`
  ADD PRIMARY KEY (`internship_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `internships`
--
ALTER TABLE `internships`
  MODIFY `internship_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`internship_id`) REFERENCES `internships` (`internship_id`);

--
-- Constraints for table `internships`
--
ALTER TABLE `internships`
  ADD CONSTRAINT `internships_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
