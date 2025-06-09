-- Active: 1748939659871@@127.0.0.1@3306@my_st
-- 優惠券主表
CREATE TABLE `coupons` (
    `id` INT PRIMARY KEY AUTO_INCREMENT COMMENT '優惠券ID',
    `name` VARCHAR(255) NOT NULL COMMENT '優惠券名稱',
    `code` VARCHAR(50) UNIQUE COMMENT '使用者輸入的優惠碼，可選',
    `content` TEXT COMMENT '優惠券說明',
    `start_at` TIMESTAMP NULL COMMENT '開始時間',
    `end_at` TIMESTAMP NULL COMMENT '結束時間',
    `status` VARCHAR(20) NOT NULL DEFAULT 'pending' COMMENT '狀態：active(生效中) | inactive(已停用) | pending(待上架)',
    `total_quantity` INT NOT NULL DEFAULT 1 COMMENT '此種優惠券的總發放「張數」',
    `per_user_limit` INT NOT NULL DEFAULT 1 COMMENT '每位用戶可領取此種券的「張數」上限',
    `uses_per_instance` INT NOT NULL DEFAULT 1 COMMENT '【核心】每張領取的券(實例)可使用的總次數',
    `is_valid` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '軟刪除標記 (1:有效, 0:已刪除)',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '建立時間',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間'
) COMMENT = '優惠券的核心定義，一張券可被使用多次，其規則定義在 coupon_rules';

-- 優惠條件設定表
CREATE TABLE `coupon_rules` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `coupon_id` INT NOT NULL COMMENT '關聯優惠券',
    `min_spend` INT COMMENT '最低消費門檻 (分 / 或整數的元)',
    `discount_type` VARCHAR(20) COMMENT 'fixed(固定金額) | percent(百分比)',
    `discount_value` INT COMMENT '折扣金額(元/分)或百分比(例:90代表9折)',
    `max_discount_amount` INT COMMENT '百分比折扣的最高折抵金額上限 (分 / 或整數的元)',
    `free_shipping` BOOLEAN DEFAULT FALSE COMMENT '是否免運費',
    `is_valid` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '軟刪除標記 (1:有效, 0:已刪除)',
    FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) COMMENT = '定義優惠券如何折扣，一張券可有多重規則 (例如 折扣+免運)';

-- 適用條件表
CREATE TABLE `coupon_targets` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `coupon_id` INT NOT NULL COMMENT '關聯優惠券',
    `target_type` VARCHAR(50) NOT NULL COMMENT '限制類型：會員等級(member_level) | 產品(product) | 類別(category)',
    `target_value` VARCHAR(255) NOT NULL COMMENT '具體值',
    `is_valid` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '軟刪除標記 (1:有效, 0:已刪除)',
    FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) COMMENT = '限制優惠券可用於特定商品、分類或會員';

-- 自動發送觸發條件設定
CREATE TABLE `coupon_triggers` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `coupon_id` INT NOT NULL COMMENT '關聯優惠券',
    `trigger_type` VARCHAR(50) NOT NULL COMMENT '觸發類型：註冊(register) | 生日(birthday)',
    `trigger_value` VARCHAR(255) COMMENT '條件參數',
    `is_valid` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '軟刪除標記 (1:有效, 0:已刪除)',
    FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) COMMENT = '自動發送觸發條件設定';

-- 發放紀錄表
CREATE TABLE `coupon_sends` (
    `id` INT PRIMARY KEY AUTO_INCREMENT COMMENT '發放給用戶的券的「實例ID」',
    `coupon_id` INT NOT NULL COMMENT '關聯的優惠券種類',
    `user_id` INT NOT NULL COMMENT '接收者用戶 ID',
    `send_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '發送時間',
    `send_method` VARCHAR(50) NOT NULL COMMENT '發送方式：manual | user_enter | auto',
    `status` VARCHAR(20) NOT NULL DEFAULT 'available' COMMENT '實例狀態: available(尚有可用次數), fully_used(已用完所有次數), expired(已過期)',
    `is_valid` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '軟刪除標記 (1:有效, 0:已刪除)',
    UNIQUE INDEX `idx_coupon_sends_coupon_user` (`coupon_id`, `user_id`) COMMENT '確保用戶對同種多用券只持有一個活躍實例 (若適用)',
    FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) COMMENT = '用戶領取的「券的實例」';

-- 使用紀錄表
CREATE TABLE `coupon_usages` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `coupon_send_id` INT NOT NULL COMMENT '關聯的券的實例ID (可重複)',
    `user_id` INT NOT NULL COMMENT '使用者ID',
    `order_id` INT NOT NULL COMMENT '使用的訂單ID',
    `used_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '使用時間',
    `discount_amount_applied` INT COMMENT '訂單上實際折抵的金額 (分 / 或整數的元)',
    `is_valid` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '軟刪除標記 (1:有效, 0:已刪除)',
    FOREIGN KEY (`coupon_send_id`) REFERENCES `coupon_sends` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) COMMENT = '追蹤優惠券的「每一次」使用';
---------------
