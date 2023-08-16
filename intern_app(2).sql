-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 16, 2023 at 05:08 AM
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
  `status` enum('pending','approved','disapproved') DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`application_id`, `student_id`, `internship_id`, `application_date`, `status`, `company_id`) VALUES
(35, 7, 16, '2023-08-02 14:34:13', 'approved', 1),
(36, 2, 17, '2023-08-15 16:10:47', 'approved', 2),
(39, 2, 16, '2023-08-16 02:55:13', 'pending', 1);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_person` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `website` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `user_id`, `name`, `address`, `contact_person`, `email`, `phone`, `website`, `created_at`) VALUES
(1, 14, 'bhoooos', 'Sanepa,Kathmandu', 'Mr. Agreem Karki', 'bhoooos@gmail.com', '9878787787', 'https://bhoooos.com', '2023-08-02 12:01:53'),
(2, 15, 'digital', 'pulchowk,kathmandu', 'Mr. Hari', 'digital@gmail.com', '9878787878', 'https://digital.com', '2023-08-15 16:07:22');

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
  `location` varchar(50) DEFAULT NULL,
  `company_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `internships`
--

INSERT INTO `internships` (`internship_id`, `admin_id`, `title`, `company_name`, `description`, `start_date`, `end_date`, `status`, `duration`, `salary`, `location`, `company_id`) VALUES
(16, 4, 'php backend engineer', 'bhoooos', 'hello', '2023-08-19', '2023-08-26', 'open', '1 month', '100$', 'kathmandu', 1),
(17, 4, 'marketing', 'digital', 'student should have a sound knowledge on digital marketing', '2023-08-16', '2023-08-28', 'open', '5 months', '500$', 'Dhobighat,Kathmandu', 2),
(19, 4, 'Backend Engineer', 'digital', 'Should have sound knowledge of django, python, APIs, mongoDB ', '2023-08-18', '2023-08-23', 'open', '5 months', '200$', 'Baghbazar,KTM', 2);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_picture` varchar(255) DEFAULT NULL,
  `cv` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `user_id`, `name`, `email`, `phone`, `gender`, `skills`, `department`, `dob`, `status`, `year_of_study`, `created_at`, `profile_picture`, `cv`) VALUES
(2, 3, 'Binit', 'binitkc17@gmail.com', '9813277080', 'male', 'none', 'computer', '2003-04-30', 'available', '2077', '2023-07-05 06:28:43', NULL, NULL),
(3, 5, 'bishal', 'bishal123@gmail.com', '9876543210', 'male', 'master in all skills', 'computer', '2002-09-09', 'available', '2077', '2023-07-05 14:05:29', 'uploads/profile_pictures/bishal.jpg', 'uploads/cv/cv.png'),
(4, 6, 'anil paudel', 'anil123@gmail.com', '9876543212', 'female', 'master in all tech stack and management and all.', 'computer', '2004-07-15', 'available', '2076', '2023-07-09 08:42:41', 'uploads/profile_pictures/wallpaperflare.com_wallpaper(8).jpg', 'uploads/cv/wallpaperflare.com_wallpaper(1).jpg'),
(7, 9, 'Agrim Paneru', 'agrim008@gmail.com', '987654241', 'male', 'machine learning, deep learning, artificial intelligence', 'Computer', '1998-08-13', 'available', '2079', '2023-08-02 08:00:50', 'uploads/profile_pictures/anil.jpg', 'uploads/cv/cv.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `role` enum('student','admin','company') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`) VALUES
(3, 'binit', 'binit', 'student'),
(4, 'admin', 'admin', 'admin'),
(5, 'bishal', 'bishal', 'student'),
(6, 'anil', 'anil', 'student'),
(9, 'agrim', 'agrim', 'student'),
(14, 'bhoooos', 'bhoooos', 'company'),
(15, 'digital', 'digital', 'company');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `internship_id` (`internship_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `internships`
--
ALTER TABLE `internships`
  ADD PRIMARY KEY (`internship_id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `fk_company_id` (`company_id`);

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
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `internships`
--
ALTER TABLE `internships`
  MODIFY `internship_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`internship_id`) REFERENCES `internships` (`internship_id`),
  ADD CONSTRAINT `applications_ibfk_3` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`);

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `company_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `internships`
--
ALTER TABLE `internships`
  ADD CONSTRAINT `fk_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
