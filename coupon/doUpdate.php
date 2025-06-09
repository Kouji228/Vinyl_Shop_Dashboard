<?php
require_once "./connect.php";
require_once "./Utilities.php";

if (!isset($_POST["id"])) {
    alertGoTo("請從正常管道進入", "./index.php");
    exit();
}

$id = $_POST["id"];

// 獲取主要優惠券欄位值
$name = $_POST["name"] ?? null;
$code = empty($_POST["code"]) ? null : $_POST["code"];
$content = $_POST["content"] ?? null;
$status = $_POST["status"] ?? null;
$totalQuantity = $_POST["total_quantity"] ?? null;
$usesPerInstance = $_POST["uses_per_instance"] ?? null;
$startAt = empty($_POST["start_at"]) ? null : $_POST["start_at"]; // 時間可選
$endAt = empty($_POST["end_at"]) ? null : $_POST["end_at"];

$set = [];
$values = [":id" => $id];

// Name
if (isset($_POST["name"])) { // 檢查 'name' 是否在 POST 中提交
    if (empty($name)) { // $name 已在頂部初始化
        alertAndBack("請輸入優惠卷名稱");
        exit;
    }
    $set[] = "`name` = :name";
    $values[":name"] = $name;
}

// Code
if (isset($_POST["code"])) { // 檢查 'code' 是否在 POST 中提交
    $set[] = "`code` = :code";
    $values[":code"] = $code; // $code 已在頂部初始化
}

// Content
if (isset($_POST["content"])) { // 檢查 'content' 是否在 POST 中提交
    $set[] = "`content` = :content";
    $values[":content"] = $content; // $content 已在頂部初始化
}

// Status
if (isset($_POST["status"])) { // 檢查 'status' 是否在 POST 中提交
    if (empty($status)) { // $status 已在頂部初始化
        alertAndBack("請選擇狀態");
        exit;
    }
    $set[] = "`status` = :status";
    $values[":status"] = $status;
}

// Total Quantity
if (isset($_POST["total_quantity"])) { // 檢查 'total_quantity' 是否在 POST 中提交
    if ($totalQuantity === null || $totalQuantity === "" || !is_numeric($totalQuantity) || (int) $totalQuantity < 0) {
        alertAndBack("請設定總發放數，且不能為負數");
        exit;
    }
    $set[] = "`total_quantity` = :total_quantity";
    $values[":total_quantity"] = (int) $totalQuantity;
}

// Uses Per Instance
if (isset($_POST["uses_per_instance"])) { // 檢查 'uses_per_instance' 是否在 POST 中提交
    if ($usesPerInstance === null || $usesPerInstance === "" || !is_numeric($usesPerInstance) || (int) $usesPerInstance < 0) {
        alertAndBack("請設定單張次數，且不能為負數");
        exit;
    }
    $set[] = "`uses_per_instance` = :uses_per_instance";
    $values[":uses_per_instance"] = (int) $usesPerInstance;
}

// Start At
if (isset($_POST["start_at"])) { // 檢查 'start_at' 是否在 POST 中提交
    $set[] = "`start_at` = :start_at";
    $values[":start_at"] = $startAt; // $startAt 已在頂部初始化
}

// End At
if (isset($_POST["end_at"])) { // 檢查 'end_at' 是否在 POST 中提交
    $set[] = "`end_at` = :end_at";
    $values[":end_at"] = $endAt; // $endAt 已在頂部初始化
}

$couponDataChanged = count($set) > 0;

// 從 update.php 接收優惠條件的欄位
$ruleId = $_POST["rule_id"] ?? null; // 來自隱藏欄位
$ruleMinSpend = !empty($_POST["min_spend"]) ? (int) $_POST["min_spend"] : null;
$ruleDiscountType = !empty($_POST["discount_type"]) ? $_POST["discount_type"] : null;
$ruleDiscountValue = (isset($_POST["discount_value"]) && is_numeric($_POST["discount_value"])) ? (int) $_POST["discount_value"] : null;
$ruleMaxDiscountAmount = !empty($_POST["max_discount_amount"]) ? (int) $_POST["max_discount_amount"] : null;
$ruleFreeShipping = isset($_POST["free_shipping"]) ? (int) $_POST["free_shipping"] : 0;

$sqlRule = null;
$paramsRule = [];

