-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2015 at 04:00 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hackidc`
--
CREATE DATABASE IF NOT EXISTS `hackidc` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `hackidc`;

-- --------------------------------------------------------

--
-- Table structure for table `profileright`
--

DROP TABLE IF EXISTS `profileright`;
CREATE TABLE IF NOT EXISTS `profileright` (
`ID` int(11) NOT NULL,
  `rightID` int(11) NOT NULL,
  `profile` text NOT NULL,
  `profileMD5` tinytext NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `rights`
--

DROP TABLE IF EXISTS `rights`;
CREATE TABLE IF NOT EXISTS `rights` (
  `right` mediumtext NOT NULL,
  `checkList` mediumtext NOT NULL,
`ID` int(11) NOT NULL,
  `category` text NOT NULL,
  `name` text NOT NULL,
  `subject` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `profileright`
--
ALTER TABLE `profileright`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `rights`
--
ALTER TABLE `rights`
 ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `profileright`
--
ALTER TABLE `profileright`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `rights`
--
ALTER TABLE `rights`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
