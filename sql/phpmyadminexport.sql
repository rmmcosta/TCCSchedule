-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 16, 2019 at 07:07 PM
-- Server version: 5.7.26-0ubuntu0.19.04.1
-- PHP Version: 7.2.17-0ubuntu0.19.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `TCCSchedule`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `Id` int(11) NOT NULL,
  `Maker` varchar(50) DEFAULT NULL,
  `Model` varchar(50) DEFAULT NULL,
  `Number` tinyint(4) DEFAULT NULL,
  `Plate` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`Id`, `Maker`, `Model`, `Number`, `Plate`) VALUES
(1, 'vw', 'golf', 1, '50-13-UM'),
(2, 'BMWi', 'Serie 2', 2, '51-13-UX'),
(3, 'Toyota', 'Hiace', 3, '45-16-PZ'),
(4, 'Iveco', 'Daily', 6, '14-YT-54'),
(5, 'Toyota', 'Hiace', 7, '14-78-GH'),
(7, 'Iveco', 'Daily', 9, '50-13-UT');

-- --------------------------------------------------------

--
-- Table structure for table `scheduleCars`
--

CREATE TABLE `scheduleCars` (
  `Id` int(11) NOT NULL,
  `ScheduleId` int(11) NOT NULL,
  `CarId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scheduleCars`
--

INSERT INTO `scheduleCars` (`Id`, `ScheduleId`, `CarId`) VALUES
(26, 27, 4),
(28, 28, 1),
(29, 28, 2),
(30, 29, 1),
(31, 30, 1),
(32, 31, 3),
(33, 32, 1),
(34, 32, 2),
(35, 33, 4),
(36, 33, 5),
(37, 34, 2),
(38, 34, 3),
(39, 35, 5),
(40, 36, 1),
(41, 36, 2),
(44, 26, 3),
(45, 26, 7),
(51, 37, 4),
(52, 37, 5),
(53, 38, 2),
(54, 38, 3),
(59, 40, 3),
(60, 40, 4),
(71, 39, 5),
(72, 39, 7),
(73, 41, 1),
(74, 41, 2),
(75, 41, 3),
(76, 41, 4),
(77, 42, 7),
(78, 43, 5),
(79, 44, 4),
(80, 45, 1),
(81, 46, 1),
(82, 46, 2),
(85, 48, 4),
(86, 48, 5),
(93, 47, 1),
(94, 47, 2),
(97, 49, 1),
(98, 49, 2),
(99, 50, 3),
(100, 50, 7),
(101, 51, 1),
(102, 51, 2),
(103, 52, 5),
(104, 52, 7),
(105, 53, 4),
(106, 53, 5),
(107, 53, 7);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `Id` int(11) NOT NULL,
  `Client` varchar(100) NOT NULL,
  `Start` datetime NOT NULL,
  `End` datetime NOT NULL,
  `Address` varchar(500) NOT NULL,
  `Notes` varchar(1000) DEFAULT NULL,
  `IsCanceled` tinyint(1) DEFAULT NULL,
  `EndAddress` varchar(500) NOT NULL,
  `IsPaid` tinyint(1) DEFAULT NULL,
  `nif` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`Id`, `Client`, `Start`, `End`, `Address`, `Notes`, `IsCanceled`, `EndAddress`, `IsPaid`, `nif`) VALUES
