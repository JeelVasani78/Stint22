-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 19, 2024 at 11:58 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `stint22`
--
CREATE DATABASE IF NOT EXISTS `stint22` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `stint22`;

-- --------------------------------------------------------

--
-- Table structure for table `emp`
--

CREATE TABLE IF NOT EXISTS `emp` (
  `emp_id` int(5) NOT NULL AUTO_INCREMENT,
  `user_id` int(5) NOT NULL,
  `team_id` int(5) NOT NULL,
  `emp_no` int(5) NOT NULL,
  `ename` varchar(30) DEFAULT NULL,
  `deptno` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `emp`
--

INSERT INTO `emp` (`emp_id`, `user_id`, `team_id`, `emp_no`, `ename`, `deptno`) VALUES
(16, 2, 1, 2, 'vinit soni', '85'),
(17, 2, 1, 3, 'jeel', '69'),
(18, 2, 1, 4, 'krishna', '41'),
(19, 7, 7, 1, 'emp1', '10'),
(20, 7, 7, 2, 'emp2', '10'),
(21, 7, 7, 3, 'emp3', '10'),
(22, 7, 7, 4, 'emp4', '10'),
(23, 7, 7, 5, 'emp5', '10'),
(24, 2, 1, 1, 'dhruvil', '22');

-- --------------------------------------------------------

--
-- Table structure for table `stud`
--

CREATE TABLE IF NOT EXISTS `stud` (
  `stud_id` int(5) NOT NULL AUTO_INCREMENT,
  `user_id` int(5) NOT NULL,
  `team_id` int(5) NOT NULL,
  `roll_no` int(5) NOT NULL,
  `sname` varchar(30) DEFAULT NULL,
  `class` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`stud_id`),
  UNIQUE KEY `roll_no` (`roll_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `task_master`
--

CREATE TABLE IF NOT EXISTS `task_master` (
  `task_id` int(5) NOT NULL AUTO_INCREMENT,
  `user_id` int(5) NOT NULL,
  `team_id` int(5) DEFAULT NULL,
  `date` date NOT NULL,
  `s_time` time DEFAULT NULL,
  `e_time` time NOT NULL,
  `title` varchar(55) NOT NULL,
  `task_desc` varchar(505) NOT NULL,
  PRIMARY KEY (`task_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `task_master`
--

INSERT INTO `task_master` (`task_id`, `user_id`, `team_id`, `date`, `s_time`, `e_time`, `title`, `task_desc`) VALUES
(1, 2, NULL, '2024-02-22', '00:48:00', '12:48:00', 'Hi', 'I am Dhruvil.ðŸ˜¶â€ðŸŒ«ï¸'),
(6, 4, NULL, '2024-03-05', '18:09:00', '17:09:00', 'auefaebf', 'afaefafa'),
(7, 5, NULL, '2024-03-07', '14:36:00', '15:36:00', 'Hi', 'I am other user'),
(8, 5, NULL, '2024-03-07', '14:36:00', '15:36:00', 'Hi', 'I am other user'),
(9, 5, NULL, '2024-03-07', '14:36:00', '15:36:00', 'Hi', 'I am other user'),
(10, 5, NULL, '2024-03-07', '14:36:00', '15:36:00', 'Hi', 'I am other user'),
(11, 5, NULL, '2024-03-14', '18:55:00', '16:55:00', 'Hi', 'abcdefghijklmnopqrstuvwxyz'),
(12, 5, NULL, '2024-03-09', '14:13:00', '18:09:00', 'Hi', 'eefeafafafa'),
(14, 2, NULL, '2024-05-12', '02:25:00', '21:30:00', 'Hi', 'Vinit Soni.ðŸ¦¥'),
(15, 2, NULL, '2024-05-17', '02:27:00', '04:27:00', 'Hi', 'Jeel Patel.ðŸ™‰'),
(17, 2, 1, '2024-05-25', NULL, '23:59:00', 'abc', 'sadafae'),
(18, 2, 4, '2024-04-28', NULL, '12:50:00', 'sfs', 'ewsf'),
(20, 2, 5, '0000-00-00', NULL, '00:00:00', 'abc', 'fewsfwsfswfewsfwswswssewwseesesddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd'),
(21, 2, NULL, '2024-04-06', '15:18:00', '15:17:00', 'Hi', 'qwdqdqwd'),
(22, 7, NULL, '2024-04-27', '11:25:00', '11:28:00', 'Hi', 'dfxdd'),
(23, 2, NULL, '2024-06-22', '16:43:00', '20:06:00', 'Hi', 'testing testing...');

-- --------------------------------------------------------

--
-- Table structure for table `team_master`
--

CREATE TABLE IF NOT EXISTS `team_master` (
  `team_id` int(5) NOT NULL AUTO_INCREMENT,
  `user_id` int(5) NOT NULL,
  `team_name` varchar(55) NOT NULL,
  `team_category` varchar(10) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`team_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `team_master`
--

INSERT INTO `team_master` (`team_id`, `user_id`, `team_name`, `team_category`, `date`) VALUES
(1, 2, 'Team1', 'Business', '2024-03-29'),
(7, 7, 'Team of Sales dept.', 'Business', '2024-04-06'),
(8, 7, 'Team1', 'Business', '2024-04-16');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `user_id` int(5) NOT NULL AUTO_INCREMENT,
  `user_nm` varchar(50) NOT NULL,
  `emailid` varchar(50) NOT NULL,
  `pass` varchar(10) NOT NULL,
  `category` varchar(10) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'img/user.jpg',
  `date` date DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`user_id`, `user_nm`, `emailid`, `pass`, `category`) VALUES
(1, 'Shri Krushna', 'shrikrishna8@gmail.com', '1234', 'Teacher'),
(2, 'dhruvil22', 'idkranadhruvil2209@gmail.com', '2209', 'Business'),
(3, 'Stint22', 'stint22@gmail.com', '2209', 'Business'),
(4, 'abc', 'abc@gmail.com', '1234', 'Business'),
(5, 'other', 'other@gmail.com', '1234', 'Other'),
(6, 'vinit soni', 'vinit420@gmail.com', '1234', 'Student'),
(7, 'user', 'user@gmail.com', '1234', 'Business');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `task_master`
--
ALTER TABLE `task_master`
  ADD CONSTRAINT `references` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
