-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2017 at 09:54 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `reduce`
--

-- --------------------------------------------------------

--
-- Table structure for table `action`
--

CREATE TABLE IF NOT EXISTS `action` (
  `action_id` int(5) NOT NULL,
  `action_name` varchar(56) NOT NULL,
  `controller` varchar(56) NOT NULL,
  `function` varchar(56) NOT NULL,
  `ui_id` int(2) NOT NULL,
  `added_by` int(11) NOT NULL,
  `add_timestamp` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `update_timestamp` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`action_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `action`
--

INSERT INTO `action` (`action_id`, `action_name`, `controller`, `function`, `ui_id`, `added_by`, `add_timestamp`, `updated_by`, `update_timestamp`, `status`) VALUES
(3301, 'Login', 'init', 'login', 0, 0, 0, 1, 1490606210, 0),
(3302, 'Sing Up', 'init', 'signup', 1, 0, 0, 1, 1490613725, 0),
(3303, 'Dashboard', 'dashboard', 'index', 1, 0, 0, 0, 0, 0),
(3304, 'Logout', 'init', 'logout', 1, 0, 0, 0, 0, 0),
(3401, 'Add Action', 'action', 'add', 1, 0, 0, 0, 0, 0),
(3402, 'Edit Action', 'action', 'edit', 1, 0, 0, 0, 0, 0),
(3403, 'Manage Actions', 'action', 'manage', 1, 0, 0, 0, 0, 0),
(3404, 'Delete Action', 'action', 'delete', 1, 0, 0, 0, 0, 0),
(3501, 'Add Role', 'role', 'add', 1, 1, 1490614234, 0, 0, 0),
(3502, 'Edit Role', 'role', 'edit', 1, 1, 1490614426, 1, 1490615448, 0),
(3503, 'Manage Role', 'role', 'manage', 1, 1, 1490614779, 0, 0, 0),
(3504, 'Delete Role', 'Role', 'delete', 1, 1, 1490614867, 1, 1490615458, 0);

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_id` int(11) NOT NULL,
  `ref_type` int(11) NOT NULL,
  `street_1` varchar(255) NOT NULL,
  `street_2` varchar(255) NOT NULL,
  `city` varchar(15) NOT NULL,
  `state` varchar(15) NOT NULL,
  `country` varchar(25) NOT NULL,
  `post_code` int(4) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `business`
--

CREATE TABLE IF NOT EXISTS `business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_ref_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `role_id` int(3) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(56) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'End User'),
(3, 'ANNONYMOUS');

-- --------------------------------------------------------

--
-- Table structure for table `role_action_mapping`
--

CREATE TABLE IF NOT EXISTS `role_action_mapping` (
  `role_id` int(3) NOT NULL,
  `action_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_action_mapping`
--

INSERT INTO `role_action_mapping` (`role_id`, `action_id`) VALUES
(3, 3301),
(1, 3303),
(1, 3304),
(3, 3302);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL,
  `ref_type` int(2) NOT NULL,
  `role_id` int(11) NOT NULL,
  `last_login_timestamp` bigint(15) NOT NULL,
  `status` int(1) NOT NULL,
  `is_super` int(11) NOT NULL DEFAULT '0',
  `added_by` int(11) NOT NULL,
  `add_timestamp` bigint(15) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `update_timestamp` bigint(15) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_login_id` (`user_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_name`, `email`, `password`, `ref_type`, `role_id`, `last_login_timestamp`, `status`, `is_super`, `added_by`, `add_timestamp`, `updated_by`, `update_timestamp`) VALUES
(1, 'admin', 'aman@duzies.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 1, 0, 1, 1, 1, 1363237200, 1, 1490613587),
(2, 'user', 'user@def.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 2, 2, 1484817788, 1, 1, 1, 1363237200, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `userinterface`
--

CREATE TABLE IF NOT EXISTS `userinterface` (
  `ui_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `url` varchar(10) NOT NULL,
  PRIMARY KEY (`ui_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `userinterface`
--

INSERT INTO `userinterface` (`ui_id`, `name`, `url`) VALUES
(1, 'Backend', 'backend'),
(2, 'Frontend', 'frontend');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