// 處理規則：驗證並準備 SQL
if (!empty($ruleDiscountType)) {
    if (!isset($_POST["discount_value"]) || $_POST["discount_value"] === '' || !is_numeric($_POST["discount_value"])) {
        alertAndBack("請填寫折扣值欄位。");
        exit;
    }

    if ($ruleDiscountType === 'percent') {
        if ($ruleDiscountValue < 0 || $ruleDiscountValue > 100) {
            alertAndBack("「折扣類型」為百分比，折扣值須為 0 到 100 之間。");
            exit;
        }
    } elseif ($ruleDiscountType === 'fixed') {
        if ($ruleDiscountValue < 0) {
            alertAndBack("「折扣類型」為固定金額，折扣值不能為負數。");
            exit;
        }
    }
} elseif (isset($_POST["discount_value"]) && $_POST["discount_value"] !== '' && $_POST["discount_value"] !== null) {
    alertAndBack("請選擇折扣類型後再填寫折扣值。");
    exit;
}

// 其他可選規則欄位驗證
if ($ruleMinSpend !== null && $ruleMinSpend < 0) {
    alertAndBack("「低消門檻」不能為負數。");
    exit;
}
if ($ruleMaxDiscountAmount !== null && $ruleMaxDiscountAmount < 0) {
    alertAndBack("「最大折扣金額」不能為負數。");
    exit;
}

// 準備 coupon_rules 的 SQL
if (!empty($ruleId)) { // 更新現有規則
    if (!empty($ruleDiscountType)) { // 有折扣類型，表示更新
        $sqlRule = "UPDATE `coupon_rules` SET 
                            `min_spend` = ?, `discount_type` = ?, `discount_value` = ?, 
                            `max_discount_amount` = ?, `free_shipping` = ? 
                        WHERE `id` = ? AND `coupon_id` = ?";
        $paramsRule = [
            $ruleMinSpend,
            $ruleDiscountType,
            $ruleDiscountValue,
            $ruleMaxDiscountAmount,
            $ruleFreeShipping,
            $ruleId,
            $id
        ];
    } else { // 沒有折扣類型，但有 ruleId，表示刪除
        $sqlRule = "DELETE FROM `coupon_rules` WHERE `id` = ? AND `coupon_id` = ?";
        $paramsRule = [$ruleId, $id];
    }
} elseif (!empty($ruleDiscountType)) { // 新增規則 (沒有 ruleId 但有 discount_type)
    $sqlRule = "INSERT INTO `coupon_rules` 
                            (`coupon_id`, `min_spend`, `discount_type`, `discount_value`, `max_discount_amount`, `free_shipping`) 
                        VALUES (?, ?, ?, ?, ?, ?)";
    $paramsRule = [$id, $ruleMinSpend, $ruleDiscountType, $ruleDiscountValue, $ruleMaxDiscountAmount, $ruleFreeShipping];
}

try {
    $pdo->beginTransaction();

    // 檢查優惠碼是否被其他優惠卷使用 (如果提供了優惠碼)
    if ($code !== null) {
        $sqlCode = "SELECT COUNT(*) FROM `coupons` WHERE `code` = :code AND `id` != :id";
        $stmtCode = $pdo->prepare($sqlCode);
        $stmtCode->execute([':code' => $code, ':id' => $id]);
        $stmtCheckCode = $stmtCode->fetchColumn();
        if ($stmtCheckCode > 0) {
            $pdo->rollBack();
            alertAndBack("錯誤：優惠碼 '$code' 已經存在，請使用不同的優惠碼。");
            exit;
        }
    }

    // 更新 coupons 表
    if ($couponDataChanged) {
        $sqlCoupon = "UPDATE `coupons` SET " . implode(", ", $set) . " WHERE `id` = :id";
        $stmtCoupon = $pdo->prepare($sqlCoupon);
        $stmtCoupon->execute($values);
    }

    // 處理 coupon_rules (更新、新增或刪除)
    if ($sqlRule !== null) {
        $stmtRule = $pdo->prepare($sqlRule);
        $stmtRule->execute($paramsRule);
    }

    $pdo->commit();
    alertGoTo("修改資料成功", "./update.php?id={$id}");

} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    alertAndBack("修改資料失敗：" . $e->getMessage());
    exit;
}