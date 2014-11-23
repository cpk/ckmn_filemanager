-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.38-log - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.0.0.4865
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table demo_alpha.files
DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` text NOT NULL,
  `file_code` varchar(200) NOT NULL,
  `file_password` varchar(32) NOT NULL,
  `file_size` int(11) NOT NULL DEFAULT '0',
  `file_create_time` int(11) NOT NULL,
  `file_downloads` int(11) NOT NULL DEFAULT '0',
  `file_folder_ower_id` int(11) NOT NULL DEFAULT '0',
  `file_user_ower_id` int(11) NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

-- Dumping data for table demo_alpha.files: 64 rows
DELETE FROM `files`;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` (`file_id`, `file_name`, `file_code`, `file_password`, `file_size`, `file_create_time`, `file_downloads`, `file_folder_ower_id`, `file_user_ower_id`) VALUES
	(1, 'test1.doc', '', '', 1220, 2231231, 20, 26, 15),
	(2, 'test2', '', '', 100, 2231231, 20, 27, 15),
	(3, 'sefsdf', '', '', 342, 232132, 23, 33, 15),
	(4, 'sdfg.avi', '', '', 1233, 2231231, 0, 0, 15),
	(5, 'Chi toi dan coder - lyric.txt', '8e17afd1d056c63b70b419357cf53da3_17o0thg17q0unva17e71dull6t2d.file', '', 1253, 1365830583, 0, 0, 15),
	(6, 'Chi toi dan coder - lyric.txt', '8e17afd1d056c63b70b419357cf53da3_17o0tjo4217vk1rmp1gkoc5b1tkb2q.file', '', 1253, 1365830657, 0, 26, 15),
	(7, 'DK Tin chi.zip', '521280d01160e0d3991b92eae2fc53db_17o0u3vhro2n183317unsou15cea.file', '', 5473977, 1365831190, 0, 0, 15),
	(8, 'DK Tin chi.zip', 'c04887ebd6ea176ed90b420cfbb57d75_17o0vga121ham27f1fn695r101ba.file', '', 5473977, 1365832642, 0, 30, 15),
	(9, 'Chi toi dan coder - lyric.txt', '7a26321b4e673d2b4984f9de92322c7a_17o0vljvkci8taf1k5s1uqn13uba.file', '', 1253, 1365832815, 0, 39, 15),
	(10, 'Chi toi dan coder - lyric.txt', '223d76a12a28c364c5e4b364940b608d_17o10k6cq1k1r9l1o301ecvh6ka.file', '', 1253, 1365833820, 0, 42, 15),
	(11, 'DK Tin chi.zip', '7e4c7fa474cebc0ddee84b792921fc3d_17o10uuli1s6t1kfp1mh31rmjn0ka.file', '', 5473977, 1365834171, 0, 42, 15),
	(12, 'DK Tin chi.zip', '7e4c7fa474cebc0ddee84b792921fc3d_17o110m7014i31a6ele51iiksbe1c.file', '', 5473977, 1365834228, 0, 42, 15),
	(13, 'Chi toi dan coder - lyric.txt', '33442b605c9a90dac8b0848f0e666791_17o112qtq1mdm4dhe1n0i1j2ca.file', '', 1253, 1365834297, 0, 0, 15),
	(14, 'Chi toi dan coder - lyric.txt', 'b68e33abff04aa7bc54a512bc0315284_17o11517b1c9k1glt1be1eqf70ja.file', '', 1253, 1365834371, 0, 44, 15),
	(15, 'Chi toi dan coder - lyric.txt', 'b50ffde416118faa8140556c85edffcc_17o116aihib21hjiqoc1jpm14vfa.file', '', 1253, 1365834415, 0, 43, 15),
	(16, 'Chi toi dan coder - lyric.txt', '908800e5507de57e74fdc47bbebf60ef_17o117umpab273j1ifm12pu1891i.file', '', 1253, 1365834468, 0, 41, 15),
	(17, 'Chi toi dan coder - lyric.txt', 'abe534ec25a6c1536b8c035ad68f78f3_17o119lbrpp11l1p63jqfd9tla.file', '', 1253, 1365834524, 0, 64, 15),
	(18, 'Chi toi dan coder - lyric.txt', 'b1349459a3af87ae024dfbc95de303b4_17o11bkksu1a14ki1tivkb51abha.file', '', 1253, 1365834588, 0, 0, 15),
	(19, 'Chi toi dan coder - lyric.txt', '308e2d5f3911ccb370aaf95013e243b9_17o11e88j1hfjm0j3b1ksf165sa.file', '', 1253, 1365834673, 0, 0, 15),
	(20, 'Chi toi dan coder - lyric.txt', 'eb366a9411955d64b2a7fbcace79b81c_17o11ftf4v711gv1m07c8fgqa.file', '', 1253, 1365834725, 0, 0, 15),
	(21, 'Chi toi dan coder - lyric.txt', '29ac27e17b3ff3456b278ec2a96ffffb_17o11h2rkbnt1fes1slk3u41pjua.file', '', 1253, 1365834763, 0, 0, 15),
	(22, 'SHARE ACC FSHARE.txt', '9bd1028a3133f38bd3390816f965e664_17o11iu8kn28jpcmnm1pleqca.file', '', 1429, 1365834825, 0, 0, 15),
	(23, 'Chi toi dan coder - lyric.txt', 'af48ebd88fef52ca21c47d596039cbe9_17o11jltc1notv0f5of3jkkp9a.file', '', 1253, 1365834849, 0, 0, 15),
	(24, 'SHARE ACC FSHARE.txt', '927fa75ffa0b336ad38f776f7ad78a48_17o11kthc1e3h1qfk4jg1fn8q4ka.file', '', 1429, 1365834890, 0, 0, 15),
	(25, 'Chi toi dan coder - lyric.txt', '795e9295b3a36e7897b28248e2f003ef_17o11mmor1ot4rdjjafdhlg6ca.file', '', 1253, 1365834951, 0, 64, 15),
	(26, 'Chi toi dan coder - lyric.txt', '5c4d4dd844d3412a41f0341bf2b2cce5_17o11ojgbd7b1j0dj481r12f1qa.file', '', 1253, 1365835010, 0, 38, 15),
	(27, 'SHARE ACC FSHARE.txt', 'e4681f80cf4cad249d7f6676f99e2730_17o11pnbjee714tb256g1i5qa.file', '', 1429, 1365835051, 0, 0, 15),
	(28, 'Chi toi dan coder - lyric.txt', 'b7a717d6fd53dcbf35f3978e26fdd236_17o11t3747gs1gh71ttqvkc1uma.file', '', 1253, 1365835161, 0, 70, 15),
	(29, 'Chi toi dan coder - lyric.txt', '6d2f987a10ab59fb7327261ee7f0b55d_17o11ugaq1q94b741j7j90e13nba.file', '', 1253, 1365835207, 0, 60, 15),
	(30, 'SHARE ACC FSHARE.txt', '3440e6c71cd011774b07fddbad8108b7_17o121fvrltjma3fup1d6kbtea.file', '', 1429, 1365835305, 0, 60, 15),
	(31, 'Chi toi dan coder - lyric.txt', '3440e6c71cd011774b07fddbad8108b7_17o124jro1q7n1u7s1akpralsmtn.file', '', 1253, 1365835410, 0, 60, 15),
	(32, 'SHARE ACC FSHARE.txt', 'f08ecd2e24b0305f181479c8e86d47b9_17o12a0ht17ls12imogo1po61ik.file', '', 1429, 1365835582, 0, 41, 15),
	(33, 'Screenshot from 2012-12-29 16:32:48.png', 'c8587afe6f8a678deadf474255291840_17o12i0sn1jjc1bm91ilsgi7voeh.file', '', 563183, 1365835848, 0, 28, 15),
	(34, 'Screenshot from 2013-01-04 18:02:50.png', 'c8587afe6f8a678deadf474255291840_17o12i0snvsi1ocu1rh614mt1rmqi.file', '', 476524, 1365835848, 0, 28, 15),
	(35, 'Screenshot from 2013-01-06 08:49:27.png', 'c8587afe6f8a678deadf474255291840_17o12i0sn1k6c10bhbn11nrlasj.file', '', 213955, 1365835848, 0, 28, 15),
	(36, 'Screenshot from 2013-02-15 20:58:18.png', 'c8587afe6f8a678deadf474255291840_17o12i0sn1qqs17kno4s1ro41rnk.file', '', 149859, 1365835849, 0, 28, 15),
	(37, 'Screenshot from 2013-02-27 10:17:18.png', 'c8587afe6f8a678deadf474255291840_17o12i0sn30h11714831ec91b7ol.file', '', 140628, 1365835849, 0, 28, 15),
	(38, 'Screenshot from 2013-03-06 16:26:40.png', 'c8587afe6f8a678deadf474255291840_17o12i0snkq2erqkm1mbum4nm.file', '', 90575, 1365835849, 0, 28, 15),
	(39, 'Screenshot from 2013-04-03 00:21:47.png', 'c8587afe6f8a678deadf474255291840_17o12i0soipc2rmnr1brmnahn.file', '', 555944, 1365835850, 0, 28, 15),
	(40, 'Screenshot from 2013-04-03 00:23:32.png', 'c8587afe6f8a678deadf474255291840_17o12i0sp1ce6op111341ar5ot6o.file', '', 542013, 1365835850, 0, 28, 15),
	(41, '130611_Elements_set.rar', '9d80c0d1c90fda1212c2068efcf560e1_17o12si5oe0v7vef5d114b88ej.file', '', 383692, 1365836192, 0, 0, 15),
	(42, '3951905-clean-web-ui-elements.rar', '9d80c0d1c90fda1212c2068efcf560e1_17o12si5o42p1m0n1eue1tbm334k.file', '', 2704697, 1365836193, 0, 0, 15),
	(43, '3994072-fb-desktop-24.zip', '9d80c0d1c90fda1212c2068efcf560e1_17o12si5p8sicah140116l93qol.file', '', 4292892, 1365836194, 0, 0, 15),
	(44, '0220100517092412475.rar', '9d80c0d1c90fda1212c2068efcf560e1_17o12si5pbfh18nv1bpkqie196um.file', '', 3578177, 1365836196, 0, 0, 15),
	(45, '3951905-clean-web-ui-elements.rar', '4da8eacc5491a31479f030839a99f177_17o19okfn1q8417tfsgf1oh31h0ja.file', '', 2704697, 1365843401, 0, 45, 15),
	(46, '111720_1337684870.jpg', 'ecd8ea7fc88c09451938751893d4e6b5_17o1d2rh9q2pfub1kdn1b6i1gcpa.file', '', 486157, 1365846881, 0, 0, 15),
	(47, 'Chi toi dan coder - lyric.txt', '93abd4060bca50a8f2bdb83fc5e885e0_17o1e78uj47q1122ffn9v3c9ca.file', '', 1253, 1365848075, 0, 42, 15),
	(48, 'SHARE ACC FSHARE.txt', '93abd4060bca50a8f2bdb83fc5e885e0_17o1edvolp1s119i1kojl91vp1n.file', '', 1429, 1365848294, 0, 47, 15),
	(49, 'Chi toi dan coder - lyric.txt', '93abd4060bca50a8f2bdb83fc5e885e0_17o1efb8j1964eos1eml1l8fepm14.file', '', 1253, 1365848339, 0, 47, 15),
	(50, '3994072-fb-desktop-24.zip', 'ecd8ea7fc88c09451938751893d4e6b5_17o1er5uo138a11hf1guma8b1h8pn.file', '', 4292892, 1365848731, 0, 0, 15),
	(51, 'Kikis.Delivery.Service.1989.720p.HDTV.x264.mkv', '512236b0e68f6bd138ab968e740c6003_17slqnjr61jal1scojsa1a2v1p8ac.file', '', 48259082, 1370827264, 0, 42, 15),
	(52, 'News Broadcast pack 2011 - YouTube.MP4', 'ecb9c3bd0ddb131b4e752b99f6825cfd_17tvqd9lbml41ao4j221dt2gc3a.file', '', 21461397, 1372236203, 0, 43, 15),
	(53, 'java.rar', '401664bc78b6ad08feee6ae914f93070_1808me9hkvhq1k8oq7q19h1ub3a.file', '', 22945274, 1374681516, 0, 33, 15),
	(54, 'Manh.jpg', 'dcce9f2ff0f952cfdcdbe559052a6533_1822i9maqla83hge9ltf31soda.file', '', 38931, 1376623322, 0, 0, 15),
	(55, 'Bootstrap-Form-Builder-gh-pages.zip', '601a6fc7e09ad124920ac9e144e0ba9d_182l35uje1hoe122o1o6v1g8i1jj2a.file', '', 213796, 1377245004, 0, 107, 15),
	(56, 'After Effects Project Files - Broadcast Design - News Package - VideoHive.FLV', '601a6fc7e09ad124920ac9e144e0ba9d_182l36mv212dq26flokaan1ngr.file', '', 11750929, 1377245194, 0, 107, 15),
	(57, '[www.begood.vn]-begood_vn_file.rar', '601a6fc7e09ad124920ac9e144e0ba9d_182l3tu6i5o10n0mm6108jdu0i.file', '', 269596, 1377245790, 0, 114, 15),
	(58, '28TRIEUDIACHIEMAIL.rar', '601a6fc7e09ad124920ac9e144e0ba9d_182l3tu6jlpi8s1v8d1m5d1cp1l.file', '', 121729682, 1377245841, 0, 114, 15),
	(59, 'Adele - Someone Like You.mp3', '601a6fc7e09ad124920ac9e144e0ba9d_182l3tu6jmmhig01ft439d7tqp.file', '', 4577280, 1377245845, 0, 114, 15),
	(60, '1531871_315537065261314_4950363624171960345_n.jpg', 'c3a55d3abcf2029d8ba26e9cdfb33fdf_1979o9cekt70cm91t844ntmbe.file', '', 109842, 1416593109, 0, 0, 15),
	(61, '1908438_689786981128408_1166182802827229957_n.jpg', 'c3a55d3abcf2029d8ba26e9cdfb33fdf_1979o9cek1ji6vj3151rst51cmcf.file', '', 97416, 1416593112, 0, 0, 15),
	(62, '10410241_689789541128152_6728058457814256792_n.jpg', 'c3a55d3abcf2029d8ba26e9cdfb33fdf_1979o9celsm2lkp1nmb15ls1v23g.file', '', 105331, 1416593115, 0, 0, 15),
	(63, '4567-Guardians-of-the-Galaxy.rar', 'c3a55d3abcf2029d8ba26e9cdfb33fdf_1979p87i3dl41giju3db0p1pg1bf.file', '', 82981, 1416593951, 0, 111, 15),
	(64, 'bootstrap-3.1.1-dist_2.zip', 'c3a55d3abcf2029d8ba26e9cdfb33fdf_1979p8eghm0i1s59vrdkj2fqubj.file', '', 206413, 1416594115, 0, 111, 15);
