-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-06-04 08:14:37
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
  `created_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `is_valid` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `msgs`
--

INSERT INTO `msgs` (`id`, `name`, `category_id`, `content`, `img`, `created_at`, `update_at`, `end_at`, `is_valid`) VALUES
(1, 'BEN', 1, '第一則貼文', '1748834611.jpeg', '2025-05-23 16:09:10', '2025-06-02 14:59:04', NULL, 1),
(2, 'Josh', 1, '66666', NULL, '2025-05-23 16:26:02', '2025-06-02 11:02:16', NULL, 1),
(3, 'BEN', 3, '轉圈圈的龍', NULL, '2025-05-26 09:13:25', '2025-05-28 10:17:44', NULL, 1),
(4, 'BEN', 1, '轉圈圈的龍好好玩', NULL, '2025-05-26 09:17:43', '2025-06-02 11:02:08', NULL, 1),
(5, 'aaa', 1, '今天想睡覺', NULL, '2025-05-26 09:18:15', '2025-05-28 10:17:56', NULL, 1),
(6, 'aANNA', 1, '預處理器的寫法2', NULL, '2025-05-26 09:24:18', '2025-05-28 10:18:01', NULL, 1),
(7, 'Josh', NULL, '預處理器的寫法3', NULL, '2025-05-26 09:29:55', NULL, NULL, 1),
(8, 'aBEN', 1, '測試測試', NULL, '2025-05-26 09:39:49', '2025-05-28 10:18:07', NULL, 1),
(9, 'anna', 4, '測試', NULL, '2025-05-27 10:37:38', '2025-05-28 10:19:19', NULL, 1),
(10, 'Avv', 1, '0526下大雨', NULL, '2025-05-26 10:30:08', '2025-06-02 11:02:36', NULL, 1),
(11, 'Ben', NULL, '今天不想上課', NULL, '2025-05-26 10:30:08', NULL, NULL, 1),
(12, 'Avv', NULL, '討厭下雨', NULL, '2025-05-26 10:30:08', NULL, NULL, 1),
(13, 'Array', 2, '想吃大餐', NULL, '2025-05-26 10:52:46', '2025-06-02 11:39:26', NULL, 1),
(14, 'aANNA', 2, '想吃巧克力', NULL, '2025-05-26 14:15:28', '2025-05-28 10:18:41', NULL, 1),
(15, '蔡依林', 2, '大餐真好吃', NULL, '2025-05-26 14:15:30', '2025-05-28 10:18:51', NULL, 1),
(16, 'aBen', 3, '使用js做增加成功後的轉跳', NULL, '2025-05-26 14:17:03', '2025-05-28 10:18:59', NULL, 1),
(17, 'Ben', NULL, '我要玩遊戲', NULL, NULL, '2025-05-28 09:50:47', NULL, 1),
(20, 'aBen', NULL, '123', NULL, NULL, NULL, '2025-05-27 11:15:28', 0),
(21, '', NULL, '', NULL, NULL, NULL, '2025-05-27 11:55:18', 1),
(22, '', NULL, '', NULL, NULL, NULL, '2025-05-28 09:28:51', 1),
(23, '', NULL, '', NULL, NULL, NULL, '2025-05-28 09:28:48', 1),
(24, '', NULL, '', NULL, NULL, NULL, '2025-05-28 09:30:48', 1),
(25, '', NULL, '', NULL, NULL, NULL, '2025-05-28 09:30:51', 1),
(26, '', NULL, '', NULL, NULL, NULL, '2025-05-28 09:30:54', 1),
(27, 'aBen', 4, '我獨很好看', NULL, NULL, NULL, NULL, 1),
(28, 'Ben', 1, '今天天氣很好', NULL, NULL, NULL, NULL, 1),
(29, 'aBen', 2, '想吃雞排', NULL, NULL, NULL, NULL, 1),
(30, 'aBen', 1, '今天心情好', NULL, NULL, '2025-06-02 10:36:31', NULL, 1),
(31, 'Ben', 1, '今天心情非常好', NULL, NULL, NULL, NULL, 1),
(32, 'Ben', 1, '沒辦法儲值 好生氣', NULL, NULL, NULL, NULL, 1),
(33, 'Ben', 1, '今天真棒', NULL, NULL, NULL, NULL, 1),
(34, 'aBen', 1, '今天下雨', '1748489268.jpeg', NULL, NULL, NULL, 1),
(35, 'aBen', 1, '狗狗好可愛', '1748489414.jpeg', NULL, '2025-06-02 09:20:58', NULL, 1),
(36, 'Ben', 1, '蔡依林有新歌真好聽', NULL, NULL, '2025-05-29 11:38:11', NULL, 1),
(37, 'Anna', 1, '好想出國玩', '1748490542.jpg', NULL, '2025-05-29 11:50:05', NULL, 1),
(38, 'aBen', 4, '動漫真好看', NULL, NULL, NULL, NULL, 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

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
