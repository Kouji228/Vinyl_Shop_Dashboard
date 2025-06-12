-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-06-12 13:40:26
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `yi`
--

-- --------------------------------------------------------

--
-- 資料表結構 `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `company`
--

INSERT INTO `company` (`id`, `name`) VALUES
(1, '未知'),
(2, 'Sony Music'),
(3, 'Universal Music'),
(4, 'Warner Music'),
(5, '滾石唱片'),
(6, '相信音樂'),
(7, '環球 UNI'),
(8, 'Steeplechase'),
(9, 'Concord Records'),
(10, '測試'),
(11, '測試'),
(12, '測試'),
(13, '144'),
(14, '144'),
(15, '145'),
(16, '145'),
(17, '145'),
(18, '145'),
(19, '145'),
(20, '145'),
(21, '145'),
(22, '145'),
(23, 'Sony Music JP'),
(24, 'YHM Indie'),
(25, '音橋 ENRICH'),
(26, 'Analogue Productions'),
(27, 'Music On Vinyl'),
(28, 'Hydeout Productions'),
(29, 'UNI JP'),
(30, 'DECCA'),
(31, 'JYP Entertainment'),
(32, 'JYP Entertainment'),
(33, 'Universal'),
(34, 'IMPEX'),
(35, 'Warner Classics'),
(36, 'Deutsche Grammophon'),
(37, 'Original Jazz Classics'),
(38, 'MPS'),
(39, 'VERVE'),
(40, 'KKV'),
(41, '環球 UNI'),
(42, '環球 UNI'),
(43, '145'),
(44, '144'),
(45, '144'),
(46, '滾石 ROCK'),
(47, 'The Lost Recordings'),
(48, 'Diggers Factory'),
(49, 'Blue Note'),
(50, 'Mondo'),
(51, 'Milan Records'),
(52, 'Stereo Sound'),
(53, '華納 WAR'),
(54, 'Blix Street Records'),
(55, 'Commmons'),
(56, 'Studio Ghibli Records'),
(57, 'Mack Avenue'),
(58, '禾廣娛樂'),
(59, 'Pure Pleasure Records'),
(60, 'Rhino'),
(61, 'Ozella Music'),
(62, 'Speakers Corner Records'),
(63, 'ECM'),
(64, 'Sony Music'),
(65, 'Steeplechase'),
(66, 'JYP Entertainment');

-- --------------------------------------------------------

--
-- 資料表結構 `condition`
--

CREATE TABLE `condition` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `condition`
--

INSERT INTO `condition` (`id`, `name`) VALUES
(1, 'Mint'),
(2, 'Near Mint'),
(3, 'Excellent'),
(4, 'Very Good'),
(5, 'Good');

-- --------------------------------------------------------

--
-- 資料表結構 `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `url` varchar(200) DEFAULT NULL,
  `o_vinyl_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `images`
--

INSERT INTO `images` (`id`, `url`, `o_vinyl_id`) VALUES
(1, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241121024505_0.jpg&w=800&h=800', 4),
(2, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241121024505_0.jpg&w=800&h=800', 5),
(3, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241121024505_0.jpg&w=800&h=800', 7),
(4, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241121050636_0.jpg&w=800&h=800', 8),
(5, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241121051143_0.jpg&w=800&h=800', 9),
(6, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241121051507_0.jpg&w=800&h=800', 10),
(7, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241202030526_0.jpg&w=800&h=800', 11),
(8, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241203103429_0.jpg&w=800&h=800', 12),
(9, '1749377696.jpg', NULL),
(10, '1749438048.jpg', NULL),
(11, '1749438215.jpg', NULL),
(12, '1749440874.jpg', NULL),
(13, '1749440922.jpg', NULL),
(14, '1749455059.jpg', NULL),
(15, '1749458231.jpg', NULL),
(16, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241121030137_0.jpg&w=800&h=800', 16),
(17, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241121032020_0.jpg&w=800&h=800', 17),
(18, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241121033410_1.jpg&w=800&h=800', 18),
(19, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241121033731_0.jpg&w=800&h=800', 19),
(20, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241121034227_0.jpg&w=800&h=800', 20),
(21, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241122033808_0.jpg&w=800&h=800', 21),
(22, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241128083546_0.jpg&w=800&h=800', 22),
(23, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241129050844_0.jpeg&w=800&h=800', 23),
(24, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241130041125_0.jpg&w=800&h=800', 24),
(25, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241205011013_0.jpg&w=800&h=800', 25),
(26, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241206012111_1.jpg&w=800&h=800', 26),
(27, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241206044018_0.jpg&w=800&h=800', 27),
(28, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241206044243_0.jpg&w=800&h=800', 28),
(29, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241209022144_0.jpg&w=800&h=800', 29),
(30, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241216104411_0.jpg&w=800&h=800', 30),
(31, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241217040812_0.jpg&w=800&h=800', 31),
(32, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241218121942_0.jpg&w=800&h=800', 32),
(33, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241225105722_1.jpg&w=800&h=800', 33),
(34, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241230124715_0.jpg&w=800&h=800', 34),
(35, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20250102051745_0.jpg&w=800&h=800', 35),
(36, '1749537319.png', NULL),
(37, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/88875113241.jpg&w=800&h=800', 37),
(38, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/88875113251.jpg&w=800&h=800', 38),
(39, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/88875113261.jpg&w=800&h=800', 39),
(40, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20230805042604_0.jpg&w=800&h=800', 40),
(41, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/2564656877.jpg&w=800&h=800', 41),
(42, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240507122654_0.jpg&w=800&h=800', 42),
(43, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20230203042048_0.jpg&w=800&h=800', 43),
(44, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/88875099781.jpg&w=800&h=800', 44),
(45, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/4795120.jpg&w=800&h=800', 45),
(46, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20250213113250_0.jpg&w=800&h=800', 46),
(47, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240402025538_0.jpg&w=800&h=800', 47),
(48, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/88875057597.jpg&w=800&h=800', 48),
(49, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/88875077627.jpg&w=800&h=800', 49),
(50, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240417042307_0.jpg&w=800&h=800', 50),
(51, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/MOVATM038.jpg&w=800&h=800', 51),
(52, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20231223111019_0.jpg&w=800&h=800', 52),
(53, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240618050521_0.jpg&w=800&h=800', 53),
(54, 'https://www.shsmusic.tw/module/nopic.jpg', 54),
(55, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20230211101509_0.jpg&w=800&h=800', 55),
(56, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/2564604914.jpg&w=800&h=800', 56),
(57, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/4793189.jpg&w=800&h=800', 57),
(58, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20230523044856_0.jpg&w=800&h=800', 58),
(59, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/0885470006512.jpg&w=800&h=800', 59),
(60, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/4795299.jpg&w=800&h=800', 60),
(61, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20230807014206_0.jpeg&w=800&h=800', 61),
(62, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20230817034514_0.jpg&w=800&h=800', 62),
(63, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/0209874MSW.jpg&w=800&h=800', 63),
(64, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/FXLP200.jpg&w=800&h=800', 64),
(65, '1749648838.jpg', NULL),
(66, '1749649243.jpg', NULL),
(67, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240603051956_0.jpg&w=800&h=800', 65),
(68, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240604124656_0.jpg&w=800&h=800', 66),
(69, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240604050309_0.jpg&w=800&h=800', 67),
(70, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240604053527_0.jpg&w=800&h=800', 68),
(71, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240604053913_0.jpg&w=800&h=800', 69),
(72, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240604054157_0.jpg&w=800&h=800', 70),
(73, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240604055814_1.jpg&w=800&h=800', 71),
(74, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240604060136_1.jpg&w=800&h=800', 72),
(75, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240605111756_0.jpg&w=800&h=800', 73),
(76, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240605112817_0.jpg&w=800&h=800', 74),
(77, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240605013435_0.jpg&w=800&h=800', 75),
(78, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240605042906_0.jpg&w=800&h=800', 76),
(79, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240605043738_0.jpg&w=800&h=800', 77),
(80, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240606121801_2.jpg&w=800&h=800', 78),
(81, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240607113752_0.jpg&w=800&h=800', 79),
(82, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240607020450_0.jpg&w=800&h=800', 80),
(83, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240607021621_0.jpg&w=800&h=800', 81),
(84, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240608020219_1.jpg&w=800&h=800', 82),
(85, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240608054907_0.jpg&w=800&h=800', 83),
(86, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240611113544_0.jpg&w=800&h=800', 84),
(87, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240611123707_0.jpg&w=800&h=800', 85),
(88, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240613104640_0.jpg&w=800&h=800', 86),
(89, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240613112714_0.jpg&w=800&h=800', 87),
(90, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240613121257_0.jpg&w=800&h=800', 88),
(91, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240613013905_0.jpg&w=800&h=800', 89),
(92, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240613014340_0.jpg&w=800&h=800', 90),
(93, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240613042614_0.jpg&w=800&h=800', 91),
(94, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240613050020_0.jpg&w=800&h=800', 92),
(95, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240614012140_0.jpg&w=800&h=800', 93),
(96, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240615025508_0.jpg&w=800&h=800', 94),
(97, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240615030148_0.jpg&w=800&h=800', 95),
(98, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240617010847_0.jpg&w=800&h=800', 96),
(99, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240617011639_0.jpg&w=800&h=800', 97),
(100, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240617052245_0.jpg&w=800&h=800', 98),
(101, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241206025951_0.jpg&w=800&h=800', 99),
(102, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240618122123_0.jpg&w=800&h=800', 100),
(103, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240618123444_0.jpg&w=800&h=800', 101),
(104, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240618123825_0.jpg&w=800&h=800', 102),
(105, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240618124130_0.jpg&w=800&h=800', 103),
(106, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240619030826_0.jpg&w=800&h=800', 104),
(107, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240620120808_0.jpg&w=800&h=800', 105),
(108, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240622043314_0.jpg&w=800&h=800', 106),
(109, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240625050148_0.jpg&w=800&h=800', 107),
(110, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240626104938_0.jpg&w=800&h=800', 108),
(111, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240626105644_0.jpg&w=800&h=800', 109),
(112, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240626110657_0.jpg&w=800&h=800', 110),
(113, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240626111459_0.jpg&w=800&h=800', 111),
(114, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240627054850_0.jpg&w=800&h=800', 112),
(115, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240628013821_0.jpg&w=800&h=800', 113),
(116, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240628015324_0.jpg&w=800&h=800', 114),
(117, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240629034350_0.jpg&w=800&h=800', 115),
(118, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240828014402_1.jpg&w=800&h=800', 116),
(119, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240703052811_0.jpg&w=800&h=800', 117),
(120, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240706112212_2.jpg&w=800&h=800', 118),
(121, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240710103045_2.jpg&w=800&h=800', 119),
(122, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240727035228_0.jpg&w=800&h=800', 120),
(123, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240715102942_0.jpg&w=800&h=800', 121),
(124, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240717020825_0.jpg&w=800&h=800', 122),
(125, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240717031045_0.jpg&w=800&h=800', 123),
(126, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240717032104_0.jpg&w=800&h=800', 124),
(127, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240723022054_0.jpg&w=800&h=800', 125),
(128, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240717040524_0.jpg&w=800&h=800', 126),
(129, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240717041224_0.jpg&w=800&h=800', 127),
(130, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240717042042_0.jpg&w=800&h=800', 128),
(131, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240717042306_0.jpg&w=800&h=800', 129),
(132, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240717042532_0.jpg&w=800&h=800', 130),
(133, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240720115648_0.jpg&w=800&h=800', 131),
(134, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240720032105_0.jpg&w=800&h=800', 132),
(135, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240722020450_0.jpg&w=800&h=800', 133),
(136, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240723024632_0.jpg&w=800&h=800', 134),
(137, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240723025547_0.jpg&w=800&h=800', 135),
(138, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240726045322_0.jpg&w=800&h=800', 136),
(139, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240730050136_0.jpg&w=800&h=800', 137),
(140, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240801105516_0.jpg&w=800&h=800', 138),
(141, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240803103919_0.jpg&w=800&h=800', 139),
(142, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240803032451_0.jpg&w=800&h=800', 140),
(143, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240803033933_0.jpg&w=800&h=800', 141),
(144, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240803034559_0.jpg&w=800&h=800', 142),
(145, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240805042529_0.jpg&w=800&h=800', 143),
(146, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240805042805_0.jpg&w=800&h=800', 144),
(147, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240805043203_0.jpg&w=800&h=800', 145),
(148, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240812041703_0.jpg&w=800&h=800', 146),
(149, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240928125223_0.jpg&w=800&h=800', 147),
(150, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240928125259_0.jpg&w=800&h=800', 148),
(151, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240807035341_0.jpg&w=800&h=800', 149),
(152, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240808030502_0.jpg&w=800&h=800', 150),
(153, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240810033728_0.jpg&w=800&h=800', 151),
(154, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240813011552_0.jpg&w=800&h=800', 152),
(155, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240813042537_0.jpg&w=800&h=800', 153),
(156, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240816053611_0.jpg&w=800&h=800', 154),
(157, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240928125417_0.jpg&w=800&h=800', 155),
(158, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240823020453_0.jpg&w=800&h=800', 156),
(159, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240823040459_0.jpg&w=800&h=800', 157),
(160, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240824034156_0.jpg&w=800&h=800', 158),
(161, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240827032010_0.jpg&w=800&h=800', 159),
(162, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240827033603_0.jpg&w=800&h=800', 160),
(163, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20250410092605_0.jpg&w=800&h=800', 161),
(164, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240828051532_0.jpg&w=800&h=800', 162),
(165, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240906050542_1.jpg&w=800&h=800', 163),
(166, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240912051734_0.jpg&w=800&h=800', 164),
(167, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241205033427_1.jpg&w=800&h=800', 165),
(168, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241213102130_0.jpg&w=800&h=800', 166),
(169, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241005102444_0.jpg&w=800&h=800', 167),
(170, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241005105326_0.jpg&w=800&h=800', 168),
(171, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241007101411_0.jpg&w=800&h=800', 169),
(172, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241007101737_0.jpg&w=800&h=800', 170),
(173, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241011112035_0.jpg&w=800&h=800', 171),
(174, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241011113206_0.jpg&w=800&h=800', 172),
(175, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241013105211_0.jpg&w=800&h=800', 173),
(176, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241022035327_0.jpg&w=800&h=800', 174),
(177, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241025050823_0.jpg&w=800&h=800', 175),
(178, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241102102907_0.jpg&w=800&h=800', 176),
(179, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241102103357_0.jpg&w=800&h=800', 177),
(180, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241122033808_0.jpg&w=800&h=800', 178),
(181, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241128083546_0.jpg&w=800&h=800', 179),
(182, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241206012111_1.jpg&w=800&h=800', 180),
(183, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241206044018_0.jpg&w=800&h=800', 181),
(184, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241206044243_0.jpg&w=800&h=800', 182),
(185, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241206044759_0.jpg&w=800&h=800', 183),
(186, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/PPAN002.jpg&w=800&h=800', 184),
(187, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/88875140841.jpg&w=800&h=800', 185),
(188, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/88875150177.jpg&w=800&h=800', 186),
(189, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/88875146151.jpg&w=800&h=800', 187),
(190, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/88875137051.jpg&w=800&h=800', 188),
(191, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/88875157581.jpg&w=800&h=800', 189),
(192, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/88875124431.jpg&w=800&h=800', 190),
(193, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20230211051416_0.jpg&w=800&h=800', 191),
(194, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/8122795427.jpg&w=800&h=800', 192),
(195, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240925021019_0.jpg&w=800&h=800', 193),
(196, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/8122797160.jpg&w=800&h=800', 194),
(197, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/CUP016.jpg&w=800&h=800', 195),
(198, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/CUR016.jpg&w=800&h=800', 196),
(199, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/OZ1056LP.jpg&w=800&h=800', 197),
(200, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/2530653.jpg&w=800&h=800', 198),
(201, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20231002021522_0.jpg&w=800&h=800', 199),
(202, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/88875139881.jpg&w=800&h=800', 200),
(203, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20240617013345_0.jpg&w=800&h=800', 201),
(204, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20231103042821_0.jpg&w=800&h=800', 202),
(205, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/pro_20241012101917_0.jpg&w=800&h=800', 203),
(206, 'https://www.shsmusic.tw/module/smallimg3.php?path=product/8106221.jpg&w=800&h=800', 204),
(207, '1749719011.jpg', NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `lp`
--

CREATE TABLE `lp` (
  `id` int(11) NOT NULL,
  `size` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `lp`
--

INSERT INTO `lp` (`id`, `size`) VALUES
(1, '1LP'),
(2, '2LP'),
(3, '3LP'),
(4, '4LP'),
(5, '5LP以上');

-- --------------------------------------------------------

--
-- 資料表結構 `main_category`
--

CREATE TABLE `main_category` (
  `id` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `main_category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `main_category`
--

