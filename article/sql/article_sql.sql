-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2025 年 06 月 11 日 06:34
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
-- 資料庫： `article_sql`
--

-- --------------------------------------------------------

--
-- 資料表結構 `articles`
--
-- 讀取資料表 article_sql.articles 的結構時出現錯誤： #1142 - SHOW command denied to user &#039;&#039;@&#039;localhost&#039; for table `article_sql`.`articles`
-- 讀取資料表 article_sql.articles 的資料時出現錯誤： #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `article_sql`.`articles`&#039; at line 1

-- --------------------------------------------------------

--
-- 資料表結構 `article_category`
--
-- 讀取資料表 article_sql.article_category 的結構時出現錯誤： #1142 - SHOW command denied to user &#039;&#039;@&#039;localhost&#039; for table `article_sql`.`article_category`
-- 讀取資料表 article_sql.article_category 的資料時出現錯誤： #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `article_sql`.`article_category`&#039; at line 1

-- --------------------------------------------------------

--
-- 資料表結構 `article_images`
--
-- 讀取資料表 article_sql.article_images 的結構時出現錯誤： #1142 - SHOW command denied to user &#039;&#039;@&#039;localhost&#039; for table `article_sql`.`article_images`
-- 讀取資料表 article_sql.article_images 的資料時出現錯誤： #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `article_sql`.`article_images`&#039; at line 1

-- --------------------------------------------------------

--
-- 資料表結構 `article_statuses`
--
-- 讀取資料表 article_sql.article_statuses 的結構時出現錯誤： #1142 - SHOW command denied to user &#039;&#039;@&#039;localhost&#039; for table `article_sql`.`article_statuses`
-- 讀取資料表 article_sql.article_statuses 的資料時出現錯誤： #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `article_sql`.`article_statuses`&#039; at line 1

-- --------------------------------------------------------

--
-- 資料表結構 `article_tag`
--
-- 讀取資料表 article_sql.article_tag 的結構時出現錯誤： #1142 - SHOW command denied to user &#039;&#039;@&#039;localhost&#039; for table `article_sql`.`article_tag`
-- 讀取資料表 article_sql.article_tag 的資料時出現錯誤： #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `article_sql`.`article_tag`&#039; at line 1

-- --------------------------------------------------------

--
-- 資料表結構 `article_views`
--
-- 讀取資料表 article_sql.article_views 的結構時出現錯誤： #1142 - SHOW command denied to user &#039;&#039;@&#039;localhost&#039; for table `article_sql`.`article_views`
-- 讀取資料表 article_sql.article_views 的資料時出現錯誤： #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `article_sql`.`article_views`&#039; at line 1

-- --------------------------------------------------------

--
-- 資料表結構 `categories`
--
-- 讀取資料表 article_sql.categories 的結構時出現錯誤： #1142 - SHOW command denied to user &#039;&#039;@&#039;localhost&#039; for table `article_sql`.`categories`
-- 讀取資料表 article_sql.categories 的資料時出現錯誤： #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `article_sql`.`categories`&#039; at line 1

-- --------------------------------------------------------

--
-- 資料表結構 `tags`
--
-- 讀取資料表 article_sql.tags 的結構時出現錯誤： #1142 - SHOW command denied to user &#039;&#039;@&#039;localhost&#039; for table `article_sql`.`tags`
-- 讀取資料表 article_sql.tags 的資料時出現錯誤： #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `article_sql`.`tags`&#039; at line 1
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
