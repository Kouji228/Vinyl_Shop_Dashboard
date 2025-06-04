-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-06-04 08:14:40
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
  `createTime` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `is_valid` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `msgs`
--

INSERT INTO `msgs` (`id`, `name`, `category_id`, `content`, `img`, `createTime`, `update_at`, `end_at`, `is_valid`) VALUES
(1, 'BEN', 1, '第一則貼文哈哈', '1748834372.jpg', '2025-05-23 16:08:52', '2025-06-02 11:19:32', NULL, 1),
(2, 'BEN', 1, '順利儲值了哈哈', NULL, '2025-05-23 16:11:35', '2025-05-28 10:16:51', NULL, 0),
(3, 'Mary', NULL, '今天下雨天哈哈', NULL, '2025-05-23 16:14:18', '2025-05-26 16:02:20', '2025-05-27 11:14:55', 1),
(4, 'BEN', 1, '轉轉轉哈哈', NULL, '2025-05-23 16:24:55', '2025-05-28 10:16:56', NULL, 0),
(8, 'asd', NULL, '今天下大雨', NULL, '2025-05-26 09:17:58', NULL, '2025-05-27 11:15:06', 1),
(9, 'qwe', 3, '預處理器的寫法2', NULL, '2025-05-26 09:24:24', '2025-05-28 10:17:03', NULL, 1),
(10, 'qwer', 3, '預處理器的寫法2-02', NULL, '2025-05-26 09:26:21', '2025-05-28 10:17:08', NULL, 1),
(11, 'zxc', 3, '預處理器的寫法 3', NULL, '2025-05-26 09:29:49', '2025-05-28 10:17:15', NULL, 1),
(12, 'Ben', 1, '沒有淋到雨', NULL, '2025-05-26 10:28:47', '2025-05-28 10:17:38', NULL, 1),
(13, 'faker', 4, '預處理器的寫法+複數的插入', NULL, '2025-05-26 10:28:47', '2025-05-28 10:17:44', NULL, 1),
(15, 'doro', 2, '現在要寫成功自動導頁', NULL, '2025-05-26 14:09:28', '2025-05-28 10:17:49', NULL, 1),
(16, 'doro', 1, '導頁前加sleep', NULL, '2025-05-26 14:10:48', '2025-05-28 10:17:56', NULL, 1),
(17, 'oner', 1, '使用 js 作增加成功後的轉跳', NULL, '2025-05-26 14:17:11', '2025-05-28 10:18:02', NULL, 1),
(18, 'chovy', 3, '增加修改頁面', NULL, '2025-05-26 15:02:51', '2025-05-28 10:18:07', NULL, 1),
(19, 'Ben', 1, '開始檢查欄位', NULL, '2025-05-26 16:18:56', '2025-05-28 10:18:12', NULL, 1),
(20, 'Ken', 2, '用最簡單的語句撰寫檢查欄位', NULL, '2025-05-26 16:18:56', '2025-05-28 10:18:18', NULL, 1),
(24, 'will', 4, '飯菜', NULL, '2025-05-28 09:35:47', NULL, NULL, 1),
(25, 'awill', 3, '刀劍', NULL, '2025-05-28 09:35:47', NULL, NULL, 1),
(26, 'will', 4, '黑人採棉花', NULL, '2025-05-28 09:37:34', NULL, NULL, 1),
(27, 'jakey', 2, '白吐司', NULL, '2025-05-28 09:37:34', NULL, NULL, 1),
(28, 'miky', 1, '藍天白雲', NULL, '2025-05-28 09:39:04', '2025-05-28 10:02:07', NULL, 1),
(29, 'andy', 1, '被騙錢', NULL, '2025-05-28 10:13:21', NULL, NULL, 1),
(30, 'ann', 1, '騙錢好爽', NULL, '2025-05-28 10:13:21', NULL, NULL, 1),
(31, 'kelly', 2, '紅紅火火恍恍惚惚', NULL, '2025-05-28 10:21:33', NULL, NULL, 1),
(32, 'moni', 2, '炭烤雞排', NULL, '2025-05-28 10:21:33', NULL, NULL, 1),
(33, 'bom', 3, '法環', NULL, '2025-05-28 10:21:33', NULL, NULL, 1),
(34, 'haddy', 3, '黑魂', NULL, '2025-05-28 10:21:33', NULL, NULL, 1),
(35, 'ken', 1, '天氣不錯', NULL, '2025-05-28 10:24:11', NULL, NULL, 1),
(36, 'anne', 2, '晚餐吃白飯', NULL, '2025-05-28 10:24:11', NULL, NULL, 1),
(37, 'span123', 2, '機油好難喝', NULL, '2025-05-28 10:24:11', NULL, NULL, 1),
(38, 'micky', 4, '東卍超難看', NULL, '2025-05-28 10:24:11', NULL, NULL, 1),
(39, 'haha', 1, '安安', NULL, '2025-05-28 10:54:53', NULL, NULL, 1),
(40, 'fork', 4, '夏日口袋', NULL, '2025-05-28 11:01:04', NULL, NULL, 1),
(41, 'tom', 4, '成神之日', NULL, '2025-05-28 11:01:27', '2025-05-28 11:01:44', NULL, 1),
(42, 'ken', 2, '豬排', NULL, '2025-05-28 11:21:11', NULL, NULL, 1),
(43, 'ken', 2, '牛排', NULL, '2025-05-28 11:21:11', NULL, NULL, 1),
(44, 'ken', 2, '雞排', NULL, '2025-05-28 11:21:11', NULL, NULL, 1),
(45, 'ken', 2, '奶茶', NULL, '2025-05-28 11:21:11', NULL, NULL, 1),
(46, 'doro', 3, '哈利波特', NULL, '2025-05-28 11:23:31', '2025-05-28 14:59:58', NULL, 1),
(47, 'daivd', 3, '大小鬼', NULL, '2025-05-28 11:23:31', NULL, NULL, 1),
(48, 'daivd', 3, '深影', NULL, '2025-05-28 11:23:31', NULL, NULL, 1),
(49, 'doro', 4, '買橘子', NULL, '2025-05-28 11:25:45', NULL, NULL, 1),
(50, 'doro', 4, '一個人', NULL, '2025-05-28 11:25:45', NULL, NULL, 1),
(51, 'doro', 4, '人回來了', NULL, '2025-05-28 11:25:45', NULL, NULL, 1),
(52, 'doro', 4, '買下橘子園', NULL, '2025-05-28 11:25:45', NULL, NULL, 1),
(53, 'doro', 1, 'test1', NULL, '2025-05-28 11:30:59', '2025-05-28 14:59:22', NULL, 1),
(54, 'doro', 2, 'test1', NULL, '2025-05-28 11:30:59', '2025-05-28 14:59:28', NULL, 1),
(55, 'doro', 3, 'test1test1', NULL, '2025-05-28 11:30:59', '2025-05-28 14:59:34', NULL, 1),
(56, 'doro', 4, 'test1', NULL, '2025-05-28 11:30:59', '2025-05-28 14:59:41', NULL, 1),
(57, 'jojo', 4, 'jo7', NULL, '2025-05-28 13:34:39', NULL, '2025-05-28 16:21:40', 1),
(58, 'doro', 1, '咚咚咚', '1748489000.jpeg', '2025-05-29 11:23:20', NULL, NULL, 1),
(59, 'doro', 1, '洞洞洞', '1748489053.jpeg', '2025-05-29 11:24:13', NULL, NULL, 1),
(60, 'doro', 3, '嘟嘟嘟', '1748489054.jpeg', '2025-05-29 11:24:13', NULL, NULL, 1),
(61, 'doro', 3, '沒圖片的', NULL, '2025-05-29 11:29:37', NULL, NULL, 1),
(62, 'dororeal', 2, '有圖片的', '1748489378.jpeg', '2025-05-29 11:29:37', NULL, NULL, 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

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
