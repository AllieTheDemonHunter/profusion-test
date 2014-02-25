-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 25, 2014 at 12:48 PM
-- Server version: 5.5.33
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `beta`
--
CREATE DATABASE IF NOT EXISTS `beta` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `beta`;

-- --------------------------------------------------------

--
-- Table structure for table `cdr_transfer_audit`
--

DROP TABLE IF EXISTS `cdr_transfer_audit`;
CREATE TABLE `cdr_transfer_audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clid` int(11) NOT NULL,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `destination_cdr`
--

DROP TABLE IF EXISTS `destination_cdr`;
CREATE TABLE `destination_cdr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `calldate` datetime NOT NULL,
  `source` varchar(80) NOT NULL,
  `destination` varchar(80) NOT NULL,
  `account_code` varchar(30) DEFAULT NULL,
  `pincode` varchar(45) NOT NULL,
  `duration_call` bigint(20) DEFAULT '0',
  `duration_talk` bigint(20) DEFAULT NULL,
  `disposition` varchar(255) NOT NULL,
  `clid` varchar(80) DEFAULT NULL,
  `cdr_id` bigint(20) DEFAULT NULL,
  `vxcdr_id` bigint(20) DEFAULT NULL,
  `provider` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
