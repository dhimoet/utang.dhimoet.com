-- phpMyAdmin SQL Dump
-- version 3.3.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Aug 08, 2012 at 09:20 PM
-- Server version: 5.1.56
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `utangapp`
--

CREATE DATABASE `utangapp`;
USE `utangapp`;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `RelatedUserID` int(11) NOT NULL,
  `Type` enum('friend_request','added_transaction') NOT NULL DEFAULT 'added_transaction',
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Borrower` int(11) NOT NULL,
  `Lender` int(11) NOT NULL,
  `Amount` double NOT NULL COMMENT 'In CAD',
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Title` varchar(30) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Reporter` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `userrelationships`
--

CREATE TABLE IF NOT EXISTS `userrelationships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `UserID1` int(11) NOT NULL COMMENT 'Friend requests must be from this column',
  `UserID2` int(11) NOT NULL,
  `Type` enum('friend','blocked','friend_request') NOT NULL DEFAULT 'friend_request',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
