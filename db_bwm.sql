-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2025 at 12:05 PM
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
-- Database: `db_bwm`
--

-- --------------------------------------------------------

--
-- Table structure for table `table_bod`
--

CREATE TABLE `table_bod` (
  `Id` int(10) NOT NULL,
  `Hostname` varchar(128) NOT NULL,
  `Description` varchar(128) NOT NULL,
  `Interface` varchar(10) NOT NULL,
  `Unit` int(5) NOT NULL,
  `Old_input_policer` varchar(10) NOT NULL,
  `Old_output_policer` varchar(10) NOT NULL,
  `Bod_input_policer` varchar(10) NOT NULL,
  `Bod_output_policer` varchar(10) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_client`
--

CREATE TABLE `table_client` (
  `Id` int(15) NOT NULL,
  `Hostname` varchar(128) NOT NULL,
  `Interface` varchar(15) NOT NULL,
  `Unit` int(20) NOT NULL,
  `Status_unit` varchar(50) NOT NULL,
  `Description` varchar(128) NOT NULL,
  `Ip_address` varchar(100) NOT NULL,
  `Vlan_id` int(5) NOT NULL,
  `Policer_status` varchar(10) NOT NULL,
  `Policer_input_status` varchar(10) NOT NULL,
  `Policer_output_status` varchar(10) NOT NULL,
  `Input_policer` varchar(10) NOT NULL,
  `Output_policer` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_client`
--

INSERT INTO `table_client` (`Id`, `Hostname`, `Interface`, `Unit`, `Status_unit`, `Description`, `Ip_address`, `Vlan_id`, `Policer_status`, `Policer_input_status`, `Policer_output_status`, `Input_policer`, `Output_policer`) VALUES
(13, 'POP.01', 'em1', 10, 'Active | Enable', 'LAN-10', '192.168.10.1/24, 192.168.100.1', 10, 'Active', 'Inactive', 'Active', '30M', '30M'),
(14, 'POP.01', 'em1', 20, 'Active | Disable', 'LAN-20', '192.168.20.1/24', 20, 'None', 'None', 'None', '10M', '10M'),
(15, 'POP.01', 'em1', 30, 'Inactive | Enable', 'LAN-30', 'None', 30, 'None', 'None', 'None', '10M', '10M'),
(16, 'POP.01', 'em1', 40, 'Active | Enable', 'LAN-40', '192.168.40.1/24', 40, 'None', 'None', 'None', '10M', '10M'),
(17, 'POP.01', 'em1', 50, 'Active | Enable', 'LAN-50', '192.168.50.1/24', 50, 'None', 'None', 'None', '10M', '10M');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_bod`
--
ALTER TABLE `table_bod`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `table_client`
--
ALTER TABLE `table_client`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_bod`
--
ALTER TABLE `table_bod`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `table_client`
--
ALTER TABLE `table_client`
  MODIFY `Id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
