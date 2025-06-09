<?php
require_once "./connect.php";
require_once "./Utilities.php";

if (!isset($_POST["name"])) {
    alertGoTo("請從正常管道進入", "./index.php"); // 防止直接訪問此頁面
    exit;
}

$name = $_POST["name"];
$code = empty($_POST["code"]) ? null : $_POST["code"]; // 優惠碼可選，若為空則設為 NULL
$content = $_POST["content"] ?? "";
$status = $_POST["status"] ?? "";
$totalQuantity = $_POST["total_quantity"] ?? "";
$usesPerInstance = $_POST["uses_per_instance"] ?? "";
$startAt = empty($_POST["start_at"]) ? null : $_POST["start_at"]; // 時間可選
$endAt = empty($_POST["end_at"]) ? null : $_POST["end_at"];

// 接收優惠條件欄位
$ruleMinSpend = !empty($_POST["min_spend"]) ? (int) $_POST["min_spend"] : null;
$ruleDiscountType = !empty($_POST["discount_type"]) ? $_POST["discount_type"] : null;
$ruleDiscountValue = (isset($_POST["discount_value"]) && is_numeric($_POST["discount_value"])) ? (int) $_POST["discount_value"] : null;
$ruleMaxDiscountAmount = !empty($_POST["max_discount_amount"]) ? (int) $_POST["max_discount_amount"] : null;
$ruleFreeShipping = isset($_POST["free_shipping"]) ? (int) $_POST["free_shipping"] : 0;

$targetType = !empty($_POST["target_type"]) ? $_POST["target_type"] : null;
$targetValue = !empty($_POST["target_value"]) ? $_POST["target_value"] : null;

if (empty($name)) {
    // 基本欄位驗證
    alertAndBack("請輸入優惠卷名稱");
    exit;
}

if (empty($status)) {
    alertAndBack("請選擇狀態");
    exit;
}
if ($totalQuantity === "" || !is_numeric($totalQuantity) || (int) $totalQuantity < 0) {
    alertAndBack("請設定總發放數，且不能為負數");
    exit;
}
if ($usesPerInstance === "" || !is_numeric($usesPerInstance) || (int) $usesPerInstance < 0) {
    alertAndBack("請設定單張次數，且不能為負數");
    exit;
}

if (empty($ruleDiscountType)) {
    alertAndBack("請選擇折扣類型");
    exit;
}

// 折扣類型與折扣值驗證
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

// 其他可選規則欄位驗證
if ($ruleMinSpend !== null && $ruleMinSpend < 0) {
    alertAndBack("「低消門檻」不能為負數。");
    exit;
}
if ($ruleMaxDiscountAmount !== null && $ruleMaxDiscountAmount < 0) {
    alertAndBack("「最大折扣金額」不能為負數。");
    exit;
}

if (empty($targetType)) {
    alertAndBack("請選擇限制類型");
    exit;
}

if (empty($targetValue)) {
    alertAndBack("請定義次類別所屬");
    exit;
}




// 準備 coupons 資料表 SQL
$sqlCoupon = "INSERT INTO `coupons` (`name`, `code`, `content`, `start_at`, `end_at`, `status`, `total_quantity`, `uses_per_instance`) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$valuesCoupon = [$name, $code, $content, $startAt, $endAt, $status, (int) $totalQuantity, (int) $usesPerInstance];

// 準備 coupon_rules 資料表 SQL (如果提供了折扣類型)
$sqlRule = null;
$baseValuesRule = [];

if (!empty($ruleDiscountType)) {
    $sqlRule = "INSERT INTO `coupon_rules` 
                    (`coupon_id`, `min_spend`, `discount_type`, `discount_value`, `max_discount_amount`, `free_shipping`) 
                VALUES (?, ?, ?, ?, ?, ?)";
    $baseValuesRule = [
        $ruleMinSpend,
        $ruleDiscountType,
        $ruleDiscountValue,
        $ruleMaxDiscountAmount,
        $ruleFreeShipping
    ];
}

$sqlTarget = null;
$baseValuesTarget = [];

if (!empty($targetType)) {
    $sqlTarget = "INSERT INTO `coupon_targets` 
                    (`coupon_id`, `target_type`, `target_value`) 
                VALUES (?, ?, ?)";
    $baseValuesTarget = [
        $targetType,
        $targetValue
    ];
}

$sqlCodeCheck = "SELECT COUNT(*) FROM `coupons` WHERE `code` = ?"; // 檢查優惠碼是否重複

try {
    // 檢查優惠碼是否已存在 (如果提供了優惠碼)
    if ($code !== null) {
        $stmtCode = $pdo->prepare($sqlCodeCheck);
        $stmtCode->execute([$code]);
        $stmtCheckCode = $stmtCode->fetchColumn();
        if ($stmtCheckCode > 0) {
            alertAndBack("錯誤：優惠碼 '$code' 已經存在，請使用不同的優惠碼。");
            exit;
        }
    }
    // 新增優惠卷資料
    $stmtCoupon = $pdo->prepare($sqlCoupon);
    $stmtCoupon->execute($valuesCoupon);

    // 獲取新增優惠卷的 ID
    $couponId = $pdo->lastInsertId();

    // 如果有規則資料且優惠卷新增成功，則新增規則
    if ($sqlRule !== null && $couponId) {
        $valuesRule = array_merge([$couponId], $baseValuesRule);

        $stmtRule = $pdo->prepare($sqlRule);
        $stmtRule->execute($valuesRule);
    }

    if ($sqlTarget !== null && $couponId) {
        $valuesTarget = array_merge([$couponId], $baseValuesTarget);

        $stmtTarget = $pdo->prepare($sqlTarget);
        $stmtTarget->execute($valuesTarget);
    }

    alertGoTo("新增資料成功", "./index.php");

} catch (PDOException $e) {
    alertAndBack("新增資料失敗：" . $e->getMessage());
    exit;
}