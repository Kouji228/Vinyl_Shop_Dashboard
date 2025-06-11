CREATE TABLE `o_vinyl` (
   `id` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
   `name` VARCHAR(100)  NOT NULL,
   `listing_date` DATETIME,
   `price` INT  NOT NULL, 
   `stock` INT  NOT NULL DEFAULT 1,
   `main_category_id` INT  NOT NULL,
   `sub_category_id` INT,
   `image_id` INT,
   `condition_id` INT,
   `status_id` INT,
   `release_date` DATE,
   `company_id` INT,
   `lp_id` INT,
   `list` TEXT,
   `desc` VARCHAR(500),
   `is_valid` INT  NOT NULL DEFAULT 1,
    FOREIGN KEY (`main_category_id`) REFERENCES `main_category`(`id`),
   FOREIGN KEY (`sub_category_id`) REFERENCES `sub_category`(`id`),
   FOREIGN KEY (`image_id`) REFERENCES `images`(`id`),
   FOREIGN KEY (`condition_id`) REFERENCES `condition`(`id`),
   FOREIGN KEY (`status_id`) REFERENCES `status`(`id`),
   FOREIGN KEY (`company_id`) REFERENCES `company`(`id`),
   FOREIGN KEY (`lp_id`) REFERENCES `lp`(`id`)
);
ALTER TABLE `o_vinyl` DROP COLUMN `introduction_content`;
drop TABLE `o_vinyl`;
CREATE DATABASE `yi`;
use`yi`;

ALTER TABLE `o_vinyl` 

CREATE TABLE `company` (
   `id` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
   `name` VARCHAR(50) 
);

CREATE TABLE `lp` (
   `id` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
   `size` VARCHAR(20)
);

CREATE TABLE `main_category` (
   `id` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
   `title` VARCHAR(20) NOT NULL, 
   `main_category_id` INT
);

CREATE TABLE `sub_category` (
   `id` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
   `title` VARCHAR(20) NOT NULL,
   `main_category_id` INT,
   FOREIGN KEY (`main_category_id`) REFERENCES `main_category`(`id`)
);

CREATE TABLE `condition` (
   `id` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
   `name` VARCHAR(20) NOT NULL
);

CREATE TABLE `status` (
   `id` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
   `name` VARCHAR(20) NOT NULL
);

CREATE TABLE `images` (
   `id` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
   `url` VARCHAR(200),
   `o_vinyl_id` INT,
    FOREIGN KEY (`o_vinyl_id`) REFERENCES `o_vinyl`(`id`)
);


SET FOREIGN_KEY_CHECKS = 0;
SET FOREIGN_KEY_CHECKS = 1;


-- =============================================================================
-- 簡化版資料庫結構建立 SQL（商品狀況和狀態作為管理功能）
-- =============================================================================
DROP TABLE `sub_category` ;
-- 1. 主分類資料表
INSERT INTO main_category (id, title) VALUES 
(1, '古典'),
(2, '爵士'),
(3, '西洋'),
(4, '華語'),
(5, '日韓'),
(6, '原聲帶');

-- 2. 子分類資料表
-- 古典音樂的子分類 (1-7)
TRUNCATE TABLE sub_category;

INSERT INTO sub_category (id, title, main_category_id) VALUES 
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

-- 3. LP規格資料表
DROP TABLE lp;
INSERT INTO lp (id, size) VALUES 
(1, '1LP'),
(2, '2LP'),
(3, '3LP'),
(4, '4LP'),
(5, '5LP以上');
INSERT INTO lp (id, size) VALUES 
(2, '2LP'),
(3, '3LP'),
(4, '4LP'),
(5, '5LP以上');
SELECT * FROM lp ORDER BY id;



-- 4. 商品狀況資料表（後台管理用，爬蟲預設使用 id=1 全新）
INSERT INTO `condition` (id, name) VALUES 
(1, 'Mint'),
(2, 'Near Mint'),
(3, 'Excellent'),
(4, 'Very Good'),
(5, 'Good');

-- 5. 商品狀態資料表（後台管理用，爬蟲預設使用 id=1 上架）
INSERT INTO `status` (id, name) VALUES 
(1, '上架'),
(2, '下架'),
(3, '售出');

-- 6. 初始公司資料（爬蟲會自動新增未知的公司）
INSERT INTO company (id, name) VALUES 
(1, '未知'),
(2, 'Sony Music'),
(3, 'Universal Music'),
(4, 'Warner Music'),
(5, '滾石唱片'),
(6, '相信音樂');

-- =============================================================================
-- 爬蟲重點欄位說明
-- =============================================================================

/*
爬蟲會自動填入的欄位：
- name: 專輯名稱
- price: 價格（從網站提取數字）
- main_category_id: 主分類ID（根據音樂類型自動判斷）
- sub_category_id: 子分類ID（根據主分類和性別自動判斷）
- lp_id: LP規格ID（根據專輯規格自動判斷）
- company_id: 公司ID（自動查找或新增）
- release_date: 發行日期（從網站解析）
- introduction_content: 完整描述內容
- list: 曲目列表
- desc: 簡短描述（截取前500字）
- image_url: 產品圖片連結

固定值（不需要爬取）：
- condition_id: 固定為 1（全新）
- status_id: 固定為 1（上架）
- stock: 固定為 1
- listing_date: 爬取時間
- is_valid: 固定為 1（有效）
*/

-- =============================================================================
-- 查詢分類對照表（供開發參考）
-- =============================================================================

-- 查看完整的分類結構
SELECT 
    mc.id as main_id,
    mc.title as main_category,
    sc.id as sub_id,
    sc.title as sub_category
FROM main_category mc
LEFT JOIN sub_category sc ON mc.id = sc.main_category_id
ORDER BY mc.id, sc.id;

-- 查看爬蟲會產生的資料欄位
SELECT 
    COLUMN_NAME,
    DATA_TYPE,
    IS_NULLABLE,
    COLUMN_DEFAULT,
    COLUMN_COMMENT
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'o_vinyl'
ORDER BY ORDINAL_POSITION;

SELECT * FROM o_vinyl;

UPDATE o_vinyl
SET `condition_id` = 4,
      `status_id` = 1,
      `stock` = 0
WHERE id = 8;
UPDATE o_vinyl
SET `condition_id` = 2,
      `status_id` = 3,
      `stock` = 3
WHERE id = 9;
alter table o_vinyl add creatTime datetime not null default  current_timestamp;
SELECT * FROM company ;

SELECT * FROM main_category ;