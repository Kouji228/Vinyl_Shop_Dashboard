-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2025 年 06 月 12 日 11:11
-- 伺服器版本： 10.4.28-MariaDB
-- PHP 版本： 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `vinyl_shop_sql`
--

-- --------------------------------------------------------

--
-- 資料表結構 `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `weekdays` varchar(50) NOT NULL DEFAULT '1,2,3,4,5' COMMENT '營業星期，以逗號分隔，1-7代表週一到週日',
  `business_hours` varchar(100) DEFAULT NULL,
  `latitude` decimal(9,6) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否以刪除',
  `deleted_at` datetime DEFAULT NULL COMMENT '刪除時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `branch`
--

INSERT INTO `branch` (`id`, `name`, `address`, `phone`, `weekdays`, `business_hours`, `latitude`, `longitude`, `is_deleted`, `deleted_at`) VALUES
(1, '黑膠咖啡', '100台灣台北市中正區八德路一段一號華山文創園區，紅磚區西7-4館', '02-4407-1508', '1,2,3,4,5,6,7', '09:30-18:30', 25.044885, 121.528175, 0, NULL),
(2, '二手唱片販售中 二手唱片收購 二手CD收購 二手錄音帶收購 二手黑膠收購 二手腳踏車收購', '235台灣新北市中和區秀朗路三段58-2號8樓', '02-7398-4852', '1,2,3,4,5', '11:00-22:00', 24.995157, 121.525974, 1, '2025-06-11 15:58:22'),
(3, '大韜黑膠耳機專賣', '115台灣台北市南港區忠孝東路七段99號1樓', '02-5257-4254', '1,2,3,4,5', '10:00-21:00', 25.051636, 121.597994, 0, NULL),
(4, '張大韜黑膠耳機專賣', '320台灣桃園市中壢區漢口街38號', '03-7399-2428', '1,2,3,4,5', '11:00-22:00', 24.953015, 121.230886, 0, NULL),
(6, '龍鳳錄音帶唱片行', '108台灣萬華區華西街46號', '02-9997-5319', '1,2,3,4,5', '12:00-20:00', 25.036978, 121.498204, 1, '2025-06-12 11:07:34'),
(7, 'SOUL AMAZIN\' MUSIC', '11090台灣台北市信義區永吉路523號2F', '02-5831-8652', '1,2,3,4,5', '09:30-18:30', 25.045589, 121.580239, 1, '2025-06-12 09:55:12'),
(8, '三創黑膠（サンチョワンヘイジャオ）', '10491台灣台北市中正區市民大道三段2號', '02-5790-2391', '1,2,3,4,5', '10:30-19:30', 25.045261, 121.531259, 1, '2025-06-12 09:55:14'),
(10, 'THT唱片', '1樓, No. 16號復興北路427巷松山區台北市台灣 105', '02-2495-3230', '1,2,3,4,5', '09:30-18:30', 25.063272, 121.545471, 0, NULL),
(11, '燭光唱片Candlelight Records & Audio | 黑膠音響專賣店', '100台灣台北市中正區信義路二段45巷19號1樓', '02-9151-8649', '1,2,3,4,5', '10:00-21:00', 25.034925, 121.526502, 0, NULL),
(12, '小宋唱片', '1樓 No, No. 10號西園路二段225巷萬華區台北市台灣 108', '02-8904-3748', '1,2,3,4,5', '11:30-20:30', 25.026980, 121.495097, 0, NULL),
(13, '佳佳唱片 - 中華店 (Chia Chia Record - Zhonghua)', '108台灣台北市萬華區中華路一段110號2樓', '02-6828-5340', '1,2,3,4,5', '12:00-20:00', 25.043903, 121.508377, 1, '2025-06-12 09:55:26'),
(14, 'M@M RECORDS 四樓唱片行', '106台灣台北市大安區忠孝東路四段112號 4號樓之3', '02-3784-2324', '1,2,3,4,5', '10:00-21:00', 25.041364, 121.546893, 0, NULL),
(15, 'Done space', '22400台灣新北市瑞芳區基山街231號佛堂巷8號2F', '02-1719-7469', '1,2,3,4,5', '13:00-23:00', 25.106868, 121.841893, 0, NULL),
(16, '古碟工作室', '330台灣桃園市桃園區南平路110巷68號1樓', '03-5438-8292', '1,2,3,4,5', '12:00-20:00', 25.022301, 121.302118, 0, NULL),
(17, '澤龍唱片', '108台灣台北市萬華區成都路10巷15號紅樓廣場旁', '02-7920-9129', '1,2,3,4,5', '09:30-18:30', 25.041948, 121.506986, 0, NULL),
(18, '壹緣工作室 收購二手ＣＤ 黑膠 錄音帶 請先來電預約', '106台灣台北市大安區信義路三段106號', '02-1896-4923', '1,2,3,4,5', '11:30-20:30', 25.033218, 121.538412, 0, NULL),
(19, '二手回收 / 音樂CD / 黑膠 /', '234台灣新北市永和區環河東路三段56號', '02-4240-7835', '1,2,3,4,5', '10:00-21:00', 25.005944, 121.526628, 0, NULL),
(20, '希聲幻影 - 桃園 DJ教學、黑膠唱片 預約制', '330台灣桃園市桃園區成功路三段221巷3號', '03-4351-4708', '1,2,3,4,5', '10:30-19:30', 25.006543, 121.323977, 0, NULL),
(21, '駱克唱片行', '105台灣台北市松山區光復北路85巷21號1F', '02-5495-6047', '1,2,3,4,5', '09:30-18:30', 25.050627, 121.558985, 0, NULL),
(22, '【貳扌殿】 雙北、桃竹苗地區到府收購.回收（皆為官方line預約服務） ： CD 錄音帶 黑膠唱片 字畫 獎狀 獎章 文件 手稿 郵票 相機 茶葉 茶壺', '241台灣新北市三重區大同南路78巷3號收購請預約 （Line ID：@a123456789', '02-7592-5580', '1,2,3,4,5', '13:00-23:00', 25.059371, 121.496514, 0, NULL),
(23, 'Rotten Blues Records【預約制】', '100台灣台北市中正區金門街11巷3-1號', '02-3289-7991', '1,2,3,4,5', '10:00-21:00', 25.021730, 121.523715, 0, NULL),
(24, 'WillMusic微樂客(赤峰門市)', '103台灣台北市大同區赤峰街12巷5號1樓', '02-3484-3083', '1,2,3,4,5', '09:30-18:30', 25.054967, 121.519395, 0, NULL),
(25, 'Groupies Records 奮死唱片行', '320台灣桃園市中壢區中平路30號3樓', '03-3421-3375', '1,2,3,4,5', '09:30-18:30', 24.954729, 121.225413, 0, NULL),
(26, '威剛黑膠音樂博物館 ADATA Museum', '114台灣台北市內湖區潭美街533號3樓', '02-9359-3216', '1,2,3,4,5', '13:00-23:00', 25.060892, 121.599872, 0, NULL),
(27, '再生工場 永和店 二手 全新 精品3C生活用品小家電黑膠卡帶CD買賣', '234台灣新北市永和區中正路260號', '02-6559-8260', '1,2,3,4,5', '10:30-19:30', 24.998585, 121.516821, 0, NULL),
(28, '古酒閣 專業收購老酒 字畫 人蔘 古物—老酒收購|收購老酒|洋酒收購|收購洋酒|古董收購|威士忌收購|金門高梁收購|龍銀收購|古董傢俱收購/字畫收購/收購字畫', '106台灣台北市大安區永康街60號', '02-7685-5348', '1,2,3,4,5', '11:00-22:00', 25.028517, 121.529477, 0, NULL),
(29, '個體戶唱片行 indimusic records', '106台灣台北市大安區羅斯福路三段297-5號號3樓', '02-6905-7444', '1,2,3,4,5', '10:30-19:30', 25.017518, 121.531756, 0, NULL),
(30, '鯤元二手書店(收購各種書籍/漫畫/小說/童書/影音CD卡帶/DVD/黑膠唱片 有到府收書的服務)', '330台灣桃園市桃園區力行路182號', '03-1116-2309', '1,2,3,4,5', '12:00-20:00', 25.001158, 121.300901, 0, NULL),
(31, 'Black Glue Records', '106台灣台北市大安區復興南路二段332號', '02-1263-9752', '1,2,3,4,5', '10:00-21:00', 25.022891, 121.543229, 0, NULL),
(32, '【阿輝の古物】回收、收購二手唱片古物、CD、錄音帶/匣式大卡帶、黑膠唱片、遊戲片/光碟/軟膠片、卡帶、老相機、唱片機、懷舊公仔模型海報、郵票、國畫、書法字畫、文獻手稿、球卡、動漫卡、手錶、紀念幣、紀念章、紙鈔、早期書、名家畫冊等各類古董收藏', '100台灣台北市中正區杭州南路二段96號現場只收購商品， 無現場購物，歡迎尋問 (Line: @buyguwu地下一樓', '02-8033-7443', '1,2,3,4,5', '11:30-20:30', 25.029157, 121.521766, 0, NULL),
(33, '再生工場 站前店 二手 全新 精品3C生活用品小家電黑膠卡帶CD買賣', '100台灣台北市中正區許昌街12號號 2 樓', '02-4879-5602', '1,2,3,4,5', '10:00-21:00', 25.045419, 121.516828, 1, '2025-06-11 15:59:25'),
(34, '佳佳唱片 - 漢口店', '100台灣台北市中正區漢口街一段3號B1', '02-9683-7017', '1,2,3,4,5', '11:00-22:00', 25.045208, 121.514675, 0, NULL),
(35, '潮電Bar&RecordStore', '106台灣台北市大安區潮州街76號2樓', '02-6709-6736', '1,2,3,4,5', '10:00-21:00', 25.029133, 121.524193, 0, NULL),
(36, '先行一車 Senko Issha Records', '106台灣台北市大安區泰順街12號', '02-9191-8613', '1,2,3,4,5', '10:00-21:00', 25.025620, 121.531466, 0, NULL),
(37, 'Joy Audio', '100台灣台北市中正區中華路二段75巷6號', '02-8594-1127', '1,2,3,4,5', '09:30-18:30', 25.033764, 121.506221, 0, NULL),
(38, '黑皮工作室 BlacksKin Studio', '320台灣桃園市中壢區後興路一段112號', '03-4297-8231', '1,2,3,4,5', '12:00-20:00', 24.942051, 121.247338, 0, NULL),
(39, '邁阿密音樂廣場宜蘭店', '260台灣宜蘭縣宜蘭市新民路76號', '03-3660-9483', '1,2,3,4,5', '13:00-23:00', 24.756975, 121.756589, 0, NULL),
(40, '合友唱片', '100台灣台北市中正區八德路一段82巷12號', '02-8997-9252', '1,2,3,4,5', '13:00-23:00', 25.043682, 121.532081, 0, NULL),
(41, '台企行有限公司－助聽器 / Hi-End 音響 / 黑膠唱片', '10450台灣台北市中山區中山北路二段25號2樓', '02-7372-6028', '1,2,3,4,5', '12:00-20:00', 25.053112, 121.522934, 0, NULL),
(42, '95樂府', '108台灣台北市萬華區漢口街二段20巷11號', '02-4601-3490', '1,2,3,4,5', '12:00-20:00', 25.044822, 121.508027, 0, NULL),
(43, '失戀排行榜 Heartbreak Fidelity Records & Books 唱片行×獨立書店', '104110台灣台北市中山區興安街6-1號', '02-5856-8931', '1,2,3,4,5', '11:00-22:00', 25.056083, 121.537541, 0, NULL),
(44, '玫瑰大眾古典館', '100台灣台北市中正區重慶南路一段15號', '02-2985-4859', '1,2,3,4,5', '09:30-18:30', 25.045788, 121.513398, 0, NULL),
(45, '搜古苑 收購字畫 cd 黑膠唱片 （請來電預約）', '234台灣新北市永和區竹林路201巷27號', '02-5656-1065', '1,2,3,4,5', '10:00-21:00', 25.009563, 121.521926, 0, NULL),
(46, '停看聽音響有限公司', '103台灣台北市大同區重慶北路二段74號12樓', '02-4127-2623', '1,2,3,4,5', '11:30-20:30', 25.056290, 121.513675, 0, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `branch_hashtag`
--

CREATE TABLE `branch_hashtag` (
  `branch_id` int(11) NOT NULL,
  `hashtag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `branch_hashtag`