(26, 'Cliente 26', '2019-04-23 23:08:00', '2019-04-25 23:08:00', 'Avenida das ForÃ§as Armadas, 39, 3Âº Esq.', '', 0, '', NULL, '245263674'),
(27, 'Cliente 27', '2019-04-30 23:10:00', '2019-05-01 23:10:00', 'Travessa de Matos, n.115', 'as minhas notas', 1, '', NULL, '245263674'),
(28, 'Cliente 28', '2019-04-10 16:55:00', '2019-04-10 16:55:00', 'Travessa de Matos, n.115', '', NULL, '', NULL, '245263674'),
(29, 'Cliente 29', '2019-04-03 16:55:00', '2019-04-03 16:55:00', '22\r\nPaÃ§o da Rainha', '', 1, '', NULL, '245263674'),
(30, 'Cliente 30', '2019-04-03 16:55:00', '2019-04-03 16:55:00', '22\r\nPaÃ§o da Rainha', '', NULL, '', NULL, '245263674'),
(31, 'Cliente 31', '2019-04-23 16:55:00', '2019-04-23 16:56:00', 'Avenida das ForÃ§as Armadas, 39, 3Âº Esq.', '', 1, '', NULL, '245263674'),
(32, 'Cliente 32', '2019-04-17 18:22:00', '2019-04-17 18:22:00', 'Avenida das ForÃ§as Armadas, 39, 3Âº Esq.', '', 1, '', NULL, '245263674'),
(33, 'Cliente 33', '2019-04-17 18:22:00', '2019-04-17 18:22:00', 'Avenida das ForÃ§as Armadas, 39, 3Âº Esq.', '', 1, '', NULL, '245263674'),
(34, 'Cliente 34', '2019-04-16 18:23:00', '2019-04-16 18:23:00', '22\r\nPaÃ§o da Rainha', '', NULL, '', NULL, '245263674'),
(35, 'Cliente 35', '2019-04-16 18:24:00', '2019-04-16 18:24:00', 'Travessa de Matos, n.115', '', NULL, '', NULL, '245263674'),
(36, 'Cliente 36', '2019-04-20 12:14:00', '2019-04-20 13:14:00', '22\r\nPaÃ§o da Rainha', '', NULL, '', NULL, '245263674'),
(37, 'Costa', '2019-05-04 14:44:00', '2019-05-04 15:44:00', 'Avenida das ForÃ§as Armadas, 39, 3Âº Esq.', '', NULL, 'guimarÃ£es', NULL, '245263674'),
(38, 'Ana', '2019-05-04 14:49:00', '2019-05-04 15:49:00', 'Travessa de Matos, n.115', '', NULL, 'PaÃ§o da Rainha', NULL, '245263674'),
(39, 'JoÃ£o', '2019-05-05 16:00:00', '2019-05-05 20:00:00', 'Avenida das ForÃ§as Armadas, 39, 3Âº Esq.', '', NULL, 'PaÃ§o da rainha', NULL, '245263674'),
(40, 'Aloisio', '2019-05-05 13:00:00', '2019-05-05 17:00:00', 'Avenida das ForÃ§as Armadas, 39, 3Âº Esq.', '', NULL, 'Torres Vedras', NULL, '245263674'),
(41, 'John', '2019-05-05 20:30:00', '2019-05-05 23:00:00', 'Avenida das ForÃ§as Armadas, 39, 3Âº Esq.', '', NULL, 'aveiro', NULL, '245263674'),
(42, 'Hospital do Algarve', '2019-05-05 20:14:00', '2019-05-06 20:14:00', 'Avenida das ForÃ§as Armadas, 39, 3Âº Esq.', '', NULL, 'Algarve', NULL, '245263674'),
(43, 'Carlos', '2019-05-06 11:00:00', '2019-05-06 14:30:00', 'Travessa de Matos, n.115', '', NULL, 'Lisboa', NULL, '245263674'),
(44, 'Espanhol', '2019-05-06 10:00:00', '2019-05-06 17:00:00', '22\r\nPaÃ§o da Rainha', '', NULL, 'Espanha', NULL, '245263674'),
(45, 'FranciÃº', '2019-05-06 10:00:00', '2019-05-06 12:00:00', 'Avenida das ForÃ§as Armadas, 39, 3Âº Esq.', '', NULL, 'FranÃ§a', NULL, '245263674'),
(46, 'NÃ£o pago', '2019-05-06 15:30:00', '2019-05-06 18:00:00', 'Avenida das ForÃ§as Armadas, 39, 3Âº Esq.', '', NULL, 'Nenhures', NULL, '245263674'),
(47, 'Jonas', '2019-05-12 11:00:00', '2019-05-12 16:00:00', 'Avenida das ForÃ§as Armadas, 39, 3Âº Esq.', '', NULL, 'FamalicÃ£o', 1, '545263674'),
(48, 'Ana', '2019-05-13 11:00:00', '2019-05-13 18:00:00', '22\r\nPaÃ§o da Rainha', '', NULL, 'Braga', NULL, '245263674'),
(49, 'Johnson', '2019-05-13 18:45:00', '2019-05-13 19:46:00', 'Avenida das ForÃ§as Armadas, 39, 3Âº Esq.', '', NULL, 'qualquer sitio', 0, '234567890'),
(50, 'Baixinho', '2019-05-13 09:47:00', '2019-05-13 14:47:00', 'Travessa de Matos, n.115', '', NULL, 'Set+ubal', 0, '123456789'),
(51, 'Admilson', '2019-05-14 18:48:00', '2019-05-14 20:48:00', 'Faro', '', NULL, 'quarteira', 0, '987654321'),
(52, 'Juliano', '2019-05-14 13:48:00', '2019-05-14 18:49:00', 'Torres Vedras', '', NULL, 'Lisboa', 0, '345678123'),
(53, 'RÃ©', '2019-05-15 13:49:00', '2019-05-15 18:49:00', 'Aveiro', '', NULL, 'Braga', 0, '654732812');

