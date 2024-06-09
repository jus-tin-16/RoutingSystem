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
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `managementaccount`
--

CREATE TABLE `managementaccount` (
  `adminId` int(11) NOT NULL,
  `adminName` varchar(50) DEFAULT NULL,
  `adminPass` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `managementaccount`
--

INSERT INTO `managementaccount` (`adminId`, `adminName`, `adminPass`) VALUES
(1, 'test', '123');

-- --------------------------------------------------------

--
-- Table structure for table `managerinfo`
--

CREATE TABLE `managerinfo` (
  `adminMail` varchar(50) NOT NULL,
  `adminFName` varchar(50) DEFAULT NULL,
  `adminLName` varchar(50) DEFAULT NULL,
  `adminMInitial` varchar(50) DEFAULT NULL,
  `adminId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `managerinfo`
--

INSERT INTO `managerinfo` (`adminMail`, `adminFName`, `adminLName`, `adminMInitial`, `adminId`) VALUES
('test123@example.com', 'ee', 'tt', 'ssyy', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `taskNo` int(11) NOT NULL,
  `crewName` varchar(45) DEFAULT NULL,
  `status` set('new','inprogress','completed') DEFAULT NULL,
  `timeFrame` date DEFAULT NULL,
  `reportNo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`taskNo`, `crewName`, `status`, `timeFrame`, `reportNo`) VALUES
(1, NULL, 'completed', NULL, 1),
(2, NULL, 'inprogress', NULL, 2),
(3, NULL, 'completed', NULL, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `managementaccount`
--
ALTER TABLE `managementaccount`
  ADD PRIMARY KEY (`adminId`);

--
-- Indexes for table `managerinfo`
--
ALTER TABLE `managerinfo`
  ADD PRIMARY KEY (`adminMail`),
  ADD KEY `adminId` (`adminId`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`taskNo`),
  ADD KEY `reportNo` (`reportNo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `managementaccount`
--
ALTER TABLE `managementaccount`
  MODIFY `adminId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `managerinfo`
--
ALTER TABLE `managerinfo`
  MODIFY `adminId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `taskNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `managerinfo`
--
ALTER TABLE `managerinfo`
  ADD CONSTRAINT `fk_to_adminId` FOREIGN KEY (`adminId`) REFERENCES `managementaccount` (`adminId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_to_reportNo` FOREIGN KEY (`reportNo`) REFERENCES `sampledatabase`.`report` (`reportFormNo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
