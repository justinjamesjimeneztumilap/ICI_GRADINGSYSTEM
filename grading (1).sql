-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2026 at 12:42 AM
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
-- Database: `grading`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `admins`
-- (See below for the actual view)
--
CREATE TABLE `admins` (
`user_id` int(11)
,`name` varchar(255)
,`email` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `strands`
--

CREATE TABLE `strands` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `strands`
--

INSERT INTO `strands` (`id`, `name`, `description`) VALUES
(1, 'TVL', 'Technical Vocational Livelihood'),
(2, 'STEM', 'Science, Technology, Engineering, Math'),
(3, 'ABM', 'Accountancy, Business, Management'),
(4, 'HUMSS', 'Humanities and Social Sciences');

-- --------------------------------------------------------

--
-- Table structure for table `strand_assignments`
--

CREATE TABLE `strand_assignments` (
  `id` int(11) NOT NULL,
  `strand_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `strand_assignments`
--

INSERT INTO `strand_assignments` (`id`, `strand_id`, `student_id`, `teacher_id`) VALUES
(1, 1, 1, NULL),
(2, 2, 0, 2),
(3, 4, NULL, 2),
(4, 3, 1, 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `students`
-- (See below for the actual view)
--
CREATE TABLE `students` (
`user_id` int(11)
,`name` varchar(255)
,`email` varchar(255)
,`strand_name` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `teachers`
-- (See below for the actual view)
--
CREATE TABLE `teachers` (
`user_id` int(11)
,`name` varchar(255)
,`email` varchar(255)
,`strand_name` varchar(50)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','teacher','admin') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `password`, `role`, `created_at`) VALUES
(1, 'justin@gmail.com', 'Justin', '123123', 'student', '2026-01-29 08:04:12'),
(2, 'erleauric@ici.edu.ph', 'Erle Auric', '123123', 'teacher', '2026-01-29 09:06:49');

-- --------------------------------------------------------

--
-- Structure for view `admins`
--
DROP TABLE IF EXISTS `admins`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `admins`  AS SELECT `users`.`id` AS `user_id`, `users`.`name` AS `name`, `users`.`email` AS `email` FROM `users` WHERE `users`.`role` = 'admin' ;

-- --------------------------------------------------------

--
-- Structure for view `students`
--
DROP TABLE IF EXISTS `students`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `students`  AS SELECT `u`.`id` AS `user_id`, `u`.`name` AS `name`, `u`.`email` AS `email`, `s`.`name` AS `strand_name` FROM ((`users` `u` left join `strand_assignments` `sa` on(`sa`.`student_id` = `u`.`id`)) left join `strands` `s` on(`sa`.`strand_id` = `s`.`id`)) WHERE `u`.`role` = 'student' ;

-- --------------------------------------------------------

--
-- Structure for view `teachers`
--
DROP TABLE IF EXISTS `teachers`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `teachers`  AS SELECT `u`.`id` AS `user_id`, `u`.`name` AS `name`, `u`.`email` AS `email`, `s`.`name` AS `strand_name` FROM ((`users` `u` left join `strand_assignments` `sa` on(`sa`.`teacher_id` = `u`.`id`)) left join `strands` `s` on(`sa`.`strand_id` = `s`.`id`)) WHERE `u`.`role` = 'teacher' ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `strands`
--
ALTER TABLE `strands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `strand_assignments`
--
ALTER TABLE `strand_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_assignment_strand` (`strand_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `strands`
--
ALTER TABLE `strands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `strand_assignments`
--
ALTER TABLE `strand_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `strand_assignments`
--
ALTER TABLE `strand_assignments`
  ADD CONSTRAINT `fk_assignment_strand` FOREIGN KEY (`strand_id`) REFERENCES `strands` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