-- --------------------------------------------------------

--
-- Table structure for table `scheduleWorkers`
--

CREATE TABLE `scheduleWorkers` (
  `Id` int(11) NOT NULL,
  `ScheduleId` int(11) NOT NULL,
  `WorkerId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scheduleWorkers`
--

INSERT INTO `scheduleWorkers` (`Id`, `ScheduleId`, `WorkerId`) VALUES
(23, 27, 1),
(24, 28, 2),
(25, 29, 1),
(26, 30, 1),
(27, 31, 2),
(28, 32, 1),
(29, 32, 2),
(30, 33, 1),
(31, 33, 2),
(32, 34, 1),
(33, 35, 2),
(34, 36, 1),
(35, 26, 3),
(39, 37, 3),
(40, 38, 2),
(43, 40, 2),
(49, 39, 1),
(50, 41, 3),
(51, 41, 2),
(52, 42, 1),
(53, 42, 3),
(54, 43, 2),
(55, 44, 2),
(56, 45, 4),
(57, 46, 4),
(60, 48, 4),
(61, 48, 3),
(68, 47, 1),
(69, 47, 4),
(71, 49, 1),
(72, 50, 1),
(73, 51, 1),
(74, 51, 4),
(75, 52, 3),
(76, 53, 1),
(77, 53, 4),
(78, 53, 3);

-- --------------------------------------------------------

--
-- Table structure for table `workers`
--

CREATE TABLE `workers` (
  `Id` int(11) NOT NULL,
  `Name` varchar(250) NOT NULL,
  `Phone` varchar(9) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `workers`
--

INSERT INTO `workers` (`Id`, `Name`, `Phone`, `Email`) VALUES
(1, 'Ana Ramos', '966945019', 'amdr33@gmail.com'),
(2, 'Ricardo Costa', '914423167', 'ricardocosta101085@gmail.com'),
(3, 'Pedro Ramos', '966945123', 'pedrodias.r@gmail.com'),
(4, 'Carlos Infante', '120', 'ci@xpot.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Plate` (`Plate`);

--
-- Indexes for table `scheduleCars`
--
ALTER TABLE `scheduleCars`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_scheduleCars_1_idx` (`ScheduleId`),
  ADD KEY `fk_scheduleCars_2_idx` (`CarId`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `scheduleWorkers`
--
ALTER TABLE `scheduleWorkers`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_scheduleWorkers_1_idx` (`ScheduleId`),
  ADD KEY `fk_scheduleWorkers_2_idx` (`WorkerId`);

--
-- Indexes for table `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `scheduleCars`
--
ALTER TABLE `scheduleCars`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;
--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `scheduleWorkers`
--
ALTER TABLE `scheduleWorkers`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT for table `workers`
--
ALTER TABLE `workers`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `scheduleCars`
--
ALTER TABLE `scheduleCars`
  ADD CONSTRAINT `fk_scheduleCars_1` FOREIGN KEY (`ScheduleId`) REFERENCES `schedules` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_scheduleCars_2` FOREIGN KEY (`CarId`) REFERENCES `cars` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `scheduleWorkers`
--
ALTER TABLE `scheduleWorkers`
  ADD CONSTRAINT `fk_scheduleWorkers_1` FOREIGN KEY (`ScheduleId`) REFERENCES `schedules` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_scheduleWorkers_2` FOREIGN KEY (`WorkerId`) REFERENCES `workers` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;