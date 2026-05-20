-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2025 at 08:01 AM
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
-- Database: `result_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses_tb`
--

CREATE TABLE `courses_tb` (
  `id` int(11) NOT NULL,
  `course_title` varchar(200) NOT NULL,
  `course_code` varchar(100) NOT NULL,
  `course_unit` varchar(50) NOT NULL,
  `dept` varchar(200) NOT NULL,
  `faculty` varchar(200) NOT NULL,
  `level` varchar(100) NOT NULL,
  `semester` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses_tb`
--

INSERT INTO `courses_tb` (`id`, `course_title`, `course_code`, `course_unit`, `dept`, `faculty`, `level`, `semester`, `date`) VALUES
(106, 'Computer Science 1', 'CSC 101', '3', 'Computer Science', 'Science', '100', 'First Semester', '2025-04-28 13:58:32'),
(107, 'Computer Science 2', 'CSC 102', '3', 'Computer Science', 'Science', '100', 'Second Semester', '2025-04-28 17:26:58'),
(108, 'General Mathematics 1', 'MTH 101', '3', 'Computer Science', 'Science', '100', 'First Semester', '2025-04-28 17:21:49'),
(109, 'General Mathematics 2', 'MTH 102', '3', 'Computer Science', 'Science', '100', 'Second Semester', '2025-04-28 17:27:12'),
(110, 'Integral Mathematics', 'MTH 103', '3', 'Computer Science', 'Science', '100', 'First Semester', '2025-04-28 17:22:40'),
(111, 'Biology 1', 'BIO 101', '3', 'Computer Science', 'Science', '100', 'First Semester', '2025-04-28 17:24:42'),
(112, 'General Physics 1', 'PHY 101', '3', 'Computer Science', 'Science', '100', 'First Semester', '2025-04-28 17:27:54'),
(113, 'General Physics Lab 1', 'PHY 107', '1', 'Computer Science', 'Science', '100', 'First Semester', '2025-04-28 17:28:16'),
(114, 'General Chemistry', 'CHM 101', '4', 'Computer Science', 'Science', '100', 'First Semester', '2025-04-28 17:29:07'),
(115, 'General Biology 2', 'BIO 102', '4', 'Computer Science', 'Science', '100', 'Second Semester', '2025-04-28 17:29:51'),
(116, 'Electricity Mordern Phy', 'PHY 102', '3', 'Computer Science', 'Science', '100', 'Second Semester', '2025-04-28 17:30:48'),
(117, 'General Physics Lab 2', 'PHY 108', '1', 'Computer Science', 'Science', '100', 'Second Semester', '2025-04-28 17:31:24');

-- --------------------------------------------------------

--
-- Table structure for table `course_advisor_tb`
--

CREATE TABLE `course_advisor_tb` (
  `id` int(11) NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `email` varchar(250) NOT NULL,
  `school_id` varchar(100) DEFAULT NULL,
  `faculty` varchar(200) NOT NULL,
  `password` longtext NOT NULL,
  `image` text DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_advisor_tb`
--

INSERT INTO `course_advisor_tb` (`id`, `fname`, `lname`, `email`, `school_id`, `faculty`, `password`, `image`, `date`) VALUES
(27, 'John', 'Greyson', 'johnmavis660@gmail.com', '123123', 'Science', '$2y$12$31EFAeVbfYP7zJFSBpDwO.n6E0yklv62cvsV3QPzdvsx3iOc4ck..', NULL, '2025-04-28 10:31:53');

-- --------------------------------------------------------

--
-- Table structure for table `dept_faculty_tb`
--

CREATE TABLE `dept_faculty_tb` (
  `id` int(11) NOT NULL,
  `department` text NOT NULL,
  `faculty` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dept_faculty_tb`
--

INSERT INTO `dept_faculty_tb` (`id`, `department`, `faculty`) VALUES
(1, 'Chemical Science', 'Science'),
(2, 'Biochemistry', 'Science'),
(3, 'Computer Science', 'Science'),
(4, 'Microbiology', 'Science');

-- --------------------------------------------------------

--
-- Table structure for table `hod_tb`
--

CREATE TABLE `hod_tb` (
  `id` int(11) NOT NULL,
  `fname` varchar(200) NOT NULL,
  `lname` varchar(200) NOT NULL,
  `email` varchar(150) NOT NULL,
  `image` text DEFAULT NULL,
  `faculty` varchar(50) NOT NULL,
  `school_id` varchar(50) NOT NULL,
  `password` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hod_tb`
--

INSERT INTO `hod_tb` (`id`, `fname`, `lname`, `email`, `image`, `faculty`, `school_id`, `password`) VALUES
(3, 'Dr', 'AJ', 'johnmavis660@gmail.com', NULL, 'Science', '123456', '$2y$12$Idm7izybkuUkPp2aNmvOBehAVzQouMXn18FfhWD27.E4yolPEKJh2');

-- --------------------------------------------------------

--
-- Table structure for table `pwd_reset_tb`
--

CREATE TABLE `pwd_reset_tb` (
  `id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `token` text NOT NULL,
  `expires` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `results_tb`
--

CREATE TABLE `results_tb` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `school_id` varchar(150) NOT NULL,
  `course_title` varchar(100) NOT NULL,
  `course_code` varchar(130) NOT NULL,
  `course_unit` int(6) NOT NULL,
  `level` varchar(150) NOT NULL,
  `dept` varchar(200) NOT NULL,
  `faculty` varchar(200) NOT NULL,
  `semester` text NOT NULL,
  `session` text NOT NULL,
  `obj` int(11) DEFAULT NULL,
  `q1` int(11) DEFAULT NULL,
  `q2` int(11) DEFAULT NULL,
  `q3` int(11) DEFAULT NULL,
  `q4` int(11) DEFAULT NULL,
  `q5` int(11) DEFAULT NULL,
  `q6` int(11) DEFAULT NULL,
  `ca` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `grade_points` int(11) NOT NULL,
  `quality_points` int(11) NOT NULL,
  `grade` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(150) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results_tb`
--

INSERT INTO `results_tb` (`id`, `name`, `school_id`, `course_title`, `course_code`, `course_unit`, `level`, `dept`, `faculty`, `semester`, `session`, `obj`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `ca`, `total`, `grade_points`, `quality_points`, `grade`, `date`, `status`) VALUES
(394, 'John Doe', 'NS/CS/19/0509', 'Computer Science 1', 'CSC 101', 3, '100', 'Computer Science', 'Science', 'First Semester', '2021/2022', 13, 10, 10, 20, 0, 0, 0, 30, 83, 5, 15, 'A', '2025-04-28 17:16:39', 'approved'),
(395, 'John Doe', 'NS/CS/19/0509', 'General Mathematics 1', 'MTH 101', 3, '100', 'Computer Science', 'Science', 'First Semester', '2021/2022', 10, 10, 10, 10, 0, 0, 0, 10, 50, 3, 9, 'C', '2025-04-28 17:50:42', 'approved'),
(396, 'John Doe', 'NS/CS/19/0509', 'Integral Mathematics', 'MTH 103', 3, '100', 'Computer Science', 'Science', 'First Semester', '2021/2022', 10, 10, 10, 0, 0, 0, 0, 10, 40, 1, 3, 'E', '2025-04-28 17:50:45', 'approved'),
(397, 'John Doe', 'NS/CS/19/0509', 'Biology 1', 'BIO 101', 3, '100', 'Computer Science', 'Science', 'First Semester', '2021/2022', 10, 10, 10, 0, 10, 10, 10, 10, 70, 5, 15, 'A', '2025-04-28 17:50:47', 'approved'),
(398, 'John Doe', 'NS/CS/19/0509', 'General Physics 1', 'PHY 101', 3, '100', 'Computer Science', 'Science', 'First Semester', '2021/2022', 10, 10, 10, 0, 10, 10, 10, 10, 70, 5, 15, 'A', '2025-04-28 17:50:50', 'approved'),
(399, 'John Doe', 'NS/CS/19/0509', 'General Physics Lab 1', 'PHY 107', 1, '100', 'Computer Science', 'Science', 'First Semester', '2021/2022', 0, 0, 10, 0, 10, 0, 10, 10, 40, 1, 1, 'E', '2025-04-28 17:50:53', 'approved'),
(400, 'John Doe', 'NS/CS/19/0509', 'General Chemistry', 'CHM 101', 4, '100', 'Computer Science', 'Science', 'First Semester', '2021/2022', 0, 0, 10, 0, 10, 0, 10, 10, 40, 1, 4, 'E', '2025-04-28 17:50:55', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `students_tb`
--

CREATE TABLE `students_tb` (
  `id` int(11) NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `school_id` varchar(100) NOT NULL,
  `level` int(11) NOT NULL,
  `faculty` varchar(200) DEFAULT NULL,
  `dept` varchar(200) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `password` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students_tb`
--

INSERT INTO `students_tb` (`id`, `fname`, `lname`, `email`, `school_id`, `level`, `faculty`, `dept`, `image`, `password`, `date`) VALUES
(93, 'John', 'Doe', 'mavisdev208@gmail.com', 'NS/CS/19/0509', 100, 'Science', 'Computer Science', 'students1745836140.webp', '$2y$12$VpdBc1z9jdgnPnrjFTwUzegMumYKCrJgS8.rQ.dNHaaNamxkj5l8u', '2025-04-28 10:19:47');

-- --------------------------------------------------------

--
-- Table structure for table `student_courses_tb`
--

CREATE TABLE `student_courses_tb` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `school_id` varchar(200) NOT NULL,
  `course_title` varchar(200) NOT NULL,
  `course_code` varchar(200) NOT NULL,
  `course_unit` int(6) NOT NULL,
  `is_carry_over` varchar(100) DEFAULT 'No',
  `level` varchar(200) NOT NULL,
  `semester` varchar(200) NOT NULL,
  `session` varchar(200) NOT NULL,
  `dept` varchar(200) NOT NULL,
  `faculty` varchar(200) NOT NULL,
  `result_computed` varchar(6) NOT NULL DEFAULT '0',
  `is_dropped` varchar(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_courses_tb`
--

INSERT INTO `student_courses_tb` (`id`, `name`, `school_id`, `course_title`, `course_code`, `course_unit`, `is_carry_over`, `level`, `semester`, `session`, `dept`, `faculty`, `result_computed`, `is_dropped`, `date`) VALUES
(237, 'John Doe', 'NS/CS/19/0509', 'Computer Science 1', 'CSC 101', 3, 'No', '100', 'First Semester', '2021/2022', 'Computer Science', 'Science', '1', '0', '2025-04-28 17:13:17'),
(238, 'John Doe', 'NS/CS/19/0509', 'General Mathematics 1', 'MTH 101', 3, 'No', '100', 'First Semester', '2021/2022', 'Computer Science', 'Science', '1', '0', '2025-04-28 17:49:36'),
(239, 'John Doe', 'NS/CS/19/0509', 'Integral Mathematics', 'MTH 103', 3, 'No', '100', 'First Semester', '2021/2022', 'Computer Science', 'Science', '1', '0', '2025-04-28 17:49:44'),
(240, 'John Doe', 'NS/CS/19/0509', 'Biology 1', 'BIO 101', 3, 'No', '100', 'First Semester', '2021/2022', 'Computer Science', 'Science', '1', '0', '2025-04-28 17:50:01'),
(241, 'John Doe', 'NS/CS/19/0509', 'General Physics 1', 'PHY 101', 3, 'No', '100', 'First Semester', '2021/2022', 'Computer Science', 'Science', '1', '0', '2025-04-28 17:50:08'),
(242, 'John Doe', 'NS/CS/19/0509', 'General Physics Lab 1', 'PHY 107', 1, 'No', '100', 'First Semester', '2021/2022', 'Computer Science', 'Science', '1', '0', '2025-04-28 17:50:17'),
(243, 'John Doe', 'NS/CS/19/0509', 'General Chemistry', 'CHM 101', 4, 'No', '100', 'First Semester', '2021/2022', 'Computer Science', 'Science', '1', '0', '2025-04-28 17:50:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses_tb`
--
ALTER TABLE `courses_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_advisor_tb`
--
ALTER TABLE `course_advisor_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dept_faculty_tb`
--
ALTER TABLE `dept_faculty_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hod_tb`
--
ALTER TABLE `hod_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pwd_reset_tb`
--
ALTER TABLE `pwd_reset_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results_tb`
--
ALTER TABLE `results_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students_tb`
--
ALTER TABLE `students_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_courses_tb`
--
ALTER TABLE `student_courses_tb`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses_tb`
--
ALTER TABLE `courses_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `course_advisor_tb`
--
ALTER TABLE `course_advisor_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `dept_faculty_tb`
--
ALTER TABLE `dept_faculty_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hod_tb`
--
ALTER TABLE `hod_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pwd_reset_tb`
--
ALTER TABLE `pwd_reset_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `results_tb`
--
ALTER TABLE `results_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=401;

--
-- AUTO_INCREMENT for table `students_tb`
--
ALTER TABLE `students_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `student_courses_tb`
--
ALTER TABLE `student_courses_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