--

INSERT INTO `branch_hashtag` (`branch_id`, `hashtag_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 7),
(1, 8),
(1, 9),
(2, 1),
(2, 2),
(2, 6),
(2, 8),
(2, 9),
(3, 1),
(3, 2),
(3, 4),
(4, 1),
(4, 2),
(4, 6),
(6, 1),
(6, 2),
(6, 9),
(7, 1),
(7, 2),
(7, 5),
(7, 8),
(7, 9),
(8, 1),
(8, 2),
(8, 4),
(10, 1),
(10, 2),
(10, 6),
(11, 1),
(11, 2),
(11, 4),
(11, 6),
(11, 9),
(12, 1),
(12, 2),
(12, 3),
(12, 5),
(13, 1),
(13, 2),
(13, 9),
(14, 1),
(14, 2),
(14, 6),
(15, 1),
(15, 2),
(15, 6),
(16, 1),
(16, 2),
(16, 5),
(16, 6),
(17, 1),
(17, 2),
(17, 6),
(17, 7),
(18, 1),
(18, 2),
(18, 8),
(19, 1),
(19, 2),
(19, 5),
(20, 1),
(20, 2),
(20, 7),
(20, 8),
(21, 1),
(21, 2),
(21, 4),
(21, 8),
(22, 1),
(22, 2),
(22, 5),
(22, 6),
(22, 7),
(23, 1),
(23, 2),
(23, 8),
(24, 1),
(24, 2),
(24, 3),
(24, 5),
(25, 1),
(25, 2),
(25, 6),
(25, 7),
(25, 9),
(26, 1),
(26, 2),
(26, 7),
(26, 8),
(27, 1),
(27, 2),
(27, 3),
(27, 7),
(28, 1),
(28, 2),
(28, 7),
(28, 8),
(29, 1),
(29, 2),
(29, 9),
(30, 1),
(30, 2),
(30, 3),
(30, 7),
(30, 9),
(31, 1),
(31, 2),
(31, 5),
(31, 7),
(31, 8),
(32, 1),
(32, 2),
(32, 3),
(33, 1),
(33, 2),
(33, 7),
(34, 1),
(34, 2),
(34, 3),
(34, 9),
(35, 1),
(35, 2),
(35, 3),
(36, 1),
(36, 2),
(36, 3),
(36, 4),
(37, 1),
(37, 2),
(37, 3),
(37, 9),
(38, 1),
(38, 2),
(38, 9),
(39, 1),
(39, 2),
(39, 3),
(40, 1),
(40, 2),
(40, 4),
(41, 1),
(41, 2),
(41, 4),
(41, 8),
(42, 1),
(42, 2),
(42, 4),
(42, 7),
(43, 1),
(43, 2),
(43, 8),
(43, 9),
(44, 1),
(44, 2),
(44, 6),
(45, 1),
(45, 2),
(45, 4),
(45, 5),
(45, 9),
(46, 1),
(46, 2),
(46, 5),
(46, 6),
(46, 7);

-- --------------------------------------------------------

--
-- 資料表結構 `branch_image`
--

CREATE TABLE `branch_image` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `url` text DEFAULT NULL COMMENT '圖片URL',
  `description` text DEFAULT NULL COMMENT '圖片描述'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `branch_image`
--

INSERT INTO `branch_image` (`id`, `branch_id`, `url`, `description`) VALUES
(2, 2, 'https://images.unsplash.com/photo-1536133455524-79533bd5f4c6?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0MjR8&ixlib=rb-4.1.0&q=80&w=1080', 'This is an analogue photo (35mm format)'),
(6, 6, 'https://images.unsplash.com/photo-1591165070967-b716648a30d6?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0MzZ8&ixlib=rb-4.1.0&q=80&w=1080', 'Photo by yang miao on Unsplash'),
(7, 7, 'https://images.unsplash.com/photo-1618972676849-feed401eacc5?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0Mzl8&ixlib=rb-4.1.0&q=80&w=1080', 'Photo by Joshua Olsen on Unsplash'),
(8, 8, 'https://images.unsplash.com/photo-1530288782965-fbad40327074?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0NDJ8&ixlib=rb-4.1.0&q=80&w=1080', 'This is an analogue photograph (35mm)'),
(10, 10, 'https://images.unsplash.com/photo-1519817006514-8b677cd06028?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0NDd8&ixlib=rb-4.1.0&q=80&w=1080', 'Photo by Aleksandr Popov on Unsplash'),
(11, 11, 'https://images.unsplash.com/photo-1554995207-c18c203602cb?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0NTB8&ixlib=rb-4.1.0&q=80&w=1080', 'Our living room has been the main area we have focuses our attention on making comfortable for us. My husband got me this couch for my birthday because I have been head over heels with it. (it is the Timber sofa from Article!)\n\n@Kara_M_Eads'),
(12, 12, 'https://images.unsplash.com/photo-1541850352971-8abae7c5bf22?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0NTN8&ixlib=rb-4.1.0&q=80&w=1080', 'Windows and bricks, Kyiv, Ukraine'),
(13, 13, 'https://images.unsplash.com/photo-1618972677992-404d787eb61b?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0NTZ8&ixlib=rb-4.1.0&q=80&w=1080', 'Photo by Joshua Olsen on Unsplash'),
(14, 14, 'https://images.unsplash.com/photo-1547156979-b57c6439f9d6?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0NTh8&ixlib=rb-4.1.0&q=80&w=1080', 'Photo by Mick Haupt on Unsplash'),
(15, 15, 'https://images.unsplash.com/photo-1575475929146-b1fdf3e1ac1a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0NjF8&ixlib=rb-4.1.0&q=80&w=1080', 'Uncle Tony\'s Donut Shoppe is not a donut shop, but a record store selling unique and rare records mostly in the jazz and island traditions. A specialty store where the owner is a true connoisseur of excellent and well recorded music.'),
(16, 16, 'https://images.unsplash.com/photo-1598363943850-6fce27244c43?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0NjR8&ixlib=rb-4.1.0&q=80&w=1080', 'Record stores, I love the feel, I love the smell, I love the mood. That\'s why I keep going to record stores.'),
(17, 17, 'https://images.unsplash.com/photo-1542728143-d9b537db6433?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0NjZ8&ixlib=rb-4.1.0&q=80&w=1080', 'Photo by Oleg Ivanov on Unsplash'),
(18, 18, 'https://images.unsplash.com/photo-1469957761306-556935073eba?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0Njl8&ixlib=rb-4.1.0&q=80&w=1080', 'Photo by Clem Onojeghuo on Unsplash'),
(19, 19, 'https://images.unsplash.com/photo-1531060504220-d30bebf3daaf?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0NzJ8&ixlib=rb-4.1.0&q=80&w=1080', 'Photo by Ellicia on Unsplash'),
(20, 20, 'https://images.unsplash.com/photo-1580537659053-7d38f300118c?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0NzV8&ixlib=rb-4.1.0&q=80&w=1080', 'Photo by Shunya Koide on Unsplash'),
(21, 21, 'https://images.unsplash.com/photo-1513506003901-1e6a229e2d15?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0Nzh8&ixlib=rb-4.1.0&q=80&w=1080', 'Lamp'),
(22, 22, 'https://images.unsplash.com/photo-1533090161767-e6ffed986c88?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0ODB8&ixlib=rb-4.1.0&q=80&w=1080', 'My Bedroom-Simplicity'),
(23, 23, 'https://images.unsplash.com/photo-1662037919894-2e78305484a8?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0ODN8&ixlib=rb-4.1.0&q=80&w=1080', 'the continuing journey to go to every record store in America with an amazing one in Missoula, Montana.'),
(24, 24, 'https://images.unsplash.com/photo-1462392246754-28dfa2df8e6b?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0ODV8&ixlib=rb-4.1.0&q=80&w=1080', 'Philadelphia retail space'),
(25, 25, 'https://images.unsplash.com/photo-1505476159322-eb48eb0a16b3?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0ODh8&ixlib=rb-4.1.0&q=80&w=1080', 'Bike by Yellow Wall'),
(26, 26, 'https://images.unsplash.com/photo-1505476159322-eb48eb0a16b3?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0OTF8&ixlib=rb-4.1.0&q=80&w=1080', 'Bike by Yellow Wall'),
(27, 27, 'https://images.unsplash.com/photo-1644552795664-1225befff5e2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0OTN8&ixlib=rb-4.1.0&q=80&w=1080', 'A periodic visit to one of my local record stores in Orlando.'),
(28, 28, 'https://images.unsplash.com/photo-1521566652839-697aa473761a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0OTZ8&ixlib=rb-4.1.0&q=80&w=1080', 'Picture taken for CouponSnake – https://couponsnake.com/'),
(29, 29, 'https://images.unsplash.com/photo-1477901492169-d59e6428fc90?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0OTl8&ixlib=rb-4.1.0&q=80&w=1080', 'Towels and clothes on lines'),
(30, 30, 'https://images.unsplash.com/photo-1519677584237-752f8853252e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc1MDF8&ixlib=rb-4.1.0&q=80&w=1080', 'Photo by Manuel Sardo on Unsplash'),
(31, 31, 'https://images.unsplash.com/photo-1461920607259-76ea048d89a2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc1MDR8&ixlib=rb-4.1.0&q=80&w=1080', 'Photo by Christoph Peich on Unsplash'),
(32, 32, 'https://images.unsplash.com/photo-1524946828034-689bba16b33c?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc1MDd8&ixlib=rb-4.1.0&q=80&w=1080', 'In the comfort of one’s own home'),
(33, 33, 'https://images.unsplash.com/photo-1541964004267-562546128275?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc1MTB8&ixlib=rb-4.1.0&q=80&w=1080', 'straight lines'),
(34, 34, 'https://images.unsplash.com/photo-1455997299803-0c4649ca02fa?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc1MTJ8&ixlib=rb-4.1.0&q=80&w=1080', 'monochrome amp'),
(35, 35, 'https://images.unsplash.com/photo-1520699049698-acd2fccb8cc8?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc1MTV8&ixlib=rb-4.1.0&q=80&w=1080', 'Lobby'),
(36, 36, 'https://images.unsplash.com/photo-1482287068671-7fb7325e1a8d?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc1MTh8&ixlib=rb-4.1.0&q=80&w=1080', 'Taxi car in an urban area of Tsim Sha Tsui'),
(37, 37, 'https://images.unsplash.com/photo-1508161887025-ebd8f2813550?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc1MjF8&ixlib=rb-4.1.0&q=80&w=1080', 'Advntr'),
(38, 38, 'https://images.unsplash.com/photo-1575488005954-3a287695b242?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc1MjN8&ixlib=rb-4.1.0&q=80&w=1080', 'Uncle Tony\'s Donut Shoppe is not a donut shop, but a record store selling unique and rare records mostly in the jazz and island traditions. A specialty store where the owner is a true connoisseur of excellent and well recorded music.'),
(39, 39, 'https://images.unsplash.com/photo-1517525199627-749c3d2683d6?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc1MjZ8&ixlib=rb-4.1.0&q=80&w=1080', 'just my favourite shop in town'),
(40, 40, 'https://images.unsplash.com/photo-1605774337664-7a846e9cdf17?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc1Mjl8&ixlib=rb-4.1.0&q=80&w=1080', 'Nordic scandi home and living room'),
(41, 41, 'https://images.unsplash.com/photo-1554222725-5cd0bf9c6da9?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc1MzF8&ixlib=rb-4.1.0&q=80&w=1080', 'Photo by Mick Haupt on Unsplash'),
(42, 42, 'https://images.unsplash.com/photo-1598363943803-54a01af6fec1?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc1MzR8&ixlib=rb-4.1.0&q=80&w=1080', 'Record stores, I love the feel, I love the smell, I love the mood. That\'s why I keep going to record stores.'),
(43, 43, 'https://images.unsplash.com/flagged/photo-1558706379-e9698f05d675?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc1MzZ8&ixlib=rb-4.1.0&q=80&w=1080', 'Custom build with 100% unmodified Lego elements'),
(44, 44, 'https://images.unsplash.com/photo-1737638517473-0ddea9d85c98?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc1Mzl8&ixlib=rb-4.1.0&q=80&w=1080', 'Photo by Dominic Kurniawan Suryaputra on Unsplash'),
(45, 45, 'https://images.unsplash.com/photo-1558125986-abf7f3428420?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc1NDJ8&ixlib=rb-4.1.0&q=80&w=1080', 'Photo by Chloe Evans on Unsplash'),
(46, 46, 'https://images.unsplash.com/photo-1594991523303-a54f2722dc3c?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc1NDR8&ixlib=rb-4.1.0&q=80&w=1080', 'Photo by Tim Foster on Unsplash'),
(55, 3, 'https://images.unsplash.com/photo-1497366216548-37526070297c?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0Mjd8&ixlib=rb-4.1.0&q=80&w=1080', 'Photo by Nastuh Abootalebi on Unsplash'),
(56, 4, 'https://images.unsplash.com/photo-1502773860571-211a597d6e4b?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3NTg5MjV8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NDg5Njc0MzB8&ixlib=rb-4.1.0&q=80&w=1080', 'Elvis in a record store'),
(68, 1, '/vinyl_shop/img/684a9851d8c28.jpg', 'photo of shop'),
(69, 1, '/vinyl_shop/img/684a985654a8a.jpg', 'photo of shop'),
(70, 1, '/vinyl_shop/img/684a985b16a1f.jpg', 'photo of shop');

-- --------------------------------------------------------

--
-- 資料表結構 `hashtag`
--

CREATE TABLE `hashtag` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `hashtag`
--

INSERT INTO `hashtag` (`id`, `name`) VALUES
(1, '新品黑膠販售'),
(2, '二手黑膠販售'),
(3, '黑膠機器販售'),
(4, '黑膠機器維修'),
(5, '二手黑膠收購'),
(6, '定期優惠活動'),
(7, '展演空間'),
(8, '黑膠清洗服務'),
(9, '黑膠現場試聽');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `branch_hashtag`
--
ALTER TABLE `branch_hashtag`
  ADD PRIMARY KEY (`branch_id`,`hashtag_id`),
  ADD KEY `hashtag_id` (`hashtag_id`);

--
-- 資料表索引 `branch_image`
--
ALTER TABLE `branch_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- 資料表索引 `hashtag`
--
ALTER TABLE `hashtag`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `branch_image`
--
ALTER TABLE `branch_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `hashtag`
--
ALTER TABLE `hashtag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `branch_hashtag`
--
ALTER TABLE `branch_hashtag`
  ADD CONSTRAINT `branch_hashtag_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  ADD CONSTRAINT `branch_hashtag_ibfk_2` FOREIGN KEY (`hashtag_id`) REFERENCES `hashtag` (`id`);

--
-- 資料表的限制式 `branch_image`
--
ALTER TABLE `branch_image`
  ADD CONSTRAINT `branch_image_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
