-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2024 at 12:02 PM
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
-- Database: `inc_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20241211144954', '2024-12-11 15:50:12', 198);

-- --------------------------------------------------------

--
-- Table structure for table `incident`
--

CREATE TABLE `incident` (
  `id` int(11) NOT NULL,
  `entity_type` varchar(50) NOT NULL,
  `reporter_id` int(11) NOT NULL,
  `incident_id` varchar(255) NOT NULL,
  `incident_details` longtext DEFAULT NULL,
  `reported_date` datetime DEFAULT NULL,
  `priority` varchar(20) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `incident`
--

INSERT INTO `incident` (`id`, `entity_type`, `reporter_id`, `incident_id`, `incident_details`, `reported_date`, `priority`, `status`) VALUES
(5, 'enterprise', 7, 'RMG144952024', 'this is test environment', '2024-12-31 16:15:00', 'low', 'open');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_type` varchar(22) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(180) NOT NULL,
  `address` varchar(255) NOT NULL,
  `country` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `fax` varchar(15) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_type`, `first_name`, `last_name`, `email`, `address`, `country`, `state`, `city`, `pincode`, `mobile`, `fax`, `phone`, `password`) VALUES
(1, '', 'priy', 'acnaici', 'as@iss.on', 'sec22', 'USA', 'California', 'Los Angeles', '122016', '7895381081', '29492834', '924923', '$2y$13$aA.LjhPKAclC0PSnODcwa.Dk78ylCg2JBt1pDPo7EPy6CwdC/tFha'),
(5, '', 'priyank', 'chaudhary', 'awr@ads.com', 'sector22', '82', '1369', '19310', '122016', '7895381081', '29492834', '232323', '$2y$13$BlxLbeW7HUcPRt7gyQcGXenK2xaeKTT1Wvgdtqh3MAjN68i2BGpOi'),
(7, 'employee', 'priyank', 'chaudhary', 'abcd@abc.in', 'sector22', 'India', 'Haryana', 'Dundahera', '122016', '7895381081', '29492834', '232323', '$2y$13$R1z2X2P5eBDJHYT.X22.e.m3yLUbiPqU6zmNmCbhGgvlPqdwsyB5m');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `incident`
--
ALTER TABLE `incident`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_3D03A11A59E53FB9` (`incident_id`),
  ADD KEY `IDX_3D03A11AE1CFE6F5` (`reporter_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `incident`
--
ALTER TABLE `incident`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `incident`
--
ALTER TABLE `incident`
  ADD CONSTRAINT `FK_3D03A11AE1CFE6F5` FOREIGN KEY (`reporter_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