/*!40000 ALTER TABLE `files` ENABLE KEYS */;


-- Dumping structure for table demo_alpha.folders
DROP TABLE IF EXISTS `folders`;
CREATE TABLE IF NOT EXISTS `folders` (
  `folder_id` int(11) NOT NULL AUTO_INCREMENT,
  `folder_name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `folder_user_owner_id` int(11) NOT NULL,
  `folder_parent_id` int(11) NOT NULL,
  `folder_size` bigint(11) NOT NULL DEFAULT '0',
  `folder_create_time` int(11) NOT NULL,
  PRIMARY KEY (`folder_id`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=latin1;

-- Dumping data for table demo_alpha.folders: ~94 rows (approximately)
DELETE FROM `folders`;
/*!40000 ALTER TABLE `folders` DISABLE KEYS */;
INSERT INTO `folders` (`folder_id`, `folder_name`, `folder_user_owner_id`, `folder_parent_id`, `folder_size`, `folder_create_time`) VALUES
	(26, 'Cái gì thế này???', 15, 0, 0, 1363261205),
	(27, 'fse', 15, 26, 0, 1363261217),
	(28, 'fse', 15, 0, 0, 1363261217),
	(29, 'TES<b>ST</b>', 15, 35, 0, 1363261343),
	(30, 'TESST', 15, 0, 0, 1363261345),
	(31, 'TESST', 15, 0, 0, 1363261357),
	(32, 'TESST', 15, 0, 0, 1363261361),
	(33, 'asd', 15, 27, 0, 1363261557),
	(34, 'ree', 15, 0, 0, 1363261563),
	(35, 'dfdsf', 15, 33, 0, 1363261607),
	(36, 'heheh', 15, 0, 0, 1363280254),
	(37, '^^', 15, 0, 0, 1363281243),
	(38, 'dfsefdf', 15, 0, 0, 1363281327),
	(39, ':)', 15, 0, 0, 1363308530),
	(40, 'Cào cào lá tre', 15, 0, 0, 1363407752),
	(41, 'dfsdfef', 15, 0, 0, 1363407838),
	(42, 'Anh Mạnh kute hihihi', 15, 0, 0, 1363407899),
	(43, '123456', 15, 0, 0, 1363408161),
	(44, 'ăd', 15, 0, 0, 1363408230),
	(45, 'sef', 15, 0, 0, 1363408258),
	(46, 'èsf', 15, 0, 0, 1363408270),
	(47, 'aw', 15, 0, 0, 1363408506),
	(48, 're', 15, 0, 0, 1363408576),
	(49, 'Waiting for you!!!!', 15, 36, 0, 1363408658),
	(50, 'sfefsdfsdf', 15, 30, 0, 1363408865),
	(51, ':Dwyd', 15, 30, 0, 1363408870),
	(52, 'dfsd fsdf sfsef sdfsdfsd fs gfs', 15, 30, 0, 1363408875),
	(53, 'sef dfsdf sgf dsfgs', 15, 52, 0, 1363408891),
	(54, 'sdfghjk', 15, 53, 0, 1363408954),
	(55, 'dsfef sdfs gsdf asdra wfsadas sgdfgfd gd', 15, 54, 0, 1363408974),
	(56, 'asdfghjlhgfh ghgfhfg hfgh fghfg h fg', 15, 55, 0, 1363408992),
	(57, 'asdfghhfhgfhfgh', 15, 56, 0, 1363409009),
	(58, 'ww', 15, 52, 0, 1363409246),
	(59, 'TEMPLATE', 15, 0, 0, 1364875163),
	(60, 'Chao ban', 15, 0, 0, 1364887351),
	(61, 'Test template', 15, 0, 0, 1364887551),
	(62, 'Chaosdw', 15, 0, 0, 1364887688),
	(63, 'Handlebars', 15, 0, 0, 1364896014),
	(64, 'dfdsfsd', 15, 0, 0, 1364955756),
	(65, 'Thêm thư mục', 15, 0, 0, 1364978459),
	(66, 'kaka', 15, 26, 0, 1364978505),
	(67, 'hhhj', 15, 42, 0, 1364995781),
	(68, 'g', 15, 43, 0, 1364995951),
	(69, 'fg', 15, 43, 0, 1364996318),
	(70, 'df', 15, 0, 0, 1365128481),
	(71, 'sd', 15, 0, 0, 1365128810),
	(72, '^^', 15, 26, 0, 1365864247),
	(73, 'd', 15, 26, 0, 1365864389),
	(74, 'dw', 15, 43, 0, 1365864419),
	(75, 'dwedas', 15, 43, 0, 1365864448),
	(76, 'sd', 15, 47, 0, 1365865119),
	(77, 'ds', 15, 39, 0, 1365865191),
	(78, 'ewer', 15, 77, 0, 1365865249),
	(79, 'se', 15, 44, 0, 1365865352),
	(80, 'dw', 15, 79, 0, 1365865949),
	(81, 'dfe', 15, 67, 0, 1365867359),
	(82, 'fghj', 15, 55, 0, 1365867578),
	(83, 'jh', 15, 54, 0, 1365867772),
	(84, 'das', 15, 54, 0, 1365867946),
	(85, 'e', 15, 54, 0, 1365868322),
	(86, 'w', 15, 54, 0, 1365868387),
	(87, 'e', 15, 54, 0, 1365868422),
	(88, 'eredfsdfs', 15, 54, 0, 1365868475),
	(89, 'ads', 15, 54, 0, 1365868531),
	(90, 'fer', 15, 89, 0, 1365868590),
	(91, 'fse', 15, 89, 0, 1365868659),
	(92, 'fse', 15, 89, 0, 1365868708),
	(93, 'sdawda', 15, 89, 0, 1365868897),
	(94, 'ad', 15, 89, 0, 1365868936),
	(95, 'aw', 15, 89, 0, 1365868964),
	(96, 'sdaw', 15, 89, 0, 1365869032),
	(97, 'sda', 15, 54, 0, 1365869227),
	(98, 'dsfe', 15, 94, 0, 1365869325),
	(99, 'sdw', 15, 82, 0, 1365871339),
	(100, 'wd', 15, 96, 0, 1365873832),
	(101, 'e', 15, 58, 0, 1365874242),
	(102, 'test', 15, 101, 0, 1365874550),
	(103, 'dwds', 15, 62, 0, 1365874779),
	(104, 'hahaha', 15, 103, 0, 1365874901),
	(105, 'effs', 15, 104, 0, 1365875034),
	(106, 'efsd', 15, 105, 0, 1365875158),
	(107, 'efsfeeeeeeeeeeeee', 15, 106, 0, 1365875218),
	(108, 've', 15, 91, 0, 1365875235),
	(109, 'shaw?', 15, 37, 0, 1370559880),
	(110, 'dfes', 15, 75, 0, 1370569978),
	(111, 'sdfsdfs', 15, 43, 0, 1372236162),
	(112, 'ghg', 15, 35, 0, 1374681529),
	(113, 'Waf', 15, 107, 0, 1377244996),
	(114, 'Thu muc moi tao', 15, 0, 0, 1377245738),
	(115, 'sdfefsf', 15, 0, 0, 1416592916),
	(116, 'awf', 15, 111, 0, 1416593255),
	(117, 'asfaw', 15, 111, 0, 1416593270),
	(118, 'rtee', 15, 113, 0, 1416594262),
	(119, 'thruru', 15, 118, 0, 1416594293);
/*!40000 ALTER TABLE `folders` ENABLE KEYS */;


-- Dumping structure for table demo_alpha.permissions
DROP TABLE IF EXISTS `permissions`;
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- Dumping data for table demo_alpha.permissions: ~21 rows (approximately)
DELETE FROM `permissions`;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
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
	(19, 'fileManagers.folderItems', NULL, '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(20, 'fileManagers.getFolderTree', NULL, '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(21, 'fileManagers.createFolder', NULL, '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;


-- Dumping structure for table demo_alpha.roles
DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `level` int(11) NOT NULL,
  `description` text NOT NULL,
  `actived` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table demo_alpha.roles: 2 rows
DELETE FROM `roles`;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `level`, `description`, `actived`) VALUES
	(1, 'ADMIN_ROLE', 1, 'ADMIN', NULL),
	(2, 'USER_ROLE', 2, 'USER', NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;


-- Dumping structure for table demo_alpha.roles_permissions
DROP TABLE IF EXISTS `roles_permissions`;
CREATE TABLE IF NOT EXISTS `roles_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- Dumping data for table demo_alpha.roles_permissions: ~21 rows (approximately)
DELETE FROM `roles_permissions`;
/*!40000 ALTER TABLE `roles_permissions` DISABLE KEYS */;
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
	(21, 1, 21, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `roles_permissions` ENABLE KEYS */;


-- Dumping structure for table demo_alpha.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `actived` tinyint(1) NOT NULL DEFAULT '0',
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table demo_alpha.users: 2 rows
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `actived`, `first_name`, `last_name`, `email`) VALUES
	(1, 'admin', '5ad24ecdb36ba3fcfe1a8e3d0d2ae327f508dcdc', 1, 'ckmn', 'ckmn', NULL),
	(3, 'user', '5ad24ecdb36ba3fcfe1a8e3d0d2ae327f508dcdc', 0, 'user', 'account', NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Dumping structure for table demo_alpha.users_permissions
DROP TABLE IF EXISTS `users_permissions`;
CREATE TABLE IF NOT EXISTS `users_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table demo_alpha.users_permissions: ~0 rows (approximately)
DELETE FROM `users_permissions`;
/*!40000 ALTER TABLE `users_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_permissions` ENABLE KEYS */;


-- Dumping structure for table demo_alpha.users_roles
DROP TABLE IF EXISTS `users_roles`;
CREATE TABLE IF NOT EXISTS `users_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table demo_alpha.users_roles: 2 rows
DELETE FROM `users_roles`;
/*!40000 ALTER TABLE `users_roles` DISABLE KEYS */;
INSERT INTO `users_roles` (`id`, `user_id`, `role_id`) VALUES
	(1, 1, 1),
	(2, 1, 2);
/*!40000 ALTER TABLE `users_roles` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
