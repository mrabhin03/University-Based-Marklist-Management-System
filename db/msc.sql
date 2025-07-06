-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2025 at 06:41 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `msc`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `CourseCode` varchar(20) NOT NULL,
  `CourseName` text NOT NULL,
  `Credit` int(11) NOT NULL DEFAULT 4,
  `CourseType` enum('Theory','Practical') DEFAULT NULL,
  `ProgramID` int(11) NOT NULL,
  `Semester` int(11) NOT NULL
) ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`CourseCode`, `CourseName`, `Credit`, `CourseType`, `ProgramID`, `Semester`) VALUES
('CA010101', 'Advanced Web Technology', 4, 'Theory', 1, 1),
('CA010102', 'Operating Systems', 4, 'Theory', 1, 1),
('CA010103', 'Lab - I (Java & PHP)', 4, 'Practical', 1, 1),
('CA500101', 'Computational Mathematics', 4, 'Theory', 1, 1),
('CA500102', 'Advanced Java Programming', 4, 'Theory', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `examattender`
--

CREATE TABLE `examattender` (
  `AttID` int(11) NOT NULL,
  `PRN` bigint(13) NOT NULL,
  `ExamID` int(11) NOT NULL,
  `ExamCenterID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examattender`
--

INSERT INTO `examattender` (`AttID`, `PRN`, `ExamID`, `ExamCenterID`) VALUES
(1, 20011023, 1, 1),
(2, 20011024, 1, 1),
(3, 20011025, 1, 1),
(4, 20011026, 1, 1),
(5, 20011027, 1, 1),
(6, 20011028, 1, 1),
(7, 20011029, 1, 1),
(8, 20011030, 1, 1),
(9, 20011031, 1, 1),
(10, 20011032, 1, 1),
(11, 20011033, 1, 1),
(12, 20011034, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `examcenter`
--

CREATE TABLE `examcenter` (
  `ExamCenterID` int(11) NOT NULL,
  `ExamCenter` text NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examcenter`
--

INSERT INTO `examcenter` (`ExamCenterID`, `ExamCenter`, `Status`) VALUES
(1, 'College 1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `ExamID` int(11) NOT NULL,
  `ExamName` text NOT NULL,
  `Semester` int(11) NOT NULL,
  `ProgramID` int(11) NOT NULL,
  `AcademicYear` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`ExamID`, `ExamName`, `Semester`, `ProgramID`, `AcademicYear`) VALUES
(1, 'FIRST SEMESTER PG EXAMINATION DECEMBER 2024', 1, 1, '2024-26');

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `MarkID` int(11) NOT NULL,
  `AttID` int(11) NOT NULL,
  `CourseCode` varchar(20) NOT NULL,
  `INTS` decimal(10,2) NOT NULL,
  `EXT` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`MarkID`, `AttID`, `CourseCode`, `INTS`, `EXT`) VALUES
(1, 1, 'CA010101', 5.00, 2.83),
(2, 1, 'CA010102', 4.80, 2.97),
(3, 1, 'CA010103', 5.00, 5.00),
(4, 1, 'CA500101', 4.60, 3.47),
(5, 1, 'CA500102', 5.00, 3.90),
(6, 2, 'CA010101', 4.00, 2.27),
(7, 2, 'CA010102', 3.60, 0.30),
(8, 2, 'CA010103', 4.60, 5.00),
(9, 2, 'CA500101', 3.60, 2.00),
(10, 2, 'CA500102', 3.80, 1.37),
(11, 3, 'CA010101', 4.40, 2.23),
(12, 3, 'CA010102', 4.40, 2.27),
(13, 3, 'CA010103', 4.60, 3.20),
(14, 3, 'CA500101', 3.40, 3.03),
(15, 3, 'CA500102', 3.60, 2.23),
(16, 4, 'CA010101', 4.00, 1.60),
(17, 4, 'CA010102', 3.80, 2.33),
(18, 4, 'CA010103', 4.60, 2.93),
(19, 4, 'CA500101', 3.80, 2.20),
(20, 4, 'CA500102', 4.00, 2.00),
(21, 5, 'CA500102', 4.00, 2.00),
(22, 5, 'CA500101', 4.00, 2.03),
(23, 5, 'CA010103', 4.80, 3.20),
(24, 5, 'CA010102', 4.00, 2.03),
(25, 5, 'CA010101', 4.80, 2.03),
(26, 6, 'CA500102', 5.00, 3.53),
(27, 6, 'CA500101', 5.00, 4.37),
(28, 6, 'CA010103', 5.00, 5.00),
(29, 6, 'CA010102', 5.00, 3.20),
(30, 6, 'CA010101', 5.00, 3.37),
(31, 7, 'CA500102', 3.80, 2.30),
(32, 7, 'CA500101', 4.00, 2.80),
(33, 7, 'CA010103', 4.60, 3.27),
(34, 7, 'CA010101', 4.00, 2.40),
(35, 7, 'CA010102', 3.80, 2.00),
(36, 8, 'CA010101', 4.00, 2.30),
(37, 8, 'CA010102', 4.00, 2.67),
(38, 8, 'CA010103', 4.60, 4.67),
(39, 8, 'CA500101', 3.80, 3.23),
(40, 8, 'CA500102', 4.00, 2.13),
(41, 9, 'CA500102', 4.60, 2.10),
(42, 9, 'CA500101', 4.40, 2.00),
(43, 9, 'CA010103', 4.60, 4.07),
(44, 9, 'CA010102', 4.20, 2.03),
(45, 9, 'CA010101', 4.60, 2.77),
(46, 10, 'CA010101', 5.00, 3.13),
(47, 10, 'CA010102', 5.00, 3.33),
(48, 10, 'CA010103', 5.00, 4.67),
(49, 10, 'CA500101', 4.80, 3.57),
(50, 10, 'CA500102', 4.80, 3.40),
(51, 11, 'CA500102', 3.60, 1.37),
(52, 11, 'CA500101', 3.40, 0.93),
(53, 11, 'CA010103', 4.00, 2.33),
(54, 11, 'CA010102', 3.60, 0.20),
(55, 11, 'CA010101', 3.60, 1.13),
(56, 12, 'CA500102', 4.00, 2.00),
(57, 12, 'CA500101', 4.00, 2.33),
(58, 12, 'CA010103', 4.00, 4.40),
(59, 12, 'CA010102', 4.00, 2.00),
(60, 12, 'CA010101', 4.00, 2.23);

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `ProgramID` int(11) NOT NULL,
  `ProgramName` text NOT NULL,
  `TotalSemesters` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`ProgramID`, `ProgramName`, `TotalSemesters`) VALUES
(1, 'MSc COMPUTER SCIENCE', 4);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `PRN` bigint(13) NOT NULL,
  `Name` varchar(250) NOT NULL,
  `ProgramID` int(11) NOT NULL,
  `AcademicYear` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`PRN`, `Name`, `ProgramID`, `AcademicYear`) VALUES
(20011023, 'StudentName1', 1, '2024-26'),
(20011024, 'StudentName2', 1, '2024-26'),
(20011025, 'StudentName3', 1, '2024-26'),
(20011026, 'StudentName4', 1, '2024-26'),
(20011027, 'StudentName5', 1, '2024-26'),
(20011028, 'StudentName6', 1, '2024-26'),
(20011029, 'StudentName7', 1, '2024-26'),
(20011030, 'StudentName8', 1, '2024-26'),
(20011031, 'StudentName9', 1, '2024-26'),
(20011032, 'StudentName10', 1, '2024-26'),
(20011033, 'StudentName11', 1, '2024-26'),
(20011034, 'StudentName12', 1, '2024-26');

-- --------------------------------------------------------

--
-- Table structure for table `theadmin`
--

CREATE TABLE `theadmin` (
  `Username` varchar(50) NOT NULL,
  `Password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `theadmin`
--

INSERT INTO `theadmin` (`Username`, `Password`) VALUES
('superadmin', 'User@123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`CourseCode`),
  ADD KEY `ProgramID` (`ProgramID`);

--
-- Indexes for table `examattender`
--
ALTER TABLE `examattender`
  ADD PRIMARY KEY (`AttID`),
  ADD KEY `PRN` (`PRN`),
  ADD KEY `ExamID` (`ExamID`),
  ADD KEY `ExamCenterID` (`ExamCenterID`);

--
-- Indexes for table `examcenter`
--
ALTER TABLE `examcenter`
  ADD PRIMARY KEY (`ExamCenterID`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`ExamID`),
  ADD KEY `ProgramID` (`ProgramID`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`MarkID`),
  ADD KEY `FKCode` (`CourseCode`),
  ADD KEY `FKATT` (`AttID`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`ProgramID`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`PRN`),
  ADD KEY `ProgramID` (`ProgramID`);

--
-- Indexes for table `theadmin`
--
ALTER TABLE `theadmin`
  ADD PRIMARY KEY (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `examattender`
--
ALTER TABLE `examattender`
  MODIFY `AttID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `examcenter`
--
ALTER TABLE `examcenter`
  MODIFY `ExamCenterID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `ExamID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `MarkID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `program`
--
ALTER TABLE `program`
  MODIFY `ProgramID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`ProgramID`) REFERENCES `program` (`ProgramID`);

--
-- Constraints for table `examattender`
--
ALTER TABLE `examattender`
  ADD CONSTRAINT `examattender_ibfk_1` FOREIGN KEY (`PRN`) REFERENCES `students` (`PRN`),
  ADD CONSTRAINT `examattender_ibfk_2` FOREIGN KEY (`ExamID`) REFERENCES `exams` (`ExamID`),
  ADD CONSTRAINT `examattender_ibfk_3` FOREIGN KEY (`ExamCenterID`) REFERENCES `examcenter` (`ExamCenterID`);

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_ibfk_1` FOREIGN KEY (`ProgramID`) REFERENCES `program` (`ProgramID`);

--
-- Constraints for table `marks`
--
ALTER TABLE `marks`
  ADD CONSTRAINT `FKATT` FOREIGN KEY (`AttID`) REFERENCES `examattender` (`AttID`),
  ADD CONSTRAINT `FKCode` FOREIGN KEY (`CourseCode`) REFERENCES `course` (`CourseCode`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`ProgramID`) REFERENCES `program` (`ProgramID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
