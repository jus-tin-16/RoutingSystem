-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2024 at 03:00 PM
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
-- Database: `sampledatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `reportFormNo` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT CURRENT_DATE,
  `repSubject` text DEFAULT NULL,
  `images` blob DEFAULT NULL,
  `attach` blob DEFAULT NULL,
  `content` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`reportFormNo`, `date`, `repSubject`, `images`, `attach`, `content`) VALUES
(1, CURRENT_DATE, 'Sample', NULL, NULL, 'Marc Niño Christopher'),
(2, CURRENT_DATE, 'Sample2', NULL, NULL, 'Hello World!'),
(3, CURRENT_DATE, 'Test Report', NULL, NULL, 'Dear [Venue Manager's Name],\r\n\r\nI am writing to seek permission to host a conference at [Gymnasium Name] on [Proposed Date(s)]. Our event aims to bring together industry professionals for knowledge sharing and networking. Here are the key details:\r\n\r\nEvent Date: [Date]\r\nTime: [Start Time] to [End Time]\r\nEstimated Attendees: [Number of Attendees]\r\nPurpose: [Brief Description of Conference Topics]\r\nWe commit to paying any applicable fees and ensuring respectful use of the facility. Your consideration is greatly appreciated.\r\n\r\nThank you for your attention. Please feel free to contact me at [Your Phone Number] or [Your Email Address] for further communication.\r\n\r\nSincerely,\r\n\r\n[Your Full Name] [Your Organization/Company]');

-- --------------------------------------------------------

--
-- Table structure for table `useraccount`
--

CREATE TABLE `useraccount` (
  `userId` int(11) NOT NULL,
  `userName` varchar(50) DEFAULT NULL,
  `userPass` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `useraccount`
--

INSERT INTO `useraccount` (`userId`, `userName`, `userPass`) VALUES
(1, 'justin_a', '12345678'),
(2, '123', 'aldus'),
(3, 'test', '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `userMail` varchar(50) NOT NULL,
  `LastName` text DEFAULT NULL,
  `FirstName` text DEFAULT NULL,
  `middleInitial` text DEFAULT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`userMail`, `LastName`, `FirstName`, `middleInitial`, `userId`) VALUES
('123@sample.com', 'Dolor', 'Lorem', 'I', 2),
('jusitn@gmail.com', 'Aleta', 'Justin Anthony', 'A.', 1),
('test@example.com', 't', 'es', 't', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`reportFormNo`);

--
-- Indexes for table `useraccount`
--
ALTER TABLE `useraccount`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`userMail`),
  ADD KEY `userId` (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `reportFormNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `useraccount`
--
ALTER TABLE `useraccount`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD CONSTRAINT `fk_to_id` FOREIGN KEY (`userId`) REFERENCES `useraccount` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
