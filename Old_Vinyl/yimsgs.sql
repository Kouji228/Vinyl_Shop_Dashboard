-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-06-04 08:14:36
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12





SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `my_db`
--

-- --------------------------------------------------------

--
-- 資料表結構 `msgs`
--

CREATE TABLE `msgs` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `img` varchar(50) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `is_valid` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `msgs`
--

INSERT INTO `msgs` (`id`, `name`, `category_id`, `content`, `img`, `create_at`, `update_at`, `end_at`, `is_valid`) VALUES
(1, 'BEN', 1, '第一則貼文哈哈', '1748827097.jpg', '2025-05-23 16:08:50', '2025-06-02 09:18:17', NULL, 1),
(2, 'BEN BEN', 2, '第一則貼文欸', NULL, '2025-05-23 16:10:59', '2025-05-28 10:17:19', NULL, 1),
(3, 'Lauren', 1, '我願意花錢養萊萊', '1748490566.jpg', '2025-05-23 16:15:04', '2025-05-29 11:49:26', NULL, 1),
(4, 'Molly', 3, '水美沒', NULL, '2025-05-23 16:24:38', '2025-05-28 11:20:47', NULL, 1),
(6, '我是睡神', NULL, '睡了12小時', NULL, '2025-05-23 16:25:08', '2025-05-27 09:11:38', NULL, 1),
(7, '1111', 2, '111', NULL, '2025-05-23 16:25:08', '2025-06-02 10:27:06', '2025-05-27 11:14:56', 0),
(9, 'Molly', 2, '小文妹', NULL, '2025-05-23 16:26:23', '2025-05-28 10:17:51', NULL, 1),
(10, 'Molly', 1, 'ㄎ', NULL, '2025-05-26 09:26:08', '2025-05-28 10:18:02', NULL, 1),
(11, 'Molly', NULL, '111', NULL, '2025-05-26 09:31:05', NULL, NULL, 1),
(12, 'Molly', 2, '111', NULL, '2025-05-26 09:31:42', '2025-05-29 11:32:56', NULL, 1),
(13, 'Molly', NULL, '111', NULL, '2025-05-26 09:31:49', NULL, NULL, 1),
(14, 'Molly', NULL, '111', NULL, '2025-05-26 09:31:55', '2025-05-28 10:13:56', NULL, 1),
(15, '22222222', NULL, '22222222', NULL, '2025-05-26 09:39:42', NULL, NULL, 1),
(16, '22222222', NULL, '22222222', NULL, '2025-05-26 09:40:10', NULL, NULL, 1),
(17, '22222222', NULL, '22222222', NULL, '2025-05-26 09:40:33', NULL, NULL, 1),
(18, '22222222', NULL, '22222222', NULL, '2025-05-26 09:44:23', NULL, NULL, 1),
(19, 'a', NULL, '1', NULL, '2025-05-26 10:27:12', NULL, NULL, 1),
(20, 'b', NULL, '2', NULL, '2025-05-26 10:27:12', NULL, NULL, 1),
(21, 'c', NULL, '3', NULL, '2025-05-26 10:27:12', NULL, NULL, 1),
(22, 'd', NULL, '4', NULL, '2025-05-26 10:27:12', NULL, NULL, 1),
(23, 'a', NULL, '1', NULL, '2025-05-26 10:29:19', NULL, NULL, 1),
(25, 'c', NULL, '3', NULL, '2025-05-26 10:29:19', NULL, NULL, 1),
(27, 'e', NULL, '6', NULL, '2025-05-26 10:29:19', NULL, NULL, 1),
(28, 'JIAYI', 1, '不要再已讀亂回了', NULL, '2025-05-26 14:09:31', '2025-05-28 11:20:55', NULL, 1),
(29, 'JIAYI', 1, '不要SLEEP', NULL, '2025-05-26 14:12:06', '2025-05-28 11:21:02', NULL, 1),
(30, 'Lauren5告pei', 1, '使用js增加成功後的跳轉', NULL, '2025-05-26 14:16:52', '2025-05-28 11:21:08', NULL, 1),
(31, 'aBen', 1, '新增JS轉跳成功', NULL, '2025-05-26 14:17:21', '2025-05-28 11:21:14', NULL, 1),
(32, 'Molly ', 1, '漂亮又熱情的寶', NULL, '2025-05-26 15:06:22', '2025-05-28 11:21:21', NULL, 1),
(34, 'assx', 1, '哈哈哈哈&#039;', NULL, '2025-05-26 16:12:53', '2025-05-28 11:21:30', NULL, 1),
(35, 'BEN', 1, '檢查欄位', NULL, '2025-05-26 16:18:46', '2025-05-28 11:21:37', NULL, 1),
(36, 'JIAYI', NULL, '開始檢查欄位', NULL, '2025-05-26 16:18:46', NULL, NULL, 1),
(37, 'Lauren5告pei', NULL, '', NULL, '2025-05-27 09:32:21', NULL, NULL, 1),
(39, 'ben', 1, '我讀好看', NULL, '2025-05-28 09:35:39', '2025-05-28 11:21:44', NULL, 1),
(40, 'aben', NULL, '全知也好看', NULL, '2025-05-28 09:35:39', NULL, NULL, 1),
(41, 'ben', 4, '喜歡看動漫', NULL, '2025-05-28 09:37:02', '2025-05-28 11:21:51', NULL, 1),
(42, 'JIAYI', NULL, '當職帶好類類', NULL, '2025-05-28 09:37:02', '2025-05-28 09:57:42', NULL, 1),
(43, 'JIAYI1', 2, '吃水餃', NULL, '2025-05-28 11:22:29', NULL, NULL, 1),
(44, 'Lauren5告pei', 2, '吃大便', NULL, '2025-05-28 11:22:29', NULL, NULL, 1),
(45, 'Molly ', 2, '吃火鍋', NULL, '2025-05-28 11:22:29', NULL, NULL, 1),
(46, 'rae', 2, '昨天吃牛肉麵', NULL, '2025-05-28 11:25:39', NULL, NULL, 1),
(47, 'rae', 2, '今天吃牛排', NULL, '2025-05-28 11:25:39', NULL, NULL, 1),
(48, 'Lauren5告pei', 2, '今天痴痴痴痴\r\n', NULL, '2025-05-28 11:25:39', NULL, NULL, 1),
(49, 'JIAYI', 2, '部珠到吃什麼', NULL, '2025-05-28 11:25:39', NULL, NULL, 1),
(50, 'ben', 2, '吃晚餐', NULL, '2025-05-28 11:25:39', NULL, NULL, 1),
(51, 'Lauren5告pei', 3, '白 腿腿找男友日記', NULL, '2025-05-28 11:31:28', NULL, NULL, 1),
(52, 'Lauren5告pei', 3, '男友難道會從天上來', NULL, '2025-05-28 11:31:28', NULL, NULL, 1),
(53, 'Lauren5告pei', 3, '皇帝不急急死太監', NULL, '2025-05-28 11:31:28', NULL, NULL, 1),
(54, 'Lauren5告pei', 3, '好想看小白談戀愛', NULL, '2025-05-28 11:31:28', NULL, NULL, 1),
(55, 'Molly ', 3, '發達之後將我好友寵上天', NULL, '2025-05-28 11:31:28', NULL, NULL, 1),
(56, 'Molly ', 3, '生了兩個雙胞胎', NULL, '2025-05-28 11:31:28', NULL, NULL, 1),
(57, '白腿腿', 3, '腿腿尋夫記', NULL, '2025-05-28 11:33:31', NULL, NULL, 1),
(58, 'yi', 3, '千里為腿尋親記', NULL, '2025-05-28 11:43:12', NULL, NULL, 1),
(59, 'yi', 3, '28歲這年的我 參加了三位好朋友 嘉儀、阿腿、茉莉的婚禮', NULL, '2025-05-28 11:43:12', NULL, NULL, 1),
(60, 'yi', 3, ' 嘉儀、阿腿、茉莉居然都懷三胞胎', NULL, '2025-05-28 11:43:12', NULL, NULL, 1),
(61, 'JIAYI', 1, '沉默是金', '1748489271.jpg', NULL, NULL, NULL, 1),
(62, 'Lauren5告pei', 2, '胖胖胖', '1748489344.jpg', NULL, NULL, NULL, 1),
(63, 'ben', 4, '轉轉龍', NULL, NULL, NULL, NULL, 1);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `msgs`
--
ALTER TABLE `msgs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `msgs`
--
ALTER TABLE `msgs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `msgs`
--
ALTER TABLE `msgs`
  ADD CONSTRAINT `msgs_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
