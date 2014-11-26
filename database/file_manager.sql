-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 26, 2014 at 12:32 PM
-- Server version: 5.5.38-log
-- PHP Version: 5.3.28

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

DROP TABLE IF EXISTS `download`;
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

DROP TABLE IF EXISTS `download_file`;
CREATE TABLE IF NOT EXISTS `download_file` (
  `id` int(11) DEFAULT NULL,
  `download_id` int(11) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
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

DROP TABLE IF EXISTS `folders`;
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
