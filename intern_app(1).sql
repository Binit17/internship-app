-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 02, 2023 at 12:42 PM
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
(29, 7, 6, '2023-08-02 08:02:56', 'approved'),
(31, 2, 7, '2023-08-02 08:26:21', 'pending'),
(32, 3, 9, '2023-08-02 08:26:44', 'approved'),
(33, 7, 8, '2023-08-02 09:02:54', 'pending'),
(34, 7, 10, '2023-08-02 09:05:23', 'approved');

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
(4, 4, 'Marketing', 'Naamche', 'We need a candidate who can handle the marketing and advertisement of our company products through online platform.', '2023-08-03', '2023-08-23', 'open', '2 months', '$200/months', 'chandragiri-15,Kathmandu'),
(6, 4, 'HR', 'Goodday', 'we need a HR.', '2023-08-02', '2023-08-21', 'open', '2 months', '$100/month', 'Baghbazar,KTM'),
(7, 4, 'Frontend Engineer', 'Naamche', 'This internship offers an excellent opportunity for aspiring web developers to gain hands-on experience in building responsive and dynamic web applications. Interns will work with a talented team, collaborating on various projects using modern web technologies and frameworks.', '2023-08-14', '2023-08-21', 'open', '3 months', '$150/months', 'Putalisadak,Kathmandu'),
(8, 4, 'Machine learning Engineer', 'Smart Data Solution', 'This internship is perfect for individuals passionate about machine learning and artificial intelligence. As a machine learning intern, you will work with a team of experienced data scientists and engineers to develop and deploy cutting-edge machine learning models. You will have the opportunity to gain hands-on experience in data preprocessing, feature engineering, model training, and evaluation.', '2023-08-11', '2023-08-04', 'open', '1 month', 'negotiable', 'chandragiri, Kathmandu'),
(9, 4, 'Graphics Designer', 'Kalka', 'Dive into the world of visual creativity and design with this exciting internship opportunity. Interns will work closely with our design team, contributing to the creation of captivating graphics, branding materials, and marketing collateral that resonate with our target audience.', '2023-08-18', '2023-09-11', 'open', '5 months', '$100/month', 'Chahabil,Kathmandu'),
(10, 4, '.net developer', 'leapfrog', 'random', '2023-08-10', '2023-08-24', 'open', '3 months', '150$', 'pulchowk,kathmandu');

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
  `role` enum('student','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`) VALUES
(3, 'binit', 'binit', 'student'),
(4, 'admin', 'admin', 'admin'),
(5, 'bishal', 'bishal', 'student'),
(6, 'anil', 'anil', 'student'),
(9, 'agrim', 'agrim', 'student');

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
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `internships`
--
ALTER TABLE `internships`
  MODIFY `internship_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
