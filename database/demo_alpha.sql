-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2014 at 04:27 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `demo_alpha`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` text NOT NULL,
  `file_code` varchar(200) NOT NULL,
  `file_password` varchar(32) NOT NULL,
  `file_size` int(11) NOT NULL DEFAULT '0',
  `file_create_time` int(11) NOT NULL,
  `file_downloads` int(11) NOT NULL DEFAULT '0',
  `file_folder_owner_id` int(11) NOT NULL DEFAULT '0',
  `file_user_owner_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE IF NOT EXISTS `folders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `folder_name` varchar(200) NOT NULL,
  `folder_user_owner_id` int(11) NOT NULL,
  `folder_parent_id` int(11) NOT NULL,
  `folder_size` bigint(20) NOT NULL DEFAULT '0',
  `folder_create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `section` varchar(255) NOT NULL,
  `module` varchar(255) NOT NULL,
  `actived` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `description`, `section`, `module`, `actived`, `created`, `modified`) VALUES
(1, 'admin.index', 'add user', 'user', 'create', 1, '2014-11-20 00:00:00', '2014-11-20 00:00:00'),
(2, 'admin.dashboard', NULL, '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'users.index', 'manager user', 'user', 'index', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'roles.index', NULL, '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'permissions.index', NULL, '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'users.account_setting', NULL, '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'users.change_password', NULL, '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'roles.show', '', 'role', 'show', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'roles.edit', '', 'role', 'edit', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'roles.update', '', 'role', 'update', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'roles.delete', '', 'role', 'delete', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'roles.add', '', 'role', 'add', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'roles.create', NULL, 'role', 'create', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'users.export', NULL, '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'fileManagers.index', NULL, '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'users.show', NULL, '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 'users.edit', NULL, '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 'users.create', NULL, '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `level` int(11) NOT NULL,
  `description` text NOT NULL,
  `actived` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `level`, `description`, `actived`) VALUES
(1, 'ADMIN_ROLE', 1, 'ADMIN', NULL),
(2, 'USER_ROLE', 2, 'USER', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles_permissions`
--

CREATE TABLE IF NOT EXISTS `roles_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `roles_permissions`
--

INSERT INTO `roles_permissions` (`id`, `role_id`, `permission_id`, `created`, `modified`) VALUES
(1, 1, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 1, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 1, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 1, 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 1, 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 1, 9, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 1, 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 1, 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 1, 12, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 1, 13, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 1, 14, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 1, 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 1, 16, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 1, 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 1, 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `actived` tinyint(1) NOT NULL DEFAULT '0',
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `actived`, `first_name`, `last_name`, `email`) VALUES
(1, 'admin', '5ad24ecdb36ba3fcfe1a8e3d0d2ae327f508dcdc', 1, 'ckmn', 'ckmn', NULL),
(3, 'user', '5ad24ecdb36ba3fcfe1a8e3d0d2ae327f508dcdc', 0, 'user', 'account', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_permissions`
--

CREATE TABLE IF NOT EXISTS `users_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE IF NOT EXISTS `users_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1),
(2, 1, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
