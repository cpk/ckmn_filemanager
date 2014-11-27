-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2014 at 09:10 AM
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
-- Table structure for table `download`
--

CREATE TABLE IF NOT EXISTS `download` (
  `id` int(11) DEFAULT NULL,
  `key` int(11) DEFAULT NULL,
  `password` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `expire_time` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `download_file`
--

CREATE TABLE IF NOT EXISTS `download_file` (
  `id` int(11) DEFAULT NULL,
  `download_id` int(11) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` text NOT NULL,
  `file_code` varchar(200) NOT NULL,
  `file_size` int(11) NOT NULL DEFAULT '0',
  `file_downloads` int(11) NOT NULL DEFAULT '0',
  `folder_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `file_create_time` int(11) NOT NULL,
  `file_modified_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=16 ;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `file_name`, `file_code`, `file_size`, `file_downloads`, `folder_id`, `user_id`, `status`, `file_create_time`, `file_modified_time`) VALUES
(1, 'data (1).jpg', 'd5d349be0a4cdadbef38f250434da260.file', 105331, 0, 0, 1, 'deleted', 1416971680, 1416972085),
(2, 'abc abc.jpg', '36e21cffc9a585579c50f5d535e1feea.file', 97416, 0, 0, 1, '', 1416971683, 1416979610),
(3, 'data (32).jpg', 'fbd0a6b89a45f37b5d3caaf8ca170c28.file', 109492, 0, 0, 1, '', 1416971684, 1416979974),
(4, 'data (1).jpg', 'd5d349be0a4cdadbef38f250434da260 (1).file', 105331, 0, 1, 1, 'deleted', 1416971712, 1416972085),
(5, 'data (2).jpg', '36e21cffc9a585579c50f5d535e1feea (1).file', 97416, 0, 1, 1, 'deleted', 1416971713, 1416972085),
(6, 'data (3).jpg', 'fbd0a6b89a45f37b5d3caaf8ca170c28 (1).file', 109492, 0, 1, 1, 'deleted', 1416971713, 1416972085),
(7, 'data (1).jpg', '7106ba9ef30103e86f9b3a463ba05932.file', 105331, 0, 4, 1, 'deleted', 1416971827, 1416972085),
(8, 'data (2).jpg', 'a812c89480a51aa21bda51a90674aa28.file', 97416, 0, 4, 1, 'deleted', 1416971828, 1416972085),
(9, 'data (3).jpg', '08211a4e30623e5dff430cd4a1475ae3.file', 109492, 0, 4, 1, 'deleted', 1416971828, 1416972085),
(10, 'data (1).jpg', 'dda77d95e6913a56cc98cf317e1aefb8.file', 105331, 0, 7, 1, '', 1416975018, 0),
(11, 'data (2).jpg', '16494703e029373a1884fca1857af93a.file', 97416, 0, 7, 1, '', 1416975019, 0),
(12, 'data (3).jpg', 'dea1292991ff1a910d11e8e3bf416f95.file', 109492, 0, 7, 1, '', 1416975019, 0),
(13, 'data (1).jpg', '2825bd4e9234081da717523d955db25c.file', 105331, 0, 2, 1, '', 1416975162, 0),
(14, 'data (2).jpg', 'f68c257b02615933dbf5f708f03c5422.file', 97416, 0, 2, 1, '', 1416975163, 0),
(15, 'data (3).jpg', 'ffc2b1fd23a2beca8518b84be4700699.file', 109492, 0, 2, 1, '', 1416975164, 0);

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE IF NOT EXISTS `folders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `folder_name` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL,
  `folder_id` int(11) NOT NULL,
  `folder_size` bigint(11) NOT NULL DEFAULT '0',
  `folder_create_time` int(11) NOT NULL,
  `folder_modified_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=11 ;

--
-- Dumping data for table `folders`
--

INSERT INTO `folders` (`id`, `folder_name`, `user_id`, `folder_id`, `folder_size`, `folder_create_time`, `folder_modified_time`) VALUES
(2, 'hahaha<b>ha</b>', 1, 0, 0, 1416971632, 1416979959),
(7, 'Tôi hết bị điên rồi', 1, 0, 0, 1416974608, 1416979992),
(8, 'sdfdsfdsf', 1, 2, 0, 1416974887, 0),
(9, 'agsgwgawgas', 1, 2, 0, 1416974904, 0),
(10, 'dsfdsfdf', 1, 7, 0, 1416975004, 0);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  `date_create` datetime DEFAULT NULL,
  `user_create` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `content`, `date_create`, `user_create`, `type`, `status`) VALUES
(1, 'a0c913f8104fd918', '2014-11-27 00:00:00', 6, '1', 0),
(2, 'a0c913f8104fd918', '2014-11-26 00:00:00', 5, '2', 0),
(3, 'commited code chang han', '2014-11-25 00:00:00', 3, '3', 1),
(4, 'a0c913f8104fd918', '2014-11-24 00:00:00', 6, '1', 0),
(5, 'a0c913f8104fd918', '2014-11-23 00:00:00', 4, '1', 0),
(6, 'a0c913f8104fd918', '2014-11-22 00:00:00', 3, '1', 1),
(7, 'a0c913f8104fd918', '2014-11-21 00:00:00', 5, '1', 0),
(8, 'a0c913f8104fd918', '2014-11-20 00:00:00', 4, '1', 1),
(9, 'a0c913f8104fd918', '2014-11-19 00:00:00', 6, '1', 0),
(10, 'a0c913f8104fd918', '2014-11-18 00:00:00', 5, '1', 1),
(11, 'a0c913f8104fd918', '2014-11-17 00:00:00', 3, '1', 0),
(12, 'task gi do', '2014-11-16 00:00:00', 1, '3', 1),
(13, 'a0c913f8104fd918', '2014-11-15 00:00:00', 5, '2', 0),
(14, 'a0c913f8104fd918', '2014-11-14 00:00:00', 3, '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notification_types`
--

CREATE TABLE IF NOT EXISTS `notification_types` (
  `id` int(10) unsigned NOT NULL,
  `message` varchar(255) CHARACTER SET latin1 NOT NULL,
  `controller` varchar(100) CHARACTER SET latin1 NOT NULL,
  `action` varchar(100) CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notification_types`
--

INSERT INTO `notification_types` (`id`, `message`, `controller`, `action`) VALUES
(1, 'chia s? v?i b?n 1 file.', 'fileManagers', 'share'),
(2, 'chia s? v?i m?i ng??i 1 file.', 'fileManagers', 'public'),
(3, 'nh?c có 1 s? ki?n s?p di?n ra.', 'calendar', 'event');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

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
(18, 'users.create', NULL, '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 'FileManagers.folderItems', NULL, '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 'FileManagers.getFolderTree', NULL, '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 'FileManagers.createFolder', NULL, '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 'FileManagers.getFileManager', NULL, '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 'FileManagers.upload', NULL, '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

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
(18, 1, 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 1, 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 1, 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 1, 21, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 1, 22, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 1, 23, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `actived`, `first_name`, `last_name`, `email`) VALUES
(1, 'admin', '5ad24ecdb36ba3fcfe1a8e3d0d2ae327f508dcdc', 1, 'Admin', 'Admin', NULL),
(3, 'khoanguyen', '5ad24ecdb36ba3fcfe1a8e3d0d2ae327f508dcdc', 0, 'Khoa', 'Nguyễn', NULL),
(4, 'nhanhnguyen', '5ad24ecdb36ba3fcfe1a8e3d0d2ae327f508dcdc', 1, 'Nhanh', 'Nguyễn', NULL),
(5, 'manhdo', '5ad24ecdb36ba3fcfe1a8e3d0d2ae327f508dcdc', 1, 'Mạnh', 'Đõ', NULL),
(6, 'cuongtruong', '5ad24ecdb36ba3fcfe1a8e3d0d2ae327f508dcdc', 1, 'Cường', 'Trương', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_notifications`
--

CREATE TABLE IF NOT EXISTS `users_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `notification_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `users_notifications`
--

INSERT INTO `users_notifications` (`id`, `user_id`, `notification_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14);

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