INSERT INTO `main_category` (`id`, `title`, `main_category_id`) VALUES
(1, '古典', NULL),
(2, '爵士', NULL),
(3, '西洋', NULL),
(4, '華語', NULL),
(5, '日韓', NULL),
(6, '原聲帶', NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `o_vinyl`
--

CREATE TABLE `o_vinyl` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `listing_date` datetime DEFAULT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 1,
  `main_category_id` int(11) NOT NULL,
  `sub_category_id` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `condition_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `lp_id` int(11) DEFAULT NULL,
  `list` text DEFAULT NULL,
  `desc` varchar(500) DEFAULT NULL,
  `is_valid` int(11) NOT NULL DEFAULT 1,
  `creatTime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `o_vinyl`
--

INSERT INTO `o_vinyl` (`id`, `name`, `listing_date`, `price`, `stock`, `main_category_id`, `sub_category_id`, `image_id`, `condition_id`, `status_id`, `release_date`, `company_id`, `lp_id`, `list`, `desc`, `is_valid`, `creatTime`) VALUES
(8, '普契尼：歌劇《波西米亞人》全曲 (豪華套裝黑膠限量版)Puccini : La Bohème', '2025-06-07 23:54:56', 3580, 0, 1, 4, 4, 4, 2, '2024-11-19', 42, 2, '0', '★麻質布紋外盒，精美原有文字與設計加上全新專文，A4收藏海報☆1972年原始母帶Remaster普契尼的《波西米亞人》是一部永恆的歌劇傑作，通過無與倫比的美麗和敏銳的音樂，傳遞出愛情的狂喜與痛苦，感動了世世代代的觀眾。這部作品不僅帶來無盡的喜悅，還能在悲劇的結尾深深打動聽眾。為紀念普契尼逝世百週年，笛卡公司將1972年由帕華洛帝、芙蕾妮、卡拉揚合作的經典錄音以高解析度24-bit 192 kHz轉錄，並附上一本豪華多語言精裝書。內容包括國際知名歌劇作家羅傑•派恩斯（Roger Pines）的全新專文；帕華洛帝、芙蕾妮和卡拉揚的個人特寫；笛卡新晉男高音托馬索撰寫的關於普契尼、帕華洛帝和《波西米亞人》的專文；完整的義大利語歌詞及英文、德文翻譯；錄音期間珍貴照片以及1920年代風格的《波西米亞人》A4收藏海報。專輯在1973年首度出版時，《留聲機》雜誌即稱「笛卡組建了一個超越以往版本的歌唱陣容」，並公認為帕華洛帝巔峰時期的最佳錄音。卡拉揚精通歌劇的每一個細節，通過樂團巧妙展現歌劇的內在戲劇性與浪漫精神；芙蕾妮與帕瓦洛第在第三幕告別二重唱，被《BBC音樂雜誌》讚為「足以讓石頭落淚', 1, '2025-06-09 10:41:49'),
(9, '天使的孩子與變奏曲(2024年再版)\nEnglaborn & Variuations', '2025-06-07 23:55:05', 1500, 3, 1, 5, 5, 2, 3, '2024-11-19', 7, 2, '0', '★經典名作¸母帶後製再次呈現 \n\n《天使的孩子》（Englabörn）是冰島作曲家約翰於2002年出版的第一張個人專輯。原有的母帶經過重新後製，加上約翰為電影《慈悲的汪洋》所寫的歌曲Karen Býr Til Engil，以及由國際知名音樂家，如：坂本龍一、音樂團體A Winged Victory for the Sullen與Theater of Voices、美國視覺藝術家與音樂家索梅爾斯，還有冰島鋼琴家維京古爾的重新創作變奏，以更豐潤完美的音質，由DG重新出版！\n\n約翰的作品被歸類在極簡主義的領域裡，也有人稱他是新古典主義作曲家，作品同時融合電子音樂與持續音音樂。《天使的孩子》原本是約翰為同名冰島戲劇所寫的音樂，經過重新修改與創作以後，透過弦樂四重奏、鋼琴、管風琴、鐘琴、打擊樂器以及電子樂器編制，從表現古羅馬詩人卡圖盧斯的著名詩歌《愛恨交織》開始，以十六首小曲表現出愛與恨等各種對立、正反兩面的情感間的平衡。每一首曲子都是獨立的作品，也都像是一幕戲劇場景。約翰的音樂非常細膩，像是集合各種不斷變化的情緒，但是聲響卻又能同時保持簡潔深刻。', 1, '2025-06-09 10:41:49'),
(10, '索柯洛夫演奏莫札特、普賽爾鋼琴作品輯\nPurcell & Mozart', '2025-06-07 23:55:12', 1680, 1, 1, 1, 6, 1, 1, '2024-11-19', 7, 3, '0', '告別協奏曲、室內樂音樂會以及錄音室後，索柯洛夫全心投入獨奏會。每個樂季，他僅安排一套曲目，昏暗的燈光、特有的進場與退場方式，以及全神貫注於史坦威鋼琴前的魁梧身影，這些都成為索柯洛夫迷人魅力的一部分。他在歐洲的獨奏會已經成為許多忠實愛樂者的朝聖之旅。\n\n在2022/2023樂季，索柯洛夫將約七十場演出的重心放在莫札特和普賽爾的作品上，展示這兩位作曲家共同的魅力與憂鬱。這張專輯匯集了他在西班牙的兩場演出：上半場來自八月十八日在桑坦德坎塔布里亞節慶宮的獨奏會，莫札特第十三號鋼琴奏鳴曲與為鋼琴而寫的慢板則是兩天前在聖塞巴斯提安音樂節的演出實況。\n\n在普賽爾的作品中，索柯洛夫展現了細膩平衡的觸鍵、柔和多變的斷奏、狂熱的顫音與清晰的高音聲部，再加上音樂線條的透明度，這些都是在大鍵琴上難以實現的。而在莫札特的作品裡，索柯洛夫注入了清晰的重音和孩童般的純真、深刻的憂鬱與平靜等待命運的溫柔哀嘆，完美結合了巴洛克的魅力與古典的優雅。\n\n每場演出結束後，索柯洛夫都安排了五到六首安可曲。從拉摩的《野人》、E小調鈴鼓舞曲，到蕭邦的《雨滴前奏曲》與F小調馬祖卡舞曲，每首曲目都為這段音樂之旅增添了深度。專輯以西洛季', 1, '2025-06-09 10:41:49'),
(11, 'When Sunny Gets Blue', '2025-06-07 23:59:59', 1380, 1, 2, 8, 7, 1, 1, '2024-11-08', 65, 1, '1', 'The last of the seven recordings Chet Baker made for SteepleChase is from 1986. Chet visited Copenhagen in February 1986 to make a TV show and then went into a Copenhagen studio with American/European first-rate rhythm section. It was two years before his tragic and untimely death in Amsterdam at age 58. Bakers life was still shaky but productive as far as recordings and live performance are concerned.', 1, '2025-06-09 10:41:49'),
(12, 'Way out West (Contemporary Records Acoustic Sounds Series edition)', '2025-06-08 00:00:12', 1280, 1, 2, 8, 8, 1, 1, '2024-12-06', 9, 1, '1', 'Sonny Rollins 向西部片致敬的概念專輯大碟！ \n企鵝爵士評鑑三星半、ＡＭＧ 五顆星高分評價！ \n\n啟發了 1950 年代爵士樂即興演奏的次中音薩克斯風大師 Sonny Rollins，在 1957 年三月加入 Max Roach 五重奏時，有感於許多紐約年輕人是在西部片陪伴之下成長的，而啟發了他以前進西方、漫遊在西方大地作為概念，創造出一張專輯；他在凌晨三點開始進行了長達四小時的錄音，以充滿熱情、溫潤飽滿的樂音，讓聽眾彷彿感受到神遊廣大的美國大西部所帶來的感觸與震撼。', 1, '2025-06-09 10:41:49'),
(16, '鋼鐵帝國(黑白飛濺彩膠)\nBritish Steel (Black & White Splatter Vinyl )', '2025-06-10 10:32:01', 1080, 1, 3, 14, 16, 1, 1, '2024-11-08', 2, 1, '0', '★葛萊美「最佳金屬演出」+MTV台「史上偉大金屬樂團」+VH1頻道「史上最偉大藝人」等多重榮耀加持的英國金屬之神，1980年第六張錄音室專輯，全新進口黑白飛濺彩膠版本\n★全英排行榜TOP 4，滾石雜誌評鑑史上百大金屬樂專輯排行第三名，開啟1980年代搖滾盛世之金屬曠世經典\n★收錄\"Breaking the Law\" , \"Living After Midnight\" 等搖滾經典\n\n冠以「金屬之神Metal Gods」封號的Judas Priest，少數經歷搖滾黃金年代、另類搖滾崛起、搖滾式微的改朝換代，完全不受後起新秀的威脅，依然屹立不搖持續發行叱吒排行作品！拿下葛萊美「最佳金屬演出」喝采，榮登MTV台「史上偉大金屬樂團」亞軍，進入VH1頻道「史上最偉大藝人」以及「搖滾榮耀」行列，全球突破5000萬張銷售量\n就如同重金屬名團Anthrax吉他手Scott Ian所說，這是一張真正定義重金屬的專輯。發行於1980年，巧妙地將搖滾注入更具侵略性的音量，更加琢磨每首歌的旋律感，終於獲得商業成功，打入主流市場，正式開啟80年代重金屬樂團大爆發。\n ', 1, '2025-06-10 10:56:34'),
(17, '最後一片落葉(落葉色雙彩膠)\nLast Leaf On The Tree', '2025-06-10 10:32:11', 1480, 1, 3, 12, 17, 1, 1, '2024-11-08', 2, 2, '0', '★葛萊美獎鄉村搖滾傳奇，第76張個人錄音室專輯，全新進口落葉色雙彩膠版本\n★歡慶91歲大壽，由兒子專輯Micah Nelson操刀製作，收錄完美重新演繹Tom Waits, Neil Young, Keith Richards, Nina Simone等傳奇音樂人之經典作品，以及自身早期經典歌曲“The Ghost”全新詮釋版本錄音\n ', 1, '2025-06-10 10:56:34'),
(18, '亞歷山大技巧The Alexander Techniqu', '2025-06-10 10:32:24', 1498, 1, 3, 12, 18, 1, 1, '2024-11-08', 64, 2, '0', '◎ 英倫音樂才子暌違近2年、被自身譽為「至今最有野心之作」的第5張專輯\r\n◎ 專輯以改善姿勢與身體意識的方法「亞歷山大技巧」為題，用鋼琴、爵士、獨立響樂的聲線，將自己接受心理治療的療程，面對心理健康的掙扎寫成歌，並期盼用歌曲陪所有相同情況的聽者，共同度過面對自己的陰暗面\r\n◎ 收錄以自己名字為題、接受治療的心情轉換成歌曲的〈Alexander〉、Sufjan Stevens共同創作，回到單純自己的念舊歌〈2008〉、詹姆斯布雷克 (James Blake) 合唱〈Look Me In The Eyes〉等16首歌集結自身最私密的音樂之作', 1, '2025-06-10 10:56:34'),
(19, '亞歷山大技巧 (限量棉花糖餅白色彩膠)\nThe Alexander Technique (Limited S’mores White)', '2025-06-10 10:32:31', 1728, 1, 3, 12, 19, 1, 1, '2024-11-08', 2, 2, '0', '◎ 英倫音樂才子暌違近2年、被自身譽為「至今最有野心之作」的第5張專輯\n◎ 專輯以改善姿勢與身體意識的方法「亞歷山大技巧」為題，用鋼琴、爵士、獨立響樂的聲線，將自己接受心理治療的療程，面對心理健康的掙扎寫成歌，並期盼用歌曲陪所有相同情況的聽者，共同度過面對自己的陰暗面\n◎ 收錄以自己名字為題、接受治療的心情轉換成歌曲的〈Alexander〉、Sufjan Stevens共同創作，回到單純自己的念舊歌〈2008〉、詹姆斯布雷克 (James Blake) 合唱〈Look Me In The Eyes〉等16首歌集結自身最私密的音樂之作', 1, '2025-06-10 10:56:34'),
(20, '迪斯可天堂(紫色彩膠)\nParadise (Purple)', '2025-06-10 10:32:38', 1498, 1, 3, 12, 20, 1, 1, '2024-11-08', 2, 2, '0', '◎ 拿下葛萊美2023年「最佳非古典混音錄製」的德國DJ睽違3年最新專輯\n◎ 傳奇音樂人 Nile Rodgers、Nothing But Thieves、Chromeo、Shenseea、Benjamin Ingrosso，以及Kungs等18組DJ與跨領域音樂人，融合新迪斯可 (Nu-Disco)、浩室 (House)和放克 (Funk) 元素，打造充滿活力和節奏感的舞曲大作\n◎ 收錄2億串流Disco舞曲〈Substitution〉、復古夜色主題曲〈Honey Boy〉等15首舞曲引領你置身跳不停的迪斯可天堂', 1, '2025-06-10 10:56:34'),
(21, '偏偏我卻都記得(限量湖水藍透明膠)', '2025-06-10 10:34:14', 1480, 1, 4, 17, 21, 1, 1, '2024-12-13', 7, 1, '0', '唱作天后 艾怡良 Eve Ai \n《偏偏我卻都記得》\n  2021全創作專輯\n\n「不放過我們的，永遠都是回憶。」\n艾怡良 懺悔後的吿解\n\n唱而優則演  金曲金馬雙料肯定\n艾怡良Ｘ陳建騏  全新懺悔之作  與回憶搏鬥的過程\n\n\n艾怡良睽於2021年發表之專輯作品《偏偏我卻都記得》。回想起從2018年的《垂直活著，水平留戀著。》深獲各界肯定，〈Forever Young〉也讓艾怡良首獲最佳作曲人殊榮。\n\n2019和2020則是以不同形式跨足電影界，2019演唱施立導演的《野雀之詩》電影主題曲〈愛比死更寂寞〉令人驚艷，2020年更發表由自己出演女主角並自己創作的電影《我沒有談的那場戀愛》主題曲〈我這個人〉，再度入圍金曲獎最佳作曲人之外，演技與歌曲也雙獲金馬獎入圍肯定，同時入圍最佳新演員和最佳原創電影歌曲獎。〈我這個人〉也一舉奪下金馬獎最佳原創電影歌曲。\n\n接著，艾怡良即將再從電影女主角身份，回歸創作歌手，2021年交出全新創作專輯《偏偏我卻都記得》，包含〈我這個人〉在內的十一首歌曲，把生活裡的每個部分經過她細心的詮釋後，成為歌曲以音樂形式發表。這次的專輯依舊與熟悉的製作人－陳建騏再度聯手打造', 1, '2025-06-10 10:56:34'),
(22, '慕情', '2025-06-10 10:37:41', 1380, 1, 4, 16, 22, 1, 1, '2025-02-26', 23, 1, '0', 'ピアノの魔術師と謳われる菅野邦彦が TBM に残した唯一のリーダー作品。(TBM 主催 5 DAYS IN JAZZ コンサート録音盤)。エロール・ガーナー直系の”天才クニ”ここにあり。（シリーズ監修：塙耕記氏より）', 1, '2025-06-10 10:56:35'),
(23, 'Tokyo Riddim Vol.2 1979-1986', '2025-06-10 10:37:56', 1380, 1, 5, 22, 23, 1, 1, '2024-11-22', 24, 1, '0', '', 1, '2025-06-10 10:56:35'),
(24, '挑戰者電影原聲帶配樂\nChallengers (Original Score)', '2025-06-10 10:39:26', 1268, 1, 6, 26, 24, 1, 1, '2024-11-29', 2, 1, '0', '    由奧斯卡得主、進入「搖滾名人殿堂」的工業金屬天團Nine Inch Nails首腦Trent Reznor和音樂合作夥伴Atticus Ross，聯合打造電影配樂。\n    來自德國身兼製作人、寫歌者、DJ的Boys Noize參與混音工作。\n\n【關於電影】 \n曾為Dior、Fendi和Salvatore Ferragamo品牌拍攝形象廣告，掌鏡《以你的名字呼喚我》義大利名導盧卡‧格達戈尼諾（Luca Guadagnino）的全新力作《挑戰者 Challengers》，締造破9000萬美金票房，贏取影評普遍讚譽，被封為「史上最性感的電影之一。」除了在球場上的精采比賽橋段，兩男一女的三角戀情，更是讓觀眾心跳加速，他們在球場上競技，在生活中交織愛情、背叛與渴望的激烈對抗。每一個發球、每一次扣殺，都隱喻角色之間的權力轉換與情感糾葛。這部電影充滿激情和張力，是一場視覺與心靈的雙重饗宴。能歌善舞又能演戲，憑藉影集《高校十八禁》拿下兩次艾美獎「最佳劇情類影集女主角」肯定的好萊塢炙手可熱大明星千黛亞（Zendaya），出飾女主角塔希；另外兩大帥氣男演員，分別為：從Netflix自製影集《', 1, '2025-06-10 10:56:35'),
(25, 'BIG WORLD', '2025-06-10 10:41:12', 1580, 1, 5, 22, 25, 1, 1, '2025-03-26', 24, 1, '0', '坂本龍一、満島ひかり、中島美嘉、田島貴男 (Original Love)、中納良恵(EGO-WRAPPIN’)、齋藤飛鳥（乃木坂46）、suis (ヨルシカ)、PORIN (Awesome City Club)、CHAI、どんぐりず、ermhoi (Black Boboi / millennium parade)、RHYMEといった豪華アーティストが参加した、MONDO GROSSOの2022年リリースのアルバム「BIG WORLD」が重量盤でアナログ化。', 1, '2025-06-10 10:56:35'),
(26, '是你', '2025-06-10 10:41:47', 1280, 1, 4, 17, 26, 1, 1, '2024-12-25', 25, 1, '0', '在乎過、堅持過、沮喪過、隱藏過\n現在，我們知道，潘美辰還是我們熟悉的潘美辰\n一如她沒變的聲音、沒變的情感\n以及始終如一的溫度\n\n潘美辰（1969年6月30日—），台灣創作女歌手，以〈我想有個家〉，〈我曾用心愛著你〉等曲廣為人知，至2008年為出道滿20年之周年，發行的專輯與所獲獎項無數。才華不僅是創作，還包括樂器演奏和現場表演，除了於台灣，演藝版圖遍及中國大陸、香港、新加坡和馬來西亞等華語地區。', 1, '2025-06-10 10:56:35'),
(27, '鬥牛場上的鑽石與灰燼 (45轉)\nDiamonds and Rust in the Bullring', '2025-06-10 10:43:40', 2280, 1, 4, 17, 27, 1, 1, NULL, 26, 2, '0', '這張原始僅限量發行的小廠牌黑膠，是 Joan Baez 為數不多的珍貴現場錄音作品之一。1988 年，她在西班牙畢爾包（Bilbao）的鬥牛場演出，雖然當日天候不佳，市民卻依然熱情前來支持，也讓這場演出成為一次難以忘懷的音樂盛會。現場錄音聲音純淨，音質之佳使本專輯成為發燒友間私藏的口耳相傳之作，亞洲原盤行情不斷飆升。\n專輯中除了經典的《Diamonds and Rust》與《Famous Blue Raincoat》兩首廣為人知的名曲，Baez 也特別以西班牙語演唱多首作品，包含巴斯克語歌曲〈Txoria Txori〉，展現她對當地文化的敬意，與觀眾間溫柔的共鳴。\n由 Joan Baez 親自繪製封面插圖，阿根廷傳奇歌手 Mercedes Sosa 亦友情獻聲，堪稱一張結合音樂、文化與歷史意義的極品現場錄音。', 1, '2025-06-10 10:56:35'),
(28, '鬥牛場上的鑽石與灰燼 (33轉)\nDiamonds and Rust in the Bullring', '2025-06-10 10:43:58', 1480, 1, 4, 17, 28, 1, 1, NULL, 26, 1, '0', '這張原始僅限量發行的小廠牌黑膠，是 Joan Baez 為數不多的珍貴現場錄音作品之一。1988 年，她在西班牙畢爾包（Bilbao）的鬥牛場演出，雖然當日天候不佳，市民卻依然熱情前來支持，也讓這場演出成為一次難以忘懷的音樂盛會。現場錄音聲音純淨，音質之佳使本專輯成為發燒友間私藏的口耳相傳之作，亞洲原盤行情不斷飆升。\n專輯中除了經典的《Diamonds and Rust》與《Famous Blue Raincoat》兩首廣為人知的名曲，Baez 也特別以西班牙語演唱多首作品，包含巴斯克語歌曲〈Txoria Txori〉，展現她對當地文化的敬意，與觀眾間溫柔的共鳴。\n由 Joan Baez 親自繪製封面插圖，阿根廷傳奇歌手 Mercedes Sosa 亦友情獻聲，堪稱一張結合音樂、文化與歷史意義的極品現場錄音。', 1, '2025-06-10 10:56:35'),
(29, '雙生自我\nALTER EGO', '2025-06-10 10:44:52', 1280, 1, 5, 21, 29, 1, 1, '2025-02-28', 2, 1, '0', '超級巨星降臨 ! 引領世界潮流指標的流行巨星 LISA 在個人廠牌 LLOUD 旗下推出首張專輯《雙生自我 ALTER EGO》\n\nInstagram全球億人追蹤、個人串流超過20億收聽，引領全球時尚的女王 LISA 出道8年終於推出個人首張專輯《雙生自我 ALTER EGO》，收錄2024年化身巨星的酷帥主題曲〈Rockstar〉、攜手西班牙天后 蘿莎莉雅 (ROSALÍA) 共唱完美女力神曲〈New Woman〉，以及取樣Sixpence None the Richer 經典情歌的〈Moonlit Floor (Kiss Me)〉等共12首歌，2025年初就聽這張，一聽LISA展現火辣與酷帥的巨星魅力。', 1, '2025-06-10 10:56:35'),
(30, '十面埋伏 電影原聲帶\nHouse of Flying Daggers (Gold Vinyl)', '2025-06-10 10:45:18', 1080, 1, 6, 26, 30, 1, 1, '2025-02-07', 27, 1, '1', '《十面埋伏：電影原聲大碟》是繼《英雄》之後，2004年張藝謀另一部矚目的武俠巨獻《十面埋伏》廣受好評。由劉德華、章子怡及金城武領銜主演，此片在康城影展中首映，獲得全場一致讚譽。 章子怡於電影《十面埋伏》中飾演盲女歌姬，於人前載歌載舞，除此之外，她更獻身親自演繹電影主題曲“佳人曲”。而也收錄了世界著名歌劇女歌唱家嘉芙蓮巴特爾（Kathleen Battle）主唱的《十面埋伏》片尾曲“Lovers”，很多歌迷因為此歌而愛上了十面埋伏的音樂，希望你也能聆聽到如此美妙的聲音！\n\n梅林茂是亞洲影壇知名配樂工作者，10餘年來先後為王家衛的《花樣年華》、黎妙雪的《戀之風景》等電影作品譜寫配樂。而《十面埋伏》主題歌演唱者美國人凱薩琳·巴特爾(Kathleen Battle)，則是時下人氣極高的國際歌壇巨星，她曾五度奪得格萊美音樂獎，還將在2004年雅典奧運會開幕式上主唱奧運會會歌。這也是張藝謀執導的影片中，首次啟用國際巨星來演唱主題曲。', 1, '2025-06-10 10:56:35'),
(31, 'Metaphorical Music', '2025-06-10 10:46:04', 1380, 1, 5, 20, 31, 1, 1, NULL, 28, 2, '0', 'アナログのシングルを中心にリリースを重ねてきたnujabesが渾身の力を注ぎ込んで完成させたアルバム『metaphorical music』。多くの人々に愛され続けているhydeout productionsの核となる作品であり、名曲の数々が刻まれている歴史的な名盤。', 1, '2025-06-10 10:56:35'),
(32, 'Candy (45轉)', '2025-06-10 10:46:22', 800, 1, 5, 21, 32, 1, 1, NULL, 29, 1, '1', '90年代を代表するジャパニーズ・アーバン・メロウの傑作として2018年のRECORD STORE DAYで初7インチ・カットされ大きな話題を呼んだ今作を、今回はオリジナルテイクのインストゥルメンタルverを加え、12inch/45rpmカラーレコード仕様でリリース。', 1, '2025-06-10 10:56:35'),
(33, '機動戰士鋼彈UC 動畫原聲帶 (Vol.1+2 合售)', '2025-06-10 10:49:14', 3000, 1, 6, 27, 33, 1, 1, '2025-03-26', 24, 2, '0', 'OVAアニメ『機動戦士ガンダムUC(ユニコーン)』15周年を記念して、劇伴のサウンドトラックからベストセレクトした曲を収録したアナログ盤を発売。\nレコード盤面はカラーヴァイナル仕様。同梱ブックレットには、【音楽：澤野弘之、監督：古橋一浩、プロデューサー：小形尚弘 】との鼎談インタビューを掲載。音楽家・澤野弘之による宇宙世紀を彩る壮大なオーケストラサウンドを、アナログ盤の豊かな音質にてぜひお楽しみください。', 1, '2025-06-10 10:56:35'),
(34, '冰血暴\nFargo Season 1 (Red Vinyl)', '2025-06-10 10:51:16', 980, 1, 6, 26, 34, 1, 1, '2025-01-24', 27, 1, '0', '“This is a true story”\n\nFargo is a fantastic dark comedy-crime drama television series created and written by Noah Hawley and inspired by Joel & Ethan Coen\'s 1996 movie of the same name. Both Coen brothers serve as executive producers on the series. The show stars Martin Freeman (The Hobbit trilogy), Billy Bob Thornton, Bob Odenkirk (Breaking Bad, Better Call Saul) and more.\n\nThe soundtrack features selections from the show\'s original music composed by Jeff Russo (Power, Necessary Roughness, Abo', 1, '2025-06-10 10:56:35'),
(35, '逃離之地 電影原聲帶(海藍膠)\nOutrun', '2025-06-10 10:53:37', 1380, 1, 6, 26, 35, 1, 1, '2025-01-03', 30, 1, '0', '電影《逃離之地》改編自艾米•利普羅特（Amy Liptrot）的暢銷自傳書籍，描述羅娜在倫敦過著混亂的生活後，決定回到故鄉重建自己的生活。約翰‧戈爾特勒（John Gürtler）和米塞爾（Jan Miserre）的配樂無疑是故事中重要的情感引導，從電子音樂到傳統蘇格蘭民謠與蘇格蘭奧克尼群島的自然聲景，構成了一幅迷人的聲音拼圖，創造出既細膩又充滿力量的聲音體驗，帶領聽眾與電影中的主角羅娜一起踏上心靈重生的旅程。\n\n故事中的羅娜在家鄉的自然景色中尋找自我，與過去的痛苦告別，配樂則精準反映出這種旅程的內外層次。重要曲目如《Corncrake》與《The Long Way Home》展現出約翰‧戈爾特勒和米塞爾如何以音樂表達自然、情感與復甦交織的功力。他們運用獨特的樂器，包括水琴、巴氏水晶琴和玻璃琴，把音景帶入更深層次的感知。此外，蘇格蘭風笛手與作曲家Malin Lewis也參與演出，為音樂增添濃厚的傳統民俗色彩。特別設計的創新樂器更為這張原聲帶注入無可比擬的獨特性。\n\n值得一提的是，這張專輯中的部分曲目早在拍攝開始之前就已經完成，讓作曲家深入理解與參與電影拍攝過程。電影導演諾拉•芬沙伊德（', 1, '2025-06-10 10:56:35'),
(36, '周子瑜 首張迷你專輯: abouTZU', NULL, 1515, 1, 5, 21, 36, 1, 1, '2025-06-10', 32, 1, NULL, 'ㄅㄏ會搶到twice 的演唱會票 子瑜讚讚讚', 1, '2025-06-10 14:35:20'),
(37, '天馬行空(2015)\nKinda Kinks', '2025-06-11 17:57:23', 518, 1, 3, 14, 37, 1, 1, '2015-09-08', 2, 1, '1', '◎英國入侵（British Invasion）指標樂隊，與The Beatles、The Who、Rolling Stone齊名的英國搖滾樂隊 ◎馳騁超過30年歲月，榮譽入列美國「搖滾名人殿堂」、英國「音樂名人殿堂」 ◎1965年第二張錄音室專輯 收錄英國金榜冠軍、美國#3冠軍單曲 ◎黑膠母帶重製 180克特殊上色 經典限量珍藏版', 1, '2025-06-11 20:59:20'),
(38, '奇想爭議(2015)\nThe Kink Kontroversy', '2025-06-11 17:57:29', 518, 1, 3, 14, 38, 1, 1, '2015-09-08', 2, 1, '1', '◎英國入侵（British Invasion）指標樂隊，與The Beatles、The Who、Rolling Stone齊名的英國搖滾樂隊 ◎馳騁超過30年歲月，榮譽入列美國「搖滾名人殿堂」、英國「音樂名人殿堂」 ◎1965年發行之第三張錄音室專輯 ◎黑膠母帶重製 180克特殊上色 經典限量珍藏版', 1, '2025-06-11 20:59:20'),
(39, '面對面(2015)\nFace To Face', '2025-06-11 17:57:35', 518, 1, 3, 14, 39, 1, 1, '2015-09-08', 2, 1, '1', '◎英國入侵（British Invasion）指標樂隊，與The Beatles、The Who、Rolling Stone齊名的英國搖滾樂隊 ◎馳騁超過30年歲月，榮譽入列美國「搖滾名人殿堂」、英國「音樂名人殿堂」 ◎1966年發行之第四張錄音室專輯 All Music&滾石雜誌評價滿分五星之經典之作 ◎黑膠母帶重製 180克特殊上色 經典限量珍藏版', 1, '2025-06-11 20:59:20'),
(40, '冠軍全紀錄\nElvis 30 #1 Hits', '2025-06-11 17:57:57', 1180, 1, 3, 12, 40, 1, 1, '2015-09-08', 2, 2, '0', '◎收錄貓王30首冠軍單曲，特別收錄2002年發行的冠軍單曲\n◎2015經典黑膠版本 原始母帶全數重製 30首搖滾之王經典一次擁有\n\n約翰藍儂：「沒有貓王，就沒有披頭四！」\n保羅麥卡尼：「每當我陷入低潮時，就放張貓王的唱片來聽！」\nU2 合唱團主唱Bono：「貓王唱醒了我的心！」\n布蘭妮：「貓王是地球上最性感的男人！」\n工人皇帝布魯斯史普林斯汀：「貓王是我的上帝，如果沒有他，我可能會去推銷百科全書！」\n保羅賽門：「因為貓王，我開始學吉他！」\n滾石合唱團主唱米克傑格：「沒有人能和他相提並論、或是達到和他一樣的成就！」', 1, '2025-06-11 20:59:20'),
(41, '第二法則\nTHE 2ND LAW', '2025-06-11 17:58:37', 1080, 1, 3, 14, 41, 1, 1, NULL, 1, 2, '0', '', 1, '2025-06-11 20:59:20'),
(42, '紅糖\nBrown Sugar', '2025-06-11 17:59:18', 1380, 1, 3, 12, 42, 1, 1, NULL, 33, 2, '0', '《Brown Sugar》是美國 R&B 歌手 D\'Angelo 的首張個人專輯，堪稱新騷靈樂的經典之作。整張專輯以浪漫的愛情為主題，融合當代 R&B 和傳統騷靈樂的精髓，同時加入了 Funk 和 Hip-Hop 的元素。流暢的樂器演奏勾勒出精妙的編曲，D\'Angelo 紮實的音樂功底盡收眼底。即使時隔多年，這依然會是一張讓你感到慾望跟甜蜜的專輯。', 1, '2025-06-11 20:59:20'),
(43, '巫毒\nVoodoo', '2025-06-11 17:59:46', 1680, 1, 3, 12, 43, 1, 1, NULL, 33, 2, '0', '●以處男大作BROWN SUGAR‧熱門金曲LADY大放光芒之性感俊俏新R&B王子 首週進BILLBOARD榜即奪魁之冠軍全\n新力作\n●東岸硬蕊饒舌名團WU-TANG CLAN要腳METHOD MAN‧多年合作搭檔REDMAN鼎力相助超熱門收錄 ：葛萊美最佳女\n主唱蘿倫希爾跨刀新曲JD’S JOINT’\n\n1974年出生於美國維吉尼亞州Richmond，五歲就精通鋼琴，18歲便組成饒舌樂團I.D.U.，並受樂界注意於91年與EMI唱片公司簽下一紙唱 片合約─本名Michael \"D’Angelo\" Archer的黑人R&B男歌手D’Angelo。 繼95年推出全球銷售突破兩百萬張的首張個人專輯「Brown Sugar」後，歷時近六年的精心製作與蘊釀終於推出邁向2000的全新個人力作「Voodoo」。 自小深受Jimi Hendrix、Marvin Gaye、Al Green、Stevie Wonder、Prince等靈魂/搖滾/節奏藍調大師之薰陶，D’Angelo更善加運用其個人獨特的音樂天賦，將靈魂爵士節奏藍調樂推至近乎完美之境 界。94年由D’Angelo製作，集結了Boyz II', 1, '2025-06-11 20:59:20'),
(44, '自由自在: 1970亞特蘭大音樂祭現場實況\nFreedom: Atlanta Pop Festival(Live)', '2025-06-11 18:04:09', 848, 1, 3, 12, 44, 1, 1, '2015-09-08', 2, 2, '0', '◎吉米罕醉克斯生涯最傑出精采之現場 ◎1970年七月四號亞特蘭大音樂祭現場實況 超過30萬人同時醉心搖擺 搖滾魅力無遠弗屆 被視為20世紀最具創意與影響力的音樂家，吉米罕醉克斯(Jimi Hendrix) 以充滿爆發性的演奏風格，使用反饋音效製造刺耳噪音，運用效果器扭曲吉他聲響，這種當時前所未有的表演風格，賦予電吉他演奏無限的想像空間，將搖滾樂推向無人境界。雖然，他不會讀樂譜也不會寫樂譜，但無損於他在音樂領域的傑出貢獻。4年短暫的音樂生涯像一顆耀眼的流星迅速流逝，但他的影響彷彿是一顆恆星般不斷發出光與熱。從放克怪傑George Clinton 到 爵士巨人Miles Davis, 從重金屬吉他大師Steve Vai 到新生代藍調吉他好手 Jonny Lang無一不是從他的音樂中獲得靈感。', 1, '2025-06-11 20:59:20'),
(45, '西貝流士 芬蘭頌和管弦樂名作集\nSibelius: Popular Tone Poems', '2025-06-11 18:13:46', 768, 1, 1, 5, 45, 1, 1, '2015-09-08', 7, 1, '0', '被芬蘭人視為國寶的西貝流士，不但是北歐知名的作曲家，更在歐洲音樂史上佔有獨特的地位。西貝流士的一生貫穿浪漫、國民到現代樂派，幾乎經歷了整整一個世 紀。他的音樂創作宛如一座橋樑，銜接了一個個不同的世代，巧妙的融合了不同的風格，也深深影響著芬蘭近、現代音樂的發展。 西貝流士的作品多取材自芬蘭當地的民族史詩、民間傳說，描繪著北歐冷冽的自然風光。曲中不經意流露的悲苦、哀愁和沉思呈現出深刻的民族情懷。 海伯特．馮．卡拉揚（德語：Herbert von Karajan，1908年4月5日－1989年7月16日），出生於薩爾茨堡，是一位奧地利指揮家、鍵盤樂器演奏家和導演。 卡 拉揚在指揮舞台上活躍70年。他帶領過歐洲眾多頂尖的樂團，並且曾和柏林愛樂樂團有過長達34年的合作關係。他熱衷於錄音和導演，為後人留下了大量的音像 資料（到1988年為止他發行超過1億張唱片約700款錄音），包括眾多的鋼管，歌劇錄音和歌劇電影，涵括從巴洛克，到後浪漫主義歐洲作曲家，甚至部分現 代樂派的作品。其中一些作品，如貝多芬的交響曲還被多次錄製。卡拉揚在音樂界享有盛譽，甚至在中文領域被人稱為「指揮帝王」。 卡拉揚有許 多哲學', 1, '2025-06-11 20:59:20'),
(46, '巴哈《郭德堡變奏曲》(1955年錄音)\nGoldberg Variations, BWV 988', '2025-06-11 18:17:00', 1280, 1, 1, 1, 46, 1, 1, '2015-09-15', 2, 1, '0', '顧爾德 (鋼琴)\n 二十三歲的顧爾德首張錄音室專輯，鋼琴史上的不朽名盤。\n 年少天才的逸興遄飛，令人屏息的詮釋技巧，顧爾德開闢的一頁傳奇。\n 原版復刻，180克雙開紙套裝黑膠唱片。\n 演出長度：38分23秒。', 1, '2025-06-11 20:59:20'),
(47, '巴哈《郭德堡變奏曲》(1981年錄音)\nGoldberg Variations, BWV 988 (1981 Recording)', '2025-06-11 18:17:06', 1280, 1, 1, 1, 47, 1, 1, '2015-09-15', 2, 1, '0', '顧爾德 (鋼琴)\n★ 四十九歲顧爾德打破同一曲目不重複錄音之慣例，再造傳奇的經典。\n★ 退隱晚年的殫精竭慮，巴哈藝術的巔峰詮釋，顧爾德的立體聲郭德堡。\n★ 原版復刻，180克雙開紙套裝黑膠唱片。\n★ 演出長度：51分07秒。', 1, '2025-06-11 20:59:20'),
(48, '【7吋黑膠單曲】帥氣破表\nHandsome', '2025-06-11 18:17:37', 748, 1, 3, 14, 48, 1, 1, '2015-09-15', 2, 1, '0', '◎連續三年提名全英音樂獎的Post-Punk Revival耀眼團隊新輯首波主打 ◎體驗一氣呵成的龐克悸動，帥氣又過癮，入選BBC Radio 1當家主持人Zane Lowe的「Hottest Record In The World」名單 ◎加贈專輯《English Graffiti》製作人，也是Mercury Rev貝斯手Dave Fridmann(The Flaming Lips、Weezer、MGMT)的獨家剪輯版本', 1, '2025-06-11 20:59:20'),
(49, '【7吋黑膠單曲】夢中情人\nDream Lover', '2025-06-11 18:17:44', 748, 1, 3, 14, 49, 1, 1, '2015-09-15', 2, 1, '0', '◎英國BBC「Sound Of 2011」亞軍及NME音樂獎「年度最佳新進樂團」肯定的疫苗樂團新輯第二波主打 ◎入選BBC Radio 1當家主持人Zane Lowe的「Hottest Record In The World」名單 ◎主唱Justin Young形容：「這是我們寫過最棒的流行歌曲」', 1, '2025-06-11 20:59:20'),
(50, '生命之歌\nSongs from the Arc of Life', '2025-06-11 18:28:00', 1480, 1, 1, 2, 50, 1, 1, '2024-06-07', 27, 2, '1', '馬友友Yo-Yo Ma (大提琴)\n凱瑟琳‧史托特Kathryn Stott (鋼琴)\n\n-18座葛萊美獎肯定 ，世紀大提琴大師馬友友60歲的音樂里程碑。\n-回歸古典，19首感動人心馬友友衷心珍愛大提琴小品。\n\n即將在2015年歡度60大壽的大提琴家馬友友，一如往昔行程依然滿檔。比較值得紀念的是，他將受邀在英國倫敦屆滿150周年的「逍遙音樂節」上演出全本巴哈無伴奏大提琴組曲，全長兩小時對任何大提琴家來說，都是體力與實力的考驗。而對音樂家來說，錄製專輯或許也是最棒的生日賀禮—無論是給自己或是獻給樂迷。馬友友和他合作屆滿30年的鋼琴家夥伴凱瑟琳‧史托特長久以來一直在構思一張將他們最鍾愛的作品集合在一起的專輯，可惜遲遲找不到合適時機與形式。回顧過去無數次的合作經驗，終於找到專輯企畫主題：生命。馬友友與史托特於是開始思考：如何用音樂來表現生命的開始與結束？表現回憶、渴望、愛情、痛苦… 他們從眾多傑作中精選最能代表普世人生經驗與意義的樂曲，透過最純真的表現方式，傳達最純粹的價值。\n\n馬友友以巴哈/古諾的聖母頌象徵生命的源起，因為這首音樂不管在形式與內容的深度與廣度都已超越宗教的意義，以舒伯特的聖', 1, '2025-06-11 20:59:20'),
(51, '棉花俱樂部 電影原聲帶\nThe Cotton Club Original Soundtrack', '2025-06-11 18:44:31', 828, 1, 6, 26, 51, 1, 1, '2015-08-17', 27, 1, '0', '★ 歐陸最大經典黑膠唱片發行廠牌之一 Music On Vinyl 高品質 180g 壓片', 1, '2025-06-11 20:59:20'),
(52, '透明\nSurfacing', '2025-06-11 18:44:51', 1080, 1, 4, 17, 52, 1, 1, '2015-09-23', 27, 1, '1', '●自 1998 年推出的首張專輯「Touch」及連續的幾張暢銷專輯以來，莎拉在全球已締造出超過三千萬張的銷售成績。榮獲三座葛萊美大獎：最佳流行演奏獎及兩次最佳女歌手獎的肯定。\n● 創立莉莉絲音樂節，在連續三年舉辦期間，共吸引了超過兩百萬名觀眾，並為公益基金累計超過了七百萬美金之多。\n●全球媒體爭相報導，包括滾石雜誌、時代雜誌及娛樂週刊封面人物。\n★ 1998 年榮獲紐約州長頒發伊利莎白遠見獎，為表彰莎拉對宣揚女性在音樂界工作權不遺餘力的重要貢獻。\n★ 莎拉兼融優雅、神祕、深情的高醇度歌聲，深植全球歌迷心中。\n\n兩屆葛萊美獎最佳流行女歌手得主莎拉‧克勞克蘭，以她獨濯於一般泛泛流行樂音的歌聲以及創作，跳脫出流行商業機制的擺弄，彷彿從一處超越俗塵外的境地，將她對音樂與自我的執著，匯成一道清流注入歌壇。這位來自加拿大的創作歌手不但以清澈蜿蜒川流般的歌聲，服貼了許多聽者的耳朵與心靈，她的創作更是將優美的旋律和展現出時而感動人心、時而露裎信念的多樣面貌歌詞包裹成流行抒情樂界最具個人風格的派別之一。 莎拉從小就學習鋼琴和吉他，同時也受過歌唱訓練。她在八零年代曾組過新浪潮樂團 October Game', 1, '2025-06-11 20:59:20'),
(53, '蕭邦計劃 - 鋼琴與鍵盤聲響的共鳴互動\nThe Chopin Project', '2025-06-11 18:51:45', 1280, 1, 1, 1, 53, 1, 1, NULL, 33, 1, '1', '☆歐拉夫．亞諾茲，鋼琴、合成器等\n☉愛麗絲‧紗良‧奧特，鋼琴\n★以沒有格局限制的觀念，重新定義蕭邦音樂之美\n\n青年作曲家歐拉夫．亞諾茲是當前新世紀音樂創作界中最亮眼的新星。他於1986年出生在冰島的小鎮，2007年首度向世界發聲後，立刻擄獲樂界的目光。歐拉夫作品受到新古典主義、環境音樂（ambient）、電子音樂與極簡主義的影響，音樂語言廣納百川之餘又能保持自己的獨特風格。\n\n歐拉夫一向喜愛蕭邦的作品，但是他對市面上一成不變的完美錄音感到厭倦，萌生出為蕭邦音樂找出新方向的念頭。他和著名青年鋼琴家，熱愛在鋼琴上嘗新，喜愛即興的愛麗絲‧紗良‧奧特合作，創造出這一張與眾不同的蕭邦唱片。\n歐拉夫把非古典唱片錄音的概念帶入這張專輯。為了追求舒適、纖細與迷人但是不完美的聲音，歐拉夫選用一部老舊但是聲音獨具個性的鋼琴，並且以老式器材來錄音。除此之外，歐拉夫還採用各種混音技術、電子合成器，或是加上弦樂五重奏的編製來重新塑造音樂裡的孤獨寂寞或感情，創造夢幻般的環境音景。歐拉夫說:「在這裏可以聽到演奏者的呼吸、觸鍵聲，愛樂者會感覺自己似乎和音樂家十分親近。」，在這個錄音中他再度以沒有格局限制的觀念，重新定', 1, '2025-06-11 20:59:20'),
(54, '月兒高 : 箏音樂', '2025-06-11 18:52:47', 1648, 1, 4, 19, 54, 1, 1, NULL, 1, 1, '0', '黑膠HQ-180gm /歐洲DMM版/雙封套 DMM Direct Metal Mastering直刻銅版製作技術 全球首張以5.6448 Mega Hz 1-bit WSD純數位錄音之古箏音樂 全程選用Tara Labs The One LE頂級線材及IsoTek Nova電源篩檢程式材，以單點直刻技術錄音，務求將 教堂之自然堂音，樂聲之三維型態，更純真地重現樂迷眼前 錄音師之精准捕捉，不論巨集動態或微動態，令聽者譁然 羅晶指法之快而准，則令人目瞪口呆 特別推薦﹕鼓箏戰颱風、茉莉芬芳、綠島小夜曲四重奏', 1, '2025-06-11 20:59:20'),
(55, 'Time Further Out: Miro Reflections', '2025-06-11 18:53:54', 1480, 1, 2, 8, 55, 1, 1, NULL, 34, 1, '1', 'Piano：Dave Brubeck\nSax：Paul Desmond\nBass：Eugene Wright\nDrums：Joe Morello\n  在《Time Out》顛覆節奏慣例後，Dave Brubeck Quartet 再次挑戰聽覺極限，推出延續前作概念的專輯《Time Further Out》。這張專輯於1961年首度發行，並由傳奇母帶工程師 George Marino 親自在 Sterling Sound 使用原始類比母帶重新製作，讓每一個音符都能呈現最真實的爵士靈魂。\n《Time Further Out》是一張實驗性極高的作品，整張專輯圍繞「非傳統拍號」設計，從3/4拍的〈It\'s a Raggy Waltz〉與〈Bluette〉開始，依序進入4/4、5/4、6/4、7/4、8/8，最後以9/8拍的〈Blue Shadows in the Street〉收尾，每首曲目皆展現出 Dave Brubeck 對節奏結構的巧妙掌握與創新精神。\n本作不僅在音樂結構上突破傳統，其封面也延續《Time Out》的現代藝術風格，採用了西班牙超現實主義大師 Joan Miró（胡安·米羅', 1, '2025-06-11 20:59:20'),
(56, '巴哈：郭德堡變奏曲\nBach: Goldberg Variations', '2025-06-11 19:16:51', 980, 1, 1, 1, 56, 1, 1, '2015-10-23', 35, 1, '1', '巴哈是所有作曲家之父，他的作品是引導我前進的唯一途徑。當我覺得疲憊，或是彈奏得不如理想的時候，我就會回到巴哈的音樂懷抱裡。它幫助我調整自己的狀態，給予我全新的力量。巴哈的音樂有其中心，但永遠沒有盡頭…..彈奏巴哈的音樂，你需要去感受自己內在的共鳴、去感受那一份謙虛，詮釋巴哈的音樂絕對是要虛懷若谷….在他的音樂裡你無所遁逃。」 ～亞歷山大．薩洛 為什麼要聽薩洛彈奏巴哈《郭德堡變奏曲》？畢竟，市面上此曲錄音多如繁星，甚至不乏經典名盤，那為什麼我們還是要選擇薩洛的版本？從樂迷的角度來考量，這不只是「鋼琴男神」的光環效應而已，而是感受新時代的巴哈語彙；從薩洛的觀點來說，郭德堡變奏曲代表他面對自己琴藝的深度審視，一個從名人蛻變成為大師的里程碑。 薩洛，我們這個世代最耀眼的鋼琴明星之一，1968年出生於法國巴黎，雖然小時候志願是魔術師，但長大後終究成為十指散發著魔力的鋼琴演奏家。他堅持視譜演奏，他不在家裡擺著鋼琴，塑造了個人的鮮明印象，而參與奧斯卡最佳外語片《愛．慕》的演出，加上從巴洛克鍵盤音樂到現代鋼琴曲目的廣泛錄音，以及多次來台演奏會，更讓他擁有廣大的粉絲。這張2015年最新錄音，薩洛選擇褪去', 1, '2025-06-11 20:59:20'),
(57, '貝多芬第七號交響曲\nBeethoven:Symphonies Nos.7', '2025-06-11 19:19:59', 880, 1, 1, 5, 57, 1, 1, '2015-10-13', 36, 1, '1', '克萊巴可說是二十世紀下半葉最具魅力的指揮家之一。他的錄音數量不多，但是張張經典，也是愛樂者必備的珍藏。 1973年與德勒斯登國立管弦樂團錄製的韋伯《魔彈射手》，是克萊巴事業上重要的里程碑。他花了三個星期的時間排練後錄音，一上市就獲得極大的回響。除了陣容堅強的聲樂家，克萊巴處理韋伯管弦樂時，讓人難以置信的張力讓它時至今日，依然是同曲目的指標。 接下來，克萊巴陸續與維也納愛樂錄下貝多芬第五、七號交響曲，布拉姆斯第四號交響曲與舒伯特第三、八號交響曲，其中最讓人吃驚的，就是貝多芬《命運》交響曲。克萊巴以精準的手法，把它演奏得像是一首全新的曲子。雖然DG最終未能依計畫為克萊巴與維也納愛樂錄製貝多芬九首交響曲，但是五、七號兩部錄音，已經為克萊巴，也為唱片史再造新的里程碑。 企鵝評鑑三星戴花！日本唱片藝術500名曲第一名！ 小克萊巴指揮的貝多芬5號、七號交響曲是一份經典中的經典，錄音技術發展到本世紀中期以後，在那麼多偉大指揮家都一再與一流樂團錄過貝多芬的交響曲之後，幾乎沒有人相信還有誰能在這些音樂中找出更多令人振奮的新素材，可是一九七五年，克萊巴的第五、七號交響曲錄音出現了，全世界的樂評家紛紛嘆了一', 1, '2025-06-11 20:59:20'),
(58, '心靈之歌\nHOW MY HEART SINGS!', '2025-06-11 19:41:14', 1180, 1, 2, 8, 58, 1, 1, NULL, 37, 1, '1', '突破傳統樂器編制的比爾‧伊文斯作品向來被奉為現代爵士鋼琴三重奏的圭臬典範，和其默契渾然天成的貝斯手史考特‧拉法洛及鼓手保羅‧莫提安可謂居功厥偉，遺憾的是前者旋即於交通意外中喪生，傷痛欲絕的伊文斯整整花了一年時間才能重返錄音室，並邀請曾為西索‧泰勒、巴德‧鮑歐等名家伴奏的恰克‧以塞列加入陣容。第二代三重奏的首度合作誕生了兩張經典大碟，其一是全抒情曲目的「月光」，另一張就是由中快板歌曲構成的本作，伊文斯試圖透過此區別凸顯演奏中如歌唱般的特性與即興搖擺時的共鳴效果，也讓整張專輯滿溢著輕盈暢快的流動感。“How My Heart Sings”一曲宛若華爾茲舞步的優雅浪漫琴音極其醉人，鼓與貝斯沉穩輕柔的陪伴唱和使整體呈現合唱團吟詠詩歌般的和諧美感；“Summertime”一曲有別於常見版本的淒苦緩慢，改由以塞列略帶炫技的華麗撩撥繽紛開場，接續由伊文斯採鋼琴明快觸鍵傳遞歡快節奏及帶出主旋律，於輕鬆和樂氛圍中，令人不由自主跟隨輕舞擺動！', 1, '2025-06-11 20:59:20'),
(59, '古爾達1970年代經典名演：巴哈「平均律」全集\nBACH : DAS WOHLTEMPERIERTE KLAVIER', '2025-06-11 19:42:08', 4888, 1, 1, 1, 59, 1, 1, '2015-10-14', 38, 5, '0', '★鋼琴大師古爾達1972、1973年經典名演，絕版數十年LP復刻發行。 ★180G，德國壓片。使用原始母帶，完全類比轉製。', 1, '2025-06-11 20:59:20'),
(60, '慕特神采 – 「黃色沙龍」古典新創意\nThe Club Album - Live At Yellow Lounge', '2025-06-11 19:42:26', 1080, 1, 1, 3, 60, 1, 1, NULL, 36, 2, '0', '2007年，柏林酒吧的一場演出開啟了Yellow Lounge的概念。古典音樂應該是最貼近人心與情感的聲音，但是演出場地或是規則往往讓人卻步。在德國著名DJ與音樂製作人DJ Clé操刀下，Yellow Lounge把古典音樂混合了現代與當代的音樂經典，創造出如休息室般的悠閒氣氛，並且把演出場地帶到柏林、巴黎、倫敦、斯德哥爾摩、維也納、哥本哈根、 馬德里、阿姆斯特丹、紐約、首爾、布宜諾斯艾利斯、雪梨、薩爾茲堡……等地的休閒俱樂部。聽眾可以以最舒服的姿勢，欣賞國際知名音樂家的演出，以最輕鬆的 心情聆聽音樂。 2015年五月初，小提琴家慕特來到柏林被稱為「新家園」（Neue Heimat）的區域，與多年的鋼琴家搭檔歐奇斯、伊朗大鍵琴家伊斯法哈尼演出曲目橫跨三個世紀的古典音樂，包括巴哈、威爾第、蓋希文到約翰‧威廉斯的作 品，為Yellow Lounge系列音樂會帶來新的高潮。「新家園」原址是舊火車站，現在則是柏林年輕藝術家的「樂園」。他們在充滿塗鴉與破舊廠房的世界裡，打造出該區域簡 單不羈的風格。除了小吃市集，也是各種表演、手工藝攤位的集散地，完全符合Yellow Lounge的概念。在輕鬆的', 1, '2025-06-11 20:59:20'),
(61, '美聲耶誕情\nChristmas Songs', '2025-06-11 19:42:35', 1280, 1, 2, 9, 61, 1, 1, '2016-10-14', 39, 1, '0', '二○○五年年末，Diana Krall難得的在大眾期盼下發行最應景的音樂專輯，以爵士角度重新詮釋大眾耳熟能詳的聖誕歌曲，除了與固定班底葛萊美獎製作人Tommy LiPuma和得獎無數的錄音師Al Schmitt合作，為呈現溫馨與愉悅的聖誕氣氛，本輯邀請曾與Rosemary Clooney、Count Basie、Duke Ellington等傳奇藝人共同演出的The Clayton/Hamilton Jazz Orchestra管弦樂團擔任大部分的演奏工作。另外，為Frank Sinatra、Natalie Cole等人編曲、Diana Krall最喜愛的著名音樂家Johnny Mandel，也為\"Christmas Time Is Here\"、\"Have Yourself A Merry Little Christmas\"、\"Count Your Blessings Instead of Sheep\"等三首歌重新編曲製作並親自指揮。新生代樂手Anthony Wilson、Russell Malone與Stefon Harris等人也在專輯中各有發揮。 　　雖是聖誕應景作品，本輯卻不只', 1, '2025-06-11 20:59:20'),
(62, '沉默之道\nIn A Silent Way', '2025-06-11 19:44:15', 880, 1, 2, 8, 62, 1, 1, '2015-10-27', 2, 1, '1', '邁爾士．戴維斯Miles Davis (小號) 素有「黑暗王子」之稱的小喇叭巨擘邁爾士．戴維斯，開創60年代末期Jazz-Rock融合（Fusion）新樂風的先鋒。 這張錄製於1969年的專輯「沉默之道」（In A Silent Way）揭示了融合（Fusion）搖滾爵士樂。它是引導邁爾士．戴維斯邁入創作新階段的試金石。 如 果1959年的專輯「泛藍調調」開啟了現代爵士（Modern Jazz）樂風，那麼就如同這張錄製於1969年的專輯「沉默之道」（In A Silent Way）揭示了融合（Fusion）搖滾爵士樂。它是引導邁爾士．戴維斯邁入創作新階段的試金石，並且找來三位神乎其技的鍵盤樂手（奇克．科瑞亞、賀比． 漢考克、喬．查威努（Joe Zawinul））與吉他手約翰．麥可勞夫林（John Mclaughlin）。如果你沒聽過這張專輯，那麼將會是你生命中的遺憾。（1976年錄音）\n ', 1, '2025-06-11 20:59:20'),
(63, '愛的陽光\nSunshine Of Your Love', '2025-06-11 19:45:41', 980, 1, 2, 9, 63, 1, 1, '2015-10-22', 1, 1, '0', '„She has been more famous, over a longer time span, than any other female singer.\" – Leonard Feather. In ihrer außergewohnlichen Karriere kollaborierte die „First Lady of Song\" mit den Schlüsselfiguren des Big Band Jazz – u.a. mit Chick Webb und Dizzy Gillespie – , gewann insgesamt 13 Grammys und wurde 1987 mit der National Medal of Arts ausgezeichnet. Ihre unverwechselbaren Interpretationen von Jazz Standards finden sich auf unzahligen American Songbook-Alben. Ellas enthusiastisch um den damals', 1, '2025-06-11 20:59:20'),
(64, '北國黑熊\nSvarte Bjorn', '2025-06-11 20:26:36', 928, 1, 4, 17, 64, 1, 1, NULL, 40, 1, '0', '發燒天后「玫瑰仙子」-『凱莉•布蕾妮斯』最新專輯，不管演唱、音樂背景，還是錄音水準，均已直達示範級數。音色通透、清脆甜美，精彩之至，教人拍案叫絕，保證是張令您滿意讚許的發燒天碟。', 1, '2025-06-11 20:59:20'),
(65, 'Ghosteen', '2025-06-12 10:02:59', 1380, 1, 3, 14, 67, 1, 1, '2019-11-08', 24, 2, '0', '', 1, '2025-06-12 13:19:19'),
(66, '心愛妹妹的眼睛', '2025-06-12 10:03:04', 899, 1, 4, 16, 68, 1, 1, '2024-10-04', 46, 1, '0', '有夢的眼睛 如詩的心底                             \n化不開的憂鬱，深深鎖在他的眉宇\n說不出的深情，悠悠映在他的眼眸\n什麼樣的男子，讓人痛在心裡\n才知道一生的愛戀可以如此濃釅\n才明白一世的執著可以如此無悔\n一生一世  從一而終\n\n張洪量的歌聲 讓你心碎的聲音，如迎面而來的風一路颳進你心的海洋，\n古典悠柔回聲重重，掀起如夢般的心痛。\n\n。原始母帶製作\n。德國Optimal刻片、壓片\n。140g\n。限量發行 ', 1, '2025-06-12 13:19:19'),
(67, 'Cape Forestier', '2025-06-12 10:03:23', 1180, 1, 3, 14, 69, 1, 1, '2024-05-10', 24, 1, '1', 'Après plus d’1/2 million d’albums vendus et des tournées internationales à guichets fermés, les frères et sœurs reviennent à leurs racines et subliment leur singularité musicale avec un 6ème album studio : Cape Forestier. Une collection de douze morceaux à la production dépouillée, offrant à l’auditeur un voyage extraordinaire et poignant vers l’intimité du duo. Plus loin que les simples étiquettes de folk, acoustique ou indie rock, Angus & Julia Stone privilégient l’authenticité dans leur écrit', 1, '2025-06-12 13:19:19'),
(68, '男孩\nboy', '2025-06-12 10:04:03', 848, 1, 3, 12, 70, 1, 1, '2024-06-07', 2, 1, '0', '◎ 澳洲偶像男團到暑五秒 (5 Seconds Of Summer) 主唱個人2024年最新EP\n◎ 再找來哈利 (Harry Styles) 專輯幕後推手Sammy Witte共同製作，以另類音色，將路克對於心理健康、人性以及家庭的回憶與反思等EP核心概念，變化成如夢似幻的成長記憶作\n◎ 發行即拿下澳洲專輯榜 #4、英國金榜 #22，美告示牌 #99，刷新個人在英美榜單成績新紀錄\n◎ 收錄以首支單曲〈Shakes〉、全新嘗試唱出自身焦慮與成長痛〈Close My Eyes〉，以及離家後的焦慮與罪惡感〈Benny〉共7首歌，帶你體驗路克內心的掙扎與真摯感受', 1, '2025-06-12 13:19:19'),
(69, '男孩(限量藍色彩膠)\nboy', '2025-06-12 10:04:08', 958, 1, 3, 12, 71, 1, 1, '2024-06-07', 2, 1, '0', '◎ 澳洲偶像男團到暑五秒 (5 Seconds Of Summer) 主唱個人2024年最新EP\n◎ 再找來哈利 (Harry Styles) 專輯幕後推手Sammy Witte共同製作，以另類音色，將路克對於心理健康、人性以及家庭的回憶與反思等EP核心概念，變化成如夢似幻的成長記憶作\n◎ 發行即拿下澳洲專輯榜 #4、英國金榜 #22，美告示牌 #99，刷新個人在英美榜單成績新紀錄\n◎ 收錄以首支單曲〈Shakes〉、全新嘗試唱出自身焦慮與成長痛〈Close My Eyes〉，以及離家後的焦慮與罪惡感〈Benny〉共7首歌，帶你體驗路克內心的掙扎與真摯感受', 1, '2025-06-12 13:19:19'),
(70, '霓虹藥丸\nNeon Pill', '2025-06-12 10:04:14', 1128, 1, 3, 14, 72, 1, 1, '2024-06-07', 2, 1, '0', '◎ 繼2度贏得葛萊美「最佳搖滾專輯」《社交線索 Social Cues》之後，睽違5年的全新第6張正規專輯\n◎ 再度邀請葛萊美「年度製作人」提名John Hill掌舵製作，打造全新獨立搖滾名作 \n◎ 收錄突破千萬串流同名歌〈Neon Pill〉、打造麥莉與桃莉芭頓金曲幕後音樂人Caitlyn Smith合寫〈Out Loud〉，以及爽快搖滾之作〈HiFi (True Light)〉等12首歌', 1, '2025-06-12 13:19:19'),
(71, '貝多芬：C大調三重協奏曲，作品56\nBeethoven: Triple Concert', '2025-06-12 10:04:27', 980, 1, 1, 7, 73, 1, 1, '2024-06-07', 35, 1, '0', '從錄音工業發產歷程的角度來審視，七○年代以來，貝多芬「三重協奏曲」的錄音版本，在卡拉揚/羅斯托波維奇/歐伊斯特拉夫/ 李希特的傳奇組合以來，一直難有足以匹敵的對手，直到1995年的2月，在柏林愛樂廳的現場，另一段傳奇歷史的起點，終於被見證了。在當時EMI唱片公司努力奔走、促成之下，將分屬不同唱片品牌的三位傑出音樂家：小提琴大師帕爾曼、華裔大提琴超級巨星馬友友、加上當時在指揮與鋼琴領域皆臻至顛峰的巴倫波因，搭配超級樂團柏林愛樂，重新奠定了此一曲目的新世代里程碑。', 1, '2025-06-12 13:19:19'),
(72, '三大男高音1994年世足賽演唱會 (彩膠限量版)\nThe Three Tenors in Concert 1994', '2025-06-12 10:04:35', 1480, 1, 1, 4, 74, 1, 1, '2024-06-14', 4, 2, '0', '這是人類音樂史上絕無僅有的一次超越時空的心靈交流！由多明哥、帕華洛帝和卡列拉斯三位頂尖男高音所組成的三大男高音，是在一九九零年七月七日的羅馬世足賽閉幕式上首次與世人見面，一同經歷了一場天籟歌聲的嘉年華會，一首首膾炙人口的歌劇詠嘆調、好萊塢名曲、世界名歌，在三大男高音各擅勝場的歌聲詮釋和迷人風采下，就此更添一抹傳奇色彩與不朽。這次的演出，透過電視轉播，讓全球來自拉丁美洲、歐洲和北美各地的足球迷及樂迷為之瘋狂，數千萬人看到、聽到三大男高音的優美演唱，不僅讓三大男高音和歌劇之能見度大大提昇，也從此改變了古典音樂界的生態。在羅馬世足賽閉幕演唱會後，三大男高音的聲望水漲船高，他們於是決定在四年後的洛杉磯世足賽閉幕式上，再度應全球足球迷的要求，再開第二次的三大男高音演唱會，也就是本片中的這份錄影。\n\n這場音樂會，就連當時的美國總統老布希夫婦都在觀眾席間觀賞，影片中也會看到鏡頭在美國國歌演唱一幕時，帶到了他們夫婦以及前美國國務卿季辛吉。由於此次的演唱是在美國舉行，因此整場音樂會主要都採用具有美國風格和關聯的曲目，像是一開始的憨第德就是美國作曲家伯恩斯坦的作品，之後則有多首美國百老匯音樂劇的組曲，以及', 1, '2025-06-12 13:19:19'),
(73, 'Steamin\' with the Miles Davis Quintet', '2025-06-12 10:04:52', 1180, 1, 2, 8, 75, 1, 1, NULL, 9, 1, '1', 'RVG錄音名盤/AMG-5星/DownBeat-4星半高評/企鵝4星超高評價，不世出巨匠熱力與勁道交織之傳奇名演\n\n★爵士樂史的傳奇留名錄音鉅作，邁爾斯戴維斯在Prestige唱片的最後合約，名為「馬拉松錄音」的成果之一，在錄音室當中整整兩天，錄製了25首曲子，收錄在《Cookin’》、《Steamin’》、《Relaxin’》、及《Workin’》等唱片當中，這些專輯，被爵土樂迷暱稱為「ING錄音」的傳世經典之作...\n★現代爵士樂從咆勃、酷派、硬式咆勃、調式爵士到融合樂引領風潮最的傳奇巨人\n★近代爵士音樂發展的縮影之代表性人物，更著實影響後輩新秀的音樂理念及演奏技巧之大師\n\n小號巨人邁爾斯‧戴維斯於1955年7月新港爵士音樂節演奏“’Round Midnight”一曲，因添加弱音器的小號聲響淒婉甘美且勾勒迷離氛圍而大獲好評並得以重返樂壇，亦替自己掙得一紙優渥的新合約。為了履行老東家Prestige廠牌的舊合約，戴維斯率領第一代五重奏於1956年利用兩天時間，採馬拉松方式進錄音室錄下四張以「ING」主題的系列專輯，過程中一氣呵成且未經任何修飾，每張都成為留名青史的上乘之作，為其日後發', 1, '2025-06-12 13:19:19'),
(74, '島嶼\nIslands: Essential Einaudi', '2025-06-12 10:05:00', 1680, 1, 1, 1, 76, 1, 1, '2024-05-31', 33, 2, '0', '★2011年，艾奧迪10年有成，最受歡迎作品精選輯\n  \n艾奧迪可能是目前世界上最受歡迎的作曲家之一，儘管您熟不熟悉他的名字，但您很可能在某個時候聽過這位義大利作曲家的優美作品——無論是透過電影、電視或廣告。\n\n如果不太熟悉艾奧迪，，那麼“島嶼(Islands)”這張於2011 年推出的精選輯，是一個很好的起點。I Giorni”，這是典型的艾奧迪作品，一首美麗、又豐富的鋼琴作品。還有「 《Le Onde》這首呈現他創作技巧的名曲。而《Nightbook》是他2009 年專輯中的主打歌，有點情緒感，在緊張的弦樂背景下音樂不斷來回穿梭，而《Divenere 》則是伴隨著鋼琴的律動音符，更加令人振奮。\n\n另外從“Fairytale”、“Nuvole Bianchi”到“Berlin Song”，都是相對悅耳的樂曲。旋律純淨簡單，精準優美的“Questa Notte”，應該是文青喜愛的罕見音樂寶石。總而言之，這是對艾奧迪這位天賦非凡又多產的作曲家，2011年之前的音樂匯理。', 1, '2025-06-12 13:19:19'),
(75, '晨光序\nUna Mattina (White Vinyl)', '2025-06-12 10:05:19', 1680, 1, 1, 1, 77, 1, 1, '2024-06-28', 33, 2, '0', '魯多維科‧艾奧迪是現今義大利最重要的作曲家與鋼琴家之一。他1955年出生於杜林，從小接受嚴格的古典音樂作曲與古典鋼琴演奏訓練，威爾第音樂學院畢業以後，艾奧迪師從貝里歐繼續深造。早年艾奧迪也走學院派創作路線，但是沒有多久，他就決定跟著自己真正的興趣走，從嚴格的學院角度出發，擁抱他所熱愛的非洲音樂、民謠、搖滾樂、披頭四、吉米罕醉克斯、鮑勃‧狄倫、U2、電台司令等，他的音樂常被形容為「極簡主義」、「當代音樂」、「環境音樂」或是「alt-classical」，但是艾奧迪形容，自己的音樂是「源自古典，但是受到生活所經歷過不同音樂的影響，包括非洲音樂、民謠與搖滾樂」。而英國《每日電訊報》形容，艾奧迪的音樂聽似簡單，卻具有不可思議的奇妙效果。\n\n《艾奧迪的音樂與極簡主義者共享一種巧妙的語言節約，但這種風格不是他音樂的基本材料。就好像葛拉斯或萊克已經完成的極簡主義專輯- 然卻被定義為新時代音樂的口味那樣：他的音樂情緒是一致的，用一種接近於的冥想音樂態度。專輯中所有的音樂都是艾奧迪獨創的鋼琴演奏，除了大提琴的些微的響，獨奏的鋼琴聲中，流洩出細微的情緒變化。本輯最早於2004年發行，20年後以白膠重新推出', 1, '2025-06-12 13:19:19'),
(76, '溫柔眼神 (發燒版)\nWhen I Look In Your Eyes (Acoustic Sounds Series)', '2025-06-12 10:05:29', 1980, 1, 2, 9, 78, 1, 1, '2024-08-23', 39, 2, '1', '★ Acoustic Sounds Series reissues from Verve/Universal Music Enterprises!\n\n★ Monthly releases highlighting the world\'s most historic and best jazz records!\n\n★ Mastered by Ryan K. Smith at Sterling Sound from the original analog tapes\n\n★ 180-gram LPs pressed at Quality Record Pressings!\n\n★ Stoughton Printing gatefold old-style tip-on jackets', 1, '2025-06-12 13:19:19'),
(77, '琴韻心聲\nDiary of Alicia Keys', '2025-06-12 10:05:35', 1480, 1, 3, 13, 79, 1, 1, '2003-12-16', 24, 2, '0', '全新版別，告別絕版\n全美冠軍專輯 媒體一致好評\n\n「經由新專輯《琴韻心聲》（榮獲四顆星最高評價），艾莉西亞凱斯展現其又向前邁進一大步的音樂新里程。絕美單曲「陌生人You Don’t Know My Name」是本張專輯的中心思想之作。艾莉西亞凱斯又創造了一張超級音樂力作！」—今日美國USA Today\n\n「艾莉西亞凱斯的專輯《琴韻心聲》，是由細膩精巧的製作、聲音表現以及器樂編制所織錦出的驚人大作。艾莉西亞凱斯無疑是未來真正R&B的前鋒！安可！」—羅傑弗德曼（美國福斯新聞網Roger Freidman, Fox News）\n\n「艾莉西亞凱斯又達到了其前一張專輯《未成年之歌》所立下的超高標準。就像教父續集一樣，這是一張決不會令人失望的第二張專輯，就是這麼優秀！（榮獲四顆星最高評價）」—人物雜誌People Magazine\n\n「令人眼界大開之作，一種融合溫暖與感覺的嘻哈調調、同時又是即興靈魂的經典之作！」—滾石雜誌Rolling Stone\n\n「一個無可限量的才華巨星。艾莉西亞凱斯讓《琴韻心聲》中的每一個時刻，都像是遊走於真實及私密之間。艾莉西亞凱斯再一次不負眾望的達到世人投注在她身上的超', 1, '2025-06-12 13:19:19'),
(78, 'Brahms: Symphony No. 4 / Strauss: Death and Transfiguratio', '2025-06-12 10:05:51', 2680, 1, 1, 5, 80, 1, 1, NULL, 47, 2, '0', '關於The Lost Recording除了挖掘爵士唱片以外，古典的歷史錄音也是相當珍貴，因為都全球首刻的片子，好幾款售完之後都以達到不敢碰的地位，請各位把握合理價格。\n\n接下來這款是指揮大師 #貝姆 1962年在柏林以68歲的年齡指揮柏林廣播交響樂團，演繹布拉姆斯與理查史特勞斯的作品。超過六十年才首度露面的錄音，製作團隊找到原始類比母帶，並且邀請原本的錄音工程師經過數周的努力修復，將第一與第二樂章分別刻錄在不同面，以保留最原整的演出細節。\n\nRecorded at Saal 1, RBB, Berlin, 29.IX.1962-01.X.1962\nSTEREO ℗ 1962 RBB\n\nRemastered by ℗ & © 2024 THE LOST RECORDINGS\nfrom the original analog tapes\n\nRef.: TLR-2403051V\n33 rpm Lacquer-cuts: Kevin Gray\nDouble vinyl album 180g\nElectroplating: United-Kingdom\n1st edition, hand nu', 1, '2025-06-12 13:19:19'),
(79, 'Live At Wembley', '2025-06-12 10:06:32', 2280, 1, 3, 14, 81, 1, 1, '2024-07-26', 4, 3, '0', '', 1, '2025-06-12 13:19:19'),
(80, '最精選\nSimply The Best (Blue Vinyl)', '2025-06-12 10:06:36', 1480, 1, 3, 13, 82, 1, 1, '2024-06-07', 4, 2, '0', '有著《The Queen Of Rock & Roll 搖滾女皇》美譽的Tina Turner，滾石雜誌票選《史上百大經典藝人》之一，1991年和前夫Ike共同分享進入搖滾名人堂榮耀，共拿下8座葛萊美獎項加冕，同時成為葛萊美名人堂永久會員，全球累積破億作品銷售數量，於好萊塢星光大道留下屬於自己的一顆星。2008年慶祝進入歌壇50週年紀念，舉辦名為《Tina!: 50th Anniversary Tour》世界巡迴演唱會，站上《2008-2009年間最佳票房》第9名，實證魅力不減的仍居不敗天后地位！\n\nTina在1991年推出生涯首張精選《Simply The Best》，空降英國金榜亞軍，待在榜內長達140週之久，全球狂賣破700萬張。主要收錄一路走來個人單飛後的暢銷代表，珍藏：翻唱Bonnie Tyler的〈The Best〉，邀請搖滾/藍調界全方位樂器演奏大師Edgar Winter薩克斯風吹奏，登記英國Top5+美國NO.15；第一支攻上英國金榜第6名的〈Let`s Stay Together〉，重新詮釋靈魂樂長青樹Al Green入籍滾石雜誌「史上500首經典歌曲」名單之歌；也', 1, '2025-06-12 13:19:19'),
(81, '絕命大煞星\nTrue Romance (30th Anniversary Edition)', '2025-06-12 10:06:41', 1980, 1, 6, 26, 83, 1, 1, '2024-07-05', 24, 2, '1', 'Enjoy The Ride Records in conjunction with Morgan Creek Entertainment proudly presents the True Romance Original Motion Picture Score, composed and conducted by Hans Zimmer. \n\nIn celebration of the iconic film\'s 30th anniversary, the True Romance Original Motion Picture Score is pressed at 45 RPM across 2 LPs for optimal sound quality.\n\nRecorded on a budget of nine musicians (after being told the plans for a full orchestra had to be scrapped due to director Tony Scott going over budget), Hans Zi', 1, '2025-06-12 13:19:19'),
(82, '捍衛任務配樂精選\nThe Story of Wick', '2025-06-12 10:07:01', 1280, 1, 6, 26, 84, 1, 1, '2024-07-26', 48, 1, '0', 'Immerse Yourself In The Raw, Thrilling World Of John Wick With The Iconic Soundtrack Now Available On Vinyl. Experience The Thrilling Action Of The Films Like Never Before By Listening To The Carefully Chosen Selection Of Tracks That Perfectly Capture The Mood And Intensity Of The Series. From Pulsating Electronic Beats To Beautifully Haunting Melodies, The John Wick OST Vinyl Is A Must-Have For Any Fan Of The Franchise. Add It To Your Collection Today And Bring The Cinematic World Of John Wick ', 1, '2025-06-12 13:19:19'),
(83, 'A Night At The Village Vanguard : The Complete Masters (Tone Poet Series)', '2025-06-12 10:07:09', 3380, 1, 2, 8, 85, 1, 1, '2024-04-26', 49, 3, '0', '★收錄薩克斯風巨人桑尼‧羅林斯1957年在前鋒村俱樂部的曠世名演，滿溢奔放不羈而擲地有聲的弘觀氣勢\n\n薩克斯風巨人桑尼‧羅林斯，有著爵士老頑童的稱號，同時擁有薩克斯風巨人的至尊美譽，縱橫樂壇數十年的他始終以其飽滿渾厚的器樂聲響吹奏出鏗鏘有力且氣韻生動的流暢旋律，再加上擅於將拉丁音樂中之加力騷的律動節奏融入演奏中，使其樂風更顯繽紛多元而饒富風情。生涯裡曾從兩度退隱以潛心苦練樂器及鑽研人生哲思的他，每一次的復出在演奏技巧、創意巧思或器樂音色上均大躍進而為之驚豔，也因此即變年事已高，依然如長青樹般在樂壇上活躍著，一次又一次傳遞著醇厚綿長的大器音色，醍醐灌頂般地讓樂迷們感受到最酣暢淋漓的不朽名演。本輯為羅林斯於1957年11月領軍無鋼琴伴奏的兩組三重奏在紐約爵士聖地前鋒村俱樂部的現場錄音，少了鋼琴聲響的牽絆制抑，讓他的吹奏更顯奔放不羈而擲地有聲，並在低音提琴的撩撥彈滑及鼓組錯落有致的助陣下，三方屢屢地交相對峙或烘托而激盪出更經典的爵士語彙及源源不絕的慧黠巧思，即便是演繹最熟悉不過的標準曲或抒情曲，均能打造出絕無僅有的大器格局；聽羅林斯在專輯中的演奏，彷彿親臨現場感受最活色生香的曠世名演！', 1, '2025-06-12 13:19:19'),
(84, '阿基拉\nAkira', '2025-06-12 10:07:14', 980, 1, 6, 27, 86, 1, 1, '2024-06-14', 24, 1, '1', 'The strength of the \'Akira\' soundtrack lies in its unique blend of traditional Japanese instruments and futuristic electronic sounds. Yamashiro weaves together an eclectic mix of influences, creating a sonic landscape that mirrors the dystopian and cyberpunk themes of the movie. The use of traditional chants, taiko drums, and shakuhachi flutes alongside electronic synthesizers and orchestral elements generates a hauntingly mesmerizing atmosphere that perfectly complements the visuals on screen. ', 1, '2025-06-12 13:19:19'),
(85, '天空之城 美特拉 (噴濺彩膠)\nMETEORA (Translucent Gold & Red Splatter Viny)', '2025-06-12 10:07:20', 1180, 1, 3, 14, 87, 1, 1, '2024-07-26', 4, 1, '0', '● 榮獲葛萊美獎、Billboard音樂獎、滾石雜誌、世界音樂獎及三大MTV音樂獎肯定\n● 空降英美台專輯排行冠軍、十八國冠軍排行寶座\n● 收錄4首Billboard現代搖滾榜冠軍曲:Somewhere I Belong、Faint、Numb、Lying From You 六個二十出頭的年輕人，發片前嚐盡被唱片公司拒於門外的挫敗，卻在出道短短三年間得到樂壇上所有的光榮，包括世界音樂獎、葛萊美獎、Billboard音樂獎、MTV音樂大獎、以及滾石雜誌所頒發的年度風雲人物，他們的首張專輯「Hybrid Theory」被滾石雜誌推崇為：「12首環環相扣的歌曲，巧妙融合了另類金屬樂、嘻哈與唱盤的技術。」這張專輯也成為2001年全美專輯銷售冠軍，並在全球創下一千五百萬張的銷售紀錄。 而第二張作品「天空之城：美特拉」亦不負眾望，推出首週便空降英美台排行冠軍，登上十八個國家的冠軍排行寶座。事實上，在「METEORA 天空之城─美特拉」專輯中，整個樂團的感覺聽起來更實在了。這種成就的確罕有，六位成員完全融為一體，但是卻不失每個人的特質，如此造就了獨屬於Linkin Park的風格。 除了音樂成就被全球', 1, '2025-06-12 13:19:19'),
(86, '世紀天后：席琳狄翁 電影原聲帶\nI Am: Celine Dion', '2025-06-12 10:08:02', 1580, 1, 3, 13, 88, 1, 1, '2024-08-09', 2, 2, '0', '★2座奧斯卡獎、5座葛萊美獎、2億5千萬張專輯銷售紀錄的唯一天后，全新紀錄片原聲帶專輯，紀錄片完整記錄世紀天后生命軌跡，以及近年與罕見疾病奮戰的心路歷程。\n\n★原聲帶專輯收錄包括”The Power of Love”, “My Heart Will Go On,”“ All By Myself”等經典世紀情歌之外，再收錄7首由巴爾巴尼亞知名大提琴家Redi Hasa操刀譜曲演出的紀錄片配樂樂曲，讚揚唯一天后的不凡生命旅程', 1, '2025-06-12 13:19:19'),
(87, 'Decoy (40 Anniversary Edition)', '2025-06-12 10:08:09', 1080, 1, 2, 8, 89, 1, 1, '2024-07-19', 27, 1, '1', '• 180 GRAM AUDIOPHILE VINYL\n• GATEFOLD SLEEVE\n• HIS 1984 ALBUM RECORDED WITH KEYBOARDIST ROBERT IRVING III AND GUITARIST JOHN SCOFIELD\n• 40TH ANNIVERSARY EDITION OF 2000 INDIVIDUALLY NUMBERED COPIES ON SMOKEY COLOURED VINYL\n\nDecoy Is A 1984 Album By The Famous Jazz Musician Miles Davis, Re- Corded In 1983. Robert Irving III On Keyboards Took Over The Role That Miles Had Assumed With A True Sense Of Harmony And Only A Rudi- Mentary Mastery Of Synthetic Sounds And Movements. Irving Shared The Resp', 1, '2025-06-12 13:19:19'),
(88, '災星之戀\nStar-Crossed (Sea Foam Vinyl)', '2025-06-12 10:08:16', 1280, 1, 3, 13, 90, 1, 1, '2021-09-10', 24, 1, '1', '★6座葛萊美獎得主 流行鄉村天后2021全新第5張錄音室大碟降臨\n★葛萊美王牌製作人&鬼才級操盤手聯袂，空降告示牌綜合榜季軍、鄉村與民謠榜雙料冠軍\n\n迷人的優雅嗓音、鄉村音樂的完美草根性、融入流行音樂的黃金元素，Kacey Musgraves的音樂總是能在同時期的音樂人中脫穎而出，靠的不僅僅是難得的天賦，更是因為她有別於眾的樂句架構和編曲模式，打造了獨一無二的個人特色，在樂壇中開闢了屬於自己的一條道路，並且至今依然在持續往前，探索音樂的更多可能性。\n\n出身於德州、現年33歲的Kacey Musgraves擁有豐富的美式音樂涵養，在8歲時便已開始嘗試音樂創作，展現了驚人的才華與天賦。2009年正式踏入樂壇，2013年以【Same Trailer Different Park】一鳴驚人，接著又以【Pageant Material】、【A Very Kacey Christmas】、【Golden Hour】等專輯以及多張EP，為她的音樂生涯攀向一個又一個的高峰，締造了數百萬張的專輯銷售之餘，更讓Kacey Musgraves獲獎無數；總計Kacey Musgraves的生涯至今，已獲得6座', 1, '2025-06-12 13:19:19'),
(89, 'Mellow Medicine', '2025-06-12 10:08:50', 1380, 1, 5, 21, 91, 1, 1, '2024-10-30', 24, 1, '0', '日本Neo Soul女聲代表——具島直子（Naoko Gushima）於1999年推出的第三張錄音室專輯，維持其一貫灑脫、都會感十足的風格，更進一步融合更華麗與多元的音樂層次，在J-Urban與City Pop愛好者中被視為經典之作。\n本次特別以清透彩膠（Clear Vinyl）形式限量再發行，質感與收藏價值兼具，無論是音樂性還是視覺美感都達到極致。每一首曲目皆展現她細膩的聲線與成熟韻味，是喜愛90年代日系靈魂樂與City Pop的樂迷絕對不容錯過的精品。', 1, '2025-06-12 13:19:19'),
(90, 'Coldplay\'s Viva La Vida (Transparent Blue Vinyl) (RSD)', '2025-06-12 10:08:55', 1280, 1, 1, 5, 92, 1, 1, '2022-11-25', 24, 1, '0', 'Vitamin String Quartet’s full album tribute to Coldplay’s Viva la Vida or Death and All His Friends is a lush, soaring collection of music and a favorite amongst VSQ’s fans. Packed with full and rousing arrangements of a revolutionary album in Coldplay’s catalog, VSQ’s classic release is getting the RSD Black Friday exclusive LP treatment. This is the first time the album will be put out on vinyl and it comes with a brand-new package, cover art, download card and colored wax for this special rel', 1, '2025-06-12 13:19:19'),
(91, '月亮上的男人\nMan On the Moon: End of the Day', '2025-06-12 10:09:02', 1480, 1, 3, 12, 93, 1, 1, '2009-09-15', 24, 2, '0', 'Man on the Moon: The End of Day is the debut studio album by American hip hop recording artist Kid Cudi, released on September 14, 2009, by Dream On, GOOD Music, and Universal Motown. A concept album, narrated by fellow American rapper Common, it follows the release of his first mixtape A Kid Named Cudi (2008). Production for the album took place during 2007 to 2009 and was handled by several record producers, including Cudi, Kanye West, Emile Haynie, Plain Pat, No I.D., Dot da Genius and Jeff B', 1, '2025-06-12 13:19:19'),
(92, 'The Sky Will Still Be There Tomorrow', '2025-06-12 10:09:08', 1680, 1, 2, 8, 94, 1, 1, '2024-03-15', 49, 2, '0', '★AMG-4星半超高評薦，現今樂壇最重量級爵士薩克斯風巨人\n★【2024衛武營爵士週】 2024-08-23 ，查爾斯．洛伊德四重奏《明日依舊》，美國爵士巨擘查爾\n斯．洛伊德，率鋼琴手傑森．莫蘭、貝斯手拉瑞．格瑞納迪亞，以及鼓手艾瑞克．哈藍連袂登臺，堪稱當今爵士樂壇最頂尖的明星級陣容，不容錯過！\n\n★持續不斷超越自我的傳奇薩克斯風大師，最新專輯，英國衛報給予五顆星經典鑑賞\n★查爾斯洛伊德以輕柔地切入，慢慢的居於主導，再到與合作的頂尖樂手並行演出，共同帶出樂曲的耀眼光彩\n★包括：美麗迷人的樂曲「Defiant,Tender Warrior」，向查爾斯洛伊德尊稱為音樂界「大祭司」的鋼琴巨人Thelonious Monk致意，縱情，狂放的幻想樂曲「Monk’s Dance」，饒富情感的標題曲「The Sky Will Still Be There Tomorrow」...\n\n2024年，八十六歲生日，橫跨兩個世紀的傳奇薩克斯風大師Charles Lloyd為全世界的樂迷獻上宏偉的雙CD錄音室音樂大作【明日依舊The Sky Will Still Be There Tomorrow】，在這張專', 1, '2025-06-12 13:19:19'),
(93, 'Are We There (10th Anniversary Edition)', '2025-06-12 10:09:49', 1180, 1, 3, 13, 95, 1, 1, '2024-05-31', 24, 1, '0', '◎美國黑色系調的獨立淒美女聲\n◎邀請葛萊美獎加冕，縱橫音樂和戲劇配樂界的Stewart Lerman(Elvis Costello、David Byrne)協助製作，拿下告示牌流行榜第25名\n\nNPR Music：「近年來最令人著迷的嗓音之一」 \nPitchfork：「全然的扣人心弦」 \n滾石雜誌：「如同Nick Cave，大量蘊含迷人的暗黑色彩」 \nAMG：「傷感氛圍營造與文思泉湧的絕佳展現」', 1, '2025-06-12 13:19:19'),
(94, 'Short n’ Sweet (Baby Blue)', '2025-06-12 10:11:24', 1480, 1, 3, 13, 96, 1, 1, '2024-08-23', 33, 1, '1', '泰勒絲欽點 新生代人氣小天后 莎賓娜卡本特\n最新錄音室大碟【Short n’ Sweet】\n全世界都在聽的魔性旋律！狂霸全球排行冠軍王座！\n\n    迎接全新莎賓娜卡本特！甜美蛻變展現嶄新自我，攜手爆紅單曲“Espresso”製作人Julian Bunetta、泰勒絲指定製作人Jack Antonoff打造最新大碟！\n    收錄席捲全球排行的冠軍主打“Espresso”、”Please Please Please”等12首全新單曲！', 1, '2025-06-12 13:19:19'),
(95, '寂寞時分\nIn The Lonely Hour (10 Anniversary Edition)', '2025-06-12 10:11:30', 1280, 1, 3, 12, 97, 1, 1, '2024-08-02', 33, 1, '0', '★史上第一位以出道單曲勇奪英國金榜冠軍的全英音樂獎「評審首選大獎」得主\n★BBC「2014年度新聲」冠軍歌手首張大碟，專輯預購強勢進駐iTunes榜No.4，收錄英國金榜冠軍大作\"Money On My Mind\"\n★英國泰晤士報盛讚：「一個真正的靈魂歌手，可以從出色的男中音轉換至完美無瑕的假音，流露著很真實受傷感覺的歌聲」、Q雜誌：「罕見的情感歌聲，無論唱什麼都能增添歌曲的感動力量」 英國泰晤士報盛讚：「Sam Smith是一個真正的靈魂樂歌手，可以從出色的男中音轉換至完美無瑕的假音，流露著很真實受傷感覺的歌聲。」\n\n他以完美融合怦然心動的碎拍節奏、輕快活潑的流行節奏藍調風格的單曲\"Money On My Mind\"，成為第一位以出道單曲勇奪英國金榜冠軍的全英音樂獎「評審首選大獎」得主，這位同時坐擁2013年英國黑人音樂獎（MOBO Awards）與BBC「2014年度新聲」頭銜、締造英國與北美巡迴演唱會爆滿票房的歌手，在2014年誠摯獻上眾所矚目的首張大碟【In The Lonely Hour】。 1992年出生於英國劍橋郡Great Chishill村的Sam Smith，青少年', 1, '2025-06-12 13:19:19'),
(96, '印第安納瓊斯 - 法櫃奇兵 電影原聲帶\nIndiana Jones and the Raiders of the Lost Ark', '2025-06-12 10:11:59', 1680, 1, 6, 26, 98, 1, 1, '2024-06-28', 33, 2, '0', '在好萊塢的影音搭檔之中，大導演史蒂芬史匹柏、喬治盧卡斯與音樂家約翰威廉斯這個鐵三角是最耀眼的共同體，三人攜手合作的印第安納瓊斯系列電影與音樂堪稱當代視覺影像藝術與音樂藝術的顛峰，環球音樂集團旗下的Concord Records唱片公司為了榮耀這個跨越了近30年的影音里程，不但重新取得這套系列電影的前三集—「法櫃奇兵」、「魔宮傳奇」、「聖戰奇兵」的原聲大碟的發行權，讓這三張在唱片市場上絕版超過十年以上的原聲帶大碟重見天日，讓全球電影音樂發燒友得以更完整的體驗這場影音創作史上的聽覺饗宴。\n\n1981年首映的印第安納瓊斯系列電影首部曲—【法櫃奇兵】，描述考古學家印第安納瓊斯博士應美國軍方之請，為了避免具有神祕能量的法櫃落入納粹之手，於是偕同女友瑪莉安前往開羅搜尋法櫃，一場驚心動魄的冒險里程就此拉開序幕。【法櫃奇兵】在全球締造了3億8300萬美金的票房，影片獲得了包括最佳影片、導演與原創音樂等8項提名，抱走了最佳剪輯、音響、視覺特效、藝術指導等4座奧斯卡，同時還獲頒奧斯卡最佳視覺特效剪輯成就獎。\n\n約翰威廉斯在為【法櫃奇兵】創作電影音樂的過程中，將他個人在1970年代中的「星際大戰」、「超人」', 1, '2025-06-12 13:19:19'),
(97, '印第安納瓊斯：水晶骷髏王國\nIndiana Jones and the Kingdom of the Crystal Skull', '2025-06-12 10:12:06', 1680, 1, 6, 26, 99, 1, 1, '2024-06-28', 33, 2, '0', '◎好萊塢巨人史蒂芬史匹柏，「星際大戰」巨匠喬治盧卡斯與動作巨星哈里遜福特組合之好萊塢鐵三角1980年代狂掃全球12億美金票房，榮獲7座奧斯卡大獎的印第安納瓊斯冒險系列-「法櫃奇兵」第4擊!!!\n◎哈里遜福特、「伊莉莎白」凱特布蘭琪、「變形金剛」西亞李畢福巨星聯演!\n◎當代最受歡迎電影音樂巨擘約翰威廉斯John Williams世紀音樂史詩經典!\n\n\n全球影壇最受歡迎的冒險動作英雄-印第安納瓊斯回來了！奧斯卡金獎導演史蒂芬史匹柏，「星際大戰」系列編導喬治盧卡斯與動作巨星哈里遜福特這個好萊塢鐵三角繼1980年代狂掃全球12億美金票房，榮獲7座奧斯卡大獎的印第安納瓊斯冒險系列-「法櫃奇兵」(Raiders Of The Lost Ark)、「魔宮傳奇」(Indiana Jones And The Temple Of Doom)、「聖戰奇兵」(Indiana Jones And The Last Crusade)之後，在2008年的夏季強檔中隆重鉅獻【印第安納瓊斯：水晶骷髏王國】，重現這為史上最強悍的考古學教授的動作魅力。\n\n\n【印第安納瓊斯：水晶骷髏王國】在演員陣容上除了有哈里遜福特之外，同', 1, '2025-06-12 13:19:19'),
(98, '癟四與大頭蛋\nBeavis & Butt-Head Do The Universe (Blue Vinyl)', '2025-06-12 10:12:26', 1580, 1, 6, 27, 100, 1, 1, '2023-04-21', 24, 1, '1', 'Enjoy The Ride Records in conjunction with Paramount Plus proudly present Beavis and Butt-Head Do The Universe, Composed by John Frizzell. Available on limited edition vinyl, John Frizzell (Alien Resurrection, Office Space, Beavis and Butt-Head Do America) returns with a 69-piece orchestra to score the return of Beavis and Butt-Head, who end up going through a black hole and end up in the year 2022. Amidst a world filled with unknown technologies, the duo is still on a mission to find nachos, an', 1, '2025-06-12 13:19:19'),
(99, 'Moon Music (2nd Edition Clear Eco Vinyl)', '2025-06-12 10:12:32', 1280, 1, 3, 14, 101, 1, 1, '2024-10-04', 4, 1, '0', '英倫搖滾天團全新第10張專輯《Moon Music 月球漫遊》，睽違三年之久的全新大碟，延續上一張專輯《Music Of The Spheres 星際漫遊》的音樂概念，超級製作班底Max Martin(泰勒絲、布蘭妮、凱蒂佩芮)回歸操刀', 1, '2025-06-12 13:19:19'),
(100, '美麗壞東西(酷亮粉雙彩膠)\nThe Best Damn Thing (Bright Pink)', '2025-06-12 10:12:38', 1680, 1, 3, 13, 102, 1, 1, '2024-06-21', 2, 2, '0', '★席捲全球3400萬張專輯、5000萬張單曲驚人銷量，搖滾教主艾薇兒2007第三張錄音室專輯，2024全新進口酷亮粉雙彩膠版本\n★空降英美多國排行榜冠軍，累積銷售超過600萬張，收錄\"Girlfriend\", ; \"When You`re Gone\", \"Hot\" and \"The Best Damn Thing\"等排行金曲\n★2024酷亮粉雙彩膠版本首度實體收錄五首bonus歌曲', 1, '2025-06-12 13:19:19'),
(101, '加州淘金夢 (紅藍彩膠)\nCalifornication (Red/Ocean Blue)', '2025-06-12 10:12:44', 1480, 1, 3, 14, 103, 1, 1, '2024-07-26', 4, 2, '0', '83年於加州成軍至今的Red Hot Chili Peppers，16年來僅管只發表過6張專輯，卻擁有多位超級製作人如George Clinton (Funkadelic Parliament幕後Funk大師)、Michael Beinhorn (Herbie Hancock)、Rick Rubin (曾負責Slayer、Dazing等Metal樂團，為Def Jam主腦人物)親自坐鎮，多組當代大團包括Beastie Boys、Faith No More、Pearl Jam、Smashing Pumpkins助陣巡迴的樂團魅力；91年的風雲專輯「Blood Sugar Sex Magik」締造全球熱賣佳績(並在Billboard榜停留年餘)，兩支主打單曲Give It Away、Under The Bridge分別獲頒MTV「最佳突破獎」及「史上500支最佳音樂錄影帶第5名」。95年「One Hot Minute」專輯延續此一氣勢，成功巡迴21個國家。當家貝斯手Flea更於96年被Bass Player雜誌評選為「年度最佳吉他手」。而他們為「癟四與大頭蛋」電影版所作的主題曲Love R', 1, '2025-06-12 13:19:19'),
(102, '靠近你\nThis Close To You', '2025-06-12 10:12:55', 788, 1, 3, 14, 104, 1, 1, '2024-06-21', 2, 1, '0', '★5座葛萊美獎肯定R&B情歌聖手領軍樂團，生涯早期1977年第二張錄音室專輯，2024全新進口黑膠版本', 1, '2025-06-12 13:19:19'),
(103, '邊界\nThe Border', '2025-06-12 10:13:01', 958, 1, 3, 12, 105, 1, 1, '2024-06-21', 2, 1, '0', '★葛萊美獎鄉村搖滾傳奇2024歡慶91歲大壽全新錄音室專輯，進口全新黑膠版本\n★專輯與與長年製作夥伴Buddy Cannon聯手創作的四首全新歌曲，一共收錄十首全新錄製音軌，突破時空界限延續鄉村搖滾傳奇的偉大音樂旅程\n ', 1, '2025-06-12 13:19:19'),
(104, '真人快打4\nMortal Kombat 4', '2025-06-12 10:14:06', 1680, 1, 6, 28, 106, 1, 1, '2023-06-30', 24, 1, '1', 'Enjoy The Ride Records in conjunction with WaterTower Music & NetherRealm Studios is proud to announce the release of Mortal Kombat 4 (Soundtrack from the Arcade Game). Composed by Dan Forden, Mortal Kombat 4 (Soundtrack from the Arcade Game) is now available for the first time on vinyl.\n\nMortal Kombat 4 (Soundtrack from the Arcade Game) is pressed at 33rpm on limited edition colored vinyl, housed in a 350gsm jacket with black poly-lined inner sleeves.', 1, '2025-06-12 13:19:19'),
(105, '吳罕\nWu Hen', '2025-06-12 10:14:14', 980, 1, 2, 8, 107, 1, 1, '2020-11-20', 24, 1, '1', 'Wu Hen is the sophomore album from Peckham jazz visionary Kamaal Williams.\n\nBringing groove to the forefront, Wu Hen oscillates between celestial jazz, funk, hip hop and r&b reinforced with the rugged beat-heavy attitude of garage, grime, house and jungle – a self-styled fusion Kamaal describes as Wu Funk.\n\nWu Funk is very much a style of the here and now – a millennial take on jazz fusion – a style that reflects the wide-ranging aesthetic of the London jazz scene through which Williams has come', 1, '2025-06-12 13:19:19'),
(106, 'Cool Cat', '2025-06-12 10:15:09', 980, 1, 2, 8, 108, 1, 1, '2024-08-02', 27, 1, '1', 'Chet Baker was an American jazz trumpeter, actor and vocalist and a major innovator in cool jazz, leading him to be nicknamed “the Prince of Cool”. The 1989 album Cool Cat contains six tracks, split into 3 instrumentals; \"Swift Swifting \", \"\'Round Midnight\", \"Caravelle\" and the 3 vocal tunes \"For All We Know\", \"Blue Moon\" and \"My Foolish Heart\". For the recordings of Cool Cat, Chet is accompanied by pianist Harold Danko, bassist Jon Burr and drummer Ben Riley.  ', 1, '2025-06-12 13:19:19'),
(107, '侏羅紀世界：統霸天下\nJurassic World Dominion', '2025-06-12 10:15:44', 2980, 1, 6, 27, 109, 1, 1, '2023-01-13', 50, 2, '1', 'Mondo, in collaboration with Back Lot Music, is thrilled to unveil the concluding chapter of the iconic Jurassic saga: Michael Giacchino’s compelling score for JURASSIC WORLD DOMINION.\n\nGiacchino\'s musical journey began at Disney Interactive Division, where he initially composed for video games. His connection with the Jurassic franchise traces back to his involvement in scoring the temp track for the video game adaptation of The Lost World: Jurassic Park during his time at DreamWorks Interactiv', 1, '2025-06-12 13:19:19'),
(108, 'Chet Baker In Paris Vol. 2', '2025-06-12 10:15:50', 1280, 1, 2, 8, 110, 1, 1, '2024-08-30', 33, 1, '0', 'het Baker recorded on October 1955 in Paris at Studio Pathé-Magellan. Original LP issue: Barclay 84.017, re-issued on a special editions by Sam records.\nRe-mastered from the original mono master tapes!\n\nOn October 24th only Jimmy Bond was still with Chet : Peter littman had returned to America, and his seat was now accupied by Nils-Bertil ‘Bert’ Dahlander, a Swedish drummer who’d accompanied Lars Gullin. At the Keyboard was an almost-unknown pianist named Gérard Gustin who’d just been signed to ', 1, '2025-06-12 13:19:19'),
(109, 'Chet Baker In Paris Vol. 1', '2025-06-12 10:15:55', 1280, 1, 2, 8, 111, 1, 1, '2024-08-30', 33, 1, '1', 'This session of Chet Baker, recorded at Studio Pathé-Magellan October 11 and 14, 1955 in Paris, is the first of three recordings released for the Barclay label between 1955 and 1956, re-issued on a special editions by Sam records.\n\nRe-mastered from the original mono master tapes!\n\nFor his first recording-date in Paris Chet decided to tackle Bob Zieff’s compositions, the same ones that Dick Twardzik had picked up in a hurry at the Alvin Hotel on his way to board the liner Ile-de-France. Violonist', 1, '2025-06-12 13:19:19'),
(110, 'Chet Baker In Paris Vol. 3 (With Bobby Jaspar)', '2025-06-12 10:16:01', 1280, 1, 2, 8, 112, 1, 1, '2024-08-30', 33, 1, '1', 'This session was recorded at Studio Pathé-Magellan in Paris, between Tuesday October, 25th, 1955 and February, 10th, 1956. This record is the third and last record for the Barclay label. In answer to an offer from Nicole Barclay, Chet Baker arrived in Paris early in September 1955. On the 22nd – or maybe the 23rd – he signed a contract to make seven records… (The figure was later erased and replaced by «three», which turned out to be correct). Released after the trumpeter’s return to the USA, th', 1, '2025-06-12 13:19:19'),
(111, 'The Brilliant', '2025-06-12 10:16:07', 980, 1, 2, 8, 113, 1, 1, '2024-08-02', 27, 1, '1', 'To this day, jazz pianists are influenced by Bill Evans by his use of impressionist harmony, interpretation of traditional jazz repertoire, and his trademark rhythmically independent, “singing” melodic lines. Evans gained his first spotlight when joining Miles Davis’ sextet during the time Kind of Blue was recorded. After leaving the sextet, Evans began his career as bandleader, which he finished in his last trio with Marc Johnson on bass and Joe LaBarbera on drums. This trio recorded The Brilli', 1, '2025-06-12 13:19:19');
INSERT INTO `o_vinyl` (`id`, `name`, `listing_date`, `price`, `stock`, `main_category_id`, `sub_category_id`, `image_id`, `condition_id`, `status_id`, `release_date`, `company_id`, `lp_id`, `list`, `desc`, `is_valid`, `creatTime`) VALUES
(112, '往天涯的盡頭單飛', '2025-06-12 10:16:11', 1299, 1, 4, 18, 114, 1, 1, '2024-10-18', 46, 1, '0', '。原始母帶製作\n。英國Abbey Road Studios刻片\n。東洋化成壓製  180g\n。限量發行\n\n\n王新蓮在20歲時，被朋友抓去參加金韻獎，演唱「風中的早晨」。22、23歲在PUB演唱，並開始寫歌﹔24歲加盟「巨將」，出版「不要太多」專輯﹔25歲到滾石，製作過「回聲」、「潘越雲金曲精選」、「你愛我嗎」(張艾嘉專輯)、「快樂天堂」等許多受歡迎的專輯。鄭華娟則是在17歲時，參加了金韻獎。20歲考進中國卡通製作公司，編導過警政署的宣導短片。21歲時，李宗盛邀請她為鄭怡專輯寫歌，不久，寶麗金欣賞她的才華，力邀她錄製專輯－「求職」。23歲時，開始加盟「滾石」，參與梁銘越「中國冥想音樂」製作，並為潘越雲等人寫歌。由她們的經歷裡可發現，參加「金韻獎」以及到「滾石」是一個共同的交接點。\n\n「往天涯的盡頭單飛」就是王新蓮和鄭華娟這兩個勇敢又自然的女孩，在離開之前的最後一次合作。她們以多年的相知經驗共同譜曲，共同演唱，融入她們過去旅行的經驗和情感，唱出告別的心情和衝刺的喜悅。她們主張「自然」是因為自然難求，她們離開城市是因為難以呼吸。她們從墾丁到巴黎，從「回聲」到「快樂天堂」的種種經驗，都促使這張', 1, '2025-06-12 13:19:20'),
(113, '愛爾蘭根源\nIrish Roots', '2025-06-12 10:16:33', 1498, 1, 1, 3, 115, 1, 1, '2024-06-28', 7, 2, '0', '小提琴家霍普的曾祖父在1890年代從愛爾蘭沃特福德前往南非，開啟了新生活。雖然霍普從未在愛爾蘭居住，但在1970年代初，因被迫離開南非尋求政治庇護時，愛爾蘭接納了霍普及其無國籍家族，給予他們國籍。這一身分深深影響了霍普的生活和音樂創作，也促使他創作紀錄片《居爾特夢：霍普的隱秘愛爾蘭歷史》。在音樂學家奧利維耶•富雷的支持下，霍普開始探索愛爾蘭民間音樂與古典音樂的聯繫。這一探索最終催生了《愛爾蘭根源》專輯，為霍普追尋其音樂DNA中愛爾蘭元素的自然延伸。\n\n\n《愛爾蘭根源》是這段音樂旅程的結晶，專輯收錄了愛爾蘭二十世紀作曲家伊娜•博伊爾和大詩人兼豎琴手奧卡羅蘭的作品，經典的《丹尼男孩》，以及三百年前在愛爾蘭風靡一時的維瓦第《和諧的靈感》協奏曲。\n\n霍普的新專輯匯聚了眾多傑出的愛爾蘭音樂家，包括傳統音樂團體Lúnasa、豎琴手雪凡•阿姆斯壯、長笛演奏家詹姆斯與珍•高威夫婦、歌手瑞亞•加維、多樂器演奏家與民間音樂家羅斯•戴利、希臘小提琴家帕帕納斯，以及由蓋斯指揮的希臘塞薩洛尼基國家交響樂團。\n\n《愛爾蘭根源》專輯不僅展示了霍普對愛爾蘭音樂的深厚熱愛，也體現了他對家族歷史的探索和感激之情。這張專輯', 1, '2025-06-12 13:19:20'),
(114, '《一個好人》電影原聲帶\nA Good Person', '2025-06-12 10:16:45', 758, 1, 6, 26, 116, 1, 1, '2024-06-28', 7, 1, '0', '《一個好人》是由札克‧布瑞夫編劇、導演和監製的美國劇情片。女主角艾莉森（佛蘿倫絲普伊飾）有一份高薪工作和相愛的未婚夫，但是一場車禍讓她失去一切。身為唯一的生還者與肇事者，她必須倚賴止痛藥來麻醉精神和身體上的疼痛。準公公丹尼爾（摩根弗里曼飾）因為這場車禍必須照顧成為孤兒的孫女，悲痛與壓力讓他又開始酗酒。艾莉森尋求救贖時，她和丹尼爾發現友誼、寬恕和希望可以在不太可能的地方萌芽。\n\n電影配樂由葛萊美獎得主、美國搖滾樂團「國民樂團」創始成員布萊斯‧戴斯納創作。憑藉哀傷的管弦樂和夢幻的鋼琴旋律，他巧妙引導觀眾進入故事。評論家稱讚布萊斯‧戴斯納的音樂情感與電影氛圍完美配合。雖然配樂中有些只是短暫的音樂片段，但布萊斯‧戴斯納以自己獨特的方式反映和配合電影情感複雜性，創造出令人沉浸其中的音景，充滿真情和回憶中的痛苦。', 1, '2025-06-12 13:19:20'),
(115, 'Live In East Berlin 1967', '2025-06-12 10:18:21', 2980, 1, 2, 9, 117, 1, 1, NULL, 47, 2, '0', '接下來這份錄音太有歷史意義了，1967年 #艾拉費茲潔拉 與Duke Ellington及其管弦樂隊在歐洲進行巡演，當他們結束了西柏林的音樂會之後，他們大膽決定帶著三重奏的小編制樂團繞道前往 “東柏林”的弗里德里希皇宮劇院(Friedrichstadt Palace)進行演出，也成為Ella在東柏林留下的唯一錄音。訊源同樣來自原始類比母帶，再交由Kevin Gray刻盤，每壓製五百張會以全新的Stampers重新製作，法國原產地生產。', 1, '2025-06-12 13:19:20'),
(116, '新世紀福音戰士新劇場版：終 原聲帶\nMusic From Shin Evangelion Evangelion: 3.0+1.0', '2025-06-12 10:21:08', 1980, 1, 6, 27, 118, 1, 1, '2024-10-25', 51, 3, '0', 'Relive the emotions of the final movie in the \"Rebuild of Evangelion\" series with Shiro SAGISU\'s Music from \"SHIN EVANGELION\" EVANGELION: 3.0+1.0 vinyl! Reconnect to your favorite EVAs in their final battle with this one-of-a-kind vinyl release.', 1, '2025-06-12 13:19:20'),
(117, 'Talking Book', '2025-06-12 10:25:02', 1280, 1, 2, 8, 119, 1, 1, NULL, 33, 1, '0', '美國曾有一位樂評人在描述Stevie Wonder的音樂技巧時寫道：「他是最擅長將電子合成器賦予人性化的樂手。」他從1972年發行的專輯【Talking Book】開始，就以獨創性的節奏結合深具街頭觀點的歌詞改變美國70年代的流行音樂創作風貌。Stevie在專輯中透過鍵盤與電子鋼琴的音色以及藉由電子合成器所營造的弦樂效果，創作出多變的節奏風格，專輯在1974年的葛萊美獎中大放異彩，包括：蟬連全美熱門單曲榜與抒情榜雙冠軍抒情曲\"You Are The Sunshine Of My Life\"贏得最佳流行男歌手獎，結合銅管樂器與薩克斯風的放克節奏冠軍曲\"Superstition\"拿下最佳節奏藍調歌曲與男歌手等兩項大獎，這兩首得獎歌曲之後在2003年的滾石雜誌史上500首最偉大的歌曲名單中雙雙入列，專輯也入選史上500張最偉大的專輯之列。', 1, '2025-06-12 13:19:20'),
(118, '闇黑無界：星際爭霸戰\nStar Trek Into Darkness', '2025-06-12 10:25:20', 3380, 1, 6, 26, 120, 1, 1, '2024-09-06', 9, 3, '0', 'The expanded Deluxe Edition version of composer Michael Giacchino’s score for Star Trek Into Darkness arrives on vinyl for the first time ever as a 3-LP Blue, Red, and Yellow set themed after the iconic Starfleet uniforms. The collection comes housed in a premium slipcase with a Starfleet Insignia-shaped cut-out, allowing fans to pick their own cover image, and includes a 16-page booklet with behind-the-scenes photos from the film set and notes from J.J. Abrams and Michael Giacchino.\n\nInto Darkn', 1, '2025-06-12 13:19:20'),
(119, '阿甘正傳 電影原聲帶(配樂)\nForrest Gump', '2025-06-12 10:25:26', 1080, 1, 6, 26, 121, 1, 1, '2024-09-13', 27, 1, '1', '「人生有如一盒巧克力，你永遠不知道你將會拿到那一顆」 湯姆漢克斯主演，平實而機敏的口白成為阿甘正傳的最佳註腳。 本片榮獲六座奧斯卡金像獎(最佳影片、導演、男主角、改編劇本、剪輯、視覺效果)，三項金球獎(最佳影片、導演、男主角)的《阿甘正傳》，可說是1994年最風光的電影，三億美元的賣座記錄，更使它躋身影史賣座第八名。 本片以智商75的阿甘來觀看世界，透過他單純的思想以及善良的個性，描繪出美國50年代至90年代的歷史，雖然40年間，美國歷史有巨大的變化，但是弱智的阿甘突破智能的限制，以一貫的誠實以及天生的直覺行動，反倒開闢了一片天地，是\"天生我才必有用\"的最佳例證。 二次大戰剛結束，阿甘出生在美國阿拉巴馬州的一個閉塞小鎮，他先天弱智，但上帝又賜予他一雙疾步如飛的飛毛腿和一副單純正直．不存半點邪念的頭腦。小鎮上的人都對阿甘另眼相待，只有兩位女性關心、愛護著他。母親給予他偉大的母愛，青梅竹馬的玩伴珍妮則以純真的少女情懷暖著他的心。在她們的愛護下，阿甘長大了。帶著對珍妮至死不渝的愛戀，踏上了極不平凡的人生旅程。 阿甘經歷了整整三十幾年間美國幾乎所有重大事件，參與譜寫了五十年代至七十年代美國歷史', 1, '2025-06-12 13:19:20'),
(120, '石之花\nStone Flower', '2025-06-12 10:25:44', 1280, 1, 2, 8, 122, 1, 1, '2023-10-20', 24, 1, '0', 'One of the great popular music composers of the 20th Century, Antonio Carlos Jobim emerged from Brazil\'s burgeoning bossa nova movement of the early-1960s. The quietly powerful Stone Flower, recorded in 1970 at Rudy Van Gelder\'s studio in New Jersey and produced by Creed Taylor, contains nine graceful compositions including the jazz waltz \"Children\'s Games,\" the sublime \"Choro,\" the sophisticated \"Andorinha,\" and the dramatic title track.\n\nWith flawless arrangements from fellow Brazilian Eumir D', 1, '2025-06-12 13:19:20'),
(121, 'Now Playing (Blue Vinyl)', '2025-06-12 10:27:13', 1280, 1, 2, 8, 123, 1, 1, '2024-05-24', 4, 1, '1', 'Uncover the brilliance of jazz legend John Coltrane through a tracklist uncovering rich gems, such as the iconic \'Giant Steps\', the soulful \'Naima\',demonstrating Coltrane\'s virtuosity and innovation, the enchanting melodies of \'My Favorite Things, Pt. 1\' and the tender ballad \'I\'ll Wait and Pray\' as the perfect start or continuation of your musicaljourney', 1, '2025-06-12 13:19:20'),
(122, '安全地帶 40th ANNIVERSARY CONCERT “Just Keep Going!” Tokyo Garden Theater', '2025-06-12 10:28:12', 3680, 1, 4, 16, 124, 1, 1, NULL, 52, 2, '0', '安全地帯40周年記念コンサート\n感動の千秋楽公演を永遠に刻む\n特別なアナログレコード誕生！\n\n2022年11月、湾岸エリア”有明”で繰り広げられた安全地帯の40周年記念コンサート「40th ANNIVERSARY CONCERT “Just Keep Going!” Tokyo Garden Theater」の感動が、最高品質のアナログレコードによって蘇ります。\n\n●真摯なる音楽への探求心\n安全地帯が40年にわたり歩み続けた音楽の旅。その真髄が3枚組のアナログレコードに詰まっています。千秋楽公演で奏でられた音楽の宝石を、最高の音質でお楽しみください。\n\n●最高の音質を追い求めた制作手法\nカッティングマスターの制作では、公演当日の48kHzサンプリング/24ビットのデジタルマルチレコーディング音源をベースにこのレコードのためにフルリミックスしたマスター音源を、アナログならではの深みを再現すべくいまや最高に贅沢な制作手法といえるハーフインチのアナログテープに録音。安全地帯の演奏、中でもヴォーカル玉置浩二の歌声=声の質感に特に重点を置いたマスタリングを行ない生々しい音質を収録しています。\n\n', 1, '2025-06-12 13:19:20'),
(123, '史克里亞賓、史卡拉第鋼琴作品輯\nScriabin • Scarlatti', '2025-06-12 10:28:31', 1328, 1, 1, 1, 125, 1, 1, '2024-07-12', 7, 2, '0', '★加盟DG首張錄音\n  \n知名鋼琴家普雷斯勒曾經說「尤里務斯•阿薩爾的鋼琴演奏讓我驚訝不已。我不知道他是如何找到那獨特的悠揚聲音。樂器似乎向他透露了一個秘密」。這個讓前輩大感驚奇的鋼琴家來自德國，1997年出生，自學聽力彈奏多年後才接受正規的音樂教育，曾在柏林的艾斯勒音樂學院和德國克龍貝格音樂學院師從席夫。\n\n阿薩爾在DG的首張專輯很罕見結合史克里亞賓與史卡拉第這位作曲家的作品：一位是沉浸於神秘主義及其藝術表現的俄羅斯人，另一位是以其五百多首華麗的鍵盤奏鳴曲著稱的那不勒斯人。這張專輯創造了一種夢幻般的冥想效果，作品、時代和風格之間的界限逐漸消失。\n\n專輯包括阿薩爾鍾愛的史克里亞賓第一鋼琴奏鳴曲，以及一些早期前奏曲和一首練習曲，還有史卡拉第的六首奏鳴曲。阿薩爾選擇這些內省的作品，是因為「我希望整張專輯是一次深刻的心理體驗，能在意想不到的方向上成長，並在每一步都牢牢抓住聽眾的心。」阿薩爾以史克里亞賓奏鳴曲最後一樂章中「輕得近乎無聲」（Quasi niente）部分作為專輯的結構主幹，以它為序曲過渡到史卡拉第F小調鍵盤樂器奏鳴曲，並在其中穿插了史克里亞賓的練習曲和前奏曲、史卡拉第的六首奏鳴曲', 1, '2025-06-12 13:19:20'),
(124, '聖桑 : 經典作品選 (彩膠)\nSaint-Saens : The Definitive Collection', '2025-06-12 10:28:38', 980, 1, 1, 5, 126, 1, 1, '2024-07-12', 7, 1, '0', '★長野健與杜特華，指揮 / 蒙特婁交響樂團與愛樂管弦樂團 (A面)\n   薛庫與依莎塔•卡納－梅森 / 大提琴與鋼琴等 (B面)\n  \n法國作曲家聖桑的才華並不侷限於音樂上，他對一切事物都感興趣，積極自行研習，而且擁有超凡的記憶力，只要聽過、讀過的，他都能毫無錯漏的放在腦袋裡。1842年，聖桑開始跟隨卡米爾•瑪麗•斯坦蒂習琴。\n\n1848年，聖桑進入巴黎音樂學院，並進修管風琴及師隨阿萊維學習作曲。聖桑曾贏得多個獎項，但卻無緣於1852年及1864年贏取知名的羅馬大獎。聖桑的天分及名氣讓他與知名鋼琴家李斯特結緣，並且成為要好的朋友。聖桑十六歲時完成了他的第一交響曲；他的第二交響樂則以降E大調第一交響樂之名面世，並且於1853年公演，令到不少作曲家及評論家驚訝。音樂家白遼士曾這樣稱許聖桑：「他懂得所有事物，只是缺少經驗而已。」白遼士後來更成為聖桑的好友之一。\n\n【動物狂歡節】創作於1886年，並於1886年3月9日非正式的演出，當時只有幾位好友參與。聖桑原本只把這個作品當作平常和朋友交流所演奏的小作品，並沒有把他當作正式的作品。除了《天鵝》以外，一生都沒有公開其他作品。直到1921年聖桑過', 1, '2025-06-12 13:19:20'),
(125, '沙丘 第二部\nDune: Part Two', '2025-06-12 10:28:44', 2180, 1, 6, 26, 127, 1, 1, '2024-07-26', 24, 2, '0', 'Mutant, in partnership with WaterTower Music, is proud to present the physical release of the soundtrack to Dune: Part Two, featuring a score by Academy Award®-winning composer Hans Zimmer. Hans Zimmer’s score to Dune: Part Two is a majestic and sweeping masterpiece, befitting one of the year\'s best films. Hans Zimmer is a master of contemplative and epic themes, delivering both equally here. The love themes are beautiful and tender, while the battle cries are bolder and more significant than ev', 1, '2025-06-12 13:19:20'),
(126, '凱吉²\nCage²', '2025-06-12 10:28:54', 1280, 1, 1, 1, 128, 1, 1, '2024-05-31', 35, 1, '0', '法國鋼琴家舒馬尤透過最新專輯《凱吉²》匯集了美國作曲家約翰‧凱吉受舞蹈啟發而為鋼琴創作的20首作品，此黑膠版本則是精選出其中的15首。它延續了舒馬尤對特定作曲家的探索，這樣的想法始於2023年舒馬尤發行的專輯，那張專輯是專注於法國作曲家薩提而發的《給薩提的信Letter(s) to Erik Satie》。那張專輯將凱吉與薩提的音樂並陳，因為凱吉在20世紀中葉推廣與發揚光大作曲家薩提的作品。而《給薩提的信》這張專輯在當時也被《衛報》讚譽為「收藏中的瑰寶」。\n\n這張專輯的名稱《凱吉²》取自過去一場舞台上的演出，該表演是凱吉在1940-1945年間為該演出在法國各地一起巡迴演出這套作品。出於演出的需要，舞台上需要有4台鋼琴，每台鋼琴都以不同的方式「預備」在舞台上。此張專輯名稱為使用作曲家凱吉的名字，再加上數學中的二次方，既是指兩位表演者（鋼琴家舞者）的互補關係，也是指舞台上由4台鋼琴組成的正方形。', 1, '2025-06-12 13:19:20'),
(127, '布魯克納：第九號交響曲〈四樂章版〉\nBRUCKNER: Symphony No. 9 in D minor', '2025-06-12 10:29:02', 980, 1, 1, 5, 129, 1, 1, '2024-08-23', 53, 2, '0', '★2012年2月7-9日，柏林愛樂廳現場演出錄音！\n★拉圖帶領柏林愛樂演出四樂章的布魯克納第九號交響曲，以嶄新的詮釋帶領聽者以另一種不同的聆賞角度進入傳統德奧樂派的世界！\n★2024年9月4日是布魯克納200歲生日，以此黑膠發行紀念他。\n\n布魯克納的第9號交響曲是他生前不停再創作的，直到他過世為止。他留下的作品架構鮮明與宏大，標誌著19世紀交響曲的結束，不過他也留下為樂曲的第4樂章所創作而遺留下來的片段與草稿，為他的一生畫下句點。這是布魯克納歷時20幾年最終未能完成的最後的作品。在他所遺留下的樂譜中，能感受出布魯克納預計在終樂章以強烈而富有遠見的輝煌燦爛為他的音樂遺願及遺囑畫上圓滿的句號。指揮家賽門‧拉圖爵士說：「這個終樂章的所有奇怪之處都是100%的布魯克納，人們可以看到他當時生活中所經歷的恐懼、害怕與熱情。」\n\n這份第九號交響曲，賽門‧拉圖爵士選擇呈現了一首大家非常不熟悉的第九號交響曲型式：四樂章。但布氏在死前深知自己來不及完成此樂章，因此就聽旁人建議，指示可以用他的感恩讚歌當作第四樂章，效法貝多芬第九交響曲「合唱」那樣，用合唱樂章結束全曲。但是拉圖不願意採用這樣的建議，他採用根據', 1, '2025-06-12 13:19:20'),
(128, 'Romance Latino vol.1', '2025-06-12 10:29:06', 1180, 1, 5, 21, 130, 1, 1, '2024-11-06', 29, 1, '0', 'Bossa Nova女王，小野麗莎黑膠盤發行！\n\n以「Sophisticate／Estilo（洗鍊）」為主題，與OSCAR CASTRO-NEVES合作製作。將Bossa Nova融入懷舊的拉丁曲目。', 1, '2025-06-12 13:19:20'),
(129, 'Romance Latino vol.2', '2025-06-12 10:29:11', 1180, 1, 5, 21, 131, 1, 1, '2024-11-06', 29, 1, '0', 'Bossa Nova女王，小野麗莎黑膠盤發行！\n\n以「Romantico」為主題，拉丁抒情曲為中心的選曲。獻給戀人們', 1, '2025-06-12 13:19:20'),
(130, 'Romance Latino vol.3', '2025-06-12 10:29:17', 1180, 1, 5, 21, 132, 1, 1, '2024-11-06', 29, 1, '0', 'Bossa Nova女王，小野麗莎黑膠盤發行！\n\n以「Caliente（溫暖）」為主題。與在日本live house演奏古巴音樂的樂手們，演奏原汁原味的拉丁音樂，是一張歡樂且備受各世代喜愛的專輯。', 1, '2025-06-12 13:19:20'),
(131, 'Amy Winehouse 傳記電影《Back to Black》配樂\nBack To Black: Music By Nick Cave & Warren Ellis', '2025-06-12 10:34:12', 1080, 1, 6, 26, 133, 1, 1, '2024-09-13', 1, 1, '1', '2024年Amy Winehouse傳記電影《Back to Black》配樂由Nick Cave & Warren Ellis製作，除了根據劇情創作以外，也融合憂鬱的弦樂和環境音，深刻捕捉她一生的動蕩和具有情感的藝術創作，這個封面太美了。', 1, '2025-06-12 13:19:20'),
(132, '青い森 Ⅲ -蔦屋書店の音楽', '2025-06-12 10:34:20', 1180, 1, 5, 20, 134, 1, 1, '2024-10-03', 24, 1, '0', '音楽家 haruka nakamuraが2023年-2024年、蔦屋書店の全国のいくつかの店内音楽を1年間 担当します。楽曲は全て蔦屋書店プロジェクトのための書き下ろし曲。本を扱う書店のコンセプト、またピアノや楽器の生まれる地でもある「森」をテーマに、ナカムラの故郷の青森と繋がった「青い森」と題し2024年夏までの期間中、全4作品のアルバムを制作予定。第一弾では初のシンセサイザーのみの音楽で話題となり、多くのリスナーに愛聴されている。第二弾はピアノ・アンビエントの世界。リスナー待望の音楽世界観で好評を博した。\n今作は川内倫子のジャケット写真にも表現されている夜明けのようなblueの世界。三作目となり最も深く内なる声へ潜っていくような、深淵な青い音。青い森シリーズのトータルなコンセプチュアルにより、手元に残したい美しい装丁としても展開される。', 1, '2025-06-12 13:19:20'),
(133, '傑利莫里根與班韋伯斯特超絕聯演\nGerry Mulligan Meets Ben Webster', '2025-06-12 10:34:55', 1680, 1, 2, 10, 135, 1, 1, '2024-07-26', 39, 1, '1', '如果低音薩克斯風的大師與高音（Tenor）薩克斯風的強將相遇，會是多麼光華奪目的一場音樂饗宴？傑瑞．穆勒根與班．韋伯斯特這兩位薩克斯風界的英雄在一九五九年，以馬拉松式的競技切磋錄音，滿足了爵士迷的狂想。新數位錄音科技更將兩人鋼管口浮溢的氣流抖動都呈現纖毫畢現。美國（Down Beat）雜誌將這套錄音譽為爵士史上最偉大的錄音，並給予五顆星的最高評價，誠然當之無愧。\n ', 1, '2025-06-12 13:19:20'),
(134, '威爾第與董尼采替:詠嘆調選曲(彩膠)\nArias By Verdi & Donizetti', '2025-06-12 10:36:35', 878, 1, 1, 4, 136, 1, 1, '2024-07-30', 7, 1, '0', '威爾第和董尼采替的《詠嘆調選曲》最初於1968 年發行，開頭選自威爾第四部歌劇中的詠嘆調：《路易莎•米勒》、《福斯卡利父子》、《假面舞會》和《馬克白》。接下來是董尼采替四部歌劇中的詠嘆調：《拉美莫爾的露西亞》、《阿爾巴公爵》、《最愛》和《唐•塞巴斯蒂亞諾》，收錄在專輯的AB第二面。這張唱片可以說包含了帕華洛帝整個職業生涯中最自然、最完美的演唱，這次以黃色膠片呈現他在歌劇界引人注目的永恆地位術。', 1, '2025-06-12 13:19:20'),
(135, '孟德爾頌\nMendelssohn', '2025-06-12 10:36:56', 1378, 1, 1, 1, 137, 1, 1, '2024-07-30', 7, 2, '0', '★依莎塔•坎納－梅森，鋼琴\n☆布洛克瑟姆，指揮 / 倫敦莫札特演奏家樂團\n \n這張專輯匯集了孟德爾頌姐弟的音樂：菲利克斯華麗的第一鋼琴協奏曲和姐姐芬妮‧孟德爾頌的失傳之作《復活節奏鳴曲》，以及其他作曲家改編的孟德爾頌著名作品。\n\n鋼琴家依莎塔。坎納－梅森表示：「對我來說，將芬妮和菲利克斯的作品同時納入這張專輯是非常重要的。近幾十年來，我們才開始聽到芬妮的作曲，這是令人驚嘆的音樂」，「我對芬妮‧孟德爾頌非常著迷，她在受拘束的環境中生活，但她的音樂卻充滿了火焰和激情。」十九世紀女性的生活受到許多限制，芬妮因性別原因被父親禁止追求音樂事業，只能將音樂視為一種「裝飾」。然而，芬妮私下創作了近五百部作品，許多作品至今仍在繼續被發掘。\n\n這張專輯不僅包括芬妮‧孟德爾頌《復活節奏鳴曲》的首度錄音，還收錄了李斯特改編的《乘著歌聲的翅膀》、拉赫曼尼諾夫改編的《仲夏夜之夢》序曲，以及菲利克斯的《無言歌》和芬妮的《夜曲》。伊莎塔希望通過這張專輯，讓人們重新認識和欣賞芬妮的音樂成就。\n\n孟德爾頌姐弟童年時期經常一起演奏音樂，並在成年後保持親密的關係，甚至在一年內相繼去世。伊莎塔與大提琴家弟弟謝庫•坎納─梅森多', 1, '2025-06-12 13:19:20'),
(136, 'No More Water: the Gospel of James Baldwin', '2025-06-12 10:38:34', 1480, 1, 2, 8, 138, 1, 1, '2024-08-02', 49, 2, '0', 'Meshell Ndegeocello, insigne bassista, pluristrumentista, cantante e compositrice vincitrice insignita di GRAMMY®, arriva con il secondo album per Blue Note Records: NO MORE WATER: THE GOSPEL OF JAMES BALDWIN è un omaggio al grande scrittore, in uscitaproprio il giorno del centesimo anniversario della sua nascita. Opera visionaria, esperienza musicale, servizio religioso, celebrazione,testimonianza, e anche un invito all\'azione. Spalleggiata dai fidati collaboratori (il vocalist Justin Hicks, il', 1, '2025-06-12 13:19:20'),
(137, 'The Duets (30th Anniversary)', '2025-06-12 10:39:18', 1180, 1, 1, 4, 139, 1, 1, '2024-10-25', 30, 1, '0', 'Marking his 30th anniversary, beloved tenor Andrea Bocelli, the most celebrated classical singer in modern history, celebrates his iconic career with ‘Duets’. This new careerspanning duets collection includes classic duets with Ed Sheeran, Pavarotti, Celine Dion, Zucchero, Matteo Bocelli, Stevie Wonder, Jennifer Lopez, Dua Lipa, Giorgia, Lang Lang and Cecilia Bartoli, alongside brand new tracks featuring superstar collaborations.\n\nThis ‘Highlights’ LP features all the biggest tracks from Andrea', 1, '2025-06-12 13:19:20'),
(138, 'Walkin After Midnight', '2025-06-12 10:39:32', 1380, 1, 4, 17, 140, 1, 1, '2024-12-13', 54, 1, '1', 'Eva Cassidy\'s After Midnight collection is literally a ticket back to Eva\'s accidental Western Swing Night. A small gig at the King of France Tavern, downtown Annapolis. The 2nd of November, 1995, two months prior to her now famous Live At Blues Alley recordings. When two of Eva\'s usual four band mates were unavailable, she improvised via an impromptu invite to musician friend Bruno Nasta.\n\nProving the old adage, less can be more, the resulting violin/ lead guitar/bass combo, together with Eva\'s', 1, '2025-06-12 13:19:20'),
(139, 'Wonderful World: The Best Of Louis Armstrong', '2025-06-12 10:40:04', 1180, 1, 2, 8, 141, 1, 1, '2024-09-24', 39, 1, '1', '★16億次的全球播放聆聽!!!-多麼美好的世界!What a Wonderful World!-音樂史上最重要的微笑歌神音樂巨人，以美國爵士文化的代名詞來形容他一點都不為過！此張微笑歌神最新金曲全精選為您呈現最讓人懷念的歌神經典完美精選\n\n★收錄包括-What a Wonderful World-全球至今累計16億次播放聆聽(僅指數位時代有大數據可循/未含實體時代數據)，美國太空總署NASA選用，將其向無垠外太空做無限光年放送期待與其它生命體發生接觸，因為這是最能夠代表全人類和平美好世界期待的一首歌....       \n\n這個世界最重要的一首歌- 「What a Wonderful World」，就是出自於此位音樂史上最重要的微笑歌神音樂巨人- 路易斯‧阿姆斯壯，他在爵士樂上的卓越成就，以美國爵士文化的代名詞來形容他一點都不為過！他歌唱時宛若邊琢磨著細石顆粒的沙啞嗓音，辨識度極高的獨有聲線，再加上好似和煦陽光般的溫暖唱腔，所蘊含之真誠敦睦質感更是無人能及...\n\n  正如同爵士名伶比莉‧哈樂黛所言：「阿姆斯壯如此親切的演唱方式，真的足以化解了人與人之間的藩籬！」，其真摯歌聲真正地闡揚', 1, '2025-06-12 13:19:20'),
(140, 'The Man With the Horn (Gold Vinyl)', '2025-06-12 10:40:23', 1080, 1, 2, 8, 142, 1, 1, '2024-09-27', 27, 1, '1', 'Ｍiles’nephew Vince Wilburn was responsible for getting the trumpeter out of the suicidal withdrawal in which he had enclosed himself since 1975. Wilburn, a drummer in a Chicago group that played music that combined funk, soul, and fusion jazz, persuaded his uncle in New York to join them in the studio. Miles, however, no longer had the same technical facility and had to record his trumpet parts later. He also met the saxophonist Bill Evans, the bass guitarist Marcus Miller, and called the drumme', 1, '2025-06-12 13:19:20'),
(141, 'UTAU', '2025-06-12 10:40:28', 3680, 1, 5, 20, 143, 1, 1, '2024-07-03', 55, 3, '0', '2010年にリリースされた大貫妙子とのコラボレーション・アルバムのLP盤\n\n2010年にリリースされた坂本龍一と大貫妙子のコラボレーション・アルバム『UTAU』の初アナログ・レコード盤。坂本龍一の過去の楽曲に大貫妙子が新たに詞をつけたもの、以前のふたりでの共同作品、童謡の「赤とんぼ」、「a life」で構成されている。\nピアノと歌だけというシンプルな表現だからこそ、1970年代初期から続くふたりの豊かな歴史が伝わってくる、究極のミニマル空間で「うた」を追求した作品。\n\nCD発売時に付属したボーナス・ディスクの内容も網羅されている。', 1, '2025-06-12 13:19:20'),
(142, '東尼瀧谷 電影原聲帶\nTony Takitani', '2025-06-12 10:40:33', 2380, 1, 6, 25, 144, 1, 1, '2024-09-25', 55, 2, '0', '村上春樹の短編小説を市川準監督が映画化した『トニー滝谷』のサウンドトラック・アルバム、初LP化！\n2005年に公開された村上春樹の短編小説を市川準監督が映画化した『トニー滝谷』のサウンドトラック・アルバム初LP化！！\n \nコンサートでよく演奏される「Solitude」などピアノ演奏のみの静謐で美しい世界が構築されている。\n映画公開当時はサウンドトラック・アルバムはCDやレコードで発売されず、iTunes Storeでのダウンロード販売のみが行われて話題になった。\nこのCDは2007年になってあらためて発売、LP化は本作が初めてとなる。\n \n■LP2枚組カラーヴァイナル', 1, '2025-06-12 13:19:20'),
(143, '德弗札克：第九號交響曲「新視界」&美國組曲\nDvorak: Symphony No. 9 \"\"From the New World\"\", American Suite', '2025-06-12 10:41:33', 1080, 1, 1, 5, 145, 1, 1, '2024-08-30', 35, 1, '0', '娜妲莉．史都茲曼指揮的第一張專輯收錄了德弗札克著名的第九號交響曲「新世界」和較不為人所知的美國組曲。娜妲莉．史都茲曼(Nathalie Stutzmann) 師從芬蘭指揮大師喬瑪‧潘努拉(Jorma Panula) 學習指揮，並受益於賽門‧拉圖(Simon Rattle) 和已故小澤徵爾(Seiji Ozawa) 的指導。她在美國擔任兩個重要職務：亞特蘭大交響樂團的音樂總監，和費城交響樂團的首席客座指揮，並曾與倫敦交響樂團、巴黎交響樂團、拜魯特音樂節等樂團進行客座演出。賽門‧拉圖 (Simon Rattle) 告訴《紐約時報》：“娜塔莉是真實地存在。如此多的愛、熱情和純粹的技巧。”', 1, '2025-06-12 13:19:20'),
(144, '美國公路之旅\nAmerican Road Trip', '2025-06-12 10:41:39', 1180, 1, 1, 3, 146, 1, 1, '2024-08-23', 35, 1, '0', '在這張最新專輯中，小提琴家奧古斯汀‧哈德利希踏上了美國公路之旅，在鋼琴家歐林．魏斯的陪伴下，穿越音樂的高速公路並途經他的第二個家。兩人演奏的作品來自於美國作曲家大熔爐，創作於 19、20 和 21 世紀，並借鏡了多種習慣用語、影響力和靈感……從歐洲浪漫主義到復興主義讚美詩；從藍調、爵士樂到草根音樂；從班鳩琴到烏克麗麗再到吉米‧罕醉克斯的吉他；從墨西哥「小星星」到精緻的日本雕刻。科普蘭(Aaron Copland)、伯恩斯坦(Leonard Bernstein)、查爾斯‧艾伍士(Charles Ives) 和約翰‧亞當斯(John Adams) 與艾米•比奇(Amy Beach)、科爾里奇─泰勒‧柏金森(Coleridge-Taylor Perkinson)、艾迪‧索斯(Eddie South)、豪迪‧弗雷斯特(Howdy Forrester)、曼努埃爾‧M‧龐塞(Manuel M. Ponce) 並排，以及與亞當斯一起併排違當今指標性作曲家的丹尼爾‧伯納德‧魯曼(Daniel Bernard Roumain)和史蒂芬‧哈特克(Stephen Hartke)。\n\n奧古斯丁‧哈德里奇出生於', 1, '2025-06-12 13:19:20'),
(145, '葛利格、法朗克、紹爾/普雷特涅夫改編、蕭士塔高維奇：作品集\nGrieg, Franck, Shor-Pletnev, Shostakovich', '2025-06-12 10:41:45', 1080, 1, 1, 1, 147, 1, 1, '2024-08-30', 35, 1, '0', '丹尼爾‧洛薩科維契，一位擁有完美技巧與深度音樂性的小提琴家。在華納古典所發行的第一張專輯，是與普雷特涅夫合作，由普雷特涅夫擔任鋼琴演奏，帶來豐富而高貴的演奏與深刻的詮釋。\n\n洛薩科維契13歲在韋爾比音樂節上第一次聽到普雷特涅夫的鋼琴演奏，因而留下深刻得印象。幾年後，透過音樂節總監的介紹，洛薩科維契因而有機會結識普雷特涅夫，並一起演奏了柴可夫斯基的三重奏作品。他們兩位說，從那時候起，他們就建立的跨越世代的友誼。\n\n在這張專輯中，兩位音樂家的音樂表現十分和諧。曲目除了作曲家葛利格和法朗克的奏鳴曲之外，還有普雷特涅夫根據1970年出生於烏克蘭的阿列謝克‧紹爾所創作的小提琴協奏曲改編的小提琴奏鳴曲，獨具風采。同時身為數學家的紹爾，在作為作曲家的身分雖然大器晚成，但他的作品卻大受好評，並被世界知名的音樂家所演譯，作品擁有優美的旋律，並包含對和平的祈禱，而洛薩科維契與普蕾特涅夫的演奏，充分表達了音樂創作的喜悅和希望。\n\n專輯以葛利格的皮爾金組曲中的「蘇爾維格之歌」開場，也以葛利格的作品「第3號小提琴奏鳴曲，作品45」作為結尾，在結尾的奏鳴曲中，兩人將樂曲中充滿活力與憂鬱表現得淋漓盡致。中間則有蕭士', 1, '2025-06-12 13:19:20'),
(146, '薩爾達傳說 電玩配樂選輯\nMusic From the Legend of Zelda', '2025-06-12 10:41:51', 2180, 1, 6, 28, 148, 1, 1, '2024-10-18', 48, 3, '0', '', 1, '2025-06-12 13:19:20'),
(147, '《心之谷》電影原聲帶', '2025-06-12 10:41:57', 1080, 1, 6, 27, 149, 1, 1, '2024-11-03', 56, 1, '1', '《心之谷》（耳をすませば）原聲帶專輯，重新以管弦樂形式錄製，帶來前所未有的細緻音樂體驗。本專輯是以原先發行的印象專輯為基礎，重新編曲並由完整的管弦樂團演奏與錄音，為經典動畫注入新的生命與層次。\n\n除了精彩的配樂外，專輯亦收錄了本片最廣為人知的主題曲〈Country Road（鄉村路）〉日文版，由女主角所演唱的動人旋律將青春的悸動與夢想再次喚醒，極具收藏價值。\n\n無論您是吉卜力的忠實影迷，還是熱愛電影配樂的樂迷，這張專輯都能帶您重新走進《心之谷》的純真世界，體會那段屬於青春、夢想與音樂交織的美好時光。', 1, '2025-06-12 13:19:20'),
(148, '《心之谷》印象專輯', '2025-06-12 10:42:03', 1080, 1, 6, 27, 150, 1, 1, '2024-11-03', 56, 1, '1', '本專輯為《心之谷》（耳をすませば）的印象音樂集，是根據宮崎駿親自擔任製作與編劇所創作的分鏡圖與文字草稿所構思出的音樂作品。透過作曲家的詮釋，將影像尚未完成時的世界觀與情感，提前以音樂的形式呈現，深具藝術與想像力。\n專輯中收錄了豐富的樂曲，並特別加入 4 首主唱歌曲，使整體氛圍更具感染力與故事感。這些音樂既有獨立欣賞的價值，也能讓人更深入體會《心之谷》所描繪的青春、夢想與成長歷程。\n對於喜愛吉卜力動畫與宮崎駿創作風格的樂迷而言，這張印象專輯不僅是聆聽的享受，更是一段通往動畫靈魂深處的聲音旅程。', 1, '2025-06-12 13:19:20'),
(149, 'イリュージョン\nIllusions: Escape From the Busy Commition of the City', '2025-06-12 10:42:22', 1380, 1, 5, 22, 151, 1, 1, '2024-07-24', 24, 1, '0', 'クニモンド瀧口のプロジェクトの流線形がヴォーカリストにシンガーソングライターのSincere（シンシア）をメンバーに迎えて<RYUSENKEI>としての第1作をアナログ盤化！', 1, '2025-06-12 13:19:20'),
(150, 'At the Hickory House, Volume 1 (Mono)', '2025-06-12 10:42:39', 1180, 1, 2, 9, 152, 1, 1, '2024-09-20', 49, 1, '1', '期待已久，德國爵士女鋼琴家Jutta Hipp的作品再度釋出，偕同鼓手Ed Thigpen以及貝斯Peter Ind組成三重奏的現場錄音。本次Blue Note挖出老母帶交由Kevin Gray以全類比的方式重新後製，再交給德國Optimal壓製。\n ', 1, '2025-06-12 13:19:20'),
(151, '復仇者聯盟：終局之戰 電影原聲帶\nAvengers: Endgame OST (Purple Vinyl)', '2025-06-12 10:43:49', 1380, 1, 6, 26, 153, 1, 1, '2024-09-06', 33, 1, '1', '★全球狂掃26億美元、台灣影史票房第二名【復仇者聯盟】系列最終章電影原聲帶\n★【復仇者聯盟】、【美國隊長】配樂大師Alan Silvestri回歸打造漫威電影最終樂章，劃下11年完美句號 【電影入座】 復仇者聯盟系列最終章！灰飛煙毀後的世界該如何走下去，是否還有逆轉結局的機會？一切都將在此揭曉。\n\n歷經11年、21部超級英雄電影的累積，醞釀出漫威電影宇宙的總結 —【復仇者聯盟：終局之戰】，一上映，台灣首日即吸金8000萬，至今已經飄破8億，而全球也已狂掃26億美元，擠下【鐵達尼號】成為全球影史票房第二，成為2019年最賣座電影。 【音樂開始】 轟動全球影壇的超級賣座系列【復仇者聯盟】，配樂無疑的佔有非常舉足輕重的地位，【復仇者聯盟：終局之戰】的導演羅素兄弟（Russo Brothers）找回擔綱前作【復仇者聯盟：無限之戰】的配樂大師亞倫‧席維斯崔(Alan Silvestri)回歸操盤，他曾獲得2次奧斯卡提名、2次金球獎提名，並擁有葛萊美獎及艾美獎肯定，先前也已為【復仇者聯盟】、【美國隊長】操刀配樂，過去代表作包括:【回到未來】三部曲、【阿甘正傳】、【博物館驚魂夜】、【走鋼索的人】]，', 1, '2025-06-12 13:19:20'),
(152, '你在我心上 30周年紀念專輯 (紅黑大理石紋彩膠)\nAlways On My Mind: CoCo s 30th Anniversary Album', '2025-06-12 10:43:54', 1658, 1, 4, 17, 154, 1, 1, '2024-09-27', 2, 1, '0', '★CoCo李玟 《Always On My Mind》 經典翻唱專輯，紅黑大理石紋彩膠紀念版\n★Made In Germany德國壓片製作180g重磅彩膠，33 1/3轉\n\n收錄8首CoCo李玟親自監製摯愛金曲 堅持高品質錄音製作\n對音樂、對家庭、對歌迷們的愛 CoCo李玟永遠放在心上\n\n2024年是CoCo李玟出道30周年，雖然她已離開我們，對她的思念及追想從未間斷，粉絲也衷心期盼可以聽見更多CoCo未曾釋出的作品。就在今年，CoCo生前已錄製完畢的經典翻唱歌曲錄音，集結成專輯《Always On My Mind》出版 。\n\n這些經典歌曲是由CoCo自己親任監製，從2016年開始陸續製作，CoCo挑選自己與家人喜愛的歌、抒發自己心情的歌，以及對當代有深刻影響的經典歌曲，以自己的想法重新詮釋，從近40首預選歌單中進行討論、試唱，最終濃縮出8首完成品。CoCo很清楚這些老歌原本的曲風與背後故事，每一首她都用了很多心血去加入創意重新編排跟領悟歌詞的故事。歌單有抒情經典「夜夜夜夜」、「我真的受傷了」、「你怎麼捨得我難過」，CoCo兒時在香港長大喜歡的粵語歌「疾風」，CoCo媽媽的偶像貓王代表', 1, '2025-06-12 13:19:20'),
(153, '音樂圖鑑 (附贈七吋盤)', '2025-06-12 10:44:39', 1680, 1, 5, 20, 155, 1, 1, NULL, 24, 2, '1', '首度日本海外授權發行，1984年坂本龍一的專輯，由東京 Saidera Mastering 重製，並再附贈的七吋盤裡額外收錄兩首曲目。', 1, '2025-06-12 13:19:20'),
(154, '世界\nWorld', '2025-06-12 10:46:36', 1180, 1, 4, 18, 156, 1, 1, NULL, 24, 1, '1', '數字搖滾樂團⼤象體操⾃ 2013 年推出⾸張作品，曾踏上⽇本 Fuji Rock、美國 Camp Flog Gnaw 萬⼈⾳樂節、SXSW 南⽅⾳樂節、韓國 Pentaport Rock Festival、英國 ArcTanGent 等國際⼤型舞台，累積超過百場海外演出，與舞蹈、戲劇、影像等多次跨界合作經驗，⼗年 間持續突破搖滾樂框架，在不同樂風間⾃由穿梭。 「時間總在不知不覺中流逝，我們的⾳樂卻依舊延伸。」⼤象體操已經走過⼗年的路程，經 歷了無數起伏。2023 年末，⼤象體操將發⾏樂團的第四張創作專輯《世界 World》，展開 逾 40 場的世界巡迴旅程，向全球的樂迷展⽰他們的⾳樂世界和信仰。 專輯收錄與⽇本傳奇搖滾樂團「東京事變」⾙斯⼿⿔⽥誠治合作，⾸次挑戰雙⾙斯編曲、共 創歌曲〈名字 Name〉，兩把⾙斯別具⼀格⼜交織對話；⾸次與印度歌⼿ Shashaa Tirupati 合作譜寫繚繞神秘魔⼒的歌曲〈Jhalleyaa〉，為專輯第⼀⾸釋出的單曲；與歌⼿林以樂 YILE LIN 合作〈快樂王⼦〉，舒暢明快的搖滾風格，搭配細膩的詞曲和直率的嗓⾳，相互 輝映；新曲〈⽻⽑〉分別邀請壞特 ', 1, '2025-06-12 13:19:20'),
(155, '平成狸合戰 印象專輯', '2025-06-12 10:46:56', 1080, 1, 6, 27, 157, 1, 1, '2024-11-03', 56, 1, '0', '大好評発売中のスタジオジブリ作品のアナログ盤シリーズに、高畑勲監督作品「平成狸合戦ぽんぽこ」、近藤喜文監督作品「耳をすませば」が登場。\n各作品共イメージアルバム、サウンドトラックのリマスタリングを行い、ジャケットも新絵柄を採用、解説やライナーノーツも充実した豪華仕様。\nジャケットの美しさ、アナログならではの、音の豊かさを、お楽しみ下さい。\n※4タイトル共通：通常黒盤１枚組、シングルジャケット、帯＆ライナーノーツ付、アートワーク制作中。\n\n多摩で暮らすタヌキたちを主人公にした高畑勲監督のコンセプト、“さまざまな要素からなる日本的な音楽”を念頭に作られたアルバム。\n（CD発売日1994.6.25）音楽：八草楽団　全12曲\n\n総天然色漫画映画 平成狸合戦ぽんぽこ\n1994年7月公開 ／ 原作・脚本・監督：高畑勲 ／ 企画：宮﨑駿 ／ 音楽：八草楽団\nエンド・テーマ「いつでも誰かが」歌：上々颱風', 1, '2025-06-12 13:19:20'),
(156, 'Nha Sentimento', '2025-06-12 10:50:35', 1480, 1, 4, 17, 158, 1, 1, '2024-06-14', 27, 2, '0', '★180 gram audiophile vinyl\n★Includes 4-page booklet with lyrics\n★Features \"Serpentina\", \"Verde Cabo di Nhas Odjos\"\n★Contains the bonus track \"Gaivota Pa Voa\"\n★For the first time available on vinyl\n★15th anniversary edition of 500 numbered copies on crystal clear vinyl\n\nNha Sentimento is the eleventh and final studio album released by Cape Verdean singer Cesaria Evora. The album consists of 14 songs, most of them written by Cesaria\'s well-known writers Teófilo Chantre and Manuel de Novas. For the', 1, '2025-06-12 13:19:20'),
(157, '生命\nLIFE', '2025-06-12 10:50:42', 1068, 1, 1, 3, 159, 1, 1, '2024-08-29', 7, 1, '0', '瑪麗‧薩穆爾森是近年頗受矚目的小提琴家。她出生於挪威哈馬爾，三歲開始向著名挪威小提家亞佛‧泰勒弗森學習小提琴，接著前往奧斯陸巴萊特─杜音樂學校師事史蒂芬‧巴萊特─杜，接著在蘇黎士師從俄羅斯著名小提琴家查哈‧布隆，與也在大提琴界擁有一片天地的大提琴家哥哥霍孔‧薩穆爾森被挪威視為當前音樂界的榮耀。\n\n雖然有堅實的古典基礎，但是薩穆爾森兄妹熱愛並且勇於嘗試各種不同類型的音樂，以《鐵達尼號》、《勇敢的心》、《美麗心靈》、《阿凡達》等電影配樂廣受喜愛與熟悉的美國作曲家詹姆斯•霍納曾經為兩人量身打造的複協奏曲《雙人舞》；瑪麗‧薩穆爾森也多次與英國作曲家馬克斯‧李希特合作。\n\n這張《生命》專輯是瑪利‧薩穆爾森在成為母親之後，用音樂探索將我們連繫在一起的原始情感，作品中反映了每個人都能引發共鳴的情感與事物，如好奇心、失敗、愛與幸福等，將這些情感與經驗透過音樂表現出來。專輯結尾以美國著名獨立搖滾樂團《The National(國民樂團)》吉他手Bryce Dessner為其子創作的搖籃曲《Octave之歌》。', 1, '2025-06-12 13:19:20'),
(158, '帕格尼尼：小提琴協奏曲 & 薩拉沙泰：卡門幻想曲\nPaganini: Violin Concerto No. 1 & Sarasate: Carmen Fantasy', '2025-06-12 10:50:59', 980, 1, 1, 3, 160, 1, 1, '2024-11-01', 35, 1, '1', '小提琴鬼才帕格尼尼一直到27歲才展開他的巡迴音樂會旅程，1813年，他成功征服義大利的音樂重鎮米蘭，從此聲名大噪。不過帕格尼尼一直要到1828年才離開義大利，真正打開國際知名度。第一號小提琴協奏曲是在1817-18年間完成的。據說，帕格尼尼有自己專屬的指法與弓法，別的小提琴家不一定模仿得來。這首協奏曲可想而知是帕格尼尼為了自己演奏會用途而創作，炫技是必然的，可是難得的是，他在這首樂曲充份展現他的旋律長才，優雅動人的歌唱性，很明顯受到當時義大利歌劇（特別是羅西尼）的作品所影響。 自幼就展現不凡音樂才華的帕爾曼，克服肢體障礙，憑著過人毅力，站上頂尖演奏家的席位。帕爾曼曾接受一代名師葛拉米安與狄蕾女士的指導，盡得真傳。上個世紀的70年代開始，帕爾曼從征服卡內基、贏得列文垂特大賽，一路過關斬將，並且開始簽下唱片合約，真正讓世人認識這位正在發光發熱的明日之星。早在1969年，帕爾曼就曾經在紐約舉辦一場解說式的音樂會，曲目正是帕格尼尼的第一號小提琴協奏曲，他在音樂會上分析樂曲，說明演奏家如何「微調」以完美表現這首全面展現小提琴演奏藝術的曠世傑作。專輯中的薩拉沙泰「卡門幻想曲」改編自比才歌劇「卡門」', 1, '2025-06-12 13:19:20'),
(159, 'Orang-utan', '2025-06-12 10:51:20', 1380, 1, 4, 16, 161, 1, 1, '2024-10-23', 23, 1, '0', ' ★「ブロー・アップ」以降、一曜人気ベーシストとなった、鈴木勲のTBM第4弾。\n\n★鬼才・森剣治らと捻出する重厚なグルーヴィー・サウンドは時代を経ても決して色褪せない。（シリーズ監修：塙耕記氏より）\n\n※ SMEからのTBMレーベル市販CD,LP商品としては2007年以来の発売となる”three blind mice プレミアム復刻コレクション”シリーズ第I期第3回発売分。\n\n鈴木 勲 (bass,cello,el-piano)\n森 剣治 (as,fl,b-cl)\n渡辺 香津美 (guitar)\n河上 修 (bass)\n守 新治 (drums)\n中本 マリ (vocal)', 1, '2025-06-12 13:19:20'),
(160, 'NEO GEO (完全生產限定盤黑膠)', '2025-06-12 10:51:31', 1328, 1, 5, 20, 162, 1, 1, '2024-08-30', 23, 1, '0', '這張專輯於1987年首次發行，是坂本龍一的第七張個人專輯，並由Bill Laswell共同製作，成為他首張全球發行的專輯。專輯中匯聚了來自不同音樂流派的頂尖音樂家，如Sly Dunbar、Bootsy Collins和Tony Williams等。錄音工作在東京和紐約之間進行，該專輯在超過20個國家發行，成為他個人職業生涯中的一個重要里程碑。這次再版由Bernie Grundman進行最新的數位重製，將以高品質格式推出。', 1, '2025-06-12 13:19:20'),
(161, 'Midnight Crusin (COBALT BLUE VINYL)', '2025-06-12 10:53:30', 1280, 1, 5, 20, 163, 1, 1, '2025-08-02', 24, 1, '0', '1982年リリースの濱田金吾の4thアルバム『midnight cruisin\'』がクリア・カラー・ヴァイナルでリプレス決定!\n\n日本のAORシーンの代表格、濱田金吾が浜田金吾名義でアルファ・ムーン在籍時にリリースしたオリジナルアルバム『midnight cruisin\'』がリイシュー。\n\n近年海外での人気も著しく上昇中の盟友松下誠をはじめ実力派ミュージシャンたちが参加の極上メロウ傑作です。', 1, '2025-06-12 13:19:20'),
(162, '與克里斯汀的對話\nConversations With Christian', '2025-06-12 10:54:01', 1880, 1, 4, 16, 164, 1, 1, NULL, 57, 1, '1', '由知名貝斯手Christian McBride集結13組二重奏和一群重量級合作嘉賓，聯手展現精湛演出。專輯中呈現出多元化的樣貌，樂風觸及爵士、流行和古典。其中，Christian McBride和小提琴家Regina Carter更以超脫的演譯來詮釋巴哈的曲目。另外; Christian McBride也與當代爵士樂大師小號手Roy Hargrove、中音薩克斯手Ron Blake和吉他手Russell Malone，以及美國知名爵士鋼琴家Chick Corea、 George Duke、已故鋼琴家Dr. Billy Taylor和Hank Jones合作，其合作陣容之堅強，絕對是不可錯過的雋永珍藏。', 1, '2025-06-12 13:19:20'),
(163, '《我推的孩子》Idol', '2025-06-12 10:57:14', 1180, 1, 5, 22, 165, 1, 1, '2024-11-15', 51, 1, '0', 'Dive into the world of stardom with Idol by YOASOBI, the opening theme for the anime sensation Oshi no Ko. Inspired by Aka Akasaka’s short story “45510,” this track blends Japanese idol pop, hip-hop, rock, and video game vibes into an unforgettable piece of music. The song captures the highs and lows of fame through Ai Hoshino’s journey, from fan adoration to groupmate jealousy. It’s no wonder this hit ruled the Billboard Japan Hot 100 for 22 non-consecutive weeks!', 1, '2025-06-12 13:19:20'),
(164, 'FIXER', '2025-06-12 11:00:55', 1580, 1, 5, 21, 166, 1, 1, '2023-12-13', 29, 2, '0', '中森明菜黑膠發行第2彈、原創專輯初LP化！！\n2017年紀念中森明菜出道35週年，環球音樂發行的《FIXER》[UHQCD]首次黑膠化！', 1, '2025-06-12 13:19:20'),
(165, '7情6慾', '2025-06-12 11:03:39', 1580, 1, 4, 17, 167, 1, 1, '2024-12-20', 25, 1, '0', '★限量600張\n★獨立編號版\n全球限量黑膠版 ~極品珍藏~\n\n李翊君同時精通國語歌和台語歌的「雙聲帶」見稱。為多部瓊瑤電視連續劇演唱過主題曲、片尾曲、插曲。\n\n十三歲第一次登台演出《蘇三起解》的蘇三。出道作品為1987年出版的《萍聚》專輯，源自救國團歌曲，每每活動時傳唱。李翊君推出第一張個人專輯《萍聚》，銷量超過四白金。\n1989年發行的《再回首》專輯，與同時間的發片男歌手姜育恆主打同一首歌曲，創下兩位歌手同時主打同一首歌的紀錄。1990年，《風中的承諾》以國語翻唱香港電影《英雄本色III》粵語片尾曲梅豔芳《夕陽之歌》，KTV創下點唱率前3名。同年，李翊君為瓊瑤電視連續劇《婉君》演唱主題曲，及為《雪珂》演唱主題曲及插曲。\n\n90年代中期到2000年初，與許美靜和許茹芸同為上華唱片公司的三大天后。\n ', 1, '2025-06-12 13:19:20'),
(166, '殘夢', '2025-06-12 11:05:08', 1580, 1, 5, 21, 168, 1, 1, '2024-12-11', 29, 2, '0', '初出場した紅白歌合戦でも披露した大ヒット曲「唱」、アニメ「SPY×FAMILY」Season 2オープニングの主題歌「クラクラ」、\nTBSドラマ「18／40～ふたりなら夢も恋も～」の主題歌「向日葵」、2024年初のリリースとなったロッテ チョコレート 60周年記念CMソング「ショコラカタブラ」など\n多数のタイアップ楽曲に加え、未発表の新録音源を含む全16曲を収録。', 1, '2025-06-12 13:19:20'),
(167, 'VOCALIST 2', '2025-06-12 11:05:23', 1880, 1, 5, 20, 169, 1, 1, '2025-01-21', 29, 2, '1', '2005年から2015年にかけて発売された初のカバーアルバム『VOCALIST』シリーズ(女性アーティストの名曲をカバー)。\nそのラストアルバム「VOCALIST 6」(2015年1月21日発売)から10年目となる2025年1月21日より、『VOCALIST』シリーズ 全6タイトルのアナログレコード盤が3ヶ月連続で発売。(「VOCALIST 4」「VOCALIST VINTAGE」「VOCALIST 6」は初アナログレコード化)', 1, '2025-06-12 13:19:20'),
(168, 'VOCALIST', '2025-06-12 11:05:27', 1880, 1, 5, 20, 170, 1, 1, '2025-01-21', 29, 2, '1', '『VOCALIST』シリーズのラストアルバム「VOCALIST 6」(2015年1月21日発売)から10年目となる2025年1月21日より、『VOCALIST』シリーズ 全6タイトルをLP化、3ヶ月連続リリース。\n（「VOCALIST 4」「VOCALIST VINTAGE」「VOCALIST 6」は初LP化）', 1, '2025-06-12 13:19:20'),
(169, 'VOCALIST 3', '2025-06-12 11:05:51', 1880, 1, 5, 20, 171, 1, 1, '2025-02-26', 29, 2, '0', '2005年から2015年にかけて発売された初のカバーアルバム『VOCALIST』シリーズ（女性アーティストの名曲をカバー）。そのラストアルバム「VOCALIST 6」(2015年1月21日発売)から10年目となる2025年1月21日より、『VOCALIST』シリーズ 全6タイトルのアナログレコード盤が3ヶ月連続で発売。（「VOCALIST 4」「VOCALIST VINTAGE」「VOCALIST 6」は初アナログレコード化）', 1, '2025-06-12 13:19:20'),
(170, 'VOCALIST 4', '2025-06-12 11:05:55', 1880, 1, 5, 20, 172, 1, 1, '2025-02-26', 29, 2, '0', '2005年から2015年にかけて発売された初のカバーアルバム『VOCALIST』シリーズ（女性アーティストの名曲をカバー）。そのラストアルバム「VOCALIST 6」(2015年1月21日発売)から10年目となる2025年1月21日より、『VOCALIST』シリーズ 全6タイトルのアナログレコード盤が3ヶ月連続で発売。（「VOCALIST 4」「VOCALIST VINTAGE」「VOCALIST 6」は初アナログレコード化）', 1, '2025-06-12 13:19:20'),
(171, 'VOCALIST VINTAGE', '2025-06-12 11:06:52', 1880, 1, 5, 20, 173, 1, 1, '2025-03-26', 29, 2, '0', '2005年から2015年にかけて発売された初のカバーアルバム『VOCALIST』シリーズ（女性アーティストの名曲をカバー）。そのラストアルバム「VOCALIST 6」(2015年1月21日発売)から10年目となる2025年1月21日より、『VOCALIST』シリーズ 全6タイトルのアナログレコード盤が3ヶ月連続で発売。（「VOCALIST 4」「VOCALIST VINTAGE」「VOCALIST 6」は初アナログレコード化）', 1, '2025-06-12 13:19:20'),
(172, 'VOCALIST 6', '2025-06-12 11:06:55', 1880, 1, 5, 20, 174, 1, 1, '2025-03-26', 29, 2, '0', '2005年から2015年にかけて発売された初のカバーアルバム『VOCALIST』シリーズ（女性アーティストの名曲をカバー）。そのラストアルバム「VOCALIST 6」(2015年1月21日発売)から10年目となる2025年1月21日より、『VOCALIST』シリーズ 全6タイトルのアナログレコード盤が3ヶ月連続で発売。（「VOCALIST 4」「VOCALIST VINTAGE」「VOCALIST 6」は初アナログレコード化）\n ', 1, '2025-06-12 13:19:20'),
(173, 'The Essential (Black Vinyl)', '2025-06-12 11:07:26', 1680, 1, 4, 17, 175, 1, 1, '2024-12-13', 30, 2, '1', 'The Essential is a testament to Melody Gardot\'s enduring artistry. This collection spans 14 years of her career and includes 25 tracks that showcase the breadth of her musical abilities. Featuring selections from her six studio albums, remixes, live recordings and previously unreleased tracks, the album captures the essence of Gardot\'s talent. Highlights include her multilingual performances, emotive renditions of classics like Elton John\'s \"Love Song,\" and live recordings that convey the raw ho', 1, '2025-06-12 13:19:20'),
(174, 'Sent (彩膠)', '2025-06-12 11:11:42', 1300, 1, 4, 17, 176, 1, 1, '2024-11-06', 58, 1, '1', '【規格】日壓彩膠、重量370g\n\n和「愛 Sent 時代」共舞，9m88 要用 8 首歌淨化「Sent 男 Sent 女」心中的苦！\n\n在這個「愛 Sent 時代」裡，我們每天收發上萬條通知，放任手機佈滿紅點，可最快的通訊軟體，也追不上最在乎的那個他。太害怕錯過，太不耐寂寞。明明身處自由表達的年代，卻學會用貼圖拖延尷尬，「笑死」、「愛心」、「哈哈哈」已是學校沒教的社交日常。\n\n籌備第三張專輯《Sent》時，9m88 遂從「訊息」發想，整理那些藏在備忘錄裡，打完又刪掉的筆記暫存檔。她分享心事，寄出清倉，自癒癒人，只求身心健康。\n\n《Sent》距離前作《9m88 Radio》僅一年，成全與國際 beatmakers 合作的夢想後，9m88 回歸華語流行本位，再度搭檔 YELLOW黃宣、余佳倫（阿涼）共同製作。創作方式卻不同於往，陸續邀請到——陳綺貞 X 馬念先 X YELLOW黃宣 X 百合花奕碩 X 羅妍婷 X 陳冠亨——齊力訂造數首詞曲；與他們親密連線，一首首逼出自己意料之外的音樂能量。\n\n\n\n【歌曲介紹】\n01 頭髮 Hair\n在愛情裡裝作沒事的我們，其實都很有事。《Sent》的專輯', 1, '2025-06-12 13:19:20'),
(175, 'I Know Nigo (Light Blue Vinyl)', '2025-06-12 11:12:48', 1480, 1, 5, 20, 177, 1, 1, '2022-12-16', 24, 1, '0', 'Nigo is a Japanese fashion designer, disc jockey, record producer and entrepreneur. He is best known as the creator of the urban clothing line \'A Bathing Ape\' and currently serves as creative director for Kenzo. \'I Know Nigo\' was released on 25th March 2022.', 1, '2025-06-12 13:19:20'),
(176, 'Just No Other Way', '2025-06-12 11:13:34', 1418, 1, 4, 17, 178, 1, 1, '2025-01-17', 2, 1, '0', '★CoCo李玟1999年第三張英文專輯，紀念CoCo出道30周年，全新黑膠紀念版本\n★專輯收錄全美告示榜舞曲榜No.49動感傑作 \"Do You Want My Love\"，澳洲排行榜No.29單曲\"Wherever You Go\"，以及收錄於電影\"Runaway Bride落跑新娘 \"原聲帶專輯之單曲\"Before I Fall in Love\"\n★Made In Germany德國壓片製作12吋180g重磅黑膠，33 1/3轉\n\n此張”Just No Other Way”專輯為CoCo李玟生涯第三張的錄音室專輯，同時也是首張進軍國際市場的雄心之作，專輯由李玟在加拿大溫哥華以及美國洛杉磯兩地製作完成，富有與一般華語音樂專輯不同的動感與能量。單曲「Do You Want My Love」找來來自紐約的嘻哈團體Natural Elements成員A-Butta合唱; 「Wherever you go」更找來Celine Dion, Mariah Carey, Whitney Houston等天后御用葛萊美獎製作人Ric Wake親手打造; 與R&B 福音歌手Kelly Price合唱的中', 1, '2025-06-12 13:19:20'),
(177, '任賢齊精選', '2025-06-12 11:13:39', 1499, 1, 4, 16, 179, 1, 1, '2025-02-14', 46, 1, '0', '有情有淚才能成就一條真漢子\n有情有義才能完整一個任賢齊\n\n本黑膠專輯為限量版發行，首批無限量流水號，日本字體書腰，\n180g  331/3轉，日本壓片進口，雙開封套， \n極具珍藏價值 ! 欲購從速 !', 1, '2025-06-12 13:19:20'),
(178, '偏偏我卻都記得(限量湖水藍透明膠)', '2025-06-12 11:21:41', 1480, 1, 4, 17, 180, 1, 1, '2024-12-13', 7, 1, '0', '唱作天后 艾怡良 Eve Ai \n《偏偏我卻都記得》\n  2021全創作專輯\n\n「不放過我們的，永遠都是回憶。」\n艾怡良 懺悔後的吿解\n\n唱而優則演  金曲金馬雙料肯定\n艾怡良Ｘ陳建騏  全新懺悔之作  與回憶搏鬥的過程\n\n\n艾怡良睽於2021年發表之專輯作品《偏偏我卻都記得》。回想起從2018年的《垂直活著，水平留戀著。》深獲各界肯定，〈Forever Young〉也讓艾怡良首獲最佳作曲人殊榮。\n\n2019和2020則是以不同形式跨足電影界，2019演唱施立導演的《野雀之詩》電影主題曲〈愛比死更寂寞〉令人驚艷，2020年更發表由自己出演女主角並自己創作的電影《我沒有談的那場戀愛》主題曲〈我這個人〉，再度入圍金曲獎最佳作曲人之外，演技與歌曲也雙獲金馬獎入圍肯定，同時入圍最佳新演員和最佳原創電影歌曲獎。〈我這個人〉也一舉奪下金馬獎最佳原創電影歌曲。\n\n接著，艾怡良即將再從電影女主角身份，回歸創作歌手，2021年交出全新創作專輯《偏偏我卻都記得》，包含〈我這個人〉在內的十一首歌曲，把生活裡的每個部分經過她細心的詮釋後，成為歌曲以音樂形式發表。這次的專輯依舊與熟悉的製作人－陳建騏再度聯手打造', 1, '2025-06-12 13:19:20'),
(179, '慕情', '2025-06-12 11:24:07', 1380, 1, 4, 16, 181, 1, 1, '2025-02-26', 23, 1, '0', 'ピアノの魔術師と謳われる菅野邦彦が TBM に残した唯一のリーダー作品。(TBM 主催 5 DAYS IN JAZZ コンサート録音盤)。エロール・ガーナー直系の”天才クニ”ここにあり。（シリーズ監修：塙耕記氏より）', 1, '2025-06-12 13:19:20'),
(180, '是你', '2025-06-12 11:26:25', 1280, 1, 4, 17, 182, 1, 1, '2024-12-25', 25, 1, '0', '在乎過、堅持過、沮喪過、隱藏過\n現在，我們知道，潘美辰還是我們熟悉的潘美辰\n一如她沒變的聲音、沒變的情感\n以及始終如一的溫度\n\n潘美辰（1969年6月30日—），台灣創作女歌手，以〈我想有個家〉，〈我曾用心愛著你〉等曲廣為人知，至2008年為出道滿20年之周年，發行的專輯與所獲獎項無數。才華不僅是創作，還包括樂器演奏和現場表演，除了於台灣，演藝版圖遍及中國大陸、香港、新加坡和馬來西亞等華語地區。', 1, '2025-06-12 13:19:20'),
(181, '鬥牛場上的鑽石與灰燼 (45轉)\nDiamonds and Rust in the Bullring', '2025-06-12 11:27:38', 2280, 1, 4, 17, 183, 1, 1, NULL, 26, 2, '0', '這張原始僅限量發行的小廠牌黑膠，是 Joan Baez 為數不多的珍貴現場錄音作品之一。1988 年，她在西班牙畢爾包（Bilbao）的鬥牛場演出，雖然當日天候不佳，市民卻依然熱情前來支持，也讓這場演出成為一次難以忘懷的音樂盛會。現場錄音聲音純淨，音質之佳使本專輯成為發燒友間私藏的口耳相傳之作，亞洲原盤行情不斷飆升。\n專輯中除了經典的《Diamonds and Rust》與《Famous Blue Raincoat》兩首廣為人知的名曲，Baez 也特別以西班牙語演唱多首作品，包含巴斯克語歌曲〈Txoria Txori〉，展現她對當地文化的敬意，與觀眾間溫柔的共鳴。\n由 Joan Baez 親自繪製封面插圖，阿根廷傳奇歌手 Mercedes Sosa 亦友情獻聲，堪稱一張結合音樂、文化與歷史意義的極品現場錄音。', 1, '2025-06-12 13:19:20'),
(182, '鬥牛場上的鑽石與灰燼 (33轉)\nDiamonds and Rust in the Bullring', '2025-06-12 11:27:53', 1480, 1, 4, 17, 184, 1, 1, NULL, 26, 1, '0', '這張原始僅限量發行的小廠牌黑膠，是 Joan Baez 為數不多的珍貴現場錄音作品之一。1988 年，她在西班牙畢爾包（Bilbao）的鬥牛場演出，雖然當日天候不佳，市民卻依然熱情前來支持，也讓這場演出成為一次難以忘懷的音樂盛會。現場錄音聲音純淨，音質之佳使本專輯成為發燒友間私藏的口耳相傳之作，亞洲原盤行情不斷飆升。\n專輯中除了經典的《Diamonds and Rust》與《Famous Blue Raincoat》兩首廣為人知的名曲，Baez 也特別以西班牙語演唱多首作品，包含巴斯克語歌曲〈Txoria Txori〉，展現她對當地文化的敬意，與觀眾間溫柔的共鳴。\n由 Joan Baez 親自繪製封面插圖，阿根廷傳奇歌手 Mercedes Sosa 亦友情獻聲，堪稱一張結合音樂、文化與歷史意義的極品現場錄音。', 1, '2025-06-12 13:19:20'),
(183, 'Birth Of The Blue', '2025-06-12 11:27:59', 1480, 1, 4, 16, 185, 1, 1, '2024-12-13', 26, 1, '0', 'Miles Davis《Birth of the Blue》——劃時代爵士巨作《Kind of Blue》的傳奇序章！\n這張備受矚目的專輯是劃時代作品《Kind of Blue》的前奏，收錄了與經典陣容一同錄製的四首珍稀曲目，是探索「模態爵士」誕生與演變的關鍵之作。Miles Davis 率領的創新樂團在本作中率先嘗試離經叛道的即興風格，為往後爵士樂的走向奠定了深遠基礎。\n全新 30 ips 母帶轉錄自原始 3 聲道錄音帶，經 Matthew Lutthans（The Mastering Lab）精心母帶處理，確保每一絲聲音細節都栩栩如生。180 克高品質黑膠唱片由 Quality Record Pressings 製作壓片，保證音質純淨無瑕；採用 Stoughton Printing 經典 tip-on 工藝製作的厚磅開頁封套，搭配抗刮霧面加工，外觀與音質同樣卓越。', 1, '2025-06-12 13:19:20'),
(184, '森林中的小孩\nBabes In The Wood', '2025-06-12 09:50:01', 1180, 1, 3, 13, 186, 1, 1, NULL, 59, 1, '0', '★ 瑪莉黑生涯中最精緻的一張專輯，忠實粉絲不可錯的經典！ ★ AMG（All Music Guide）音樂網站四星半高度推薦！ ★ 演繹民謠天后Joni Mitchells的經典名曲《Urge for Going》，感人至深！ 1991年發行的「森林中的小孩」是愛爾蘭民謠女歌手瑪莉黑繼1989年的經典專輯「No Frontiers」之後，再度讓樂迷留下深刻印象的一張專輯，一推出就盤據愛爾蘭排行榜的冠軍達六週之久，可見她在當地受歡迎的程度。不但銷售成績屢創新高，這張專輯在樂評之間也獲得極高的評價，普遍認為「森林中的小孩」是瑪莉黑演唱生涯中的顛峰之作。專輯由老搭檔Declan Sinnott 擔任製作人，伴奏的樂手也都是瑪莉黑的老班底，曲風格也將更多的流行元素融入以往的克爾特民謠風格中，更顯得多元與豐富。專輯中選了不少新進詞曲創作人Noel Brazil的作品，還有民謠歌手Richard Thompson的《Dimming of the Day》，最後一曲還特別選了民謠天后Joni Mitchells的《Urge for Going》，更顯得意味深長。「森林中的小孩」不但是認識這位民謠女歌', 1, '2025-06-12 13:20:00'),
(185, '美夢成真 與皇家愛樂管弦樂團\nIf I Can Dream: Elvis Presley with the Royal Philharmonic Orchestra', '2025-06-12 09:59:09', 1480, 1, 3, 12, 187, 1, 1, NULL, 2, 2, '0', '★進口黑膠典藏版\n★風靡全球的皇家愛樂管弦樂團與搖滾樂之王的劃時代跨界合作全新冠軍專輯\n★美國亞馬遜音樂銷售榜第2名，iTunes英國專輯榜第3名\n★4座葛萊美獎肯定流行樂巨星麥可布雷跨時空合唱金曲\n★義大利新世代美聲組合美聲少年虛擬和聲演唱\n\n「新專輯為貓王的十四首難忘的演唱帶來史詩般的轉折。」-People雜誌\n\n2015年是貓王80歲冥誕，貓王企業與RCA唱片公司展開系列慶祝活動，像是全新設計的官方網站www.ElvisTheMusic.com上線，自2014年12月至2016年1月間於倫敦東南區的格林威治半島上的娛樂專區O2展覽館進行歐洲史上最大型的貓王特展，貓王的1960年代系列專輯「The Complete ’60s Albums Collection Vol. 1 and Vol. 2」在iTunes上架銷售，而2015年10月底登場的專輯【If I Can Dream: Elvis Presley With The Royal Philharmonic Orchestra】也是其中的矚目焦點。  \n\n  貓王的遺孀普莉西拉普里斯萊，在聊到邀請英國著名的皇家愛樂管弦樂團，', 1, '2025-06-12 13:20:00'),
(186, '昨日重現 (7吋黑膠單曲)\nHier Encore', '2025-06-12 10:01:55', 428, 1, 3, 14, 188, 1, 1, '2015-11-17', 2, 1, '0', '◎走著復古懷舊風的法國奇情雙姝主打單曲 ◎節選自空降法國流行榜第7名+白金唱片銷售認證專輯《A Bouche Que Veux-Tu》 ◎收藏錄音室原曲，追入馬利共和國的傳統世界音樂名團BKO Quintet合作版本 (無附原文歌詞)', 1, '2025-06-12 13:20:00'),
(187, '蝴蝶\nPapillon', '2025-06-12 10:02:01', 948, 1, 3, 12, 189, 1, 1, '2015-11-17', 2, 1, '1', '內附數位下載碼+原文歌詞 ◎來自法國鄉村民謠樂界老頑童第七張專輯 ◎專輯創作靈感來自胸口紋有蝴蝶刺青，綽號Papillon的Henri Charriere逃獄經驗寫成的傳記小說「Papillon」 ◎加入小提琴、班鳩琴、大提琴、手風琴、曼陀林等樂器輔佐，增添耐人尋味的動聽誘因', 1, '2025-06-12 13:20:00'),
(188, '蔚藍海岸\nShores', '2025-06-12 10:02:06', 948, 1, 3, 14, 190, 1, 1, '2015-11-17', 2, 1, '1', '內附數位下載碼+原文歌詞 ◎來自法國的五人奇幻電音團隊首張力作 ◎送上9首英文+1首法文歌謠，充滿詩意的文藻，對外物與內在情懷觸及的瞬間，引發諸多連想空間 ◎電子加嘻哈混搭的首波主打〈The Shark〉，時唸時唱的詮釋，相當值得玩味，入選媒體的「十大獨立單曲」名單', 1, '2025-06-12 13:20:00'),
(189, '首張同名EP\nBig Grams', '2025-06-12 10:02:12', 848, 1, 3, 14, 191, 1, 1, '2015-11-17', 2, 1, '1', '內附數位下載碼+原文歌詞+180-GRAM黑膠唱片 ◎嘻哈超級大團OutKast成員Big Boi+男女獨立電子搭檔Phantogram合組實驗嘻哈電子部隊2015首張EP ◎請來超級製作/DJ 9th Wonder(Jay-Z、Destiny’s Child、De La Soul)+6座葛萊美獎得主，電音界鬼才Skrillex(Justin Bieber、Usher、Madonna)合力掌舵 ◎Killer Mike和El-P兩位黑白雙雄組成的Run The Jewel饒舌團體站台〈Born To Shine〉', 1, '2025-06-12 13:20:00'),
(190, '珍稀作品-巴布狄倫私藏錄音第12集(超值珍藏版)\nThe Cutting Edge 1965-1966: The Bootleg Series Vol.12', '2025-06-12 10:03:42', 2948, 1, 3, 12, 192, 1, 1, NULL, 2, 3, '0', '★3LP+ 2CD超值珍藏版 ★搖滾傳奇巴布狄倫 1965-1966年間未曝光錄音 珍藏史料呈現 ★包括, , 錄音音軌 ★收錄傳世名曲完整錄音室音軌紀錄', 1, '2025-06-12 13:20:00'),
(191, '活出自我\nWe Sing. We Dance. We Steal Things', '2025-06-12 10:05:47', 1480, 1, 3, 12, 193, 1, 1, '2015-06-18', 4, 2, '0', '「音樂大玩童」傑森瑪耶茲Jason Mraz，於2002年、2005年分別推出了其個人的首張專輯“Waiting For My Rocket To Come”與第二張原創大碟“Mr. A-Z”，便以他隨性的創作態度、擅長把玩文字的創意，吸引了許多跨界樂迷，當中的「The Remedy (I Won’t Worry)」、「You and I Both」、「Wordplay」等也都成為傳唱度極高的單曲，讓他展開無數場現場表演以及一連串的宣傳行程。結束行程後原本想休息一年的他，卻在稍作休息之後，奇妙地產生了源源不絕的創作靈感，並讓他在這休息的過程裡，慢慢地從自我了解到自我強化，一直到自我成長，而這些嶄新的音樂能量，自然而然地匯集結成其第三張原創專輯“活出自我（We Sing, We Dance, We Steal Things）”！\n\n“活出自我” 專輯以「Make It Mine」一曲略具戲劇化地開場，那積極的喜悅、真摯的熱情、無慮的自在，我們都感受到了；如果說，想把大自然寫成一首歌，「I`m Yours」就是最好的問候語，而Jason Mraz則會是最佳的翻譯官；至於部落格女孩Colbi', 1, '2025-06-12 13:20:00'),
(192, 'Live', '2025-06-12 10:06:14', 848, 1, 3, 12, 194, 1, 1, NULL, 1, 2, '0', '', 1, '2025-06-12 13:20:00'),
(193, 'CODA', '2025-06-12 10:06:57', 1280, 1, 3, 14, 195, 1, 1, NULL, 60, 1, '1', '', 1, '2025-06-12 13:20:00'),
(194, '歐提斯藍調：獻唱靈魂\nOtis Redding Sings Soul (Blue Vinyl)', '2025-06-12 10:08:24', 980, 1, 2, 8, 196, 1, 1, '2012-10-11', 4, 1, '1', '1967年12月因飛機失事驟逝的 Otis Redding，和 James Brown、Sam Cooke 兩位巨匠並列為靈魂樂之王，是這種音樂類型最重要的核心人物之一；他 26 年的短暫生命，卻以充滿熱情能量的歌聲和寫曲功力，讓靈魂樂也打入白人流行市場，連 Jay Z 和 Kanye West 這樣的嘻哈天王都做了一首〈Otis〉向他致敬。這張專輯原發行於 1965 年，是他的第三張錄音室專輯，翻唱了他的偶像 Sam Cooke、BB King 等人的作品，以及滾石合唱團名曲 ”Satisfaction” 等多首名曲，加入 Redding 獨特的演繹風格，成為令人難忘的一張靈魂／節奏藍調經典！', 1, '2025-06-12 13:20:00'),
(195, '彤彩 水晶膠限量紀念版', '2025-06-12 10:28:21', 1278, 1, 4, 17, 197, 1, 1, '2015-12-02', 58, 1, '0', '鳳飛飛專輯唱片──彤彩之旅 延伸了「彩虹」、飛躍過「夏艷」，鳳飛飛再度把我們帶進一片彤彩， 她獨特、圓潤地傾述期待、歡愉、黯然和離愁， 於是那些我們曾經擁有的年少夢幻、煙霞往事， 悲喜交織成光影，一時都來眼前浮動， 鳳飛飛最新作品─瀟洒的走、午夜的街頭， 音韻迴盪，引導您我尋向記憶更深處...... 瀟洒的走‧午夜的街頭‧漂泊 *美國製水晶膠片 *防灰塵及抗靜電 *紀念版限量典藏', 1, '2025-06-12 13:20:00'),
(196, '彤彩 彩膠限量紀念版', '2025-06-12 10:28:26', 1998, 1, 4, 17, 198, 1, 1, '2015-12-02', 58, 1, '0', '鳳飛飛專輯唱片──彤彩之旅 延伸了「彩虹」、飛躍過「夏艷」，鳳飛飛再度把我們帶進一片彤彩， 她獨特、圓潤地傾述期待、歡愉、黯然和離愁， 於是那些我們曾經擁有的年少夢幻、煙霞往事， 悲喜交織成光影，一時都來眼前浮動， 鳳飛飛最新作品─瀟洒的走、午夜的街頭， 音韻迴盪，引導您我尋向記憶更深處...... 瀟洒的走‧午夜的街頭‧漂泊 *美國壓製200克重盤 *高品質雙面紀念彩膠 *多幀彩頁寫真歌詞本 *獨立編號的限量珍藏 *大雙套唱片封面+側條', 1, '2025-06-12 13:20:00'),
(197, '伊斯坦堡的天空\nIstanbul Sky', '2025-06-12 10:42:27', 1678, 1, 4, 19, 199, 1, 1, NULL, 61, 1, '1', '★ 丹麥極具知名度、功力深厚的歐陸爵士小喇叭手！ ★ 結合人聲、電子、低音大提琴、吉他等豐富樂音 ★ 為您帶來充滿新鮮感、意境悠遠之發燒錄音饗宴！ ★ 音響論壇劉漢盛先生「總編私房軟體」強力推薦 ~ 2015 十一月號 326 期雜誌 德國著名錄音師兼音樂家、作曲家戴戈貝治．伯姆（Dagobert Bohm）所創辦的發燒音樂廠牌「奧塞勒 (Ozella)」，樂風近似 ECM，囊括歐陸爵士、Lounge 音樂、現代音樂等多元化的風格，在錄音上則更為 貼近音響迷的喜好，以極為精緻、發燒的音效，帶來最高傳真的體驗；這張《伊斯坦堡的天空》，由來自丹麥哥本哈根音樂學院的小喇叭手兼鍵盤樂器手古納．霍爾演出，他在其中展現了小喇叭、鍵盤樂器等深厚的功力，甚至自己獻聲演唱，乍聽之下顯得非常獨特奇異，但卻擁有深邃的旋律美感，給您前所未聞的嶄新聽覺體驗。 除了音樂本身的創新與迷人，本專輯共動用了多達十名的樂手，包括貝斯、低音大提琴、吉他、打擊樂器等等的演奏也都非常精采，無論是貝斯輕撥的細微弦振聲、 彷彿有著真實接觸感的鼓聲、令人心房顫動，血管收縮的小喇叭聲，都在在考驗著您的音響系統解析力；而各式各樣多元化的', 1, '2025-06-12 13:20:00'),
(198, '蕭士塔高維契：第二號大提琴協奏曲\nShostakovich：Cello Concerto No. 2', '2025-06-12 11:03:15', 1480, 1, 1, 2, 200, 1, 1, NULL, 62, 1, '0', '★ 法國唱片大獎推薦 ★ 德國黑膠唱片名廠 Speakers Corner 經典重刻，高品質 180g 壓片', 1, '2025-06-12 13:20:00'),
(199, '巴哈：大提琴無伴奏組曲全套 (1983年錄音)\nBach: Unaccompanied Cello Suites', '2025-06-12 11:10:47', 1680, 1, 1, 2, 201, 1, 1, '2020-11-06', 27, 3, '0', '葛萊美最佳古典演奏。\n\n巴哈的六首無伴奏大提琴組曲，是音樂史的一個奇異現象，在於他 的時代，大提琴還是項爭論中的樂器，而選擇它寫作獨奏的樂器，則更是大膽的嘗試；在他的時代或更早，有許多作曲家也曾嘗試寫過提琴家族的演奏作品，這些作 品，都在樂曲的舖陳和和聲特性上受到限制，如何展現複旋律之美，是這個時代美的準則，這就是巴哈創作此六首作品難度之所在。對於提琴家族，大提琴家尤甚， 同時驅動兩條弦以上來進行對位弦律是不可能做到的，可是，如何藉著單弦律的進行，暗示對位弦律的存在，則在巴哈的大、小提琴無伴奏組曲中明白昭示給後人。 馬友友在此六曲中的演奏，自面世以來即廣為人注目，這些他自小親近的作品，對思考空間自由的馬友友而言，尋找樂曲的啟發性是比遵守傳統溫雅風格重要得，這 也是此版之所以為人稱道之處。', 1, '2025-06-12 13:20:00'),
(200, '海邊音樂會\nThe Complete Concert by the Sea', '2025-06-12 11:11:05', 848, 1, 2, 8, 202, 1, 1, '2015-12-25', 2, 2, '0', '厄羅．加納Erroll Garner (鋼琴) 這張唱片被Allmusic選為五星經典，認為這是加納畢生錄音作品中最出色。 CD3收錄音樂會後台的採訪，紐約時報認為，在原本就被認為是加納畢生傑作的錄音中，更揭露了整場音樂會的原貌。 厄 羅加納的海邊音樂會是1956年發行的暢銷專輯，在1958年時，該專輯就已經銷售超過一百萬美金，成為知名的金唱片。這張專輯之所以名為「海邊音樂會」 是因為其錄音地點選在加州海邊的一間學校禮堂中進行。這個錄音地點其實不僅僅被厄羅加納錄音團隊相中，也是另一個當時知名的＂日落音樂會系列＂的場地，這 個系列音樂會成為日後知名的＂蒙特雷爵士音樂節＂的前身。 加納這場音樂會是採用三重奏的方式演出，除了加納的鋼琴外，還有貝斯手 Eddie Calhoun和鼓手Denzil Best。但是因為錄音的佈置方式，這張專輯整體聽來幾乎就像是只有加納的鋼琴主奏，整場錄音效果可以說不盡理想，中間的鼓掌聲也有壓扁的情形，之所以會 這樣，是因為這場音樂會本來並沒有想要灌錄下來，而是在演出時經紀人發現台下有人用錄音機錄音，詢問之後得知錄音者是一名爵士樂迷兼學者，他服役於美國陸 軍廣播電台', 1, '2025-06-12 13:20:00'),
(201, '愛慕\nAmore', '2025-06-12 11:13:53', 1580, 1, 4, 16, 203, 1, 1, '2015-11-19', 33, 2, '0', '上帝之子 永恆深情 音樂史上最磅礡的跨界天碟 肯尼吉、胡立歐、史提夫汪達、克莉絲汀、大衛佛斯特愛慕跨刀\n\n史上最暢銷古典跨界藝人重新演繹世上最動人的情歌 收錄2006冬季奧運會歌\"Because We Believe\" 以及\"Can`t Help Falling In Love\"、\"Besame Mucho\"等情歌經典\n全美流行專輯榜亞軍 空降古典跨界榜冠軍 網路專輯榜Top 3 美/加等5國白金唱片 英/澳/港/台等10國金唱片\n\n世界上只有一個嗓音可以同時詮釋流行樂的浪漫，古典樂的聖潔，歌劇的激情；他的歌聲能夠超越語言直入人心、傳達對生命的熱情，他藉由歌聲自在地將情感灌注於古典與流行音樂，他是上天賦予人類的寶藏，他是獨一無二的波伽利。 義大利歌劇與男高音前輩的傳奇點燃了波伽利對歌唱的熱情，1996-97年，與莎拉布萊曼合唱的\"Time To Say Goodbye\"沸騰他在歐陸的人氣。1999年，波伽利開始在美國樂壇攻城掠地：年初入圍葛萊美獎最佳新進藝人，成為38年來首位提名此一獎項的古典藝人，接著與席琳狄翁合唱「魔劍奇兵」主題曲\"The Prayer\"獲金球獎肯定；3月發', 1, '2025-06-12 13:20:00'),
(202, '烈愛無悔\nCurrency Of Man', '2025-06-12 11:30:00', 1480, 1, 2, 9, 204, 1, 1, '2015-11-12', 33, 2, '1', '*新世代魅爵女帝，最新烈愛無悔真我宣言….\n*21世紀時尚爵士第一人，近10年最為言之有物的全面向專輯，以爵士、藍調、節奏藍調為底蘊，透過創作及獻唱勾勒出宏觀視野的生涯里程碑…\n\n美樂蒂‧佳朵，一個集創作天賦及迷人歌聲於一身的傳奇性全方位音樂人，出道後急速竄起，以時尚璀璨之姿成為新世代魅爵女聲，完美勾勒出時尚經典的摩登況味，透過成熟洗鍊的魅力聲線無盡揮灑，席捲全世界樂迷們芳心，更是經常與諾拉‧瓊絲、戴安娜．克瑞兒等相提並論；從佳朵2006年以細膩低吟心靈灰暗角落的「悸動芳心」（Worrisome Heart）、2009年精準刻畫都會女子情緒的「為你情狂」（My One And Only Thrill）到2012年巧妙融合熱帶風情語彙的「意亂情迷」（The Absence），歷經多時醞釀、每隔三年推出的專輯都代表著她不停前進的音樂旅程及不斷蛻變的音樂思維。以世界公民自詡的佳朵，暌違樂壇三年的音樂大碟則是以她落腳於加州洛杉磯時的所聽、所見、我聞為根柢，從最基本的日常生活為起點，漸而擴及弱勢團體、種族問題、宗教爭議、環保議題、資源匱乏及戰爭禍害等均為其關心重點及研究範疇，也因此在本輯藉由最熟', 1, '2025-06-12 13:20:00'),
(203, '歡樂頌：馬友友與友人的音樂禮讚\nSongs of Joy and Peace', '2025-06-12 11:30:30', 1380, 1, 1, 2, 205, 1, 1, '2024-11-01', 27, 2, '1', '★ 收錄22首馬友友與音樂好友們的聖誕與新年感恩祝福\n★ 葛萊美最佳古典跨界專輯，美國告示排行榜Top 20\n★ 大提琴家馬友友最為暢銷專輯之一，首度黑膠唱片發行\n★ 歐陸最大經典黑膠唱片發行廠牌之一 Music On Vinyl 高品質 180g 壓片\n\n大提琴家馬友友從不將自己的風格給設限，聖誕專輯《歡樂頌：馬友友與友人的音樂禮讚》邀請許多好友音樂家前來助陣，包括 Diana Krall 、 Alison Krauss 、 James Taylor 、 Dave Brubeck 、 Chris Botti ……等，也只有馬友友的魅力能將各路人馬聚集在一塊，除了熟悉的古典樂音之外，更多了流行、爵士及世界音樂的韻味。此外，這張專輯並非只收錄一般尋常的聖誕歌曲，馬友友與好友們重新詮釋了一些平常大家都相當熟悉的經典，例如〈Here Comes the Sun〉、〈My Favorite Things〉、〈My One and Only Love〉及〈Happy Xmas (War is Over)〉，並將這些耳熟能詳的歌曲賦予新意。馬友友希望大家對於專輯裡的歌曲不會感到太陌生外，也能認識一', 1, '2025-06-12 13:20:00'),
(204, '旅行\nTravels', '2025-06-12 12:25:01', 1480, 1, 2, 10, 206, 1, 1, NULL, 63, 2, '0', '★ 兼具技巧和個性的吉他天才組團後首張現場專輯，1983年葛萊美獎最佳融合爵士演奏獎！ ★ 多重民俗音樂元素衝擊您的想像、挑戰爵士樂迷聽覺習慣，AMG四顆星高評價！ 本專輯為派特．麥席尼樂團於1982年發行的首張現場專輯，收錄他們遍佈達拉斯、費城、哈特佛等地的演出，隨時求新求變的派特．麥席尼在其中融入了巴西風格、民俗樂器、甚至是峇里島傳統音樂、虛無飄渺的吟唱等等異國元素，但也紮實地展現了精湛的吉他演奏技巧，充分展現出藝高人膽大的創意，對熟悉他的樂迷來說也是一次全新的挑戰；如今以雙黑膠完整重發，是您認識大師的不二途徑。', 1, '2025-06-12 13:20:00'),
(205, '端午節快樂', NULL, 1515, 0, 4, 16, 207, 2, 1, '2025-06-12', 66, 3, NULL, '吃可愛粽子', 1, '2025-06-12 17:03:31');

-- --------------------------------------------------------

--
-- 資料表結構 `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, '上架'),
(2, '下架'),
(3, '售出');

-- --------------------------------------------------------

--
-- 資料表結構 `sub_category`
--

CREATE TABLE `sub_category` (
  `id` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `main_category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `sub_category`
--

INSERT INTO `sub_category` (`id`, `title`, `main_category_id`) VALUES
(1, '鋼琴', 1),
(2, '大提琴', 1),
(3, '小提琴', 1),
(4, '歌劇/跨界美聲', 1),
(5, '其他類型樂器', 1),
(6, '交響樂', 1),
(7, '多重奏', 1),
(8, '男藝人', 2),
(9, '女藝人', 2),
(10, '團體/合輯', 2),
(11, '其他', 2),
(12, '男藝人', 3),
(13, '女藝人', 3),
(14, '團體/合輯', 3),
(15, '其他', 3),
(16, '男藝人', 4),
(17, '女藝人', 4),
(18, '團體/合輯', 4),
(19, '其他', 4),
(20, '男藝人', 5),
(21, '女藝人', 5),
(22, '團體/合輯', 5),
(23, '其他', 5),
(24, '華語電影/電視', 6),
(25, '日韓電影/電視', 6),
(26, '歐美電影/電視', 6),
(27, '動畫卡通', 6),
(28, '電玩配樂', 6);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `condition`
--
ALTER TABLE `condition`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `o_vinyl_id` (`o_vinyl_id`);

--
-- 資料表索引 `lp`
--
ALTER TABLE `lp`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `main_category`
--
ALTER TABLE `main_category`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `o_vinyl`
--
ALTER TABLE `o_vinyl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `main_category_id` (`main_category_id`),
  ADD KEY `sub_category_id` (`sub_category_id`),
  ADD KEY `image_id` (`image_id`),
  ADD KEY `condition_id` (`condition_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `lp_id` (`lp_id`);

--
-- 資料表索引 `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `main_category_id` (`main_category_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `condition`
--
ALTER TABLE `condition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `lp`
--
ALTER TABLE `lp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `main_category`
--
ALTER TABLE `main_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `o_vinyl`
--
ALTER TABLE `o_vinyl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`o_vinyl_id`) REFERENCES `o_vinyl` (`id`);

--
-- 資料表的限制式 `o_vinyl`
--
ALTER TABLE `o_vinyl`
  ADD CONSTRAINT `o_vinyl_ibfk_1` FOREIGN KEY (`main_category_id`) REFERENCES `main_category` (`id`),
  ADD CONSTRAINT `o_vinyl_ibfk_2` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_category` (`id`),
  ADD CONSTRAINT `o_vinyl_ibfk_3` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`),
  ADD CONSTRAINT `o_vinyl_ibfk_4` FOREIGN KEY (`condition_id`) REFERENCES `condition` (`id`),
  ADD CONSTRAINT `o_vinyl_ibfk_5` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `o_vinyl_ibfk_6` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `o_vinyl_ibfk_7` FOREIGN KEY (`lp_id`) REFERENCES `lp` (`id`);

--
-- 資料表的限制式 `sub_category`
--
ALTER TABLE `sub_category`
  ADD CONSTRAINT `sub_category_ibfk_1` FOREIGN KEY (`main_category_id`) REFERENCES `main_category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
