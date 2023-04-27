-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 20.01.2023 klo 08:24
-- Palvelimen versio: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `2022_login`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `table_roles`
--

CREATE TABLE `table_roles` (
  `r_ID` int(11) NOT NULL,
  `r_name` varchar(255) NOT NULL,
  `r_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vedos taulusta `table_roles`
--

INSERT INTO `table_roles` (`r_ID`, `r_name`, `r_level`) VALUES
(1, 'user', 1),
(2, 'Admin', 50),
(3, 'Super-admin', 99),
(4, 'hyper giga admin', 9999),
(5, 'Redaktör', 20);

-- --------------------------------------------------------

--
-- Rakenne taululle `table_status`
--

CREATE TABLE `table_status` (
  `s_id` int(11) NOT NULL,
  `s_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Rakenne taululle `table_user`
--

CREATE TABLE `table_user` (
  `u_ID` int(11) NOT NULL,
  `u_username` varchar(255) NOT NULL,
  `u_firstname` varchar(255) NOT NULL,
  `u_lastname` varchar(255) NOT NULL,
  `u_email` varchar(255) NOT NULL,
  `u_password` varchar(256) NOT NULL,
  `u_role` int(11) NOT NULL,
  `u_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vedos taulusta `table_user`
--

INSERT INTO `table_user` (`u_ID`, `u_username`, `u_firstname`, `u_lastname`, `u_email`, `u_password`, `u_role`, `u_status`) VALUES
(12, 'molle', 'Martin', 'Molnar', 'a@a.com', '$2y$10$BpZ/sK7.ShRoz02tqWhk0.UwjPG/0Jiu2pz/ce8LRyhHX3LoyY6Oe', 3, 0),
(13, 'admin', 'asd', 'asd', 'asd@asd.com', '$2y$10$fFq6b1CHDrL4bThvSeP60.AWpV8iDQ1hZ8x7yYz76.0yBHdC9Osd6', 1, 0),
(14, 'molle1', 'mol', 'mol', 'mole@mol.com', '$2y$10$exFxValB.w/8erqPux.DpeKWAYlz4elGSnd4EgGOP1p10JrMVobGO', 1, 0),
(15, 'molle212', 'asd', 'asd', 'asdasdsd@asda.com', '$2y$10$QQAciXouJU7Rm3dCFZMQSe3FCMGgKW9bCfvZSBLcJ.i/R8LwnDjje', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_roles`
--
ALTER TABLE `table_roles`
  ADD PRIMARY KEY (`r_ID`);

--
-- Indexes for table `table_status`
--
ALTER TABLE `table_status`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `table_user`
--
ALTER TABLE `table_user`
  ADD PRIMARY KEY (`u_ID`),
  ADD KEY `u_role` (`u_role`),
  ADD KEY `u_password` (`u_password`,`u_role`),
  ADD KEY `u_status` (`u_status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_roles`
--
ALTER TABLE `table_roles`
  MODIFY `r_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `table_status`
--
ALTER TABLE `table_status`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_user`
--
ALTER TABLE `table_user`
  MODIFY `u_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
